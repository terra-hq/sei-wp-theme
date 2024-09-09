<?php $testimonials = $module['testimonials'];
if($testimonials): ?>
  <section class="c--slider-a <?= get_spacing($module['section_spacing']); ?>">
    <div class="f--container f--container-tabletl--fluid u--overflow-hidden">
        <div class="f--row">
            <div class="f--col-12">
                <div class="c--slider-a__wrapper js--slider-a">
                    <?php foreach($testimonials as $key => $testimonial): ?>
                    <div class="c--slider-a__wrapper__item">
                        <div class="c--testimonials-a">
                            <div class="c--testimonials-a__left-items">
                                <?php $image_tag_args = array(
                                    'image' => $testimonial['quoters_image'],
                                    'sizes' => '(max-width: 1024px) 100vw, 50vw ',
                                    'class' => 'c--testimonials-a__left-items__media tns-lazy-img',
                                    'isLazy' => false,
                                    'showAspectRatio' => true,
                                    'decodingAsync' => true,
                                    'fetchPriority' => false,
                                    'addFigcaption' => false,
                                );
                                ?>
                                <?php echo generate_image_tag($image_tag_args) ?>
                            </div>
                            <div class="c--testimonials-a__right-items">
                                <p class="c--testimonials-a__right-items__title"><?php echo $testimonial['quote'] ?></p>
                                <p class="c--testimonials-a__right-items__subtitle"><?php echo $testimonial['quoter'] ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="c--slider-a__controls js--slider-a-controls">
                    <button class="c--slider-a__controls__btn c--slider-a__controls__btn--reverse">
                        <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.773681 6.9998L16.8123 6.9998M16.8123 6.9998L11.1282 12.8923M16.8123 6.9998L11.1282 1.10727" stroke="#F7F2EB"/>
                        </svg>                    
                    </button>
                    <button class="c--slider-a__controls__btn">
                        <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.773681 6.9998L16.8123 6.9998M16.8123 6.9998L11.1282 12.8923M16.8123 6.9998L11.1282 1.10727" stroke="#F7F2EB"/>
                        </svg>
                    </button>
                </div>
                
            </div>
        </div>
    </div>
</section>
<?php endif; ?>