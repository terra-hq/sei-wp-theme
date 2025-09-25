<?php

/**
 * Handles AJAX requests to load case studies posts.
 * 
 * This function processes the request to load case studies posts with filtering and pagination.
 * It generates HTML for the posts and returns it as a JSON response.
 */

add_action('wp_ajax_nopriv_load_case_studies', 'load_case_studies');
add_action('wp_ajax_load_case_studies', 'load_case_studies');

/**
 * Loads case studies posts based on request parameters and outputs HTML for the posts.
 * 
 * This function retrieves posts according to the provided parameters, including post type, 
 * number of posts per page, offset, search term, taxonomies, and more. It also handles 
 * displaying a featured case study and paginated loading of more posts.
 */

function load_case_studies()
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

    $featured_case_study = get_field('featured_case_study', $page_id);

    global $my_query;
    $my_query = new WP_Query($myArgs);

    $myArgs = array(
        'post_type' => $postType,
        'offset' => $offset,
        'posts_per_page' => ($is_load_more == 'true') ? $postsPerPage : 6,
        'order' => 'DESC', 
        'orderby' => 'date',
        'post_status' => 'publish',
        's' => $searchTerm,
        'post__not_in' => $featured_case_study ? array($featured_case_study[0]->ID) : array(),
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

    <?php if ($is_load_more == 'false' && $published_posts != 0 && $featured_case_study): ?>
    <!-- FEATURED CASE STUDY -->
    <div class="f--col-12">
        <div class="c--card-m u--mb-5">
            <div class="f--row u--display-flex u--align-items-center">
                <div class="f--col-4 f--col-tabletm-12">
                     <a href="<?= $featured_case_study_link ?>" target="<?= $target ?>"  rel="<?= $self ?>"  class="u--overflow-hidden">
                    <div class="c--card-m__wrapper">
                        <?php 
                        $featured_image = get_post_thumbnail_id($featured_case_study[0]->ID);
                        $image_to_use = $featured_image ? $featured_image : get_field('placeholder_image', 'options');
                        
                        if ($image_to_use) :
                            $image_tag_args = array(
                                'image' => $image_to_use,
                                'sizes' => '(max-width: 810px) 95vw, 33vw',
                                'class' => 'c--card-m__wrapper__media',
                                'isLazy' => false,
                                'lazyClass' => 'g--lazy-01',
                                'showAspectRatio' => false,
                                'decodingAsync' => true,
                                'fetchPriority' => false,
                                'addFigcaption' => false,
                            );
                            generate_image_tag($image_tag_args);
                        endif;
                        ?>
                    </div>
                </div>
                
                <?php 
                    $is_external = get_field('case_study_type', $featured_case_study[0]->ID) === "external";
                    if($is_external) {
                        $featured_case_study_link =  get_field('download_pdf', $featured_case_study[0]->ID);
                        $target= '_blank';
                        $rel = 'noopener noreferrer';
                    } else {
                        $featured_case_study_link = get_permalink($featured_case_study[0]->ID);
                        $target = '';
                        $rel = '';
                    }
                ?>
                <div class="f--col-4 f--col-tabletm-12">
                    <div class="c--card-m__hd">
                        <p class="c--card-m__hd__title">THE STARTING POINT</p>
                        <a  href="<?= $featured_case_study_link ?>" target="<?= $target ?>"  rel="<?= $self ?>" class="c--card-m__hd__paragraph"><?= get_the_title($featured_case_study[0]->ID); ?></a>
                        <a class="g--link-01 g--link-01--fourth" href="<?= $featured_case_study_link ?>" target="<?= $target ?>"  rel="<?= $self ?>">Learn More</a>
                    </div>
                </div>
                <div class="f--col-4 f--col-tabletm-12">
                    <div class="c--card-m__ft">
                        <p class="c--card-m__ft__title">HOW WE HELPED</p>
                        <div class="c--card-m__ft__items">
                            <?php 
                            $capabilities = get_the_terms($featured_case_study[0]->ID, 'case-study-capability');
                            if ($capabilities && !is_wp_error($capabilities)) :
                                foreach ($capabilities as $capability) : 
                                    // First try with the exact slug
                                    $capability_post = get_posts(array(
                                        'post_type' => 'capability',
                                        'name' => $capability->slug,
                                        'posts_per_page' => 1,
                                        'post_status' => 'publish'
                                    ));
                                    
                                    // If not found, search by normalized name
                                    if (empty($capability_post)) {
                                        $capability_posts = get_posts(array(
                                            'post_type' => 'capability',
                                            'posts_per_page' => -1,
                                            'post_status' => 'publish'
                                        ));
                                        
                                        $term_name_clean = strtolower(str_replace(array('&', ' ', ','), array('', '', ''), html_entity_decode($capability->name)));
                                        
                                        foreach($capability_posts as $cap_post) {
                                            $post_title_clean = strtolower(str_replace(array('&', ' ', ','), array('', '', ''), $cap_post->post_title));
                                            if ($term_name_clean === $post_title_clean) {
                                                $capability_post = array($cap_post);
                                                break;
                                            }
                                        }
                                    }
                                    
                                    $capability_link = !empty($capability_post) ? get_permalink($capability_post[0]->ID) : '#';
                                    ?>
                                    <a class="g--pill-01" href="<?= $capability_link; ?>"><?= $capability->name; ?></a>
                                <?php endforeach;
                            endif; ?>
                        </div>
                    </div>
                </div>
            </div>  
        </div>                                      
    </div>
    <?php endif; ?>

    <?php while ($my_query->have_posts()):
        $my_query->the_post(); ?>
        <div class="f--col-12">
            <div class="c--card-m u--mb-5">
                <div class="f--row u--display-flex u--align-items-center">
                    <div class="f--col-4 f--col-tabletm-12">
                         <a href="<?= get_permalink($post->ID); ?>" class="u--overflow-hidden">
                            <div  class="c--card-m__wrapper">
                                <?php 
                                $post_image = get_post_thumbnail_id($post->ID);
                                $image_to_use = $post_image ? $post_image : get_field('placeholder_image', 'options');
                                
                                if ($image_to_use) :
                                    $image_tag_args = array(
                                        'image' => $image_to_use,
                                        'sizes' => '(max-width: 810px) 95vw, 33vw',
                                        'class' => 'c--card-m__wrapper__media',
                                        'isLazy' => false,
                                        'lazyClass' => 'g--lazy-01',
                                        'showAspectRatio' => false,
                                        'decodingAsync' => true,
                                        'fetchPriority' => false,
                                        'addFigcaption' => false,
                                    );
                                    generate_image_tag($image_tag_args);
                                endif;
                                ?>
                            </div>
                        </a>
                    </div>
                    
                    <div class="f--col-4 f--col-tabletm-12">
                        <div class="c--card-m__hd">
                            <p  class="c--card-m__hd__title">THE STARTING POINT</p>
                            <a class="c--card-m__hd__paragraph" ref="<?= get_permalink($post->ID); ?>"><?= get_the_title($post->ID); ?></a>
                            <a class="g--link-01 g--link-01--fourth" href="<?= get_permalink($post->ID); ?>">Learn More</a>
                        </div>
                    </div>
                    <div class="f--col-4 f--col-tabletm-12">
                        <div class="c--card-m__ft">
                            <p class="c--card-m__ft__title">HOW WE HELPED</p>
                            <div class="c--card-m__ft__items">
                                <?php 
                                $capabilities = get_the_terms($post->ID, 'case-study-capability');
                                if ($capabilities && !is_wp_error($capabilities)) :
                                    foreach ($capabilities as $capability) : 
                                        // First try with the exact slug
                                        $capability_post = get_posts(array(
                                            'post_type' => 'capability',
                                            'name' => $capability->slug,
                                            'posts_per_page' => 1,
                                            'post_status' => 'publish'
                                        ));
                                        
                                        // If not found, search by normalized name
                                        if (empty($capability_post)) {
                                            $capability_posts = get_posts(array(
                                                'post_type' => 'capability',
                                                'posts_per_page' => -1,
                                                'post_status' => 'publish'
                                            ));
                                            
                                            $term_name_clean = strtolower(str_replace(array('&', ' ', ','), array('', '', ''), html_entity_decode($capability->name)));
                                            
                                            foreach($capability_posts as $cap_post) {
                                                $post_title_clean = strtolower(str_replace(array('&', ' ', ','), array('', '', ''), $cap_post->post_title));
                                                if ($term_name_clean === $post_title_clean) {
                                                    $capability_post = array($cap_post);
                                                    break;
                                                }
                                            }
                                        }
                                        
                                        $capability_link = !empty($capability_post) ? get_permalink($capability_post[0]->ID) : '#';
                                        ?>
                                        <a class="g--pill-01" href="<?= $capability_link; ?>"><?= $capability->name; ?></a>
                                    <?php endforeach;
                                endif; ?>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>                                      
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
