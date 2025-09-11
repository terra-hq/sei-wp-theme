<?php

/**
 * Main Custom Endpoints Index
 *
 * This file serves as the primary index for including various custom REST API endpoints within the theme.
 * It acts as a central point of entry, ensuring that all necessary functionality related to custom 
 * endpoints is properly loaded.
 * To add more functionality or new endpoints to the theme, you would typically include additional files here.
 * This ensures that any new features or customizations are correctly loaded and integrated with the 
 * existing theme structure.
 */

 require get_template_directory() . '/functions/project/utilities/endpoints/get-dropdowns.php'; 
 require get_template_directory() . '/functions/project/utilities/endpoints/get-jobs.php'; 
 require get_template_directory() . '/functions/project/utilities/endpoints/get-news.php'; 
 require get_template_directory() . '/functions/project/utilities/endpoints/get-search-results.php'; 
 require get_template_directory() . '/functions/project/utilities/endpoints/load-insights.php'; 
 require get_template_directory() . '/functions/project/utilities/endpoints/load-case-studies.php';

?>
