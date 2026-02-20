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

        <?php if ($button || $scroll_to_form): ?>
            <div class="g--card-05__ft-items__list-group">
                <?php if (!empty($scroll_to_form)): ?>
                    <button tf-data-target="form-hero" tf-data-distance="0"
                            class="g--card-05__ft-items__list-group__item js--scroll-to">
                        <?= $scroll_to_form_title; ?>
                    </button>
                <?php else: ?>
                    <a href="<?= esc_url($button['url']); ?>"
                    <?= get_target_link($button['target'], $button['title']); ?>
                    class="g--card-05__ft-items__list-group__item">
                        <?= $button['title']; ?>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($image): ?>
            <figure class="g--card-05__ft-items__media-wrapper">
                <?php
                $image_tag_args = array(
                    'image' => $image,
                    'sizes' => '180px',
                    'class' => 'g--card-05__media-wrapper__media',
                    'isLazy' => true,
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
