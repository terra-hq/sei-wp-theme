<div class="c--card-k">
    <div class="c--card-k__wrapper">
        <h3 class="c--card-k__wrapper__title"> <?= $title ?> </h3>
        <div class="c--card-k__wrapper__content">
            <?php if($adress_line_1): ?>
                <p><?= $adress_line_1 ?></p>
            <?php endif; ?>
            <?php if($adress_line_2): ?>
                <p><?= $adress_line_2 ?></p>
            <?php endif; ?>
            <?php if($adress_line_3): ?>
                <p><?= $adress_line_3 ?></p>
            <?php endif; ?>
            <?php if($phone): ?>
                   <p><a href="tel:<?= $phone ?>"><?= $phone ?></a></p>
            <?php endif; ?>
        </div>
    </div>
</div>