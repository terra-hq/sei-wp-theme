<section>
  <div class="f--container f--container--fluid">
    <div class="f--row">
      <div class="f--col-12">
        <?php $media_type = $module['media_type'];
        if ($media_type == 'image') : ?>
          <div class="c--media-b">
            <?php
              $image_tag_args = array(
                'image' => $module['full_image'],
                'sizes' => '100vw',
                'class' => 'c--media-b__media',
                'isLazy' => true,
                'lazyClass' => 'g--lazy-01',
                'showAspectRatio' => true,
                'decodingAsync' => true,
                'fetchPriority' => false,
                'addFigcaption' => false,
              );
              generate_image_tag($image_tag_args)
              ?>
          </div>
        <?php endif; ?>
        <?php $type_of_video = $module['type_of_video'];
        if ($media_type == 'video' && $type_of_video == 'media') { ?>
          <div class="c--media-b">
            <div class="js--boostify-player c--media-b__video" data-media="<?php echo $module['media_video']['url'] ?>"></div>
          </div>
        <?php } elseif($media_type == 'video' && $type_of_video == 'embed') { ?>
          <div class="c--media-b">
            <div class="js--boostify-embed c--media-b__iframe" data-url-youtube="<?php echo $module['embed_video'] ?>"></div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</section>