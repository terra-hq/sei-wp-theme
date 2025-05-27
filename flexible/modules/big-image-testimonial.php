<!-- Logo testimonial -->
<?php
    $spacing = $spacing = get_spacing($module['section_spacing']);
    $title = $module['title'];
    $subtitle = $module['subtitle'];
    $testimonial_name = $module['testimonial_name'];
    $testimonial_position = $module['testimonial_position'];
    $modifierClass = 'g--card-33--second';
    $image = $module['image'];
?>

<section class="<?= $spacing ?>">
    <div class="f--container">
        <?php include(locate_template('components/card/card-33.php')); ?>
    </div>
</section>

<?php unset($spacing, $title, $subtitle, $testimonial_name, $testimonial_position, $modifierClass, $image); ?>