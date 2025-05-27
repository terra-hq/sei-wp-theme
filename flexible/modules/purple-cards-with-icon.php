<?php
    $spacing = get_spacing($module['spacing']);
    $bgColor = $module['bg_color'];
    $cards = $module['cards'];
?>

<section class="<?= $bgColor ?> <?= $spacing ?>">
    <div class="f--container">
        <div class="f--row f--row--remove-gutter u--justify-content-center">
            <div class="f--col-4 f--col-tablets-8 f--col-mobile-12 u--display-flex">
                <?php
                    $description = $cards[0]['description'];
                    $image = $cards[0]['image'];
                    include(locate_template('components/card/card-01.php', false, false));
                ?>
            </div>
            <div class="f--col-4 f--col-tablets-8 f--col-mobile-12 u--display-flex">
                <?php
                    $modifierClass = 'second';
                    $description = $cards[1]['description'];
                    $image = $cards[1]['image'];
                    include(locate_template('components/card/card-01.php', false, false));
                ?>
            </div>
            <div class="f--col-4 f--col-tablets-8 f--col-mobile-12 u--display-flex">
                <?php
                    $modifierClass = 'third';
                    $description = $cards[2]['description'];
                    $image = $cards[2]['image'];
                    include(locate_template('components/card/card-01.php', false, false));
                ?>
            </div>
        </div>
    </div>
</section>

<?php unset($spacing, $bgColor, $cards, $description, $image, $modifierClass); ?>