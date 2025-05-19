<?php
    $spacing = get_spacing($module['section_spacing']);

?>

<section class="c--slider-a <?= $spacing ?>">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-12">
                <div class="c--slider-a__wrapper js--slider-a">
                <?php include(locate_template('components/card/card-24.php', false, false));?>
                </div>
            </div>
        </div>
    </div>
</section>