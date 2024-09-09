<?php
    $spacing = get_spacing($module['spacing']);
    $tagline = $module['tagline'];
    $title = $module['title'];
?>

<section class="<?= $spacing?>">
    <div class="f--container">
        <div class="f--row f--gap-a">
            <div class="f--col-4 f--col-tabletl-12">
                <h2 class="f--font-i f--color-c u--letter-spacing-a u--text-uppercase u--font-medium f--mb-4"><?= $tagline ?></h2>
                <h3 class="f--font-e"><?= $title ?></h3>
            </div>
            <div class="f--col-8 f--col-tabletl-12">
                <div class="c--accordion-a">
                <?php 
                    wp_reset_postdata();

                    $current_post_id = get_the_ID();
                    $parent_post_id = wp_get_post_parent_id($current_post_id);

                    if (!$parent_post_id) {
                        $parent_post_id = $current_post_id;
                    }

                    $child_args = array(
                        'post_type' => 'capability',
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'orderby' => 'title',
                        'order' => 'ASC',
                        'post_parent' => $parent_post_id,
                    );
                    if ($parent_post_id != $current_post_id) {
                        $child_args['post__not_in'] = array($current_post_id); // If child, exclude current post
                    }
                    $child_query = new WP_Query($child_args);


                    if ($child_query->have_posts()) :
                        $first = true;
                        while ($child_query->have_posts()) : $child_query->the_post();
                        $card_title = get_the_title();
                        $card_description = get_field('subcapbilities_accordion_tagline', $post->ID) ?? 'Not Filled'; 
                        $link = get_the_permalink();
                        ?>
                        <div class="c--accordion-a__item">
                            <input type="radio" name="select" class="c--accordion-a__item__btn" <?php echo $first ? 'checked' : ''; ?> />
                            <div class="c--accordion-a__item__hd">
                                <span class="c--accordion-a__item__hd__content"><?php the_title(); ?></span>
                            </div>
                            <?php  $modifierClass = 'second'; ?>
                            <div class="c--accordion-a__item__wrapper" role="region" aria-hidden="<?php echo $first ? 'false' : 'true'; ?>">
                                <div class="c--accordion-a__item__wrapper__content">
                                    <?php
                                        $show_lottie = false;
                                        include(locate_template('components/card/card-b.php', false, false));
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php
                        $first = false;
                        endwhile;
                        wp_reset_postdata();
                    endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>