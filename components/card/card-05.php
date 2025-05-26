<div class="g--card-05">
    <div class="g--card-05__ft-items">

        <?php if ($title): ?>
            <h3 class="g--card-05__ft-items__item-primary"><?= esc_html($title); ?></h3>
        <?php endif; ?>

        <?php if ($content): ?>
            <div class="g--card-05__ft-items__item-secondary c--content-a">
                <?= $content; ?>
            </div>
        <?php endif; ?>

        <?php if ($button): ?>
            <div class="g--card-05__ft-items__list-group">
                <a href="<?= esc_url($button['url']); ?>"
                <?= get_target_link($button['target'], $button['title']); ?>
                class="g--card-05__ft-items__list-group__item">
                    <?= esc_html($button['title']); ?>
                </a>
            </div>
        <?php endif; ?>

        <?php if ($image): ?>
            <figure class="g--card-05__ft-items__media-wrapper">
                <?php
                $image_tag_args = array(
                    'image' => $image,
                    'sizes' => '180px',
                    'class' => 'g--card-05__media-wrapper__media',
                    'isLazy' => false,
                    'lazyClass' => 'g--lazy-01',
                    'showAspectRatio' => true,
                    'decodingAsync' => true,
                    'fetchPriority' => false,
                    'addFigcaption' => false,
                );
                generate_image_tag($image_tag_args);
                ?>
            </figure>
        <?php endif; ?>

    </div>
</div>
