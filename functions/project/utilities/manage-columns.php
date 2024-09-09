<?php

/**
 * Adds a custom 'Authors' column to the 'insight' post type admin table.
 * 
 * @param array $columns Existing columns.
 * @return array Modified columns with the new 'Authors' column.
 */
function custom_insight_columns($columns) {
    // Add the 'Authors' column to the array of columns.
    $columns['custom_author'] = __('Authors');
    return $columns;
}
add_filter('manage_insight_posts_columns', 'custom_insight_columns'); // Apply the filter to 'insight' post type.

/**
 * Fills the content for the custom 'Authors' column in the 'insight' post type admin table.
 * 
 * @param string $column_name The name of the column.
 * @param int $post_id The ID of the current post.
 */
function custom_insight_column_content($column_name, $post_id) {
    if ($column_name == 'custom_author') {
        // Retrieve the 'author' field for the current post.
        $people = get_field('author', $post_id);
        
        if ($people) {
            $names = array();
            
            // Iterate over the people objects and get their names.
            foreach ($people as $person) {
                $names[] = get_the_title($person->ID);
            }
            
            // Print names separated by commas.
            echo implode(', ', $names);
        } else {
            echo 'No authors'; // Display message if no authors are found.
        }
    }
}
add_action('manage_insight_posts_custom_column', 'custom_insight_column_content', 10, 2); // Apply the action to 'insight' post type.

/**
 * Adds a custom 'Template' column to the 'insight' post type admin table.
 * 
 * @param array $columns Existing columns.
 * @return array Modified columns with the new 'Template' column.
 */
function custom_insight_columns_template($columns) {
    // Add the 'Template' column to the array of columns.
    $columns['template'] = __('Template', 'textdomain');
    return $columns;
}
add_filter('manage_insight_posts_columns', 'custom_insight_columns_template'); // Apply the filter to 'insight' post type.

/**
 * Fills the content for the custom 'Template' column in the 'insight' post type admin table.
 * 
 * @param string $column The name of the column.
 * @param int $post_id The ID of the current post.
 */
function custom_insight_column_content_template($column, $post_id) {
    if ($column === 'template') {
        // Retrieve the template used for the current post.
        $template = get_post_meta($post_id, '_wp_page_template', true);
        if (!empty($template)) {
            echo esc_html($template); // Display the template name.
        } else {
            echo __('default', 'textdomain'); // Display 'default' if no template is set.
        }
    }
}
add_action('manage_insight_posts_custom_column', 'custom_insight_column_content_template', 10, 2); // Apply the action to 'insight' post type.

/**
 * Makes the custom 'Template' column sortable in the 'insight' post type admin table.
 * 
 * @param array $columns Existing sortable columns.
 * @return array Modified columns with the sortable 'Template' column.
 */
function custom_insight_sortable_columns_template($columns) {
    // Make the 'Template' column sortable.
    $columns['template'] = 'template';
    return $columns;
}
add_filter('manage_edit-insight_sortable_columns', 'custom_insight_sortable_columns_template'); // Apply the filter to 'insight' post type.

?>