<div class="g--card-33 <?= $modifierClass ?>">
    <div class="g--card-33__wrapper">
        <h2 class="g--card-33__wrapper__item-primary"><?= $title ?></h2>
        <h3 class="g--card-33__wrapper__item-secondary"><?= $subtitle ?></h3>
        <p class="g--card-33__wrapper__item-tertiary"><?= $testimonial_name ?></p>
        <div class="g--card-33__wrapper__list-group">
            <p class="g--card-33__wrapper__list-group__item"><?= $testimonial_position ?></p>
        </div>
    </div>
    <figure class="g--card-33__media-wrapper">
        <?php if(isset($image) && $image):
            $image_tag_args = array(
                'image' => $image,
                'sizes' => '(max-width: 810px) 50vw, 100vw ',
                'class' => 'g--card-33__media-wrapper__media',
                'isLazy' => true,
                'lazyClass' => 'g--lazy-01',
                'showAspectRatio' => true,
                'decodingAsync' => true,
                'fetchPriority' => false,
                'addFigcaption' => false,
            );
            generate_image_tag($image_tag_args);
        endif; ?>
    </figure>
</div>