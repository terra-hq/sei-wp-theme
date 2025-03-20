<?php
/**
 * Create an instance of the TerraLighthouse class with specified parameters
 *
 * This creates an object of TerraLighthouse class and configures it with
 * email, interval, and URL parameters. This instance will be used to
 * handle Lighthouse reports and scheduling tasks.
 * 
 * Uncomment this block if you want to initialize TerraLighthouse with the given parameters.
 * 
 * Example usage:
 * $lightHouse = new TerraLighthouse((object) array(
 *     'email' => 'XXX@terrahq.com',  // Email address to receive notifications
 *     'interval' => 360,                // Interval (in seconds) for scheduling the cron job
 *     'url' => 'https://www.XXXX.com/',  // URL to be analyzed by Lighthouse
 * ));
 */

global $custom_module; // Declare a global variable for TerraLighthouse instance

require get_template_directory() . '/functions/default/terraClasses/search_modules/search_modules.php'; // Include report class
class Custom_Search_Modules {
    public $interval;  // Interval for the cron job
    public $email;     // Email address to receive notifications
    public $url;       // URL to be analyzed by Lighthouse

    /**
     * Constructor for TerraLighthouse.
     *
     * @param object $config Configuration object containing the interval, email, and URL.
     */
    public function __construct($config) {
        global $custom_module;
        $custom_module = $this; // Assign the instance to the global variable
        add_action('init', array($this, 'add_search_module_table'));
    }

    /**
     * Adds the Lighthouse report menu and starts the cron job.
     *
     * This method registers the admin menu page and starts the cron job to fetch the Lighthouse reports.
     *
     * @return void
     */
    public function add_search_module_table() {
        if(is_user_logged_in() && is_admin()){
            wp_enqueue_style('search-module-style', get_template_directory_uri() . '/functions/default/terraClasses/search_modules/style.css');
            $this->create_search_module_page(); // Create an admin menu page for the report
        } 
    }

    /**
     * Adds a Lighthouse report page to the WordPress admin panel.
     *
     * @return void
     */
    public function create_search_module_page(){
        // Use WordPress's add_menu_page to create a custom admin page
        add_menu_page(
            'Search modules', // Page title in the admin panel
            'Search modules', // Text for the menu item
            'manage_options',    // Capability required to view the menu
            'custom_search_module', // Slug for the menu page
            'show_custom_search_module',        // Function to display the content of the page (lighthouse/showTable.php)
            'dashicons-search', // Dashicon icon for the menu item
            101                  // Position in the menu
        );
    }
}
?>
