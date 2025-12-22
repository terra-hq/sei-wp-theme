<?php
/**
 * ACF Module Descriptions - Admin Interface
 * 
 * Technical Implementation:
 * - ACF field group scanning with acf_get_field_groups() and acf_get_fields()
 * - Field type classification based on field name string analysis
 * - WordPress options API for description storage (acf_module_desc_ prefix)
 * - File system operations for preview image detection
 * - Template-based rendering with extract() for variable scope
 * 
 * @package Visual_ACF_Modules
 * @subpackage Admin_Interface
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Admin interface for managing ACF module descriptions and preview images
 * Uses WordPress admin_menu hook and template system for UI rendering
 */
class ACF_Module_Descriptions {

    /**
     * Register admin menu hook
     */
    public function __construct() {
        add_action('admin_menu', [$this, 'admin_menu']);
    }

    /**
     * WordPress admin menu registration
     * Creates top-level menu item with manage_options capability
     */
    public function admin_menu() {
        add_menu_page(
            'ACF Module Descriptions',
            'Module Docs',
            'manage_options',
            'acf-module-descriptions',
            [$this, 'description_page'],
            'dashicons-media-text',
            61
        );
    }

    /**
     * ACF layout discovery and classification
     * Scans all field groups for flexible_content fields, extracts layouts
     * Classifies as 'hero' or 'module' based on field name string analysis
     * Returns array: [slug => ['slug', 'label', 'type', 'field_name']]
     */
    public function get_all_modules_and_heros() {
        $modules = [];
        $field_groups = acf_get_field_groups();
        
        foreach ($field_groups as $field_group) {
            $fields = acf_get_fields($field_group['key']);
            
            if ($fields) {
                foreach ($fields as $field) {
                    if ($field['type'] === 'flexible_content' && isset($field['layouts'])) {
                        // Field type classification: check for 'hero' in field name
                        $field_name = strtolower($field['name']);
                        $is_hero = (strpos($field_name, 'hero') !== false || $field_name === 'heros');
                        $field_type = $is_hero ? 'hero' : 'module';
                        
                        foreach ($field['layouts'] as $layout) {
                            $slug = $layout['name'];
                            $label = $layout['label'];
                            
                            $modules[$slug] = [
                                'slug' => $slug,
                                'label' => $label,
                                'type' => $field_type,
                                'field_name' => $field['name']
                            ];
                        }
                    }
                }
            }
        }
        
        uasort($modules, function($a, $b) {
            return strcmp($a['label'], $b['label']);
        });
        
        return $modules;
    }

    /**
     * Get description for a specific module/hero using ACF slug
     *
     * @param string $acf_slug The ACF slug
     * @return string The description or empty string
     */
    public function get_module_description($acf_slug) {
        $description = get_option('acf_module_desc_' . sanitize_key($acf_slug), '');
        return $description;
    }

    /**
     * Save description for a specific module/hero using ACF slug
     *
     * @param string $acf_slug The ACF slug
     * @param string $description The description to save
     * @return bool Whether the save was successful
     */
    public function save_module_description($acf_slug, $description) {
        return update_option('acf_module_desc_' . sanitize_key($acf_slug), $description);
    }

