<?php

$media = $module['image']; 
$subtitle = $module['label'];
$title = $module['title'];
$tag = $module['subtitle'];
$btn = $module['button'];

include(locate_template('components/cta/cta-a.php'));

unset($media, $subtitle, $title, $tag, $btn);

?>