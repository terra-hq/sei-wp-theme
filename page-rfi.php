<?php
/*
Template Name: RFI
*/
?>
<?php get_header(); ?>


<?php
$hero_title = get_field('hero_title');
$hero_subtitle = get_field('hero_subtitle');
$hero_form_id = get_field('hero_form_id');
$hero_form_portal = get_field('hero_form_portal');
$hero_h1 = true;
include (locate_template('components/hero/hero-h.php', false, false));
?>


<?php get_footer(); ?>