<?php
    $spacing = get_spacing($module['spacing']) ?? 'u--pt-15 u--pb-15';
?>

<section class="<?= $spacing?>">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-12">
                <div class="c--accordion-a c--accordion-a--second">
                <?php
                        wp_reset_postdata();
                        $parent_args = array(
                            'post_type' => 'capability',
                            'post_status' => 'publish',
                            'posts_per_page' => -1,
                            'orderby' => 'title',
                            'order' => 'ASC',
                            'post_parent' => 0 // Only post that are parents (0 = no parent id)
                        );
    
                        $parent_query = new WP_Query($parent_args);

                        if ($parent_query->have_posts()) :
                            $first = true;
                            while ($parent_query->have_posts()) : $parent_query->the_post();
                            $card_title = get_the_title();
                            $card_description = get_field('homepage_tagline', get_the_ID()) ?? 'Not Filled';
                            $link = get_the_permalink();
                    ?>
                         <div class="c--accordion-a__item">
                            <input type="radio" name="select" class="c--accordion-a__item__btn" <?php echo $first ? 'checked' : ''; ?> />
                            <div class="c--accordion-a__item__hd">
                                <span class="c--accordion-a__item__hd__content"><?= $card_title ?></span>
                            </div>
                            <div class="c--accordion-a__item__wrapper">
                                <div class="c--accordion-a__item__wrapper__content">
                                    <?php include(locate_template('components/card/card-n.php', false, false)); ?>
                                </div>
                            </div>
                        </div>
                    <?php
                        $first = false;
                        endwhile;
                        wp_reset_postdata();
                    endif; ?>
                </div>
$spacing = get_spacing($module['section_spacing']);
$left_label_accordion = $module['left_label_accordion'] ?? '';
$right_label_accordion = $module['right_label_accordion'] ?? '';
$accordion_items = $module['accordion_items'] ?? [];
?>

<section class="<?= $spacing ?>">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-12">

                <?php if (!empty($accordion_items)): ?>
                    <?php foreach ($accordion_items as $index => $item): ?>
                        <?php if (!empty($item['title'])): ?>
                            <h3><?= $item['title'] ?></h3>
                        <?php endif; ?>

                        <div>
                            <?php if ($left_label_accordion): ?>
                                <p><strong><?= $left_label_accordion ?></strong></p>
                            <?php endif; ?>
                            <?php if (!empty($item['left_content'])): ?>
                                <p><?= $item['left_content'] ?></p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <?php if ($right_label_accordion): ?>
                                <p><strong><?= $right_label_accordion ?></strong></p>
                            <?php endif; ?>
                            <?php if (!empty($item['right_content'])): ?>
                                <p><?= $item['right_content'] ?></p>
                            <?php endif; ?>
                        </div>

                        <hr>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>

<<<<<<< HEAD
<?php unset($spacing); ?>
=======
<?php unset($spacing, $left_label_accordion, $right_label_accordion, $accordion_items); ?>
>>>>>>> create--ai-productization--86dyh4zj9
