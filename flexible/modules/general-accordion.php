<?php
    $spacing = get_spacing($module['spacing']);
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
                                    <div class="u--display-flex u--width-100 f--background-g u--pt-7 u--pb-7 u--pl-6 u--pr-6">
                                        <div class="u--display-flex u--flex-direction-column u--width-100">
                                            <h4 class="f--font-f f--color-a u--mb-3"><?= $card_title ?></h4>
                                            <div class="f--row">
                                                <div class="f--col-6 f--col-tablets-12">
                                                    <?php if ($left_label_accordion): ?>
                                                        <div class="f--font-i f--color-a u--font-bold u--mb-2">
                                                            <?= $left_label_accordion ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="c--content-a c--content-a--second-color u--mb-5">
                                                        <?php if (!empty($item['left_content'])): ?>
                                                            <?= $item['left_content'] ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="f--col-6 f--col-tablets-12">
                                                    <?php if ($right_label_accordion): ?>
                                                        <div class="f--font-i f--color-a u--font-bold u--mb-2">
                                                            <?= $right_label_accordion ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="c--content-a c--content-a--second-color u--mb-5">
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
