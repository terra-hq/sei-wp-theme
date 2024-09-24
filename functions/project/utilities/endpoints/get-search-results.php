<?php

/**
 * Retrieves search results based on a keyword from various post types.
 * 
 * This function processes the search request and retrieves posts from specified post types 
 * that match the given keyword. It returns a JSON response with the results or an error if 
 * no results are found.
 * 
 * @param array $request The request parameters, including the search keyword.
 * @return WP_REST_Response The response object containing the search results or error message.
 */

 
function get_search_results($request) {
    $modifiedSpaces = str_replace('%20', ' ', $request['keyword']);
    $search = strtolower($modifiedSpaces);

    $args = array(
        'post_type' => array('page', 'capability', 'industry', 'insight', 'partnerships', 'location'),
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'relevance', 
        'order' => 'ASC', 
    );

    $query = new WP_Query($args);

    if (!$query->have_posts()) {
        return rest_ensure_response(new WP_Error('no_results', 'No results found', array('status' => 404)));
    }

    $results = array();

    while ($query->have_posts()) {
        $query->the_post();

        $post_id = get_the_ID();
        $post_type = get_post_type($post_id);
        $post_title = get_the_title();
        $permalink = get_permalink($post_id);

        $results[] = (object) array(
            'post_type' => $post_type,
            'post_title' => $post_title,
            'permalink' => $permalink,
        );
    }

    wp_reset_postdata();
    return rest_ensure_response($results);
}

new Custom_API_Endpoint((object) array(
    'namespace' => 'wp/v2/tf_api/',
     'route' => '/get_results',
     'method' => 'GET',
     'callback_function' => 'get_search_results',
 ));
?>
