<?php
/*
Template Name: Capabilities Index
*/
?>
<?php get_header(); ?>

<?php
    $full_title = get_the_title();
    $title = [];
    if ($last_space_pos = strrpos($full_title, ' ')) {
        $title[] = ['text' => substr($full_title, 0, $last_space_pos), 'italic' => false];
    } else {
        $title[] = ['text' => $full_title, 'italic' => false];
    }
    $description = get_field('description', $post->ID);

    $hero = [
        'title' => $title,
        'subtitle' => $description
    ];

    include(locate_template('flexible/hero/big-heading-tagline-hero.php', false, false));

    $capabilities_args = array(
        'post_type' => 'capability',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
        'post_parent' => 0 // Only post that are parents (0 = no parent id)
    );

    $capabilities_query = new WP_Query($capabilities_args);

    if ($capabilities_query->have_posts()) :
?>

<section class="u--pb-15 u--pb-tabletm-10">
    <div class="f--container">
        <?php foreach ($capabilities_query->posts as $capability) : ?>
            <?php
                $capability_title = get_the_title($capability->ID);
                $capability_description = get_field('homepage_tagline', $capability->ID);
                $capability_image = get_field('capability_lottie_index', $capability->ID);
                $image = get_field('index_icon', $capability->ID);
            ?>

            <div class="c--border-a u--pt-5 u--pt-tabletm-4 u--pb-8 u--pb-tabletm-5">
                <a href="<?= get_the_permalink($capability->ID) ?>" class="c--heading-b">
                    <div class="c--heading-b__wrapper">
                        <h2 class="c--heading-b__wrapper__title"><?= $capability_title ?></h2>
                        <p class="c--heading-b__wrapper__subtitle"><?= $capability_description ?></p>
                        <p class="c--heading-b__wrapper__btn">Learn More</p>
                    </div>
                    <div class="c--heading-b__media-wrapper">
                        
                            <?php
                                $image_tag_args = array(
                                    'image' => $capability_image,
                                    'sizes' => '(max-width: 810px) 50vw, 100vw ',
                                    'class' => 'c--heading-b__media-wrapper__media' ,
                                    'isLazy' => true,
                                    'lazyClass' => 'g--lazy-01',
                                    'showAspectRatio' => true,
                                    'decodingAsync' => true,
                                    'fetchPriority' => false,
                                    'addFigcaption' => false,
                                );
                                generate_image_tag($image_tag_args)
                            ?>                        
                    </div>
                </a>
                <div class="f--row f--gap-b">
                    <?php
                        // Fetch child capabilities
                        $child_args = array(
                            'post_type' => 'capability',
                            'post_status' => 'publish',
                            'posts_per_page' => -1,
                            'orderby' => 'title',
                            'order' => 'ASC',
                            'post_parent' => $capability->ID
                        );
                        $child_query = new WP_Query($child_args);

                        if ($child_query->have_posts()) :
                            foreach ($child_query->posts as $sub_capability) :
                                $url = get_the_permalink($sub_capability->ID);
                                $title = get_the_title($sub_capability->ID);
                                $subtitle = get_field('subcapbilities_accordion_tagline', $sub_capability->ID);
                    ?>
                        <div class="f--col-4 f--col-tabletm-6 f--col-tablets-12 u--display-flex">
                            <?php include(locate_template('components/card/card-e.php', false, false)); ?>
                        </div>
                    <?php
                            endforeach;
                            wp_reset_postdata();
                        endif;
                    ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php 
    endif;
    wp_reset_postdata();
    get_footer();
?>