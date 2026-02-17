<?php
    $spacing = get_spacing($module['spacing']);
?>

<section class="<?= $spacing?>">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-12">
                <div class="c--accordion-a" data-breakpoint="810">
                <?php
                        wp_reset_postdata();
                        $parent_args = array(
                            'post_type' => 'capability',
                            'post_status' => 'publish',
                            'posts_per_page' => -1,
                            'orderby' => 'title',
                            'order' => 'ASC',
                            'post_parent' => 0 // Only post that are parents (0 = no parent id)
                        );
    
                        $parent_query = new WP_Query($parent_args);

                        if ($parent_query->have_posts()) :
                            $first = true;
                            while ($parent_query->have_posts()) : $parent_query->the_post();
                            $card_title = get_the_title();
                            $card_description = get_field('homepage_tagline', get_the_ID()) ?? 'Not Filled';
                            $link = get_the_permalink();
                    ?>
                         <div class="c--accordion-a__item">
                            <input type="radio" name="select" class="c--accordion-a__item__btn" <?php echo $first ? 'checked' : ''; ?> />
                            <div class="c--accordion-a__item__hd">
                                <span class="c--accordion-a__item__hd__content"><?= $card_title ?></span>
                            </div>
                            <div class="c--accordion-a__item__wrapper">
                                <div class="c--accordion-a__item__wrapper__content">
                                    <?php 
                                        $show_lottie = true;
                                        $card_key = 'capability-' . get_the_ID();
                                        include(locate_template('components/card/card-b.php', false, false)); 
                                        unset($card_key);
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

<?php unset($spacing); ?>