<section class="c--hero-b">
    <div class="c--zoom-section-b">
        <div class="c--zoom-section-b__media-wrapper f--background-b js--zoom-b" data-hero="true"></div>
    </div>
    <div class="c--hero-b__wrapper">
        <div class="c--hero-b__wrapper__item-left">
            <h1 class="c--hero-b__wrapper__item-left__title"><?php echo $hero['hero_title'] ?></h1>
            <div class="c--hero-b__wrapper__item-left__subtitle c--content-a c--content-a--third-text">
                <?php echo $hero['hero_subtitle'] ?>
            </div>
            <div class="c--hero-b__wrapper__item-left__list-group">
                <?php $child_args = array(
                    'post_type' => 'capability',
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    'orderby' => 'title',
                    'order' => 'ASC',
                    'post_parent' => get_the_ID() // Dinámicamente establece el ID del padre actual
                );

                $child_query = new WP_Query($child_args);

                if ($child_query->have_posts()) :
                    while ($child_query->have_posts()) : $child_query->the_post();
                        ?>
                        <a href="<?php the_permalink(); ?>" class="c--hero-b__wrapper__item-left__list-group__item"><?php the_title(); ?></a>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif; ?>
            </div>
        </div>
        <div class="c--hero-b__wrapper__item-right">
            <div class="js--lottie-element c--hero-b__wrapper__item-right__media" data-path="<?php echo $hero['hero_lottie']['url'] ?>" data-animType="svg" data-loop="true" data-autoplay="true" data-name="graphicHero"></div>
            </div>
        </div>
    </div>
</section>