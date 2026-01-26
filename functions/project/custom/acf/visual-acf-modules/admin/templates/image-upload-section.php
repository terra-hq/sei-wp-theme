<?php
/**
 * Template for the image upload section in module edit form
 * 
 * @var string $module_slug The module slug
 */
?>
<div class="module-preview-upload-section">
    <h3>Module Preview Image</h3>
    <div class="current-preview"></div>
    <div class="upload-area">
        <div class="upload-instructions">
            <span class="dashicons dashicons-upload"></span>
            <p>Drag & drop an image here or click to select</p>
            <p class="file-types">Supported formats: JPG, PNG, GIF, SVG, WebP (Max 5MB)</p>
        </div>
        <input type="file" id="module-preview-upload" accept="image/*">
    </div>
    <div class="upload-progress">
        <div class="progress-container">
            <div class="progress-bar"></div>
        </div>
    </div>
    <div class="upload-message"></div>
</div>
