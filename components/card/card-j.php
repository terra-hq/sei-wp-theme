<div class="c--card-j">
    <div class="c--card-j__wrapper">
        <div class="c--card-j__wrapper__item-left">
            <h3 class="c--card-j__wrapper__item-left__title">
                <?php echo get_field('side_cta_title', $page_id) ?>
            </h3>
            <p class="c--card-j__wrapper__item-left__subtitle">
                <?php echo get_field('side_cta_subtitle', $page_id) ?>
            </p>
        </div>
        <div class="c--card-j__wrapper__item-right">
            <div class="c--card-j__wrapper__item-right__item-left">
                <?php if (get_field('side_cta_persons_image', $page_id)) : ?>
                    <?php $image_tag_args = array(
                            'image' => get_field('side_cta_persons_image', $page_id),
                            'sizes' => '200px',
                            'class' => 'c--card-j__wrapper__item-right__item-left__media',
                            'isLazy' => true,
                            'lazyClass' => 'g--lazy-01',
                            'showAspectRatio' => true,
                            'decodingAsync' => true,
                            'fetchPriority' => false,
                            'addFigcaption' => false,
                        );
                        generate_image_tag($image_tag_args) ?>
                <?php endif; ?>
            </div>
            <div class="c--card-j__wrapper__item-right__item-right">
                <p class="c--card-j__wrapper__item-right__item-right__title">
                    <?php echo get_field('side_cta_persons_name', $page_id) ?>
                </p>
                <?php if (get_field('side_cta_persons_email', $page_id)) : ?>
                    <a class="c--card-j__wrapper__item-right__item-right__link" href="mailto:<?php echo get_field('side_cta_persons_email', $page_id) ?>"><?php echo get_field('side_cta_persons_email', $page_id) ?></a>
                <?php endif; ?>
                <?php if (get_field('side_cta_persons_phone', $page_id)) : ?>
                    <a class="c--card-j__wrapper__item-right__item-right__link" href="tel:<?php echo get_field('side_cta_persons_phone', $page_id) ?>"><?php echo get_field('side_cta_persons_phone', $page_id) ?></a>
                <?php endif; ?>
                <div class="c--card-j__wrapper__item-right__item-right__content">
                    <?php echo get_field('side_cta_persons_address', $page_id) ?>
                </div>
            </div>
        </div>
    </div>
</div>