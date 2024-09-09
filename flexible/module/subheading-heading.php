<span id="<?php echo $module['create_anchor'] ? $module['anchor_id'] : '' ?>" class="js--invisible-span" style="position: relative; display:block;"></span>
<section class="g--layout-01 <?= get_spacing($module['section_spacing']); ?>">
  <div class="g--layout-01__wrapper">
    <div class="g--layout-01__wrapper__content">
      <h2 class="g--layout-01__wrapper__content__item-primary">
        <?php echo $module['subheading'] ?>
      </h2>
      <?php $title = '';
      $headings = $module['heading'];
      if ($headings) {
        foreach ($headings as $heading) {
          $sentence = $heading['sentence'];
          $italic = $heading['italic'];
          if ($italic) {
            $title .= '<span class="u--font-style-italic">' . esc_html($sentence) . '</span> ';
          } else {
            $title .= esc_html($sentence) . ' ';
          }
        }
      } ?>
      <div class="g--layout-01__wrapper__content__list-group">
        <p href="#" class="g--layout-01__wrapper__content__list-group__item"><?php echo $title ?></p>
      </div>
    </div>
  </div>
</section>