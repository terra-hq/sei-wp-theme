<?php
    $title = $module['heading'];
    $title_size = $module['heading_size'];
    $bgColor = $module['bg_color'];
    $text_center = $module['text_center'] ? "u--text-center" : "";
    if ($bgColor === 'f--background-c' || $bgColor === 'f--background-d') $color = 'f--color-a'; // white
    else $color = 'f--color-b'; // black
    $btn = $module['header_button'];
    $spacing = get_spacing($module['section_spacing']);

    include(locate_template('components/heading/heading-a.php', false, false));
?>