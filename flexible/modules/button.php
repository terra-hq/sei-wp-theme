<?php
$spacing = get_spacing($module['spacing']);
$button = $module['button'];
$position_class = match ($module['button_position']) {
    'left'   => 'u--justify-content-start',
    'right'  => 'u--justify-content-flex-end',
    default  => 'u--justify-content-center'
};
?>

<section class=" <?= $spacing ?>">
    <div class="f--container">
        <div class="f--row">
            <?php if($button) : ?> 
                <div class="f--col-12 u--display-flex <?= esc_attr($position_class); ?>">
                    <a href="<?= esc_url($button['url']) ?>"
                    <?= get_target_link($button['target'], $button['title']) ?>
                    class="g--btn-03 g--btn-03--second">
                        <span><?= $button['title'] ?></span>
                        <?php include(locate_template('img/btn-03-arrow.svg', false, false)); ?>
                    </a>

                    <!-- ejemlo anchor to

                     <a data-target="form-hero" f-data-distance="50" href=" <?= $button['url']?>"
                   <?= get_target_link($button['target'], $button['title']) ?>
                   class="g--btn-03 g--btn-03--second">
                   class="g--btn-03 g--btn-03--second js--scroll-to">
                    <span><?= $button['title'] ?></span>
                    <?php include(locate_template('img/btn-03-arrow.svg', false, false)); ?>
                </a>


                      -->
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php unset($spacing, $button, $position_class); ?>
