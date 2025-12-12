<?php
/**
 * Modal Background API Endpoint
 * 
 * Technical Implementation:
 * - WordPress options API with get_option() and update_option()
 * - Nonce verification with wp_verify_nonce() for security
 * - Capability checking with current_user_can()
 * - Data sanitization with sanitize_text_field()
 * - Dual endpoints: getter (public) and setter (admin-only)
 * 
 * @package Visual_ACF_Modules
 * @subpackage API_Endpoints
 */

add_action('wp_ajax_get_modal_background', 'get_modal_background');
add_action('wp_ajax_nopriv_get_modal_background', 'get_modal_background');

/**
 * Background color retrieval from WordPress options
 * Returns stored color or default '#fff' if not set
 */
function get_modal_background() {
    $background_color = get_option('acf_modal_background_color', '#fff');
    
    wp_send_json_success([
        'background_color' => $background_color
    ]);
}

add_action('wp_ajax_save_modal_background', 'save_modal_background');

/**
 * Background color storage with security validation
 * Validates: user capabilities, nonce verification, data sanitization
 * Updates WordPress option: acf_modal_background_color
 */
function save_modal_background() {
    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'You do not have permission to perform this action']);
        return;
    }
    
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'modal_customization_nonce')) {
        wp_send_json_error(['message' => 'Security check failed']);
        return;
    }
    
    $background_color = isset($_POST['background_color']) ? sanitize_text_field($_POST['background_color']) : '#fff';
    
    update_option('acf_modal_background_color', $background_color);
    
    wp_send_json_success([
        'message' => 'Background color saved successfully',
        'background_color' => $background_color
    ]);
}
