<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>
        <?php wp_title('•', true, 'right'); ?>
    </title>
    <?php $favicon = get_field('favicon', 'option') ?>
    <link rel="shortcut icon" type="image/png" href="<?= $favicon; ?>">
    <link rel="icon" href="<?= $favicon; ?>">
    <link rel="apple-touch-icon" href="<?= $favicon; ?>">
    <link rel="apple-touch-icon-precomposed" href="<?= $favicon; ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= $favicon; ?>">

    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php echo esc_url(get_bloginfo('pingback_url')); ?>">

    <meta name="theme-color" content="#FFFFFF">

    <meta name="google-site-verification" content="LcbhbQD6nPKf97ASCAw2IFz3UH7NhT7bUl0VD2pI1LU" />

    <?php wp_head(); ?>

    <?php $headerScripts = get_field('header_scripts', 'option'); ?>
    <?php echo $headerScripts; ?>
    
</head>

<body <?php body_class(); ?>>
    
    <?php $bodyTopScripts = get_field('body_top_scripts', 'option'); ?>
    <?php echo $bodyTopScripts; ?>

    <div class="c--header-wrapper-a">
        <!-- Banner -->
        <div class="f--container f--container--tablets-fluid">
            <?php include(locate_template('components/banner/banner-01.php', false, false)); ?>
        </div>

        <!-- Header -->
        <?php include(locate_template('components/header/header-a.php', false, false)); ?>
    </div>

    <!-- Preloader -->
    <?php include(locate_template('components/preloader/preloader-a.php', false, false)); ?>

    <!-- Cookies -->
    <?php include( locate_template( 'components/cookies/cookies.php', false, false ) ); ?>

    <!-- transitions -->
    <div class="c--transition-a js--transition">
        <div class="c--transition-a__media-wrapper">
            <figure class="g--card-06__media-wrapper">
                <?php
                    $image_tag_args = array(
                        'image' => array( 
                            'url' => get_theme_file_uri('/img/swirl-filled.webp'),
                            'width'  => 312,
                            'height' => 301,
                            'sizes' => array(
                                'thumbnail' => get_theme_file_uri('/img/swirl-filled.webp'),
                                'small' => get_theme_file_uri('/img/swirl-filled.webp'),
                                'medium' => get_theme_file_uri('/img/swirl-filled.webp'),
                                'large' => get_theme_file_uri('/img/swirl-filled.webp'),
                                'tablets' => get_theme_file_uri('/img/swirl-filled.webp'),
                                'mobile' => get_theme_file_uri('/img/swirl-filled.webp'),
                            )
                        ),
                        'sizes' => '56px',
                        'class' => 'c--transition-a__media-wrapper__media',
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
        <svg class="c--transition-a__artwork" viewBox="0 0 100 100" preserveAspectRatio="none">
			<path vector-effect="non-scaling-stroke" d="M 0 100 V 100 Q 50 100 100 100 V 100 z" />
		</svg>
    </div>

    <main id="swup">
        <div id="main-content">