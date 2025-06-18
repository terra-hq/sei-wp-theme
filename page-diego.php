<?php
/*
Template Name: Ares
*/
?>
<?php get_header(); ?>


<!-- Divider - spacing must be dynamic -->
<section class="">
    <div class="f--container--fluid">
        <div class="f--row">
            <div class="f--col-12">
                <hr class="c--divider-a c--divider-a--third">
            </div>
        </div>
    </div>
</section>

<!-- Module: Heading left + Accordion right - spacing must be dynamic -->
<section class="">
    <div class="f--container">
        <div class="f--row f--gap-c">
            <div class="f--col-5 f--col-tabletl-6 f--col-tabletm-12">
                <div class="c--sticky-a">
                    <span class="f--font-i u--font-medium u--text-uppercase f--color-k">
                        lorem ipsum
                    </span>
                    <h2 class="f--font-c f--color-g u--mt-2">
                        Our Industries
                    </h2>
                    <p class="f--font-i u--mt-3">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis mollitia facere, iusto iste tempore debitis reiciendis hic doloribus, amet, harum ducimus rerum? Ex, quos! Commodi qui fuga eius obcaecati corrupti!
                    </p>
                </div>
            </div>
            <div class="f--col-6 f--col-tabletm-12 f--offset-1 f--offset-tabletl-0">
                <?php
                    // Nerea copie un poco la logica de flexible/modules/accordion.php, pero este aquí no nos sirve porque tiene su propia section
                    // te dejo hardcodeado las variables debajo, es lo que tendría que venir dinamico:
                    $modifier = 'g--accordion-02--third';
                    $module['accordion_items'] = [
                        [
                            'accordion_title' => 'Industry Name',
                            'accordion_title_copy' => '<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus, repellendus. Dolorum, consequatur.</p>'
                        ],
                        [
                            'accordion_title' => 'Industry Name',
                            'accordion_title_copy' => '<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus, repellendus. Dolorum, consequatur.</p>'
                        ],
                        [
                            'accordion_title' => 'Industry Name',
                            'accordion_title_copy' => '<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus, repellendus. Dolorum, consequatur.</p>'
                        ],
                    ];                
                ?>
                <?php foreach($module['accordion_items'] as $key => $accItem): ?>
                    <div class="g--accordion-02 <?php echo $modifier ?> js--accordion-02">
                        <button class="g--accordion-02__hd" type="button" data-accordion02-control="simpleContent02-0<?php echo $key?>" aria-expanded="false">                           
                            <div class="g--accordion-02__hd__item-primary">
                                <?php if ($modifier === 'g--accordion-02--third'): ?>
                                    <span class="f--color-c"><?= $key < 9 ? '0' : '' ?><?= $key + 1 ?>&nbsp;</span>
                                <?php endif; ?>
                                <span><?php echo $accItem['accordion_title']?></span>
                            </div>
                            <span class="g--accordion-02__hd__icon" role="presentation">
                                <svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.51953 7.5H14.4795" stroke="#F01840" stroke-width="2" stroke-linecap="square"/>
                                    <path d="M8 1.02002V13.98" stroke="#F01840" stroke-width="2" stroke-linecap="square"/>
                                </svg>
                            </span>
                        </button>
                        <div class="g--accordion-02__bd" data-accordion02-content="simpleContent02-0<?php echo $key?>" aria-hidden="true">
                            <div class="g--accordion-02__bd__content">
                                <?php echo $accItem['accordion_title_copy']?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>


<?php get_footer(); ?>