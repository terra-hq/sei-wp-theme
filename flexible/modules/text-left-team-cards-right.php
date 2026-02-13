<?php
$spacing = get_spacing($module['section_spacing']);
$title = $module['title'] ?? '';
$subtitle = $module['subtitle'] ?? '';
$experts = $module['experts'] ?? [];
?>

<section class="c--layout-e <?= $spacing; ?>">
    <div class="f--container">
        <div class="f--row f--gap-b u--justify-content-space-between">
            <div class="f--col-12 f--col-laptop-5 f--col-tablets-10">
                <?php if ($title): ?>
                    <h2 class="c--layout-e__title">
                        <?= $title ?>
                    </h2>
                <?php endif; ?>
                <?php if ($subtitle): ?>
                    <div class="c--layout-e__content">
                        <?= $subtitle ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="f--col-12 f--col-laptop-6 f--col-tablets-12">
                <?php if (!empty($experts)): ?>
                    <div class="f--row f--gap-c u--justify-content-flex-end u--justify-content-tablets-center">
                        <?php foreach ($experts as $expert): ?>
                            <div class="f--col-10 f--col-tablets-6">
                                <div class="c--card-c">
                                    <div class="c--card-c__wrapper">
                                        <div class="c--card-c__wrapper__media-wrapper">
                                            <?php if (!empty($expert->picture)): ?>
                                                <?php
                                                $image_tag_args = [
                                                    'image' => $expert->picture,
                                                    'sizes' => 'medium',
                                                    'class' => 'c--card-c__wrapper__media-wrapper__media',
                                                    'isLazy' => true,
                                                    'lazyClass' => 'g--lazy-01',
                                                    'showAspectRatio' => false,
                                                    'decodingAsync' => true,
                                                    'fetchPriority' => false,
                                                    'addFigcaption' => false,
                                                ];
                                                generate_image_tag($image_tag_args);
                                                ?>
                                            <?php endif; ?>
                                        </div>

                                        <h3 class="c--card-c__wrapper__title">
                                            <?= get_the_title($expert->ID) ?>
                                        </h3>
                                        <?php if (!empty($expert->job_position)): ?>
                                            <div class="c--card-c__wrapper__subtitle">
                                                <?= $expert->job_position ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($expert->people_single_years)): ?>
                                            <span class="g--pill-01">
                                                <?= intval($expert->people_single_years) ?>+ years
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php unset($spacing, $title, $subtitle, $experts); ?>
