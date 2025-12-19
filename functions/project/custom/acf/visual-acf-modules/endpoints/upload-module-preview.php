<?php
/**
 * Module Preview Upload API Endpoint
 * 
 * Technical Implementation:
 * - File upload handling with $_FILES validation
 * - MIME type and extension validation against allowlist
 * - File size limit enforcement (5MB)
 * - Directory creation with wp_mkdir_p() and chmod()
 * - File operations: move_uploaded_file(), unlink(), copy()
 * - Image optimization with wp_get_image_editor()
 * - WordPress nonce security with wp_verify_nonce()
 * 
 * @package Visual_ACF_Modules
 * @subpackage API_Endpoints
 */

add_action('wp_ajax_upload_module_preview', 'handle_module_preview_upload');
add_action('wp_ajax_delete_module_preview', 'handle_module_preview_delete');

/**
 * File upload handler with validation and optimization
 * Validates: permissions, nonce, file type, size limit
 * Processes: file move, image resize, permissions setting
 */
function handle_module_preview_upload() {
    // Check permissions
    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'Insufficient permissions']);
        return;
    }

    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'module_preview_upload')) {
        wp_send_json_error(['message' => 'Security check failed']);
        return;
    }

    // Check if file was uploaded
    if (!isset($_FILES['preview_image']) || $_FILES['preview_image']['error'] !== UPLOAD_ERR_OK) {
        wp_send_json_error(['message' => 'No file uploaded or upload error']);
        return;
    }

    // Get module slug
    $module_slug = isset($_POST['module_slug']) ? sanitize_text_field($_POST['module_slug']) : '';
    
    // Debug logging
    error_log('Upload Module Preview - Received slug: ' . $module_slug);
    error_log('Upload Module Preview - POST data: ' . print_r($_POST, true));
    
    if (empty($module_slug)) {
        wp_send_json_error(['message' => 'Module slug is required']);
        return;
    }

    $uploaded_file = $_FILES['preview_image'];
    
    // Validate file type
    $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/svg+xml', 'image/webp'];
    $file_type = wp_check_filetype($uploaded_file['name']);
    
    if (!in_array($uploaded_file['type'], $allowed_types) || !$file_type['ext']) {
        wp_send_json_error(['message' => 'Invalid file type. Only images are allowed.']);
        return;
    }

    // Validate file size (max 5MB)
    $max_size = 5 * 1024 * 1024; // 5MB in bytes
    if ($uploaded_file['size'] > $max_size) {
        wp_send_json_error(['message' => 'File size exceeds 5MB limit']);
        return;
    }

    // Get the base directory of the visual-acf-modules dynamically
    $module_base_dir = dirname(dirname(__FILE__)); // Go up two levels from current file
    $module_base_url = str_replace(get_template_directory(), get_template_directory_uri(), $module_base_dir);
    
    // Set up the preview directory
    $preview_dir = $module_base_dir . '/assets/previews/';
    $preview_url = $module_base_url . '/assets/previews/';
    
    // Log the paths for debugging
    error_log('Upload Module Preview - Module base dir: ' . $module_base_dir);
    error_log('Upload Module Preview - Preview dir: ' . $preview_dir);

    // Create directory if it doesn't exist
    if (!file_exists($preview_dir)) {
        wp_mkdir_p($preview_dir);
    }

    // Delete existing preview image for this module if it exists
    $existing_files = glob($preview_dir . $module_slug . '.*');
    foreach ($existing_files as $existing_file) {
        if (is_file($existing_file)) {
            unlink($existing_file);
        }
    }

    // Generate new filename with module slug
    $new_filename = $module_slug . '.' . $file_type['ext'];
    $target_path = $preview_dir . $new_filename;

    // Check if directory is writable
    if (!is_writable($preview_dir)) {
        // Try to create the directory with proper permissions
        if (!file_exists($preview_dir)) {
            wp_mkdir_p($preview_dir);
        }
        // Try to change permissions
        @chmod($preview_dir, 0755);
        
        // Check again
        if (!is_writable($preview_dir)) {
            wp_send_json_error(['message' => 'Preview directory is not writable. Please check permissions for: ' . $preview_dir]);
            return;
        }
    }

    // Use WordPress function to handle the file upload
    $upload_overrides = array(
        'test_form' => false,
        'unique_filename_callback' => function($dir, $name, $ext) use ($module_slug, $file_type) {
            return $module_slug . '.' . $file_type['ext'];
        }
    );

    // First, let's try with move_uploaded_file
    $move_result = @move_uploaded_file($uploaded_file['tmp_name'], $target_path);
    
    if (!$move_result) {
        // If move_uploaded_file fails, try copy as fallback
        $copy_result = @copy($uploaded_file['tmp_name'], $target_path);
        
        if (!$copy_result) {
            // Get more detailed error information
            $error_msg = 'Failed to save file. ';
            if (!file_exists($preview_dir)) {
                $error_msg .= 'Directory does not exist. ';
            }
            if (!is_writable($preview_dir)) {
                $error_msg .= 'Directory is not writable. ';
            }
            $error_msg .= 'Target path: ' . $target_path;
            
            wp_send_json_error(['message' => $error_msg]);
            return;
        }
    }

    // File was successfully moved/copied
    // Optimize image if it's not SVG
    if ($file_type['ext'] !== 'svg' && file_exists($target_path)) {
        $image_editor = wp_get_image_editor($target_path);
        if (!is_wp_error($image_editor)) {
            // Resize if larger than 800px width while maintaining aspect ratio
            $size = $image_editor->get_size();
            if ($size['width'] > 800) {
                $image_editor->resize(800, null, false);
                $image_editor->save($target_path);
            }
        }
    }

    // Verify the file was actually saved
    if (file_exists($target_path)) {
        // Log success
        error_log('Upload Module Preview - Success! File saved as: ' . $new_filename . ' for module: ' . $module_slug);
        
        // Return success with the new image URL
        wp_send_json_success([
            'message' => 'Image uploaded successfully for module: ' . $module_slug,
            'url' => $preview_url . $new_filename,
            'filename' => $new_filename,
            'module_slug' => $module_slug
        ]);
    } else {
        wp_send_json_error(['message' => 'File was not saved properly. Please check server permissions.']);
    }
}

/**
 * File deletion handler with security validation
 * Validates: permissions, nonce, module slug
 * Processes: file discovery and removal
 */
function handle_module_preview_delete() {
    // Check permissions
    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'Insufficient permissions']);
        return;
    }

    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'module_preview_upload')) {
        wp_send_json_error(['message' => 'Security check failed']);
        return;
    }

    // Get module slug
    $module_slug = isset($_POST['module_slug']) ? sanitize_text_field($_POST['module_slug']) : '';
    if (empty($module_slug)) {
        wp_send_json_error(['message' => 'Module slug is required']);
        return;
    }

    // Get the base directory of the visual-acf-modules dynamically
    $module_base_dir = dirname(dirname(__FILE__)); // Go up two levels from current file
    $module_base_url = str_replace(get_template_directory(), get_template_directory_uri(), $module_base_dir);
    
    // Set up the preview directory
    $preview_dir = $module_base_dir . '/assets/previews/';

    // Delete existing preview image for this module
    $existing_files = glob($preview_dir . $module_slug . '.*');
    $deleted = false;
    
    foreach ($existing_files as $existing_file) {
        if (is_file($existing_file)) {
            if (unlink($existing_file)) {
                $deleted = true;
            }
        }
    }

    if ($deleted) {
        wp_send_json_success(['message' => 'Image deleted successfully']);
    } else {
        wp_send_json_error(['message' => 'No image found to delete']);
    }
}
