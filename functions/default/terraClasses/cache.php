<?php
/**
 * Terra Cache Headers (Configurable, Self-Documented)
 *
 * PURPOSE
 * -------
 * Centralize HTTP cache header behavior for WordPress sites using a simple,
 * safe-by-default strategy:
 *   - Only run on specific domains you allow (by TLD or exact host).
 *   - Force NO-CACHE on non-production (or when a developer explicitly
 *     bypasses cache) so changes are visible immediately.
 *   - Force NO-CACHE in sensitive contexts (admin, logged-in users, search, 404).
 *   - Enable PUBLIC CACHE with sensible TTLs in production for anonymous users
 *     to reduce origin load (fewer PHP/MySQL hits) and avoid 504 timeouts.
 *
 * WHY THIS MATTERS
 * ----------------
 * Many performance issues (slow pages, 504 errors) come from serving every
 * request dynamically. Correct caching lets proxies/CDNs and browsers reuse
 * responses safely, dramatically lowering server load and speeding up sites.
 *
 * KEY IDEAS
 * ---------
 * - “Page cache” lives at two layers:
 *     * Browser cache → user’s browser reuses content (controlled by `max-age`).
 *     * Proxy/CDN cache (e.g., WP Engine/Varnish/Cloudflare) → shared cache for
 *       many users (controlled by `s-maxage`).
 * - “Sensitive context” (admin/logged-in/search/404): must NOT be cached
 *   because they’re personalized or volatile.
 * - Developer bypass: engineers can temporarily disable cache for themselves
 *   only (param/cookie), without slowing down everyone else.
 *
 * DEV BYPASS (HOW TO)
 * -------------------
 * Two ways to bypass the cache when you need instant changes:
 *
 * 1) Query Parameter:
 *    Add `?dev_nocache=1` to the URL:
 *      https://example.com/?dev_nocache=1
 *    Affects only that request (or any URL where the param is present).
 *
 * 2) Cookie:
 *    Set a cookie so all requests from your browser skip cache:
 *      // Set (enable bypass)
 *      document.cookie = "terra_dev_nocache=1; path=/";
 *
 *      // Remove (disable bypass)
 *      document.cookie = "terra_dev_nocache=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
 *
 *    Bookmarklet (toggle on/off):
 *      javascript:(function(){
 *        if (document.cookie.includes("terra_dev_nocache=1")) {
 *          document.cookie = "terra_dev_nocache=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
 *          alert("terra_dev_nocache REMOVED (cache restored)");
 *        } else {
 *          document.cookie = "terra_dev_nocache=1; path=/";
 *          alert("terra_dev_nocache SET (cache bypass active)");
 *        }
 *      })();
 *
 * RECOMMENDED DEFAULTS
 * --------------------
 * - allowed_tlds: ['com'] → only handle public-facing .com domains by default.
 * - nonprod detection: rely on WP env (wp_get_environment_type()).
 * - TTLs: 5 min (browser), 30 min (CDN) → balance “see changes soon” vs. “good cache hit rate”.
 *
 * MARKERS (OPTIONAL)
 * ------------------
 * For easier debugging, this class can emit:
 *   - Response header:   X-Terra-Cache: PUBLIC | NONPROD | BYPASS | SENSITIVE
 *   - Small HTML comment in <head>: <!-- TERRA CACHE: MODE (...) -->
 * These help confirm which mode is active without guessing.
 */

