<?php 
$spacing = get_spacing($module['section_spacing']);
$bg_color = $module['bg_color'];
$modifierClass = '';
if ($bg_color === 'f--background-c' || $bg_color === 'f--background-d') {
    $modifierClass = 'g--card-34--second';
}
$should_be_a_slider = $module['should_be_a_slider'];

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
}else{
    $items = $module['slider']; 
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
                    <div class="c--slider-a__wrapper js--slider-a">
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
                        <?php include(locate_template('components/card/card-n.php', false, false)); ?>
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
