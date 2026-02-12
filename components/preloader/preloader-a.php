<div class="c--preloader-a">
    <div class="c--preloader-a__media-wrapper">
        <figure>
            <?php
                $image_tag_args = array(
                    'image' => array( 
                        'url' => get_theme_file_uri('/img/swirl-filled.webp'),
                        'width'  => 312,
                        'height' => 301,
                        'sizes' => array(
                            'thumbnail' => get_theme_file_uri('/img/swirl-filled.webp'),
                            'small' => get_theme_file_uri('/img/swirl-filled.webp'),
                            'medium' => get_theme_file_uri('/img/swirl-filled.webp'),
                            'large' => get_theme_file_uri('/img/swirl-filled.webp'),
                            'tablets' => get_theme_file_uri('/img/swirl-filled.webp'),
                            'mobile' => get_theme_file_uri('/img/swirl-filled.webp'),
                        )
                    ),
                    'sizes' => 'large',
                    'class' => 'c--preloader-a__media-wrapper__media',
                    'isLazy' => false,
                    'showAspectRatio' => true,
                    'decodingAsync' => true,
                    'fetchPriority' => false,
                    'addFigcaption' => false,
                );

                generate_image_tag($image_tag_args);
            ?>
        </figure>
    </div>
    <svg class="c--preloader-a__artwork" viewBox="0 0 100 100" preserveAspectRatio="none">
        <path vector-effect="non-scaling-stroke" d="M 0 0 V 100 Q 50 100 100 100 V 0 z" />
    </svg>
</div>