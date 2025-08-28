<?php
/**
 * Custom Functionality Index
 *
 * This file serves as the primary index for including custom class files that extend the functionality of the theme.
 * Each class provides a specific set of features, such as managing custom post types, taxonomies, cron jobs, and API endpoints.
 * By organizing and including these class files here, we ensure that all custom functionality is properly loaded
 * and accessible throughout the theme.
 */

require get_template_directory() . '/functions/default/terraClasses/Cronjob.php'; 
require get_template_directory() . '/functions/default/terraClasses/CustomPostType.php'; 
require get_template_directory() . '/functions/default/terraClasses/CustomTaxonomy.php'; 
require get_template_directory() . '/functions/default/terraClasses/MailTo.php'; 
require get_template_directory() . '/functions/default/terraClasses/TerraLighthouse.php'; 
require get_template_directory() . '/functions/default/terraClasses/Custom_API_Endpoint.php'; 
require get_template_directory() . '/functions/default/terraClasses/Custom_Search_Modules.php'; 
require get_template_directory() . '/functions/default/terraClasses/cache.php'; 
?>
