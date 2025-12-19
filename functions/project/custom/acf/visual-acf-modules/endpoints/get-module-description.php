<?php
/**
 * Module Description API Endpoint
 * 
 * Technical Implementation:
 * - WordPress options API with get_option() for description storage
 * - Data sanitization with sanitize_text_field() and sanitize_key()
 * - WordPress AJAX hooks for authenticated and public access
 * - Debug logging with error_log() for troubleshooting
 * - Response format: {success: true, data: {module: string, description: string}}
 * 
 * @package Visual_ACF_Modules
 * @subpackage API_Endpoints
 */

add_action('wp_ajax_get_module_description', 'get_module_description');
add_action('wp_ajax_nopriv_get_module_description', 'get_module_description');

/**
 * Description retrieval from WordPress options
 * Uses ACF slug as key with acf_module_desc_ prefix
 * Includes debug logging for description lookup
 */
function get_module_description() {
    $module_name = isset($_POST['module_name']) ? sanitize_text_field($_POST['module_name']) : '';
    
    if (empty($module_name)) {
        wp_send_json_error('Module name is required');
        return;
    }
    
    $description = get_option('acf_module_desc_' . sanitize_key($module_name), '');
    
    error_log('Getting description for ACF slug: ' . $module_name);
    error_log('Option key: acf_module_desc_' . sanitize_key($module_name));
    error_log('Description found: ' . ($description ? 'Yes ('.strlen($description).' chars)' : 'No'));
    
    wp_send_json_success(array(
        'module' => $module_name,
        'description' => $description
    ));
}
