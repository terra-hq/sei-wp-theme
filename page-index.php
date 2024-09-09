<?php
/*
Template Name: Index
*/
?>
<?php get_header(); ?>

<?php
    $url = $_SERVER['REQUEST_URI'];
    $url_parts = explode('/', $url);
    $post_type = $url_parts[1];

    // For Capabilities we use page-capabilities-index.php

    switch ($post_type) {
        case 'locations':
            $post_type = 'location';
            break;
        case 'functions':
            $post_type = 'functions';
            break;
        case 'industries':
            $post_type = 'industry';
            break;
    }


    $full_title = get_the_title();
    $dynamic_title = [];
    if ($last_space_pos = strrpos($full_title, ' ')) {
        $dynamic_title[] = ['text' => substr($full_title, 0, $last_space_pos), 'italic' => false];
        if ($post_type === 'location') {
            $dynamic_title[] = ['text' => substr($full_title, $last_space_pos + 1), 'italic' => true];
        }
    } else {
        $dynamic_title[] = ['text' => $full_title, 'italic' => false];
    }
        $description = get_field('description', $post->ID);

    $hero = [
        'title' => $dynamic_title,
        'subtitle' => $description
    ];

    include(locate_template('flexible/hero/big-heading-tagline-hero.php', false, false));
?>
<div class="post-list">
    <?php
        $args = array(
            'post_type' => $post_type,
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC'
        );
        $custom_query = new WP_Query($args);


        if ($custom_query->have_posts()) :
    ?>

        <section class="f--pb-22 f--pb-tablets-15">
            <div class="f--container">
                <div class="f--row f--gap-b">
                    <?php while ($custom_query->have_posts()) : $custom_query->the_post(); ?>
                        <?php
                            $url = ($post_type === 'functions') ? null : get_the_permalink();
                            $title = get_the_title();
                            $subtitle = get_field('description');
                        ?>
                        <div class="f--col-4 f--col-tablets-6 f--col-mobile-12 u--display-flex">
                            <?php 
                                if ($post_type === 'location') {
                                    include(locate_template('components/card/card-e-third.php', false, false));
                                } else {
                                    include(locate_template('components/card/card-e.php', false, false));
                                }
                            ?>
                        </div>

                    <?php endwhile; ?>
                </div>
            </div>
        </section>
    <?php
    else :
        ?>
        <p><?php esc_html_e('No posts found.'); ?></p>
        <?php
    endif;
    ?>
</div>

<?php wp_reset_postdata(); ?>
<?php get_footer(); ?>
