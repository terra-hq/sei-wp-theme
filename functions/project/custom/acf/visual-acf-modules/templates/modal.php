<?php
/**
 * Main Modal Template
 * 
 * Technical Implementation:
 * - POST data processing with sanitize_text_field() and json_decode()
 * - Dynamic content adaptation based on field_type parameter
 * - Grid layout with data-layout attributes for JavaScript interaction
 * - Conditional image rendering with fallback to dashicons
 * - WordPress escaping functions for XSS prevention
 * 
 * @package Visual_ACF_Modules
 * @subpackage Templates
 */

if (!defined('ABSPATH')) {
    exit;
}

// POST data processing and sanitization
$field_type = isset($_POST['field_type']) ? sanitize_text_field($_POST['field_type']) : 'modules';
$layouts = isset($_POST['layouts']) ? json_decode(stripslashes($_POST['layouts']), true) : [];
$preview_images = isset($_POST['preview_images']) ? json_decode(stripslashes($_POST['preview_images']), true) : [];

// Dynamic content based on field type
$modal_title = $field_type === 'heros' ? 'Select Hero' : 'Select Module';
$search_placeholder = $field_type === 'heros' ? 'Search heros...' : 'Search modules...';
?>

<div class="acf-modal-overlay active">
    <div class="acf-modal-container">
        <div class="acf-modal-header">
            <div class="acf-modal-header-content">
                <img class="acf-modal-logo" src="" alt="Logo">
                <h2><?php echo esc_html($modal_title); ?></h2>
            </div>
            <button class="acf-modal-close" aria-label="Close">
                <span class="dashicons dashicons-no-alt"></span>
            </button>
        </div>
        
        <div class="acf-modal-search">
            <input type="text" class="acf-modal-search-input" placeholder="<?php echo esc_attr($search_placeholder); ?>">
        </div>
        
        <div class="acf-modal-body">
            <div class="acf-modal-grid">
                <?php foreach ($layouts as $layout): ?>
                    <div class="acf-modal-card" data-layout="<?php echo esc_attr($layout['name']); ?>">
                        <button class="acf-modal-card-info" data-layout="<?php echo esc_attr($layout['name']); ?>" title="View module usage">
                            <span class="dashicons dashicons-info"></span>
                        </button>
                        <div class="acf-modal-card-preview">
                            <?php if (isset($preview_images[$layout['name']])): ?>
                                <img src="<?php echo esc_url($preview_images[$layout['name']]); ?>" alt="<?php echo esc_attr($layout['name']); ?> preview" />
                            <?php else: ?>
                                <span class="dashicons dashicons-layout"></span>
                            <?php endif; ?>
                        </div>
                        <div class="acf-modal-card-title"><?php echo esc_html($layout['label']); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
