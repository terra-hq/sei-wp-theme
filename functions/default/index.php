<?php

/**
 * Default Theme Functionality Index
 *
 * This file acts as the index for all the default functionalities that come with the theme. 
 * Any changes or additions to the default behavior should be documented here. 
 * When making modifications, please add the 🛠️ Emoji to indicate custom work.
 */

require get_template_directory() . '/functions/default/cronjob.php'; 
require get_template_directory() . '/functions/default/cleanHouse.php'; 
require get_template_directory() . '/functions/default/blocks/block-cta.php'; 

?>