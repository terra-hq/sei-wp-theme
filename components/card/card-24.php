<?php
    if(!isset($lazy_loading)) {
        $lazy_loading = true;
    }
?>

<a href="<?php echo $permalink ?>" <?php echo $target ?> class="g--card-24">
    <div class="g--card-24__wrapper">
        <p class="g--card-24__wrapper__item-primary"><?php echo $insight_type_name  ?></p>
        <p class="g--card-24__wrapper__item-secondary"><?php echo $title ?></p>
        <div class="g--card-24__wrapper__list-group">
            <?php foreach ($topics as $topic) {
              $topic_name = $topic->name; ?>
              <span class="g--card-24__wrapper__list-group__item"><?php echo $topic_name ?></span>
            <?php } ?>
        </div>
    </div>
    <figure class="g--card-24__media-wrapper">
        <?php
            $image_tag_args = array(
                'image' => $image,
                'sizes' => '580px',
                'class' => 'g--card-24__media-wrapper__media',
                'isLazy' => $lazy_loading ? true : false,
                'lazyClass' => 'g--lazy-01',
                'showAspectRatio' => true,
                'decodingAsync' => true,
                'fetchPriority' => false,
                'addFigcaption' => false,
            );
            generate_image_tag($image_tag_args)
        ?>
    </figure>
</a>