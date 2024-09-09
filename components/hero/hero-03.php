<section class="g--hero-03<?php if ($modifierClass) { echo " g--hero-03--$modifierClass";}; ?>">
    <?php if (!$modifierClass) { ?>
        <div class="g--hero-03__bg-items"></div>
    <?php } ?>
    <div class="g--hero-03__ft-items">
        <div class="g--hero-03__ft-items__wrapper">
            <div class="g--hero-03__ft-items__wrapper__content">
                <h1 class="g--hero-03__ft-items__wrapper__content__item-primary">
                    <?php if ($title) {
                        foreach ($title as $e) {
                            $text = $e['text'];
                            $italic = $e['italic'];
                            if ($italic) {
                                echo '<span class="f--font-d">' . $text . '</span>';
                            } else {
                                echo $text . ' ';
                            }
                        }
                    } ?>
                </h1>
            </div>
        </div>
    </div>
</section>