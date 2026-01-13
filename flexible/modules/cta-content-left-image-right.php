<?php 
$spacing = get_spacing($module['section_spacing']);
$bg_color = $module['bg_color'];
$modifierClass = '';
if ($bg_color === 'f--background-c' || $bg_color === 'f--background-d') {
    $modifierClass = 'g--card-34--second';
}
$should_be_a_slider = $module['should_be_a_slider'];
$items = $module['slider']; 
if (!$should_be_a_slider) {
    $items[] = [
        'title' => $module['title'],
        'description' => $module['description'],
        'button' => $module['button'],
        'type' => $module['type'],
        'first_image' => $module['first_image'],
        'second_image' => $module['second_image'],
        'second_image_text' => $module['second_image_text']
    ];
}
?>

<?php if ($should_be_a_slider): ?>
    <section class="c--slider-a">
        <div class="<?= $spacing ?> <?= $bg_color ?>">
<?php else: ?>
    <section class="<?= $spacing ?> <?= $bg_color ?>">
<?php endif; ?>
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-12">
                <?php if ($should_be_a_slider): ?>
                    <div class="c--slider-a__wrapper js--slider-e">
                <?php endif; ?>
                <?php 
                foreach ($items as $item): 
                    $title = $item['title'];
                    $description = $item['description'];
                    $btn = $item['button'];
                    $type = isset($item['type']) ? $item['type'] : '';
                    $first_image = $item['first_image'];
                    $second_image = isset($item['second_image']) ? $item['second_image'] : null;
                    $second_image_text = isset($item['second_image_text']) ? $item['second_image_text'] : '';
                ?>
                    <div class="c--slider-a__wrapper__item">
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
                <?php endforeach; ?>
                <?php if ($should_be_a_slider): ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php if ($should_be_a_slider): ?>
        </div>
    </section>
<?php else: ?>
    </section>
<?php endif; ?>

<?php 
unset($spacing, $bg_color, $modifierClass, $items, $should_be_a_slider);
?>
