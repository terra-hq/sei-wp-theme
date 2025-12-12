<?php
/**
 * Visual ACF Modules - Main Controller bootstrap
 */

if (!defined('ABSPATH')) {
    exit;
}

$module_dir = dirname(__FILE__);

require_once $module_dir . '/class-visual-acf-modules.php';

new Visual_ACF_Modules();
