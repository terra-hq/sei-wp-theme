<?php
$spacing = get_spacing($module['section_spacing']);
$title = $module['title'] ?? '';
$subtitle = $module['subtitle'] ?? '';
$experts = $module['experts'] ?? [];
?>

<section class="<?= $spacing; ?>">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-12">

                <?php if ($title): ?>
                    <p><strong>Title:</strong> <?= $title ?></p>
                <?php endif; ?>

                <?php if ($subtitle): ?>
                    <p><strong>Subtitle:</strong> <?= $subtitle ?></p>
                <?php endif; ?>

                <?php if (!empty($experts)): ?>
                    <?php foreach ($experts as $expert): ?>
                        <div>
                            <?php if (!empty($expert->picture)): ?>
                                <p><strong>Picture:</strong></p>
                                <?php
                                $image_tag_args = [
                                    'image' => $expert->picture,
                                    'sizes' => 'medium',
                                    'isLazy' => false
                                ];
                                generate_image_tag($image_tag_args);
                                ?>
                            <?php endif; ?>

                            <?php if (!empty($expert->people_single_description)): ?>
                                <p><strong>Description:</strong> <?= $expert->people_single_description ?></p>
                            <?php endif; ?>

                            <?php if (!empty($expert->people_single_years)): ?>
                                <p><strong>Years:</strong> <?= $expert->people_single_years ?></p>
                            <?php endif; ?>

                            <?php
                            $specialities = get_field('people_single_specialities', $expert->ID) ?: [];
                            if (!empty($specialities)): ?>
                                <p><strong>Specialities:</strong></p>
                                <ul>
                                    <?php foreach ($specialities as $speciality): ?>
                                        <li><?= $speciality['speciality_pill_text'] ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>

<?php unset($spacing, $title, $subtitle, $experts); ?>
