<?php $featured_people = $module['featured_people'];
if($featured_people): ?>
<section class="<?php echo $module['bg_color']?> <?= get_spacing($module['section_spacing']) ?>">
    <div class="f--container">
        <div class="f--row f--gap-c u--justify-content-mobile-center">
            <?php foreach($featured_people as $key => $person): ?>
            <div class="f--col-3 f--col-desktop-4 f--col-tablets-6 f--col-mobile-10">
                <?php include(locate_template('components/card/card-c.php', false, false)); ?>
            </div>
            <?php endforeach; ?>
            <div class="f--col-3 f--col-desktop-4 f--col-tablets-6 f--col-mobile-10">
                <?php include(locate_template('components/cta/cta-e.php', false, false)); ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>