<section id="form-hero" class="c--hero-h <?= $customClass ?>">
    <div class="c--hero-h__bg-items"></div>
    <div class="c--hero-h__wrapper">
        <div class="f--row f--gap-c">
            <div class="f--col-6 f--col-tabletm-12">
                <?php if ($hero_h1 && $keyIndexModule == 0) { ?>
                    <h1 class="c--hero-h__wrapper__title">
                        <?= $hero_title ?>
                    </h1>
                <?php } else { ?>
                    <h2 class="c--hero-h__wrapper__title">
                        <?= $hero_title ?>
                    </h2>
                <?php } ?>
                <?php if($hero_subtitle && $hero_subtitle !== '') : ?>
                    <p class="c--hero-h__wrapper__subtitle">
                        <?= $hero_subtitle ?>
                    </p>
                <?php endif; ?>
                </div>
            <?php if($hero_form_id && $hero_form_portal) : ?>
                <div class="f--col-5 f--col-tabletl-6 f--col-tabletm-12 f--offset-1 f--offset-tabletl-0">
                    <div class="c--form-d js--hubspot-script" data-form-id="<?= $hero_form_id ?>" data-portal-id="<?= $hero_form_portal ?>"></div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>