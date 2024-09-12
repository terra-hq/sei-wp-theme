<div class="c--card-b <?php if ($modifierClass === 'second') echo 'c--card-b--second'; ?>">
    <div class="c--card-b__wrapper">
        <h4 class="c--card-b__wrapper__title"><?= $card_title ?></h4>
        <div class="c--card-b__wrapper__content c--content-a c--content-a--second-color c--content-a--second-text">
            <p><?= $card_description ?></p>
        </div>
        <a href="<?= $link ?>" class="c--card-b__wrapper__btn">
            <span>Learn More</span>
            <?php include(locate_template('img/btn-03-arrow.svg', false, false)); ?>
        </a>
    </div>

    <?php 
        $capability_lottie = get_field('capability_lottie', $post->ID);
        if ($show_lottie) : ?>
        <div class="c--card-b__media-wrapper">
            <div class="c--card-b__media-wrapper__media js--lottie-data" data-src="<?php echo $capability_lottie['url'] ?>" data-autoplay="true" data-loop="true" data-name="graphic"></div>
        </div>
    <?php endif; ?>
</div>