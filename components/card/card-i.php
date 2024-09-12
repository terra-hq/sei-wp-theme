<div class="c--card-i <?= $modifierClass ? "c--card-i--$modifierClass" : "" ?>">
    <?php if (!$modifierClass) : ?>
        <!-- no b-lazy for this background, it creates a bad loading effect -->
        <img
            src="<?php bloginfo('template_url'); ?>/assets/frontend/background/card-i-bg_2x.webp"
            srcset="<?php bloginfo('template_url'); ?>/assets/frontend/background/card-i-bg_1x.webp 738w,
                    <?php bloginfo('template_url'); ?>/assets/frontend/background/card-i-bg_2x.webp 1712w" 
            sizes="100vw"
            class="c--card-i__bg-items" 
            width="1712"
            height="1884"
            style="aspect-ratio: 1712 / 1884"
            decoding="async"
            loading="lazy"
        >
    <?php endif; ?>
    <div class="c--card-i__wrapper">
        <div class="c--card-i__wrapper__hd">
            <span class="c--card-i__wrapper__hd__title">
                <?= $card['title'] ?>
            </span>
            <?php if ($card['button']) : ?>
                <a href="<?= $card['button']["url"] ?>" class="c--card-i__wrapper__hd__link">
                <?= $card['button']["title"] ?>
            </a>
            <?php endif; ?>
        </div>
        <div class="c--card-i__wrapper__bd">
            <?php if ($card_posts) : ?>
                <?php foreach ($card_posts as $post) : ?>
                        <a href="<?= get_the_permalink($post->ID) ?>" class="c--card-i__wrapper__bd__item">
                            <?= $post->post_title ?>
                        </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>