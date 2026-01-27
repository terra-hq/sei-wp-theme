<div class="c--card-g">
    <div class="c--card-g__wrapper">
        <?php if (is_array($image) && isset($image['url'])): ?>
            <div class="c--card-g__wrapper__item-left">
                <?php
                    $image_tag_args = array(
                        'image' => $image,
                        'sizes' => '(max-width: 810px) 50vw, 100vw',
                        'class' => 'c--card-g__wrapper__item-left__media' ,
                        'isLazy' => false,
                        'showAspectRatio' => false,
                        'decodingAsync' => true,
                        'fetchPriority' => false,
                        'addFigcaption' => false,
                    );
                    generate_image_tag($image_tag_args)
                ?>                        
            </div>
        <?php else: ?>
            <div class="c--card-g__wrapper__item-left">
                <?php
                    $image_tag_args = array(
                        'image' => array( 
                            'url' => get_testimonial_placeholder_image(),
                            'width'  => 800,
                            'height' => 600,
                            'sizes' => array(
                                'thumbnail' => get_testimonial_placeholder_image(),
                                'small' => get_testimonial_placeholder_image(),
                                'medium' => get_testimonial_placeholder_image(),
                                'large' => get_testimonial_placeholder_image(),
                                'tablets' => get_testimonial_placeholder_image(),
                                'mobile' => get_testimonial_placeholder_image(),
                            )
                        ),
                        'sizes' => 'large',
                        'class' => 'c--card-g__wrapper__item-left__media',
                        'isLazy' => false,
                        'showAspectRatio' => true,
                        'decodingAsync' => true,
                        'fetchPriority' => false,
                        'addFigcaption' => false,
                    );

                    generate_image_tag($image_tag_args);
                ?>
            </div>
        <?php endif; ?>
        <div class="c--card-g__wrapper__item-right">
            <h3 class="c--card-g__wrapper__item-right__title"><?= $small_heading ?></h3>
            <p class="c--card-g__wrapper__item-right__content"><?= $description ?></p>
            <div class="c--card-g__wrapper__item-right__ft">
                <p class="c--card-g__wrapper__item-right__ft__title"><?= $name ?></p>
                <p class="c--card-g__wrapper__item-right__ft__subtitle"><?= $job_position ?></p>
            </div>
        </div>
    </div>
</div>