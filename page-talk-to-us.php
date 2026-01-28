<?php
/*
Template Name: Talk To Us
*/
?>
<?php get_header(); ?>


<?php
$hero_title = get_field('hero_title');
$hero_subtitle = get_field('hero_subtitle');
$hero_form_id = get_field('hero_form_id');
$hero_form_portal = get_field('hero_form_portal');
include (locate_template('components/hero/hero-h.php', false, false));
?>

<?php $args = array(
        'post_type' => 'location',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
    );
    $locations_query = new WP_Query($args);
    if ($locations_query->have_posts()) :
    $title = get_field('title', $post->ID);
    $description = get_field('description', $post->ID);
?>
<!--layout-b-->
<section class="c--layout-b u--pt-15">
    <div class="f--container">
        <div class="f--row f--gap-c u--justify-content-space-between">
            <div class="f--col-6 f--col-tabletm-10 f--col-mobile-12">
                <h2 class="c--layout-b__title">
                    <?= $title ?>
                </h2>
            </div>
            <div class="f--col-5 f--col-tabletm-10 f--col-mobile-12">
                <div class="c--layout-b__content">
                    <?= $description ?>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="f--background-a  u--mb-20">
    <div class="f--container">
        <div class="f--row">

            <div class="f--col-12 u--mt-10 u--mt-tablets-8">
                <div class="c--wrapper-b c--wrapper-b--second">
                    <?php while ($locations_query->have_posts()) : $locations_query->the_post(); ?>
                    <?php
                        $post_id = get_the_ID();
                        $title = get_the_title();
                        $extras = get_field('extras', $post_id);
                        $adress_line_1 = $extras['adress_line_1'];
                        $adress_line_2 = $extras['adress_line_2'];
                        $adress_line_3 = $extras['adress_line_3'];
                        $phone = $extras['phone'];
                        $fax = $extras['fax'];

                        include (locate_template('components/card/card-k.php', false, false));
                    ?>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php endif; ?>
<?php get_footer(); ?>