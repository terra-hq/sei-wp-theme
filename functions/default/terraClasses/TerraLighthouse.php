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
require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); // Include WordPress upgrade functions
require get_template_directory() . '/functions/default/terraClasses/lighthouse/getReport.php'; // Include report class
require get_template_directory() . '/functions/default/terraClasses/lighthouse/showTable.php';  // Include table class
require get_template_directory() . '/functions/default/terraClasses/lighthouse/updateMetricWithAjax.php';   // Include AJAX functions
require get_template_directory() . '/functions/default/terraClasses/lighthouse/register-hook.php';
global $terraLighthouse; // Declare a global variable for TerraLighthouse instance

class TerraLighthouse {
    public $interval;  // Interval for the cron job
    public $email;     // Email address to receive notifications
    public $url;       // URL to be analyzed by Lighthouse

    /**
     * Constructor for TerraLighthouse.
     *
     * @param object $config Configuration object containing the interval, email, and URL.
     */
    public function __construct($config) {
        $this->interval = $config->interval; // Set the interval
        $this->email = $config->email;       // Set the email
        $this->url = $config->url;           // Set the URL

        global $terraLighthouse;
        $terraLighthouse = $this; // Assign the instance to the global variable
        
        // Hook to initialize custom functionality
        add_action('init', array($this, 'add_lighthouse_report_menu'));
    }

    /**
     * Adds the Lighthouse report menu and starts the cron job.
     *
     * This method registers the admin menu page and starts the cron job to fetch the Lighthouse reports.
     *
     * @return void
     */
    public function add_lighthouse_report_menu() {
        $this->start_cronjob();       // Initialize the cron job
        if(is_user_logged_in() && is_admin()){
            $this->create_admin_menu_page(); // Create an admin menu page for the report
        } 
    }

    /**
     * Starts a cron job to periodically run the Lighthouse report.
     *
     * @return void
     */
    public function start_cronjob() {
        // Create an instance of the CallCronjob class to manage cron jobs
        // Schedule the cron job with the defined interval and the callback to fetch Lighthouse reports
        $lighthouseCron = new CallCronjob((object) array(
            'cronName' => 'every_twelve_hours',   // Name of the cron job
            'interval' =>  $this->interval,  // Interval (in seconds) for some functionality in the class
            'functionName' => 'lighthouse_report_page_content',   // Function to be executed by the cron job      
        ));
        $lighthouseCron->call_cronjob();
    }

    /**
     * Adds a Lighthouse report page to the WordPress admin panel.
     *
     * @return void
     */
    public function create_admin_menu_page(){
        // Use WordPress's add_menu_page to create a custom admin page
        add_menu_page(
            'Page Speed Report', // Page title in the admin panel
            'Page Speed Report', // Text for the menu item
            'manage_options',    // Capability required to view the menu
            'lighthouse-report', // Slug for the menu page
            'show_table',        // Function to display the content of the page (lighthouse/showTable.php)
            'dashicons-chart-line', // Dashicon icon for the menu item
            100                  // Position in the menu
        );
    }
}
?>
