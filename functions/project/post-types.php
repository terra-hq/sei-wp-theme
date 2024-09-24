<?php
/**
 * Registers the custom post types using the public Custom_Post_Type class..
 *
 * @return void
 */

new Custom_Post_Type((object) array(
    'post_type' => 'capability',
    'singular_name' => 'Capability',
    'plural_name' => 'Capabilities',
    'args' => array(
        'menu_icon' => 'dashicons-welcome-add-page',
        'rewrite' => array('slug' => 'capabilities'),
        'hierarchical' => true,
        'supports' => array('title', 'page-attributes'),
    )
));

new Custom_Post_Type((object) array(
    'post_type' => 'insight',
    'singular_name' => 'Insight',
    'plural_name' => 'Insights',
    'args' => array(
        'menu_icon' => 'dashicons-list-view',
        'rewrite' => array('slug' => 'insights/%insight-types%', 'with_front' => false),
        'supports' => array('title', 'editor', 'thumbnail'),
    )
));

new Custom_Post_Type((object) array(
    'post_type' => 'location',
    'singular_name' => 'Location',
    'plural_name' => 'Locations',
    'args' => array(
        'menu_icon' => 'dashicons-admin-site',
        'rewrite' => array('slug' => 'locations'),
        'supports' => array('title', 'page-attributes'),
    )
));

new Custom_Post_Type((object) array(
    'post_type' => 'industry',
    'singular_name' => 'Industry',
    'plural_name' => 'Industries',
    'args' => array(
        'menu_icon' => 'dashicons-admin-settings',
        'rewrite' => array('slug' => 'industries'),
        'supports' => array('title', 'page-attributes'),
    )
));

new Custom_Post_Type((object) array(
    'post_type' => 'functions',
    'singular_name' => 'Function',
    'plural_name' => 'Functions',
    'args' => array(
        'menu_icon' => 'dashicons-plugins-checked',
        'rewrite' => array('slug' => 'functions'),
        'supports' => array('title', 'page-attributes'),
    )
));

new Custom_Post_Type((object) array(
    'post_type' => 'people',
    'singular_name' => 'People',
    'plural_name' => 'People',
    'args' => array(
        'menu_icon' => 'dashicons-businessperson',
        'rewrite' => array('slug' => 'people', 'with_front' => false),
        'supports' => array('title'),
    )
));

new Custom_Post_Type((object) array(
    'post_type' => 'partnerships',
    'singular_name' => 'Partnership',
    'plural_name' => 'Partnerships',
    'args' => array(
        'menu_icon' => 'dashicons-buddicons-buddypress-logo',
        'rewrite' => array('slug' => 'partnerships'),
        'supports' => array('title', 'page-attributes'),
    )
));

new Custom_Post_Type((object) array(
    'post_type' => 'news',
    'singular_name' => 'New',
    'plural_name' => 'News',
    'args' => array(
        'menu_icon' => 'dashicons-bell',
        'rewrite' => array('slug' => 'news'),
        'supports' => array('title', 'page-attributes', 'editor'),
    )
));

new Custom_Post_Type((object) array(
    'post_type' => 'awards',
    'singular_name' => 'Award',
    'plural_name' => 'Awards',
    'args' => array(
        'menu_icon' => 'dashicons-star-filled',
        'rewrite' => array('slug' => 'awards'),
        'supports' => array('title', 'page-attributes'),
    )
));

add_filter('wpseo_exclude_from_sitemap_by_post_ids', 'exclude_news_from_sitemap');
function exclude_news_from_sitemap($excluded_posts)
{
    $news_query = new WP_Query(
        array(
            'post_type' => 'news',
            'tax_query' => array(
                array(
                    'taxonomy' => 'news-type',
                    'field' => 'slug',
                    'terms' => 'internal',
                    'operator' => 'NOT IN',
                ),
            ),
            'posts_per_page' => -1,
            'fields' => 'ids',
        )
    );

    if ($news_query->have_posts()) {
        foreach ($news_query->posts as $post_id) {
            $excluded_posts[] = $post_id;
        }
    }

    wp_reset_postdata();
    return $excluded_posts;
}

function hide_permalink_metabox()
{
    global $post;

    if ($post->post_type === 'news' && !has_term('internal', 'news-type', $post->ID)) {
        echo '<style>
            #edit-slug-box { 
                display: none; 
            }
            #slugdiv { 
                display: none; 
            }
        </style>';
    }
}
add_action('admin_head', 'hide_permalink_metabox');

?>
