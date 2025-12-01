<?php
$spacing = get_spacing($module['section_spacing'] ?? '');
$slider_items = $module['slider_items'] ?? [];
?>

<section class="c--slider-c <?= htmlspecialchars($spacing, ENT_QUOTES); ?>">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-12">
                <div class="c--slider-c__wrapper js--slider-a">

                    <?php if (!empty($slider_items)) : ?>
                        <?php foreach ($slider_items as $item) : ?>
                            <div class="c--slider-c__wrapper__item">
                                <?php
                                    $title = $item['title'] ?? '';
                                    $columns_left_label = $item['columns_left_label'] ?? '';
                                    $columns_left_content = $item['columns_left_content'] ?? '';
                                    $columns_right_label = $item['columns_right_label'] ?? '';
                                    $columns_right_content = $item['columns_right_content'] ?? '';
                                    $bottom_label = $item['bottom_label'] ?? '';
                                    $bottom_cards = $item['bottom_cards'] ?? [];
                                    $image = $item['image'] ?? null;
                                    $button_label = $item['button_label'] ?? '';
                                    $button_link = $item['button_link'] ?? '#';
                                    $pills = $item['pills'] ?? [];
                                    $form_title = $module['form_title'];
                                    $form_id = $module['form_id'];
                                    $form_portal_id = $module['form_portal_id'];
                                    include(locate_template('components/card/card-o.php', false, false));
                                ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</section>

<?php include(locate_template('components/modal/modal-a.php', false, false)); ?>

<?php unset($spacing, $slider_items, $title, $columns_left_label, $columns_left_content, $columns_right_label, $columns_right_content, $bottom_label, $bottom_cards, $image, $button_label, $button_link, $pills, $form_title, $form_id, $form_portal_id); ?>
