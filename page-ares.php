<?php
/*
Template Name: Ares
*/
?>
<?php get_header(); ?>

<section class="f--pt-20 f--pb-20 f--background-d  <?= $spacing ?>">
    <div class="f--container">
        <div class="f--row">
          
            <div class="c--marquee-a js--marquee f--col-12 " data-speed="1" data-controls-on-hover="false" data-reversed="false">
                <img width="83" height="32" src="<?= get_template_directory_uri() . "/img/logos/sei-logo.svg" ?>" alt="SEI logo" class="c--marquee-a__item c--marquee-a__item--initial" decoding="async">
                <img width="83" height="32" src="<?= get_template_directory_uri() . "/img/logos/sei-logo.svg" ?>" alt="SEI logo" class="c--marquee-a__item" decoding="async">
                <img width="83" height="32" src="<?= get_template_directory_uri() . "/img/logos/sei-logo.svg" ?>" alt="SEI logo" class="c--marquee-a__item" decoding="async">
                <img width="83" height="32" src="<?= get_template_directory_uri() . "/img/logos/sei-logo.svg" ?>" alt="SEI logo" class="c--marquee-a__item" decoding="async">
                <img width="83" height="32" src="<?= get_template_directory_uri() . "/img/logos/sei-logo.svg" ?>" alt="SEI logo" class="c--marquee-a__item" decoding="async">
                <img width="83" height="32" src="<?= get_template_directory_uri() . "/img/logos/sei-logo.svg" ?>" alt="SEI logo" class="c--marquee-a__item" decoding="async">
    
            </div>
        </div>
    </div>
</section>





<section class=" f--pt-20 f--pb-20 <?= $spacing ?>">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-12 u--display-flex u--justify-content-center">
            <a href="<?php echo get_field('page_link', 'option')['url'] ?>"  class="g--btn-03 g--btn-03--second">
                        <span><?php echo get_field('page_link', 'option')['title'] ?></span>
                        <?php include(locate_template('img/btn-03-arrow.svg', false, false)); ?>
                    </a>
            </div>
        </div>
    </div>
</section>


<?php get_footer(); ?>