<?php
/**
 * Modal Customization Admin Interface
 * 
 * Technical Implementation:
 * - File upload handling with $_FILES validation and move_uploaded_file()
 * - WordPress options API for background color storage
 * - Dynamic path resolution with dirname() and str_replace()
 * - File extension and MIME type validation
 * - WordPress nonce security with check_admin_referer()
 * 
 * @package Visual_ACF_Modules
 * @subpackage Admin_Interface
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Modal customization interface for logo upload and color management
 * Uses WordPress submenu system and file operations for branding assets
 */
class ACF_Modal_Customization {

    private $branding_dir;
    private $branding_url;

    /**
     * Initialize paths and create branding directory
     * Sets up dynamic path resolution and WordPress admin menu hook
     */
    public function __construct() {
        $module_base_dir = dirname(dirname(__FILE__));
        $this->branding_dir = $module_base_dir . '/assets/branding/';
        $this->branding_url = str_replace(
            get_template_directory(), 
            get_template_directory_uri(), 
            $module_base_dir
        ) . '/assets/branding/';

        if (!file_exists($this->branding_dir)) {
            wp_mkdir_p($this->branding_dir);
        }

        add_action('admin_menu', [$this, 'admin_menu']);
    }

    /**
     * Register submenu under acf-module-descriptions parent
     */
    public function admin_menu() {
        add_submenu_page(
            'acf-module-descriptions',
            'Customize Modal',
            'Customize Modal',
            'manage_options',
            'acf-modal-customization',
            [$this, 'customization_page']
        );
    }

    /**
     * Logo file discovery with cache busting
     * Scans for logo.{ext} files and returns URL with filemtime parameter
     */
    public function get_logo_url() {
        $allowed_extensions = ['png', 'jpg', 'jpeg', 'svg', 'webp'];
        
        foreach ($allowed_extensions as $ext) {
            $file_path = $this->branding_dir . 'logo.' . $ext;
            if (file_exists($file_path)) {
                return $this->branding_url . 'logo.' . $ext . '?v=' . filemtime($file_path);
            }
        }
        
        return false;
    }

    /**
     * Delete all logo files with unlink()
     * Returns true if any file was deleted
     */
    public function delete_logo() {
        $allowed_extensions = ['png', 'jpg', 'jpeg', 'svg', 'webp'];
        $deleted = false;
        
        foreach ($allowed_extensions as $ext) {
            $file_path = $this->branding_dir . 'logo.' . $ext;
            if (file_exists($file_path)) {
                $deleted = unlink($file_path) || $deleted;
            }
        }
        
        return $deleted;
    }

    /**
     * File upload processing with validation
     * Validates: upload errors, file extension, MIME type, file size (2MB)
     * Uses move_uploaded_file() and chmod() for secure file handling
     */
    private function handle_logo_upload() {
        if (!isset($_FILES['modal_logo']) || $_FILES['modal_logo']['error'] === UPLOAD_ERR_NO_FILE) {
            return ['success' => false, 'message' => 'No file uploaded'];
        }

        if ($_FILES['modal_logo']['error'] !== UPLOAD_ERR_OK) {
            $error_messages = [
                UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize',
                UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE',
                UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
                UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
                UPLOAD_ERR_EXTENSION => 'Upload stopped by extension'
            ];
            $error_msg = isset($error_messages[$_FILES['modal_logo']['error']]) 
                ? $error_messages[$_FILES['modal_logo']['error']] 
                : 'Upload error occurred';
            return ['success' => false, 'message' => $error_msg];
        }

        // Get file extension from actual filename
        $file_info = pathinfo($_FILES['modal_logo']['name']);
        $extension = strtolower($file_info['extension'] ?? '');
        
        // Validate file extension
        $allowed_extensions = ['png', 'jpg', 'jpeg', 'svg', 'webp'];
        if (!in_array($extension, $allowed_extensions)) {
            return ['success' => false, 'message' => 'Invalid file extension. Allowed: PNG, JPG, SVG, WebP'];
        }

        // Validate MIME type
        $allowed_types = ['image/png', 'image/jpeg', 'image/jpg', 'image/svg+xml', 'image/webp'];
        $file_type = $_FILES['modal_logo']['type'];
        
        if (!in_array($file_type, $allowed_types)) {
            return ['success' => false, 'message' => 'Invalid file type. Please upload PNG, JPG, SVG, or WebP'];
        }

        // Validate file size (2MB max)
        $max_size = 2 * 1024 * 1024;
        if ($_FILES['modal_logo']['size'] > $max_size) {
            return ['success' => false, 'message' => 'File size exceeds 2MB limit'];
        }

        // Ensure branding directory exists and is writable
        if (!file_exists($this->branding_dir)) {
            if (!wp_mkdir_p($this->branding_dir)) {
                return ['success' => false, 'message' => 'Failed to create branding directory'];
            }
        }

        if (!is_writable($this->branding_dir)) {
            return ['success' => false, 'message' => 'Branding directory is not writable. Check permissions.'];
        }

        // Delete existing logo
        $this->delete_logo();

        // Move uploaded file
        $destination = $this->branding_dir . 'logo.' . $extension;
        
        if (move_uploaded_file($_FILES['modal_logo']['tmp_name'], $destination)) {
            // Set proper permissions
            chmod($destination, 0644);
            return ['success' => true, 'message' => 'Logo uploaded successfully!'];
        }

        return ['success' => false, 'message' => 'Failed to move uploaded file. Check directory permissions.'];
    }

    /**
     * Get the current background color
     *
     * @return string The background color
     */
    public function get_background_color() {
        return get_option('acf_modal_background_color', '#fff');
    }

