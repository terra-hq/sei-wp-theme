
<section class="c--layout-a <?= get_spacing($module['section_spacing']); ?>">
    <div class="f--container f--container-mobile--fluid">
        <div class="f--row f--gap-c u--align-items-flex-end">
            <div class="f--col-4 f--col-tabletl-12 f--order-tabletl-first <?php echo ($module['media_order'] == 'right' ? 'f--order-1' : '')  ?>">
                <div class="c--layout-a__content">
                    <div class="g--card-04">
                        <h3 class="g--card-04__item-primary"><?php echo $module['card_title'] ?></h3>
                        <div class="g--card-04__list-group">
                            <p class="g--card-04__list-group__item">
                               <?php echo $module['card_subtitle'] ?>
                            </p>
                        </div>
                        <figure class="g--card-04__media-wrapper">
                          <?php $image_tag_args = array(
                            'image' => $module['card_icon'],
                            'sizes' => '64px',
                            'class' => 'g--card-04__media-wrapper__media',
                            'isLazy' => true,
                            'lazyClass' => 'g--lazy-01',
                            'showAspectRatio' => false,
                            'decodingAsync' => true,
                            'fetchPriority' => false,
                            'addFigcaption' => false,
                          );
                          generate_image_tag($image_tag_args) ?>
                        </figure>
                    </div>
                </div>
            </div>
            
            <div class="f--col-8 f--col-tabletl-12 <?php echo ($module['media_order'] == 'left' ? 'f--order-1' : '')  ?>">
                <div class="c--layout-a__media-wrapper <?php echo ($module['media_type'] == 'two' ? 'c--layout-a__media-wrapper--second' : '' ) ?>">
                    <?php $image_tag_args = array(
                            'image' => $module['media'],
                            'sizes' => '(max-width: 1024px) 100vw, 66vw',
                            'class' => 'c--layout-a__media-wrapper__media',
                            'isLazy' => true,
                            'lazyClass' => 'g--lazy-01',
                            'showAspectRatio' => false,
                            'decodingAsync' => true,
                            'fetchPriority' => false,
                            'addFigcaption' => false,
                          );
                          generate_image_tag($image_tag_args) ?>
                    <?php if($module['media_type'] == 'two' && $module['media_second_image']): ?>
                      <?php $image_tag_args = array(
                            'image' => $module['media_second_image'],
                            'sizes' => '(max-width: 1024px) 50vw, 33vw',
                            'class' => 'c--layout-a__media-wrapper__media',
                            'isLazy' => true,
                            'lazyClass' => 'g--lazy-01',
                            'showAspectRatio' => false,
                            'decodingAsync' => true,
                            'fetchPriority' => false,
                            'addFigcaption' => false,
                          );
                          generate_image_tag($image_tag_args) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>