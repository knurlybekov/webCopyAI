#!/usr/bin/env python3
"""
Joomla 4 Template Converter
============================
Converts a static HTML/CSS/JS website template into an installable Joomla 4 template.

Input:  folder, ZIP archive, or URL of a static site.
Output: Joomla template directory + installable ZIP.

Usage:
    python convert.py input_folder/ output_template/
    python convert.py template.zip output_template/
    python convert.py --url https://example.com output_template/
    python convert.py input_folder/ output_template/ --name my_template

No cloud APIs. Fully deterministic DOM-based logic.
"""

import argparse
import os
import re
import shutil
import sys
import tempfile
import zipfile
from datetime import datetime
from pathlib import Path
from urllib.parse import urljoin, urlparse

from bs4 import BeautifulSoup, Tag

# ---------------------------------------------------------------------------
# Placeholder tokens
# ---------------------------------------------------------------------------
# BeautifulSoup HTML-encodes PHP tags placed inside attribute values.
# We use plain-text placeholders during DOM manipulation, then replace
# them with real PHP code after serialising to string.
# ---------------------------------------------------------------------------

_TPL_BASE = "__JOOMLA_TPL_BASE__"   # <?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>
_PHP_LANG = "__JOOMLA_LANG__"       # <?php echo $this->language; ?>
_PHP_DIR  = "__JOOMLA_DIR__"        # <?php echo $this->direction; ?>

_PLACEHOLDER_MAP = {
    _TPL_BASE: "<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>",
    _PHP_LANG: "<?php echo $this->language; ?>",
    _PHP_DIR:  "<?php echo $this->direction; ?>",
}

# ---------------------------------------------------------------------------
# Section detection heuristics
# ---------------------------------------------------------------------------

SECTION_HEURISTICS = {
    "menu": {
        "tags": ["nav"],
        "classes": [
            "navbar", "nav", "navigation", "main-nav", "top-nav",
            "site-nav", "primary-nav", "nav-wrapper", "menu",
        ],
        "ids": [
            "navbar", "nav", "navigation", "main-nav", "top-nav",
            "site-nav", "primary-nav", "menu",
        ],
    },
    "header": {
        "tags": ["header"],
        "classes": [
            "header", "site-header", "page-header", "top-header",
            "masthead", "head-wrapper",
        ],
        "ids": [
            "header", "site-header", "page-header", "masthead",
        ],
    },
    "slider": {
        "tags": [],
        "classes": [
            "slider", "carousel", "hero", "hero-section", "hero-banner",
            "banner", "slideshow", "swiper", "owl-carousel",
            "slick-slider", "hero-area", "hero-wrap",
        ],
        "ids": [
            "slider", "carousel", "hero", "hero-section", "banner",
            "slideshow",
        ],
    },
    "sidebar": {
        "tags": ["aside"],
        "classes": [
            "sidebar", "side-bar", "widget-area", "aside",
            "left-sidebar", "right-sidebar",
        ],
        "ids": [
            "sidebar", "side-bar", "widget-area",
        ],
    },
    "footer": {
        "tags": ["footer"],
        "classes": [
            "footer", "site-footer", "page-footer", "bottom",
            "footer-area", "footer-wrapper",
        ],
        "ids": [
            "footer", "site-footer", "page-footer",
        ],
    },
    "component": {
        "tags": ["main"],
        "classes": [
            "content", "main-content", "page-content", "site-content",
            "main", "main-wrapper", "content-area", "content-wrapper",
        ],
        "ids": [
            "content", "main-content", "page-content", "site-content",
            "main",
        ],
    },
}

# Order matters: detect specific positions before the broad "component".
DETECTION_ORDER = ["menu", "slider", "sidebar", "footer", "header", "component"]

# Asset directory names we copy from source to output.
ASSET_DIRS = ["css", "js", "images", "img", "fonts", "webfonts", "assets", "vendor"]

# Loose file globs to copy from root of input.
LOOSE_ASSET_GLOBS = ["*.ico", "*.png", "*.svg", "*.jpg", "*.webp", "*.webmanifest"]


