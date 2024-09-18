<?php
$bgColor = $module['bg_color'];
$spacing = get_spacing($module['spacing']);
$content = $module['content'];
?>

<section class="<?= $bgColor ?> <?= $spacing ?>">
    <div class="f--container">
        <div class="f--row u--justify-content-flex-end">
            <div class="f--col-8 f--col-tabletm-12">
                <div
                    class="c--content-a <?= $bgColor == 'f--background-c' || $bgColor == 'f--background-d' ? 'c--content-a--second-color' : '' ?>">
                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>
</section>