if ( ! class_exists('Terra_CacheHeaders') ) {

  class Terra_CacheHeaders {

    /**
     * CONFIGURATION
     * -------------
     * Override any of these via the constructor.
     *
     * - max_age / s_maxage:
     *     Browser and Proxy/CDN TTLs. Higher → better cache hit rates, but
     *     changes take longer to show up. Lower → faster changes, fewer hits.
     *
     * - respect_wp_env:
     *     If true and wp_get_environment_type() exists, treat any env that isn’t
     *     'production' as non-prod (e.g., 'staging' or 'development').
     *
     * - allowed_tlds:
     *     Safety switch. Only manage domains that either:
     *        • end with one of these TLDs (e.g. 'com'), or
     *        • match an exact host (e.g. 'localhost', 'ia').
     *     Empty array => apply EVERYWHERE (useful in local/dev).
     *
     * - dev_bypass:
     *     Developer-only no-cache:
     *       • query_param   → e.g., ?dev_nocache=1
     *       • cookie_name   → e.g., terra_dev_nocache
     *       • cookie_value  → e.g., "1"
     *
     * - send_last_modified:
     *     Send Last-Modified based on latest post modification so clients can get
     *     304 Not Modified (bandwidth-friendly).
     *
     * - vary_cookie:
     *     Add "Vary: Cookie" so proxies don’t mix authenticated/anonymous responses.
     *
     * - extra_sensitive_cb:
     *     Optional callback for additional “never cache” rules (return true to force no-cache).
     *
     * - emit_markers:
     *     If true, adds a diagnostic response header and an HTML comment in <head>
     *     indicating the current cache mode (for easier debugging).
     */
    protected $config = [
      // Cache lifetimes
      'max_age'  => 300,   // Browser: 5 minutes
      's_maxage' => 1800,  // Proxy/CDN: 30 minutes

      // Environment detection
      'respect_wp_env' => true,

      // Only apply to these TLDs or exact hosts (safe-by-default)
      // Examples: ['com'] or ['com','localhost','ia']
      'allowed_tlds' => ['com'],

      // Developer bypass
      'dev_bypass' => [
        'query_param'  => 'dev_nocache',
        'cookie_name'  => 'terra_dev_nocache',
        'cookie_value' => '1',
      ],

      // Behavior toggles
      'send_last_modified' => true,
      'vary_cookie'        => true,

      // Custom “never cache” callback: function(): bool { ... }
      'extra_sensitive_cb' => null,

      // Debug markers (header + HTML comment)
      'emit_markers'       => true,
    ];

    /** Human-readable marker for wp_head(), if enabled. */
    protected $marker_message = null;

    /**
     * Constructor
     * @param array $overrides Configuration overrides (see $config doc above).
     */
    public function __construct(array $overrides = []) {
      $this->config = array_replace_recursive($this->config, $overrides);
    }

    /**
     * init()
     * -------
     * Register WordPress hooks. Separate from constructor so projects can
     * configure first and attach hooks afterwards.
     *
     * Hooks:
     * - init:           define WP constants to stop certain caches in non-prod/bypass
     * - send_headers:   send the actual HTTP headers for cache control
     * - wp_head:        (optional) print a debug marker so humans can see the mode
     */
    public function init() {
      add_action('init',         [$this, 'maybe_define_nocache_constants']);
      add_action('send_headers', [$this, 'send_cache_headers'], 0); // run as early as possible
      add_action('wp_head',      [$this, 'emit_head_marker'], 1);
      add_action('wp_footer',    [$this, 'emit_head_marker'], 9999); // fallback if theme lacks wp_head
    }

    /**
     * applies_to_current_site()
     * -------------------------
     * Apply logic only if the current site’s domain ends with one of the allowed TLDs
     * OR matches an allowed exact host.
     *
     * WHY:
     * - In multi-site/multi-account setups, the same code can run on many domains.
     * - We only want to enforce Terra’s caching strategy on the domains we opt-in.
     * - This “opt-in” prevents accidental cache policy changes where they’re not intended.
     *
     * EXAMPLES:
     *   Host: integrityadvocate.com  → matches ['com'] → headers applied.
     *   Host: localhost:8888         → matches ['localhost'] (exact host) → headers applied.
     *   Host: ia:8888                → matches ['ia'] (exact host) → headers applied.
     *   Host: integrityadvocate.net  → not in allowed list → do nothing.
     *
     * @return bool True if we should manage headers for this host.
     */
    protected function applies_to_current_site(): bool {
      $host = $_SERVER['HTTP_HOST'] ?? ($_SERVER['SERVER_NAME'] ?? '');
      if (!$host) return false;

      // Normalize: strip port (e.g., ia:8888 -> ia), lowercase, strip IPv6 brackets
      $host = strtolower($host);
      $host = preg_replace('/:\d+$/', '', $host);
      $host = trim($host, '[]');

      $list = (array) ($this->config['allowed_tlds'] ?? ['com']);

      // Empty list => apply everywhere (useful in local/dev)
      if ($list === []) return true;

      foreach ($list as $item) {
        $item = strtolower(trim((string)$item));
        if ($item === '') continue;

        // 1) Exact host match (covers 'localhost', 'ia', 'example.com' if you want)
        if ($host === $item) return true;

        // 2) TLD suffix match (covers 'com', 'org', etc.)
        //    host ends with ".com", ".org", etc.
        if (preg_match('/\.' . preg_quote($item, '/') . '$/i', $host)) return true;
      }
      return false;
    }

    /**
     * is_nonprod()
     * ------------
     * Determine if this request is running in a non-production environment.
     *
     * We rely on WordPress environment type if available:
     *  - wp_get_environment_type() !== 'production' → non-prod (e.g., 'staging' or 'development').
     *
     * WHY:
     * - In non-prod we want responses to be fresh (NO-CACHE) so developers and QA
     *   see changes immediately without manual purges.
     *
     * @return bool True if considered non-production.
     */
    protected function is_nonprod(): bool {
      if ( ! empty($this->config['respect_wp_env']) && function_exists('wp_get_environment_type') ) {
        return wp_get_environment_type() !== 'production';
      }
      // If WP env is not available, default to "prod" (safer). Local/dev can still bypass via query/cookie.
      return false;
    }

    /**
     * dev_bypass_active()
     * -------------------
     * Check if the current request should skip cache *for this developer only*.
     *
     * HOW:
     * - Query parameter: e.g., `?dev_nocache=1`
     * - Cookie: name/value pair, e.g., `terra_dev_nocache=1`
     *
     * WHY:
     * - Powerful technique to debug/verify changes without turning off cache
     *   for everyone. This keeps production fast for real users.
     *
     * @return bool True if cache should be bypassed for this request/user.
     */
    protected function dev_bypass_active(): bool {
      $q  = $this->config['dev_bypass']['query_param']  ?? 'dev_nocache';
      $cn = $this->config['dev_bypass']['cookie_name']  ?? 'terra_dev_nocache';
      $cv = $this->config['dev_bypass']['cookie_value'] ?? '1';

      $by_query  = $q && isset($_GET[$q]);
      $by_cookie = $cn && !empty($_COOKIE[$cn]) && $_COOKIE[$cn] === $cv;

      return $by_query || $by_cookie;
    }

    /**
     * is_sensitive_context()
     * ----------------------
     * Detect contexts that must NEVER be cached:
     *  - wp-admin screens
     *  - Logged-in users (personalized content)
     *  - Search results (volatile)
     *  - 404 pages (short-lived, often redirect logic follows)
     *  - (Optional) any custom rule you provide via extra_sensitive_cb
     *
     * WHY:
     * - Caching personalized or volatile pages can leak data or show outdated
     *   content. Better to always serve these dynamically.
     *
     * @return bool True if this request is “sensitive” and must be no-cache.
     */
    protected function is_sensitive_context(): bool {
      if ( is_admin() || is_user_logged_in() || is_search() || is_404() ) {
        return true;
      }

      // Extra custom rules provided by the project
      if ( is_callable($this->config['extra_sensitive_cb']) ) {
        try {
          if ( (bool) call_user_func($this->config['extra_sensitive_cb']) ) {
            return true;
          }
        } catch (\Throwable $e) {
          // Do not break header logic due to a callback error
        }
      }

      return false;
    }

    /**
     * maybe_define_nocache_constants()
     * --------------------------------
     * Some WordPress caching plugins/platforms respect special constants that
     * tell them “do not cache this page/DB request”. In non-prod or when a developer
     * bypass is active, define these constants early:
     *
     * - DONOTCACHEPAGE → avoid page cache
     * - DONOTCACHEDB   → avoid DB query cache
     *
     * WHY:
     * - It adds an extra safety net so multiple layers align on “no-cache” mode.
     */
    public function maybe_define_nocache_constants() {
      if ( ! $this->applies_to_current_site() ) return;

      if ( $this->is_nonprod() || $this->dev_bypass_active() ) {
        if ( ! defined('DONOTCACHEPAGE') ) define('DONOTCACHEPAGE', true);
        if ( ! defined('DONOTCACHEDB') )   define('DONOTCACHEDB', true);
      }
    }

    /**
     * send_cache_headers()
     * --------------------
     * The core logic that decides which HTTP headers to send.
     *
     * ORDER OF DECISIONS:
     *  1) If this host doesn’t match allowed list → do nothing (opt-in safety).
     *  2) If sensitive context → force NO-CACHE.
     *  3) If non-prod OR dev bypass → force strong NO-CACHE.
     *  4) Otherwise (production, anonymous) → enable PUBLIC CACHE with TTL.
     *
     * DETAILS:
     * - Sensitive:
     *     Use WordPress’ nocache_headers() and add "Vary: Cookie" to avoid proxy mix-ups.
     *
     * - Non-prod / Bypass:
     *     Send strict headers that prevent any caching:
     *       Cache-Control: no-store, no-cache, must-revalidate, max-age=0
     *       Expires: 0
     *     Optional debug markers: X-Terra-Cache: NONPROD/BYPASS
     *
     * - Production (public/anonymous):
     *     Send shared-cache-friendly headers:
     *       Cache-Control: public, max-age=<browser>, s-maxage=<cdn>, stale-while-revalidate=60
     *     “stale-while-revalidate” lets caches serve slightly stale content while
     *     they fetch a fresh copy in the background (good for perceived speed).
     *
     * - Last-Modified (optional):
     *     Based on latest post modification time. If client sends If-Modified-Since
     *     with the same timestamp, respond 304 (saves bandwidth/CPU).
     */
    public function send_cache_headers() {
      if ( ! $this->applies_to_current_site() ) return;

      $varyCookie  = ! empty($this->config['vary_cookie']);
      $emitMarkers = ! empty($this->config['emit_markers']);

      // Always remove legacy/conflicting headers first
      header_remove('Cache-Control');
      header_remove('Pragma');
      header_remove('Expires');

      // (1) Sensitive contexts → absolutely NO-CACHE
      if ( $this->is_sensitive_context() ) {
        nocache_headers();
        if ( $varyCookie ) header('Vary: Cookie');
        if ( $emitMarkers ) {
          header('X-Terra-Cache: SENSITIVE');
          $this->marker_message = 'TERRA CACHE: SENSITIVE (no-cache)';
        }
        return;
      }

      // (2) Dev/Stage (non-prod) or developer bypass → strong NO-CACHE
      if ( $this->is_nonprod() || $this->dev_bypass_active() ) {
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Expires: 0');
        if ( $varyCookie ) header('Vary: Cookie');
        if ( $emitMarkers ) {
          $mode = $this->dev_bypass_active() ? 'BYPASS' : 'NONPROD';
          header('X-Terra-Cache: ' . $mode);
          $this->marker_message = 'TERRA CACHE: ' . $mode . ' (no-cache)';
        }
        return;
      }

      // (3) Production (public/anonymous visitors): enable cache with TTL.
      /**
       * WHY:
       * - Offload repeated traffic from PHP/MySQL by letting proxies/CDNs serve
       *   cached pages. Browsers also reuse the response for a few minutes.
       * - With short TTLs (e.g., 5m/30m), developers still see changes relatively
       *   soon without manual purges. For critical changes, purge is still possible.
       */
      $max_age  = (int) ($this->config['max_age']  ?? 300);
      $s_maxage = (int) ($this->config['s_maxage'] ?? 1800);

      header('Cache-Control: public, max-age=' . $max_age . ', s-maxage=' . $s_maxage . ', stale-while-revalidate=60');
      if ( $varyCookie ) header('Vary: Cookie');
      if ( $emitMarkers ) {
        header('X-Terra-Cache: PUBLIC');
        $this->marker_message = 'TERRA CACHE: PUBLIC (public cache with TTL)';
      }

      // (4) Optional: 304 support via Last-Modified
      if ( ! empty($this->config['send_last_modified']) ) {
        $last_gmt = get_lastpostmodified('GMT');
        if ( $last_gmt ) {
          $last_modified = gmdate('D, d M Y H:i:s', strtotime($last_gmt)) . ' GMT';
          header("Last-Modified: $last_modified");

          // If the client’s cache matches, we can skip sending the body
          if ( isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && $_SERVER['HTTP_IF_MODIFIED_SINCE'] === $last_modified ) {
            status_header(304);
            exit;
          }
        }
      }
    }

    /**
     * emit_head_marker()
     * ------------------
     * If markers are enabled and a mode marker was set during send_headers(),
     * print a small HTML comment in <head>:
     *   <!-- TERRA CACHE: PUBLIC (public cache with TTL) -->
     *
     * WHY:
     * - Humans can confirm the current cache mode directly from View Source
     *   without digging into Response Headers every time.
     */
    public function emit_head_marker() {
      if ( empty($this->config['emit_markers']) ) return;
      if ( ! $this->applies_to_current_site() ) return;
      if ( ! $this->marker_message ) return;

      echo "\n<!-- " . esc_html($this->marker_message) . " -->\n";
    }
  }

}