# ===========================================================================
# Section Detector
# ===========================================================================

class SectionDetector:
    """Detects layout sections in an HTML document using heuristic rules."""

    def __init__(self, soup: BeautifulSoup):
        self.soup = soup
        self.detected: dict[str, Tag] = {}
        self._claimed: set[int] = set()

    def detect_all(self) -> dict[str, Tag]:
        """Return mapping of position_name -> BeautifulSoup Tag."""
        for position in DETECTION_ORDER:
            rules = SECTION_HEURISTICS[position]
            element = self._find_section(rules)
            if element is not None and id(element) not in self._claimed:
                self.detected[position] = element
                self._claimed.add(id(element))

        if "component" not in self.detected:
            self._detect_main_content_fallback()

        return self.detected

    def _find_section(self, rules: dict) -> Tag | None:
        for tag in rules["tags"]:
            for el in self.soup.find_all(tag):
                if id(el) not in self._claimed:
                    return el

        for cls in rules["classes"]:
            pattern = re.compile(r"\b" + re.escape(cls) + r"\b", re.I)
            el = self.soup.find(class_=pattern)
            if el and id(el) not in self._claimed:
                return el

        for id_val in rules["ids"]:
            el = self.soup.find(id=re.compile(r"^" + re.escape(id_val) + r"$", re.I))
            if el and id(el) not in self._claimed:
                return el

        return None

    def _detect_main_content_fallback(self):
        """Pick the largest unclaimed container by text length."""
        body = self.soup.find("body")
        if not body:
            return

        candidates = body.find_all(["div", "section", "article"])
        best, best_size = None, 0

        for el in candidates:
            if id(el) in self._claimed:
                continue
            if any(el in det.descendants for det in self.detected.values()):
                continue
            text_len = len(el.get_text(strip=True))
            if text_len > best_size:
                best_size = text_len
                best = el

        if best:
            self.detected["component"] = best
            self._claimed.add(id(best))


# ===========================================================================
# Joomla Converter
# ===========================================================================

