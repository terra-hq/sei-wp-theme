<?php
    $direction = $module['direction'] == 'left' ?  0 : 1;
    $spacing = get_spacing($module['spacing']);
    $logos = $module['logos'];
?>
<?php if($logos): ?>
<section class="f--background-d  <?= $spacing ?>">
    <div class="f--container--fluid">
        <div class="f--row">
            <div class="f--col-12">
                <div class="c--marquee-a js--marquee f--col-12" data-speed="1" data-controls-on-hover="false" data-reversed=<?= $direction ?> >
                    <?php foreach($logos as $key => $logo): ?>
                        <?php if($logo): ?>
                            <?php  $image_tag_args = array(
                                    'image' => $logo['logo'],
                                    'sizes' => 'large',
                                    'class' => $key == 0 ? 'c--marquee-a__item c--marquee-a__item--initial' : 'c--marquee-a__item',
                                    'isLazy' => false,
                                    'showAspectRatio' => true,
                                    'decodingAsync' => true,
                                    'fetchPriority' => false,
                                    'addFigcaption' => false,
                                );
                                generate_image_tag($image_tag_args); 
                            ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
     </div>
</section>
<?php endif; ?>



