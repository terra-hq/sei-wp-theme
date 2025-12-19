<?php
/**
 * Visual ACF Modules - Main Controller
 * 
 * This system enhances the ACF Flexible Content experience by replacing the default
 * dropdown selection with a visual modal interface featuring preview images, search
 * functionality, and comprehensive module documentation.
 * 
 * Key Features:
 * - Visual module selection with preview images
 * - Real-time search and filtering capabilities
 * - Module usage tracking across the entire site
 * - Customizable branding (logos, colors)
 * - Rich text descriptions and documentation
 * - Responsive design with accessibility features
 * 
 * @package Visual_ACF_Modules
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Main Visual ACF Modules Controller
 * 
 * Orchestrates the entire system by loading all necessary components,
 * managing asset dependencies, and ensuring proper initialization order.
 * The class follows a modular architecture pattern for maintainability.
 */
class Visual_ACF_Modules {

    /**
     * Initialize the Visual ACF Modules system
     * 
     * Sets up the complete module ecosystem by loading all endpoints and admin interfaces,
     * then hooks into WordPress to manage asset loading. The order of operations is critical:
     * 1. Load all API endpoints (for AJAX functionality)
     * 2. Load admin interfaces (for management capabilities)
     * 3. Hook asset management to admin_enqueue_scripts
     */
    public function __construct() {
        $this->include_endpoints();
        $this->include_admin_pages();
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    /**
     * Load all API endpoint handlers
     * 
     * These endpoints provide the AJAX functionality that powers the modal interface.
     * Each endpoint handles specific data operations and follows WordPress AJAX conventions.
     * The endpoints are loaded early to ensure they're available when needed.
     */
    private function include_endpoints() {
        require_once __DIR__ . '/endpoints/get-preview-images.php';
        require_once __DIR__ . '/endpoints/get-module-usage.php';
        require_once __DIR__ . '/endpoints/get-modal-templates.php';
        require_once __DIR__ . '/endpoints/get-module-description.php';
        require_once __DIR__ . '/endpoints/upload-module-preview.php';
        require_once __DIR__ . '/endpoints/get-admin-templates.php';
        require_once __DIR__ . '/endpoints/get-branding-logo.php';
        require_once __DIR__ . '/endpoints/get-modal-background.php';
    }

    /**
     * Load administrative interface components
     * 
     * These classes create the WordPress admin pages that allow administrators
     * to manage module descriptions, upload preview images, and customize the
     * modal appearance. Each class is self-contained and registers its own hooks.
     */
    private function include_admin_pages() {
        require_once __DIR__ . '/admin/module-descriptions.php';
        require_once __DIR__ . '/admin/modal-customization.php';
    }

    /**
     * Intelligent Asset Management System
     * 
     * This method implements a sophisticated asset loading strategy that ensures optimal
     * performance and prevents conflicts. It handles:
     * 
     * 1. Dynamic path resolution for flexible deployment environments
     * 2. File-based cache busting using modification timestamps
     * 3. Dependency management to ensure proper loading order
     * 4. Conditional loading based on admin page context
     * 5. WordPress media library integration for admin interfaces
     * 
     * The loading strategy is critical for system functionality:
     * - API Service must load first (provides AJAX communication layer)
     * - Main modal JS depends on API Service (handles user interactions)
     * - CSS files are loaded independently for parallel processing
     * - Admin-specific assets only load on relevant pages (performance optimization)
     * 
     * @param string $hook WordPress admin page hook identifier
     */
    public function enqueue_assets($hook) {
        if (!is_admin()) {
            return;
        }

        /**
         * Dynamic Path Resolution
         * 
         * Calculates module paths dynamically to support various deployment scenarios:
         * - Development environments with different directory structures
         * - Production environments with CDN or asset optimization
         * - Multi-site installations with varying theme locations
         */
        $module_base_dir = dirname(__FILE__);
        $module_base_url = str_replace(get_template_directory(), get_template_directory_uri(), $module_base_dir);
        
        /**
         * File-Based Cache Busting Strategy
         * 
         * Uses file modification timestamps for versioning instead of static version numbers.
         * This approach provides several advantages:
         * - Automatic cache invalidation when files are updated
         * - No manual version number management required
         * - Efficient browser caching for unchanged files
         * - Fallback to semantic versioning if files don't exist
         */
        $api_service_version = file_exists($module_base_dir . '/assets/js/api-service.js') 
            ? filemtime($module_base_dir . '/assets/js/api-service.js') 
            : '1.0.0';
            
        $js_version = file_exists($module_base_dir . '/assets/js/acf-flexible-modal.js') 
            ? filemtime($module_base_dir . '/assets/js/acf-flexible-modal.js') 
            : '1.0.0';
        
        $css_main_version = file_exists($module_base_dir . '/assets/css/acf-flexible-modal.css') 
            ? filemtime($module_base_dir . '/assets/css/acf-flexible-modal.css') 
            : '1.0.0';
            
        $css_usage_version = file_exists($module_base_dir . '/assets/css/usage-modal.css') 
            ? filemtime($module_base_dir . '/assets/css/usage-modal.css') 
            : '1.0.0';

        /**
         * Core JavaScript Assets - Critical Loading Order
         * 
         * The API Service MUST be loaded first as it provides the communication layer
         * that all other components depend on. This creates a stable foundation for
         * the entire system's AJAX functionality.
         */
        wp_register_script(
            'acf-api-service',
            $module_base_url . '/assets/js/api-service.js',
            [],
            $api_service_version,
            true
        );
        wp_enqueue_script('acf-api-service');

        /**
         * Main Modal Interface Controller
         * 
         * Handles all user interactions with the modal system. Explicitly depends
         * on the API service to ensure proper initialization order and prevent
         * JavaScript errors from undefined dependencies.
         */
        wp_register_script(
            'acf-visual-modules',
            $module_base_url . '/assets/js/acf-flexible-modal.js',
            ['acf-api-service'],
            $js_version,
            true
        );
        wp_enqueue_script('acf-visual-modules');

        /**
         * Core Stylesheet Assets
         * 
         * CSS files are loaded without dependencies to allow parallel processing
         * and faster page rendering. Each stylesheet handles specific UI components.
         */
        wp_register_style(
            'acf-visual-modules',
            $module_base_url . '/assets/css/acf-flexible-modal.css',
            [],
            $css_main_version
        );
        wp_enqueue_style('acf-visual-modules');

        wp_register_style(
            'acf-usage-modal',
            $module_base_url . '/assets/css/usage-modal.css',
            [],
            $css_usage_version
        );
        wp_enqueue_style('acf-usage-modal');

        /**
         * Admin-Specific Asset Loading
         * 
         * Conditional loading strategy that only includes admin interface assets
         * on relevant pages. This prevents unnecessary resource loading and potential
         * conflicts on other admin pages.
         */
        if ($hook === 'toplevel_page_acf-module-descriptions' || $hook === 'module-docs_page_acf-modal-customization') {
            $css_responsive_version = file_exists($module_base_dir . '/assets/css/module-descriptions-responsive.css') 
                ? filemtime($module_base_dir . '/assets/css/module-descriptions-responsive.css') 
                : '1.0.0';
                
            $css_admin_version = file_exists($module_base_dir . '/assets/css/module-descriptions-admin.css') 
                ? filemtime($module_base_dir . '/assets/css/module-descriptions-admin.css') 
                : '1.0.0';
                
            $css_customization_version = file_exists($module_base_dir . '/assets/css/modal-customization-admin.css') 
                ? filemtime($module_base_dir . '/assets/css/modal-customization-admin.css') 
                : '1.0.0';
                
            $js_admin_version = file_exists($module_base_dir . '/assets/js/module-descriptions-admin.js') 
                ? filemtime($module_base_dir . '/assets/js/module-descriptions-admin.js') 
                : '1.0.0';
                
            $js_customization_version = file_exists($module_base_dir . '/assets/js/modal-customization-admin.js') 
                ? filemtime($module_base_dir . '/assets/js/modal-customization-admin.js') 
                : '1.0.0';
            
            // Register responsive styles
            wp_register_style(
                'acf-module-descriptions-responsive',
                $module_base_url . '/assets/css/module-descriptions-responsive.css',
                [],
                $css_responsive_version
            );
            wp_enqueue_style('acf-module-descriptions-responsive');
            
            // Register admin styles
            wp_register_style(
                'acf-module-descriptions-admin',
                $module_base_url . '/assets/css/module-descriptions-admin.css',
                [],
                $css_admin_version
            );
            wp_enqueue_style('acf-module-descriptions-admin');
            
            // Register customization styles
            wp_register_style(
                'acf-modal-customization-admin',
                $module_base_url . '/assets/css/modal-customization-admin.css',
                [],
                $css_customization_version
            );
            wp_enqueue_style('acf-modal-customization-admin');
            
            // Register customization admin script
            if ($hook === 'module-docs_page_acf-modal-customization') {
                wp_register_script(
                    'acf-modal-customization-admin',
                    $module_base_url . '/assets/js/modal-customization-admin.js',
                    [],
                    $js_customization_version,
                    true
                );
                wp_enqueue_script('acf-modal-customization-admin');
            }

            wp_enqueue_media();
            wp_enqueue_script(
                'acf-module-descriptions-admin',
                $module_base_url . '/assets/js/module-descriptions-admin.js',
                ['acf-api-service'],
                $js_admin_version,
                true
            );

            wp_localize_script('acf-module-descriptions-admin', 'acf_module_admin', [
                'nonce' => wp_create_nonce('module_preview_upload'),
                'ajax_url' => admin_url('admin-ajax.php'),
            ]);
        }
    }
}
