<?php
    $spacing = get_spacing($module['spacing']);
    $bgColor = $module['bg_color'];
    $title = $module['title'];
    $description = $module['description'];
    $choose_post_type = $module['choose_post_type'];

    if ($choose_post_type === 'functions') {
        $list = $module['functions_selector'];
    } else {
        $list = $module['industries_selector'];
    }
    $card_url = "/" . $choose_post_type;
?>

<section class="<?= $bgColor ?> <?= $spacing ?>">
    <?php include (locate_template('components/cta/cta-b.php', false, false)); ?>
</section>

<?php unset($spacing, $bgColor, $title, $description, $choose_post_type, $list, $card_url); ?>