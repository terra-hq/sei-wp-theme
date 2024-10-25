<?php function remove_editor()
{
    if (isset($_GET['post'])) {
        $id = $_GET['post'];
        $template = get_post_meta($id, '_wp_page_template', true);
        $post = get_post($id);
        switch ($template) {
            case 'page-modules.php':
                remove_post_type_support('page', 'editor');
                break;
            case 'page-home.php':
                remove_post_type_support('page', 'editor');
                break;
            case 'page-index.php':
                remove_post_type_support('page', 'editor');
                break;
            case 'page-capabilities-index.php':
                remove_post_type_support('page', 'editor');
                break;
            case 'page-talk-to-us.php':
                remove_post_type_support('page', 'editor');
                break;
            case 'page-job-detail.php':
                remove_post_type_support('page', 'editor');
                break;
            case 'page-open-positions.php':
                remove_post_type_support('page', 'editor');
                break;
            case 'page-newsroom-index.php':
                remove_post_type_support('page', 'editor');
                break;
            case 'page-awards.php':
                remove_post_type_support('page', 'editor');
                break;
            case 'page-insights.php':
                remove_post_type_support('page', 'editor');
                break;
            default:
                break;
        }
        remove_post_type_support('page', 'thumbnail');
        if ($post->post_type == "testimonial") {
            remove_post_type_support('testimonial', 'editor');
        }

        if ($post->post_type == "news") {
            $terms = get_the_terms($post->ID, 'news-type');
            if ($terms && !is_wp_error($terms)) {
                foreach ($terms as $term) {
                    if ($term->slug === 'external') {
                        remove_post_type_support('news', 'editor');
                        break;
                    }
                }
            }
        }

        if ($post->post_type == "insight") {
            $terms = get_the_terms($post->ID, 'insight-types');
            if ($terms && !is_wp_error($terms)) {
                foreach ($terms as $term) {
                    if ($term->slug === 'case-study') {
                        if (get_field('case_study_type', $post->ID) == 'external') {
                            remove_post_type_support('insight', 'editor');
                            break;
                        }
                    }
                }
            }
        }

        if ($post->post_name == 'about') {
            remove_post_type_support('page', 'editor');
        }
    }
}
add_action('init', 'remove_editor'); ?>