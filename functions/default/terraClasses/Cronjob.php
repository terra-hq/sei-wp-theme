<?php
/**
 * Class CallCronjob
 *
 * Function to add and execute a custom cron job.
 *
 * @param string $cronName     The name of the cron job.
 * @param int    $interval     The interval in seconds at which the cron job will run.
 * @param string $functionName The name of the function that will be executed by the cron job.
 *
 * @example
 * new CallCronjob((object) array(
 *     'cronName' => 'every_one_hour',       // Name of the cron job
 *     'interval' => 3600,                      // Interval (in seconds) to run the cron job (12 hours)
 *     'functionName' => 'lighthouse_report_page_content' // Function to be executed by the cron job
 * ));
 */
class CallCronjob {
    private $cronName;  // The email message content
    private $interval;    // The recipient's email address
    private $functionName;  // The email subject

    /**
     * Constructor for CallCronjob.
     *
     * @param object $config The configuration object for the mail. It should include the message, email, and subject.
     */
    public function __construct($config) {
        $this->cronName = $config->cronName;  // Set the email message from the configuration
        $this->interval = $config->interval;      // Set the recipient's email from the configuration
        $this->functionName = $config->functionName;  // Set the email subject from the configuration

        add_action('init', array($this, 'call_cronjob'));
    }

    public function call_cronjob() {
        // Add a filter to create a custom cron schedule with the specified interval.
        $cronName = $this->cronName;  
        $interval = $this->interval; 
        add_filter('cron_schedules', function($schedules) use ($cronName, $interval) {
            $schedules[$cronName] = array(
                'interval' => $interval,  // Interval in seconds
                'display'  => 'Every ' . ($interval / 60) . ' minutes'  // Display the interval in minutes
            );
            return $schedules;
        });

        // Check if the cron event is already scheduled.
        if (!wp_next_scheduled('execute_' . $cronName)) {
            // Schedule the cron event to run at the specified interval.
            wp_schedule_event(time(), $cronName, 'execute_' . $cronName);
        }

        // Hook the cron action to the specified function.
        add_action('execute_' . $cronName,  $this->functionName);
    }
}
?>
