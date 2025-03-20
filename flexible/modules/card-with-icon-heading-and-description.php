<?php 
    $spacing = get_spacing($module['section_spacing']);
    $bg_color = $module['bg_color'];
    if ($bg_color === 'f--background-c' || $bg_color === 'f--background-d') $modifier = 'g--card-04--second';
    $cards = $module['cards'];
?>

<section class="<?= $spacing ?> <?= $bg_color ?>">
    <div class="f--container">
        <div class="f--row f--gap-b">
            <?php foreach ($cards as $card) { ?>
                <div class="f--col-3 f--col-tabletm-6">
                    <div class="g--card-04 <?= $modifier ?>">
                        <h3 class="g--card-04__item-primary"><?= $card['title'] ?></h3>
                        <div class="g--card-04__list-group">
                            <div class="c--content-a g--card-04__list-group__item"><?= apply_filters('the_content', $card['description']) ?></div>
                        </div>
                        <figure class="g--card-04__media-wrapper">
                            <?php
                                $image_tag_args = array(
                                    'image' => $card['image'],
                                    'sizes' => '580px',
                                    'class' => 'g--card-04__media-wrapper__media',
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
                </div>
            <?php } ?>
        </div>
    </div>
</section>
