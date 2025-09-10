<?php
/*
Template Name: Services Index
*/
?>
<?php get_header(); ?>

<?php
    $hero_title = get_field('hero_title');
    $hero_subtitle = get_field('hero_subtitle');
    $heroDynamic = [];
    if ($hero_title) {
        $heroDynamic = [];
        foreach ($hero_title as $heroTitle) {
            $heroDynamic[] = [
                'text' => $heroTitle['text'],
                'italic' => !empty($heroTitle['is_highligted']) ? true : false
            ];
        }
    }
    

    $hero = [
        'title' => $heroDynamic,
        'subtitle' => $hero_subtitle
    ];
    

    include(locate_template('flexible/hero/big-heading-tagline-hero.php', false, false));
?>
<?php 
$args = array(
    'post_type' => 'services',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order' => 'ASC'
);
$services = get_posts($args);
$grouped_services = [];

if ($services) {
    foreach ($services as $service) {
        $service_title = get_the_title($service->ID);
        $service_link  = get_the_permalink($service->ID);
        $type          = get_the_terms($service->ID, 'service-type');

        if ($type && !is_wp_error($type)) {
            $term       = $type[0];
            $group_key  = $term->term_id;
            $order_key  = get_field('text', 'service-type_' . $term->term_id); // ACF "text" para ordenar
            $term_link  = get_term_link($term);

            if (!isset($grouped_services[$group_key])) {
                $grouped_services[$group_key] = [
                    'label'     => $term->name, // lo que se muestra como título
                    'order_key' => $order_key ?: $term->name, // fallback al nombre si no hay ACF
                    'link'      => !is_wp_error($term_link) ? $term_link : '#',
                    'services'  => []
                ];
            }

            $grouped_services[$group_key]['services'][] = [
                'title' => $service_title,
                'link'  => $service_link,
                'type'  => $term->name
            ];
        }
    }

    // Ordenar por el campo ACF "text", y si no existe, por el nombre
    uasort($grouped_services, function ($a, $b) {
        return strcasecmp((string) $a['order_key'], (string) $b['order_key']);
    });
}
?>

<section class="u--pb-15 u--pb-tablets-10">
    <div class="f--container">
        <div class="f--row f--gap-a">
            <?php foreach ($grouped_services as $group) { ?>
                <div class="f--col-4 f--col-tablets-6 f--col-mobile-12">
                    <h2 class="f--font-g u--mb-3">
                        <a href="<?= esc_url($group['link']) ?>" 
                           class="g--link-01 g--link-01--second">
                           <?= esc_html($group['label']) ?>
                        </a>
                    </h2>
                    <div class="f--row f--gap-d">
                        <?php foreach ($group['services'] as $service) { ?>
                            <div class="f--col-12">
                                <a href="<?= esc_url($service['link']) ?>" 
                                   class="f--font-h u--font-light g--link-01 g--link-01--second">
                                   <?= esc_html($service['title']) ?>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<?php 
    get_footer();
?>