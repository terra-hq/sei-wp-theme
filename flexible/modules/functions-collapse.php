<?php $spacing = get_spacing($module['section_spacing']); ?>
<section class="<?php echo $spacing ?>">
    <div class="f--container u--position-relative">
        <div class="c--overlay-c"></div>
        <div class="f--row f--gap-a f--sp-a">

            <?php

            $args = array(
                'post_type' => 'functions',
                'posts_per_page' => 6,
                'orderby' => 'title',
                'order' => 'ASC',
            );

            $custom_query = new WP_Query($args);

            if ($custom_query->have_posts()) : ?>
                <?php while ($custom_query->have_posts()) : $custom_query->the_post(); ?>
                    <div class="f--col-4 f--col-tabletm-6 f--col-mobile-12 u--display-flex">
                        <?php
                            $url = get_the_permalink($post->ID);
                            $title = get_the_title($post->ID);
                            $subtitle = get_field('description', $post->ID);
                            include(locate_template('components/card/card-e.php', false, false));
                        ?>
                    </div>
                <?php endwhile; 
                wp_reset_postdata();
            endif;
            ?>


        </div>
        <div class="f--row js--collapse u--position-relative">
            <div class="f--col-12 u--text-center">
                <button class="g--btn-01" data-collapsify-control="all-functions">See All</button>
            </div>
        </div>
        <div class="f--row f--gap-a f--sp-a" data-collapsify-content="all-functions">
            <?php

            $args_2 = array(
                'post_type' => 'functions',
                'offset' => 6,
                'orderby' => 'title',
                'order' => 'ASC',
            );

            $custom_query_2 = new WP_Query($args_2);

            if ($custom_query_2->have_posts()) : ?>
                <?php while ($custom_query_2->have_posts()) : $custom_query_2->the_post(); ?>
                    <div class="f--col-4 f--col-tabletm-6 f--col-mobile-12 u--display-flex">
                        <?php
                            $url = get_the_permalink($post->ID);
                            $title = get_the_title($post->ID);
                            $subtitle = get_field('description', $post->ID);
                            include(locate_template('components/card/card-e.php', false, false));
                        ?>
                    </div>
                <?php endwhile; 
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
</section>

<?php unset($spacing, $args, $custom_query, $args_2, $custom_query_2); ?>