class JoomlaConverter:
    """Orchestrates the full static-to-Joomla conversion pipeline."""

    def __init__(self, input_path: Path, output_path: Path, template_name: str | None = None):
        self.input_path = Path(input_path)
        self.output_path = Path(output_path)
        raw_name = template_name or self.output_path.name or "custom_template"
        self.template_name = re.sub(r"[^a-zA-Z0-9_]", "_", raw_name).lower()
        self.positions: list[str] = []
        self.css_files: list[str] = []
        self.js_files: list[str] = []

    # ------------------------------------------------------------------
    # Public API
    # ------------------------------------------------------------------
    def convert(self) -> bool:
        html_content = self._read_source_html()
        if not html_content:
            print("ERROR: Could not find index.html (or any .html) in input directory.")
            return False

        # First parse: detect sections (for reporting).
        soup_report = BeautifulSoup(html_content, "html.parser")
        sections_report = SectionDetector(soup_report).detect_all()
        print(f"Detected sections: {list(sections_report.keys())}")

        # Build output tree and copy assets.
        self._create_output_dirs()
        self._copy_assets()
        self._collect_asset_lists()

        # Second parse: clean copy for mutation.
        soup = BeautifulSoup(html_content, "html.parser")
        sections = SectionDetector(soup).detect_all()

        index_php = self._generate_index_php(soup, sections)

        self._write("index.php", index_php)
        self._write("templateDetails.xml", self._generate_template_details())
        self._write("error.php", self._generate_error_php())
        self._write("component.php", self._generate_component_php())

        zip_path = self._create_zip()

        print(f"\nConversion complete!")
        print(f"  Template folder : {self.output_path}")
        print(f"  Installable ZIP : {zip_path}")
        print(f"  Module positions: {', '.join(self.positions)}")
        return True

    # ------------------------------------------------------------------
    # Input handling
    # ------------------------------------------------------------------
    def _read_source_html(self) -> str | None:
        index = self.input_path / "index.html"
        if index.exists():
            return index.read_text(encoding="utf-8", errors="replace")
        for f in self.input_path.glob("*.html"):
            return f.read_text(encoding="utf-8", errors="replace")
        return None

    # ------------------------------------------------------------------
    # Output structure & assets
    # ------------------------------------------------------------------
    def _create_output_dirs(self):
        self.output_path.mkdir(parents=True, exist_ok=True)
        for d in ("css", "js", "images"):
            (self.output_path / d).mkdir(exist_ok=True)

    def _copy_assets(self):
        for d in ASSET_DIRS:
            src = self.input_path / d
            if src.exists() and src.is_dir():
                dst = self.output_path / d
                if dst.exists():
                    shutil.rmtree(dst)
                shutil.copytree(src, dst)
                print(f"  Copied: {d}/")
        for pattern in LOOSE_ASSET_GLOBS:
            for f in self.input_path.glob(pattern):
                shutil.copy2(f, self.output_path / f.name)

    def _collect_asset_lists(self):
        css_dir = self.output_path / "css"
        if css_dir.exists():
            self.css_files = sorted(
                f"css/{f.name}" for f in css_dir.iterdir() if f.suffix == ".css"
            )
        js_dir = self.output_path / "js"
        if js_dir.exists():
            self.js_files = sorted(
                f"js/{f.name}" for f in js_dir.iterdir() if f.suffix == ".js"
            )

    # ------------------------------------------------------------------
    # index.php generation
    # ------------------------------------------------------------------
    def _generate_index_php(self, soup: BeautifulSoup, sections: dict) -> str:
        self._process_head(soup)
        self._process_html_tag(soup)
        self._process_sections(soup, sections)
        self._rewrite_asset_paths(soup)
        return self._build_php_string(soup)

    def _process_html_tag(self, soup: BeautifulSoup):
        """Replace the <html> lang/dir with Joomla PHP placeholders."""
        html_tag = soup.find("html")
        if html_tag:
            html_tag["lang"] = _PHP_LANG
            html_tag["dir"] = _PHP_DIR

    def _process_head(self, soup: BeautifulSoup):
        head = soup.find("head")
        if not head:
            return

        # Joomla manages <title> and charset <meta>.
        title = head.find("title")
        if title:
            title.decompose()
        for meta in head.find_all("meta"):
            if meta.get("charset") or (
                meta.get("http-equiv", "").lower() == "content-type"
            ):
                meta.decompose()

        # Insert <jdoc:include type="head" /> after remaining <meta> tags.
        jdoc_head = soup.new_tag("jdoc:include")
        jdoc_head["type"] = "head"

        last_meta = None
        for meta in head.find_all("meta"):
            last_meta = meta
        if last_meta:
            last_meta.insert_after(jdoc_head)
        else:
            head.insert(0, jdoc_head)

    def _process_sections(self, soup: BeautifulSoup, sections: dict):
        """Inject <jdoc:include> directives for every detected section.

        Handles arbitrary nesting:
        - <header> containing <nav>  (header wraps menu)
        - <main> containing <aside>  (component wraps sidebar)
        Nested children are processed first (leaves → roots), and parent
        sections preserve already-processed children rather than wiping them.
        """
        # --- Build parent / children maps ----------------------------------
        parent_of: dict[str, str] = {}      # child_pos -> immediate parent_pos
        children_of: dict[str, list[str]] = {}  # parent_pos -> [child_pos, …]

        for pos_child, el_child in sections.items():
            closest_parent: str | None = None
            closest_el: Tag | None = None
            for pos_parent, el_parent in sections.items():
                if pos_child == pos_parent:
                    continue
                if not _is_descendant(el_child, el_parent):
                    continue
                # Is this a closer (more deeply-nested) ancestor?
                if closest_el is None or _is_descendant(el_parent, closest_el):
                    closest_parent = pos_parent
                    closest_el = el_parent
            if closest_parent:
                parent_of[pos_child] = closest_parent
                children_of.setdefault(closest_parent, []).append(pos_child)

        # --- Recursive processor (leaves first) ----------------------------
        processed: set[str] = set()

        def _process(pos: str):
            if pos in processed:
                return
            # Recurse into children first so they are already converted.
            for child_pos in children_of.get(pos, []):
                _process(child_pos)

            element = sections[pos]
            child_positions = {
                cp: sections[cp] for cp in children_of.get(pos, [])
            }

            if pos == "component":
                self._inject_component(soup, element, child_positions)
            elif child_positions:
                self._inject_parent_with_children(soup, element, pos, child_positions)
            else:
                self._inject_module_position(soup, element, pos)

            self.positions.append(pos)
            processed.add(pos)

        for pos in sections:
            _process(pos)

    # ------------------------------------------------------------------
    # Section injection helpers
    # ------------------------------------------------------------------

    def _inject_module_position(self, soup: BeautifulSoup, element: Tag, position: str):
        """Leaf section: replace children with <jdoc:include type="modules">."""
        jdoc = soup.new_tag("jdoc:include")
        jdoc["type"] = "modules"
        jdoc["name"] = position
        jdoc["style"] = "xhtml"
        element.clear()
        element.append(jdoc)

    def _inject_parent_with_children(self, soup: BeautifulSoup, element: Tag,
                                     position: str, children: dict[str, Tag]):
        """Parent section that wraps other detected sections (e.g. <header>
        containing <nav>).  Extract the already-processed children, clear the
        parent, insert the parent's own module position, then re-attach the
        children so both positions appear in the output.
        """
        # Pull nested elements out of the tree temporarily.
        extracted: list[Tag] = []
        for _cp, child_el in children.items():
            child_el.extract()
            extracted.append(child_el)

        # Clear the parent's remaining content and add its module position.
        element.clear()
        jdoc = soup.new_tag("jdoc:include")
        jdoc["type"] = "modules"
        jdoc["name"] = position
        jdoc["style"] = "xhtml"
        element.append(jdoc)
        element.append("\n")

        # Re-attach each child section.
        for child_el in extracted:
            element.append(child_el)
            element.append("\n")

    def _inject_component(self, soup: BeautifulSoup, element: Tag,
                          children: dict[str, Tag]):
        """Component section — may contain nested module positions (e.g.
        sidebar).  When children exist, find the largest content column that
        does *not* contain a child position and replace it with the
        component include; otherwise clear and insert.
        """
        if not children:
            element.clear()
            jdoc_msg = soup.new_tag("jdoc:include")
            jdoc_msg["type"] = "message"
            jdoc_comp = soup.new_tag("jdoc:include")
            jdoc_comp["type"] = "component"
            element.append(jdoc_msg)
            element.append("\n")
            element.append(jdoc_comp)
            return

        nested_ids = set(id(el) for el in children.values())

        def _touches_nested(tag: Tag) -> bool:
            if id(tag) in nested_ids:
                return True
            return any(
                isinstance(d, Tag) and id(d) in nested_ids
                for d in tag.descendants
            )

        best, best_size = None, 0
        for desc in element.descendants:
            if not isinstance(desc, Tag):
                continue
            if id(desc) in nested_ids or _touches_nested(desc):
                continue
            tlen = len(desc.get_text(strip=True))
            if tlen > best_size:
                best_size = tlen
                best = desc

        if best:
            best.clear()
            jdoc_msg = soup.new_tag("jdoc:include")
            jdoc_msg["type"] = "message"
            jdoc_comp = soup.new_tag("jdoc:include")
            jdoc_comp["type"] = "component"
            best.append(jdoc_msg)
            best.append("\n")
            best.append(jdoc_comp)
        else:
            # Fallback: prepend at the top of the component area.
            jdoc_msg = soup.new_tag("jdoc:include")
            jdoc_msg["type"] = "message"
            jdoc_comp = soup.new_tag("jdoc:include")
            jdoc_comp["type"] = "component"
            element.insert(0, jdoc_comp)
            element.insert(0, "\n")
            element.insert(0, jdoc_msg)

    def _rewrite_asset_paths(self, soup: BeautifulSoup):
        """Convert relative asset paths to Joomla PHP template paths.

        Uses a placeholder token that won't be HTML-encoded by BeautifulSoup.
        """
        tpl = _TPL_BASE

        # CSS <link rel="stylesheet">
        for link in soup.find_all("link", rel="stylesheet"):
            href = link.get("href", "")
            if href and not self._is_absolute_url(href):
                link["href"] = f"{tpl}/{href.lstrip('./')}"

        # JS <script src="">
        for script in soup.find_all("script", src=True):
            src = script.get("src", "")
            if src and not self._is_absolute_url(src):
                script["src"] = f"{tpl}/{src.lstrip('./')}"

        # Images <img src="">
        for img in soup.find_all("img"):
            src = img.get("src", "")
            if src and not self._is_absolute_url(src) and not src.startswith("data:"):
                img["src"] = f"{tpl}/{src.lstrip('./')}"

        # Background images in inline style="" attributes.
        for el in soup.find_all(style=True):
            style = el["style"]
            el["style"] = re.sub(
                r"""url\(\s*['"]?(?!(?:https?://|//|/|data:))([^'")]+)['"]?\s*\)""",
                lambda m: f'url("{tpl}/{m.group(1).lstrip("./")}")',
                style,
            )

        # Favicon / icon links
        for link in soup.find_all("link", rel=re.compile(r"icon", re.I)):
            href = link.get("href", "")
            if href and not self._is_absolute_url(href):
                link["href"] = f"{tpl}/{href.lstrip('./')}"

    @staticmethod
    def _is_absolute_url(url: str) -> bool:
        """Absolute = protocol-based, protocol-relative, server-absolute, or
        already rewritten to a template placeholder."""
        return url.startswith(("http://", "https://", "//", "/", _TPL_BASE))

    def _build_php_string(self, soup: BeautifulSoup) -> str:
        raw = str(soup)

        # --- Replace placeholder tokens with real PHP code -----------------
        for token, php in _PLACEHOLDER_MAP.items():
            raw = raw.replace(token, php)

        # --- Fix jdoc tags -------------------------------------------------
        # BeautifulSoup may render <jdoc:include ...></jdoc:include> or mangle
        # spacing.  Normalise to self-closing  <jdoc:include ... />.
        raw = re.sub(
            r"<jdoc:include\s+([^>]*?)>\s*</jdoc:include>",
            r"<jdoc:include \1 />",
            raw,
        )
        raw = re.sub(
            r"<jdoc:include\s+(.*?)/\s*>",
            lambda m: "<jdoc:include " + " ".join(m.group(1).split()) + " />",
            raw,
        )

        # Ensure DOCTYPE
        if "<!doctype" not in raw[:50].lower():
            raw = "<!DOCTYPE html>\n" + raw

        year = datetime.now().year
        php_header = (
            "<?php\n"
            "/**\n"
            " * @package     Joomla.Site\n"
            f" * @subpackage  Templates.{self.template_name}\n"
            f" * @copyright   Copyright (C) {year}. All rights reserved.\n"
            " * @license     GNU General Public License version 2 or later\n"
            " */\n"
            "\n"
            "defined('_JEXEC') or die;\n"
            "\n"
            "use Joomla\\CMS\\HTML\\HTMLHelper;\n"
            "\n"
            "/** @var Joomla\\CMS\\Document\\HtmlDocument $this */\n"
            "\n"
            "// Load Bootstrap framework (optional – remove if not needed)\n"
            "HTMLHelper::_('bootstrap.framework');\n"
            "?>\n"
        )

        return php_header + raw

    # ------------------------------------------------------------------
    # templateDetails.xml
    # ------------------------------------------------------------------
    def _generate_template_details(self) -> str:
        positions_xml = "\n".join(
            f"        <position>{p}</position>" for p in sorted(set(self.positions))
        )

        files_entries = []
        for php in ("index.php", "error.php", "component.php"):
            files_entries.append(f"        <filename>{php}</filename>")
        for folder in ASSET_DIRS:
            if (self.output_path / folder).exists():
                files_entries.append(f"        <folder>{folder}</folder>")
        files_xml = "\n".join(files_entries)

        year = datetime.now().year
        date = datetime.now().strftime("%Y-%m-%d")

        return (
            '<?xml version="1.0" encoding="utf-8"?>\n'
            '<extension type="template" client="site" method="upgrade">\n'
            f"    <name>{self.template_name}</name>\n"
            "    <version>1.0.0</version>\n"
            f"    <creationDate>{date}</creationDate>\n"
            "    <author>Template Converter</author>\n"
            "    <authorEmail>info@example.com</authorEmail>\n"
            "    <authorUrl>https://example.com</authorUrl>\n"
            f"    <copyright>Copyright (C) {year}. All rights reserved.</copyright>\n"
            "    <license>GNU General Public License version 2 or later</license>\n"
            f"    <description>Converted template: {self.template_name}</description>\n"
            "    <inheritable>1</inheritable>\n"
            "\n"
            "    <files>\n"
            f"{files_xml}\n"
            "    </files>\n"
            "\n"
            "    <positions>\n"
            f"{positions_xml}\n"
            "    </positions>\n"
            "</extension>\n"
        )

    # ------------------------------------------------------------------
    # error.php
    # ------------------------------------------------------------------
    def _generate_error_php(self) -> str:
        year = datetime.now().year
        tpl = "<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>"

        css_link = ""
        if self.css_files:
            css_link = (
                f'    <link rel="stylesheet" href="{tpl}/{self.css_files[0]}">\n'
            )

        return (
            "<?php\n"
            "/**\n"
            " * @package     Joomla.Site\n"
            f" * @subpackage  Templates.{self.template_name}\n"
            f" * @copyright   Copyright (C) {year}. All rights reserved.\n"
            " * @license     GNU General Public License version 2 or later\n"
            " */\n"
            "\n"
            "defined('_JEXEC') or die;\n"
            "\n"
            "use Joomla\\CMS\\Language\\Text;\n"
            "\n"
            "/** @var Joomla\\CMS\\Document\\ErrorDocument $this */\n"
            "\n"
            "$errorCode    = $this->error->getCode();\n"
            "$errorMessage = $this->error->getMessage();\n"
            "?>\n"
            "<!DOCTYPE html>\n"
            '<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">\n'
            "<head>\n"
            '    <meta charset="utf-8">\n'
            '    <meta name="viewport" content="width=device-width, initial-scale=1">\n'
            "    <title><?php echo $errorCode; ?> - <?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></title>\n"
            f"{css_link}"
            "    <style>\n"
            "        body {\n"
            "            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;\n"
            "            margin: 0; padding: 0;\n"
            "            display: flex; justify-content: center; align-items: center;\n"
            "            min-height: 100vh; background: #f5f5f5; color: #333;\n"
            "        }\n"
            "        .error-container { text-align: center; padding: 2rem; max-width: 600px; }\n"
            "        .error-code { font-size: 6rem; font-weight: 700; color: #e74c3c; margin: 0; line-height: 1; }\n"
            "        .error-message { font-size: 1.5rem; margin: 1rem 0; }\n"
            "        .error-link {\n"
            "            display: inline-block; margin-top: 1.5rem; padding: 0.75rem 2rem;\n"
            "            background: #3498db; color: #fff; text-decoration: none;\n"
            "            border-radius: 4px; transition: background 0.3s;\n"
            "        }\n"
            "        .error-link:hover { background: #2980b9; }\n"
            "    </style>\n"
            "</head>\n"
            "<body>\n"
            '    <div class="error-container">\n'
            '        <h1 class="error-code"><?php echo $errorCode; ?></h1>\n'
            "        <p class=\"error-message\"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></p>\n"
            '        <a href="<?php echo $this->baseurl; ?>/index.php" class="error-link">\n'
            "            <?php echo Text::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?>\n"
            "        </a>\n"
            "    </div>\n"
            "</body>\n"
            "</html>\n"
        )

    # ------------------------------------------------------------------
    # component.php
    # ------------------------------------------------------------------
    def _generate_component_php(self) -> str:
        year = datetime.now().year
        return (
            "<?php\n"
            "/**\n"
            " * @package     Joomla.Site\n"
            f" * @subpackage  Templates.{self.template_name}\n"
            f" * @copyright   Copyright (C) {year}. All rights reserved.\n"
            " * @license     GNU General Public License version 2 or later\n"
            " */\n"
            "\n"
            "defined('_JEXEC') or die;\n"
            "\n"
            "use Joomla\\CMS\\HTML\\HTMLHelper;\n"
            "\n"
            "/** @var Joomla\\CMS\\Document\\HtmlDocument $this */\n"
            "?>\n"
            "<!DOCTYPE html>\n"
            '<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">\n'
            "<head>\n"
            '    <jdoc:include type="head" />\n'
            "</head>\n"
            '<body class="contentpane">\n'
            '    <jdoc:include type="message" />\n'
            '    <jdoc:include type="component" />\n'
            "</body>\n"
            "</html>\n"
        )

    # ------------------------------------------------------------------
    # File helpers
    # ------------------------------------------------------------------
    def _write(self, filename: str, content: str):
        path = self.output_path / filename
        path.write_text(content, encoding="utf-8")
        print(f"  Generated: {filename}")

    def _create_zip(self) -> Path:
        zip_path = self.output_path.parent / f"{self.template_name}.zip"
        with zipfile.ZipFile(zip_path, "w", zipfile.ZIP_DEFLATED) as zf:
            for root, _dirs, files in os.walk(self.output_path):
                for fname in files:
                    full = Path(root) / fname
                    arcname = full.relative_to(self.output_path)
                    zf.write(full, arcname)
        return zip_path


