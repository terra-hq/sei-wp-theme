<section class="c--hero-a <?= get_spacing($hero['section_spacing']); ?>">
  <div class="f--container">
    <div class="f--row f--gap-b">
      <div class="f--col-6 f--col-tabletm-12">
        <?php $title = '';
        $headings = $hero['hero_title'];
        if ($headings) {
          foreach ($headings as $heading) {
            $sentence = $heading['sentence'];
            $italic = $heading['italic'];
            if ($italic) {
              $title .= '<span class="c--hero-a__title__artwork">' . esc_html($sentence) . '</span> ';
            } else {
              $title .= esc_html($sentence) . ' ';
            }
          }
        } ?>
        <h1 class="c--hero-a__title">
          <?php echo $title ?>
        </h1>
      </div>
      <div class="f--col-6 f--col-tabletm-12">
        <div class="c--hero-a__content">
          <?php echo $hero['hero_content'] ?>
        </div>
        <?php if ($hero['hero_button']) : ?>
          <a href="<?php echo $hero['hero_button']['url'] ?>" <?php echo get_target_link($hero['hero_button']['target'], $hero['hero_button']['title']) ?> class="c--hero-a__link">
            <?php echo $hero['hero_button']['title'] ?>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div class="f--container f--container-mobile--fluid">
    <div class="f--row">
      <div class="f--col-12">
        <?php $image_tag_args = array(
          'image' => $hero['hero_image'],
          'sizes' => '100vw',
          'class' => 'c--hero-a__media',
          'isLazy' => false,
          'showAspectRatio' => true,
          'decodingAsync' => true,
          'fetchPriority' => false,
          'addFigcaption' => false,
        );
        ?>
        <?php echo generate_image_tag($image_tag_args) ?>
      </div>
    </div>
  </div>
</section>