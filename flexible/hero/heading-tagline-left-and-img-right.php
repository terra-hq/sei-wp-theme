<?php 
    $title = $hero['title'];
    $subtitle = $hero['subtitle'];
    $image = get_field('icon_color', $post->ID);
?>
<?php include(locate_template('components/hero/hero-e.php', false, false)); ?>