    /**
     * Save the background color
     *
     * @param string $color The background color to save
     * @return bool Whether the save was successful
     */
    public function save_background_color($color) {
        return update_option('acf_modal_background_color', $color);
    }

    /**
     * Handle form submission
     */
    private function handle_form_submission() {
        $message = null;

        // Handle logo upload
        if (isset($_POST['upload_logo']) && check_admin_referer('modal_customization_nonce')) {
            $result = $this->handle_logo_upload();
            $message = [
                'type' => $result['success'] ? 'success' : 'error',
                'text' => $result['message']
            ];
        }

        // Handle logo deletion
        if (isset($_POST['delete_logo']) && check_admin_referer('modal_customization_nonce')) {
            if ($this->delete_logo()) {
                $message = [
                    'type' => 'success',
                    'text' => 'Logo deleted successfully!'
                ];
            } else {
                $message = [
                    'type' => 'error',
                    'text' => 'Failed to delete logo'
                ];
            }
        }

        // Handle background color save
        if (isset($_POST['save_background_color']) && check_admin_referer('modal_customization_nonce')) {
            $color = isset($_POST['background_color']) ? sanitize_text_field($_POST['background_color']) : 'rgba(0, 0, 0, 0.7)';
            
            if ($this->save_background_color($color)) {
                $message = [
                    'type' => 'success',
                    'text' => 'Background color saved successfully!'
                ];
            } else {
                $message = [
                    'type' => 'error',
                    'text' => 'Failed to save background color'
                ];
            }
        }

        // Handle background color reset
        if (isset($_POST['reset_background_color']) && check_admin_referer('modal_customization_nonce')) {
            if ($this->save_background_color('#fff')) {
                $message = [
                    'type' => 'success',
                    'text' => 'Background color reset to default!'
                ];
            } else {
                $message = [
                    'type' => 'error',
                    'text' => 'Failed to reset background color'
                ];
            }
        }

        return $message;
    }

    /**
     * Admin page content
     */
    public function customization_page() {
        $message = $this->handle_form_submission();
        $logo_url = $this->get_logo_url();

        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <p class="description">Customize the appearance of your ACF module selection modals.</p>

            <?php if ($message): ?>
                <div class="notice notice-<?php echo esc_attr($message['type']); ?> is-dismissible">
                    <p><?php echo esc_html($message['text']); ?></p>
                </div>
            <?php endif; ?>

            <div class="acf-customization-container">
                
                <!-- Logo Section -->
                <div class="acf-customization-section">
                    <h2>Company Logo</h2>
                    <p class="description">Upload a logo to display in the modal header. Recommended size: 150x40px (max 2MB).</p>

                    <?php if ($logo_url): ?>
                        <!-- Current Logo Preview -->
                        <div class="current-logo">
                            <h3>Current Logo</h3>
                            <div class="current-logo-preview">
                                <img src="<?php echo esc_url($logo_url); ?>" alt="Current logo">
                            </div>
                            <form method="post">
                                <?php wp_nonce_field('modal_customization_nonce'); ?>
                                <button type="submit" name="delete_logo" class="button button-secondary" onclick="return confirm('Are you sure you want to delete the logo?');">
                                    Delete Logo
                                </button>
                            </form>
                        </div>
                    <?php endif; ?>

                    <!-- Upload Form -->
                    <form method="post" enctype="multipart/form-data" class="upload-form">
                        <?php wp_nonce_field('modal_customization_nonce'); ?>
                        
                        <h3><?php echo $logo_url ? 'Replace Logo' : 'Upload Logo'; ?></h3>
                        
                        <div class="logo-upload-container">
                            <input type="file" name="modal_logo" id="modal_logo" accept="image/png,image/jpeg,image/jpg,image/svg+xml,image/webp">
                            <p class="description">Accepted formats: PNG, JPG, SVG, WebP (max 2MB)</p>
                        </div>

                        <p class="submit">
                            <button type="submit" name="upload_logo" id="upload_logo_button" class="button button-primary button-disabled" disabled>
                                <?php echo $logo_url ? 'Replace Logo' : 'Upload Logo'; ?>
                            </button>
                        </p>
                    </form>
                </div>

                <!-- Background Color Section -->
                <div class="acf-customization-section">
                    <h2>Modal Background</h2>
                    <p class="description">Customize the background color of the modal container.</p>
                    
                    <div class="background-color-section">
                        <form method="post">
                            <?php wp_nonce_field('modal_customization_nonce'); ?>
                            
                            <div class="color-picker-container">
                                <div class="color-preview" id="background-color-preview" style="background-color: <?php echo esc_attr($this->get_background_color()); ?>"></div>
                                <input type="text" name="background_color" id="background-color-input" class="color-input" value="<?php echo esc_attr($this->get_background_color()); ?>" placeholder="rgba(0, 0, 0, 0.7)">
                            </div>
                            
                            <div class="color-actions">
                                <button type="submit" name="save_background_color" class="button button-primary button-disabled" disabled>Save Background Color</button>
                                <button type="submit" name="reset_background_color" class="button button-secondary color-reset button-disabled" disabled>Reset to Default</button>
                            </div>
                            
                            <p class="description" style="margin-top: 10px;">
                                You can use HEX (#000000), RGB (rgb(0,0,0)), or RGBA (rgba(0,0,0,0.7)) color formats.<br>
                                This color will be applied to the modal container itself, not the semi-transparent overlay behind it.
                            </p>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <?php
    }
}

new ACF_Modal_Customization();
