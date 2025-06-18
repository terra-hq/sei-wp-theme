<?php
    $spacing = get_spacing($module['spacing']);
    $heading = $module['heading'];
    $description = $module['description'];
    $time_events = $module['time_events'];
?>
<section class="f--background-d <?= $spacing ?>">
    <div class="f--container">
        <div class="f--row f--gap-c u--justify-content-space-between">
            <div class="f--col-6 f--col-tablets-10 f--col-mobile-12">
                <h2 class="f--font-e f--color-a u--font-medium">
                    <?= $heading ?>
                </h2>
            </div>
            <div class="f--col-5 f--col-tabletm-6 f--col-tablets-10 f--col-mobile-12">
                <p class="f--font-h f--color-a u--font-light u--mt-2 u--mt-tablets-0">
                    <?= $description ?>
                </p>
            </div>
            <div class="f--col-12">
                <div class="c--timeline-a js--timeline-a">
                    <?php foreach ($time_events as $time_event) : ?>
                        <div class="c--timeline-a__item">
                            <div class="c--timeline-a__item__wrapper">
                                <span class="c--timeline-a__item__wrapper__date">
                                    <?= $time_event['title'] ?>
                                </span>
                                <p class="c--timeline-a__item__wrapper__content">
                                    <?= $time_event['description'] ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
    unset($spacing, $heading, $description, $time_events);
?>