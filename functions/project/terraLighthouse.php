<?php

// Create an instance of the TerraLighthouse class with specified parameters
new TerraLighthouse((object) array(
    'email' => array("eli@terrahq.com", "andres@terrahq.com", "nerea@terrahq.com"),  // Email address to be used in the class
    'interval' => 43200,                // Interval (in seconds) for some functionality in the class (every 12 hours)
    'url' => 'https://www.sei.com/', // !URL to be used in the class, change this accordingly please add wwww always to the URL
));

?>