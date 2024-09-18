<?php if ($url): ?>
    <a href="<?= $url ?>" <?php echo $is_external ? "target='_blank'" : '' ?> class="c--card-e">
        <h2 class="c--card-e__title"><?= $title ?></h2>
        <p class="c--card-e__subtitle"><?= $subtitle ?></p>
        <span class="c--card-e__link">Learn More</span>
    </a>
<?php else: ?>
    <div class="c--card-e">
        <h2 class="c--card-e__title"><?= $title ?></h2>
        <p class="c--card-e__subtitle"><?= $subtitle ?></p>
    </div>
<?php endif; ?>