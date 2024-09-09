<?php
/*
Template Name: Newsroom Index
*/
?>
<?php get_header(); ?>


<?php
$hero_title = get_field('hero_title');
$hero_subtitle = get_field('hero_subtitle');
$page_id = get_the_ID();
?>
<section class="g--hero-04">
    <div class="g--hero-04__ft-items">
        <div class="g--hero-04__ft-items__wrapper">
            <div class="g--hero-04__ft-items__wrapper__content">
                <h1 class="g--hero-04__ft-items__wrapper__content__item-primary">
                    <?php echo $hero_title ?>
                </h1>
                <div class="g--hero-04__ft-items__wrapper__content__list-group">
                    <p class="g--hero-04__ft-items__wrapper__content__list-group__item"><?php echo $hero_subtitle ?></p>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="js--section-news">
    <?php
    $postType = 'news';
    $posts_per_page = 12;
    $offset = 0;
    $cardPath = 'components/card/card-e.php';
    $args = array(
        'post_type' => 'news',
        'posts_per_page' => $posts_per_page,
        'offset' => $offset,
        'orderby' => 'date',
        'order' => 'DESC',
    );
    $custom_query = new WP_Query($args);


    if ($custom_query->have_posts()) : ?>

        <section class="f--pb-22 f--pb-tablets-15">
            <div class="f--container">
                <div class="f--row f--gap-a">
                    <div class="f--col-8 f--col-tabletm-12">
                        <div class="js--news-container c--wrapper-b c--wrapper-b--third">

                            <?php while ($custom_query->have_posts()) : $custom_query->the_post(); ?>
                                <?php $repeater_item = $post->ID ?>
                                <?php $args['posts_per_page'] = -1;
                                        $posts_count = get_posts($args);
                                        $published_posts = count($posts_count); ?>
                                <?php
                                        $url = ($post_type === 'functions') ? null : get_field('link')['url'];
                                        $title = get_the_title();
                                        $subtitle = get_the_date('M j, Y', get_the_ID());
                                        $new = true;
                                        ?>
                                    <?php include(locate_template('components/card/card-e.php', false, false)); ?>
                            <?php endwhile; ?>

                        </div>
                        <div class="u--display-flex u--justify-content-center f--mt-8">
                            <button class="g--btn-03 g--btn-03--fourth js--load-more-news" data-posts-total="<?php echo $published_posts ?>" data-posts-per-page="<?php echo $posts_per_page ?>" data-offset="<?php echo $offset ?>" data-card-path="<?php echo $cardPath ?>" data-post-type="<?= $postType ?>">
                                <span class="g--btn-03__content">
                                    Load More
                                </span>
                                <?php include(locate_template('assets/frontend/btn-03-plus.svg', false, false)); ?>
                            </button>
                        </div>
                    </div>
                    <div class="f--col-4 f--col-tabletm-12">
                        <?php include(locate_template('components/card/card-j.php', false, false)); ?>
                    </div>
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