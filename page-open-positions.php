<?php
/*
Template Name: Open Positions
*/
?>
<?php get_header(); ?>

<?php
$hero = [
    'title' => get_field('hero_title'),
    'subtitle' => get_field('hero_subtitle')
]; ?>
<?php include(locate_template('flexible/hero/big-heading-tagline-hero.php', false, false)); ?>

<section class="u--pb-22 u--pb-tablets-15 js--load-all-jobs">
    <div class="f--container">
        <div class="f--row u--justify-content-space-between u--justify-content-tablets-center f--gap-b">
            <div class="f--col-6 f--col-tabletm-7 f--col-tablets-12">
                <div class="f--row f--sp-b f--gap-d">
                    <div class="f--col-6 f--col-mobile-12">
                        <div class="c--filter-a c--filter-a--second">
                            <div class="c--filter-a__item">
                                <select name="js--filter-pratice-areas" id="js--filter-pratice-areas" onchange="this.dataset.chosen = this.value;" data-chosen="all">
                                    <option value>All Practice Areas</option>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="f--col-6 f--col-mobile-12">
                        <div class="c--filter-a c--filter-a--second">
                            <div class="c--filter-a__item">
                                <select name="js--filter-locations" id="js--filter-locations" onchange="this.dataset.chosen = this.value;" data-chosen="all">
                                    <option value>All Locations</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="f--row f--gap-c" id="js--load-all-job-results"></div>
                <div class="g--message-01 js--loading">
                    <div class="g--spinner-01 g--message-01__artwork">
                        <svg viewBox="0 0 26 26" fill="none">
                            <path d="M23.446 9.625c1.063-.344 1.66-1.494 1.155-2.49a13 13 0 1 0-1.085 13.507c.657-.903.251-2.134-.743-2.642-.994-.51-2.198-.095-2.916.76a8.954 8.954 0 1 1 .831-10.352c.573.96 1.695 1.56 2.758 1.217Z" fill="#7F7ED0"></path>
                        </svg>
                    </div>
                    <p class="g--message-01__item-primary">Loading...</p>
                </div>
            </div>
            <div class="f--col-5 f--col-tablets-10 f--col-mobile-12">
                <div class="c--media-c">
                    <?php
                    if (get_field('background_image')) :
                        $image_tag_args = array(
                            'image' => get_field('background_image'),
                            'sizes' => '(max-width: 810px) 95vw, 41vw ',
                            'class' => 'c--media-c__media',
                            'isLazy' => true,
                            'lazyClass' => 'g--lazy-01',
                            'showAspectRatio' => false,
                            'decodingAsync' => true,
                            'fetchPriority' => false,
                            'addFigcaption' => false,
                        );
                        generate_image_tag($image_tag_args);
                    endif;
                    ?>
                    <div class="c--media-c__wrapper">
                        <div class="c--media-c__wrapper__item-left">
                            <?php
                            if (get_field('glassdoor_logo')) :
                                $image_tag_args = array(
                                    'image' => get_field('glassdoor_logo'),
                                    'sizes' => '135px',
                                    'class' => 'c--media-c__wrapper__item-left__media',
                                    'isLazy' => true,
                                    'lazyClass' => 'g--lazy-01',
                                    'showAspectRatio' => true,
                                    'decodingAsync' => true,
                                    'fetchPriority' => false,
                                    'addFigcaption' => false,
                                );
                                generate_image_tag($image_tag_args);
                            endif;
                            ?>
                            <div class="c--media-c__wrapper__item-left__item" style="--rate: <?php echo get_field('rating') ?>">
                                <p class="c--media-c__wrapper__item-left__item__title"><?php echo get_field('rating') ?></p>
                                <div class="c--media-c__wrapper__item-left__item__media-wrapper">
                                    <figure>
                                        <?php
                                            $image_tag_args = array(
                                                'image' => array( 
                                                    'url' => get_theme_file_uri('/img/five-stars-white.svg'),
                                                    'width'  => 312,
                                                    'height' => 301,
                                                    'sizes' => array(
                                                        'thumbnail' => get_theme_file_uri('/img/five-stars-white.svg'),
                                                        'small' => get_theme_file_uri('/img/five-stars-white.svg'),
                                                        'medium' => get_theme_file_uri('/img/five-stars-white.svg'),
                                                        'large' => get_theme_file_uri('/img/five-stars-white.svg'),
                                                        'tablets' => get_theme_file_uri('/img/five-stars-white.svg'),
                                                        'mobile' => get_theme_file_uri('/img/five-stars-white.svg'),
                                                    )
                                                ),
                                                'sizes' => '149px',
                                                'class' => 'c--media-c__wrapper__item-left__item__media-wrapper__media g--lazy-01',
                                                'isLazy' => false,
                                                'showAspectRatio' => true,
                                                'decodingAsync' => true,
                                                'fetchPriority' => false,
                                                'addFigcaption' => false,
                                            );

                                            generate_image_tag($image_tag_args);
                                        ?>
                                    </figure>
                                    <div class="c--media-c__wrapper__item-left__item__media-wrapper__artwork">
                                        <figure>
                                            <?php
                                                $image_tag_args = array(
                                                    'image' => array( 
                                                        'url' => get_theme_file_uri('/img/five-stars-white.svg'),
                                                        'width'  => 312,
                                                        'height' => 301,
                                                        'sizes' => array(
                                                            'thumbnail' => get_theme_file_uri('/img/five-stars-white.svg'),
                                                            'small' => get_theme_file_uri('/img/five-stars-white.svg'),
                                                            'medium' => get_theme_file_uri('/img/five-stars-white.svg'),
                                                            'large' => get_theme_file_uri('/img/five-stars-white.svg'),
                                                            'tablets' => get_theme_file_uri('/img/five-stars-white.svg'),
                                                            'mobile' => get_theme_file_uri('/img/five-stars-white.svg'),
                                                        )
                                                    ),
                                                    'sizes' => '149px',
                                                    'class' => 'c--media-c__wrapper__item-left__item__media-wrapper__artwork__media g--lazy-01',
                                                    'isLazy' => false,
                                                    'showAspectRatio' => true,
                                                    'decodingAsync' => true,
                                                    'fetchPriority' => false,
                                                    'addFigcaption' => false,
                                                );

                                                generate_image_tag($image_tag_args);
                                            ?>
                                        </figure>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="c--media-c__wrapper__item-right">
                            <div class="c--media-c__wrapper__item-right__item">
                                <p class="c--media-c__wrapper__item-right__item__title"><?php echo get_field('percentage_one') ?></p>
                                <p class="c--media-c__wrapper__item-right__item__subtitle"><?php echo get_field('percentage_one_legend') ?></p>
                            </div>
                            <div class="c--media-c__wrapper__item-right__item">
                                <p class="c--media-c__wrapper__item-right__item__title"><?php echo get_field('percentage_two') ?></p>
                                <p class="c--media-c__wrapper__item-right__item__subtitle"><?php echo get_field('percentage_two_legend') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>