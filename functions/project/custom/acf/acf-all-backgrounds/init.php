<?php
/**
 * Registration logic for the new ACF field type.
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('init', 'PREFIX_include_acf_field_allbackgroundcolor');
/**
 * Registers the ACF field type.
 */
function PREFIX_include_acf_field_allbackgroundcolor()
{
    if (!function_exists('acf_register_field_type')) {
        return;
    }
    require_once __DIR__ . '/class-PREFIX-acf-field-allbackgroundcolor.php';

    acf_register_field_type('PREFIX_acf_field_allbackgroundcolor');
}
