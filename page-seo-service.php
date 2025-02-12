<?php
/*
Template Name: Seo Service
*/
?>
<?php get_header(); ?>

<section class="f--section-a">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-12">
                Seo service hardcoded modules
            </div>
        </div>
    </div>
</section>
<!-- Modulo: FAQs Accordion - example on light background -->
<section class="f--pt-7 f--pt-tablets-4 f--pb-7 f--pb-tablets-4">
    <div class="f--container">
        <div class="f--row u--justify-content-center">
            <div class="f--col-8 f--col-tabletm-10 f--col-tablets-12">
                <div class="g--accordion-02 js--accordion-02">
                    <button class="g--accordion-02__hd" type="button" data-accordion02-control="simpleContent02-01" aria-expanded="false">
                        <span class="g--accordion-02__hd__item-primary">Lorem Ipsum?</span>
                        <span class="g--accordion-02__hd__icon" role="presentation">
                            <svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.51953 7.5H14.4795" stroke="#F01840" stroke-width="2" stroke-linecap="square"/>
                                <path d="M8 1.02002V13.98" stroke="#F01840" stroke-width="2" stroke-linecap="square"/>
                            </svg>
                        </span>
                    </button>
                    <div class="g--accordion-02__bd" data-accordion02-content="simpleContent02-01" aria-hidden="true">
                        <div class="g--accordion-02__bd__content">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sollicitudin pulvinar mattis nisl turpis turpis aliquam ultricies fringilla. Porttitor pulvinar turpis feugiat sed lobortis massa dolor. In sem neque facilisi accumsan pulvinar. In quis lectus iaculis est turpis euismod.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modulo: FAQs Accordion - example on dark background (g--accordion-02--second) -->
<section class="f--background-c f--pt-7 f--pt-tablets-4 f--pb-7 f--pb-tablets-4">
    <div class="f--container">
        <div class="f--row u--justify-content-center">
            <div class="f--col-8 f--col-tabletm-10 f--col-tablets-12">
                <div class="g--accordion-02 g--accordion-02--second js--accordion-02">
                    <button class="g--accordion-02__hd" type="button" data-accordion02-control="simpleContent02-02" aria-expanded="false">
                        <span class="g--accordion-02__hd__item-primary">Lorem Ipsum?</span>
                        <span class="g--accordion-02__hd__icon" role="presentation">
                            <svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.51953 7.5H14.4795" stroke="#F01840" stroke-width="2" stroke-linecap="square"/>
                                <path d="M8 1.02002V13.98" stroke="#F01840" stroke-width="2" stroke-linecap="square"/>
                            </svg>
                        </span>
                    </button>
                    <div class="g--accordion-02__bd" data-accordion02-content="simpleContent02-02" aria-hidden="true">
                        <div class="g--accordion-02__bd__content">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sollicitudin pulvinar mattis nisl turpis turpis aliquam ultricies fringilla. Porttitor pulvinar turpis feugiat sed lobortis massa dolor. In sem neque facilisi accumsan pulvinar. In quis lectus iaculis est turpis euismod.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modulo: Talk to Us - same classes and structure as hero-h -->
<section class="c--hero-h">
    <div class="c--hero-h__bg-items"></div>
    <div class="c--hero-h__wrapper">
        <div class="f--row f--gap-c">
            <div class="f--col-6 f--col-tabletm-12">
                <h1 class="c--hero-h__wrapper__title">
                    Talk to Us
                </h1>
                <p class="c--hero-h__wrapper__subtitle">
                    Interested in collaborating, or just want to learn more about SEI? Drop us a line! We'd love to hear from you.
                </p>
            </div>
            <div class="f--col-5 f--col-tabletl-6 f--col-tabletm-12 f--offset-1 f--offset-tabletl-0">
                <div class="c--form-d js--hubspot-script" data-form-id="<?php echo $hero_form_id ?>" data-portal-id="<?php echo $hero_form_portal ?>"></div>
            </div>
        </div>
    </div>
</section>


<?php get_footer(); ?>