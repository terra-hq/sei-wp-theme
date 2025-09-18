<?php

  // ============================================================================
  // USAGE EXAMPLE
  // ----------------------------------------------------------------------------
  // Put this in a must-use plugin (wp-content/mu-plugins/terra-cache-headers.php)
  // or include it from your theme’s functions.php. Adjust the config if needed.
  // ============================================================================

  (new Cache([
    'apply_on' => [
      'https://sei.com',
      'https://stagesei.wpengine.com/',
      'https://seidevelopment.wpengine.com/',
      'http://localhost/wp-sei/', // localhost
    ],
    'time_to_live_browser' => 300,
    'time_to_live_cdn'     => 1800,
    'enable_logged_in'     => false,
  ]))->init();

?>