<?php 
    $spacing = get_spacing($module['section_spacing']);
    $bg_color = $module['bg_color'];
    if ($bg_color === 'f--background-c' || $bg_color === 'f--background-d') $modifierClass = 'g--card-34--second';
    $title = $module['title'];
    $description = $module['description'];
    $btn = $module['button'];

    $type = $module['type'];
    $first_image = $module['first_image'];
    $second_image = $module['second_image'];
    $second_image_text = $module['second_image_text'];
?>

<section class="<?= $spacing ?> <?= $bg_color ?>">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-12">
                <div class="g--card-34 <?= $modifierClass ?>">
                    <div class="g--card-34__wrapper">
                        <h2 class="g--card-34__wrapper__item-primary"><?= $title ?></h2>
                        <p class="g--card-34__wrapper__item-secondary"><?= $description ?></p>
                        <div class="g--card-34__wrapper__list-group">
                            <?php if($btn) { ?>
                                <a href="<?= $btn['url'] ?>" <?= get_target_link($btn['target'], $btn['title']) ?> rel="noopener noreferrer" class="g--card-34__wrapper__list-group__item">
                                    <?= $btn['title'] ?>
                                </a>
                            <?php }?>
                        </div>
                    </div>
                    <figure class="g--card-34__media-wrapper">
                        <?php 
                            $first_image_tag_args = array(
                                'image' => $first_image,
                                'sizes' => '(max-width: 810px) 50vw, 10vw ',
                                'class' => 'g--card-34__media-wrapper__media',
                                'isLazy' => true,
                                'lazyClass' => 'g--lazy-01',
                                'showAspectRatio' => true,
                                'decodingAsync' => true,
                                'fetchPriority' => false,
                                'addFigcaption' => false,
                            );
                            generate_image_tag($first_image_tag_args)
                        ?>

                        <?php if($type === 'image_text') { ?>
                            <!-- Second image -->
                            <div class="g--card-34__media-wrapper__wrapper">
                            <?php 
                                $second_image_tag_args = array(
                                    'image' => $second_image,
                                    'sizes' => '(max-width: 810px) 50vw, 10vw ',
                                    'class' => 'g--card-34__media-wrapper__wrapper__media',
                                    'isLazy' => true,
                                    'lazyClass' => 'g--lazy-01',
                                    'showAspectRatio' => true,
                                    'decodingAsync' => true,
                                    'fetchPriority' => false,
                                    'addFigcaption' => false,
                                );
                                generate_image_tag($second_image_tag_args)
                            ?>

                                <p class="g--card-34__media-wrapper__wrapper__title"><?= $second_image_text ?></p>
                            </div>
                            <!-- dark overlay -->
                            <div class="g--card-34__media-wrapper__overlay"></div>
                        <?php } ?>
                    </figure>
                </div>
            </div>
        </div>
    </div>
</section>