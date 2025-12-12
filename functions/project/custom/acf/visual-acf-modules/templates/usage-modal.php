<?php
/**
 * Usage Modal Template
 * 
 * Technical Implementation:
 * - POST data processing with sanitize_text_field() and json_decode()
 * - Dynamic post type label resolution with get_post_type_object()
 * - Conditional rendering based on user capabilities and data availability
 * - Filter system with data-type attributes for JavaScript interaction
 * - WordPress escaping functions for XSS prevention
 * 
 * @package Visual_ACF_Modules
 * @subpackage Templates
 */

if (!defined('ABSPATH')) {
    exit;
}

// POST data processing and sanitization
$layout_name = isset($_POST['layout_name']) ? sanitize_text_field($_POST['layout_name']) : '';
$layout_label = isset($_POST['layout_label']) ? sanitize_text_field($_POST['layout_label']) : '';
$field_type = isset($_POST['field_type']) ? sanitize_text_field($_POST['field_type']) : 'modules';
$usage_data = isset($_POST['usage_data']) ? json_decode(stripslashes($_POST['usage_data']), true) : [];
$total = isset($usage_data['total']) ? intval($usage_data['total']) : 0;
$description = isset($_POST['description']) ? wp_kses_post($_POST['description']) : '';

// Dynamic header title based on field type
$header_title = $field_type === 'heros' ? 'Hero Usage' : 'Module Usage';
?>

<div class="acf-usage-modal">
    <div class="acf-usage-modal-content">
        <div class="acf-usage-modal-header">
            <div class="acf-usage-modal-header-content">
                <img class="acf-usage-modal-logo" src="" alt="Logo">
                <h3><?php echo esc_html("{$header_title}: {$layout_label} ({$total} pages)"); ?></h3>
            </div>
            <button class="acf-usage-modal-close">
                <span class="dashicons dashicons-no-alt"></span>
            </button>
        </div>
        <div class="acf-usage-modal-body">
            <?php 
            // Conditional description section: show if content exists OR user has admin capabilities
            $show_description_section = !empty($description) || current_user_can('manage_options');
            ?>
            <?php if ($show_description_section): ?>
                <div class="acf-usage-description">
                    <?php if (!empty($description)): ?>
                        <h4>Description</h4>
                        <div class="acf-usage-description-content">
                            <?php echo $description; ?>
                        </div>
                    <?php else: ?>
                        <!-- Admin-only message when no description exists -->
                        <div class="acf-usage-no-description">
                            <p><strong>No description available.</strong> You can add one in the <a href="<?php echo admin_url('admin.php?page=acf-module-descriptions&module=' . urlencode($layout_name)); ?>" target="_blank">Module Documentation</a> section.</p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="acf-usage-pages">
                <h4>Usage</h4>
                <?php if (!empty($usage_data['usage'])): ?>
                <div class="acf-usage-filters">
                    <ul class="acf-usage-filter-pills">
                        <li><button class="acf-filter-pill active" data-type="all">All types</button></li>
                        <?php 
                        // Extraer tipos únicos de los elementos
                        $types = [];
                        foreach ($usage_data['usage'] as $item) {
                            if (!in_array($item['type'], $types)) {
                                $types[] = $item['type'];
                            }
                        }
                        sort($types); // Ordenar alfabéticamente
                        
                        // Mostrar una pill por cada tipo único
                        foreach ($types as $type) {
                            // Obtener el objeto del post type para acceder a sus labels
                            $post_type_obj = get_post_type_object($type);
                            // Usar el label si está disponible, de lo contrario usar el slug
                            $type_label = $post_type_obj ? $post_type_obj->labels->singular_name : $type;
                            echo '<li><button class="acf-filter-pill" data-type="'.esc_attr($type).'">'.esc_html($type_label).'</button></li>';
                        }
                        ?>
                    </ul>
                </div>
                <?php endif; ?>
                <?php if (empty($usage_data['usage'])): ?>
                    <p class="acf-usage-empty">This module is not currently in use.</p>
                <?php else: ?>
                <ul class="acf-usage-list">
                    <?php foreach ($usage_data['usage'] as $item): ?>
                        <li data-type="<?php echo esc_attr($item['type']); ?>">
                            <div class="acf-usage-item">
                                <div class="acf-usage-title">
                                    <?php echo esc_html($item['title']); ?> 
                                    <span class="type">(<?php 
                                        $post_type_obj = get_post_type_object($item['type']);
                                        echo esc_html($post_type_obj ? $post_type_obj->labels->singular_name : $item['type']); 
                                    ?>)</span>
                                </div>
                                <div class="acf-usage-actions">
                                    <a href="<?php echo esc_url($item['view_link']); ?>" target="_blank" class="button">View</a>
                                    <a href="<?php echo esc_url($item['edit_link']); ?>" target="_blank" class="button button-primary">Edit</a>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            </div>
        </div>
    </div>
</div>
