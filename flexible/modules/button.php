
<section class=" <?= $spacing ?>">
    <div class="f--container">
        <div class="f--row">
            <!-- Holii si el botón esta centreado al centro tiene que tener la clase u--justify-content-center, en la derecha   u--justify-content-flex-end y en la izquierda u--justify-content-start -->
            <div class="f--col-12 u--display-flex u--justify-content-center">
            <a href="<?php echo get_field('page_link', 'option')['url'] ?>"  class="g--btn-03 g--btn-03--second">
                        <span><?php echo get_field('page_link', 'option')['title'] ?></span>
                        <?php include(locate_template('img/btn-03-arrow.svg', false, false)); ?>
                    </a>
            </div>
        </div>
    </div>
</section>