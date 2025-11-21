<?php
$spacing = get_spacing($module['section_spacing']);
$bg_color = $module['bg_color'];
$heading = $module['heading'];
$text = $module['text'];
?>

<section class="<?= $spacing; ?> <?= $bg_color; ?>">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-12">

                <p><strong>heading:</strong> <?= $heading; ?></p>
                <p><strong>text:</strong> <?= $text; ?></p>
                
            </div>
        </div>
    </div>
</section>

<?php unset($spacing, $bg_color, $heading, $text); ?>