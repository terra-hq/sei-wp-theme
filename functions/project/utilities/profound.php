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
        'https://artemis.api.tryprofound.com/v1/logs/wordpress',
        array(
            'headers' => array(
                'Content-Type' => 'application/json',
                'x-api-key' => get_field('profound_api_key', 'options'),
            ),
            'body' => json_encode($data)
        )
    );
});
