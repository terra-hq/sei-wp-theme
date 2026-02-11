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
                            <img class="c--marquee-a__item" src="<?= $logo['logo']['url'] ?>" alt="<?= $logo['logo']['alt'] ?>" />
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
     </div>
</section>
<?php endif; ?>



