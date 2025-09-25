<?php
/*
Template Name: Success Stories
*/
?>

<?php
// INDUSTRY FILTER
$industry_query = array();
if (isset($_GET['ind']) && !empty($_GET['ind'])) {
    array_push($industry_query, array('case-study-industry' => htmlspecialchars($_GET['ind'])));
}

// CAPABILITY FILTER
$capability_query = array();
if (isset($_GET['cap']) && !empty($_GET['cap'])) {
    array_push($capability_query, array('case-study-capability' => htmlspecialchars($_GET['cap'])));
}

// SEARCH FILTER
$search_term = '';
if (isset($_GET['query']) && !empty($_GET['query'])) {
    $search_term = htmlspecialchars($_GET['query']);
}
?>



<?php get_header(); ?>

<?php
$modules = get_field('modules', $post_id);
$hero_title = $modules['hero_title'];
$hero_subtitle = $modules['hero_subtitle'];
$hero = array(
    'title' => $hero_title,
    'subtitle' => $hero_subtitle
);
include(locate_template('flexible/hero/big-heading-tagline-hero.php', false, false));
?>

<section class="u--pb-10 u--pb-tablets-7 js--section-container">
    <div class="f--container">
        <div class="f--row f--sp-a f--gap-c">

            <div class="f--col-3 f--col-tabletm-6 f--col-mobile-12">
                <!-- INDUSTRY FILTER -->
                <form class="c--filter-a c--filter-a--second">
                    <div class="c--filter-a__item">
                        <select name="ind" data-taxonomy="case-study-industry" data-taxonomy-slug="ind" data-type="case-study-industry" onchange="this.dataset.chosen = this.value;" data-chosen="all" class="js--case-study-industry-dropdown">
                            <option value="all">All Industries</option>
                            <?php
                            $terms = get_terms(array(
                                'taxonomy' => 'case-study-industry',
                                'hide_empty' => false,
                            ));
                            ?>
                            <?php foreach ($terms as $term) : ?>
                                <option value="<?= $term->slug; ?>" <?= isset($_GET['ind']) && $term->slug === htmlspecialchars($_GET['ind']) ? 'selected' : ''; ?>>
                                    <?= $term->name; ?>
                                </option>
                            <?php endforeach; ?>
                            <?php wp_reset_postdata(); ?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="f--col-3 f--col-tabletm-6 f--col-mobile-12">
                <!-- CAPABILITY FILTER -->
                <form class="c--filter-a c--filter-a--second">
                    <div class="c--filter-a__item">
                        <select name="cap" data-taxonomy="case-study-capability" data-taxonomy-slug="cap" data-type="case-study-capability" onchange="this.dataset.chosen = this.value;" data-chosen="all" class="js--case-study-capability-dropdown">
                            <option value="all">All Capabilities</option>
                            <?php
                            $terms = get_terms(array(
                                'taxonomy' => 'case-study-capability',
                                'hide_empty' => false,
                            ));
                            ?>
                            <?php foreach ($terms as $term) : ?>
                                <option value="<?= $term->slug; ?>" <?= isset($_GET['cap']) && $term->slug === htmlspecialchars($_GET['cap']) ? 'selected' : ''; ?>>
                                    <?= $term->name; ?>
                                </option>
                            <?php endforeach; ?>
                            <?php wp_reset_postdata(); ?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="f--col-3 f--col-tabletm-6 f--col-mobile-12">
                <!-- SEARCH FILTER -->
                <form class="c--filter-a c--filter-a--third">
                    <div class="c--filter-a__item">
                        <input type="search" id="inputSearch" placeholder="Search" aria-label="Search items" class="c--form-search-a__item js--posts-search" <?php if (!empty($search_term)) : ?> value="<?php echo $search_term ?>" <?php endif; ?>>
                    </div>
                </form>
            </div>
            <div class="f--col-12 js--results-number">
                <p class="f--font-i f--color-c u--font-semibold"></p>
            </div>
        </div>

        <div class="f--row">
            <div class="f--col-12">
                <div class="g--message-01 js--loading">
                    <div class="g--spinner-01 g--message-01__artwork">
                        <svg viewBox="0 0 26 26" fill="none">
                            <path d="M23.446 9.625c1.063-.344 1.66-1.494 1.155-2.49a13 13 0 1 0-1.085 13.507c.657-.903.251-2.134-.743-2.642-.994-.51-2.198-.095-2.916.76a8.954 8.954 0 1 1 .831-10.352c.573.96 1.695 1.56 2.758 1.217Z" fill="#7F7ED0"></path>
                        </svg>
                    </div>
                    <p class="g--message-01__item-primary">Loading...</p>
                </div>
            </div>
        </div>

        <div class="f--row js--no-results-message" style="display: none">
            <div class="f--col-12">
                <div class="g--message-01 f--sp-c">
                    <p class="g--message-01__item-primary">No results found. Please try another search</p>
                </div>
            </div>
        </div>

        <!-- RESULTS -->
        <div class="js--results-container f--row f--gap-e">
            <!-- FEATURED INSIGHT -->

            <?php
            $featured_case_study = get_field('featured_case_study');
            
            $posts_per_page = 6;
            $offset = 0;
            $postType = 'case-study';

            $query_args = array(
                "post_type" => "case-study",
                "post__not_in" => $featured_case_study ? array($featured_case_study[0]->ID) : array(),
                "posts_per_page" => 6,
                "offset" => $offset,
                "post_status" => "publish",
                'order' => 'DESC', 
                'orderby' => 'date',
            );

            // Combine tax_query for industry and capability
            $tax_query = array('relation' => 'AND');

            if (!empty($industry_query)) {
                foreach ($industry_query as $tax) {
                    $taxonomy = key($tax);
                    $term = current($tax);
                    $tax_query[] = array(
                        'taxonomy' => $taxonomy,
                        'field' => 'slug',
                        'terms' => $term
                    );
                }
            }

            if (!empty($capability_query)) {
                foreach ($capability_query as $tax) {
                    $taxonomy = key($tax);
                    $term = current($tax);
                    $tax_query[] = array(
                        'taxonomy' => $taxonomy,
                        'field' => 'slug',
                        'terms' => $term
                    );
                }
            }

            if (!empty($tax_query)) {
                $query_args['tax_query'] = $tax_query;
            }

            // SET SEARCH QUERY
            if (!empty($search_term)) {
                $query_args['s'] = $search_term;
            }

            $the_query = new WP_Query($query_args);
            $index = 0; ?>

            <?php if ($the_query->have_posts() && $featured_case_study) : ?>
               <div class="f--col-12">
                <div class="c--card-m u--mb-5">
                    <div class="f--row u--display-flex u--align-items-start">
                        <div class="f--col-4 f--col-tabletm-12">
                            <a href="<?= $featured_case_study_link ?>" target="<?= $target ?>"  rel="<?= $self ?>" class="u--overflow-hidden">
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
                            </a>    
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
                                <a class="c--card-m__hd__paragraph" href="<?= $featured_case_study_link ?>" target="<?= $target ?>"  rel="<?= $self ?>"><?= get_the_title($featured_case_study[0]->ID); ?></a>
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

            <?php if ($the_query->have_posts()) :
                while ($the_query->have_posts()) :
                    $the_query->the_post();
                    ?>
                     <div class="f--col-12">
                        <div class="c--card-m u--mb-5">
                            <div class="f--row u--display-flex u--align-items-start">
                                <div class="f--col-4 f--col-tabletm-12 u--overflow-hidden">
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
                                        <a href="<?= get_permalink($post->ID); ?>" class="c--card-m__hd__paragraph"><?= get_the_title($post->ID); ?></a>
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
                    $query_args['posts_per_page'] = -1;
                    $posts_count = get_posts($query_args);
                    $published_posts = count($posts_count);
                    if ($index < 5) {
                        $index++;
                    } else {
                        $index = 0;
                    }
                endwhile;
            endif;
            wp_reset_postdata();
            ?>

            <?php if (!$published_posts) : ?>
                <div class="f--row js--no-results-message" style="display: block">
                    <div class="f--col-12">
                        <div class="g--message-01 f--sp-c">
                            <p class="g--message-01__item-primary">No results found. Please try another search</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
        <div class="f--row">
            <div class="f--col-12 u--display-flex u--justify-content-center">
                <div class="c--spinner-wrapper-a u--mt-8 u--mt-tablets-5">
                    <button class="g--btn-03 g--btn-03--fourth js--load-more-posts" aria-label="load more items" data-posts-total="<?= $published_posts ?>" data-posts-per-page="<?= $posts_per_page ?>" data-offset="<?= $offset ?>" data-post-type="<?= $postType ?>" data-featured-case-study-id="<?= $featured_case_study ? $featured_case_study[0]->ID : '' ?>">
                        <span class="g--btn-03__content">Load More</span>
                        <?php include(locate_template('img/btn-03-plus.svg', false, false)); ?>
                    </button>

                    <div class="c--spinner-wrapper-a__item g--spinner-01 js--spinner-load-more">
                        <svg viewBox="0 0 26 26" fill="none">
                            <path d="M23.446 9.625c1.063-.344 1.66-1.494 1.155-2.49a13 13 0 1 0-1.085 13.507c.657-.903.251-2.134-.743-2.642-.994-.51-2.198-.095-2.916.76a8.954 8.954 0 1 1 .831-10.352c.573.96 1.695 1.56 2.758 1.217Z" fill="#7F7ED0"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$module = array(
    'title' => $modules['title'],
    'button' => $modules['btn'],
    'full_width' => true
);
include(locate_template('flexible/modules/texture-background-cta.php', false, false));
?>

<?php get_footer(); ?>
