<?php
$bg_color = $module['background_color'];
$spacing = get_spacing($module['spacing']);
$case_studies = $module['case_studies'];
?>
<section class="c--slider-a c--slider-a--second <?= esc_attr($bg_color) ?> <?= esc_attr($spacing) ?>">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-12">
                <div class="c--slider-a__wrapper js--slider-a">
                    <?php if ($case_studies) : ?>
                        <?php foreach ($case_studies as $single_case_study) : ?>

                            <?php
                            $is_external = get_field('case_study_type', $single_case_study->ID) === 'external';
                            if ($is_external) {
                                $case_link   = get_field('download_pdf', $single_case_study->ID);
                                $case_target = '_blank';
                                $case_rel    = 'noopener noreferrer';
                            } else {
                                $case_link   = get_permalink($single_case_study->ID);
                                $case_target = '';
                                $case_rel    = '';
                            }

                            // fallback imagen
                            $image = get_post_thumbnail_id($single_case_study->ID);
                            $image_to_use = $image ? $image : get_field('placeholder_image', 'options');
                            ?>

                            <div class="c--slider-a__wrapper__item">
                                <div class="c--card-m">
                                    <div class="f--row">

                                        <!-- IMAGEN -->
                                        <div class="f--col-4 f--col-tabletl-12">
                                            <a href="<?= esc_url($case_link) ?>" <?= $case_target ? 'target="'.esc_attr($case_target).'"' : '' ?> <?= $case_rel ? 'rel="'.esc_attr($case_rel).'"' : '' ?> class="u--overflow-hidden">
                                                <div class="c--card-m__wrapper">
                                                    <?php
                                                    $image_tag_args = array(
                                                        'image' => $image_to_use,
                                                        'sizes' => '(max-width: 810px) 50vw, 100vw',
                                                        'class' => 'c--card-m__wrapper__media',
                                                        'isLazy' => false,
                                                        'showAspectRatio' => true,
                                                        'decodingAsync' => true,
                                                        'fetchPriority' => false,
                                                        'addFigcaption' => false,
                                                    );
                                                    if ($image_to_use) {
                                                        generate_image_tag($image_tag_args);
                                                    }
                                                    ?>
                                                </div>
                                            </a>
                                        </div>

                                        <!-- WHAT WE DID -->
                                        <div class="f--col-4 f--col-tabletl-12">
                                            <div class="c--card-m__hd">
                                                <p class="c--card-m__hd__title">WHAT WE DID</p>
                                                <a href="<?= esc_url($case_link) ?>" <?= $case_target ? 'target="'.esc_attr($case_target).'"' : '' ?> <?= $case_rel ? 'rel="'.esc_attr($case_rel).'"' : '' ?> class="c--card-m__hd__paragraph">
                                                    <?= esc_html(get_the_title($single_case_study->ID)) ?>
                                                </a>
                                                <a class="g--link-01 g--link-01--fourth" href="<?= esc_url($case_link) ?>" <?= $case_target ? 'target="'.esc_attr($case_target).'"' : '' ?> <?= $case_rel ? 'rel="'.esc_attr($case_rel).'"' : '' ?>>Learn More</a>
                                            </div>
                                        </div>

                                        <!-- HOW WE HELPED / PILLS -->
                                        <div class="f--col-4 f--col-tabletl-12">
                                            <div class="c--card-m__ft">
                                                <p class="c--card-m__ft__title">HOW WE HELPED</p>
                                                <div class="c--card-m__ft__items">
                                                    <?php
                                                    // Capabilities
                                                    $capabilities = get_the_terms($single_case_study->ID, 'case-study-capability');
                                                    if ($capabilities && !is_wp_error($capabilities)) :
                                                        foreach ($capabilities as $cap) :
                                                            $related_post = get_field('capabilities', 'case-study-capability_' . $cap->term_id);
                                                            $pill_link = '#';
                                                            if ($related_post && !empty($related_post)) {
                                                                $cap_post = is_array($related_post) ? $related_post[0] : $related_post;
                                                                if (!empty($cap_post->ID)) $pill_link = get_permalink($cap_post->ID);
                                                            }
                                                            if ($pill_link !== '#') : ?>
                                                                <a class="g--pill-01" href="<?= esc_url($pill_link) ?>"><?= esc_html($cap->name) ?></a>
                                                            <?php else : ?>
                                                                <span class="g--pill-01"><?= esc_html($cap->name) ?></span>
                                                            <?php endif;
                                                        endforeach;
                                                    endif;

                                                    // Industries
                                                    $industries = get_the_terms($single_case_study->ID, 'case-study-industry');
                                                    if ($industries && !is_wp_error($industries)) :
                                                        foreach ($industries as $ind) :
                                                            $related_post = get_field('industries', 'case-study-industry_' . $ind->term_id);
                                                            $pill_link = '#';
                                                            if ($related_post && !empty($related_post)) {
                                                                $ind_post = is_array($related_post) ? $related_post[0] : $related_post;
                                                                if (!empty($ind_post->ID)) $pill_link = get_permalink($ind_post->ID);
                                                            }
                                                            if ($pill_link !== '#') : ?>
                                                                <a class="g--pill-01" href="<?= esc_url($pill_link) ?>"><?= esc_html($ind->name) ?></a>
                                                            <?php else : ?>
                                                                <span class="g--pill-01"><?= esc_html($ind->name) ?></span>
                                                            <?php endif;
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
