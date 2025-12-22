<?php
/**
 * Modal Templates API Endpoint
 * 
 * Technical Implementation:
 * - Template mapping system with predefined template->file associations
 * - Dynamic path resolution using plugin_dir_path() and relative paths
 * - Output buffering with ob_start()/ob_get_clean() for template rendering
 * - WordPress AJAX hooks for authenticated and public access
 * - Legacy support through template type override
 * 
 * @package Visual_ACF_Modules
 * @subpackage API_Endpoints
 */

add_action('wp_ajax_get_modal_template', 'get_modal_template');
add_action('wp_ajax_nopriv_get_modal_template', 'get_modal_template');

/**
 * Template loader with type mapping and fallback
 * Maps template names to files, validates existence, renders with output buffering
 * Returns WordPress AJAX response: {success: true, data: {html: string}}
 */
function get_modal_template() {
    $template = isset($_POST['template']) ? sanitize_text_field($_POST['template']) : 'modal';
    
    // Template name to file mapping with fallback to modal.php
    $template_map = [
        'modal' => 'modal.php',
        'usage' => 'usage-modal.php',
        'loading' => 'loading.php',
        'error' => 'error.php'
    ];
    
    $template_file = isset($template_map[$template]) ? $template_map[$template] : 'modal.php';
    $template_path = plugin_dir_path(__FILE__) . '../templates/' . $template_file;
    
    if (!file_exists($template_path)) {
        wp_send_json_error('Template not found');
        return;
    }
    
    // Render template with output buffering
    ob_start();
    include $template_path;
    $html = ob_get_clean();
    
    wp_send_json_success([
        'html' => $html
    ]);
}

/**
 * Legacy endpoint for usage modal template
 * Overrides POST template parameter and forwards to main handler
 */
add_action('wp_ajax_get_usage_modal_template', 'get_usage_modal_template');
add_action('wp_ajax_nopriv_get_usage_modal_template', 'get_usage_modal_template');

function get_usage_modal_template() {
    $_POST['template'] = 'usage';
    get_modal_template();
}
