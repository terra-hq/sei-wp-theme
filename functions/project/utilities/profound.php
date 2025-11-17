<?php
/*
Plugin Name: SEI Profound Logger
*/

add_action('wp_footer', function () {

    $data = array(
        'event' => 'page_view',
        'page' => $_SERVER['REQUEST_URI']
    );

    wp_remote_post(
        'https://artemis.api.tryprofound.com/v1/logs/custom',
        array(
            'headers' => array(
                'Content-Type' => 'application/json',
                'x-api-key' => 'bot_81245185-f9e0-4c1d-a36e-a8092dfe730f'
            ),
            'body' => json_encode($data)
        )
    );
});
