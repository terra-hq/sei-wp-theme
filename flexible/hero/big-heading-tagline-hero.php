<?php 
    $title = $hero['title'];
    $subtitle = $hero['subtitle'];
?>

<section class="g--hero-04">
    <div class="g--hero-04__ft-items">
        <div class="g--hero-04__ft-items__wrapper">
            <div class="g--hero-04__ft-items__wrapper__content">
                <h1 class="g--hero-04__ft-items__wrapper__content__item-primary">
                    <?php if ($title) {
                        foreach ($title as $t) {
                            if ($t['italic']) {
                                echo '<span class="f--font-d">' . $t['text'] . '</span>';
                            } else {
                                echo $t['text'] . ' ';
                            }
                        }
                    } ?>
                </h1>
                <div class="g--hero-04__ft-items__wrapper__content__list-group">
                    <p class="g--hero-04__ft-items__wrapper__content__list-group__item"><?php echo $subtitle ?></p>
                </div>
            </div>
        </div>
    </div>
</section>