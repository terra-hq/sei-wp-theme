<?php

switch ($hero['acf_fc_layout']) {
    case 'homepage_hero':
        include (locate_template('flexible/hero/homepage-hero.php', false, false));
        break;
    case 'capability_hero':
        include (locate_template('flexible/hero/capability-hero.php', false, false));
        break;
    case 'big_image_hero':
        include (locate_template('flexible/hero/big-image-hero.php', false, false));
        break;
    case 'title_left_text_right_hero':
        include (locate_template('flexible/hero/title-left-text-right-hero.php', false, false));
        break;
    case 'big_heading_tagline_hero':
        include (locate_template('flexible/hero/big-heading-tagline-hero.php', false, false));
        break;
    case 'heading_hero':
        include (locate_template('flexible/hero/heading-hero.php', false, false));
        break;
    case 'heading_swirl':
        include (locate_template('flexible/hero/heading-swirl.php', false, false));
        break;
    case 'heading_tagline_left_and_img_right':
        include (locate_template('flexible/hero/heading-tagline-left-and-img-right.php', false, false));
        break;
       
}