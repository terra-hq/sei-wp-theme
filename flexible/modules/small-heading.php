<?php
$title = $module['heading'];
$bgColor = $module['bg_color']; //$module['bgColor'];
if ($bgColor === 'f--background-c' || $bgColor === 'f--background-d') { //morados
    $color = 'f--color-a'; //blanco
} else {
    $color = 'f--color-c'; //rojo
}
$spacing = get_spacing($module['section_spacing']);
include(locate_template('components/heading/heading-c.php', false, false));
?>

<?php
unset($title, $bgColor, $color, $spacing);
?>