    /**
     * Check if a module has a preview image
     *
     * @param string $module_slug The module slug
     * @return bool Whether the module has a preview image
     */
    public function module_has_preview($module_slug) {
        // Get the base directory of the visual-acf-modules dynamically
        $module_base_dir = dirname(dirname(__FILE__)); // Go up two levels from current file
        $preview_dir = $module_base_dir . '/assets/previews/';
        
        $allowed_extensions = array('png', 'jpg', 'jpeg', 'gif', 'svg', 'webp');
        
        foreach ($allowed_extensions as $ext) {
            if (file_exists($preview_dir . $module_slug . '.' . $ext)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Get the preview image URL for a module
     *
     * @param string $module_slug The module slug
     * @return string|false The image URL or false if not found
     */
    public function get_module_preview_url($module_slug) {
        // Get the base directory of the visual-acf-modules dynamically
        $module_base_dir = dirname(dirname(__FILE__)); // Go up two levels from current file
        $module_base_url = str_replace(get_template_directory(), get_template_directory_uri(), $module_base_dir);
        
        // Set up the preview directory
        $preview_dir = $module_base_dir . '/assets/previews/';
        $preview_url = $module_base_url . '/assets/previews/';
        
        $allowed_extensions = array('png', 'jpg', 'jpeg', 'gif', 'svg', 'webp');
        
        foreach ($allowed_extensions as $ext) {
            $file_path = $preview_dir . $module_slug . '.' . $ext;
            if (file_exists($file_path)) {
                return $preview_url . $module_slug . '.' . $ext;
            }
        }
        
        return false;
    }

    /**
     * Path to the templates directory
     * 
     * @return string Path to templates
     */
    private function get_template_path() {
        return __DIR__ . '/templates';
    }
    
    /**
     * Load a template file
     * 
     * @param string $template Template file name (without extension)
     * @param array $data Data to pass to the template
     */
    private function load_template($template, $data = []) {
        $file = $this->get_template_path() . '/' . $template . '.php';
        
        if (file_exists($file)) {
            // Extract data to make variables available in the template
            extract($data);
            include $file;
        }
    }
    
    /**
     * Admin page content
     */
    public function description_page() {
        $this->handle_form_submission();
        
        // Get all modules and heros
        $modules = $this->get_all_modules_and_heros();
        
        // Get current module being edited
        $current_slug = isset($_GET['module']) ? sanitize_text_field($_GET['module']) : '';
        $editing = !empty($current_slug) && isset($modules[$current_slug]);
        
        $this->render_admin_header();
        
        if ($editing) {
            $this->render_edit_form($modules[$current_slug], $current_slug);
        } else {
            $this->render_modules_table($modules);
        }
        
        $this->render_admin_footer();
    }
    
    /**
     * Handle form submission for saving module descriptions
     */
    private function handle_form_submission() {
        if (isset($_POST['acf_module_description_submit']) && check_admin_referer('acf_module_description_nonce')) {
            $module_slug = isset($_POST['module_slug']) ? sanitize_text_field($_POST['module_slug']) : '';
            $description = isset($_POST['module_description']) ? wp_kses_post($_POST['module_description']) : '';
            
            if (!empty($module_slug)) {
                $this->save_module_description($module_slug, $description);
                echo '<div class="notice notice-success"><p>Description and image settings saved successfully!</p></div>';
            }
        }
    }
    
    /**
     * Render admin page header
     */
    private function render_admin_header() {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <?php
    }
    
    /**
     * Render admin page footer
     */
    private function render_admin_footer() {
        ?>
        </div>
        <?php
    }
    
    /**
     * Render the edit form for a module
     *
     * @param array $module The module data
     * @param string $current_slug The current module slug being edited
     */
    private function render_edit_form($module, $current_slug) {
        $description = $this->get_module_description($current_slug);
        $preview_url = $this->get_module_preview_url($current_slug);
        
        $this->load_template('edit-form', [
            'module' => $module,
            'current_slug' => $current_slug,
            'description' => $description,
            'preview_url' => $preview_url
        ]);
    }
    
    /**
     * Get the action button text based on module status
     *
     * @param bool $has_desc Whether the module has a description
     * @param bool $has_preview Whether the module has a preview image
     * @return string The button text
     */
    private function get_action_button_text($has_desc, $has_preview) {
        if ($has_desc && $has_preview) {
            return 'Edit';
        } elseif ($has_desc || $has_preview) {
            return 'Edit / Complete';
        }
        return 'Add Content';
    }
    
    /**
     * Render the modules table
     *
     * @param array $modules The modules data
     */
    private function render_modules_table($modules) {
        $this->load_template('modules-table', [
            'modules' => $modules
        ]);
    }
}

new ACF_Module_Descriptions();
