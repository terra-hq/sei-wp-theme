<?php
/*
Template Name: Modules
*/
?>
<?php get_header() ?>

<?php $heros = get_field('heros');
if ($heros) { 
    foreach ($heros as $keyIndexHero => $hero):
       include(locate_template('flexible/hero/index.php', false, false)); 
    endforeach;
} ?>

<?php include(locate_template('flexible/modules/quiz.php', false, false)); ?>

<?php $modules = get_field('modules');
if ($modules) { 
    foreach ($modules as $keyIndexModule => $module):
       include(locate_template('flexible/modules/index.php', false, false)); 
    endforeach;
} ?>

<?php get_footer() ?>