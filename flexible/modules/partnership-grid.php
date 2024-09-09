
<?php
    $spacing = get_spacing($module['section_spacing']);
    $partnerships = $module['partnerships'];

    $background_classes = [
        'g--card-03', // Light
        'g--card-03 g--card-03--second', // Medium
        'g--card-03 g--card-03--third', // Dark
        'g--card-03 g--card-03--second', // Medium
        'g--card-03 g--card-03--third', // Dark
        'g--card-03', // Light
        'g--card-03 g--card-03--third' // Dark
    ];
    $class_count = count($background_classes);
?>

<section class="<?= $spacing; ?>">
    <div class="f--container">
        <div class="f--row f--row--remove-gutter">
                <?php foreach ($partnerships as $index => $partnership) {
                    wp_reset_postdata();
                    $description = get_field('description', $partnership->ID);
                    $image = get_field('icon_white', $partnership->ID);
                    $background_class = $background_classes[$index % $class_count];
                    $link = get_permalink($partnership->ID);
                    if ($description && $image) {
                ?>
                <div class="f--col-4 f--col-tablets-6 f--col-mobile-12 u--display-flex">
                    <a href="<?= $link; ?>" rel="noopener noreferrer" class="<?= $background_class; ?>">
                        <div class="g--card-03__ft-items">
                            <p class="g--card-03__ft-items__item-primary"><?= $description; ?></p>
                            <div class="g--card-03__ft-items__list-group">
                                <span href="#" rel="noopener noreferrer" class="g--card-03__ft-items__list-group__item">Learn More +</span>
                            </div>
                            <figure class="g--card-03__ft-items__media-wrapper">
                                <?php
                                    $image_tag_args = array(
                                        'image' => $image,
                                        'sizes' => '580px',
                                        'class' => 'g--card-03__ft-items__media-wrapper__media',
                                        'isLazy' => true,
                                        'lazyClass' => 'g--lazy-01',
                                        'showAspectRatio' => true,
                                        'decodingAsync' => true,
                                        'fetchPriority' => false,
                                        'addFigcaption' => false,
                                    );
                                    generate_image_tag($image_tag_args)
                                ?>
                            </figure>
                        </div>
                    </a>
                </div>
            <?php 
                }
            }
            ?>
        </div>
    </div>
</section>