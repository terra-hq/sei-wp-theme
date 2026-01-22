<footer class="c--footer-a">
    <div class="f--container">
        <div class="c--footer-a__hd">
            <div class="f--row">
                <div class="f--col-7 f--col-tabletl-8 f--col-tabletm-12">
                    <?php $title = '';
                    $footer_titles = get_field('footer_title', 'option');
                    if ($footer_titles) {
                        foreach ($footer_titles as $footer_title) {
                            $sentence = $footer_title['sentence'];
                            $italic = $footer_title['italic'];
                            if ($italic) {
                                $title .= '<span class="f--font-b">' . esc_html($sentence) . '</span> ';
                            } else {
                                $title .= esc_html($sentence) . ' ';
                            }
                        }
                    }
                    if ($title && get_field('footer_link', 'option')) : ?>
                        <a href="<?php echo esc_url(get_field('footer_link', 'option')); ?>" class="c--footer-a__hd__link"><?php echo $title; ?></a>
                    <?php endif; ?>
                </div>
                <div class="f--col-5 f--col-tabletl-4 f--col-tabletm-12">
                    <?php $socialbTitle = get_field('ask_ai_about_sei','option') ?>
                    <?php $socialbLinks = get_field('ai_links','option') ?>
                    <?php include(locate_template('components/social/social-b.php', false, false)); ?>
                </div>
            </div>
        </div>
        <div class="c--footer-a__bd">
            <div class="f--row f--gap-a u--justify-content-space-between">
                <div class="f--col-7 f--col-tabletl-6 f--col-tabletm-8 f--col-tabletm-12">
                    <div class="c--footer-a__bd__item c--form-a js--hubspot-script--footer" data-form-id=<?php echo get_field('form_id', 'option') ?> data-portal-id=<?php echo get_field('form_portal_id', 'option') ?>>
                    </div>
                </div>
                <?php $navigation_links = get_field('navigation_links', 'option');
                if ($navigation_links) : ?>
                    <div class="f--col-5 f--col-tabletm-12">
                        <nav class="c--nav-c">
                            <?php foreach ($navigation_links as $navEach) : ?>
                                <a href="<?php echo $navEach['link']['url'] ?>" <?= get_target_link($navEach['link']['target'], $navEach['link']['title'] )?> class="c--nav-c__item"><?php echo $navEach['link']['title'] ?></a>
                            <?php endforeach; ?>
                        </nav>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="c--footer-a__ft">
            <div class="c--footer-a__ft__wrapper">
                <div class="f--row f--gap-c">
                    <div class="f--col-9 f--col-tabletl-8 f--col-tabletm-12">
                        <?php $extra_links = get_field('extra_links', 'option');
                        if ($extra_links) : ?>
                            <nav class="c--footer-a__ft__wrapper__list-group c--nav-d">
                                <?php foreach ($extra_links as $eachExtra) : ?>
                                    <a href="<?php echo $eachExtra['link']['url'] ?>" <?= get_target_link($eachExtra['link']['target'], $eachExtra['link']['title'] )?> class="c--nav-d__item"><?php echo $eachExtra['link']['title'] ?></a>
                                <?php endforeach; ?>
                            </nav>
                        <?php endif; ?>
                        <p class="f--font-j f--color-a">Copyright © <?php echo date('Y') ?> <?php echo get_field('copyright', 'option') ?></p>
                    </div>
                    <div class="f--col-3 f--col-tabletl-4 f--col-tabletm-12">
                        <?php $socialCustomClass = 'c--footer-a__ft__wrapper__item-right' ?>
                        <?php include(locate_template('components/social/social-a.php', false, false)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>