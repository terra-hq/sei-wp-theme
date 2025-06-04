<?php $stats = $module['stats'];
if ($stats) : ?>
    <section class="<?php echo $module['bg_color'] ?> <?= get_spacing($module['section_spacing']); ?>">
        <div class="f--container">
            <div class="f--row f--gap-b u--justify-content-space-between">
                <?php foreach ($stats as $key => $eachStat) : ?>
                    <?php if (($key % 2) == 0) {
                                $customClass = 'f--offset-4 f--offset-tabletm-0';
                            } else {
                                $customClass = '';
                            } ?>
                    <div class="f--col-4 f--col-tabletm-6 f--col-mobile-12 <?php echo $customClass ?> u--display-flex">
                        <?php include(locate_template('components/card/card-d.php', false, false)); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php unset($stats, $customClass); ?>