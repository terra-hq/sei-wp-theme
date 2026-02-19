<?php
new Grammar(array(
        'post_types' => ['page','capabilities', 'insights','industries','functions', 'news','locations','people','services','case-studies','awards','partnerships'],  // Los post types que quieres revisar
        'notify_emails' => ['nerea@terrahq.com','isabel@terrahq.com'], 
        'language' => 'en-US'  ,  
        'spling_api_key' => get_field('spling_api_key', 'options')
));

?>