
<section class="g--layout-02 <?= $bgColor ?> <?= $spacing ?> <?= $modifierClass ?>">
    <div class="g--layout-02__wrapper">
        <div class="g--layout-02__wrapper__content">
            <h2 class="g--layout-02__wrapper__content__item-primary">
                <?= $title ?>
            </h2>
            <div class="g--layout-02__wrapper__content__item-secondary">
                <p><?= $description ?></p>
            </div>
            <div class="g--layout-02__wrapper__content__list-group">
                <?php if ($btn) : ?>
                    <a href="<?= $btn['url'] ?>" <?= get_target_link($btn['target'], $btn['title'] )?> class="g--layout-02__wrapper__content__list-group__item">
                        <?= $btn['title'] ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>