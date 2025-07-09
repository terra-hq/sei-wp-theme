<?php
/*
Template Name: Page Ares
*/
?>
<?php get_header(); ?>


<!-- stats block --> 

<div class="c--content-a u--pt-20 u--pb-20">
    <div class="f--row">
            <div class="f--col-4 f--col-tablets-6 f--col-mobile-12">
            <div class="c--card-d c--card-d--second ">
                <div class="c--card-d__wrapper">
                    <div class="c--card-d__wrapper__title">
                        20%
                    </div>
                    <div class="c--card-d__wrapper__subtitle">
                        Lorem ipsum dolor sit amet, elit  egas urna lectus eu adipiscing cras consequat nullam.
                    </div>
                </div>
            </div>
           
        </div>
          <div class="f--col-4">
            <div class="c--card-d c--card-d--second">
                <div class="c--card-d__wrapper">
                    <div class="c--card-d__wrapper__title">
                        20%
                    </div>
                    <div class="c--card-d__wrapper__subtitle">
                        Lorem ipsum dolor sit amet, elit  egas urna lectus eu adipiscing cras consequat nullam.
                    </div>
                </div>
            </div>
           
        </div>
         <div class="f--col-4">
            <div class="c--card-d c--card-d--second">
                <div class="c--card-d__wrapper">
                    <div class="c--card-d__wrapper__title">
                        20%
                    </div>
                    <div class="c--card-d__wrapper__subtitle">
                        Lorem ipsum dolor sit amet, elit  egas urna lectus eu adipiscing cras consequat nullam.
                    </div>
                </div>
            </div>
           
        </div>

    </div>
     <div class="f--row">
        <div class="f--col-12"> 
            <div class="c--pills-a">
                <a class="g--pill-01">Change Management</a>
                <a class="g--pill-01">Change Management</a>
                <a class="g--pill-01">Change Management</a>
                <a class="g--pill-01">Change Management</a>
            </div>
        </div>
    </div>
    <div class="c--icon-heading-a">

  <!--  <?php
            $image_tag_args = array(
                'image' => $item_icon,
                'sizes' => '48px',
                'class' => 'c--icon-heading-a__artwork',
                'isLazy' => false,
                'showAspectRatio' => true,
                'decodingAsync' => true,
                'fetchPriority' => false,
                'addFigcaption' => false,
            );
            generate_image_tag($image_tag_args)
        ?> -->
         <img class="c--icon-heading-a__artwork" width=83 height=32 src=<?= get_template_directory_uri() . "/img/logos/icon-problem.svg" ?> alt="SEI logo" class="c--brand-a__media" decoding="async">
        <h2 class="c--icon-heading-a__title">Problem</h2>
    </div>
</div>


<?php get_footer(); ?>