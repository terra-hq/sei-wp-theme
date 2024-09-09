<!-- Testimonial + optional image -->
<?php
    $title = $module['title'];
    $subtitle = $module['subtitle'];
    $testimonial_name = $module['testimonial_name'];
    $testimonial_position = $module['testimonial_position'];
    $image = $module['image'];

    if($module['section_spacing']){
        $spacing = get_spacing($module['section_spacing']);
    } else {
        $spacing =  null;
    }

    if(!$image){
        $modifierClass = 'g--card-33--third';
        $useContainer = true;
    } else {
        $useContainer = false;
    }
    
    if ($useContainer) : ?>
        <div class="f--container <?php echo $spacing?>">
    <?php endif; ?>
    
    <?php include(locate_template('components/card/card-33.php')); ?>
    
    <?php if ($useContainer) : ?>
        </div>
    <?php endif; ?>
