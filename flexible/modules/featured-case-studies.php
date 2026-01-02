<?php
$spacing         = get_spacing($module['spacing']);
$how_to_display  = $module['how_to_display'];
$category        = $module['category'] ?? '';
$case_studies    = $module['case_studies'];

if ($how_to_display === 'latest' && $category) {
    $args = [
        'post_type'      => 'case-study',
        'posts_per_page' => 3,
        'tax_query'      => [
            [
                'taxonomy' => 'case-study-capability',
                'field'    => 'term_id',
                'terms'    => $category,
            ],
        ],
    ];

    $case_studies_query = new WP_Query($args);
    $case_studies = $case_studies_query->posts;
}
?>

<section class="<?= esc_attr($spacing) ?>">
    <div class="f--container">
        <div class="f--row">

            <?php if ($case_studies) : ?>
                <?php foreach ($case_studies as $case_study) : ?>
                    <?php
                    $case_study_id = $case_study->ID;
                    $left_column_label  = 'OUR CLIENT';
                    $right_column_label = 'HOW WE HELPED';
                    include(locate_template('components/card/card-m.php', false, false));
                    ?>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>
</section>

<?php 
if ($how_to_display === 'latest' && $category) {
    wp_reset_postdata();
}

unset($spacing, $case_studies, $case_study, $case_study_id, $how_to_display, $category); 
?>
