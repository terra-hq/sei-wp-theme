<?php
    $spacing = get_spacing($module['spacing']);
    $bgColor = $module['bg_color'];
    if ($bgColor === 'f--background-c' || $bgColor === 'f--background-d') $color = 'f--color-a'; // blanco
    else $color = 'f--color-c'; // rojo
    $title = $module['title'];
    $btn = $module['button'];
    $how_to_loop = $module['how_to_loop'];
    $cards = $module['cards'];
    $pick_topic = $module['pick_topic'];
    $pick_capability = $module['pick_capability'];

    switch ($how_to_loop) {
        case 'last':
            $args = array(
                'post_type' => 'insight',
                'posts_per_page' => 2,
                'orderby' => 'date',
                'order' => 'DESC',
            );
          break;
        case (strpos($how_to_loop, 'taxonomy-') === 0):
            $taxonomy = substr($how_to_loop, 9);
            $terms = wp_list_pluck($taxonomy == 'capability' ? $pick_capability : $pick_topic, 'slug');
            $taxonomy_name = ($taxonomy == 'capability') ? 'insight-capability' : 'topics';
            $args = array(
                'post_type' => 'insight',
                'posts_per_page' => 2,
                'orderby' => 'title',
                'order' => 'ASC',
                'tax_query' => array(
                    array(
                        'taxonomy' => $taxonomy_name,
                        'field' => 'slug',
                        'terms' => $terms,
                    ),
                )
            );
            break;
        default:
            $selected_ids = array_map(function($post) {
                return $post->ID;
            }, $cards);

            $args = array(
                'post_type' => 'insight',
                'posts_per_page' => 2,
                'order' => 'ASC',
                'post__in' => $selected_ids,
                'orderby' => 'post__in',
            );
        }
    $custom_query = new WP_Query($args);

    if ($custom_query->have_posts()):
?>

<section class="<?= $bgColor ?> <?= $spacing ?>">
    <div class="f--container">
        <div class="f--row f--gap-c u--justify-content-space-between">
            <div class="f--col-5 f--col-tabletm-12">
                <h2 class="f--font-c f--mb-5 f--mt-5 <?= ($bgColor != "f--background-a") ? "f--color-a" : "" ?>">
                    <?php
                        if ($title) {
                            foreach ($title as $e) {
                                $text = $e['text'];
                                $italic = $e['italic'];
                                if ($italic) {
                                    echo '<span class="f--font-d">' . $text . '</span>';
                                } else {
                                    echo $text . ' ';
                                }
                            }
                        }
                    ?>
                </h2>
                <a href="<?= $btn['url'] ?>" class="g--btn-03 g--btn-03--second">
                    <span class="g--btn-03__content">
                        <?= $btn['title'] ?>
                    </span>
                    <?php include(locate_template('public/assets/btn-03-arrow.svg', false, false)); ?>
                </a>
            </div>
            <div class="f--col-6 f--col-tabletm-12">
                <div class="c--wrapper-a">
                    <?php
                        while ($custom_query->have_posts()): $custom_query->the_post();
                        $modifierClass = ($bgColor != "f--background-a") ? "second" : null;
                        $subtitle = implode(', ', wp_list_pluck(get_the_terms(get_the_ID(), 'insight-types'), 'name'));
                        $tags = wp_list_pluck(get_the_terms(get_the_ID(), 'topics'), 'name');
                        $card = array(
                            'ID' => get_the_ID(),
                            'subtitle' =>  $subtitle,
                            'title' => get_the_title(),
                            'excerpt' => get_the_excerpt(),
                            'permalink' => get_permalink(),
                            'tags' =>  $tags,
                        );
                        include (locate_template('components/card/card-l.php', false, false));
                        if ($custom_query->current_post < $custom_query->post_count - 1) { ?>
                            <hr class="c--divider-a <?= ($bgColor != "f--background-a") ? "c--divider-a--second" : ""; ?>">
                    <?php } endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
        wp_reset_postdata();
    endif;
?>