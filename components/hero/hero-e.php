<section class="c--hero-e">
    <div class="c--zoom-section-b">
        <div class="c--zoom-section-b__media-wrapper f--background-b js--zoom-b" data-hero="true"></div>
    </div>
    <div class="c--hero-e__wrapper">
        <div class="c--hero-e__wrapper__item-left">
            <h1 class="c--hero-e__wrapper__item-left__title"><?= $title; ?></h1>
            <div class="c--hero-e__wrapper__item-left__subtitle c--content-a c--content-a--third-text">
                <p><?= $subtitle; ?></p>
            </div>
        </div>
        <div class="c--hero-e__wrapper__item-right">
            <?php
                $image_tag_args = array(
                    'image' => $image,
                    'sizes' => '350px',
                    'class' => 'c--hero-e__wrapper__item-right__media',
                    'isLazy' => false,
                    'showAspectRatio' => true,
                    'decodingAsync' => false,
                    'fetchPriority' => true,
                    'addFigcaption' => false,
                );
                generate_image_tag($image_tag_args)
            ?>
        </div>
    </div>
</section>