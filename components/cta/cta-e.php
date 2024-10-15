<?php if ($module['cta_link']) : ?>
    <a href="<?php echo $module['cta_link']['url'] ?>" class="c--cta-e">
        <img data-src="<?php bloginfo('template_url'); ?>/img/bg/cta-e-bg-02.webp" 
            class="c--cta-e__bg-items g--lazy-01" 
        >
        <div class="c--cta-e__wrapper">
            <div class="c--cta-e__wrapper__icon"></div>
            <h3 class="c--cta-e__wrapper__title">
                <?php echo $module['cta_link']['title'] ?>
            </h3>
        </div>
    </a>
<?php endif; ?>