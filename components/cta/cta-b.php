<div class="c--cta-b">
    <div class="c--zoom-section-b">
        <div class="c--zoom-section-b__media-wrapper js--zoom-b" data-hero="false">
            <figure>
                <?php
                    $image_tag_args = array(
                        'image' => array( 
                            'url' => get_theme_file_uri('/img/bg/cta-b-bg2.webp'),
                            'width'  => 4096,
                            'height' => 2304,
                            'sizes' => array(
                                'thumbnail' => get_theme_file_uri('/img/bg/cta-b-810.webp'),
                                'small' => get_theme_file_uri('/img/bg/cta-b-1300.webp'),
                                'medium' => get_theme_file_uri('/img/bg/cta-b-810-2x.webp'),
                                'large' => get_theme_file_uri('/img/bg/cta-b-1300-2x.webp'),
                                'tablets' => get_theme_file_uri('/img/bg/cta-b-bg2.webp'),
                                'mobile' => get_theme_file_uri('/img/bg/cta-b-810.webp'),
                            )
                        ),
                        'sizes' => '100vw',
                        'class' => 'c--zoom-section-b__media-wrapper__media',
                        'isLazy' => true,
                        'showAspectRatio' => true,
                        'decodingAsync' => true,
                        'fetchPriority' => false,
                        'addFigcaption' => false,
                    );

                    generate_image_tag($image_tag_args);
                ?>
            </figure>
        </div>
    </div>
    <div class="c--cta-b__wrapper">
        <div class="f--container">
            <div class="f--row f--gap-c u--justify-content-center">
                <div class="f--col-8 f--col-tabletl-12">
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
                            <?php foreach ($list as $each): ?>
                                <a href="<?php echo get_the_permalink($each->ID); ?>" class="c--cta-b__wrapper__list-group__list-item">
                                    <?php echo get_the_title($each->ID); ?>
                                </a>
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