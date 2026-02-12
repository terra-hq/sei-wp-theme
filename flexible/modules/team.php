<?php
    $spacing = get_spacing($module['section_spacing']);
    $title = $module['title'];
    $btn = $module['button'];
    $type = $module['type'];
    $leader = $module['leader']; // relationship of 1
    if ($type == 1) {
        $team = $module['4_members'];
    } else if ($type == 3) {
        $team = $module['1_member'];
    } else if ($type == 4) {
        $team = $module['3_members'];
    } else if ($type == 5) {
        $team = $module['2_members'];
    } else if ($type == 6) {
        $team = $module['more_than_5_members'];
    } else {
        $team = [];
    }
?>

<!-- option 1, Team 01, leader + 4 members -->
<!-- option 2, Team 02, only leader -->
<!-- option 3, Team 03, leader + 1 member -->
<!-- option 4, Team 04, leader + 3 members -->
<!-- option 5, Team 05, leader + 2 members -->
<!-- option 6, Team 06, 5 or more members -->

<?php if($type == 1) { ?>
    <!-- option 1, Team 01, leader + 4 members -->
    <section class="c--bg-b c--bg-b--second <?= $spacing ?>">
        <div class="f--container">
            <!-- title and button -->
            <div class="f--row u--justify-content-space-between f--gap-c u--mb-8">
                <div class="f--col-5 f--col-tabletl-6 f--col-tablets-12">
                    <h2 class="f--font-c f--color-b">
                        <?php if ($title) : ?>
                            <?php foreach ($title as $e) : ?>
                                <?php echo $e['italic'] ? '<span class="f--font-d">' . $e['text'] . '</span>' . ' ' : $e['text'] . ' '; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </h2>
                </div>
                <div class="f--col-3 f--col-tabletl-6 f--col-tablets-12 u--display-flex u--justify-content-flex-end u--justify-content-tablets-flex-start">
                    <?php if ($btn) : ?>
                        <a href="<?= $btn['url'] ?>" <?= get_target_link($btn['target'], $btn['title']) ?> class="g--btn-03 g--btn-03--second">
                            <span class="g--btn-03__content"><?= $btn['title'] ?></span>
                            <?php include(locate_template('img/btn-03-arrow.svg', false, false)); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <!-- team members, leader and 4 members -->
            <div class="f--row f--gap-c u--justify-content-center u--justify-content-tablets-flex-start">
                <div class="f--col-4 f--col-desktop-5 f--col-tabletm-4 f--col-tablets-6 f--col-mobile-12">
                    <!-- leader -->
                    <?php foreach($leader as $key => $person): ?>
                        <?php include(locate_template('components/card/card-c.php', false, false)); ?>
                    <?php endforeach; ?>
                </div>
                <!-- Pay attention, we have a col-7 with a row and col-6 inside of it, to recreate a grid whithout a custom wrapper -->
                <div class="f--col-6 f--col-desktop-7 f--col-tabletm-8 f--col-tablets-12 ">
                    <div class="f--row f--gap-c">
                        <!-- 4 team members -->
                       <?php foreach ($team as $key => $person) : ?>
                        <div class="f--col-6 f--col-mobile-12">
                            <?php include(locate_template('components/card/card-c.php', false, false)); ?>
                        </div> 
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- swirl -->
        <?php if (count($team) >= 3) { ?>
            <div class="c--bg-b__media-wrapper">
                <!-- static image, don't use generate image tag function -->
                <?php
                    $image_tag_args = array(
                        'image' => array( 
                            'url' => get_theme_file_uri('/img/red-swirl.svg'),
                            'width'  => 616,
                            'height' => 542,
                            'sizes' => array(
                                'thumbnail' => get_theme_file_uri('/img/red-swirl.svg'),
                                'small' => get_theme_file_uri('/img/red-swirl.svg'),
                                'medium' => get_theme_file_uri('/img/red-swirl.svg'),
                                'large' => get_theme_file_uri('/img/red-swirl.svg'),
                                'tablets' => get_theme_file_uri('/img/red-swirl.svg'),
                                'mobile' => get_theme_file_uri('/img/red-swirl.svg'),
                            )
                        ),
                        'sizes' => 'large',
                        'class' => 'c--bg-b__media-wrapper__media',
                        'isLazy' => true,
                        'lazyClass' => 'g--lazy-01',
                        'showAspectRatio' => true,
                        'decodingAsync' => true,
                        'fetchPriority' => false,
                        'addFigcaption' => false,
                    );

                    generate_image_tag($image_tag_args);
                ?>
            </div>
        <?php } ?>
    </section>
<?php } elseif($type == 2) { ?>
    <!-- option 2, Team 02, only leader -->
    <section class="c--bg-b <?= $spacing; ?>">
        <div class="f--container">
            <!-- title and button + team member -->
            <div class="f--row f--gap-c">
                <!-- title and button -->
                <div class="f--col-6 f--col-mobile-12">
                    <h2 class="f--font-c f--color-b f--sp-b">
                        <?php if ($title) : ?>
                            <?php foreach ($title as $e) : ?>
                                <?php echo $e['italic'] ? '<span class="f--font-d">' . $e['text'] . '</span>' . ' ' : $e['text'] . ' '; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </h2>
                    <?php if ($btn) : ?>
                        <a href="<?= $btn['url'] ?>" <?= get_target_link($btn['target'], $btn['title']) ?> class="g--btn-03 g--btn-03--second">
                            <span class="g--btn-03__content"><?= $btn['title'] ?></span>
                            <?php include(locate_template('img/btn-03-arrow.svg', false, false)); ?>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="f--col-4 f--col-tabletl-6 f--col-mobile-12">
                    <!-- leader -->
                    <?php foreach($leader as $key => $person): ?>
                        <?php include(locate_template('components/card/card-c.php', false, false)); ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!-- swirl -->
        <div class="c--bg-b__media-wrapper">
            <!-- static image, don't use generate image tag function -->
             <?php
                $image_tag_args = array(
                    'image' => array( 
                        'url' => get_theme_file_uri('/img/red-swirl.svg'),
                        'width'  => 616,
                        'height' => 542,
                        'sizes' => array(
                            'thumbnail' => get_theme_file_uri('/img/red-swirl.svg'),
                            'small' => get_theme_file_uri('/img/red-swirl.svg'),
                            'medium' => get_theme_file_uri('/img/red-swirl.svg'),
                            'large' => get_theme_file_uri('/img/red-swirl.svg'),
                            'tablets' => get_theme_file_uri('/img/red-swirl.svg'),
                            'mobile' => get_theme_file_uri('/img/red-swirl.svg'),
                        )
                    ),
                    'sizes' => 'large',
                    'class' => 'c--bg-b__media-wrapper__media',
                    'isLazy' => true,
                    'lazyClass' => 'g--lazy-01',
                    'showAspectRatio' => true,
                    'decodingAsync' => true,
                    'fetchPriority' => false,
                    'addFigcaption' => false,
                );

                generate_image_tag($image_tag_args);
            ?>
        </div>
    </section>
<?php } elseif($type == 3) { ?>
    <!-- option 3, Team 03, leader + 1 member -->
    <section class="c--bg-b c--bg-b--third <?= $spacing; ?>">
        <div class="f--container">
            <!-- title and button -->
            <div class="f--row u--justify-content-space-between f--gap-c u--mb-8">
                <div class="f--col-4 f--col-tabletl-6 f--col-tablets-12">
                    <h2 class="f--font-c f--color-b">
                        <?php if ($title) : ?>
                            <?php foreach ($title as $e) : ?>
                                <?php echo $e['italic'] ? '<span class="f--font-d">' . $e['text'] . '</span>' . ' ' : $e['text'] . ' '; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </h2>
                </div>
                <div class="f--col-3 f--col-tabletl-6 f--col-tabletm-4 f--col-tablets-6 f--col-mobile-12 u--display-flex u--justify-content-flex-end u--justify-content-tablets-flex-start u--align-items-center">
                    <?php if ($btn) : ?>
                        <a href="<?= $btn['url'] ?>" <?= get_target_link($btn['target'], $btn['title']) ?> class="g--btn-03 g--btn-03--second">
                            <span class="g--btn-03__content"><?= $btn['title'] ?></span>
                            <?php include(locate_template('img/btn-03-arrow.svg', false, false)); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <!-- team members, leader and 1 member -->
            <div class="f--row f--gap-c u--justify-content-center">
                <div class="f--col-4 f--col-desktop-5 f--col-tabletm-4 f--col-tablets-6 f--col-mobile-12">
                    <!-- leader -->
                    <?php foreach($leader as $key => $person): ?>
                        <?php include(locate_template('components/card/card-c.php', false, false)); ?>
                    <?php endforeach; ?>
                </div>
                <!-- Pay attention, we have a col-7 with a row and col-6 inside of it, to recreate a grid whithout a custom wrapper -->
                <div class="f--col-6 f--col-desktop-7 f--col-tabletm-8 f--col-tablets-6 f--col-mobile-12">
                    <div class="f--row f--gap-c">
                        <div class="f--col-6 f--col-tablets-12">
                            <!-- 1 team member -->
                            <?php foreach ($team as $key => $person) : ?>
                                <?php include(locate_template('components/card/card-c.php', false, false)); ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- swirl -->
        <div class="c--bg-b__media-wrapper">
            <!-- static image, don't use generate image tag function -->
             <?php
                $image_tag_args = array(
                    'image' => array( 
                        'url' => get_theme_file_uri('/img/red-swirl.svg'),
                        'width'  => 616,
                        'height' => 542,
                        'sizes' => array(
                            'thumbnail' => get_theme_file_uri('/img/red-swirl.svg'),
                            'small' => get_theme_file_uri('/img/red-swirl.svg'),
                            'medium' => get_theme_file_uri('/img/red-swirl.svg'),
                            'large' => get_theme_file_uri('/img/red-swirl.svg'),
                            'tablets' => get_theme_file_uri('/img/red-swirl.svg'),
                            'mobile' => get_theme_file_uri('/img/red-swirl.svg'),
                        )
                    ),
                    'sizes' => 'large',
                    'class' => 'c--bg-b__media-wrapper__media',
                    'isLazy' => true,
                    'lazyClass' => 'g--lazy-01',
                    'showAspectRatio' => true,
                    'decodingAsync' => true,
                    'fetchPriority' => false,
                    'addFigcaption' => false,
                );

                generate_image_tag($image_tag_args);
            ?>
        </div>
    </section>
<?php } elseif($type == 4) { ?>
    <!-- option 4, Team 04, leader + 3 members -->
    <section class="c--bg-b c--bg-b--fourth <?= $spacing; ?>">
        <div class="f--container">
            <!-- title and button -->
            <div class="f--row u--justify-content-space-between f--gap-c u--mb-8">
                <div class="f--col-5 f--col-tabletl-6 f--col-tablets-12">
                    <h2 class="f--font-c f--color-b">
                        <?php if ($title) : ?>
                            <?php foreach ($title as $e) : ?>
                                <?php echo $e['italic'] ? '<span class="f--font-d">' . $e['text'] . '</span>' . ' ' : $e['text'] . ' '; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </h2>
                </div>
                <div class="f--col-3 f--col-tabletl-6 f--col-tablets-12 u--display-flex u--justify-content-flex-end u--justify-content-tablets-flex-start u--align-items-center">
                    <?php if ($btn) : ?>
                        <a href="<?= $btn['url'] ?>" <?= get_target_link($btn['target'], $btn['title']) ?> class="g--btn-03 g--btn-03--second">
                            <span class="g--btn-03__content"><?= $btn['title'] ?></span>
                            <?php include(locate_template('img/btn-03-arrow.svg', false, false)); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <!-- team members, leader and 3 members -->
            <div class="f--row f--gap-c u--justify-content-center u--justify-content-tablets-flex-start">
                <div class="f--col-4 f--col-desktop-5 f--col-tabletm-4 f--col-tablets-6 f--col-mobile-12">
                    <!-- leader -->
                    <?php foreach($leader as $key => $person): ?>
                        <?php include(locate_template('components/card/card-c.php', false, false)); ?>
                    <?php endforeach; ?>
                </div>
                <!-- Pay attention, we have a col-7 with a row and col-6 inside of it, to recreate a grid whithout a custom wrapper -->
                <div class="f--col-6 f--col-desktop-7 f--col-tabletm-8 f--col-tablets-12 f--col-mobile-12">
                    <div class="f--row f--gap-c">
                       <!-- 3 team members -->
                       <?php foreach ($team as $key => $person) : ?>
                            <div class="f--col-6 f--col-mobile-12">
                                <?php include(locate_template('components/card/card-c.php', false, false)); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- swirl -->
        <div class="c--bg-b__media-wrapper">
            <!-- static image, don't use generate image tag function -->
             <?php
                $image_tag_args = array(
                    'image' => array( 
                        'url' => get_theme_file_uri('/img/red-swirl.svg'),
                        'width'  => 616,
                        'height' => 542,
                        'sizes' => array(
                            'thumbnail' => get_theme_file_uri('/img/red-swirl.svg'),
                            'small' => get_theme_file_uri('/img/red-swirl.svg'),
                            'medium' => get_theme_file_uri('/img/red-swirl.svg'),
                            'large' => get_theme_file_uri('/img/red-swirl.svg'),
                            'tablets' => get_theme_file_uri('/img/red-swirl.svg'),
                            'mobile' => get_theme_file_uri('/img/red-swirl.svg'),
                        )
                    ),
                    'sizes' => 'large',
                    'class' => 'c--bg-b__media-wrapper__media',
                    'isLazy' => true,
                    'lazyClass' => 'g--lazy-01',
                    'showAspectRatio' => true,
                    'decodingAsync' => true,
                    'fetchPriority' => false,
                    'addFigcaption' => false,
                );

                generate_image_tag($image_tag_args);
            ?>
        </div>
    </section>
<?php } elseif($type == 5) { ?>
    <!-- option 5, Team 05, leader + 2 members -->
    <section class="c--bg-b c--bg-b--third <?= $spacing; ?>">
        <div class="f--container">
            <!-- title and button -->
            <div class="f--row u--justify-content-space-between f--gap-c u--mb-8">
                <div class="f--col-5 f--col-tabletl-6 f--col-tablets-12">
                    <h2 class="f--font-c f--color-b">
                        <?php if ($title) : ?>
                            <?php foreach ($title as $e) : ?>
                                <?php echo $e['italic'] ? '<span class="f--font-d">' . $e['text'] . '</span>' . ' ' : $e['text'] . ' '; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </h2>
                </div>
                <div class="f--col-3 f--col-tabletl-6 f--col-tabletm-4 f--col-tablets-6 f--col-mobile-12 u--display-flex u--justify-content-flex-end u--justify-content-tablets-flex-start u--align-items-center">
                    <?php if ($btn) : ?>
                        <a href="<?= $btn['url'] ?>" <?= get_target_link($btn['target'], $btn['title']) ?> class="g--btn-03 g--btn-03--second">
                            <span class="g--btn-03__content"><?= $btn['title'] ?></span>
                            <?php include(locate_template('img/btn-03-arrow.svg', false, false)); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <!-- team members, leader and 2 members -->
            <div class="f--row f--gap-c u--justify-content-center u--justify-content-tablets-flex-start">
                <div class="f--col-4 f--col-desktop-5 f--col-tabletm-4 f--col-tablets-6 f--col-mobile-12">
                    <!-- leader -->
                    <?php foreach($leader as $key => $person): ?>
                        <?php include(locate_template('components/card/card-c.php', false, false)); ?>
                    <?php endforeach; ?>
                </div>
                <!-- Pay attention, we have a col-7 with a row and col-6 inside of it, to recreate a grid whithout a custom wrapper -->
                <div class="f--col-6 f--col-desktop-7 f--col-tabletm-8 f--col-tablets-12">
                    <div class="f--row f--gap-c">
                            <!-- 2 team members -->
                            <?php foreach ($team as $key => $person) : ?>
                                <div class="f--col-6 f--col-mobile-12">
                                <?php include(locate_template('components/card/card-c.php', false, false)); ?>
                                </div>
                            <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- swirl -->
        <div class="c--bg-b__media-wrapper">
            <!-- static image, don't use generate image tag function -->
             <?php
                $image_tag_args = array(
                    'image' => array( 
                        'url' => get_theme_file_uri('/img/red-swirl.svg'),
                        'width'  => 616,
                        'height' => 542,
                        'sizes' => array(
                            'thumbnail' => get_theme_file_uri('/img/red-swirl.svg'),
                            'small' => get_theme_file_uri('/img/red-swirl.svg'),
                            'medium' => get_theme_file_uri('/img/red-swirl.svg'),
                            'large' => get_theme_file_uri('/img/red-swirl.svg'),
                            'tablets' => get_theme_file_uri('/img/red-swirl.svg'),
                            'mobile' => get_theme_file_uri('/img/red-swirl.svg'),
                        )
                    ),
                    'sizes' => 'large',
                    'class' => 'c--bg-b__media-wrapper__media',
                    'isLazy' => true,
                    'lazyClass' => 'g--lazy-01',
                    'showAspectRatio' => true,
                    'decodingAsync' => true,
                    'fetchPriority' => false,
                    'addFigcaption' => false,
                );

                generate_image_tag($image_tag_args);
            ?>
        </div>
    </section>
<?php } elseif($type == 6) { ?>
    <!-- option 6, Team 06, 5 or more members -->
    <section class="c--bg-b c--bg-b--sixth <?= $spacing; ?>">
        <div class="f--container">
            <!-- title and button -->
            <div class="f--row u--justify-content-space-between f--gap-c u--mb-8">
                <div class="f--col-5 f--col-tabletl-6 f--col-tablets-12">
                    <h2 class="f--font-c f--color-b">
                        <?php if ($title) : ?>
                            <?php foreach ($title as $e) : ?>
                                <?php echo $e['italic'] ? '<span class="f--font-d">' . $e['text'] . '</span>' . ' ' : $e['text'] . ' '; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </h2>
                </div>
                <div class="f--col-3 f--col-tabletl-6 f--col-tablets-12 u--display-flex u--justify-content-flex-end u--justify-content-tablets-flex-start u--align-items-center">
                    <?php if ($btn) : ?>
                        <a href="<?= $btn['url'] ?>" <?= get_target_link($btn['target'], $btn['title']) ?> class="g--btn-03 g--btn-03--second">
                            <span class="g--btn-03__content"><?= $btn['title'] ?></span>
                            <?php include(locate_template('img/btn-03-arrow.svg', false, false)); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <!-- team members, 5 or more members -->
            <div class="c--layout-c">
                <?php foreach($team as $key => $person): ?>
                    <div class="c--layout-c__item">
                        <?php include(locate_template('components/card/card-c.php', false, false)); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php } ?>