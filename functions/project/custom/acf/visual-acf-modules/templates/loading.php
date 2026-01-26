<?php
/**
 * Loading Modal Template
 * 
 * Technical Implementation:
 * - POST data processing with sanitize_text_field()
 * - WordPress spinner component integration
 * - Minimal DOM structure for overlay display
 * - Dynamic title parameter support
 * 
 * @package Visual_ACF_Modules
 * @subpackage Templates
 */

if (!defined('ABSPATH')) {
    exit;
}

// POST data processing with fallback
$title = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : 'Loading...';
?>

<div class="acf-loading-modal">
    <div class="acf-loading-modal-content">
        <div class="acf-loading-modal-body">
            <div class="acf-loading-spinner">
                <span class="spinner is-active"></span>
            </div>
            <h3><?php echo esc_html($title); ?></h3>
        </div>
    </div>
</div>
