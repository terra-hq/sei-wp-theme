<?php
    $spacing = get_spacing($module['spacing']) ?? 'u--pt-15 u--pb-15';
    $left_label_accordion = $module['left_label_accordion'] ?? '';
    $right_label_accordion = $module['right_label_accordion'] ?? '';
    $accordion_items = $module['accordion_items'] ?? [];
?>

<?php if (!empty($accordion_items)): ?>
<section class="<?= $spacing ?>">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-12">
                <div class="c--accordion-a c--accordion-a--second">
                    <?php $first = true; ?>
                    <?php foreach ($accordion_items as $index => $item): ?>
                        <?php
                            $card_title = $item['title'] ?? '';
                        ?>
                        <div class="c--accordion-a__item">
                            <input type="radio" name="select" class="c--accordion-a__item__btn" <?php echo $first ? 'checked' : ''; ?> />
                            <div class="c--accordion-a__item__hd">
                                <span class="c--accordion-a__item__hd__content"><?= $card_title ?></span>
                            </div>
                            <div class="c--accordion-a__item__wrapper">
                                <div class="c--accordion-a__item__wrapper__content">
                                    <div class="c--card-n">
                                        <div class="c--card-n__wrapper">
                                            <h4 class="c--card-n__wrapper__title"><?= $card_title ?></h4>
                                            <div class="f--row">
                                                <div class="f--col-6 f--col-tablets-12">
                                                    <?php if ($left_label_accordion): ?>
                                                        <div class="c--card-n__wrapper__subtitle">
                                                            <?= $left_label_accordion ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="c--card-n__wrapper__content">
                                                        <?php if (!empty($item['left_content'])): ?>
                                                            <?= $item['left_content'] ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="f--col-6 f--col-tablets-12">
                                                    <?php if ($right_label_accordion): ?>
                                                        <div class="c--card-n__wrapper__subtitle">
                                                            <?= $right_label_accordion ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="c--card-n__wrapper__content">
                                                        <?php if (!empty($item['right_content'])): ?>
                                                            <?= $item['right_content'] ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $first = false; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php unset($spacing, $left_label_accordion, $right_label_accordion, $accordion_items); ?>
