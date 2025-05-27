

<?php
$customClass = 'c--hero-h--second ' . get_spacing($module['spacing']);
$hero_title = $module['title'];
$hero_subtitle = $module['subtitle'];
$hero_form_id = $module['form_id'];
$hero_form_portal = $module['form_portal_id'];
include (locate_template('components/hero/hero-h.php', false, false));
unset($customClass, $hero_title, $hero_subtitle, $hero_form_id, $hero_form_portal);
?>