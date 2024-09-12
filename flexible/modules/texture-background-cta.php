<?php
$spacing = get_spacing($module['section_spacing']);
$title = $module['title'];
$simple_title = $module['simple_title'];
$btn = $module['button'];
$full_width = $module['full_width'];
$bg_image = $module['bg_image']
?>

<section class="<?= $spacing ?>">
    <div class="f--container <?= $full_width ? 'f--container--fluid' : '' ?>">
        <div class="f--row">
            <div class="f--col-12">
                <div class="g--cta-02 <?= !$full_width ? 'g--cta-02--second' : '' ?>">
                    <?php if (!$bg_image) { ?>
                        <img src="<?php bloginfo('template_url'); ?>/assets/frontend/background/cta-d-bg-v2.webp" data-src="<?php bloginfo('template_url'); ?>/assets/frontend/background/cta-d-bg-v2.webp" alt="background shape texture" class="g--cta-02__bg-items g--lazy-01" decoding="async" width="1000" height="500" style="aspect-ratio: 1000 / 500" />
                    <?php } elseif(isset($bg_image) && $bg_image) { ?>
                        <?php $image_tag_args = array(
                                'image' => $bg_image,
                                'sizes' => 'small',
                                'class' => 'g--cta-02__bg-items',
                                'isLazy' => true,
                                'lazyClass' => 'g--lazy-01',
                                'showAspectRatio' => true,
                                'decodingAsync' => true,
                                'fetchPriority' => false,
                                'addFigcaption' => false,
                            );
                            generate_image_tag($image_tag_args) ?>
                    <?php }  ?>
                    <div class="g--cta-02__ft-items">
                        <div class="g--cta-02__ft-items__content">
                            <?php if ($full_width) : ?>
                                <h2 class="g--cta-02__ft-items__content__item-primary f--font-c">
                                    <?php
                                        if ($title) {
                                            foreach ($title as $t) {
                                                if ($t['italic']) {
                                                    echo '<span class="f--font-d">' . $t['text'] . '</span>';
                                                } else {
                                                    echo $t['text'] . ' ';
                                                }
                                            }
                                        }
                                        ?>
                                </h2>
                            <?php else : ?>
                                <h2 class="g--cta-02__ft-items__content__item-primary f--font-e"><?= $simple_title ?></h2>
                            <?php endif; ?>
                            <div class="g--cta-02__ft-items__content__list-group">
                                <?php if ($btn) : ?>
                                    <a href="<?= $btn['url'] ?>" <?= get_target_link($btn['target'], $btn['title']) ?> class="g--cta-02__ft-items__content__list-group__item">
                                        <span><?= $btn['title'] ?></span>
                                        <?php include(locate_template('img/btn-03-arrow.svg', false, false)); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>