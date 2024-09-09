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


?>