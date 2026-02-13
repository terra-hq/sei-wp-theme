<a class="c--card-l <?= $modifierClass ? "c--card-l--$modifierClass" : "" ?>" href="<?= $card['permalink'] ?>" <?php echo $card['target'] ?> >
    <?php if (isset($modifierClass) && $modifierClass === "third") : ?>
        <figure>
            <?php
                $image_tag_args = array(
                    'image' => array( 
                        'url' => get_theme_file_uri('/img/bg/card-l-bg.webp'),
                        'width'  => 1181,
                        'height' => 574,
                        'sizes' => array(
                            'thumbnail' => get_theme_file_uri('/img/bg/card-l-bg.webp'),
                            'small' => get_theme_file_uri('/img/bg/card-l-bg.webp'),
                            'medium' => get_theme_file_uri('/img/bg/card-l-bg.webp'),
                            'large' => get_theme_file_uri('/img/bg/card-l-bg.webp'),
                            'tablets' => get_theme_file_uri('/img/bg/card-l-bg.webp'),
                            'mobile' => get_theme_file_uri('/img/bg/card-l-bg.webp'),
                        )
                    ),
                    'sizes' => 'large',
                    'class' => 'c--card-l__bg-items',
                    'isLazy' => false,
                    'showAspectRatio' => true,
                    'decodingAsync' => true,
                    'fetchPriority' => false,
                    'addFigcaption' => false,
                );

                generate_image_tag($image_tag_args);
            ?>
        </figure>
    <?php endif; ?>
    <div class="c--card-l__wrapper">
        <span class="c--card-l__wrapper__subtitle">
            <?php if (isset($modifierClass) && $modifierClass === "third") { echo 'featured'; } ?>
            <?= $card['subtitle'] ?>
        </span>
        <h3 class="c--card-l__wrapper__title">
            <?= $card['title'] ?>
        </h3>
        <ul class="c--card-l__wrapper__list-group">
            <?php foreach ($card['tags'] as $tag): ?>
                <li class="c--card-l__wrapper__list-group__list-item">
                    <?= $tag ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</a>