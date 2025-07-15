<?php

/**
 * Default Theme Functionality Index
 *
 * This file acts as the index for all the default functionalities that come with the theme. 
 * Any changes or additions to the default behavior should be documented here. 
 * When making modifications, please add the 🛠️ Emoji to indicate custom work.
 */

require get_template_directory() . '/functions/default/blocks/block-cta.php'; 
require get_template_directory() . '/functions/default/blocks/block-slider.php'; 
require get_template_directory() . '/functions/default/blocks/block-stats.php'; 
require get_template_directory() . '/functions/default/blocks/block-pills.php'; 
require get_template_directory() . '/functions/default/blocks/block-icon-title.php'; 
require get_template_directory() . '/functions/default/blocks/global/block-footnote.php'; 
require get_template_directory() . '/functions/default/blocks/global/block-highlighted.php'; 

require get_template_directory() . '/functions/default/cleanHouse.php'; 
require get_template_directory() . '/functions/default/terraClasses/index.php'; 
require get_template_directory() . '/functions/default/cronjobSiteIndex.php'; 

?>