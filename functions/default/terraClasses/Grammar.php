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

    private string|false $api_key;
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

        error_log('Grammar: Initialized - post_types: ' . implode(', ', $this->post_types) . ' | emails: ' . implode(', ', $this->notify_emails));

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
        // Hook for posts/pages/CPTs on publish (schedules async check)
        add_action('transition_post_status', [$this, 'on_post_publish'], 10, 3);

        // Hook for async grammar check via WP Cron (runs in background)
        add_action('grammar_check_async', [$this, 'run_async_check'], 10, 2);

        // Hook for frontend page visits (disabled until credits are available)
        // add_action('template_redirect', [$this, 'on_page_visit']);
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

        // Schedule async grammar check so we don't block Gutenberg's save request
        if (!wp_next_scheduled('grammar_check_async', [$post->ID, $post->post_type])) {
            wp_schedule_single_event(time() + 5, 'grammar_check_async', [$post->ID, $post->post_type]);
        }
    }

    /**
     * Run the grammar check asynchronously via WP Cron.
     *
     * @param int $post_id Post ID.
     * @param string $post_type Post type.
     */
    public function run_async_check(int $post_id, string $post_type): void {
        $post = get_post($post_id);

        if (!$post || $post->post_status !== 'publish') {
            return;
        }

        $post_url = get_permalink($post->ID);

        if (!$post_url) {
            error_log("Grammar: Could not get permalink for post ID {$post->ID}");
            return;
        }

        $this->create_report($post, $post_url);
    }

    /**
     * Triggered on frontend page visit.
     * Creates a Spling report and sends email if issues are found.
     */
    public function on_page_visit(): void {
        $show_debug = is_user_logged_in();

        if ($show_debug) {
            echo '<pre style="background:#222;color:#0f0;padding:10px;font-size:12px;">';
            echo "=== GRAMMAR DEBUG ===\n";
        }

        if (!is_singular($this->post_types)) {
            if ($show_debug) {
                echo "STOP: Not a singular post of configured types\n";
                echo "Current post types config: " . implode(', ', $this->post_types) . "\n";
                echo '</pre>';
            }
            return;
        }

        $post = get_queried_object();

        if (!$post instanceof \WP_Post || $post->post_status !== 'publish') {
            if ($show_debug) {
                echo "STOP: Not a published WP_Post\n";
                echo '</pre>';
            }
            return;
        }

        if ($show_debug) {
            echo "Post: {$post->post_title} (ID: {$post->ID}, type: {$post->post_type}, status: {$post->post_status})\n";
        }

        // Debounce disabled for testing
        $transient_key = 'grammar_checked_' . $post->ID;
        delete_transient($transient_key);

        $post_url = get_permalink($post->ID);

        if (!$post_url) {
            if ($show_debug) {
                echo "STOP: No permalink\n";
                echo '</pre>';
            }
            return;
        }

        if ($show_debug) {
            echo "URL: {$post_url}\n";
            echo "API Key: " . (!empty($this->api_key) ? 'YES (' . strlen($this->api_key) . ' chars)' : 'NO') . "\n";
            echo "Notify emails: " . implode(', ', $this->notify_emails) . "\n";
            echo "Calling Spling API...\n";
        }

        // Create grammar report
        $this->create_report($post, $post_url, $show_debug);

        if ($show_debug) {
            echo '</pre>';
        }
    }

    /**
     * Create a grammar report via Spling API.
     *
     * @param WP_Post $post Post object.
     * @param string $url URL to check.
     */
    protected function create_report(\WP_Post $post, string $url, bool $show_debug = false): void {
        if ($show_debug) echo "[1/5] Creating report...\n";

        $response = $this->api_request('create_report', [
            'website' => home_url(),
            'pages' => [$url],
            'num_unselected_pages' => 0,
            'config' => [
                'preferredLanguage' => $this->language
            ]
        ]);

        if (is_wp_error($response)) {
            if ($show_debug) {
                echo "[2/5] API ERROR: " . $response->get_error_message() . "\n";
                echo "[2/5] Request body sent: " . wp_json_encode([
                    'website' => home_url(),
                    'pages' => [$url],
                    'num_unselected_pages' => 0,
                    'config' => ['preferredLanguage' => $this->language]
                ], JSON_PRETTY_PRINT) . "\n";
            }
            return;
        }

        if ($show_debug) { echo "[2/5] API Response: "; var_dump($response); }

        if (empty($response['uuid'])) {
            if ($show_debug) echo "[2/5] FAIL - No UUID in response\n";
            return;
        }

        $uuid = $response['uuid'];
        if ($show_debug) echo "[3/5] UUID: {$uuid} - Polling report...\n";

        $report = $this->get_report_card_detail($uuid);

        if (is_wp_error($report)) {
            if ($show_debug) echo "[3/5] Report ERROR: " . $report->get_error_message() . "\n";
            return;
        }

        $results = $report['results'] ?? [];
        if ($show_debug) echo "[4/5] Report COMPLETE - " . count($results) . " issue(s) found\n";

        if (!empty($results) && $show_debug) {
            echo "[4/5] Issues:\n";
            foreach ($results as $i => $result) {
                echo "  #{$i}: " . ($result['extracted_word'] ?? 'N/A') . " - " . ($result['is_typo_explanation'] ?? 'N/A') . "\n";
            }
        }

        if (empty($results)) {
            if ($show_debug) echo "[4/5] No issues - Skipping email\n";
            return;
        }

        if ($show_debug) echo "[5/5] Sending email...\n";
        $this->send_notification($post, $url, $uuid, count($results));
        if ($show_debug) echo "[5/5] DONE - Email sent!\n";
    }

    /**
     * Fetch report detail from the Spling API.
     *
     * Polls GET /get_report_card_detail until status is COMPLETE.
     *
     * @param string $uuid Report UUID.
     * @return array|WP_Error Report data or error.
     */
    protected function get_report_card_detail(string $uuid): array|\WP_Error {
        $max_attempts = 10;
        $delay = 5;

        for ($i = 0; $i < $max_attempts; $i++) {
            sleep($delay);

            $response = wp_remote_get(self::API_BASE_URL . '/get_report_card_detail?' . http_build_query(['uuid' => $uuid]), [
                'headers' => [
                    'Authorization' => $this->api_key,
                ],
                'timeout' => 30,
            ]);

            $data = $this->parse_api_response($response);

            if (is_wp_error($data)) {
                return $data;
            }

            if (!empty($data['status']) && $data['status'] === 'COMPLETE') {
                return $data;
            }

            if (!empty($data['status']) && $data['status'] === 'FAILED') {
                return new \WP_Error('spling_report_failed', 'Spling report generation failed.');
            }

            error_log("Grammar: Polling report {$uuid} - attempt " . ($i + 1) . "/{$max_attempts} - status: " . ($data['status'] ?? 'unknown'));
        }

        return new \WP_Error('spling_timeout', 'Report did not complete within the expected time.');
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
            $error_msg = $data['message'] ?? "API returned status code {$code}";
            return new \WP_Error(
                'spling_api_error',
                $error_msg . ' | Raw: ' . $body
            );
        }

        return $data ?? [];
    }

    /**
     * Send email notification with the report link.
     *
     * @param WP_Post $post Post object.
     * @param string $url Checked URL.
     * @param string $uuid Report UUID.
     * @param int $error_count Number of errors found.
     */
    protected function send_notification(\WP_Post $post, string $url, string $uuid, int $error_count): void {
        $report_url = $this->build_report_url($uuid, $url);

        $subject = sprintf('[Grammar Check] %s - %d error(s) found', $post->post_title, $error_count);

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

    /**
     * Build the HTML email message.
     *
     * @param WP_Post $post Post object.
     * @param string $url Checked URL.
     * @param string $report_url Spling report URL.
     * @param int $error_count Number of errors found.
     * @return string HTML message.
     */
    protected function build_email_message(\WP_Post $post, string $url, string $report_url, int $error_count): string {
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
                    <td style='padding: 8px; font-weight: bold;'>Errors Found:</td>
                    <td style='padding: 8px; color: " . ($error_count > 0 ? '#d63638' : '#00a32a') . "; font-weight: bold;'>{$error_count}</td>
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