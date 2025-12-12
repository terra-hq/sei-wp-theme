<?php
$spacing = get_spacing($module['section_spacing']);
$bg_color = trim($module['bg_color']);
$heading = $module['heading'];
$text = $module['text'];

$bg_classes = [
    'f--background-d' => '',                     // dark purple
    'f--background-c' => 'g--layout-01--second', // light purple
    'f--background-b' => 'g--layout-01--third',  // grey
    'f--background-a' => 'g--layout-01--fourth', // white
];

$layout_modifier = isset($bg_classes[$bg_color]) ? $bg_classes[$bg_color] : '';
?>

<section class="g--layout-01 <?= $spacing; ?><?= $layout_modifier ? ' ' . $layout_modifier : ''; ?>">
    <div class="g--layout-01__wrapper">
        <div class="g--layout-01__wrapper__content">
            <h2 class="g--layout-01__wrapper__content__item-primary">
                <?= $heading; ?>
            </h2>
            <div class="g--layout-01__wrapper__content__list-group">
                <p class="g--layout-01__wrapper__content__list-group__item">
                    <?= $text; ?>
                </p>
            </div>
        </div>
    </div>
</section>

<?php unset($spacing, $bg_color, $heading, $text); ?>
