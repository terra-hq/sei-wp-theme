<?php
/*
Template Name: Awards
*/
?>
<?php get_header(); ?>

<section class="g--hero-04">
    <div class="g--hero-04__ft-items">
        <div class="g--hero-04__ft-items__wrapper">
            <div class="g--hero-04__ft-items__wrapper__content">
                <h1 class="g--hero-04__ft-items__wrapper__content__item-primary">
                <?php echo get_field('hero_title') ?>
                </h1>
                <div class="g--hero-04__ft-items__wrapper__content__list-group">
                    <p class="g--hero-04__ft-items__wrapper__content__list-group__item"><?php echo get_field('hero_subtitle') ?></p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class=" u--pb-15 u--pb-tablets-10">
    <div class="f--container">
        <div class="f--row">
            <?php
            $args = array(
                'post_type' => 'awards',
                'posts_per_page' => -1,
                'orderby' => 'date',
                'order' => 'DESC',
            );

            $awards_query = new WP_Query($args);

            if ($awards_query->have_posts()) {
                $awards_by_year = array();

                while ($awards_query->have_posts()) {
                    $awards_query->the_post();
                    $year = get_the_date('Y');
                    $awards_by_year[$year][] = get_post();
                }

                krsort($awards_by_year); // Ordena los años en orden descendente
                $years = array_keys($awards_by_year);

                $latest_years = array_slice($years, 0, 2); // Obtiene los dos últimos años

                foreach ($awards_by_year as $year => $awards) {
                    $is_active = in_array($year, $latest_years) ? 'c--accordion-b--is-active' : '';
                    if ($year >= 2021) {
                        ?>
                        <div class="f--col-12">
                            <div class="c--accordion-b js--accordion-b <?php echo $is_active; ?>">
                                <div class="c--accordion-b__hd">
                                    <h3 class="c--accordion-b__hd__title"><?php echo $year; ?></h3>
                                    <button class="c--accordion-b__hd__btn">
                                        <svg class="c--accordion-b__hd__btn__icon c--accordion-b__hd__btn__icon--second" xmlns="http://www.w3.org/2000/svg" width="16" height="15" viewBox="0 0 16 15" fill="none">
                                            <path d="M1.52344 7.5H14.4834" stroke="#F01840" stroke-width="2" stroke-linecap="square" />
                                            <path d="M8 1.01953V13.9795" stroke="#F01840" stroke-width="2" stroke-linecap="square" />
                                        </svg>
                                        <svg class="c--accordion-b__hd__btn__icon" xmlns="http://www.w3.org/2000/svg" width="16" height="3" viewBox="0 0 16 3" fill="none">
                                            <path d="M1.52344 1.5H14.4834" stroke="#F01840" stroke-width="2" stroke-linecap="square" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="c--accordion-b__bd">
                                    <?php foreach ($awards as $award) { ?>
                                        <div class="c--accordion-b__bd__item">
                                            <div class="g--card-06">
                                                <h3 class="g--card-06__item-primary"><?php echo get_field('text_1', $award->ID); ?></h3>
                                                <p class="g--card-06__item-secondary"><?php echo get_field('text_2', $award->ID); ?></p>
                                                <div class="g--card-06__list-group">
                                                    <p class="g--card-06__list-group__item"><?php echo get_field('text_3', $award->ID); ?></p>
                                                </div>
                                                <?php if (get_field('image', $award->ID)) : ?>
                                                    <figure class="g--card-06__media-wrapper">
                                                        <?php  $image_tag_args = array(
                                                            'image' => get_field('image', $award->ID),
                                                            'sizes' => 'small',
                                                            'class' => 'g--card-06__media-wrapper__media',
                                                            'isLazy' => true,
                                                            'lazyClass' => 'g--lazy-01',
                                                            'showAspectRatio' => true,
                                                            'decodingAsync' => true,
                                                            'fetchPriority' => false,
                                                            'addFigcaption' => false,
                                                        );
                                                        generate_image_tag($image_tag_args) ?>
                                                        
                                                    </figure>
                                                <?php else : ?>
                                                    <figure class="g--card-06__media-wrapper">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="89" height="28" viewBox="0 0 89 28" fill="none">
                                                            <path d="M9.06588 11.5167C9.15235 11.2505 9.52888 11.2505 9.61535 11.5167L11.3604 16.8875C11.3991 17.0066 11.51 17.0871 11.6352 17.0871H17.2824C17.5623 17.0871 17.6786 17.4452 17.4522 17.6097L12.8835 20.9291C12.7823 21.0027 12.7399 21.133 12.7786 21.2521L14.5237 26.6229C14.6101 26.8891 14.3055 27.1104 14.0791 26.9459L9.51041 23.6265C9.40916 23.553 9.27206 23.553 9.17082 23.6265L4.60211 26.9459C4.37571 27.1104 4.07109 26.8891 4.15757 26.6229L5.90266 21.2521C5.94133 21.133 5.89897 21.0027 5.79772 20.9291L1.22901 17.6097C1.00261 17.4452 1.11896 17.0871 1.39881 17.0871H7.04604C7.17119 17.0871 7.28211 17.0066 7.32078 16.8875L9.06588 11.5167Z" stroke="#F01840" stroke-width="1.08329" />
                                                            <path d="M44.3502 1.19961C44.4366 0.933463 44.8132 0.933464 44.8996 1.19961L47.8029 10.1349C47.8416 10.2539 47.9525 10.3345 48.0776 10.3345H57.4728C57.7526 10.3345 57.869 10.6926 57.6426 10.8571L50.0417 16.3794C49.9405 16.453 49.8981 16.5834 49.9368 16.7024L52.8401 25.6377C52.9265 25.9038 52.6219 26.1251 52.3955 25.9607L44.7947 20.4383C44.6935 20.3648 44.5564 20.3648 44.4551 20.4383L36.8543 25.9607C36.6279 26.1251 36.3233 25.9038 36.4098 25.6377L39.313 16.7024C39.3517 16.5834 39.3093 16.453 39.2081 16.3794L31.6072 10.8571C31.3809 10.6926 31.4972 10.3345 31.777 10.3345H41.1722C41.2973 10.3345 41.4082 10.2539 41.4469 10.1349L44.3502 1.19961Z" stroke="#F01840" stroke-width="1.08329" />
                                                            <path d="M79.6344 11.5167C79.7209 11.2505 80.0975 11.2505 80.1839 11.5167L81.929 16.8875C81.9677 17.0065 82.0786 17.0871 82.2038 17.0871H87.851C88.1308 17.0871 88.2472 17.4452 88.0208 17.6097L83.4521 20.9291C83.3508 21.0026 83.3085 21.133 83.3471 21.252L85.0922 26.6229C85.1787 26.889 84.8741 27.1103 84.6477 26.9458L80.079 23.6265C79.9777 23.5529 79.8406 23.5529 79.7394 23.6265L75.1707 26.9458C74.9443 27.1103 74.6397 26.889 74.7261 26.6229L76.4712 21.252C76.5099 21.133 76.4675 21.0026 76.3663 20.9291L71.7976 17.6097C71.5712 17.4452 71.6875 17.0871 71.9674 17.0871H77.6146C77.7398 17.0871 77.8507 17.0065 77.8894 16.8875L79.6344 11.5167Z" stroke="#F01840" stroke-width="1.08329" />
                                                        </svg>
                                                    </figure>

                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php
                            } else {

                                $archive_awards[] = $awards;
                            }
                        }


                        if (!empty($archive_awards)) {
                            ?>
                    <div class="f--col-12">
                        <div class="c--accordion-b js--accordion-b">
                            <div class="c--accordion-b__hd">
                                <h3 class="c--accordion-b__hd__title">2020 & Earlier</h3>
                                <button class="c--accordion-b__hd__btn">
                                    <svg class="c--accordion-b__hd__btn__icon c--accordion-b__hd__btn__icon--second" xmlns="http://www.w3.org/2000/svg" width="16" height="15" viewBox="0 0 16 15" fill="none">
                                        <path d="M1.52344 7.5H14.4834" stroke="#F01840" stroke-width="2" stroke-linecap="square" />
                                        <path d="M8 1.01953V13.9795" stroke="#F01840" stroke-width="2" stroke-linecap="square" />
                                    </svg>
                                    <svg class="c--accordion-b__hd__btn__icon" xmlns="http://www.w3.org/2000/svg" width="16" height="3" viewBox="0 0 16 3" fill="none">
                                        <path d="M1.52344 1.5H14.4834" stroke="#F01840" stroke-width="2" stroke-linecap="square" />
                                    </svg>
                                </button>
                            </div>
                            <div class="c--accordion-b__bd">
                                <?php foreach ($archive_awards as $year => $awards) {
                                            foreach ($awards as $award) { ?>
                                        <div class="c--accordion-b__bd__item">
                                            <div class="g--card-06">
                                                <h3 class="g--card-06__item-primary"><?php echo get_field('text_1', $award->ID); ?></h3>
                                                <p class="g--card-06__item-secondary"><?php echo get_field('text_2', $award->ID); ?></p>
                                                <div class="g--card-06__list-group">
                                                    <p class="g--card-06__list-group__item"><?php echo get_field('text_3', $award->ID); ?></p>
                                                </div>
                                                <?php if (get_field('image', $award->ID)) : ?>
                                                    <figure class="g--card-06__media-wrapper">
                                                    <?php  $image_tag_args = array(
                                                            'image' => get_field('image', $award->ID),
                                                            'sizes' => 'small',
                                                            'class' => 'g--card-06__media-wrapper__media',
                                                            'isLazy' => true,
                                                            'lazyClass' => 'g--lazy-01',
                                                            'showAspectRatio' => true,
                                                            'decodingAsync' => true,
                                                            'fetchPriority' => false,
                                                            'addFigcaption' => false,
                                                        );
                                                        generate_image_tag($image_tag_args) ?>
                                                    </figure>
                                                <?php else : ?>
                                                    <figure class="g--card-06__media-wrapper">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="89" height="28" viewBox="0 0 89 28" fill="none" >
                                                            <path d="M9.06588 11.5167C9.15235 11.2505 9.52888 11.2505 9.61535 11.5167L11.3604 16.8875C11.3991 17.0066 11.51 17.0871 11.6352 17.0871H17.2824C17.5623 17.0871 17.6786 17.4452 17.4522 17.6097L12.8835 20.9291C12.7823 21.0027 12.7399 21.133 12.7786 21.2521L14.5237 26.6229C14.6101 26.8891 14.3055 27.1104 14.0791 26.9459L9.51041 23.6265C9.40916 23.553 9.27206 23.553 9.17082 23.6265L4.60211 26.9459C4.37571 27.1104 4.07109 26.8891 4.15757 26.6229L5.90266 21.2521C5.94133 21.133 5.89897 21.0027 5.79772 20.9291L1.22901 17.6097C1.00261 17.4452 1.11896 17.0871 1.39881 17.0871H7.04604C7.17119 17.0871 7.28211 17.0066 7.32078 16.8875L9.06588 11.5167Z" stroke="#F01840" stroke-width="1.08329" />
                                                            <path d="M44.3502 1.19961C44.4366 0.933463 44.8132 0.933464 44.8996 1.19961L47.8029 10.1349C47.8416 10.2539 47.9525 10.3345 48.0776 10.3345H57.4728C57.7526 10.3345 57.869 10.6926 57.6426 10.8571L50.0417 16.3794C49.9405 16.453 49.8981 16.5834 49.9368 16.7024L52.8401 25.6377C52.9265 25.9038 52.6219 26.1251 52.3955 25.9607L44.7947 20.4383C44.6935 20.3648 44.5564 20.3648 44.4551 20.4383L36.8543 25.9607C36.6279 26.1251 36.3233 25.9038 36.4098 25.6377L39.313 16.7024C39.3517 16.5834 39.3093 16.453 39.2081 16.3794L31.6072 10.8571C31.3809 10.6926 31.4972 10.3345 31.777 10.3345H41.1722C41.2973 10.3345 41.4082 10.2539 41.4469 10.1349L44.3502 1.19961Z" stroke="#F01840" stroke-width="1.08329" />
                                                            <path d="M79.6344 11.5167C79.7209 11.2505 80.0975 11.2505 80.1839 11.5167L81.929 16.8875C81.9677 17.0065 82.0786 17.0871 82.2038 17.0871H87.851C88.1308 17.0871 88.2472 17.4452 88.0208 17.6097L83.4521 20.9291C83.3508 21.0026 83.3085 21.133 83.3471 21.252L85.0922 26.6229C85.1787 26.889 84.8741 27.1103 84.6477 26.9458L80.079 23.6265C79.9777 23.5529 79.8406 23.5529 79.7394 23.6265L75.1707 26.9458C74.9443 27.1103 74.6397 26.889 74.7261 26.6229L76.4712 21.252C76.5099 21.133 76.4675 21.0026 76.3663 20.9291L71.7976 17.6097C71.5712 17.4452 71.6875 17.0871 71.9674 17.0871H77.6146C77.7398 17.0871 77.8507 17.0065 77.8894 16.8875L79.6344 11.5167Z" stroke="#F01840" stroke-width="1.08329" />
                                                        </svg>
                                                    </figure>

                                                <?php endif; ?>
                                            </div>
                                        </div>
                                <?php }
                                        } ?>
                            </div>
                        </div>
                    </div>
            <?php
                }
                wp_reset_postdata();
            } else {
                echo '<p>No awards found.</p>';
            }
            ?>

        </div>
    </div>
</section>

<?php wp_reset_postdata(); ?>
<?php get_footer(); ?>