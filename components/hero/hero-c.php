<?php
    $title = $hero['title'];
    $subtitle = $hero['subtitle'];
    $description = $hero['description'];
    $bg_color = isset($hero['bg_color']) ? $hero['bg_color'] : 'f--background-f';

    $current_post_id = get_the_ID();
    $parent_id = wp_get_post_parent_id($current_post_id);
    $parent_permalink = get_permalink($parent_id);
    $parent_title = get_the_title($parent_id);
    $current_title = get_the_title($current_post_id);

    if($bg_color == 'f--background-f'){
        $backgrounds = [
            '/assets/frontend/background/hero-c-bg-01.webp',
            '/assets/frontend/background/hero-c-bg-02.webp',
            '/assets/frontend/background/hero-c-bg-03.webp',
            '/assets/frontend/background/hero-c-bg-04.webp'
        ];
        $random_background = $backgrounds[array_rand($backgrounds)];
    } else {
        $random_background = '/assets/frontend/background/hero-c-bg-purple.webp';
    };
?>

<?php if(!$description){
    $customClass = 'c--hero-c--second';
} ?>
<section class="c--hero-c <?php echo $customClass ?>" style="background-image:url('<?php bloginfo('template_url'); echo $random_background; ?>')">
    <div class="f--container">
        <?php if ($current_title !== $parent_title && $description) : ?>
            <div class="f--row">
                <div class="f--col-12">
                    <nav class="c--hero-c__hd c--breadcrumbs-a c--breadcrumbs-a--second">
                        <a href="<?= $parent_permalink ?>" class="c--breadcrumbs-a__item"><?= $parent_title ?></a>
                        <p class="c--breadcrumbs-a__item"><?= $current_title ?></p>
                    </nav>
                </div>
            </div>
        <?php endif; ?>
        <div class="f--row u--align-items-flex-end u--justify-content-space-between">
            <div class="<?php echo ($customClass == 'c--hero-c--second') ? 'f--col-7 f--col-tabletl-10 f--col-mobile-12' : 'f--col-5 f--col-tabletl-10 f--col-mobile-12' ?>">
                <h1 class="c--hero-c__title">
                    <?php
                        if ($title) {
                            foreach ($title as $e) {
                                $text = $e['text'];
                                $italic = $e['italic'];
                                if ($italic) {
                                    echo '<span class="c--hero-c__title__artwork">' . $text . '</span>';
                                } else {
                                    echo $text . ' ';
                                }
                            }
                        }
                    ?>
                </h1>
            </div>
            <?php if($description): ?>
                <div class="f--col-6 f--col-tabletl-10 f--col-mobile-12">
                    <?php if($subtitle): ?>
                        <h2 class="c--hero-c__subtitle"><?= $subtitle ?></h2>
                    <?php endif; ?>
                    <div class="c--hero-c__content c--content-a c--content-a--second-color c--content-a--third-text">
                        <p><?= $description ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>