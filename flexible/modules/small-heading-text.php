<?php
    $spacing = get_spacing($module['spacing']);
    $bgColor = $module['bg_color'];
    if ($bgColor === 'f--background-c' || $bgColor === 'f--background-d') $modifierClass = 'g--layout-02--second';
    $title = $module['title'];
    $description = $module['description'];
    $btn = $module['btn'];
    include(locate_template('components/layout/layout-02.php', false, false)); 
?>

<?php
    unset($spacing, $bgColor, $modifierClass, $title, $description, $btn);
?>