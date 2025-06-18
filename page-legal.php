<?php
/*
Template Name: Legal
*/
?>
<?php get_header(); ?>

<?php
    $title = get_the_title();
?>

<section class="u--pt-20 u--pt-tablets-10">

    <div class="f--container">
        <div class="f--row">
            <div class="f--col-9 f--col-tablets-12 u--pb-10 u--pb-tablets-7">
                <h1 class="f--sp-c f--font-c"><?= $title ?></h1>
                <p class="f--font-g u--font-light">Last updated: <?php echo get_the_modified_date('m/d/Y', $page_id) ?></p>
            </div>

            <div class="f--col-7 f--col-tabletl-10 f--col-tablets-12 u--pb-15 u--pb-tablets-10">
                <div class="c--content-a">
                    <?php the_content();?>

                </div>
            </div>
        </div>
    </div>

</section>

<?php wp_reset_postdata(); ?>
<?php get_footer(); ?>