<?php if($module['accordion_items']): ?>
<?php if ($module['bg_color'] === 'f--background-c' || $module['bg_color'] === 'f--background-d') $modifier = 'g--accordion-02--second'; ?>
<section class="<?= get_spacing($module['section_spacing']) ?> <?= $module['bg_color'] ?>">
    <div class="f--container">
        <div class="f--row u--justify-content-center">
            <div class="f--col-8 f--col-tabletm-10 f--col-tablets-12">
                <?php foreach($module['accordion_items'] as $key => $accItem): ?>
                <div class="g--accordion-02 <?= $modifier ?> js--accordion-02">
                    <button class="g--accordion-02__hd" type="button" data-accordion02-control="acc-0<?= $key?>-<?= $keyIndexModule ?>" aria-expanded="false">
                        <span class="g--accordion-02__hd__item-primary"><?= $accItem['accordion_title']?></span>
                        <span class="g--accordion-02__hd__icon" role="presentation"></span>
                    </button>
                    <div class="g--accordion-02__bd" data-accordion02-content="acc-0<?= $key?>-<?= $keyIndexModule ?>" aria-hidden="true">
                        <div class="g--accordion-02__bd__content">
                            <?= $accItem['accordion_title_copy']?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php unset($accordion_items, $bg_color, $section_spacing, $modifier); ?>