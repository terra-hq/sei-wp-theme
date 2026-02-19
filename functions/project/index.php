<?php

/**
 * Main Functionality Index
 *
 * This file serves as the primary index for including various function files within the theme. 
 * It acts as a central point of entry, ensuring that all necessary functionality is properly loaded.
 * To add more functionality to the theme, you would typically include additional files here. 
 * This ensures that any new features or customizations are correctly loaded and integrated with the 
 * existing theme structure.
 */

// Primary Functions
require get_template_directory() . '/functions/project/local-variable.php'; 
require get_template_directory() . '/functions/project/hash.php'; 
require get_template_directory() . '/functions/project/enqueues.php'; 

// Custom post types + custom taxonomies
require get_template_directory() . '/functions/project/post-types.php'; 
require get_template_directory() . '/functions/project/taxonomies.php'; 

// Custom ACF fields
require get_template_directory() . '/functions/project/custom/acf/index.php'; 

// Custom endpoints
require get_template_directory() . '/functions/project/utilities/endpoints/index.php'; 


//Functions specific for this project
require get_template_directory() . '/functions/project/utilities/manage-columns.php';
require get_template_directory() . '/functions/project/utilities/set-cookie.php';
require get_template_directory() . '/functions/project/utilities/login-logo.php';
require get_template_directory() . '/functions/project/utilities/redirect-cpt.php';
require get_template_directory() . '/functions/project/utilities/get-spacing.php';
require get_template_directory() . '/functions/project/utilities/remove-editor.php';

// Lighthouse performance feature
require get_template_directory() . '/functions/project/terraLighthouse.php'; 
require get_template_directory() . '/functions/project/custom-search-module.php'; 
require get_template_directory() . '/functions/project/grammar-spelling.php'; 
require get_template_directory() . '/functions/project/utilities/profound.php'; 
?>