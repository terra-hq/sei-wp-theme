<?php if($module['accordion_items']): ?>
<?php if ($module['bg_color'] === 'f--background-c' || $module['bg_color'] === 'f--background-d') $modifier = 'g--accordion-02--second'; ?>
<section class="<?= get_spacing($module['section_spacing']) ?> <?= $module['bg_color'] ?>">
    <div class="f--container">
        <div class="f--row u--justify-content-center">
            <div class="f--col-8 f--col-tabletm-10 f--col-tablets-12">
                <?php foreach($module['accordion_items'] as $key => $accItem): ?>
                <div class="g--accordion-02 <?= $modifier ?> js--accordion-02">
                    <button class="g--accordion-02__hd" type="button" data-accordion02-control="simpleContent02-0<?= $key?>-<?= $keyIndexModule ?>" aria-expanded="false">
                        <span class="g--accordion-02__hd__item-primary"><?= $accItem['accordion_title']?></span>
                        <span class="g--accordion-02__hd__icon" role="presentation">
                            <svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.51953 7.5H14.4795" stroke="#F01840" stroke-width="2" stroke-linecap="square"/>
                                <path d="M8 1.02002V13.98" stroke="#F01840" stroke-width="2" stroke-linecap="square"/>
                            </svg>
                        </span>
                    </button>
                    <div class="g--accordion-02__bd" data-accordion02-content="simpleContent02-0<?= $key?>-<?= $keyIndexModule ?>" aria-hidden="true">
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