<section class="c--cta-a">
  <div class="f--container">
    <div class="f--row u--align-items-center u--justify-content-space-between f--gap-a">
      <div class="f--col-6 f--col-tablets-12">
        <div class="c--cta-a__wrapper">
          <h2 class="c--cta-a__wrapper__title"><?php echo $module['cta_title'] ?></h2>
          <p class="c--cta-a__wrapper__subtitle"><?php echo $module['cta_subtitle'] ?></p>
        </div>
      </div>
      <?php if ($module['cta_button']) : ?>
        <div class="f--col-3 f--col-tabletl-6 f--col-tablets-12 u--display-flex u--justify-content-flex-end u--justify-content-tablets-center">
          <a href="<?php echo $module['cta_button']['url'] ?>" <?php echo get_target_link($module['cta_button']['target'], $module['cta_button']['title'])?> class="c--cta-a__link"><?php echo $module['cta_button']['title'] ?></a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>