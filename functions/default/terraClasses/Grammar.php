<?php
/**
 * Grammar Class
 *
 * Validates grammar and spelling on published posts and taxonomy archives
 * using the Spling API. Sends email notifications with the report.
 *
 * Requires:
 * - SPLING_API_KEY constant defined (or set via options)
 * - MailTo class for email notifications
 *
 * @package TerraFramework
 * @since 1.0.0
 *
 * @example
 * // Define API key in wp-config.php or theme config
 * define('SPLING_API_KEY', 'your_api_key_here');
 *
 * // Instantiate in theme setup
 * new Grammar([
 *     'post_types' => ['post', 'page'],
 *     'taxonomies' => ['category', 'post_tag'],
 *     'notify_emails' => ['editor@example.com', 'writer@example.com'],
 *     'language' => 'en-US'
 * ]);
 */
class Grammar {

    private const API_BASE_URL = 'https://api.spl.ing/v1.0';

    private string $api_key;
    private array $post_types;
    private array $taxonomies;
    private array $notify_emails;
    private string $language;

    /**
     * Constructor for Grammar.
     *
     * @param array $config Configuration options:
     *   - post_types: Array of post types to check (default: ['post', 'page'])
     *   - taxonomies: Array of taxonomies to check (default: [])
     *   - notify_emails: Array of emails to send reports (default: [admin email])
     *   - language: Preferred language for checking (default: 'en-US')
     */
    public function __construct(array $config = []) {
        // Try constant first, then helper function
        $spling_api_key = $config['spling_api_key'] ?? false;
        $this->api_key = $spling_api_key;
        $this->post_types = $config['post_types'] ?? ['any'];
        $this->taxonomies = $config['taxonomies'] ?? [];
        $this->notify_emails = $config['notify_emails'] ?? [get_option('admin_email')];
        $this->language = $config['language'] ?? 'en-US';

        if (empty($this->api_key)) {
            error_log('Grammar: Spling API key not found. Grammar checking disabled.');
            return;
        }

        $this->init();
    }

    /**
     * Build the Spling report card URL.
     *
     * @param string $uuid Report UUID.
     * @return string Full report card URL.
     */
    private function build_report_url(string $uuid, string $url): string {
        return "https://www.spl.ing/report-card/?website={$url}&uuid={$uuid}";
    }

    /**
     * Initialize hooks.
     */
    protected function init(): void {
        // Hook for posts/pages/CPTs
        add_action('transition_post_status', [$this, 'on_post_publish'], 10, 3);
    }


    /**
     * Triggered when post status changes.
     * Only runs when post is published (new or updated).
     *
     * @param string $new_status New post status.
     * @param string $old_status Old post status.
     * @param WP_Post $post Post object.
     */
    public function on_post_publish(string $new_status, string $old_status, \WP_Post $post): void {
        // Only check on publish
        if ($new_status !== 'publish') {
            return;
        }

        // Check if post type should be validated
        if (!in_array($post->post_type, $this->post_types, true)) {
            return;
        }

        error_log("Grammar: Post publish detected - '{$post->post_title}' (type: {$post->post_type}, status: {$new_status})");

        // Get the post URL
        $post_url = get_permalink($post->ID);

        if (!$post_url) {
            error_log("Grammar: Could not get permalink for post ID {$post->ID}");
            return;
        }

        // Create grammar report
        $this->create_report($post, $post_url);
    }

    /**
     * Create a grammar report via Spling API.
     *
     * @param WP_Post $post Post object.
     * @param string $url URL to check.
     */
    protected function create_report(\WP_Post $post, string $url): void {
        $response = $this->api_request('create_report', [
            'website' => home_url(),
            'pages' => [$url],
            'num_unselected_pages' => 0,
            'config' => [
                'preferredLanguage' => $this->language
            ]
        ]);

        if (is_wp_error($response)) {
            error_log('Grammar: API error - ' . $response->get_error_message());
            return;
        }

        if (!empty($response['uuid'])) {
            // 🔧 Modified: Schedule report check instead of sending email immediately
            $this->schedule_report_check($post->ID, $url, $response['uuid']);
        } else {
            error_log('Grammar: API response did not contain a UUID. Response: ' . wp_json_encode($response));
        }
    }

