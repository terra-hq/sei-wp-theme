<div class="c--card-c">
    <div class="c--card-c__wrapper">
        <div class="c--card-c__wrapper__media-wrapper">
            <?php
                $image_tag_args = array(
                    'image' => get_field('picture', $person->ID),
                    'sizes' => 'medium',
                    'class' => 'c--card-c__wrapper__media-wrapper__media',
                    'isLazy' => true,
                    'lazyClass' => 'g--lazy-01',
                    'showAspectRatio' => false,
                    'decodingAsync' => true,
                    'fetchPriority' => false,
                    'addFigcaption' => false,
                );
                if(get_field('picture', $person->ID)){
                    generate_image_tag($image_tag_args);
                }
            ?>
        </div>

        <h3 class="c--card-c__wrapper__title">
            <?php echo get_the_title($person->ID) ?>
        </h3>
        <div class="c--card-c__wrapper__subtitle">
            <?php
                $job_position = get_field('job_position', $person->ID);
                if(is_singular('location')){
                    $location = null;
                } else {
                    $location = get_field('location', $person->ID);
                }

                if (!empty($job_position) && !empty($location)) {
                    echo $job_position . ',';
                } else if (!empty($job_position)) {
                    echo $job_position;
                }
                
                $post_title = '';
                $post_url = '';

                if (!empty($location) && is_array($location) && isset($location[0]) && is_object($location[0]) && property_exists($location[0], 'ID')) {
                    $post_title = $location[0]->post_title;
                    $post_url = get_permalink($location[0]->ID);
                }
            ?>
            <a href="<?php echo $post_url ? $post_url : '#' ?>" class="c--card-c__wrapper__subtitle__link">
                <?php echo $post_title ? $post_title : '' ?>
            </a>
        </div>
        <div class="c--card-c__wrapper__ft">
            <?php if(get_field('linkedin_link', $person->ID)): ?>
            <a href="<?php echo get_field('linkedin_link', $person->ID) ?>" target="_blank" rel="noopener nofollow" class="c--card-c__wrapper__ft__link">
                <img src="<?php bloginfo('template_url'); ?>/img/linkedin.svg" class="c--card-c__wrapper__ft__link__icon">
            </a>
            <?php endif; ?>
            <?php if(get_field('email', $person->ID)): ?>
            <a href="mailto:<?php echo get_field('email', $person->ID) ?>" class="c--card-c__wrapper__ft__link">
                <img src="<?php bloginfo('template_url'); ?>/img/envelope.svg" class="c--card-c__wrapper__ft__link__icon">
            </a>
            <?php endif; ?>

        </div>
    </div>
</div>