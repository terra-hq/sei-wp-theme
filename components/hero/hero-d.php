<?php
    $title = $hero['title'];
    $subtitle = $hero['subtitle'];
    $image = $hero['image'];
?>

<section class="c--hero-d">
<div class="c--zoom-section-b">
        <div class="c--zoom-section-b__media-wrapper js--zoom-b" data-hero="true">
            <?php if ($image) : ?>
                <?php $image_tag_args = array(
                        'image' => $image,
                        'sizes' => 'large',
                        'class' => 'c--zoom-section-b__media-wrapper__media"',
                        'isLazy' => false,
                        'showAspectRatio' => false,
                        'decodingAsync' => false,
                        'fetchPriority' => true,
                        'addFigcaption' => false,
                    );
                    generate_image_tag($image_tag_args)
                ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="f--container">
        <div class="f--row f--gap-c u--justify-content-center">
            <div class="f--col-10 f--col-mobile-12">
                <div class="c--hero-d__wrapper">
                    <h1 class="c--hero-d__wrapper__title"> <?= $title ?> </h1>
                    <p class="c--hero-d__wrapper__subtitle"> <?= $subtitle ?> </p>
                </div>
            </div>
        </div>
    </div>
</section>