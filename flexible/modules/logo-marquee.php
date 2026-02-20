<?php
    $direction = $module['direction'] == 'left' ?  true : false;
    $spacing = get_spacing($module['spacing']);
    $logos = $module['logos'];
?>
<?php if($logos): ?>
<section class="f--background-d  <?= $spacing ?>">
    <div class="f--container--fluid">
        <div class="f--row">
            <div class="f--col-12">
                <div class="c--marquee-a js--marquee" data-speed="1" data-controls-on-hover="false" data-reversed=<?= $direction ?> >
                    <?php foreach($logos as $key => $logo): ?>
                        <?php if($logo): ?>
                            <div class="c--marquee-a__wrapper">
                                <?php  $image_tag_args = array(
                                        'image' => $logo['logo'],
                                        'sizes' => 'large',
                                        'class' => $key == 0 ? 'c--marquee-a__wrapper__item c--marquee-a__wrapper__item--initial' : 'c--marquee-a__wrapper__item',
                                        'isLazy' => true,
                                        'showAspectRatio' => true,
                                        'decodingAsync' => true,
                                        'fetchPriority' => false,
                                        'addFigcaption' => false,
                                    );
                                    generate_image_tag($image_tag_args);
                                ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
     </div>
</section>
<?php endif; ?>



