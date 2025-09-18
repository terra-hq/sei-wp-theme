<?php
/**
 * Cache — Simple & Opinionated (public | developer_bypass | protected)
 * - Emits clear cache headers and a <meta name="x-terra-cache"> with human-ready attributes.
 * - No JSON script is emitted. Always emits the meta tag.
 * - No nonprod logic; environment is controlled via apply_on.
 */

if (!class_exists('Cache')) {
  class Cache {

    protected $config = [
      // Apply on TLDs, exact hosts, or full URLs; [] = all hosts
      'apply_on' => ['com'],

      // TTLs (seconds)
      'time_to_live_browser' => 300,
      'time_to_live_cdn'     => 1800,

      // Developer bypass
      'dev_bypass' => [
        'query_param'  => 'dev_nocache',
        'cookie_name'  => 'terra_dev_nocache',
        'cookie_value' => '1',
      ],

      // Allow caching for logged-in users? (true by default)
      'enable_logged_in' => true,
    ];

    protected $marker_message     = null;
    protected $last_modified_http = null;
    protected $emitted_marker     = false;

    // State reflected in <meta>
    protected $state = [
      'mode'                 => null,   // Fast | bypassFast | Slow
      'cache_status'         => null,   // on | off
      'cache_reason'         => null,   // public | developer_bypass | protected
      'cache_human'          => null,   // human-readable sentence
      'last_modified'        => null,   // HTTP-date GMT
      'time_to_live_browser' => null,   // seconds
      'time_to_live_cdn'     => null,   // seconds
    ];

    public function __construct(array $overrides = []) {
      $this->config = array_replace_recursive($this->config, $overrides);
    }

    public function init() {
      add_action('init',         [$this, 'maybe_define_nocache_constants']);
      add_action('send_headers', [$this, 'send_cache_headers'], 0);
      add_action('wp_head',      [$this, 'emit_head_marker'], 1);
      add_action('wp_footer',    [$this, 'emit_head_marker'], 9999); // fallback
    }

    /** Match current site against apply_on list (TLD, host, or full URL). */
    protected function applies_to_current_site(): bool {
      $host = $_SERVER['HTTP_HOST'] ?? ($_SERVER['SERVER_NAME'] ?? '');
      if (!$host) return false;
      $host = strtolower(preg_replace('/:\d+$/', '', trim($host, '[]')));

      $list = (array) ($this->config['apply_on'] ?? ['com']);
      if ($list === []) return true;

      foreach ($list as $item) {
        $item = strtolower(trim((string)$item));
        if ($item === '') continue;

        if (preg_match('#^https?://#i', $item)) {
          $parsed = parse_url($item, PHP_URL_HOST);
          if ($parsed && $host === strtolower($parsed)) return true;
          continue;
        }
        if ($host === $item) return true;
        if (preg_match('/\.' . preg_quote($item, '/') . '$/i', $host)) return true; // TLD
      }
      return false;
    }

    /** Developer bypass via query param or cookie. */
    protected function dev_bypass_active(): bool {
      $q  = $this->config['dev_bypass']['query_param']  ?? 'dev_nocache';
      $cn = $this->config['dev_bypass']['cookie_name']  ?? 'terra_dev_nocache';
      $cv = $this->config['dev_bypass']['cookie_value'] ?? '1';

      $by_query  = $q && isset($_GET[$q]);
      $by_cookie = $cn && (!empty($_COOKIE[$cn]) && $_COOKIE[$cn] === $cv);

      return $by_query || $by_cookie;
    }

    /** Contexts that should never be cached. */
    protected function is_protected_context(): bool {
      if (is_admin() || is_search() || is_404()) return true;
      if (is_user_logged_in() && empty($this->config['enable_logged_in'])) return true;
      return false;
    }

    /** In protected/bypass contexts: define anti-cache constants for plugins/platforms. */
    public function maybe_define_nocache_constants() {
      if (!$this->applies_to_current_site()) return;
      if ($this->dev_bypass_active() || $this->is_protected_context()) {
        if (!defined('DONOTCACHEPAGE')) define('DONOTCACHEPAGE', true);
        if (!defined('DONOTCACHEDB'))   define('DONOTCACHEDB', true);
      }
    }

    /** Send cache headers + Last-Modified (always). */
    public function send_cache_headers() {
      if (!$this->applies_to_current_site()) return;

      // Remove conflicting headers
      header_remove('Cache-Control');
      header_remove('Pragma');
      header_remove('Expires');

      // Avoid mixing auth/anon variants at proxies
      header('Vary: Cookie');

      // Compute Last-Modified (always)
      $this->last_modified_http = $this->compute_last_modified_http();
      if ($this->last_modified_http) {
        header("Last-Modified: {$this->last_modified_http}");
      }

      $protected = $this->is_protected_context();
      $bypass    = $this->dev_bypass_active();

      if ($protected) {
        $this->send_no_cache_headers();
        $this->set_state_and_markers(
          mode: 'Slow',
          cache_status: 'off',
          cache_reason: 'protected',
          human: '⛔ We are NOT caching (protected context: admin/search/404 or logged-in by settings). Changes are immediate.'
        );
        $this->maybe_respond_304();
        return;
      }

      if ($bypass) {
        $this->send_no_cache_headers();
        $this->set_state_and_markers(
          mode: 'bypassFast',
          cache_status: 'off',
          cache_reason: 'developer_bypass',
          human: '⛔ We are NOT caching (developer bypass). Changes are immediate.'
        );
        $this->maybe_respond_304();
        return;
      }

      // Public caching (production/public path, controlled by apply_on)
      $browser = (int) $this->config['time_to_live_browser'];
      $cdn     = (int) $this->config['time_to_live_cdn'];

      header('Cache-Control: public, max-age=' . $browser . ', s-maxage=' . $cdn . ', stale-while-revalidate=60');

      $mins = function($s){ return max(1, (int)round($s/60)); };
      $this->set_state_and_markers(
        mode: 'Fast',
        cache_status: 'on',
        cache_reason: 'public',
        human: sprintf(
          '✅ We are caching (public). Browser %dm, CDN %dm. Changes may take a few minutes to appear.',
          $mins($browser),
          $mins($cdn)
        )
      );

      $this->maybe_respond_304();
    }

    /** Strong NO-CACHE headers. */
    protected function send_no_cache_headers() {
      nocache_headers();
      header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
      header('Expires: 0');
    }

    /** Set state + comment + response header marker. */
    protected function set_state_and_markers(string $mode, string $cache_status, string $cache_reason, string $human) {
      header('X-Terra-Cache: ' . $mode);

      $lm      = $this->last_modified_http ?: 'n/a';
      $browser = (int) $this->config['time_to_live_browser'];
      $cdn     = (int) $this->config['time_to_live_cdn'];

      // View-source comment
      $this->marker_message = sprintf(
        'TERRA CACHE: %s — %s — Last-Modified: %s — time_to_live_browser: %ss — time_to_live_cdn: %ss',
        $mode,
        $human,
        $lm,
        $browser,
        $cdn
      );

      // Meta state
      $this->state = [
        'mode'                 => $mode,          // Fast | bypassFast | Slow
        'cache_status'         => $cache_status,  // on | off
        'cache_reason'         => $cache_reason,  // public | developer_bypass | protected
        'cache_human'          => $human,         // sentence for PMs
        'last_modified'        => $lm,
        'time_to_live_browser' => $browser,
        'time_to_live_cdn'     => $cdn,
      ];
    }

    /** Emit HTML comment + <meta name="x-terra-cache" ...> once. */
    public function emit_head_marker() {
      if ($this->emitted_marker) return;
      if (!$this->applies_to_current_site()) return;
      if (!$this->marker_message) return;

      // Comment (for view-source)
      echo "\n<!-- " . esc_html($this->marker_message) . " -->\n";

      // META (always; no JSON)
      printf(
        '<meta name="x-terra-cache" ' .
          'data-mode="%s" ' .
          'data-cache_status="%s" ' .
          'data-cache_reason="%s" ' .
          'data-cache_human="%s" ' .
          'data-last_modified="%s" ' .
          'data-time_to_live_browser="%d" ' .
          'data-time_to_live_cdn="%d" ' .
        '/>' . "\n",
        esc_attr($this->state['mode']),
        esc_attr($this->state['cache_status']),
        esc_attr($this->state['cache_reason']),
        esc_attr($this->state['cache_human']),
        esc_attr($this->state['last_modified']),
        (int) $this->state['time_to_live_browser'],
        (int) $this->state['time_to_live_cdn']
      );

      $this->emitted_marker = true;
    }

    /** Compute Last-Modified as HTTP-date (GMT). */
    protected function compute_last_modified_http(): ?string {
      $last_gmt = function_exists('get_lastpostmodified') ? get_lastpostmodified('GMT') : null;
      $ts = $last_gmt ? strtotime($last_gmt) : time();
      if (!$ts) return null;
      return gmdate('D, d M Y H:i:s', $ts) . ' GMT';
    }

    /** If If-Modified-Since matches Last-Modified, return 304. */
    protected function maybe_respond_304() {
      if (!$this->last_modified_http) return;
      if (!isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) return;
      if (trim($_SERVER['HTTP_IF_MODIFIED_SINCE']) === $this->last_modified_http) {
        status_header(304);
        exit;
      }
    }
  }
}