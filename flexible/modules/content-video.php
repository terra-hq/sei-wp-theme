<?php
// $bg_color = $module['background_color'];
$bg_color = $module['bg_color'];
$spacing = get_spacing($module['spacing']);
$legend = $module['pre-title'];
$title = $module['title'];
$content = $module['content'];
$button = $module['button'];
$media_type = $module['media_type'];
$video_type = $module['video_type'];
$video_url = $module['video_url'];
$video_file = $module['video_file'];
$poster_image = $module['poster_image'];
?>
<section class="c--layout-d <?= $bg_color == 'cream'  || $bg_color == 'white '?  'c--layout-d--second'  : ''?>  <?= $bg_color ?> <?= $spacing ?>">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-4 f--col-tabletm-6 f--col-mobile-12">
                <div class="c--layout-d__hd">
                    <?php if ($legend):?>
                        <p class="c--layout-d__hd__title"><?= $legend ?></p>
                     <?php endif; ?>
                    <?php if ($title):?>
                        <p class="c--layout-d__hd__subtitle"><?= $title ?></p>
                    <?php endif; ?>
                </div>
            </div>
             <div class="f--col-4 f--col-tabletm-6 f--col-mobile-12  u--pb-tabletm-4">
                 <button
                    type="button"
                    class="c--layout-d__wrapper"
                    data-modal-open="my-modal"
                    data-modal-video-type="<?= $video_type == 'file' ? 'file' : 'embed' ?>"
                    data-modal-video-url=<?= $video_type == 'file' ? $video_file :  $video_url ?>
                >
                   <img class="c--layout-d__wrapper__media" src="<?= $poster_image ?>" alt="Poster Image">
                    <svg class="c--layout-d__wrapper__artwork" xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 56 56" fill="none">
                        <rect width="56" height="56" rx="28" fill="#FFFFF8"/>
                        <path d="M18.6641 11.9941V44.6608L44.3307 28.3275L18.6641 11.9941Z" fill="#F01840"/>
                    </svg>
                </button>
             
            </div>
            <div class="f--col-4 f--col-tabletm-12 u--display-flex u--align-items-flex-end">
                 <div class="c--layout-d__ft">
                    <?php if ($content):?>
                        <div class="c--layout-d__ft__content"><?= $content ?></div>
                    <?php endif; ?>
                    <?php if ($button):?>
                        <a href="<?= $button['url'] ?>" <?= get_target_link($button['target'], $button['title']) ?> class="c--layout-d__ft__btn g--btn-01"><?= $button['title'] ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
