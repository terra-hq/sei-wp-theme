<?php 
    $modifierText = $module['heading_size'] == 'large' ? 'f--font-c' : 'f--font-e'; 
    $span_size = $module['heading_size'] == 'large' ? 'f--font-d' : 'f--font-k';
    $modifier = '';
    if ($module['bg_color'] === 'f--background-c' || $module['bg_color'] === 'f--background-d') $modifier = 'c--layout-b--second';
?>

<section class="c--layout-b <?= $modifier ?> <?= $module['bg_color']?> <?= get_spacing($module['section_spacing']) ?> <?= $module['heading_size'] == 'large' ? 'c--layout-b--large' : '';?>">
    <div class="f--container">
        <div class="f--row f--gap-c u--justify-content-space-between">
            <div class="f--col-6 f--col-tabletl-10 f--col-tablets-12">
                <h2 class="c--layout-b__title">
                    <?php if ($module['heading']) {
                        foreach ($module['heading'] as $title) {
                            if ($title['italic']) {
                                echo '<span class="' . $span_size . '">' . $title['text'] . ' ' . '</span>';
                            } else {
                                echo $title['text'] . ' ';
                            }
                        }
                    } ?>
                </h2>
            </div>
            <div class="f--col-5 f--col-tabletl-10 f--col-tablets-12">
                <div class="c--layout-b__content">
                    <?= $module['content'] ?>
                </div>
                <?php if ($module['button']): ?>
                    <a href="<?= $module['button']['url'] ?>" <?= get_target_link($module['button']['target'], $module['button']['title'] )?> class="c--layout-b__btn">
                        <?= $module['button']['title'] ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php unset($modifierText, $span_size, $modifier); ?>