<?php
/**
 * Required:
 * $case_study_id (int)
 */

$left_column_label  = isset($left_column_label) ? $left_column_label : 'WHAT WE DID';
$right_column_label = isset($right_column_label) ? $right_column_label : 'HOW WE HELPED';

$is_external = get_field('case_study_type', $case_study_id) === 'external';
if ($is_external) {
    $case_link = get_field('download_pdf', $case_study_id);
    $target    = '_blank';
    $rel       = 'noopener noreferrer';
} else {
    $case_link = get_permalink($case_study_id);
    $target    = '';
    $rel       = '';
}

// Image fallback
$image        = get_post_thumbnail_id($case_study_id);
$image_to_use = $image ? $image : get_field('placeholder_image', 'options');
?>

<div class="c--card-m">
    <div class="f--row ">

        <!-- IMAGE -->
        <div class="f--col-4 f--col-tabletm-12">
            <a href="<?= esc_url($case_link) ?>"
               <?= $target ? 'target="'.$target.'"' : '' ?>
               <?= $rel ? 'rel="'.$rel.'"' : '' ?>
               class="u--overflow-hidden">

                <div class="c--card-m__wrapper">
                    <?php
                    if ($image_to_use) {
                        generate_image_tag(array(
                            'image' => $image_to_use,
                            'sizes' => 'large',
                            'class' => 'c--card-m__wrapper__media',
                            'isLazy' => false,
                            'showAspectRatio' => true,
                            'decodingAsync' => true,
                            'fetchPriority' => false,
                            'addFigcaption' => false,
                        ));
                    }
                    ?>
                </div>
            </a>
        </div>

        <!-- WHAT WE DID -->
        <div class="f--col-4 f--col-tabletm-12">
            <div class="c--card-m__hd">
                <p class="c--card-m__hd__title"><?= esc_html($left_column_label); ?></p>
                <a href="<?= esc_url($case_link) ?>"
                   <?= $target ? 'target="'.$target.'"' : '' ?>
                   <?= $rel ? 'rel="'.$rel.'"' : '' ?>
                   class="c--card-m__hd__paragraph">
                    <?= esc_html(get_the_title($case_study_id)); ?>
                </a>
                <a class="g--link-01 g--link-01--fourth"
                   href="<?= esc_url($case_link) ?>"
                   <?= $target ? 'target="'.$target.'"' : '' ?>
                   <?= $rel ? 'rel="'.$rel.'"' : '' ?>>
                    Learn More
                </a>
            </div>
        </div>

        <!-- HOW WE HELPED -->
        <div class="f--col-4 f--col-tabletm-12">
            <div class="c--card-m__ft">
                <p class="c--card-m__ft__title"><?= esc_html($right_column_label); ?></p>
                <div class="c--card-m__ft__items">

                    <?php
                    // Capabilities
                    $capabilities = get_the_terms($case_study_id, 'case-study-capability');
                    if ($capabilities && !is_wp_error($capabilities)) :
                        foreach ($capabilities as $cap) :
                            $related_post = get_field('capabilities', 'case-study-capability_' . $cap->term_id);
                            $pill_link = '#';
                            if ($related_post) {
                                $cap_post = is_array($related_post) ? $related_post[0] : $related_post;
                                if (!empty($cap_post->ID)) {
                                    $pill_link = get_permalink($cap_post->ID);
                                }
                            }
                            echo $pill_link !== '#'
                                ? '<a class="g--pill-01" href="'.esc_url($pill_link).'">'.esc_html($cap->name).'</a>'
                                : '<span class="g--pill-01">'.esc_html($cap->name).'</span>';
                        endforeach;
                    endif;

                    // Industries
                    $industries = get_the_terms($case_study_id, 'case-study-industry');
                    if ($industries && !is_wp_error($industries)) :
                        foreach ($industries as $ind) :
                            $related_post = get_field('industries', 'case-study-industry_' . $ind->term_id);
                            $pill_link = '#';
                            if ($related_post) {
                                $ind_post = is_array($related_post) ? $related_post[0] : $related_post;
                                if (!empty($ind_post->ID)) {
                                    $pill_link = get_permalink($ind_post->ID);
                                }
                            }
                            echo $pill_link !== '#'
                                ? '<a class="g--pill-01" href="'.esc_url($pill_link).'">'.esc_html($ind->name).'</a>'
                                : '<span class="g--pill-01">'.esc_html($ind->name).'</span>';
                        endforeach;
                    endif;
                    ?>

                </div>
            </div>
        </div>

    </div>
</div>
