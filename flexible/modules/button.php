<?php
$spacing = get_spacing($module['spacing']);
$position_class = match ($module['button_position']) {
    'left'   => 'u--justify-content-start',
    'right'  => 'u--justify-content-flex-end',
    default  => 'u--justify-content-center'
};

$scroll_to_form = $module['scroll_to_form'];
$scroll_to_form_title = $module['scroll_to_form_title'];
$button = $module['button'];
?>

<section class="<?= $spacing ?>">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-12 u--display-flex <?= $position_class; ?>">

                <?php if ($scroll_to_form && $scroll_to_form_title): ?>
                    <a href="#" data-target="form-hero" f-data-distance="50"
                       class="g--btn-03 g--btn-03--second js--scroll-to">
                        <span><?= $scroll_to_form_title; ?></span>
                        <?php include(locate_template('img/btn-03-arrow.svg', false, false)); ?>
                    </a>
                <?php elseif ($button): ?>
                    <a href="<?= esc_url($button['url']) ?>"
                       <?= get_target_link($button['target'], $button['title']) ?>
                       class="g--btn-03 g--btn-03--second">
                        <span><?= $button['title'] ?></span>
                        <?php include(locate_template('img/btn-03-arrow.svg', false, false)); ?>
                    </a>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>

<?php unset($spacing, $button, $position_class, $scroll_to_form, $scroll_button_title); ?>
