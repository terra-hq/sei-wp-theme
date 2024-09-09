<?php

switch ($hero['acf_fc_layout']) {
    case 'homepage_hero':
        include (locate_template('flexible/hero/homepage-hero.php', false, false));
        break;
}