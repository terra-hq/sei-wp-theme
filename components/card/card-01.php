<div class="g--card-01 <?= isset($modifierClass) ? " g--card-01--$modifierClass" : "" ?>">
    <div class="g--card-01__ft-items">
        <div class="g--card-01__ft-items__item-primary">
            <p><?= $description ?></p>
        </div>
        <figure class="g--card-01__ft-items__media-wrapper">
            <?php
                $image_tag_args = array(
                    'image' => $image,
                    'sizes' => '58px',
                    'class' => 'g--card-01__ft-items__media-wrapper__media',
                    'isLazy' => true,
                    'lazyClass' => 'g--lazy-01',
                    'showAspectRatio' => true,
                    'decodingAsync' => true,
                    'fetchPriority' => false,
                    'addFigcaption' => false,
                );
                generate_image_tag($image_tag_args)
            ?>
        </figure>
    </div>
</div>