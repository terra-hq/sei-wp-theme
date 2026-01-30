<?php
/*
Template Name: Insights
*/
?>

<?php
// TYPE FILTER
// $type_query = array();
// if (isset($_GET['type']) && !empty($_GET['type'])) {
//     array_push($type_query, array('insight-types' => htmlspecialchars($_GET['type'])));
// }

// CAPABILITY FILTER
$capability_query = array();
if (isset($_GET['cap']) && !empty($_GET['cap'])) {
    array_push($capability_query, array('insight-capability' => htmlspecialchars($_GET['cap'])));
}

// TOPICS FILTER
$topic_query = array();
if (isset($_GET['topic']) && !empty($_GET['topic'])) {
    array_push($capability_query, array('topics' => htmlspecialchars($_GET['topic'])));
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

<section class="u--pb-10 u--pb-tablets-7 js--section-insights">
    <div class="f--container">
        <div class="f--row f--sp-a f--gap-c">
            <!-- <div class="f--col-3 f--col-tabletm-6 f--col-mobile-12">
                <form class="c--filter-a c--filter-a--second">
                    <div class="c--filter-a__item">
                        <select name="type" data-taxonomy="insight-types" data-taxonomy-slug="type" data-type="insight-types"  onchange="this.dataset.chosen = this.value;" data-chosen="all" class="js--insight-types-dropdown">
                            <option value="all">Category</option>
                            <?php
                            //$terms = get_terms(array(
                                //'taxonomy' => 'insight-types',
                                //'hide_empty' => true,
                            //));
                            ?>
                            <?php //foreach ($terms as $term) : ?>
                                <option value="<?//= $term->slug; ?>" <?//= isset($_GET['type']) && $term->slug === htmlspecialchars($_GET['type']) ? 'selected' : ''; ?>>
                                    <?//= $term->name; ?>
                                </option>
                            <?php //endforeach; ?>
                        </select>
                    </div>
                </form>
            </div> -->
            <div class="f--col-3 f--col-tabletm-6 f--col-mobile-12">
                <!-- CAPABILITY FILTER -->
                <form class="c--filter-a c--filter-a--second">
                    <div class="c--filter-a__item">
                        <select name="cap" data-taxonomy="insight-capability" data-taxonomy-slug="cap" data-type="insight-capability"  onchange="this.dataset.chosen = this.value;" data-chosen="all"  class="js--insight-capability-dropdown">>
                            <option value="all">All Capabilities</option>
                            <?php
                            $terms = get_terms(array(
                                'taxonomy' => 'insight-capability',
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
                <!-- TOPIC FILTER -->
                <form class="c--filter-a c--filter-a--second">
                    <div class="c--filter-a__item">
                        <select name="topic" data-taxonomy="topics" data-taxonomy-slug="topic" data-type="topics" onchange="this.dataset.chosen = this.value;" data-chosen="all" class="js--topics-dropdown">>
                            <option value="all">All Topics</option>
                            <?php
                            $terms = get_terms(array(
                                'taxonomy' => 'topics',
                                'hide_empty' => false,
                            ));
                            ?>
                            <?php foreach ($terms as $term) : ?>
                                <option value="<?= $term->slug; ?>" <?= isset($_GET['topic']) && $term->slug === htmlspecialchars($_GET['topic']) ? 'selected' : ''; ?>>
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
            $featured_insight = get_field('featured_insight');
            
            $posts_per_page = 9;
            $offset = 0;
            $postType = 'insight';

            $query_args = array(
                "post_type" => "insight",
                "post__not_in" => array($featured_insight[0]->ID),
                "posts_per_page" => 7,
                "offset" => $offset,
                "post_status" => "publish",
                'order' => 'DESC', 
                'orderby' => 'date',
            );

            // Combine tax_query for type and capability
            $tax_query = array('relation' => 'AND');

            // if (!empty($type_query)) {
            //     foreach ($type_query as $tax) {
            //         $taxonomy = key($tax);
            //         $term = current($tax);
            //         $tax_query[] = array(
            //             'taxonomy' => $taxonomy,
            //             'field' => 'slug',
            //             'terms' => $term
            //         );
            //     }
            // }

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

            <?php if ($the_query->have_posts()) : ?>
                <div class="f--col-8 f--col-tabletm-12 u--display-flex js--featured-insight" data-page-id="<?= get_the_ID(); ?>">
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
                        include(locate_template('components/card/card-l.php', false, false));
                        ?>
                </div>
            <?php endif; ?>

            <?php if ($the_query->have_posts()) :
                while ($the_query->have_posts()) :
                    $the_query->the_post();
                    ?>
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
                                if (!$topics) {
                                    $topics = array();
                                }
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
                                

                                include(locate_template('components/card/card-24.php', false, false));
                                ?>
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
                    <button class="g--btn-03 g--btn-03--fourth js--load-more-posts" aria-label="load more items" data-posts-total="<?= $published_posts ?>" data-posts-per-page="<?= $posts_per_page ?>" data-offset="<?= $offset ?>" data-category="<?= $categoryName ?>" data-post-type="<?= $postType ?>" data-featured-insight-id="<?= $featured_insight_id ?>"></data-feature>
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