<?php
/*
Template Name: Sitemap
*/
?>
<?php get_header() ?>

<?php 
    $hero['title'] = [
        [
            'text' => get_the_title(),
        ]
    ];
    $modifierClass = "second";
?>
<?php include(locate_template('flexible/hero/big-heading-tagline-hero.php', false, false)); ?>

<?php $sitemap_items = get_field('sitemap_items', 'option');?>
          
<?php 
if ($sitemap_items) { ?>
<section class="f--pb-15 f--pb-tablets-10">
    <div class="f--container">
        <div class="c--sitemap-a">
            <?php foreach ($sitemap_items as $sitemap_item) {  ?>
                <?php if(!$sitemap_item['has_children']) { ?>
                    <?php if($sitemap_item['link']) { ?>
                        <div class="c--sitemap-a__wrapper">
                            <div class="c--sitemap-a__wrapper__hd">
                                <a href="<?= $sitemap_item['link']['url']?>" class="c--sitemap-a__wrapper__hd__title"><?= $sitemap_item['link']['title'] ?></a>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else {?>
                    <div class="c--sitemap-a__wrapper">
                        <div class="c--sitemap-a__wrapper__hd">
                            <p class="c--sitemap-a__wrapper__hd__title"><?= $sitemap_item['parent_item'] ?></p>
                        </div>
                        <?php if ($sitemap_item['children'] && !$sitemap_item['is_bold_heading']) { ?>
                            <div class="c--sitemap-a__wrapper__bd">
                                <?php foreach ($sitemap_item['children'] as $sitemap_single) {  ?>
                                    <div class="c--sitemap-a__wrapper__bd__item">
                                        <a href="<?= get_the_permalink($sitemap_single->ID); ?>" class="c--sitemap-a__wrapper__bd__item__content"><?= $sitemap_single->post_title?></a>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <?php if($sitemap_item['is_bold_heading']) {?>
                            <div class="c--sitemap-a__wrapper__bd">
                                <?php foreach ($sitemap_item['parent_children'] as $parent_sitemap_single) {  ?>
                                    <div class="c--sitemap-a__wrapper__bd__item">
                                        <a href="<?= get_the_permalink($parent_sitemap_single->ID); ?>" class="c--sitemap-a__wrapper__bd__item__title"><?= $parent_sitemap_single['bold_heading_title']?></a>
                                        <?php foreach ($parent_sitemap_single['children'] as $children_single) {  ?>
                                            <a href="<?= get_the_permalink($children_single->ID); ?>" class="c--sitemap-a__wrapper__bd__item__content"><?= $children_single->post_title?></a>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php }?>
             <?php }?>
        </div>
    </div>
</section>
<?php } ?>
<?php get_footer() ?>