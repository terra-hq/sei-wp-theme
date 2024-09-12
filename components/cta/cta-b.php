<div class="c--cta-b">
    <div class="c--zoom-section-b">
        <div class="c--zoom-section-b__media-wrapper js--zoom-b" data-hero="false">
            <img
                data-srcset="<?php bloginfo('template_url'); ?>/assets/frontend/background/cta-b-810.webp 810w,
                    <?php bloginfo('template_url'); ?>/assets/frontend/background/cta-b-1300.webp 1300w,
                    <?php bloginfo('template_url'); ?>/assets/frontend/background/cta-b-810-2x.webp 1620w,
                    <?php bloginfo('template_url'); ?>/assets/frontend/background/cta-b-1300-2x.webp 2600w,
                    <?php bloginfo('template_url'); ?>/assets/frontend/background/cta-b-bg2.webp 4096w"
                data-src="<?php bloginfo('template_url'); ?>/assets/frontend/background/cta-b-bg2.webp"
                sizes="100vw"
                class="c--zoom-section-b__media-wrapper__media g--lazy-01" 
                width="4096"
                height="2304"
                style="aspect-ratio: 4096 / 2304"
                decoding="async"
            >
        </div>
    </div>
    <div class="c--cta-b__wrapper">
        <div class="f--container">
            <div class="f--row f--gap-c u--justify-content-center">
                <div class="f--col-8 f--col-tabletm-12">
                    <h3 class="c--cta-b__wrapper__title">
                        <?php
                            if ($title) {
                                foreach ($title as $t) {
                                    if ($t['italic']) {
                                        echo '<span class="c--cta-b__wrapper__title__artwork">' . $t['text'] . '</span>';
                                    } else {
                                        echo $t['text'] . ' ';
                                    }
                                }
                            }
                        ?>
                    </h3>
                    <p class="c--cta-b__wrapper__subtitle">
                        <?= $description ?>
                    </p>
                    <div class="c--cta-b__wrapper__list-group">
                        <?php if ($list): ?>
                            <?php foreach ($list as $title): ?>
                                <span class="c--cta-b__wrapper__list-group__list-item">
                                    <?php echo $title; ?>
                                </span>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <a href="<?= $card_url ?>" rel="noopener noreferrer" class="c--cta-b__wrapper__list-group__btn">
                            <span class="g--btn-03__content">
                                See All
                            </span>
                            <?php include(locate_template('img/btn-03-arrow.svg', false, false)); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>