# ===========================================================================
# Utility
# ===========================================================================

def _is_descendant(child: Tag, parent: Tag) -> bool:
    """Check if *child* is a descendant of *parent* (not equal)."""
    node = child.parent
    while node is not None:
        if node is parent:
            return True
        node = getattr(node, "parent", None)
    return False


# ===========================================================================
# Website downloader (--url mode)
# ===========================================================================

def download_website(url: str, output_dir: Path) -> Path:
    """Download a page's HTML and referenced CSS / JS / images."""
    try:
        import requests
    except ImportError:
        print("ERROR: 'requests' package is required for --url mode.")
        print("       Install it with:  pip install requests")
        sys.exit(1)

    output_dir = Path(output_dir)
    output_dir.mkdir(parents=True, exist_ok=True)

    print(f"Downloading: {url}")
    headers = {
        "User-Agent": (
            "Mozilla/5.0 (Windows NT 10.0; Win64; x64) "
            "AppleWebKit/537.36 (KHTML, like Gecko) "
            "Chrome/120.0.0.0 Safari/537.36"
        )
    }

    resp = requests.get(url, headers=headers, timeout=30)
    resp.raise_for_status()

    soup = BeautifulSoup(resp.text, "html.parser")
    base_url = url.rstrip("/")

    # --- CSS ---
    css_dir = output_dir / "css"
    css_dir.mkdir(exist_ok=True)
    css_counter = 0
    for link in soup.find_all("link", rel="stylesheet"):
        href = link.get("href", "")
        if not href:
            continue
        asset_url = urljoin(base_url + "/", href)
        filename = Path(urlparse(href).path).name or f"style_{css_counter}.css"
        css_counter += 1
        try:
            r = requests.get(asset_url, headers=headers, timeout=15)
            (css_dir / filename).write_bytes(r.content)
            link["href"] = f"css/{filename}"
            print(f"  Downloaded CSS: {filename}")
        except Exception as exc:
            print(f"  Warning: CSS download failed ({asset_url}): {exc}")

    # --- JS ---
    js_dir = output_dir / "js"
    js_dir.mkdir(exist_ok=True)
    js_counter = 0
    for script in soup.find_all("script", src=True):
        src = script.get("src", "")
        if not src:
            continue
        if src.startswith("//"):
            asset_url = "https:" + src
        elif src.startswith(("http://", "https://")):
            asset_url = src
        else:
            asset_url = urljoin(base_url + "/", src)
        filename = Path(urlparse(src).path).name or f"script_{js_counter}.js"
        js_counter += 1
        try:
            r = requests.get(asset_url, headers=headers, timeout=15)
            (js_dir / filename).write_bytes(r.content)
            script["src"] = f"js/{filename}"
            print(f"  Downloaded JS: {filename}")
        except Exception as exc:
            print(f"  Warning: JS download failed ({asset_url}): {exc}")

    # --- Images ---
    img_dir = output_dir / "images"
    img_dir.mkdir(exist_ok=True)
    seen_imgs: set[str] = set()
    for img in soup.find_all("img"):
        src = img.get("src", "")
        if not src or src.startswith("data:"):
            continue
        asset_url = urljoin(base_url + "/", src)
        filename = Path(urlparse(src).path).name
        if not filename or filename in seen_imgs:
            continue
        seen_imgs.add(filename)
        try:
            r = requests.get(asset_url, headers=headers, timeout=15)
            (img_dir / filename).write_bytes(r.content)
            img["src"] = f"images/{filename}"
            print(f"  Downloaded image: {filename}")
        except Exception as exc:
            print(f"  Warning: Image download failed ({asset_url}): {exc}")

    # Save processed HTML.
    (output_dir / "index.html").write_text(str(soup), encoding="utf-8")
    print("  Saved: index.html")
    return output_dir


