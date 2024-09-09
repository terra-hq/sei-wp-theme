<?php 
    $spacing = get_spacing($module['section_spacing']);
    $bgColor = $module['bg_color'];
    $cards = $module['cards'];
?>

<section class="<?= $bgColor ?> <?= $spacing ?>">
    <div class="f--container">
        <div class="f--row f--row--remove-gutter">
            <!-- light one -->
            <div class="f--col-4 f--col-tablets-6 f--col-mobile-12 u--display-flex">
                <div class="c--stats-a">
                    <h3 class="c--stats-a__title js--counter"><?= $cards[0]['title'] ?></h3>
                    <p class="c--stats-a__subtitle"><?= $cards[0]['subtitle']?></p>
                </div>
            </div>
            <!-- medium one -->
            <div class="f--col-4 f--col-tablets-6 f--col-mobile-12 u--display-flex">
                <div class="c--stats-a c--stats-a--second">
                    <h3 class="c--stats-a__title js--counter"><?= $cards[1]['title'] ?></h3>
                    <p class="c--stats-a__subtitle"><?= $cards[1]['subtitle'] ?></p>
                </div>
            </div>
            <!-- dark one -->
            <div class="f--col-4 f--col-tablets-6 f--col-mobile-12 u--display-flex">
                <div class="c--stats-a c--stats-a--third">
                    <h3 class="c--stats-a__title js--counter"><?= $cards[2]['title'] ?></h3>
                    <p class="c--stats-a__subtitle"><?= $cards[2]['subtitle'] ?></p>
                </div>
            </div>
        </div>
    </div>
</section>