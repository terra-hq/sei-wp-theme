<?php $faqs = $module['faq'];
if ($faqs) : ?>
    <section class="f--background-b f--pb-15 f--pb-tablets-0">
        <div class="f--container">
            <div class="f--row f--gap-b">
                <div class="f--col-6 f--col-tabletl-12">
                    <?php foreach ($faqs as $key => $faq): ?>
                    <div class="g--accordion-02 js--accordion-02">
                        <button class="g--accordion-02__hd" type="button" data-accordion02-control="simpleContent02-0<?php echo $key+1 ?>" aria-expanded="false">
                            <span class="g--accordion-02__hd__item-primary"><?php echo $faq['faq_title'] ?></span>
                            <span class="g--accordion-02__hd__icon" role="presentation"></span>
                        </button>
                        <div class="g--accordion-02__bd" data-accordion02-content="simpleContent02-0<?php echo $key+1 ?>" aria-hidden="true">
                            <div class="g--accordion-02__bd__content">
                            <?php echo $faq['faq_content'] ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
                <div class="f--col-6 f--pl-4 u--display-tabletl-none">
                    <div class="c--media-a">
                        <?php $image_tag_args = array(
                            'image' => $module['section_image'],
                            'sizes' => '(max-width: 1024px) 100vw, 50vw ',
                            'class' => 'c--media-a__media',
                            'isLazy' => true,
                            'lazyClass' => 'g--lazy-01',
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
        </div>
        <div class="f--container f--container-mobile--fluid u--display-none u--display-tabletl-block f--pt-8">
            <div class="f--row">
                <div class="f--col-12">
                    <div class="c--media-a">
                        <?php $image_tag_args = array(
                            'image' => $module['section_image'],
                            'sizes' => '(max-width: 1024px) 100vw, 50vw ',
                            'class' => 'c--media-a__media',
                            'isLazy' => true,
                            'lazyClass' => 'g--lazy-01',
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
        </div>
    </section>
<?php endif; ?>