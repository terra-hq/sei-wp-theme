<a href="<?php echo $item_link ?>" <?php echo get_target_link($item_target, $item_title)?>  class="c--card-h c--dropdown-a__content__item">
    <div class="c--card-h__wrapper">
        <p class="c--card-h__wrapper__title"><?php echo $item_title ?></p>
        <p class="c--card-h__wrapper__subtitle"><?php echo $item_description ?></p>
    </div>
    <div class="c--card-h__media-wrapper">
        <?php
            $image_tag_args = array(
                'image' => $item_icon,
                'sizes' => '580px',
                'class' => 'c--card-h__media-wrapper__media',
                'isLazy' => false,
                'showAspectRatio' => true,
                'decodingAsync' => true,
                'fetchPriority' => false,
                'addFigcaption' => false,
            );
            generate_image_tag($image_tag_args)
        ?>
    </div>
</a>