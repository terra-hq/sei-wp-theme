<section class="c--hero-a">
    <div class="c--zoom-section-a">
        <div class="c--zoom-section-a__media-wrapper js--zoom" data-hero="true">
            <?php
            $image_tag_args = array(
                'image' => $hero['hero_background_image'],
                'sizes' => '100vw',
                'class' => 'c--zoom-section-a__media-wrapper__media',
                'isLazy' => false,
                'showAspectRatio' => true,
                'decodingAsync' => true,
                'fetchPriority' => false,
                'addFigcaption' => false,
            );
            generate_image_tag($image_tag_args)
            ?>
        </div>
    </div>
    <div class="c--hero-a__ft-items">
        <div class="f--container">
            <div class="c--hero-a__ft-items__wrapper">
                <?php
                $image_tag_args = array(
                    'image' => $hero['hero_image'],
                    'sizes' => '50px',
                    'class' => 'c--hero-a__ft-items__wrapper__media',
                    'isLazy' => false,
                    'showAspectRatio' => true,
                    'decodingAsync' => true,
                    'fetchPriority' => false,
                    'addFigcaption' => false,
                );
                generate_image_tag($image_tag_args)
                ?>

                <?php
                $taglines = $hero['hero_taglines'];
                $titles = [];

                if ($taglines) :
                    foreach ($taglines as $key => $eachTagline) :
                        $title = '';
                        foreach ($eachTagline['sentences'] as $key => $eachSentence) {
                            $sentence = $eachSentence['sentence'];
                            $italic = $eachSentence['italic'];
                            if ($italic) {
                                $title .= '<span class="c--hero-a__ft-items__wrapper__title__artwork">' . esc_html($sentence) . '</span> ';
                            } else {
                                $title .= esc_html($sentence) . ' ';
                            }
                        }
                        $titles[] = trim($title);
                    endforeach;
                endif;

                $random_title = $titles[array_rand($titles)];

                ?>



                <h1 class="c--hero-a__ft-items__wrapper__title"><?php echo $random_title ?></h1>


                <?php if ($hero['hero_button']) : ?>
                    <a href="<?php echo $hero['hero_button']['url'] ?>" class="c--hero-a__ft-items__wrapper__btn" <?php get_target_link($hero['hero_button']['target'], $hero['hero_button']['title']) ?>>
                        <span class="c--hero-a__ft-items__wrapper__btn__content"><?php echo $hero['hero_button']['title'] ?></span>
                        <?php include(locate_template('dist/assets/btn-03-arrow.svg', false, false)); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>