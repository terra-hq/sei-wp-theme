<section class="c--header-a">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-12">
                <div class="c--header-a__wrapper">
                    <a href="<?php echo home_url(); ?>" class="c--header-a__wrapper__brand">
                        <img src="<?php echo get_field('nav_logo', 'option')['url'] ?>" sizes="(max-width: 810px) 95vw, 33vw" alt="header logo" class="c--header-a__wrapper__brand__logo">
                    </a>
                    <nav class="c--header-a__wrapper__list-group">
                        <!-- poner u--display-tabletm-none en las que no salen en mobile -->

                        <?php
                        $nav_items = get_field('nav_items', 'option');
                        if ($nav_items) :
                            foreach ($nav_items as $key => $nav_item) :
                                $class = 'c--header-a__wrapper__list-group__list-item';
                                if (!$nav_item['show_mobile']) {
                                    $class .= ' u--display-tabletm-none';
                                }
                                ?>
                                <?php if ($nav_item['is_anchor']) { ?>
                                    <button class="<?php echo $class; ?> js--scroll-to" tf-data-distance="20" tf-data-target="<?php echo $nav_item['where'] ?>">
                                        <?php echo $nav_item['nav_link']['title']; ?>
                                    </button>
                                <?php } else { ?>
                                    <a href="<?php echo $nav_item['nav_link']['url']; ?>" class="<?php echo $class; ?>">
                                        <?php echo $nav_item['nav_link']['title']; ?>
                                    </a>
                                <?php } ?>
                        <?php endforeach;
                        endif;
                        ?>
                        <?php if (get_field('nav_button', 'option')) : ?>
                            <a href="<?php echo get_field('nav_button', 'option')['url'] ?>" class="c--header-a__wrapper__list-group__btn">
                                <span class="c--header-a__wrapper__list-group__btn__content"><?php echo get_field('nav_button', 'option')['title'] ?></span>
                                <svg class="c--header-a__wrapper__list-group__btn__icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20.9 23.54C10.15 22.89 1.57004 14.31 0.920044 3.58996C0.920044 1.84996 2.31004 0.459961 4.02004 0.459961H9.22004C9.42004 0.459961 9.61004 0.579961 9.68004 0.769961L12.28 7.25996C12.37 7.48996 12.28 7.74996 12.07 7.86996L9.22004 9.57996C10.5 11.97 12.48 13.95 14.87 15.23L16.58 12.39C16.71 12.18 16.97 12.09 17.19 12.18L23.68 14.78C23.87 14.86 23.99 15.04 23.99 15.24V20.43C23.99 22.14 22.6 23.53 20.89 23.53L20.9 23.54ZM4.02004 1.45996C2.86004 1.45996 1.92004 2.39996 1.92004 3.55996C2.54004 13.75 10.71 21.92 20.93 22.54C22.06 22.54 23 21.6 23 20.44V15.58L17.22 13.27L15.49 16.15C15.36 16.37 15.07 16.46 14.84 16.34C11.94 14.91 9.55004 12.52 8.12004 9.61996C8.00004 9.38996 8.09004 9.09996 8.31004 8.96996L11.19 7.23996L8.87004 1.45996H4.02004Z" fill="#1E4687" />
                                </svg>
                            </a>
                        <?php endif; ?>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>