# ===========================================================================
# ZIP extraction helper
# ===========================================================================

def extract_zip_input(zip_path: str, extract_to: str) -> Path:
    with zipfile.ZipFile(zip_path, "r") as zf:
        zf.extractall(extract_to)
    items = list(Path(extract_to).iterdir())
    if len(items) == 1 and items[0].is_dir():
        return items[0]
    return Path(extract_to)


# ===========================================================================
# CLI
# ===========================================================================

def main():
    parser = argparse.ArgumentParser(
        description="Convert a static HTML/CSS/JS template into an installable Joomla 4 template.",
        formatter_class=argparse.RawDescriptionHelpFormatter,
        epilog=(
            "Examples:\n"
            "  python convert.py my_site/ joomla_template/\n"
            "  python convert.py template.zip joomla_template/\n"
            "  python convert.py --url https://example.com joomla_template/\n"
            "  python convert.py my_site/ joomla_template/ --name awesome_theme\n"
        ),
    )
    parser.add_argument("input", nargs="?", help="Input folder or ZIP file path")
    parser.add_argument("output", help="Output template folder path")
    parser.add_argument("--url", help="Download website from URL instead of local input")
    parser.add_argument("--name", help="Template name (default: derived from output folder name)")

    args = parser.parse_args()

    if not args.url and not args.input:
        parser.error("Provide either an input path or --url")

    tmp_dir = None
    try:
        if args.url:
            tmp_dir = tempfile.mkdtemp(prefix="joomla_cvt_")
            input_path = download_website(args.url, Path(tmp_dir) / "downloaded")
        else:
            input_path = Path(args.input)
            if input_path.suffix.lower() == ".zip":
                tmp_dir = tempfile.mkdtemp(prefix="joomla_cvt_")
                input_path = extract_zip_input(str(input_path), tmp_dir)
            elif not input_path.is_dir():
                print(f"ERROR: '{args.input}' is not a directory or ZIP file.")
                sys.exit(1)

        converter = JoomlaConverter(input_path, Path(args.output), args.name)
        if not converter.convert():
            sys.exit(1)
    finally:
        if tmp_dir:
            shutil.rmtree(tmp_dir, ignore_errors=True)


if __name__ == "__main__":
    main()
