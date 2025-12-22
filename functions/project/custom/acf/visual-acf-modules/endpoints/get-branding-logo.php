<?php
/**
 * Branding Logo API Endpoint
 * 
 * Technical Implementation:
 * - File discovery with predefined extension allowlist
 * - Dynamic path resolution using dirname() and str_replace()
 * - Cache busting with filemtime() parameter
 * - WordPress AJAX hooks for authenticated and public access
 * - Response format: {success: true, data: {logo_url: string|false}}
 * 
 * @package Visual_ACF_Modules
 * @subpackage API_Endpoints
 */

add_action('wp_ajax_get_branding_logo', 'get_branding_logo');
add_action('wp_ajax_nopriv_get_branding_logo', 'get_branding_logo');

/**
 * Logo file discovery with cache busting
 * Scans for logo.{ext} files in /assets/branding/ directory
 * Returns URL with filemtime parameter or false if not found
 */
function get_branding_logo() {
    $module_base_dir = dirname(dirname(__FILE__));
    $branding_dir = $module_base_dir . '/assets/branding/';
    $branding_url = str_replace(get_template_directory(), get_template_directory_uri(), $module_base_dir) . '/assets/branding/';
    
    $allowed_extensions = array('png', 'jpg', 'jpeg', 'svg', 'webp');
    
    foreach ($allowed_extensions as $ext) {
        $file_path = $branding_dir . 'logo.' . $ext;
        if (file_exists($file_path)) {
            wp_send_json_success([
                'logo_url' => $branding_url . 'logo.' . $ext . '?v=' . filemtime($file_path)
            ]);
            return;
        }
    }
    
    wp_send_json_success([
        'logo_url' => false
    ]);
}
