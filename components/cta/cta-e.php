<?php if ($module['cta_link']) : ?>
    <a href="<?php echo $module['cta_link']['url'] ?>" class="c--cta-e">
        <figure>
            <?php
                $image_tag_args = array(
                    'image' => array( 
                        'url' => get_theme_file_uri('/img/bg/cta-e-bg-02.webp'),
                        'width'  => 764,
                        'height' => 824,
                        'sizes' => array(
                            'thumbnail' => get_theme_file_uri('/img/bg/cta-e-bg-02.webp'),
                            'small' => get_theme_file_uri('/img/bg/cta-e-bg-02.webp'),
                            'medium' => get_theme_file_uri('/img/bg/cta-e-bg-02.webp'),
                            'large' => get_theme_file_uri('/img/bg/cta-e-bg-02.webp'),
                            'tablets' => get_theme_file_uri('/img/bg/cta-e-bg-02.webp'),
                            'mobile' => get_theme_file_uri('/img/bg/cta-e-bg-02.webp'),
                        )
                    ),
                    'sizes' => 'large',
                    'class' => 'c--cta-e__bg-items',
                    'isLazy' => true,
                    'showAspectRatio' => true,
                    'decodingAsync' => true,
                    'fetchPriority' => false,
                    'addFigcaption' => false,
                );

                generate_image_tag($image_tag_args);
            ?>
        </figure>
        <div class="c--cta-e__wrapper">
            <div class="c--cta-e__wrapper__icon"></div>
            <h3 class="c--cta-e__wrapper__title">
                <?php echo $module['cta_link']['title'] ?>
            </h3>
        </div>
    </a>
<?php endif; ?>