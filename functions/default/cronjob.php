<?php

/**
 * Send an alert email when the site indexing status is changed.
 *
 * This function sends an alert email to notify the recipient that the 
 * website's indexing status has been corrected to ensure it is indexed
 * or not indexed as appropriate for the environment.
 *
 * @return void
 */

// Add a custom cron schedule for every thirty minutes
add_filter('cron_schedules', 'add_every_thirty_minutes_cron_schedule');
function add_every_thirty_minutes_cron_schedule($schedules)
{
    $schedules['every_thirty_minutes'] = array(
        'interval' => 1800,
        'display' => __('Every 30 Minutes', 'textdomain')
    );
    return $schedules;
}

// Schedule the custom event if it hasn't been scheduled already
if (!wp_next_scheduled('execute_every_thirty_minutes')) {
    wp_schedule_event(time(), 'every_thirty_minutes', 'execute_every_thirty_minutes');
}

// Hook the custom event to the function
add_action('execute_every_thirty_minutes', 'detect_robot_callback');

function detect_robot_callback()
{
    $home_url = home_url();
    $parsed_url = parse_url($home_url);
    $base_url = $parsed_url['scheme'] . '://' . $parsed_url['host'];
    $site_indexed = get_option('blog_public');

    // Check if the base URL contains the dev identifier string (indicating a dev environment)
    if (strpos($base_url, DEV_IDENTIFIER) === false) {
        if (!$site_indexed) {
            update_option('blog_public', 1); // Set the site to be indexed
            send_alert_email('site_not_indexed', $base_url); // Send an alert email
        }
    } else {
        if ($site_indexed) {
            update_option('blog_public', 0); // Set the site to not be indexed
            send_alert_email('site_indexed', $base_url); // Send an alert email
        }
    }
}

function send_alert_email($status, $url)
{
    $to = array('andres@terrahq.com', 'maria@terrahq.com');
    $subject = '';
    $message = '';

    if ($status == 'site_not_indexed') {
        $subject = 'ALERT: Website ' . $url . ' was not indexed';
        $message = 'The website at ' . $url . ' was not indexed. It has been fixed and now it is indexed as expected.';
    } elseif ($status == 'site_indexed') {
        $subject = 'ALERT: Website ' . $url . ' was indexed';
        $message = 'The website at ' . $url . ' was indexed. It has been fixed and now it is not indexed anymore.';
    }
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
    );
    wp_mail($to, $subject, $message, $headers);
}
