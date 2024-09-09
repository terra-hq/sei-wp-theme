<?php get_header() ?>
<h1>
    <a href="<?= esc_url( home_url( '/' ) ) ?>">Go Home</a>
    <div id="js--vue"></div>
    <?= generate_image_tag(get_field('home'),"" , "test g--lazy-01", true) ?>
</h1>
<?php get_footer() ?>