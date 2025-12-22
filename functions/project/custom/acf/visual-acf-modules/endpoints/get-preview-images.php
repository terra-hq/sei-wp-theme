<?php
/**
 * Preview Images API Endpoint
 * 
 * Technical Implementation:
 * - Filesystem scanning with scandir() for real-time asset discovery
 * - Dynamic path resolution using dirname() and str_replace()
 * - File extension validation against allowlist
 * - WordPress AJAX hooks for authenticated and public access
 * - Response format: {slug: url} mapping for frontend consumption
 * 
 * @package Visual_ACF_Modules
 * @subpackage API_Endpoints
 */

add_action('wp_ajax_get_acf_preview_images', 'get_acf_preview_images');
add_action('wp_ajax_nopriv_get_acf_preview_images', 'get_acf_preview_images');

/**
 * Scans /assets/previews/ directory and returns slug->URL mapping
 * Uses pathinfo() for filename extraction and extension validation
 * Returns WordPress AJAX response: {success: true, data: {slug: url}}
 */
function get_acf_preview_images() {
    // Dynamic path resolution for deployment flexibility
    $module_base_dir = dirname(dirname(__FILE__));
    $module_base_url = str_replace(get_template_directory(), get_template_directory_uri(), $module_base_dir);
    
    $preview_dir = $module_base_dir . '/assets/previews/';
    $preview_url = $module_base_url . '/assets/previews/';
    
    $images = array();
    
    if (is_dir($preview_dir)) {
        $files = scandir($preview_dir);
        $allowed_extensions = array('png', 'jpg', 'jpeg', 'gif', 'svg', 'webp');
        
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;
            
            $file_info = pathinfo($file);
            $extension = strtolower($file_info['extension'] ?? '');
            
            if (in_array($extension, $allowed_extensions)) {
                $module_slug = $file_info['filename'];
                $images[$module_slug] = $preview_url . $file;
            }
        }
    }
    
    wp_send_json_success($images);
}
