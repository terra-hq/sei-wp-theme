<?php
$bg_color = $module['bg_color'];
$spacing = get_spacing($module['section_spacing']);
$legend = $module['legend'];
$title = $module['title'];
$content = $module['content'];
$button = $module['button'];
$button_type = $module['button_type'];
$anchor_title = $module['anchor_title'];
$anchor_id = $module['anchor_id'];
?>

<section class="c--layout-a <?= $bg_color === 'f--background-b' ? 'c--layout-a--second' : '' ?> <?= $spacing ?>">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-6 f--col-tabletl-7 f--col-tablets-12">
                <h2 class="c--layout-a__title"><?= $legend ?></h2>
                <h3 class="c--layout-a__subtitle"><?= $title ?></h3>
                <div class="c--layout-a__content c--content-a c--content-a--third-text">
                    <?= $content ?>
                </div>
                <?php if ($button && $button_type == 'button'): ?>
                    <a href="<?= $button['url'] ?>" class="c--layout-a__btn"><?= $button['title'] ?></a>
                <?php endif; ?>
                <?php if ($anchor_title &&  $anchor_id && $button_type == 'anchor'): ?>
                    <button tf-data-target="<?= $anchor_id ?>" tf-data-distance="0"
                            class="c--layout-a__btn js--scroll-to">
                        <?= $anchor_title; ?>
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="c--layout-a__media-wrapper">
        <img src="<?php bloginfo('template_url'); ?>/img/swirl.webp" alt="" class="c--layout-a__media-wrapper__media">
    </div>
</section>

<?php unset($bg_color, $spacing, $legend, $title, $content, $button); ?>
