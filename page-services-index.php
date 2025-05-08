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
    if($services){
        foreach($services as $service){
            $service_title = get_the_title($service->ID);
            $service_link = get_the_permalink($service->ID);
            $type = get_the_terms($service->ID, 'service-type');
            $group_key = $type[0]->name; // Usamos el nombre del término como clave del grupo
            if (!isset($grouped_services[$group_key])) {
                $grouped_services[$group_key] = [];
            }
            $grouped_services[$group_key][] = [
                'title' => $service_title,
                'link' => $service_link,
                'type' => $type->name
            ];

        }
    }
?>
<section class="f--pb-15 f--pb-tablets-10">
    <div class="f--container">
        <div class="f--row f--gap-a">
            <?php foreach ($grouped_services as $key => $typeName) { ?>
            <div class="f--col-4 f--col-tablets-6 f--col-mobile-12">
                <h2 class="f--font-g f--mb-3">
                    <a href="#" class="g--link-01 g--link-01--second"><?= $key ?></a>
                </h2>
                <div class="f--row f--gap-d">
                    <?php foreach ($typeName as $service) {?>
                        <div class="f--col-12">
                            <a href="<?= $service['link'] ?>" class="f--font-h u--font-light g--link-01 g--link-01--second"><?= $service['title'] ?></a>
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