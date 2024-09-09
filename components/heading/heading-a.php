<section class="c--heading-a <?= isset($title_size) ? "c--heading-a--$title_size" : "" ?> <?= $spacing ?> <?= $bgColor ?>">
    <div class="f--container">
        <div class="f--row f--gap-c u--justify-content-space-between">
            <?php if ($btn && !$text_center): ?>
                <div class="f--col-8 f--col-tablets-12">
                    <h2 class="c--heading-a__title <?= $color ?>">
                        <?= $title ?>
                    </h2>
                </div>
                <div class="f--col-4 f--col-tablets-12 u--display-flex">
                    <a href="<?= $btn['url'] ?>" class="c--heading-a__btn" <?= get_target_link($btn['target'], $btn['title'] )?>>
                        <span class="g--btn-03__content">
                            <?= $btn['title'] ?>
                        </span>
                        <?php include(locate_template('assets/frontend/btn-03-arrow.svg', false, false)); ?>
                    </a>
                </div>
            <?php elseif ($btn && $text_center): ?>
                <div class="f--col-12">
                    <h2 class="c--heading-a__title <?= $color ?> <?= $text_center ?>">
                        <?= $title ?>
                    </h2>
                </div>
                <div class="f--col-12 u--display-flex u--justify-content-center">
                    <a href="<?= $btn['url'] ?>" class="c--heading-a__btn c--heading-a__btn--is-centered" <?= get_target_link($btn['target'], $btn['title'] )?>>
                        <span class="g--btn-03__content">
                            <?= $btn['title'] ?>
                        </span>
                        <?php include(locate_template('assets/frontend/btn-03-arrow.svg', false, false)); ?>
                    </a>
                </div>
            <?php elseif ($text_center): ?>
                <div class="f--col-12">
                    <h2 class="c--heading-a__title <?= $color ?> <?= $text_center ?>">
                        <?= $title ?>
                    </h2>
                </div>
            <?php else: ?>
                <div class="f--col-6 f--col-tabletm-8 f--col-tablets-12">
                    <h2 class="c--heading-a__title <?= $color ?>">
                        <?= $title ?>
                    </h2>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>