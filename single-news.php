<?php get_header() ?>

<section class="f--pt-15 f--pt-tablets-10 f--pb-15 f--pb-tablets-10">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-12">
                <a href="<?php echo esc_url(home_url('/about/newsroom/')) ?>" class="c--back-link-a f--mb-10">Back to
                    All
                    News</a>
                <p class="f--font-i f--color-c u--text-uppercase u--letter-spacing-a u--font-medium f--mb-3">News</p>
            </div>
        </div>
        <div class="f--row u--justify-content-space-between f--gap-a">
            <div class="f--col-7 f--col-tablets-12">
                <h1 class="f--font-c f--sp-c"><?php the_title() ?></h1>
                <p class="f--font-h"><span
                        class="u--opacity-6"><?php echo get_the_date('M j, Y', get_the_ID()) ?></span>
                </p>
                <article class="f--pt-8 f--pt-tablets-5 f--pb-4">
                    <div class="c--content-a">
                        <?php the_content() ?>
                    </div>
                </article>
                <div class="c--border-a f--pt-4 u--display-flex u--align-items-center">
                    <p class="f--font-i f--color-c f--mr-1">Share on</p>
                    <?php include(locate_template('components/social/social-a--second.php', false, false)); ?>
                </div>
            </div>
            <div class="f--col-4 f--col-tabletl-5 f--col-tablets-12">
                <?php if (get_field('subscribe_form_id', 'option') && get_field('subscribe_form_portal', 'option')): ?>
                    <div class="c--form-b">
                        <h2 class="c--form-b__title"><?php echo get_field('subscribe_form_title', 'option') ?></h2>
                        <div class="js--hubspot-script"
                            data-form-id="<?php echo get_field('subscribe_form_id', 'option') ?>"
                            data-portal-id="<?php echo get_field('subscribe_form_portal', 'option') ?>"></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php get_footer() ?>