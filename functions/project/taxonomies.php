<?php
/**
 * Registers the custom taxonomy using the public Custom_Taxonomy class.
 *
 * @return void
 */

new Custom_Taxonomy((object) array(
    'taxonomy' => 'insight-types',
    'object_type' => array('insight'),
    'singular_name' => 'Insight Type',
    'plural_name' => 'Insight Types',
    'args' => (object) array(
        'rewrite' => array('slug' => 'insight-types', 'with_front' => false)
    )
));

// Registering the "Insight Topics" taxonomy
new Custom_Taxonomy((object) array(
    'taxonomy' => 'topics',
    'object_type' => array('insight'),
    'singular_name' => 'Topic',
    'plural_name' => 'Insight Topics',
    'args' => (object) array(
        'rewrite' => array('slug' => 'topics', 'with_front' => false)
    )
));

// Registering the "Case Study Types" taxonomy
new Custom_Taxonomy((object) array(
    'taxonomy' => 'case-study-types',
    'object_type' => array('casestudy'),
    'singular_name' => 'Case Study Type',
    'plural_name' => 'Case Study Types',
    'args' => (object) array(
        'rewrite' => array('slug' => 'case-study-types', 'with_front' => false)
    )
));

// Registering the "Insight Capability" taxonomy
new Custom_Taxonomy((object) array(
    'taxonomy' => 'insight-capability',
    'object_type' => array('insight'),
    'singular_name' => 'Capability',
    'plural_name' => 'Insight Capabilities',
    'args' => (object) array(
        'rewrite' => array('slug' => 'insight-capability', 'with_front' => false)
    )
));

new Custom_Taxonomy((object) array(
    'taxonomy' => 'news-type',
    'object_type' => array('news'),
    'singular_name' => 'Type',
    'plural_name' => 'Types',
    'args' => (object) array(
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'news-type', 'with_front' => false)
    )
));

new Custom_Taxonomy((object) array(
    'taxonomy' => 'service-type',
    'object_type' => array('services'),
    'singular_name' => 'Type',
    'plural_name' => 'Types',
    'args' => (object) array(
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'news-type', 'with_front' => false)
    )
));
new Custom_Taxonomy((object) array(
    'taxonomy' => 'case-study-industry',
    'object_type' => array('case-study'),
    'singular_name' => 'Case Study Industry',
    'plural_name' => 'Case Study Industries',
    'args' => (object) array(
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'case-study-industry', 'with_front' => false)
    )
));
new Custom_Taxonomy((object) array(
    'taxonomy' => 'case-study-capability',
    'object_type' => array('case-study'),
    'singular_name' => 'Case Study Capability',
    'plural_name' => 'Case Study Capabilities',
    'args' => (object) array(
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'case-study-capability', 'with_front' => false)
    )
));




/**
 * Includes a function that creates custom post type links with taxonomy type in the URL.
 * A post of type "insight" with a taxonomy of "Insight Type" will be renamed to /insight/insight-type.
 */
add_filter('post_type_link', 'projectcategory_permalink_structure', 10, 4);

function projectcategory_permalink_structure($post_link, $post, $leavename, $sample) {
    if (false !== strpos($post_link, '%insight-types%')) {
        $projectscategory_type_term = get_the_terms($post->ID, 'insight-types');
        if (!empty($projectscategory_type_term)) {
            $post_link = str_replace('%insight-types%', array_pop($projectscategory_type_term)->slug, $post_link);
        } else {
            $post_link = str_replace('%insight-types%', 'uncategorized', $post_link);
        }
    }
    if (false !== strpos($post_link, '%topics%')) {
        $projectscategory_type_term = get_the_terms($post->ID, 'topics');
        if (!empty($projectscategory_type_term)) {
            $post_link = str_replace('%topics%', array_pop($projectscategory_type_term)->slug, $post_link);
        } else {
            $post_link = str_replace('%topics%', 'uncategorized', $post_link);
        }
    }
    return $post_link;
}

add_action('admin_head', function () {
    $screen = get_current_screen();
    if (isset($screen->taxonomy) && in_array($screen->taxonomy, ['case-study-capability', 'case-study-industry'])) {
        echo '<style>.term-description-wrap {display: none !important;}</style>';
    }
});


?>
