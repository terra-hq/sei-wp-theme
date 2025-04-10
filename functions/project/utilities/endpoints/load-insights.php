<?php

/**
 * Handles AJAX requests to load insights posts.
 * 
 * This function processes the request to load insights posts with filtering and pagination.
 * It generates HTML for the posts and returns it as a JSON response.
 */

add_action('wp_ajax_nopriv_load_insights', 'load_insights');
add_action('wp_ajax_load_insights', 'load_insights');

/**
 * Loads insights posts based on request parameters and outputs HTML for the posts.
 * 
 * This function retrieves posts according to the provided parameters, including post type, 
 * number of posts per page, offset, search term, taxonomies, and more. It also handles 
 * displaying a featured insight and paginated loading of more posts.
 */

function load_insights()
{
    ob_start();
    
    $postType = $_REQUEST['postType'];
    $postsPerPage = $_REQUEST['postPerPage'];
    $offset = $_REQUEST['offset'];
    $searchTerm = $_REQUEST['searchTerm'];
    $taxonomies = $_REQUEST['taxonomies'];
    $disable_lazy_loading_image = true;
    $page_id = $_REQUEST['page_id'];
    $is_load_more = $_REQUEST['isLoadMore'];

    $featured_insight = get_field('featured_insight', $page_id);

    global $my_query;
    $my_query = new WP_Query($myArgs);

    $myArgs = array(
        'post_type' => $postType,
        'offset' => $offset,
        'posts_per_page' => ($is_load_more == 'true') ? $postsPerPage : 7,
        'order' => 'DESC', 
        'orderby' => 'date',
        'post_status' => 'publish',
        's' => $searchTerm,
        'post__not_in' => array($featured_insight[0]->ID),
    );


    if ($taxonomies && count($taxonomies) > 0) {
        $myArgs['tax_query'] = array(
            'relation' => 'AND',
        );

        foreach ($taxonomies as $tax) {
            $taxonomy = key($tax);
            $term = current($tax);

            $myArgs['tax_query'][] = array(
                'taxonomy' => $taxonomy,
                'field' => 'slug',
                'terms' => $term
            );
        }
    }

    $my_query->query($myArgs);

    $myArgs['posts_per_page'] = -1;
    $myArgs['offset'] = 0;
    $posts_count = get_posts($myArgs);
    $published_posts = count($posts_count);
    $index = 0;
    ?>

    <?php if ($is_load_more == 'false' && $published_posts != 0): ?>
    <!-- FEATURED INSIGHT -->
    <div class="f--col-8 f--col-tabletm-12 u--display-flex js--featured-insight">
        <?php
            
            $types = get_the_terms($featured_insight[0]->ID, 'insight-types');
            $title = get_the_title($featured_insight[0]->ID);
            if ($types[0]->name == 'Case Study') {
                if(get_field('case_study_type', $featured_insight[0]->ID) == "external"){
                    $permalink = get_field('download_pdf', $featured_insight[0]->ID);
                    $target = "target='_blank'";
                } else {
                    $permalink = get_permalink($featured_insight[0]->ID);
                    $target = null;
                }
            } else {
                $permalink = get_permalink($featured_insight[0]->ID);
                $target = null;
            }
            $topics = get_the_terms($featured_insight[0]->ID, 'topics');
            $tags = array();
            foreach ($topics as $topic) {
                $tags[] = $topic->name;
            }

            $card = array(
                'ID' => $featured_insight[0]->ID,
                'subtitle' => $types[0]->name,
                'title' => $title,
                'permalink' => $permalink,
                'tags' =>  $tags,
                'target' => $target
            );
            $modifierClass = 'third';
            include (locate_template('components/card/card-l.php', false, false));
        ?>
    </div>
    <?php endif; ?>

    <?php while ($my_query->have_posts()):
        $my_query->the_post(); ?>
        <div class="f--col-4 f--col-tabletm-6 f--col-mobile-12 u--display-flex">
            <!-- INSIGHT CARD -->
            <?php
                $insight_types = get_the_terms($post->ID, 'insight-types');
                if ($insight_types && !is_wp_error($insight_types)) {
                    $insight_type = $insight_types[0];
                    $insight_type_name = $insight_type->name;
                }
                $title = get_the_title($post->ID);
                $topics = get_the_terms($post->ID, 'topics');
                if ($insight_types[0]->name == 'Case Study') {
                    if(get_field('case_study_type', $post->ID) == "external"){
                        $permalink = get_field('download_pdf', $post->ID);
                        $target = "target='_blank'";
                    } else {
                        $permalink = get_permalink($post->ID);
                        $target = null;
                    }
                } else {
                    $permalink = get_permalink($post->ID);
                    $target = null;
                }
                $image = get_post_thumbnail_id($post->ID);
                $lazy_loading = false;
                
                include(locate_template('components/card/card-24.php', false, false));
            ?>
        </div>
        <?php
        if ($index < 5) {
            $index++;
        } else {
            $index = 0;
        }
    ?>
    <?php endwhile; ?>

    <?php wp_reset_postdata();

    $content = ob_get_contents();
    $response = array(
        'html' => $content,
        'postsTotal' => $published_posts,
    );
    ob_end_clean();

    echo json_encode($response);
    die();
}