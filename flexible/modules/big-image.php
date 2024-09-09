<?php
    $spacing = get_spacing($module['section_spacing']);
    $bg_color = $module['bg_color'];
    $image = $module['image'];
?>

<section class="<?= $spacing ?> <?= $bg_color ?>">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-12">
                <div class="c--media-a">
                    <?php
                        $image_tag_args = array(
                            'image' => $image,
                            'sizes' => '100vw',
                            'class' => 'c--media-a__media',
                            'isLazy' => true,
                            'lazyClass' => 'g--lazy-01',
                            'showAspectRatio' => true,
                            'decodingAsync' => true,
                            'fetchPriority' => false,
                            'addFigcaption' => false,
                        );
                        if($image){
                            generate_image_tag($image_tag_args);
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>