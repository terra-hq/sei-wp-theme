<section class="c--lottie-a">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-12">
                <div class="c--lottie-a__media-wrapper">
                    <?php
                        $image_tag_args = array(
                            'image' => array('url' => get_template_directory_uri() . '/img/lotties/lottie.svg'),
                            'sizes' => '(max-width: 810px) 50vw, 100vw ',
                            'class' => 'c--lottie-a__media-wrapper__media' ,
                            'isLazy' => true,
                            'lazyClass' => 'g--lazy-01',
                            'showAspectRatio' => true,
                            'decodingAsync' => true,
                            'fetchPriority' => false,
                            'addFigcaption' => false,
                        );
                        generate_image_tag($image_tag_args)
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>