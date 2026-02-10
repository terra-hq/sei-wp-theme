<div class="c--card-i <?= $modifierClass ? "c--card-i--$modifierClass" : "" ?>">
    <?php if (!$modifierClass) : ?>
        <!-- no b-lazy for this background, it creates a bad loading effect -->
        <figure>
            <?php
                $image_tag_args = array(
                    'image' => array( 
                        'url' => get_theme_file_uri('/img/bg/card-i-bg_2x.webp'),
                        'width'  => 1712,
                        'height' => 1884,
                        'sizes' => array(
                            'thumbnail' => get_theme_file_uri('/img/bg/card-i-bg_1x.webp'),
                            'small' => get_theme_file_uri('/img/bg/card-i-bg_1x.webp'),
                            'medium' => get_theme_file_uri('/img/bg/card-i-bg_2x.webp'),
                            'large' => get_theme_file_uri('/img/bg/card-i-bg_2x.webp'),
                            'tablets' => get_theme_file_uri('/img/bg/card-i-bg_2x.webp'),
                            'mobile' => get_theme_file_uri('/img/bg/card-i-bg_1x.webp'),
                        )
                    ),
                    'sizes' => 'large',
                    'class' => 'c--card-i__bg-items',
                    'isLazy' => true,
                    'showAspectRatio' => true,
                    'decodingAsync' => true,
                    'fetchPriority' => false,
                    'addFigcaption' => false,
                );

                generate_image_tag($image_tag_args);
            ?>
        </figure>
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