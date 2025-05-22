<!-- Todos los campos de la card pueden ser custom -->

<a href="<?php echo $permalink ?>" <?php echo $target ?> class="g--card-05">
    <div class="g--card-05__ft-items">
        <h3 class="g--card-05__ft-items__item-primary">This is the title lorem ipsum dolor sit amet consecteur elit fermentum posuere.</h3>
        <div class="g--card-05__ft-items__item-secondary c--content-a">
            <p>This is a short description lorem ipsum dolor sit amet consecteur elit fermentum posuere. Lorem ipsum dolor sit amet consecteur elit fermentum posuere.</p>
            <ul>
                <li>Bullet point text here</li>
                <li>Bullet point text here</li>
                <li>Bullet point text here</li>
            </ul>
        </div>
        <div class="g--card-05__ft-items__list-group">
            <p class="g--card-05__ft-items__list-group__item">Free Discovery</p>
        </div>
        <figure class="g--card-05__ft-items__media-wrapper">
            <?php
                $image_tag_args = array(
                    'image' => $image,
                    'sizes' => '180px',
                    'class' => 'g--card-05__media-wrapper__media',
                    'isLazy' => false,
                    'lazyClass' => 'g--lazy-01',
                    'showAspectRatio' => true,
                    'decodingAsync' => true,
                    'fetchPriority' => false,
                    'addFigcaption' => false,
                );
                generate_image_tag($image_tag_args)
            ?>
        </figure>
    </div>
</a>