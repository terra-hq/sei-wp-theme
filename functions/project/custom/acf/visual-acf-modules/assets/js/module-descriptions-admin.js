/**
 * Module Descriptions Admin - Image Upload Management
 * 
 * Technical Implementation:
 * - Template caching system with JSON-based cache keys
 * - DOM manipulation for dynamic form injection
 * - File upload with XMLHttpRequest progress tracking
 * - Drag-and-drop API integration
 * - Client-side validation (file type, size limits)
 * 
 * @package Visual_ACF_Modules
 * @subpackage Admin_Interface
 */

(function() {
    'use strict';

    // Template cache: templateName + JSON.stringify(data) = HTML
    const templateCache = {};

    document.addEventListener('DOMContentLoaded', function() {
        if (document.body.classList.contains('toplevel_page_acf-module-descriptions')) {
            // Check if we're on the edit page (has module parameter)
            const urlParams = new URLSearchParams(window.location.search);
            const moduleParam = urlParams.get('module');
            
            if (moduleParam) {
                // Show loading immediately for edit pages
                showLoading('Loading module editor...');
                
                // Hide the main content while loading
                const mainContent = document.querySelector('.wrap');
                if (mainContent) {
                    mainContent.style.opacity = '0.3';
                    mainContent.style.pointerEvents = 'none';
                }
            }
            
            initImageUpload();
        }
    });

    /**
     * Template loader with caching
     * Cache key: templateName + JSON.stringify(data)
     * 
     * @param {string} templateName 
     * @param {object} data 
     * @returns {Promise<string>} HTML string
     */
    async function loadTemplate(templateName, data = {}) {
        const cacheKey = templateName + JSON.stringify(data);
        if (templateCache[cacheKey]) {
            return templateCache[cacheKey];
        }

        try {
            const html = await ACFApiService.getTemplate(templateName, data);
            templateCache[cacheKey] = html;
            return html;
        } catch (error) {
            console.error('Failed to load template:', error);
            throw error;
        }
    }

    /**
     * Show loading modal using modal template system
     * Uses ACFApiService.getModalTemplate for consistency with other modals
     */
    async function showLoading(title = 'Loading...') {
        try {
            const html = await ACFApiService.getModalTemplate('loading', { title });
            document.body.insertAdjacentHTML('beforeend', html);
        } catch (error) {
            console.error('Failed to show loading modal:', error);
        }
    }

    /**
     * Hide loading modal by removing from DOM
     */
    function hideLoading() {
        const loadingModal = document.querySelector('.acf-loading-modal');
        if (loadingModal) {
            loadingModal.remove();
        }
    }

    /**
     * Show error modal with message
     * Uses ACFApiService.getModalTemplate for consistency
     */
    async function showError(title = 'Error', message = 'An error occurred') {
        try {
            const html = await ACFApiService.getModalTemplate('error', { title, message });
            document.body.insertAdjacentHTML('beforeend', html);
            
            const modal = document.querySelector('.acf-error-modal');
            if (modal) {
                const closeModal = () => modal.remove();
                const closeButton = modal.querySelector('.acf-error-modal-close');
                if (closeButton) {
                    closeButton.addEventListener('click', closeModal);
                }
                modal.addEventListener('click', e => {
                    if (e.target === modal) closeModal();
                });
            }
        } catch (error) {
            console.error('Failed to show error modal:', error);
        }
    }

    /**
     * Dynamic form injection for image upload interface
     * Loads templates and restores page visibility when complete
     */
    function initImageUpload() {
        const form = document.querySelector('form[method="post"]');
        const moduleSlugInput = document.querySelector('input[name="module_slug"]');
        const moduleSlug = moduleSlugInput ? moduleSlugInput.value : null;
        
        if (form && moduleSlug) {
            loadTemplate('image_upload', { module_slug: moduleSlug })
                .then(html => {
                    const submitParagraph = form.querySelector('p:has(input[type="submit"])') || 
                                           Array.from(form.querySelectorAll('p')).find(p => p.querySelector('input[type="submit"]'));
                    
                    if (submitParagraph) {
                        const container = document.createElement('div');
                        container.innerHTML = html;
                        form.insertBefore(container, submitParagraph);
                        
                        // Load preview and setup handlers
                        return loadCurrentPreview(moduleSlug);
                    }
                })
                .then(() => {
                    setupUploadHandlers(moduleSlug);
                    
                    // Restore page visibility and hide loading
                    const mainContent = document.querySelector('.wrap');
                    if (mainContent) {
                        mainContent.style.opacity = '1';
                        mainContent.style.pointerEvents = 'auto';
                    }
                    hideLoading();
                })
                .catch(error => {
                    console.error('Failed to load image upload template:', error);
                    
                    // Restore page visibility even on error
                    const mainContent = document.querySelector('.wrap');
                    if (mainContent) {
                        mainContent.style.opacity = '1';
                        mainContent.style.pointerEvents = 'auto';
                    }
                    hideLoading();
                    showError('Error', 'Failed to load module editor components');
                });
        } else {
            // If no form or module slug, just restore visibility
            const mainContent = document.querySelector('.wrap');
            if (mainContent) {
                mainContent.style.opacity = '1';
                mainContent.style.pointerEvents = 'auto';
            }
            hideLoading();
        }
    }

    /**
     * Loads existing preview image from API
     */
    async function loadCurrentPreview(moduleSlug) {
        try {
            const images = await ACFApiService.getPreviewImages();
            if (images[moduleSlug]) {
                showCurrentPreview(images[moduleSlug], moduleSlug);
            }
        } catch (error) {
            console.error('Error loading preview images:', error);
        }
    }

    /**
     * Renders preview template with delete handler
     */
    function showCurrentPreview(imageUrl, moduleSlug) {
        loadTemplate('current_preview', { 
            image_url: imageUrl, 
            module_slug: moduleSlug 
        })
        .then(html => {
            const previewContainer = document.querySelector('.current-preview');
            if (previewContainer) {
                previewContainer.innerHTML = html;
                
                const deleteButton = previewContainer.querySelector('.delete-preview');
                if (deleteButton) {
                    deleteButton.addEventListener('click', function() {
                        if (confirm('Are you sure you want to delete this preview image?')) {
                            deletePreview(this.getAttribute('data-slug'));
                        }
                    });
                }
            }
        })
        .catch(error => {
            console.error('Failed to load current preview template:', error);
        });
    }

    /**
     * Sets up drag-and-drop and click upload handlers
     * Implements HTML5 drag-and-drop API with visual feedback
     */
    function setupUploadHandlers(moduleSlug) {
        const uploadArea = document.querySelector('.upload-area');
        const fileInput = document.getElementById('module-preview-upload');
        
        if (!uploadArea || !fileInput) return;
        
        uploadArea.addEventListener('click', function() {
            fileInput.click();
        });
        
        fileInput.addEventListener('click', function(e) {
            e.stopPropagation();
        });
        
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                uploadFile(file, moduleSlug);
            }
        });
        
        // Drag-and-drop implementation
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.style.background = '#f0f0f0';
        });
        
        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.style.background = 'white';
        });
        
        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.style.background = 'white';
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                uploadFile(files[0], moduleSlug);
            }
        });
    }

    /**
     * File upload with client-side validation and progress tracking
     * Validates: file type (image/*), size (5MB max)
     * Uses XMLHttpRequest for progress callback support
     */
    async function uploadFile(file, moduleSlug) {
        if (!moduleSlug) {
            showMessage('Error: Module slug not found. Please refresh the page and try again.', 'error');
            return;
        }
        
        // Client-side validation
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/svg+xml', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            showMessage('Invalid file type. Please upload an image file.', 'error');
            return;
        }
        
        const maxSize = 5 * 1024 * 1024; // 5MB
        if (file.size > maxSize) {
            showMessage('File size exceeds 5MB limit.', 'error');
            return;
        }
        
        const progressElement = document.querySelector('.upload-progress');
        const messageElement = document.querySelector('.upload-message');
        
        if (progressElement) progressElement.style.display = 'block';
        if (messageElement) messageElement.style.display = 'none';
        
        try {
            const result = await ACFApiService.uploadModulePreview(moduleSlug, file, (percentComplete) => {
                const progressBar = document.querySelector('.progress-bar');
                if (progressBar) {
                    progressBar.style.width = percentComplete + '%';
                }
            });
            
            if (progressElement) progressElement.style.display = 'none';
            
            showMessage('Image uploaded successfully!', 'success');
            showCurrentPreview(result.url, moduleSlug);
            
            const fileInput = document.getElementById('module-preview-upload');
            if (fileInput) fileInput.value = '';
            
        } catch (error) {
            if (progressElement) progressElement.style.display = 'none';
            console.error('Upload failed:', error);
            showMessage(error.message || 'Upload failed', 'error');
        }
    }

    /**
     * Delete preview image via API, clear DOM container
     */
    async function deletePreview(moduleSlug) {
        try {
            await ACFApiService.deleteModulePreview(moduleSlug);
            
            const previewContainer = document.querySelector('.current-preview');
            if (previewContainer) previewContainer.innerHTML = '';
            showMessage('Image deleted successfully!', 'success');
            
        } catch (error) {
            console.error('Delete failed:', error);
            showMessage(error.message || 'Delete failed', 'error');
        }
    }

    /**
     * Message display with template fallback
     * Auto-hide after 5 seconds with CSS opacity animation
     */
    function showMessage(message, type) {
        const messageDiv = document.querySelector('.upload-message');
        if (!messageDiv) return;
        
        loadTemplate('status_message', { 
            message: message, 
            type: type 
        })
        .then(html => {
            messageDiv.innerHTML = html;
            messageDiv.style.display = 'block';
            
            setTimeout(function() {
                fadeOut(messageDiv);
            }, 5000);
        })
        .catch(error => {
            // Inline fallback if template loading fails
            console.error('Failed to load status message template:', error);
            
            const bgColor = type === 'success' ? '#d4edda' : '#f8d7da';
            const textColor = type === 'success' ? '#155724' : '#721c24';
            const borderColor = type === 'success' ? '#c3e6cb' : '#f5c6cb';
            
            messageDiv.innerHTML = message;
            messageDiv.style.background = bgColor;
            messageDiv.style.color = textColor;
            messageDiv.style.padding = '10px';
            messageDiv.style.borderRadius = '5px';
            messageDiv.style.border = '1px solid ' + borderColor;
            messageDiv.style.display = 'block';
            
            setTimeout(function() {
                fadeOut(messageDiv);
            }, 5000);
        });
    }
    
    /**
     * CSS opacity fade-out animation
     * 50ms intervals, 0.1 opacity decrements
     */
    function fadeOut(element) {
        let opacity = 1;
        const timer = setInterval(function() {
            if (opacity <= 0.1) {
                clearInterval(timer);
                element.style.display = 'none';
                element.style.opacity = '1';
            } else {
                opacity -= 0.1;
                element.style.opacity = opacity;
            }
        }, 50);
    }

})();
