<?php

  // ============================================================================
  // USAGE EXAMPLE
  // ----------------------------------------------------------------------------
  // Put this in a must-use plugin (wp-content/mu-plugins/terra-cache-headers.php)
  // or include it from your theme’s functions.php. Adjust the config if needed.
  // ============================================================================

  (new Terra_CacheHeaders([
    'allowed_tlds'        =>  ['sei.com', 'localhost', 'wp-sei', 'localhost/wp-sei'],
    'nonprod_host_pattern'=> '/wpengine/i',
    'respect_wp_env'      => true, //cambiar a true si se quiere respetar el entorno de WordPress
    'max_age'             => 300, // 60 para desaroll, 300 para produccion
    's_maxage'            => 1800, // 900 para desaroll, 1800 para produccion
    'send_last_modified'  => true,
    'vary_cookie'         => true,
    'emit_markers'        => true,
  ]))->init();

?>