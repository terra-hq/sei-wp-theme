<?php
$spacing = get_spacing($module['section_spacing']);
$slider_items = $module['slider_items'] ?? [];
?>

<section class="<?= htmlspecialchars($spacing, ENT_QUOTES); ?>">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-12">

                <?php if (!empty($slider_items)) : ?>
                    <p><strong>slider_items:</strong></p>

                    <?php foreach ($slider_items as $index => $item) : ?>
                        <div style="margin-left:20px;">

                            <p><strong>Item <?= $index + 1; ?>:</strong></p>

                            <p><strong>title:</strong> <?= htmlspecialchars($item['title'] ?? '', ENT_QUOTES); ?></p>

                            <p><strong>columns_left_label:</strong> <?= htmlspecialchars($item['columns_left_label'] ?? '', ENT_QUOTES); ?></p>
                            <p><strong>columns_left_content:</strong><br>
                                <?= nl2br(htmlspecialchars($item['columns_left_content'] ?? '', ENT_QUOTES)); ?>
                            </p>

                            <p><strong>columns_right_label:</strong> <?= htmlspecialchars($item['columns_right_label'] ?? '', ENT_QUOTES); ?></p>
                            <p><strong>columns_right_content:</strong><br>
                                <?= nl2br(htmlspecialchars($item['columns_right_content'] ?? '', ENT_QUOTES)); ?>
                            </p>

                            <p><strong>bottom_label:</strong> <?= htmlspecialchars($item['bottom_label'] ?? '', ENT_QUOTES); ?></p>
                            <?php if (!empty($item['image'])) : ?>
                                <p><strong>image:</strong></p>
                                <figure>
                                    <?php
                                   $image_tag_args = [
                                    'image' => $item['image'],
                                    'sizes' => 'small',
                                    'class' => '',
                                    'isLazy' => false,
                                    'lazyClass' => '',
                                    'showAspectRatio' => true,
                                    'decodingAsync' => true,
                                    'fetchPriority' => false,
                                    'addFigcaption' => false,
                                ];
                                generate_image_tag($image_tag_args);

                                    ?>
                                </figure>
                            <?php endif; ?>

                            <p><strong>button_label:</strong> <?= htmlspecialchars($item['button_label'] ?? '', ENT_QUOTES); ?></p>
                            <p><strong>data_form_id:</strong> <?= htmlspecialchars($item['data_form_id'] ?? '', ENT_QUOTES); ?></p>
                            <p><strong>data_portal_id:</strong> <?= htmlspecialchars($item['data_portal_id'] ?? '', ENT_QUOTES); ?></p>

                            <?php 
                            $bottom_cards = $item['bottom_cards'] ?? [];
                            if (!empty($bottom_cards)) : ?>
                                <p><strong>bottom_cards:</strong></p>

                                <?php foreach ($bottom_cards as $c_index => $card) : ?>
                                    <div style="margin-left:40px;">

                                        <p><strong>Card <?= $c_index + 1; ?>:</strong></p>

                                        <p><strong>card_title:</strong> <?= htmlspecialchars($card['card_title'] ?? '', ENT_QUOTES); ?></p>
                                        <p><strong>card_subtitle:</strong> <?= htmlspecialchars($card['card_subtitle'] ?? '', ENT_QUOTES); ?></p>

                                    </div>
                                <?php endforeach; ?>

                            <?php endif; ?>

                        </div>
                    <?php endforeach; ?>

                <?php endif; ?>

            </div>
        </div>
    </div>
</section>

<?php unset($spacing, $slider_items); ?>
