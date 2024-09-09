<?php $collapsible_contents = $module['collapsible_content'];
if($collapsible_contents): ?>
<section class="f--background-b f--pb-15 f--pb-tablets-0">
    <div class="f--container">
        <div class="f--row f--gap-b">
            <div class="f--col-8 f--col-tabletl-12">

                <?php foreach($collapsible_contents as $key => $each): ?>
                <div class="c--accordion-a js--accordion-a">
                    <button class="c--accordion-a__hd c--accordion-a__hd--is-active" type="button" data-accordionA-control="simpleContent-0<?php echo $key+1?>" aria-expanded="false">
                        <span class="c--accordion-a__hd__badge">0<?php echo $key+1?>.</span>
                        <span class="c--accordion-a__hd__title"><?php echo $each['title'] ?></span>
                        <span class="c--accordion-a__hd__icon" role="presentation"></span>
                    </button>
                    <div class="c--accordion-a__bd" data-accordionA-content="simpleContent-0<?php echo $key+1?>" aria-hidden="true">
                        <div class="c--accordion-a__bd__content">
                           <?php echo $each['content'] ?>
                        </div>
                    </div>
                </div>
                    <?php endforeach; ?>

            </div>
            <div class="f--col-4 f--pl-4 u--display-tabletl-none">
                <div class="c--media-a">
                    <?php $image_tag_args = array(
                        'image' => $module['image'],
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
                        'image' => $module['image'],
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