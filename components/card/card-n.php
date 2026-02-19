<div class="c--card-n <?= $modifierClass ?> <?= $center_image?>">
    <div class="c--card-n__wrapper">
        <h2 class="c--card-n__wrapper__item-primary"><?= $title ?></h2>
        <p class="c--card-n__wrapper__item-secondary"><?= $description ?></p>
        <div class="c--card-n__wrapper__list-group">
            <?php if ($btn): ?>
                <a href="<?= $btn['url'] ?>" <?= get_target_link($btn['target'], $btn['title']) ?> rel="noopener noreferrer" class="c--card-n__wrapper__list-group__item">
                    <?= $btn['title'] ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
    <figure class="c--card-n__media-wrapper">
        <?php 
        if ($first_image) {
            $first_image_tag_args = [
                'image' => $first_image,
                'sizes' => 'large',
                'class' => 'c--card-n__media-wrapper__media',
                'isLazy' => false,
                'lazyClass' => 'g--lazy-01',
                'showAspectRatio' => true,
                'decodingAsync' => true,
                'fetchPriority' => false,
                'addFigcaption' => false,
            ];
            generate_image_tag($first_image_tag_args);
        }
        ?>

        <?php if ($type === 'image_text' && $second_image): ?>
            <div class="c--card-n__media-wrapper__wrapper">
                <?php 
                $second_image_tag_args = [
                    'image' => $second_image,
                    'sizes' => '90px',
                    'class' => 'c--card-n__media-wrapper__wrapper__media',
                    'isLazy' => false,
                    'lazyClass' => 'g--lazy-01',
                    'showAspectRatio' => true,
                    'decodingAsync' => true,
                    'fetchPriority' => false,
                    'addFigcaption' => false,
                ];
                generate_image_tag($second_image_tag_args);
                ?>
                <p class="c--card-n__media-wrapper__wrapper__title"><?= $second_image_text ?></p>
            </div>
            <div class="c--card-n__media-wrapper__overlay"></div>
        <?php endif; ?>
    </figure>
</div>