<?php
    $direction = $module['direction'] ?? 'left';
    $spacing = get_spacing($module['spacing']);
    $logos = $module['logos'];
?>
<?php if($logos): ?>
<section class="f--background-d  <?= $spacing ?>">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-12">
                <div class="c--marquee-a js--marquee f--col-12  <?= $direction ?> " data-speed="1" data-controls-on-hover="false" data-reversed="false">
                    <?php foreach($logos as $key=> $logo): ?>
                        <img class="c--marquee-a__item <?= $key == 0 ? 'c--marquee-a__item--initial' : ''?>" src="<?= $logo['url'] ?>" alt="<?= $logo['alt'] ?>" />
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
     </div>
</section>
<?php endif; ?>



