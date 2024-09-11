<section class="c--layout-a <?php echo $module['bg_color'] == 'f--background-b' ? 'c--layout-a--second' : '' ?> <?= get_spacing($module['section_spacing']); ?>">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-6 f--col-tabletl-7 f--col-tablets-12">
                <h2 class="c--layout-a__title"><?php echo $module['legend'] ?></h2>
                <h3 class="c--layout-a__subtitle"><?php echo $module['title'] ?></h3>
                <div class="c--layout-a__content c--content-a c--content-a--third-text">
                    <?php echo $module['content'] ?>
                </div>
                <?php if($module['button']): ?>
                    <a href="<?php echo $module['button']['url'] ?>" class="c--layout-a__btn"><?php echo $module['button']['title'] ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="c--layout-a__media-wrapper">
        <img src="<?php bloginfo('template_url'); ?>/public/assets/swirl.webp" alt="" class="c--layout-a__media-wrapper__media">
    </div>
</section>