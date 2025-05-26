<section id="form-hero" class="c--hero-h <?php echo get_spacing($module['section_spacing']) ?>">
    <div class="c--hero-h__bg-items"></div>
    <div class="c--hero-h__wrapper">
        <div class="f--row f--gap-c">
            <div class="f--col-6 f--col-tabletm-12">
                <h1 class="c--hero-h__wrapper__title">
                    <?php echo $module['title'] ?>
                </h1>
                <p class="c--hero-h__wrapper__subtitle">
                    <?php echo $module['subtitle'] ?>
                </p>
            </div>
            <div class="f--col-5 f--col-tabletl-6 f--col-tabletm-12 f--offset-1 f--offset-tabletl-0">
                <div class="c--form-d js--hubspot-script" data-form-id="<?php echo $module['form_id'] ?>" data-portal-id="<?php echo $module['form_portal_id'] ?>"></div>
            </div>
        </div>
    </div>
</section>
