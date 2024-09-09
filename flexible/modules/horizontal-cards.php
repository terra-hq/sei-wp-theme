<?php
$args = array(
    'post_type' => 'capability',
    'post_parent' => 0,
    'posts_per_page' => -1,
    'orderby' => 'title',     
    'order' => 'ASC'
);

$query = new WP_Query($args);

if ($query->have_posts()) : ?>
    <section class="f--background-d <?= get_spacing($module['section_spacing']); ?>">
        <div class="f--container">
            <div class="f--row">
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <div class="f--col-12">
                        <?php $title = get_the_title($post->ID);
                        $homepage_tagline = get_field('homepage_tagline', $post->ID); 
                        $permalink = get_the_permalink($post->ID) ?>
                        <?php include(locate_template('components/card/card-a.php', false, false)); ?>
                    </div>
                <?php endwhile;
                    wp_reset_postdata();  ?>
            </div>
        </div>
    </section>
<?php endif; ?>