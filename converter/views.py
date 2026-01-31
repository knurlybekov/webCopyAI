"""
Django views for the Joomla Template Converter web interface.
"""

import logging
import re
import shutil
import tempfile
import uuid
from pathlib import Path

from django.conf import settings
from django.http import FileResponse, JsonResponse
from django.shortcuts import render
from django.views.decorators.csrf import csrf_exempt
from django.views.decorators.http import require_http_methods

# Import our converter module
import sys
sys.path.insert(0, str(settings.BASE_DIR))
from convert import JoomlaConverter, download_website, extract_zip_input

logger = logging.getLogger(__name__)


def index(request):
    """Render the main page with the upload form."""
    return render(request, 'converter/index.html')


def json_error(message, status=500):
    """Helper to return JSON error response."""
    return JsonResponse({'success': False, 'error': str(message)}, status=status)


@csrf_exempt
@require_http_methods(["POST"])
def convert(request):
    """Handle conversion request - either URL or file upload."""
    temp_dir = None
    session_dir = None

    try:
        # Get the template name (optional)
        template_name = request.POST.get('template_name', '').strip()
        if not template_name:
            template_name = 'joomla_template'

        # Sanitize template name
        template_name = re.sub(r'[^a-zA-Z0-9_]', '_', template_name).lower()
        if not template_name:
            template_name = 'joomla_template'

        # Create unique session directory
        session_id = str(uuid.uuid4())
        session_dir = Path(settings.MEDIA_ROOT) / 'sessions' / session_id
        session_dir.mkdir(parents=True, exist_ok=True)

        input_path = None

        # Check if URL provided
        url = request.POST.get('url', '').strip()

        if url:
            # Download from URL
            if not url.startswith(('http://', 'https://')):
                url = 'https://' + url

            try:
                temp_dir = tempfile.mkdtemp(prefix='joomla_web_')
                input_path = download_website(url, Path(temp_dir) / 'downloaded')
            except Exception as e:
                logger.exception(f"Failed to download website: {url}")
                return json_error(f"Failed to download website: {e}", 400)

        elif request.FILES:
            # Handle file upload
            uploaded_file = request.FILES.get('file')

            if not uploaded_file:
                return json_error('No file uploaded', 400)

            try:
                temp_dir = tempfile.mkdtemp(prefix='joomla_web_')

                # Save the uploaded file
                upload_path = Path(temp_dir) / uploaded_file.name
                with open(upload_path, 'wb') as f:
                    for chunk in uploaded_file.chunks():
                        f.write(chunk)

                # Handle based on file type
                if uploaded_file.name.lower().endswith('.zip'):
                    input_path = extract_zip_input(str(upload_path), str(Path(temp_dir) / 'extracted'))
                elif uploaded_file.name.lower().endswith(('.html', '.htm')):
                    # Single HTML file - create a directory structure
                    html_dir = Path(temp_dir) / 'html_input'
                    html_dir.mkdir()
                    shutil.copy(upload_path, html_dir / 'index.html')
                    input_path = html_dir
                else:
                    return json_error('Unsupported file type. Please upload a ZIP or HTML file.', 400)
            except Exception as e:
                logger.exception("Failed to process uploaded file")
                return json_error(f"Failed to process file: {e}", 400)
        else:
            return json_error('Please provide a URL or upload a file.', 400)

        # Output directory
        output_dir = session_dir / template_name

        # Run the converter
        try:
            converter = JoomlaConverter(input_path, output_dir, template_name)
            success = converter.convert()
        except Exception as e:
            logger.exception("Conversion failed")
            return json_error(f"Conversion error: {e}")

        if not success:
            return json_error('Conversion failed - could not find HTML file in input')

        # The ZIP is created in the parent directory of output_dir
        zip_path = session_dir / f'{template_name}.zip'

        if not zip_path.exists():
            return json_error('ZIP file not generated')

        # Return success with download info
        return JsonResponse({
            'success': True,
            'session_id': session_id,
            'template_name': template_name,
            'positions': converter.positions,
            'download_url': f'/download/{session_id}/{template_name}.zip'
        })

    except Exception as e:
        logger.exception("Unexpected error in convert view")
        # Clean up session dir on error
        if session_dir and session_dir.exists():
            shutil.rmtree(session_dir, ignore_errors=True)
        return json_error(f"Unexpected error: {e}")

    finally:
        # Clean up temp directory
        if temp_dir:
            shutil.rmtree(temp_dir, ignore_errors=True)


def download(request, session_id, filename):
    """Serve the generated ZIP file for download."""
    # Validate session_id format (UUID)
    try:
        uuid.UUID(session_id)
    except ValueError:
        return JsonResponse({'error': 'Invalid session'}, status=400)

    file_path = Path(settings.MEDIA_ROOT) / 'sessions' / session_id / filename

    if not file_path.exists() or not file_path.is_file():
        return JsonResponse({'error': 'File not found'}, status=404)

    # Security: ensure path is within sessions directory
    try:
        file_path.resolve().relative_to((Path(settings.MEDIA_ROOT) / 'sessions').resolve())
    except ValueError:
        return JsonResponse({'error': 'Invalid path'}, status=400)

    response = FileResponse(
        open(file_path, 'rb'),
        as_attachment=True,
        filename=filename
    )
    return response


def preview(request, session_id):
    """Preview the generated index.php content."""
    try:
        uuid.UUID(session_id)
    except ValueError:
        return JsonResponse({'error': 'Invalid session'}, status=400)

    session_dir = Path(settings.MEDIA_ROOT) / 'sessions' / session_id

    # Find the template directory
    template_dirs = [d for d in session_dir.iterdir() if d.is_dir()]
    if not template_dirs:
        return JsonResponse({'error': 'Template not found'}, status=404)

    template_dir = template_dirs[0]
    index_php = template_dir / 'index.php'

    if not index_php.exists():
        return JsonResponse({'error': 'index.php not found'}, status=404)

    content = index_php.read_text(encoding='utf-8')

    return JsonResponse({
        'filename': 'index.php',
        'content': content
    })
