<?php
$spacing = get_spacing($module['spacing'] ?? '');

$eyebrow = $module['eyebrow'] ?? '';
$title = $module['title'] ?? '';
$description = $module['description'] ?? '';
$accordion_items = $module['accordion_items'] ?? [];
$modifier = 'g--accordion-02--third';
?>

<section class="<?= $spacing ?>">
    <div class="f--container">
        <div class="f--row f--gap-c">
            <div class="f--col-5 f--col-laptop-6 f--col-tabletl-12">
                <div class="c--sticky-a">
                    <?php if (!empty($eyebrow)) : ?>
                        <span class="f--font-i u--font-medium u--text-uppercase f--color-c">
                            <?= esc_html($eyebrow); ?>
                        </span>
                    <?php endif; ?>

                    <?php if (!empty($title)) : ?>
                        <h2 class="f--font-c f--color-b u--mt-2">
                            <?= esc_html($title); ?>
                        </h2>
                    <?php endif; ?>

                    <?php if (!empty($description)) : ?>
                        <p class="f--font-i u--mt-3">
                            <?= esc_html($description); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="f--col-6 f--col-tabletl-12 f--offset-1 f--offset-laptop-0">
                <?php if (!empty($accordion_items)) : ?>
                    <?php foreach ($accordion_items as $key => $accItem) : ?>
                        <div class="g--accordion-02 <?= $modifier ?> js--accordion-02">
                            <button class="g--accordion-02__hd" type="button"
                                    data-accordion02-control="acc-0<?= $key ?>-<?= $keyIndexModule ?>" aria-expanded="false">
                                <div class="g--accordion-02__hd__item-primary">
                                    <?php if ($modifier === 'g--accordion-02--third'): ?>
                                        <span class="f--color-c"><?= $key < 9 ? '0' : '' ?><?= $key + 1 ?>&nbsp;</span>
                                    <?php endif; ?>
                                    <span><?= esc_html($accItem['accordion_title']) ?></span>
                                </div>
                                <span class="g--accordion-02__hd__icon" role="presentation">
                                </span>
                            </button>
                            <div class="g--accordion-02__bd"
                                 data-accordion02-content="acc-0<?= $key ?>-<?= $keyIndexModule ?>" aria-hidden="true">
                                <div class="g--accordion-02__bd__content">
                                    <?= $accItem['accordion_title_copy'] ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php unset($spacing, $eyebrow, $title, $description, $accordion_items, $modifier); ?>