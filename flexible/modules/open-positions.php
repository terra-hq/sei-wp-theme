<!-- Alejo, este componente es igual que insights pero con subtitle extra y usando en el bucle la card-f -->
<?php
    $spacing = get_spacing($module['section_spacing']);
    $bgColor = $module['bg_color'];
    $title = $module['title'];
    $subtitle = $module['subtitle'];
    $btn = $module['button'];
    $greenhouse_id = $module['greenhouse_id'];
?>


<section class="<?= $bgColor ?> <?= $spacing ?>">
    <div class="f--container">
        <div class="f--row u--justify-content-space-between">
            <div class="f--col-5 f--col-tabletm-12 f--mb-tabletm-7">
                <h2 class="f--font-c">
                    <?php
                        if ($title) {
                            foreach ($title as $e) {
                                $text = $e['text'];
                                $italic = $e['italic'];
                                if ($italic) {
                                    echo '<span class="f--font-d">' . $text . '</span>';
                                } else {
                                    echo $text . ' ';
                                }
                            }
                        }
                    ?>
                </h2>
                <p class="f--mt-3 f--mb-5 f--font-h u--font-light">
                    <?= $subtitle ?>
                </p>
                <a href="<?= $btn['url'] ?>" <?= get_target_link($btn['target'], $btn['title'] )?> class="g--btn-03 g--btn-03--second">
                    <span class="g--btn-03__content">
                        <?= $btn['title'] ?>
                    </span>
                    <?php include(locate_template('img/btn-03-arrow.svg', false, false)); ?>
                </a>
            </div>
            <div class="f--col-6 f--col-tabletm-12">
                <div class="c--wrapper-a c--wrapper-a--second js--load-jobs" data-location-id="<?php echo $greenhouse_id ?>">
                    <div class="g--message-01">
                        <div class="g--spinner-01 g--message-01__artwork">
                            <svg viewBox="0 0 26 26" fill="none">
                                <path d="M23.446 9.625c1.063-.344 1.66-1.494 1.155-2.49a13 13 0 1 0-1.085 13.507c.657-.903.251-2.134-.743-2.642-.994-.51-2.198-.095-2.916.76a8.954 8.954 0 1 1 .831-10.352c.573.96 1.695 1.56 2.758 1.217Z" fill="#7F7ED0"></path>
                            </svg>
                        </div>
                        <p class="g--message-01__item-primary">Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php unset($spacing, $bgColor, $title, $subtitle, $btn, $greenhouse_id); ?>