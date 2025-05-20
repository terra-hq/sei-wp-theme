<?php
$spacing = get_spacing($module['spacing']);
$how_to_loop = $module['how_to_loop'];
$pick_topic = $module['pick_topic'];
$pick_type = $module['pick_type'];

$args = array(
    'post_type' => 'insight',
    'posts_per_page' => 9,
    'orderby' => 'date',
    'order' => 'DESC',
);

switch ($how_to_loop) {
    case 'topic':
        $args = array(
            'post_type' => 'insight',
            'posts_per_page' => 9,
            'orderby' => 'date',
            'order' => 'DESC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'topics',
                    'field'    => 'id',
                    'terms'    => $pick_topic,
                ),
            ),
        );
        break;

    case 'type':
        $args = array(
            'post_type' => 'insight',
            'posts_per_page' => 9,
            'orderby' => 'date',
            'order' => 'DESC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'insight-types',
                    'field'    => 'id',
                    'terms'    => $pick_type,
                ),
            ),
        );
        break;
}
?>
<section class="c--slider-a <?= $spacing ?>">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-12">
                <div class="c--slider-a__wrapper js--slider-c">
                    <?php
                    $custom_query = new WP_Query($args);
                    if ($custom_query->have_posts()) :
                        while ($custom_query->have_posts()) : $custom_query->the_post();
                            $insight_types = get_the_terms(get_the_ID(), 'insight-types');
                            if ($insight_types && !is_wp_error($insight_types)) {
                                $insight_type = $insight_types[0];
                                $insight_type_name = $insight_type->name;
                            }
                            $title = get_the_title();
                            $topics = get_the_terms(get_the_ID(), 'topics');
                            $permalink = get_the_permalink();
                            $image = get_post_thumbnail_id(get_the_ID());
                                include(locate_template('components/card/card-24.php', false, false));
                        endwhile;
                    endif;
                    wp_reset_postdata();
                    ?>
                </div>

            </div>
        </div>
    </div>
</section>
