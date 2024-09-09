<?php

class Custom_Taxonomy {
    private $taxonomy;
    private $object_type;
    private $singular_name;
    private $plural_name;
    private $args;

    public function __construct($config) {
        $this->taxonomy = $config->taxonomy;
        $this->object_type = $config->object_type;
        $this->singular_name = $config->singular_name;
        $this->plural_name = $config->plural_name;
        $this->args = $config->args;

        add_action('init', array($this, 'register_taxonomy'));
    }

    public function register_taxonomy() {
        $labels = array(
            'name' => __($this->plural_name, 'SJL'),
            'singular_name' => __($this->singular_name, 'SJL'),
            'search_items' => __('Search ' . $this->plural_name, 'SJL'),
            'all_items' => __('All ' . $this->plural_name, 'SJL'),
            'parent_item' => __('Parent ' . $this->singular_name, 'SJL'),
            'parent_item_colon' => __('Parent ' . $this->singular_name . ':', 'SJL'),
            'edit_item' => __('Edit ' . $this->singular_name, 'SJL'),
            'update_item' => __('Update ' . $this->singular_name, 'SJL'),
            'add_new_item' => __('Add New ' . $this->singular_name, 'SJL'),
            'new_item_name' => __('New ' . $this->singular_name . ' Name', 'SJL'),
            'menu_name' => __($this->plural_name, 'SJL')
        );

        $default_args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_quick_edit' => true,
            'show_in_rest' => true,
            'rewrite' => array('slug' => strtolower(str_replace(' ', '-', $this->singular_name)), 'with_front' => false)
        );

        $args = array_merge($default_args, (array) $this->args);

        register_taxonomy($this->taxonomy, $this->object_type, $args);
    }
}

// Registering the "Insight Types" taxonomy
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
?>
