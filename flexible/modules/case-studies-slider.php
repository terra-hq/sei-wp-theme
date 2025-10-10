<?php
$bg_color = $module['background_color'];
$spacing = get_spacing($module['spacing']);
$case_studies = $module['case_studies'];
?>
<section class="c--slider-a c--slider-a--second <?= $bg_color ?> <?= $spacing ?>">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-12">
                <div class="c--slider-a__wrapper js--slider-a">
                    <?php if($case_studies) { ?>
                        <?php foreach ($case_studies as $key => $single_case_study) { ?>
                            <div class="c--slider-a__wrapper__item">
                                <div class="c--card-m">
                                    <div class="f--row u--display-flex u--align-items-center">
                                        <div class="f--col-4 f--col-tabletm-12">
                                            <a href="<?= $featured_case_study_link ?>" target="<?= $target ?>"  rel="<?= $self ?>" class="u--overflow-hidden">
                                                <div class="c--card-m__wrapper">
                                                    <?php $image = get_post_thumbnail_id($single_case_study->ID); ?>
                                                    <?php
                                                        $image_tag_args = array(
                                                            'image' => $image,
                                                            'sizes' => '(max-width: 810px) 50vw, 100vw',
                                                            'class' => 'c--card-m__wrapper__media',
                                                            'isLazy' => false,
                                                            'showAspectRatio' => true,
                                                            'decodingAsync' => true,
                                                            'fetchPriority' => false,
                                                            'addFigcaption' => false,
                                                        );
                                                        generate_image_tag($image_tag_args)
                                                        ?>
                                                </div>
                                            </a>
                                        </div>
                                        
                                        <?php 
                                            $is_external = get_field('case_study_type', $single_case_study->ID) === "external";
                                            if($is_external) {
                                                $featured_case_study_link =  get_field('download_pdf', $single_case_study->ID);
                                                $target= '_blank';
                                                $rel = 'noopener noreferrer';
                                            } else {
                                                $featured_case_study_link = get_permalink($single_case_study->ID);
                                                $target = '';
                                                $rel = '';
                                            }
                                        ?>
                                        <div class="f--col-4 f--col-tabletm-12">
                                            <div class="c--card-m__hd">
                                                <p  class="c--card-m__hd__title">WHAT WE DID</p>
                                                <a href="<?= $featured_case_study_link ?>" target="<?= $target ?>"  rel="<?= $self ?>"  class="c--card-m__hd__paragraph"><?= get_the_title($single_case_study->ID); ?></a>
                                                <a class="g--link-01 g--link-01--fourth" href="<?= $featured_case_study_link ?>" target="<?= $target ?>"  rel="<?= $self ?>">Learn More</a>
                                            </div>
                                        </div>

                                        <?php $types = get_the_terms($single_case_study->ID, 'case-study-capability'); ?>
                                        <?php if($types)  { ?>
                                              <div class="f--col-4 f--col-tabletm-12">
                                                <div class="c--card-m__ft">
                                                    <p class="c--card-m__ft__title">HOW WE HELPED</p>
                                                    <div class="c--card-m__ft__items">
                                                        <?php foreach ($types as $type) { ?>
                                                            <a class="g--pill-01" href="<?= get_term_link($type) ?>"><?= $type->name ?></a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                             </div>
                                        <?php } ?>
                                    </div>  
                                </div>   
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>