    // 🔧 Added: Schedule a delayed check for the report results
    /**
     * Schedule a WP cron event to check the report after a delay.
     *
     * @param int $post_id Post ID.
     * @param string $url Checked URL.
     * @param string $uuid Report UUID.
     * @param int $attempt Current attempt number (default 1).
     */
    protected function schedule_report_check(int $post_id, string $url, string $uuid, int $attempt = 1): void {
        $delay = 60; // seconds to wait before checking

        wp_schedule_single_event(
            time() + $delay,
            'grammar_check_report',
            [$post_id, $url, $uuid, $attempt]
        );

        error_log("Grammar: Scheduled report check for post ID {$post_id} (attempt {$attempt}, UUID: {$uuid})");
    }

    // 🔧 Added: Check report results and notify only if errors found
    /**
     * Check a Spling report for errors and send notification if issues are found.
     * Called via WP cron after report creation.
     *
     * @param int $post_id Post ID.
     * @param string $url Checked URL.
     * @param string $uuid Report UUID.
     * @param int $attempt Current attempt number.
     */
    public function check_report_and_notify(int $post_id, string $url, string $uuid, int $attempt = 1): void {
        $max_attempts = 5;

        $report = $this->api_get_request("get_report/{$uuid}");

        if (is_wp_error($report)) {
            error_log('Grammar: Error fetching report - ' . $report->get_error_message());
            return;
        }

        // If report is still processing, reschedule
        $status = $report['status'] ?? '';
        if ($status === 'processing' || $status === 'pending') {
            if ($attempt < $max_attempts) {
                error_log("Grammar: Report still processing for post ID {$post_id} (attempt {$attempt}/{$max_attempts})");
                $this->schedule_report_check($post_id, $url, $uuid, $attempt + 1);
            } else {
                error_log("Grammar: Max attempts reached for post ID {$post_id}. Report UUID: {$uuid}");
            }
            return;
        }

        // Check if report contains errors
        $error_count = $this->count_report_errors($report);

        if ($error_count === 0) {
            error_log("Grammar: No errors found for post ID {$post_id}. Email not sent.");
            return;
        }

        error_log("Grammar: {$error_count} error(s) found for post ID {$post_id}. Sending notification.");

        $post = get_post($post_id);
        if (!$post) {
            error_log("Grammar: Post ID {$post_id} not found. Cannot send notification.");
            return;
        }

        $this->send_notification($post, $url, $uuid, $error_count, $report);
    }

    // 🔧 Added: Count errors in a report
    /**
     * Count errors/issues in a Spling report.
     *
     * @param array $report Report data from API.
     * @return int Number of errors found.
     */
    protected function count_report_errors(array $report): int {
        $count = 0;

        // Check for issues in pages array
        if (!empty($report['pages']) && is_array($report['pages'])) {
            foreach ($report['pages'] as $page) {
                if (!empty($page['issues']) && is_array($page['issues'])) {
                    $count += count($page['issues']);
                }
            }
        }

        // Fallback: check top-level issues or error_count
        if ($count === 0 && isset($report['error_count'])) {
            $count = (int) $report['error_count'];
        }

        if ($count === 0 && !empty($report['issues']) && is_array($report['issues'])) {
            $count = count($report['issues']);
        }

        return $count;
    }

    // 🔧 Added: GET request method for fetching reports
    /**
     * Make a GET request to the Spling API.
     *
     * @param string $endpoint API endpoint (without base URL).
     * @return array|WP_Error Response data or error.
     */
    protected function api_get_request(string $endpoint): array|\WP_Error {
        $response = wp_remote_get(self::API_BASE_URL . '/' . $endpoint, [
            'headers' => [
                'Authorization' => $this->api_key,
                'Content-Type' => 'application/json',
            ],
            'timeout' => 30,
        ]);

        return $this->parse_api_response($response);
    }

