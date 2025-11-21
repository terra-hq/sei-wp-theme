<?php
$spacing = get_spacing($module['section_spacing']);
$left_label_accordion = $module['left_label_accordion'] ?? '';
$right_label_accordion = $module['right_label_accordion'] ?? '';
$accordion_items = $module['accordion_items'] ?? [];
$heading = $module['heading'] ?? '';
$text = $module['text'] ?? '';
?>

<section class="<?= $spacing ?>">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-12">

                <?php if ($heading): ?>
                    <h2><?= $heading ?></h2>
                <?php endif; ?>

                <?php if ($text): ?>
                    <p><strong>Text:</strong> <?= $text ?></p>
                <?php endif; ?>

                <?php if (!empty($accordion_items)): ?>
                    <?php foreach ($accordion_items as $index => $item): ?>
                        <?php if (!empty($item['title'])): ?>
                            <h3><?= $item['title'] ?></h3>
                        <?php endif; ?>

                        <div>
                            <?php if ($left_label_accordion): ?>
                                <p><strong><?= $left_label_accordion ?></strong></p>
                            <?php endif; ?>
                            <?php if (!empty($item['left_content'])): ?>
                                <p><?= $item['left_content'] ?></p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <?php if ($right_label_accordion): ?>
                                <p><strong><?= $right_label_accordion ?></strong></p>
                            <?php endif; ?>
                            <?php if (!empty($item['right_content'])): ?>
                                <p><?= $item['right_content'] ?></p>
                            <?php endif; ?>
                        </div>

                        <hr>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>

<?php unset($spacing, $left_label_accordion, $right_label_accordion, $accordion_items, $heading, $text); ?>
