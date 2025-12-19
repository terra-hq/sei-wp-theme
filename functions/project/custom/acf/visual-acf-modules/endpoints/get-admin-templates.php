<?php
/**
 * Admin Templates API Endpoint
 * 
 * Technical Implementation:
 * - Template mapping system with predefined template->file associations
 * - Dynamic path resolution using dirname() for admin/templates directory
 * - POST data extraction and variable scope injection with extract()
 * - Output buffering with ob_start()/ob_get_clean() for template rendering
 * - WordPress capability checking with current_user_can()
 * 
 * @package Visual_ACF_Modules
 * @subpackage API_Endpoints
 */

add_action('wp_ajax_get_admin_template', 'get_admin_template');

/**
 * Template loader with capability checking and variable injection
 * Maps template names to files, validates existence, renders with POST data
 * Returns WordPress AJAX response: {success: true, data: {html: string}}
 */
function get_admin_template() {
    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'Insufficient permissions']);
        return;
    }

    $template = isset($_POST['template']) ? sanitize_text_field($_POST['template']) : '';
    
    // Template name to file mapping
    $template_map = [
        'image_upload' => 'image-upload-section.php',
        'current_preview' => 'current-preview.php',
        'status_message' => 'status-message.php'
    ];
    
    if (!isset($template_map[$template])) {
        wp_send_json_error(['message' => 'Invalid template type']);
        return;
    }
    
    $template_file = $template_map[$template];
    $template_path = dirname(dirname(__FILE__)) . '/admin/templates/' . $template_file;
    
    if (!file_exists($template_path)) {
        wp_send_json_error(['message' => 'Template not found: ' . $template_path]);
        return;
    }
    
    // Extract POST data for template variable scope
    $data = [];
    foreach ($_POST as $key => $value) {
        if ($key !== 'action' && $key !== 'template') {
            $data[$key] = $value;
        }
    }
    
    // Render template with output buffering
    ob_start();
    extract($data);
    include $template_path;
    $html = ob_get_clean();
    
    wp_send_json_success([
        'html' => $html
    ]);
}
