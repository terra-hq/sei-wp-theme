<?php

switch ($module['acf_fc_layout']) {
    case 'heading':
        include(locate_template('flexible/module/heading.php', false, false));
        break;
    case 'subheading_heading':
        include(locate_template('flexible/module/subheading-heading.php', false, false));
        break;
    case 'cta':
        include(locate_template('flexible/module/cta.php', false, false));
        break;
    case 'marquee':
        include(locate_template('flexible/module/marquee.php', false, false));
        break;
    case 'faqs_media':
        include(locate_template('flexible/module/faqs-media.php', false, false));
        break;
    case 'collapsible_content_image':
        include(locate_template('flexible/module/collapsible-content-image.php', false, false));
        break;
    case 'testimonials':
        include(locate_template('flexible/module/testimonials.php', false, false));
        break;
    case 'fullwidth_image':
        include(locate_template('flexible/module/fullwidth-image.php', false, false));
        break;
    case 'media_card':
        include(locate_template('flexible/module/media-card.php', false, false));
        break;
}
