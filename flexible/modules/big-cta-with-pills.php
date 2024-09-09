<?php
    $spacing = get_spacing($module['spacing']);
    $bgColor = $module['bg_color'];
    $title = $module['title'];
    $description = $module['description'];
    $choose_post_type = $module['choose_post_type'];

    function get_post_titles($post_selector) {
        $titles = [];
        foreach ($post_selector as $post_id) {
            $titles[] = get_the_title($post_id);
        }
        return $titles;
    }

    if ($choose_post_type === 'functions') {
        $list = get_post_titles($module['functions_selector']);
    } else {
        $list = get_post_titles($module['industries_selector']);
    }
    $card_url = "/" . $choose_post_type;
?>

<section class="<?= $bgColor ?>">
    <?php include (locate_template('components/cta/cta-b.php', false, false)); ?>
</section>