    /**
     * Make a POST request to the Spling API.
     *
     * @param string $endpoint API endpoint (without base URL).
     * @param array $body Request body.
     * @return array|WP_Error Response data or error.
     */
    protected function api_request(string $endpoint, array $body = []): array|\WP_Error {
        $response = wp_remote_post(self::API_BASE_URL . '/' . $endpoint, [
            'headers' => [
                'Authorization' => $this->api_key,
                'Content-Type' => 'application/json',
            ],
            'body' => wp_json_encode($body),
            'timeout' => 30,
        ]);

        return $this->parse_api_response($response);
    }

    /**
     * Parse an API response.
     *
     * @param array|WP_Error $response wp_remote response.
     * @return array|WP_Error Parsed data or error.
     */
    private function parse_api_response($response): array|\WP_Error {
        if (is_wp_error($response)) {
            return $response;
        }

        $code = wp_remote_retrieve_response_code($response);
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        if ($code < 200 || $code >= 300) {
            return new \WP_Error(
                'spling_api_error',
                $data['message'] ?? "API returned status code {$code}"
            );
        }

        return $data ?? [];
    }

    // 🔧 Modified: Added error_count and report parameters
    /**
     * Send email notification with the report link.
     *
     * @param WP_Post $post Post object.
     * @param string $url Checked URL.
     * @param string $uuid Report UUID.
     * @param int $error_count Number of errors found.
     * @param array $report Full report data.
     */
    protected function send_notification(\WP_Post $post, string $url, string $uuid, int $error_count = 0, array $report = []): void {
        $report_url = $this->build_report_url($uuid, $url);

        $subject = sprintf('[Grammar Check] %s - %d issue(s) found', $post->post_title, $error_count);

        $message = $this->build_email_message($post, $url, $report_url, $error_count);

        foreach ($this->notify_emails as $email) {
            new MailTo((object) [
                'email' => $email,
                'subject' => $subject,
                'message' => $message,
            ]);
        }

        error_log("Grammar: Report created for '{$post->post_title}' - {$report_url}");
    }

    // 🔧 Modified: Added error_count parameter and display in email
    /**
     * Build the HTML email message.
     *
     * @param WP_Post $post Post object.
     * @param string $url Checked URL.
     * @param string $report_url Spling report URL.
     * @param int $error_count Number of errors found.
     * @return string HTML message.
     */
    protected function build_email_message(\WP_Post $post, string $url, string $report_url, int $error_count = 0): string {
        return "
        <html>
        <body style='font-family: Arial, sans-serif; line-height: 1.6;'>
            <h2>Grammar Check Report</h2>
            <p>A grammar and spelling check has been completed for the following content:</p>

            <table style='border-collapse: collapse; margin: 20px 0;'>
                <tr>
                    <td style='padding: 8px; font-weight: bold;'>Post Title:</td>
                    <td style='padding: 8px;'>{$post->post_title}</td>
                </tr>
                <tr>
                    <td style='padding: 8px; font-weight: bold;'>Post Type:</td>
                    <td style='padding: 8px;'>{$post->post_type}</td>
                </tr>
                <tr>
                    <td style='padding: 8px; font-weight: bold;'>URL:</td>
                    <td style='padding: 8px;'><a href='{$url}'>{$url}</a></td>
                </tr>
                <tr>
                    <td style='padding: 8px; font-weight: bold;'>Author:</td>
                    <td style='padding: 8px;'>" . get_the_author_meta('display_name', $post->post_author) . "</td>
                </tr>
                <tr>
                    <td style='padding: 8px; font-weight: bold;'>Issues Found:</td>
                    <td style='padding: 8px; color: #d63638; font-weight: bold;'>{$error_count}</td>
                </tr>
            </table>

            <p style='margin: 20px 0;'>
                <a href='{$report_url}'
                   style='background-color: #0073aa; color: white; padding: 12px 24px;
                          text-decoration: none; border-radius: 4px; display: inline-block;'>
                    View Full Report
                </a>
            </p>

            <p style='color: #666; font-size: 12px;'>
                This is an automated message from the Grammar Check system powered by Spling.
            </p>
        </body>
        </html>
        ";
    }

}
