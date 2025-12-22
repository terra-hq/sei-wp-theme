<?php
$spacing      = get_spacing($module['spacing']);
$case_studies = $module['case_studies'];
?>

<section class="<?= $spacing ?>">
    <div class="f--container">
        <div class="f--row">

            <?php if ($case_studies) : ?>
                <?php foreach ($case_studies as $case_study) : ?>
                    <?php
                    $case_study_id = $case_study->ID;
                    $left_column_label = 'OUR CLIENT';
                    $right_column_label = 'HOW WE HELPED';
                    include(locate_template('components/card/card-m.php', false, false));
                    ?>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>
</section>

<?php unset($spacing, $case_studies, $case_study, $case_study_id); ?>
