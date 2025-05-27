<?php
    $spacing = get_spacing($module['section_spacing']);
    $bg_color = $module['bg_color'];
    $testimonials = $module['testimonials'];
?>

<section class="c--slider-a <?= $bg_color ?> <?= $spacing ?>">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-12">
                <div class="c--slider-a__wrapper js--slider-a">
                    <?php foreach($testimonials as $testimonial): ?>
                        <?php
                            $people_post = $testimonial['team'][0];
                            $small_heading = $testimonial['small_heading'];
                            $description = $testimonial['description'];
                            $name = get_the_title($people_post->ID);
                            $job_position = get_field('job_position', $people_post->ID);
                            $image = get_field('picture', $people_post->ID);
                        ?>
                        <div class="c--slider-a__wrapper__item">
                            <?php include(locate_template('components/card/card-g.php', false, false)) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
    unset($spacing, $bg_color, $testimonials, $people_post, $small_heading, $description, $name, $job_position, $image);
?>