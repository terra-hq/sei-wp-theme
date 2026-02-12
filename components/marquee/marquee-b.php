<?php
$marquee_click_destination = $module['marquee_click_destination'];
$scroll_to_form = $module['marquee_scroll_to_form'];
$marquee_text = $module['marquee_text'];
?>

    <div class="c--marquee-b">
        <?php if ($scroll_to_form): ?>
            <button tf-data-target="form-hero"
                    tf-data-distance="0"
                    class="c--marquee-b__list-group js--marquee-b js--scroll-to"
                    data-speed="1"
                    data-controls-on-hover="false"
                    data-reversed="false">
                <?php for ($i = 0; $i < 5; $i++) : ?>
                    <div class="c--marquee-b__list-group__list-item">
                        <figure>
                            <?php
                                $image_tag_args = array(
                                    'image' => array( 
                                        'url' => get_theme_file_uri('/public/assets/img/vector.webp'),
                                        'width'  => 116,
                                        'height' => 116,
                                        'sizes' => array(
                                            'thumbnail' => get_theme_file_uri('/public/assets/img/vector.webp'),
                                            'small' => get_theme_file_uri('/public/assets/img/vector.webp'),
                                            'medium' => get_theme_file_uri('/public/assets/img/vector.webp'),
                                            'large' => get_theme_file_uri('/public/assets/img/vector.webp'),
                                            'tablets' => get_theme_file_uri('/public/assets/img/vector.webp'),
                                            'mobile' => get_theme_file_uri('/public/assets/img/vector.webp'),
                                        )
                                    ),
                                    'sizes' => 'small',
                                    'class' => 'c--marquee-b__list-group__list-item__artwork',
                                    'isLazy' => true,
                                    'showAspectRatio' => true,
                                    'decodingAsync' => true,
                                    'fetchPriority' => false,
                                    'addFigcaption' => false,
                                );

                                generate_image_tag($image_tag_args);
                            ?>
                        </figure>
                        <?php foreach ($marquee_text as $item): ?>
                                <?php if ($item['italic']): ?>
                                    <p class="c--marquee-b__list-group__list-item__content"><?= $item['text']; ?></p>
                                <?php else: ?>
                                      <p class="c--marquee-b__list-group__list-item__content"> <?= $item['text']; ?> </p>
                                <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endfor; ?>
            </button>
        <?php elseif ($marquee_click_destination): ?>
            <a href="<?= esc_url($marquee_click_destination); ?>"
               target="_blank"
               class="c--marquee-b__list-group js--marquee-b"
               data-speed="1"
               data-controls-on-hover="false"
               data-reversed="0">
                <?php for ($i = 0; $i < 5; $i++) : ?>
                    <div class="c--marquee-b__list-group__list-item">
                        <figure>
                            <?php
                                $image_tag_args = array(
                                    'image' => array( 
                                        'url' => get_theme_file_uri('/public/assets/img/vector.webp'),
                                        'width'  => 116,
                                        'height' => 116,
                                        'sizes' => array(
                                            'thumbnail' => get_theme_file_uri('/public/assets/img/vector.webp'),
                                            'small' => get_theme_file_uri('/public/assets/img/vector.webp'),
                                            'medium' => get_theme_file_uri('/public/assets/img/vector.webp'),
                                            'large' => get_theme_file_uri('/public/assets/img/vector.webp'),
                                            'tablets' => get_theme_file_uri('/public/assets/img/vector.webp'),
                                            'mobile' => get_theme_file_uri('/public/assets/img/vector.webp'),
                                        )
                                    ),
                                    'sizes' => 'small',
                                    'class' => 'c--marquee-b__media',
                                    'isLazy' => true,
                                    'showAspectRatio' => true,
                                    'decodingAsync' => true,
                                    'fetchPriority' => false,
                                    'addFigcaption' => false,
                                );

                                generate_image_tag($image_tag_args);
                            ?>
                        </figure>
                        <?php foreach ($marquee_text as $item): ?>
                            <p>
                                <?php if ($item['italic']): ?>
                                    <span class="c--marquee-b__ft"><?= $item['text']; ?></span>
                                <?php else: ?>
                                    <?= $item['text']; ?>
                                <?php endif; ?>
                            </p>
                        <?php endforeach; ?>
                    </div>
                <?php endfor; ?>
            </a>
        <?php endif; ?>
    </div>

    <?php unset($marquee_click_destination, $scroll_to_form, $marquee_text);
?>
