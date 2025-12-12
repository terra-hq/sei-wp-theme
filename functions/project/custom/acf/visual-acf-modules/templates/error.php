<?php
/**
 * Error Modal Template
 * 
 * Technical Implementation:
 * - POST data processing with sanitize_text_field()
 * - Dual parameter support (title and message)
 * - Close button with dashicons integration
 * - Modal overlay structure for user interaction
 * - WordPress escaping functions for XSS prevention
 * 
 * @package Visual_ACF_Modules
 * @subpackage Templates
 */

if (!defined('ABSPATH')) {
    exit;
}

// POST data processing with fallbacks
$title = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : 'Error';
$message = isset($_POST['message']) ? sanitize_text_field($_POST['message']) : 'An error occurred.';
?>

<div class="acf-error-modal">
    <div class="acf-error-modal-content">
        <div class="acf-error-modal-header">
            <h3><?php echo esc_html($title); ?></h3>
            <button class="acf-error-modal-close">
                <span class="dashicons dashicons-no-alt"></span>
            </button>
        </div>
        <div class="acf-error-modal-body">
            <p class="acf-error-message"><?php echo esc_html($message); ?></p>
        </div>
    </div>
</div>
