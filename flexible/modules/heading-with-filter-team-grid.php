<?php
    function sanitize_location($location) {
        // Convert to lowercase
        $clean = strtolower($location);
        // Replace spaces with hyphens
        $clean = str_replace(' ', '-', $clean);
        // Remove any multiple consecutive hyphens
        $clean = preg_replace('/-+/', '-', $clean);
        // Trim hyphens from start and end
        return trim($clean, '-');
    }

    $spacing = get_spacing($module['section_spacing']);
    $title = $module['title'];
    $people_selector = $module['people_selector'];

    $selected_people_ids = array();
    if (!empty($people_selector) && is_array($people_selector)) {
        $selected_people_ids = array_map(function($person) {
            return $person->ID;
        }, $people_selector);
    }

    $people_args = array(
        'post_type' => 'people',
        'posts_per_page' => -1,
        'post__in' => $selected_people_ids,
        'orderby' => 'post__in',
    );
    $people_query = new WP_Query($people_args);
    $locations = array();

    if ($people_query->have_posts()) :
        while ($people_query->have_posts()) : $people_query->the_post();
            $location = get_field('location');
            if ($location) {
                foreach ($location as $loc) {
                    $location_title = $loc->post_title;
                    if (!in_array($location_title, $locations)) {
                        $locations[] = $location_title;
                    }
                }
            }
        endwhile;
    endif;
    wp_reset_postdata();

    // Sort locations alphabetically
    sort($locations);
?>

<section class="f--background-a <?= $spacing ?>">
    <div class="f--container">
        <div class="f--row f--gap-a">
            <div class="f--col-6 f--col-tabletm-8 f--col-tablets-12 u--display-flex">
                <h2 class="f--font-e u--font-medium"><?= $title ?></h2>
            </div>
            <div class="f--col-6 f--col-tabletm-4 f--col-tablets-12 u--display-flex u--align-items-flex-end">
                <div class="c--filter-a">
                    <div class="c--filter-a__item">
                        <select name="team-grid-location" id="team-grid-location">
                            <!-- Estos items son placeholders -->
                            <option value="all">All Locations</option>
                            <?php foreach ($locations as $location_title) : 
                            ?>
                                <option value="<?= $location_title; ?>"><?= $location_title; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- El spinner solo aparecerá cuando NO tenga la clase c--filter-a__artwork--is-hidden. 
                    Controlar esto por php: Cuando el filter este loading, quitar la clase, y cuando finalice, ponerla. -->
                    <div class="c--filter-a__artwork c--filter-a__artwork--is-hidden">
                        <svg viewBox="0 0 26 26" fill="none">
                            <path d="M23.446 9.625c1.063-.344 1.66-1.494 1.155-2.49a13 13 0 1 0-1.085 13.507c.657-.903.251-2.134-.743-2.642-.994-.51-2.198-.095-2.916.76a8.954 8.954 0 1 1 .831-10.352c.573.96 1.695 1.56 2.758 1.217Z" fill="#7F7ED0"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="f--col-12">
            <div class="c--wrapper-b">
                <?php foreach ($people_query->posts as $person) : ?>
                    <?php
                        $locations = get_field('location', $person->ID);
                        $location_classes = '';

                        if ($locations) {
                            foreach ($locations as $location) {
                                $location_classes .= 'location-' . sanitize_location($location->post_title) . ' ';
                            }
                        }
                    ?>
                    <div id="team-grid-people" class="<?= trim($location_classes); ?>">
                        <?php include(locate_template('components/card/card-c.php', false, false)); ?>
                    </div>
                <?php endforeach; ?>
            </div>
            </div>
        </div>
    </div>
</section>