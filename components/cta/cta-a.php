<section class="c--cta-a">
    <div class="f--container">
        <div class="f--row f--gap-c">
            <div class="f--col-12">
                <div class="c--cta-a__wrapper">
                    <?php
                    $image_tag_args = array(
                        'image' => $media,
                        'sizes' => 'small',
                        'class' => 'c--cta-a__wrapper__media',
                        'isLazy' => true,
                        'lazyClass' => 'g--lazy-01',
                        'showAspectRatio' => true,
                        'decodingAsync' => true,
                        'fetchPriority' => false,
                        'addFigcaption' => false,
                    );
                    generate_image_tag($image_tag_args)
                    ?>


                    <span class="c--cta-a__wrapper__subtitle">
                        <?= $subtitle ?>
                    </span>
                    <h2 class="c--cta-a__wrapper__title">
                        <?= $title ?>
                    </h2>
                    <span class="c--cta-a__wrapper__category">
                        <?= $tag ?>
                    </span>
                    <?php if ($btn) : ?>
                        <a href="<?= $btn['url'] ?>" <?= get_target_link($btn['target'], $btn['title']) ?> class="c--cta-a__wrapper__btn">
                            <span class="g--btn-03__content">
                                <?= $btn['title'] ?>
                            </span>
                            <?php include(locate_template('img/btn-03-arrow.svg', false, false)); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>