<div class="c--social-b <?= $socialCustomClass ?>">
    <h3 class="c--social-b__title"><?= $socialbTitle ?></h3>
    <div class="c--social-b__bd">
        <?php foreach ($socialbLinks as $key => $singleAI) { ?>
            <?php 
                $ia_image_url = $singleAI['link'];
                $ia_host = parse_url($ia_image_url, PHP_URL_HOST);     
                $ia_name = preg_replace('/\..*/', '', $ia_host);  
            ?>
            
                <a href="<?= $ia_image_url  ?>" target="_blank" rel="noopener noreferrer" class="c--social-b__bd__link" aria-label="<?= $ia_name ?>">
                    <?php if($singleAI['image']) : ?>
                    <?php  $image_tag_args = array(
                        'image' => $singleAI['image'],
                        'sizes' => 'small',
                        'class' => 'c--social-b__bd__link__artwork',
                        'isLazy' => true,
                        'lazyClass' => 'g--lazy-01',
                        'showAspectRatio' => true,
                        'decodingAsync' => true,
                        'fetchPriority' => false,
                        'addFigcaption' => false,
                    );
                    generate_image_tag($image_tag_args) ; endif;  ?>
                </a>
        <?php } ?>
    </div>
</div>