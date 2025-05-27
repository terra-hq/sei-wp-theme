
<?php
    $spacing = get_spacing($module['section_spacing']);
    $bg_color = $module['bg_color'];
    $logos = $module['logos'];
?>

<section class="<?= $spacing ?> <?= $bg_color ?>">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-12">
                <div class="c--media-b <?php echo count($logos) > 5 && (count($logos) % 5 == 1 || count($logos) % 5 == 2 || count($logos) % 5 == 3) ? 'c--media-b--second' : ''; ?>">
                    <?php foreach ($logos as $logo) { ?>
                        <div class="c--media-b__item">
                            <?php if ($logo['link']): ?>
                                <a href="<?= $logo['link'] ? $logo['link']['url'] : '#'; ?>" 
                                   <?= get_target_link($logo['link']['target'], $logo['link']['title']) ?> 
                                   class="c--media-b__item__link">
                                    <?php
                                    if (!empty($logo['image'])) {
                                        $image_tag_args = array(
                                            'image' => $logo['image'],
                                            'sizes' => '580px',
                                            'class' => 'c--media-b__item__link__media',
                                            'isLazy' => true,
                                            'lazyClass' => 'g--lazy-01',
                                            'showAspectRatio' => true,
                                            'decodingAsync' => true,
                                            'fetchPriority' => false,
                                            'addFigcaption' => false,
                                        );
                                        generate_image_tag($image_tag_args);
                                    }
                                    ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php unset($spacing, $bg_color, $logos); ?>