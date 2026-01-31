"""
URL patterns for the converter app.
"""

from django.urls import path
from . import views

app_name = 'converter'

urlpatterns = [
    path('', views.index, name='index'),
    path('convert/', views.convert, name='convert'),
    path('download/<str:session_id>/<str:filename>', views.download, name='download'),
    path('preview/<str:session_id>/', views.preview, name='preview'),
]
