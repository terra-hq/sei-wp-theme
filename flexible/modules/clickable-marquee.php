<?php
$section_spacing = get_spacing($module['section_spacing']);
?>

<section class=" <?= $section_spacing ?> ">
    <?php 
        include (locate_template('components/marquee/marquee-b.php'));
    ?>
</section>

<?php unset($section_spacing); ?>
