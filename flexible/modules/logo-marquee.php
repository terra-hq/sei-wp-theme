<?php
$spacing = get_spacing($module['spacing']);
$items = $module['logos'];
$direction = $module['direction'];
$reversed = ($direction === 'right') ? 'true' : 'false';
?>

<?php if (!empty($items)) : ?>
<section class="f--background-d u--overflow-hidden <?= $spacing ?>">
    <div class="f--container--fluid">
        <div class="f--row">
            <div class="c--marquee-a js--marquee f--col-8 f--col-tabletl-10 f--offset-2 f--offset-tabletl-1 f--offset-tablets-0 f--col-tablets-12"
                 data-speed="1"
                 data-controls-on-hover="false"
                 data-reversed="<?= $reversed ?>">
                 
                <?php foreach ($items as $key => $item) :
                    $image = $item['logo'];
                    if ($image) :
                        $image_tag_args = [
                            'image' => $image,
                            'sizes' => '(max-width: 580px) 250px, (max-width: 1024px) 300px, 600px',
                            'class' => $key === 0 ? 'c--marquee-a__item c--marquee-a__item--initial' : 'c--marquee-a__item',
                            'isLazy' => false,
                            'showAspectRatio' => false,
                            'decodingAsync' => true,
                            'fetchPriority' => false,
                            'addFigcaption' => false,
                        ];
                        generate_image_tag($image_tag_args);
                    endif;
                    unset($image);
                endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php unset($spacing, $items, $direction, $reversed); ?>
