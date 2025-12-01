<?php
$spacing = get_spacing($module['section_spacing']);
$lottie = $module['lottie'];
?>

<section class="<?= $spacing; ?> <?= $bg_color; ?>">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-12">
                <div class="js--lottie-element" data-path="<?php echo $lottie['url'] ?>" data-animType="svg" data-loop="true" data-autoplay="true" data-name="graphic"></div>
            </div>
        </div>
    </div>
</section>

<?php unset($spacing, $lottie); ?>
