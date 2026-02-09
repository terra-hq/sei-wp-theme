<?php
add_action('wp_ajax_nopriv_load_case_studies', 'load_case_studies');
add_action('wp_ajax_load_case_studies', 'load_case_studies');

function load_case_studies() {
    ob_start();

    $postType = isset($_REQUEST['postType']) ? sanitize_text_field($_REQUEST['postType']) : 'case-study';
    $postsPerPage = isset($_REQUEST['postPerPage']) ? intval($_REQUEST['postPerPage']) : 6;
    $offset = isset($_REQUEST['offset']) ? intval($_REQUEST['offset']) : 0;
    $searchTerm = isset($_REQUEST['searchTerm']) ? sanitize_text_field($_REQUEST['searchTerm']) : '';
    $taxonomies = isset($_REQUEST['taxonomies']) && is_array($_REQUEST['taxonomies']) ? $_REQUEST['taxonomies'] : array();
    $page_id = isset($_REQUEST['page_id']) ? intval($_REQUEST['page_id']) : 0;
    $is_load_more = isset($_REQUEST['isLoadMore']) ? $_REQUEST['isLoadMore'] : 'false';

    $featured_case_study = get_field('featured_case_study', $page_id);

    $myArgs = array(
        'post_type'      => $postType,
        'offset'         => $offset,
        'posts_per_page' => ($is_load_more === 'true') ? $postsPerPage : 6,
        'order'          => 'DESC',
        'orderby'        => 'date',
        'post_status'    => 'publish',
    );

    if (!empty($searchTerm)) {
        $myArgs['s'] = $searchTerm;
    }

    if ($featured_case_study) {
        $myArgs['post__not_in'] = array($featured_case_study[0]->ID);
    }

    if ($taxonomies && count($taxonomies) > 0) {
        $myArgs['tax_query'] = array('relation' => 'AND');
        foreach ($taxonomies as $tax) {
            $taxonomy = key($tax);
            $term = current($tax);
            $myArgs['tax_query'][] = array(
                'taxonomy' => $taxonomy,
                'field'    => 'slug',
                'terms'    => $term,
            );
        }
    }

    $my_query = new WP_Query($myArgs);

    $count_args = $myArgs;
    $count_args['posts_per_page'] = -1;
    $count_args['offset'] = 0;
    $posts_count = get_posts($count_args);
    $published_posts = is_array($posts_count) ? count($posts_count) : 0;

    $index = 0;

    // FEATURED CASE STUDY
    if ($is_load_more === 'false' && $published_posts != 0 && $featured_case_study) :

        $fc = $featured_case_study[0];
        $fc_id = !empty($fc->ID) ? $fc->ID : 0;

        $is_external_fc = get_field('case_study_type', $fc_id) === 'external';
        if ($is_external_fc) {
            $featured_case_study_link = get_field('download_pdf', $fc_id);
            $featured_case_study_target = '_blank';
            $featured_case_study_rel = 'noopener noreferrer';
        } else {
            $featured_case_study_link = get_permalink($fc_id);
            $featured_case_study_target = '';
            $featured_case_study_rel = '';
        }
        $featured_case_study_link = $featured_case_study_link ? $featured_case_study_link : '#';

        ?>
        <div class="f--col-12">
            <div class="c--card-m">
                <div class="f--row">
                    <div class="f--col-4 f--col-tabletm-12">
                        <a href="<?= esc_url($featured_case_study_link) ?>" <?= $featured_case_study_target ? 'target="'.esc_attr($featured_case_study_target).'"' : '' ?> <?= $featured_case_study_rel ? 'rel="'.esc_attr($featured_case_study_rel).'"' : '' ?> class="u--overflow-hidden">
                            <div class="c--card-m__wrapper">
                                <?php
                                $featured_image = get_post_thumbnail_id($fc_id);
                                $image_to_use = $featured_image ? $featured_image : get_field('placeholder_image', 'options');
                                if ($image_to_use) {
                                    generate_image_tag(array(
                                        'image' => $image_to_use,
                                        'sizes' => '(max-width: 810px) 95vw, 33vw',
                                        'class' => 'c--card-m__wrapper__media',
                                        'isLazy' => false,
                                        'showAspectRatio' => false,
                                    ));
                                }
                                ?>
                            </div>
                        </a>
                    </div>

                    <div class="f--col-4 f--col-tabletm-12">
                        <div class="c--card-m__hd">
                            <p class="c--card-m__hd__title">WHAT WE DID</p>
                            <a href="<?= esc_url($featured_case_study_link) ?>" <?= $featured_case_study_target ? 'target="'.esc_attr($featured_case_study_target).'"' : '' ?> <?= $featured_case_study_rel ? 'rel="'.esc_attr($featured_case_study_rel).'"' : '' ?> class="c--card-m__hd__paragraph">
                                <?= esc_html(get_the_title($fc_id)); ?>
                            </a>
                            <a class="g--link-01 g--link-01--fourth" href="<?= esc_url($featured_case_study_link) ?>" <?= $featured_case_study_target ? 'target="'.esc_attr($featured_case_study_target).'"' : '' ?> <?= $featured_case_study_rel ? 'rel="'.esc_attr($featured_case_study_rel).'"' : '' ?>>Learn More</a>
                        </div>
                    </div>

                    <div class="f--col-4 f--col-tabletm-12">
                        <div class="c--card-m__ft">
                            <p class="c--card-m__ft__title">HOW WE HELPED</p>
                            <div class="c--card-m__ft__items">
                                <?php
                                // Capabilities (featured)
                                $capabilities = get_the_terms($fc_id, 'case-study-capability');
                                if ($capabilities && !is_wp_error($capabilities)) :
                                    foreach ($capabilities as $cap) :
                                        $related_post = get_field('capabilities', 'case-study-capability_' . $cap->term_id);
                                        $pill_link = '#';
                                        if ($related_post && !empty($related_post)) {
                                            $cap_post = is_array($related_post) ? $related_post[0] : $related_post;
                                            if (!empty($cap_post->ID)) $pill_link = get_permalink($cap_post->ID);
                                        }
                                        if ($pill_link !== '#') : ?>
                                            <a class="g--pill-01" href="<?= esc_url($pill_link) ?>"><?= esc_html($cap->name) ?></a>
                                        <?php else : ?>
                                            <span class="g--pill-01"><?= esc_html($cap->name) ?></span>
                                        <?php endif;
                                    endforeach;
                                endif;

                                // Industries (featured)
                                $industries = get_the_terms($fc_id, 'case-study-industry');
                                if ($industries && !is_wp_error($industries)) :
                                    foreach ($industries as $ind) :
                                        $related_post = get_field('industries', 'case-study-industry_' . $ind->term_id);
                                        $pill_link = '#';
                                        if ($related_post && !empty($related_post)) {
                                            $ind_post = is_array($related_post) ? $related_post[0] : $related_post;
                                            if (!empty($ind_post->ID)) $pill_link = get_permalink($ind_post->ID);
                                        }
                                        if ($pill_link !== '#') : ?>
                                            <a class="g--pill-01" href="<?= esc_url($pill_link) ?>"><?= esc_html($ind->name) ?></a>
                                        <?php else : ?>
                                            <span class="g--pill-01"><?= esc_html($ind->name) ?></span>
                                        <?php endif;
                                    endforeach;
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    <?php
    endif;

    // ---------- POSTS LOOP ----------
    while ($my_query->have_posts()) :
        $my_query->the_post();
        $post_id = get_the_ID();

        $is_external_post = get_field('case_study_type', $post_id) === 'external';
        if ($is_external_post) {
            $case_link = get_field('download_pdf', $post_id);
            $case_target = '_blank';
            $case_rel = 'noopener noreferrer';
        } else {
            $case_link = get_permalink($post_id);
            $case_target = '';
            $case_rel = '';
        }
        $case_link = $case_link ? $case_link : '#';
        ?>

        <div class="f--col-12">
            <div class="c--card-m">
                <div class="f--row">
                    <div class="f--col-4 f--col-tabletm-12">
                        <a href="<?= esc_url($case_link) ?>" <?= $case_target ? 'target="'.esc_attr($case_target).'"' : '' ?> <?= $case_rel ? 'rel="'.esc_attr($case_rel).'"' : '' ?> class="u--overflow-hidden">
                            <div class="c--card-m__wrapper">
                                <?php
                                $post_image = get_post_thumbnail_id($post_id);
                                $image_to_use = $post_image ? $post_image : get_field('placeholder_image', 'options');
                                if ($image_to_use) {
                                    generate_image_tag(array(
                                        'image' => $image_to_use,
                                        'sizes' => '(max-width: 810px) 95vw, 33vw',
                                        'class' => 'c--card-m__wrapper__media',
                                        'isLazy' => false,
                                        'showAspectRatio' => false,
                                    ));
                                }
                                ?>
                            </div>
                        </a>
                    </div>

                    <div class="f--col-4 f--col-tabletm-12">
                        <div class="c--card-m__hd">
                            <p class="c--card-m__hd__title">WHAT WE DID</p>
                            <a class="c--card-m__hd__paragraph" href="<?= esc_url($case_link) ?>" <?= $case_target ? 'target="'.esc_attr($case_target).'"' : '' ?> <?= $case_rel ? 'rel="'.esc_attr($case_rel).'"' : '' ?>>
                                <?= esc_html(get_the_title($post_id)) ?>
                            </a>
                            <a class="g--link-01 g--link-01--fourth" href="<?= esc_url($case_link) ?>" <?= $case_target ? 'target="'.esc_attr($case_target).'"' : '' ?> <?= $case_rel ? 'rel="'.esc_attr($case_rel).'"' : '' ?>>Learn More</a>
                        </div>
                    </div>

                    <div class="f--col-4 f--col-tabletm-12">
                        <div class="c--card-m__ft">
                            <p class="c--card-m__ft__title">HOW WE HELPED</p>
                            <div class="c--card-m__ft__items">
                                <?php
                                // Capabilities (per post)
                                $capabilities = get_the_terms($post_id, 'case-study-capability');
                                if ($capabilities && !is_wp_error($capabilities)) :
                                    foreach ($capabilities as $cap) :
                                        $related_post = get_field('capabilities', 'case-study-capability_' . $cap->term_id);
                                        $pill_link = '#';
                                        if ($related_post && !empty($related_post)) {
                                            $cap_post = is_array($related_post) ? $related_post[0] : $related_post;
                                            if (!empty($cap_post->ID)) $pill_link = get_permalink($cap_post->ID);
                                        }
                                        if ($pill_link !== '#') : ?>
                                            <a class="g--pill-01" href="<?= esc_url($pill_link) ?>"><?= esc_html($cap->name) ?></a>
                                        <?php else : ?>
                                            <span class="g--pill-01"><?= esc_html($cap->name) ?></span>
                                        <?php endif;
                                    endforeach;
                                endif;

                                // Industries (per post)
                                $industries = get_the_terms($post_id, 'case-study-industry');
                                if ($industries && !is_wp_error($industries)) :
                                    foreach ($industries as $ind) :
                                        $related_post = get_field('industries', 'case-study-industry_' . $ind->term_id);
                                        $pill_link = '#';
                                        if ($related_post && !empty($related_post)) {
                                            $ind_post = is_array($related_post) ? $related_post[0] : $related_post;
                                            if (!empty($ind_post->ID)) $pill_link = get_permalink($ind_post->ID);
                                        }
                                        if ($pill_link !== '#') : ?>
                                            <a class="g--pill-01" href="<?= esc_url($pill_link) ?>"><?= esc_html($ind->name) ?></a>
                                        <?php else : ?>
                                            <span class="g--pill-01"><?= esc_html($ind->name) ?></span>
                                        <?php endif;
                                    endforeach;
                                endif;
                                ?>
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

    endwhile;

    wp_reset_postdata();

    $content = ob_get_contents();
    $response = array(
        'html' => $content,
        'postsTotal' => $published_posts,
    );
    ob_end_clean();

    wp_send_json($response);
}
