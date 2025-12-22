<?php
/**
 * Template for displaying the current preview image
 * 
 * @var string $image_url The URL of the preview image
 * @var string $module_slug The module slug
 */
?>
<div class="preview-container">
    <img class="preview-image" src="<?php echo esc_url($image_url); ?>" alt="Current preview">
    <button type="button" class="delete-preview" data-slug="<?php echo esc_attr($module_slug); ?>">
        <span class="dashicons dashicons-trash"></span>
    </button>
</div>
<p class="preview-caption">Current preview image</p>
