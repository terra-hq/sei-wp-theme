<section class="c--layout-e">
    <div class="f--container">
        <div class="f--row f--gap-c u--justify-content-space-between">
            <div class="f--col-5 f--col-tabletm-10 f--col-mobile-12">
                <h2 class="c--layout-e__title">
                    Meet Your Advisory Experts
                </h2>
                <div class="c--layout-e__content">
                    <p>These are the senior consultants who will be in your corner—each specifically chosen for their expertise in solving challenges like yours. You're in exceptionally capable hands.</p>
                </div>
            </div>
            <div class="f--col-6 f--col-tabletm-10 f--col-mobile-12">
                <div class="f--row f--gap-c u--justify-content-flex-end">
                    <!-- 2 team members using card-c component, put the code of card-c contents here as example, card-c contents have not been modified -->

                    <div class="f--col-6 f--col-mobile-12">
                        <div class="c--card-c">
                            <div class="c--card-c__wrapper">
                                <div class="c--card-c__wrapper__media-wrapper">
                                    <?php
                                        // $image_tag_args = array(
                                        //     'image' => get_field('picture', $person->ID),
                                        //     'sizes' => 'medium',
                                        //     'class' => 'c--card-c__wrapper__media-wrapper__media',
                                        //     'isLazy' => true,
                                        //     'lazyClass' => 'g--lazy-01',
                                        //     'showAspectRatio' => false,
                                        //     'decodingAsync' => true,
                                        //     'fetchPriority' => false,
                                        //     'addFigcaption' => false,
                                        // );
                                        // if(get_field('picture', $person->ID)){
                                        //     generate_image_tag($image_tag_args);
                                        // }
                                    ?>
                                    <img class="c--card-c__wrapper__media-wrapper__media" src="http://placeholder.terrahq.com/headshot.webp">
                                </div>

                                <h3 class="c--card-c__wrapper__title">
                                    Antonio Mañueco
                                </h3>
                                <div class="c--card-c__wrapper__subtitle">
                                    Head of Technology & AI
                                </div>
                                <span class="g--pill-01">10+ years</span>
                            </div>
                        </div>
                    </div>

                    <div class="f--col-6 f--col-mobile-12">
                        <div class="c--card-c">
                            <div class="c--card-c__wrapper">
                                <div class="c--card-c__wrapper__media-wrapper">
                                    <?php
                                        // $image_tag_args = array(
                                        //     'image' => get_field('picture', $person->ID),
                                        //     'sizes' => 'medium',
                                        //     'class' => 'c--card-c__wrapper__media-wrapper__media',
                                        //     'isLazy' => true,
                                        //     'lazyClass' => 'g--lazy-01',
                                        //     'showAspectRatio' => false,
                                        //     'decodingAsync' => true,
                                        //     'fetchPriority' => false,
                                        //     'addFigcaption' => false,
                                        // );
                                        // if(get_field('picture', $person->ID)){
                                        //     generate_image_tag($image_tag_args);
                                        // }
                                    ?>
                                    <img class="c--card-c__wrapper__media-wrapper__media" src="http://placeholder.terrahq.com/headshot.webp">
                                </div>

                                <h3 class="c--card-c__wrapper__title">
                                    John Longo
                                </h3>
                                <div class="c--card-c__wrapper__subtitle">
                                    AI & Data Ecosystems Architect
                                </div>
                                <span class="g--pill-01">15+ years</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<?php unset($modifierText, $span_size, $modifier); ?>