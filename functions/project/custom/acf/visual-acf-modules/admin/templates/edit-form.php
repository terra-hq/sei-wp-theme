<?php
/**
 * Template for the module edit form
 * 
 * @var array $module The module data
 * @var string $current_slug The current module slug
 * @var string $description The module description
 * @var string|false $preview_url The preview image URL or false if not available
 */
?>
<h2>Edit Module: <?php echo esc_html($module['label']); ?></h2>
<div class="module-info-box">
    <p class="module-info-item"><strong>Type:</strong> <?php echo ucfirst(esc_html($module['type'])); ?></p>
    <p class="module-info-item"><strong>ACF Slug:</strong> <code><?php echo esc_html($current_slug); ?></code></p>
    <?php if ($preview_url): ?>
        <p class="module-info-item"><strong>Preview Image:</strong> <span class="module-info-available">✓ Available</span></p>
    <?php else: ?>
        <p class="module-info-item"><strong>Preview Image:</strong> <span class="module-info-not-available">✗ Not set</span></p>
    <?php endif; ?>
</div>

<h3>Module Description</h3>

<form method="post">
    <?php wp_nonce_field('acf_module_description_nonce'); ?>
    <input type="hidden" name="module_slug" value="<?php echo esc_attr($current_slug); ?>">
    
    <div class="editor-container">
        <?php 
            wp_editor(
                $description, 
                'module_description', 
                [
                    'textarea_name' => 'module_description',
                    'textarea_rows' => 10,
                    'media_buttons' => true,
                ]
            ); 
        ?>
    </div>
    
    <p>
        <input type="submit" name="acf_module_description_submit" class="button button-primary" value="Save Description">
        <a href="<?php echo admin_url('admin.php?page=acf-module-descriptions'); ?>" class="button">Back to List</a>
    </p>
</form>
