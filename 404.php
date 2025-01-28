<?php get_header() ?>
<section class="g--404-01">
    <div class="g--404-01__wrapper">
        <div class="g--404-01__wrapper__content">
            <h1 class="g--404-01__wrapper__content__item-primary"><?php echo get_field('page_title', 'option') ?></h1>
            <p class="g--404-01__wrapper__content__item-secondary"><?php echo get_field('page_subtitle', 'option') ?></p>
            <?php if(get_field('page_link', 'option')): ?>
                <div class="g--404-01__wrapper__content__list-group">
                    <a href="<?php echo get_field('page_link', 'option')['url'] ?>"  class="g--btn-03 g--btn-03--second">
                        <span><?php echo get_field('page_link', 'option')['title'] ?></span>
                        <?php include(locate_template('img/btn-03-arrow.svg', false, false)); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="g--404-01__media-wrapper">
        <div class="js--lottie-element g--404-01__media-wrappert__media" data-path="<?php echo get_field('page_lottie', 'option')['url'] ?>" data-animType="svg" data-loop="true" data-autoplay="true" data-name="graphic"></div>
    </div>
</section>
<?php get_footer() ?>