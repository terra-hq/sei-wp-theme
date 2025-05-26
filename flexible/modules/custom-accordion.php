<?php
    $spacing = get_spacing($module['spacing']);
?>
<?php if($module['accordion_items']): ?>
<section class="<?= $spacing?>">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-12">
                <div class="c--accordion-a">
                <?php $first = true; ?>
                <?php foreach($module['accordion_items'] as $key => $accItem): 
                        $card_title = $accItem['accordion_title'];
                        $card_description = $accItem['accordion_content'];
                        $link =  $accItem['accordion_button'];
                        $image = $accItem['accordion_image']; ?>
                         <div class="c--accordion-a__item">
                            <input type="radio" name="select" class="c--accordion-a__item__btn" <?php echo $first ? 'checked' : ''; ?> />
                            <div class="c--accordion-a__item__hd">
                                <span class="c--accordion-a__item__hd__content"><?= $card_title ?></span>
                            </div>
                            <div class="c--accordion-a__item__wrapper">
                                <div class="c--accordion-a__item__wrapper__content">
                                    <div class="c--card-b">
                                        <div class="c--card-b__wrapper">
                                            <h4 class="c--card-b__wrapper__title"><?= $card_title ?></h4>
                                            <div class="c--card-b__wrapper__content c--content-a c--content-a--second-color c--content-a--second-text">
                                                <?= $card_description ?>
                                            </div>
                                            <?php if($link): ?>
                                                <a href="<?= $link['url'] ?>" <?= get_target_link($link['target'], $link['title']); ?> class="c--card-b__wrapper__btn">
                                                    <span><?= $link['title'] ?></span>
                                                    <?php include(locate_template('img/btn-03-arrow.svg', false, false)); ?>
                                                </a>
                                            <?php endif; ?>
                                        </div>

                                        <?php 
                                            if ($image) : ?>
                                            <div class="c--card-b__media-wrapper">
                                                <figure class="g--card-06__media-wrapper">
                                                <?php  $image_tag_args = array(
                                                    'image' => $image,
                                                    'sizes' => 'small',
                                                    'class' => 'c--card-b__media-wrapper__media',
                                                    'isLazy' => true,
                                                    'lazyClass' => 'g--lazy-01',
                                                    'showAspectRatio' => true,
                                                    'decodingAsync' => true,
                                                    'fetchPriority' => false,
                                                    'addFigcaption' => false,
                                                );
                                                generate_image_tag($image_tag_args) ?>
                                                
                                                </figure>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php  $first = false; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>