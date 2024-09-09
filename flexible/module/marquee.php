<?php $logos = $module['logos'];
if($logos): 
  $logos = array_merge($logos, $logos); // duplicate logos
?>
<section class="c--marquee-a <?= get_spacing($module['section_spacing']); ?>">
  <div class="f--container f--container--fluid">
    <div class="f--row u--justify-content-center">
      <div class="f--col-12 u--display-flex u--justify-content-center">
        <div class="c--marquee-a__wrapper js--marquee" data-speed=".5" data-controls-on-hover="true" data-reversed="false">
          <?php foreach($logos as $key => $logo): ?>
          <div class="c--marquee-a__wrapper__item">
            <?php
            $image_tag_args = array(
                'image' => $logo['logo'],
                'sizes' => '580px',
                'class' => 'c--marquee-a__wrapper__item__media',
                'isLazy' => false,
                'showAspectRatio' => true,
                'decodingAsync' => true,
                'fetchPriority' => false,
                'addFigcaption' => false,
            );
            ?>
            <?php echo generate_image_tag($image_tag_args) 
            ?>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>