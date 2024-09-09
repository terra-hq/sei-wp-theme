<section class="c--footer-a">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-5 f--col-tabletm-12">
                <h3 class="c--footer-a__title">
                    <?php echo get_field('footer_title', 'option') ?>
                </h3>
                <p class="c--footer-a__subtitle">
                    <?php echo get_field('footer_subtitle', 'option') ?>
                </p>
            </div>
            <div class="f--col-6 f--col-tabletm-12 f--offset-1 f--offset-tabletm-0">
                <div class="c--form-a">
                    <?php $form_shortcode = get_field('footer_form', 'option');
                    if ($form_shortcode) {
                        echo do_shortcode($form_shortcode);
                    } ?>
                </div>
            </div>
        </div>
    </div>
    <hr class="c--footer-a__dash">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-12">
                <div class="c--footer-a__wrapper">
                    <img src="<?php echo get_field('footer_logo', 'option')['url'] ?>" sizes="(max-width: 810px) 50vw, 33vw" alt="footer logo" class="c--footer-a__wrapper__logo">
                    <div class="c--footer-a__wrapper__list-group">
                        <?php if (get_field('privacy_link', 'option')) : ?>
                            <a href="<?php echo get_field('privacy_link', 'option')['url'] ?>" target="_blank" rel="noreferrer noopener" class="c--footer-a__wrapper__list-group__link">
                                <?php echo get_field('privacy_link', 'option')['title'] ?>
                            </a>
                        <?php endif; ?>
                        <p class="c--footer-a__wrapper__list-group__list-item">
                            © <?php echo get_field('copyright_text', 'option') ?> <?php echo date('Y') ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>