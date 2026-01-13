<?php 
$spacing = get_spacing($module['section_spacing']);
$bg_color = $module['bg_color'];
$modifierClass = '';
if ($bg_color === 'f--background-c' || $bg_color === 'f--background-d') {
    $modifierClass = 'g--card-34--second';
}
$title = $module['title'];
$description = $module['description'];
$btn = $module['button'];

$type = $module['type'];
$first_image = $module['first_image'];
$second_image = $module['second_image'];
$second_image_text = $module['second_image_text'];
$should_be_a_slider = $module['should_be_a_slider'];
$slider = $module['slider']
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
                            <?php if ($btn): ?>
                                <a href="<?= $btn['url'] ?>" <?= get_target_link($btn['target'], $btn['title']) ?> rel="noopener noreferrer" class="g--card-34__wrapper__list-group__item">
                                    <?= $btn['title'] ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <figure class="g--card-34__media-wrapper">
                        <?php 
                        if ($first_image) {
                            $first_image_tag_args = [
                                'image' => $first_image,
                                'sizes' => '(max-width: 810px) 50vw, 10vw',
                                'class' => 'g--card-34__media-wrapper__media',
                                'isLazy' => true,
                                'lazyClass' => 'g--lazy-01',
                                'showAspectRatio' => true,
                                'decodingAsync' => true,
                                'fetchPriority' => false,
                                'addFigcaption' => false,
                            ];
                            generate_image_tag($first_image_tag_args);
                        }
                        ?>

                        <?php if ($type === 'image_text' && $second_image): ?>
                            <div class="g--card-34__media-wrapper__wrapper">
                                <?php 
                                $second_image_tag_args = [
                                    'image' => $second_image,
                                    'sizes' => '(max-width: 810px) 50vw, 10vw',
                                    'class' => 'g--card-34__media-wrapper__wrapper__media',
                                    'isLazy' => true,
                                    'lazyClass' => 'g--lazy-01',
                                    'showAspectRatio' => true,
                                    'decodingAsync' => true,
                                    'fetchPriority' => false,
                                    'addFigcaption' => false,
                                ];
                                generate_image_tag($second_image_tag_args);
                                ?>
                                <p class="g--card-34__media-wrapper__wrapper__title"><?= $second_image_text ?></p>
                            </div>
                            <div class="g--card-34__media-wrapper__overlay"></div>
                        <?php endif; ?>
                    </figure>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
unset($spacing, $bg_color, $modifierClass, $title, $description, $btn, $type, $first_image, $second_image, $second_image_text); 
?>
