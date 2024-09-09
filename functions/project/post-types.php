<?php

class Custom_Post_Type {
    private $post_type;
    private $singular_name;
    private $plural_name;
    private $args;

    public function __construct($config) {
        $this->post_type = $config->post_type;
        $this->singular_name = $config->singular_name;
        $this->plural_name = $config->plural_name;
        $this->args = $config->args;

        add_action('init', array($this, 'register_post_type'));
    }

    public function register_post_type() {
        $labels = array(
            'name' => __($this->plural_name, 'SEI'),
            'singular_name' => __($this->singular_name, 'SEI'),
            'add_new' => __('Add New', 'SEI'),
            'add_new_item' => __('Add New ' . $this->singular_name, 'SEI'),
            'edit_item' => __('Edit ' . $this->singular_name, 'SEI'),
            'new_item' => __('New ' . $this->singular_name, 'SEI'),
            'all_items' => __('All ' . $this->plural_name, 'SEI'),
            'view_item' => __('View ' . $this->singular_name, 'SEI'),
            'search_items' => __('Search ' . $this->plural_name, 'SEI'),
            'not_found' => __('No ' . $this->singular_name . ' found', 'SEI'),
            'not_found_in_trash' => __('No ' . $this->plural_name . ' found in Trash', 'SEI'),
            'parent_item_colon' => '',
            'menu_name' => __($this->plural_name, 'SEI')
        );

        $default_args = array(
            'labels' => $labels,
            'public' => true,
            'capability_type' => 'post',
            'has_archive' => false,
            'hierarchical' => false,
            'show_in_rest' => true,
            'supports' => array('title')
        );

        $args = array_merge($default_args, (array) $this->args);

        register_post_type($this->post_type, $args);
    }
}

// Creación de instancias para los Custom Post Types
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
        'publicly_queryable' => false,
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
        'publicly_queryable' => false,
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
        'publicly_queryable' => false,
        'supports' => array('title', 'page-attributes'),
    )
));


?>
