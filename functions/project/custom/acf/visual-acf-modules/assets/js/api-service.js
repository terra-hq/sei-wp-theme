/**
 * ACF API Service - AJAX Communication Layer
 * 
 * Technical Implementation:
 * - Fetch API for standard requests with URLSearchParams encoding
 * - XMLHttpRequest for file uploads (progress tracking support)
 * - WordPress AJAX conventions with nonce security
 * - Promise-based interface with error handling
 * - Multiple URL resolution strategies for compatibility
 * 
 * @package Visual_ACF_Modules
 * @subpackage API_Communication
 */

const ACFApiService = (() => {
    'use strict';

    /**
     * WordPress AJAX URL resolution with fallbacks
     * Priority: acf_module_admin.ajax_url > ajaxurl > default path
     */
    const getAjaxUrl = () => {
        return (typeof acf_module_admin !== 'undefined' && acf_module_admin.ajax_url) 
            || (typeof ajaxurl !== 'undefined' && ajaxurl)
            || '/wp-admin/admin-ajax.php';
    };

    /**
     * WordPress nonce retrieval for CSRF protection
     */
    const getNonce = () => {
        return (typeof acf_module_admin !== 'undefined' && acf_module_admin.nonce) || null;
    };

    /**
     * Core AJAX POST request handler
     * Uses Fetch API with URLSearchParams for WordPress compatibility
     * Validates WordPress response format: {success: bool, data: object}
     */
    const post = async (action, params = {}) => {
        const urlParams = new URLSearchParams();
        urlParams.append('action', action);
        
        Object.keys(params).forEach(key => {
            urlParams.append(key, params[key]);
        });

        try {
            const response = await fetch(getAjaxUrl(), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: urlParams.toString()
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            
            if (!data.success) {
                throw new Error(data.data?.message || 'Request failed');
            }

            return data.data;
        } catch (error) {
            console.error(`API Error (${action}):`, error);
            throw error;
        }
    };

    /**
     * File upload with progress tracking
     * Uses XMLHttpRequest instead of Fetch for upload.progress event support
     * Returns Promise for consistency with other API methods
     */
    const upload = (action, formData, onProgress = null) => {
        return new Promise((resolve, reject) => {
            if (!formData.has('action')) {
                formData.append('action', action);
            }

            const xhr = new XMLHttpRequest();
            
            // Progress tracking via xhr.upload.progress event
            if (onProgress && xhr.upload) {
                xhr.upload.addEventListener('progress', (e) => {
                    if (e.lengthComputable) {
                        const percentComplete = (e.loaded / e.total) * 100;
                        onProgress(percentComplete);
                    }
                });
            }

            xhr.onload = () => {
                if (xhr.status >= 200 && xhr.status < 400) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            resolve(response.data);
                        } else {
                            reject(new Error(response.data?.message || 'Upload failed'));
                        }
                    } catch (e) {
                        reject(new Error('Invalid response format'));
                    }
                } else {
                    reject(new Error(`Server error: ${xhr.status}`));
                }
            };

            xhr.onerror = () => {
                reject(new Error('Upload failed'));
            };

            xhr.open('POST', getAjaxUrl(), true);
            xhr.send(formData);
        });
    };

    /**
     * Get a template from the server
     * @param {string} templateName - Name of the template
     * @param {Object} data - Data to pass to the template
     * @returns {Promise<string>} Promise resolving to the template HTML
     */
    const getTemplate = async (templateName, data = {}) => {
        const params = {
            template: templateName,
            ...data
        };

        const result = await post('get_admin_template', params);
        return result.html;
    };

    /**
     * Get modal template
     * @param {string} template - Template type (loading, error, etc.)
     * @param {Object} data - Template data
     * @returns {Promise<string>} Promise resolving to the template HTML
     */
    const getModalTemplate = async (template, data = {}) => {
        const params = {
            template,
            ...data
        };

        const result = await post('get_modal_template', params);
        return result.html;
    };

    /**
     * Get usage modal template
     * @param {Object} params - Template parameters
     * @returns {Promise<string>} Promise resolving to the template HTML
     */
    const getUsageModalTemplate = async (params) => {
        const result = await post('get_usage_modal_template', params);
        return result.html;
    };

    /**
     * Get all preview images
     * @returns {Promise<Object>} Promise resolving to preview images object
     */
    const getPreviewImages = async () => {
        return await post('get_acf_preview_images');
    };

    /**
     * Get branding logo URL
     * @returns {Promise<string|false>} Promise resolving to logo URL or false if not found
     */
    const getBrandingLogo = async () => {
        const result = await post('get_branding_logo');
        return result.logo_url;
    };

    /**
     * Get modal background color
     * @returns {Promise<string>} Promise resolving to background color
     */
    const getModalBackground = async () => {
        const result = await post('get_modal_background');
        return result.background_color;
    };

    /**
     * Save modal background color
     * @param {string} color - Background color (hex, rgb, rgba)
     * @returns {Promise<Object>} Promise resolving to save result
     */
    const saveModalBackground = async (color) => {
        const params = {
            background_color: color
        };

        const nonce = getNonce();
        if (nonce) {
            params.nonce = nonce;
        }

        return await post('save_modal_background', params);
    };

    /**
     * Get module usage data
     * @param {string} moduleName - Name of the module
     * @param {string} fieldType - Type of field (modules/heros)
     * @returns {Promise<Object>} Promise resolving to usage data
     */
    const getModuleUsage = async (moduleName, fieldType) => {
        return await post('get_module_usage', {
            module_name: moduleName,
            field_type: fieldType
        });
    };

    /**
     * Get module description
     * @param {string} moduleName - Name of the module
     * @returns {Promise<Object>} Promise resolving to module description
     */
    const getModuleDescription = async (moduleName) => {
        return await post('get_module_description', {
            module_name: moduleName
        });
    };

    /**
     * Upload module preview image
     * @param {string} moduleSlug - Module slug
     * @param {File} file - Image file
     * @param {Function} onProgress - Progress callback
     * @returns {Promise<Object>} Promise resolving to upload result
     */
    const uploadModulePreview = async (moduleSlug, file, onProgress = null) => {
        const formData = new FormData();
        formData.append('action', 'upload_module_preview');
        formData.append('module_slug', moduleSlug);
        formData.append('preview_image', file);
        
        const nonce = getNonce();
        if (nonce) {
            formData.append('nonce', nonce);
        }

        return await upload('upload_module_preview', formData, onProgress);
    };

    /**
     * Delete module preview image
     * @param {string} moduleSlug - Module slug
     * @returns {Promise<Object>} Promise resolving to delete result
     */
    const deleteModulePreview = async (moduleSlug) => {
        const params = {
            module_slug: moduleSlug
        };

        const nonce = getNonce();
        if (nonce) {
            params.nonce = nonce;
        }

        return await post('delete_module_preview', params);
    };

    // Public API
    return {
        post,
        upload,
        getTemplate,
        getModalTemplate,
        getUsageModalTemplate,
        getPreviewImages,
        getBrandingLogo,
        getModalBackground,
        saveModalBackground,
        getModuleUsage,
        getModuleDescription,
        uploadModulePreview,
        deleteModulePreview
    };
})();
