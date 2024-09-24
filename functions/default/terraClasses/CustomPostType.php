<?php
/**
 * Class Custom_Post_Type
 *
 * A reusable class for registering custom post types in WordPress.
 * This class allows for dynamic configuration of post types by passing a configuration object during instantiation.
 *
 * @property string $post_type The slug for the custom post type.
 * @property string $singular_name The singular name of the post type.
 * @property string $plural_name The plural name of the post type.
 * @property array|object $args Additional arguments for registering the post type.
 *
 * @method void register_post_type() Registers the post type using the provided configuration.
 *
 * @param object $config An object containing the configuration for the custom post type.
 * @param string $config->post_type The slug for the post type.
 * @param string $config->singular_name The singular label for the post type.
 * @param string $config->plural_name The plural label for the post type.
 * @param array|object $config->args Additional arguments for registering the post type.
 *
 * @example
 * new Custom_Post_Type((object) array(
 *     'post_type' => 'media-and-press',
 *     'singular_name' => 'Media and Press',
 *     'plural_name' => 'Media and Press',
 *     'args' => (object) array(
 *         'menu_icon' => 'dashicons-portfolio',
 *         'rewrite' => array('slug' => 'media-and-press', 'with_front' => false),
 *         'terra_hide_permalink' => true, // Hide the permalink in the editor (true or false)
 *         'terra_hide_preview_button' => true, // Hide the preview button in the editor (true or false)
 *         'terra_hide_seo_columns' => false, // Do not hide SEO columns (true or false)
 *         'terra_redirect' => '/some-page' // Name of the page which should be redirect or a custom funcion name 
 *     )
 * ));
 */

class Custom_Post_Type {
    private $post_type;  // Slug for the custom post type
    private $singular_name;  // Singular name for the custom post type
    private $plural_name;  // Plural name for the custom post type
    private $args;  // Additional arguments for the custom post type

    // Constructor that accepts a configuration object and assigns values to properties
    public function __construct($config) {
        $this->post_type = $config->post_type;
        $this->singular_name = $config->singular_name;
        $this->plural_name = $config->plural_name;
        $this->args = $config->args;

        // WordPress action hook to register the post type when the 'init' action is fired
        add_action('init', array($this, 'register_post_type'));
    }

    // Registers the custom post type in WordPress using the provided or default arguments
    public function register_post_type() {
        $labels = array(
            'name' => __($this->plural_name, get_bloginfo('name')),
            'singular_name' => __($this->singular_name, get_bloginfo('name')),
            'add_new' => __('Add New', get_bloginfo('name')),
            'add_new_item' => __('Add New ' . $this->singular_name, get_bloginfo('name')),
            'edit_item' => __('Edit ' . $this->singular_name, get_bloginfo('name')),
            'new_item' => __('New ' . $this->singular_name, get_bloginfo('name')),
            'all_items' => __('All ' . $this->plural_name, get_bloginfo('name')),
            'view_item' => __('View ' . $this->singular_name, get_bloginfo('name')),
            'search_items' => __('Search ' . $this->plural_name, get_bloginfo('name')),
            'not_found' => __('No ' . $this->singular_name . ' found', get_bloginfo('name')),
            'not_found_in_trash' => __('No ' . $this->plural_name . ' found in Trash', get_bloginfo('name')),
            'parent_item_colon' => '',
            'menu_name' => __($this->plural_name, get_bloginfo('name'))
        );

        // Default arguments for registering the custom post type
        $default_args = array(
            'labels' => $labels,
            'public' => true,
            'capability_type' => 'post',
            'has_archive' => false,
            'hierarchical' => false,
            'show_in_rest' => true,
            'supports' => array('title'),
            'custom_function_call' => $this->terra_custom_functions() // Calls custom functions related to the post type
        );

        // Merges default arguments with any provided in the $args object
        $args = array_merge($default_args, (array) $this->args);

        // Registers the custom post type in WordPress
        register_post_type($this->post_type, $args);
    }

    // Executes custom functions, such as hiding the permalink or preview button based on the configuration
    public function terra_custom_functions() {
        // Hide permalink if configured
        if (isset($this->args->terra_hide_permalink) && $this->args->terra_hide_permalink) {
            $this->terra_hide_permalink_action();
        }
        // Hide preview button if configured
        if (isset($this->args->terra_hide_preview_button) && $this->args->terra_hide_preview_button) {
            $this->terra_hide_preview_button_action();
        }
        // Hide SEO columns if configured
        if (isset($this->args->terra_hide_seo_columns) && $this->args->terra_hide_seo_columns) {
            $this->terra_hide_seo_columns_action();
        }
        // Redirect post type if configured
        if (isset($this->args->terra_redirect)) {
            $this->terra_redirect_action();
        }
    }
    
    // Action that hides the permalink in the editor by adding CSS to the page
    public function terra_hide_permalink_action() {
        if (isset($_GET['post'])) {
            echo '<style>
                    body.post-type-'.$this->post_type . ' #post-body-content  
                    .inside{
                        display:none
                    } 
            </style>';
        }
    }

    // Action that hides the preview button in the editor by adding CSS to the page
    public function terra_hide_preview_button_action() {
        if (isset($_GET['post_type'])) {
            echo '<style>
                    body.post-type-'.$this->post_type . ' 
                    .block-editor-post-preview__button-toggle{
                    display:none !important;
                    }   
                    .row-actions .view { 
                    display:none !important;
                    }
                    .preview.button{
                        display:none !important;
                    }
            </style>';
        }
    }

    // Hides SEO columns by filtering post type columns in the admin area
    public function terra_hide_seo_columns_action() {
        // This function terra_seo_manage_columns is in cleanHouse.php file
        add_filter('manage_edit-' . $this->post_type . '_columns', 'terra_seo_manage_columns');
    }
    
    // Handles redirection for single posts of the custom post type
    public function terra_redirect_action() {

        // Add action for 'template_redirect' to handle redirection logic
        //This ensures that your redirection logic is executed before WordPress renders the page. 
        add_action('template_redirect', function() {
        
            // Check if the function specified in $this->args->terra_redirect exists
            if (function_exists($this->args->terra_redirect)) {
            
                // If the function exists, call it dynamically using call_user_func
                call_user_func($this->args->terra_redirect);
            
            } else {
            
                // Get the queried post type from the WordPress query variables
                $queried_post_type = get_query_var('post_type');
                
                // Check if it's a single post page and if the queried post type matches the custom post type
                if (is_single() && $this->post_type == $queried_post_type) {
                
                    // Sanitize the redirection URL by escaping it
                    $principalUrl = esc_url(home_url($this->args->terra_redirect)); // Redirect URL
                    
                    // Perform a 301 (permanent) redirection to the specified URL
                    wp_redirect($principalUrl, 301);
                    
                    // Exit the script to stop further execution after redirection
                    exit;
                }
            }
        });
    }

}
?>