<?php
    $direction = $module['direction'] ?? 'left';
    $spacing = get_spacing($module['spacing']);
    $logos = $module['logos'];
?>
<?php if($logos): ?>
<section class="f--logo-marquee <?= $spacing ?>">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-12">
                <div class="c--logo-marquee <?= $direction ?>">
                    <?php foreach($logos as $logo): ?>
                        <div class="c--logo-marquee__item">
                            <img src="<?= $logo['url'] ?>" alt="<?= $logo['alt'] ?>" />
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>