<header class="c--header-a">
    <div class="c--header-a__wrapper">
        <div class="c--header-a__wrapper__hd">
            <a href="<?php echo home_url(); ?>" class="c--brand-a" aria-label="SEI homepage">
                <img width=83 height=32 src=<?= get_template_directory_uri() . "/public/assets/logos/sei-logo.svg" ?> alt="SEI logo" class="c--brand-a__media" decoding="async">
            </a>
        </div>
        <div class="c--header-a__wrapper__bd">
            <nav class="c--nav-a">
                <ul class="c--nav-a__list-group">
                    <li class="c--nav-a__list-group__item">
                        <ul class="c--nav-b">
                            <?php $navbar_items = get_field('navbar_items', 'option');
                            if ($navbar_items) :
                                foreach ($navbar_items as $key => $item) : ?>
                                    <li class="c--nav-b__item">
                                        <?php if ($item['has_dropdown']) { ?>
                                            <button class="c--nav-b__item__link js--nav-item" data-id="<?php echo $key ?>"><?php echo $item['item_link']['title'] ?></button>
                                
                                            <?php $children = $item['navbar_children'];
                                            if ($children) :
                                                $dropdown_class = 'c--dropdown-a js--dropdown';
                                                foreach ($children as $child) {
                                                    if (!$child['child_description_icon']) {
                                                        $dropdown_class .= ' c--dropdown-a--second';
                                                        $wrapper = true;
                                                        break;
                                                    }
                                                } ?>
                                                <div class="<?php echo $dropdown_class; ?>" data-wrapper=<?php echo $wrapper ?>></div>
                                            <?php endif; ?>
                                        <?php } else { ?>
                                            <a href="<?php echo $item['item_link']['url'] ?>" class="c--nav-b__item__link"><?php echo $item['item_link']['title'] ?></a>
                                        <?php } ?>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>

                    </li>

                    <li class="c--nav-a__list-group__item">
                        <button class="c--nav-a__list-group__item__link js--search" aria-label="Search">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M18.4937 18.7471L12.6115 12.8649M12.6115 12.8649C13.8431 11.6333 14.6048 9.93189 14.6048 8.05263C14.6048 4.29402 11.5578 1.24707 7.79921 1.24707C4.0406 1.24707 0.993652 4.29402 0.993652 8.05263C0.993652 11.8112 4.0406 14.8582 7.79921 14.8582C9.67848 14.8582 11.3799 14.0965 12.6115 12.8649Z" stroke="#141018" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </li>
                    <li class="c--nav-a__list-group__item">
                        <button class="c--burger-a js--burger js--scroll-init" aria-label="Menu" aria-label="Sidenav Menu">
                            <svg xmlns="http://www.w3.org/2000/svg" width="46" height="14" viewBox="0 0 46 14" fill="none">
                                <path d="M46 1.74512H0M46 12.2486H23.5" stroke="#141018" stroke-width="2" />
                            </svg>
                        </button>
                    </li>
                </ul>
                <div class="c--search-a">
                    <div class="c--search-a__media-wrapper"></div>

                    <div class="c--search-a__hd">
                        <div class="g--form-input-icon-01">
                            <input type="search" role=search id="js--search-input" class="g--form-input-icon-01__item" placeholder="Type something" />
                            <div class="g--spinner-01 g--form-input-icon-01__artwork">
                                <svg viewBox="0 0 26 26" fill="none">
                                    <path d="M23.446 9.625c1.063-.344 1.66-1.494 1.155-2.49a13 13 0 1 0-1.085 13.507c.657-.903.251-2.134-.743-2.642-.994-.51-2.198-.095-2.916.76a8.954 8.954 0 1 1 .831-10.352c.573.96 1.695 1.56 2.758 1.217Z" fill="#7F7ED0"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <p class="c--search-a__bd" id="js--search-results__number"></p>
                    <div class="c--search-a__ft">
                        <div id="js--search-results"></div>
                     </div>
                </div>
            </nav>
        </div>
    </div>
</header>
<nav class="c--sidenav-a">
    <?php $sidebar_items = get_field('sidebar_items', 'option');
    if($sidebar_items): ?>
    <ul class="c--sidenav-a__list-group">
    <li class="c--sidenav-a__list-group__item c--sidenav-a__list-group__item--second"></li>
        <?php foreach($sidebar_items as $key => $side_item): ?>
            <li class="c--sidenav-a__list-group__item">
                <?php if($side_item['sidebar_has_dropdown']) { ?>
                    <button class="c--sidenav-a__list-group__item__link js--nav-item" aria-label="Sidenav link"><?php echo $side_item['sidebar_item']['title'] ?></button>
                    <div class="c--dropdown-a c--dropdown-a--third js--dropdown">
                        <div class="c--dropdown-a__content">
                        <?php $side_children = $side_item['sidebar_children'];
                        if($side_children): ?>
                            <div class="c--dropdown-a__content__wrapper">
                                <?php foreach($side_children as $key => $side_child): ?>
                                    <a href="<?php echo $side_child['child_link']['url'] ?>" <?php echo get_target_link($side_child['child_link']['target'], $side_child['child_link']['title']) ?> class="c--dropdown-a__content__wrapper__item"><?php echo $side_child['child_link']['title'] ?></a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        </div>
                    </div>
                <?php } else { ?>
                    <a href="<?php echo $side_item['sidebar_item']['url'] ?>" <?php echo get_target_link($side_item['sidebar_item']['target'], $side_item['sidebar_item']['title'])?> class="c--sidenav-a__list-group__item__link"><?php echo $side_item['sidebar_item']['title'] ?></a>
                <?php } ?>
        <?php endforeach; ?>
        <?php if(get_field('sidebar_highlighted_link', 'option'));
        if(get_field('sidebar_highlighted_link', 'option')): ?>
        <li class="c--sidenav-a__list-group__item">
            <a href="<?php echo get_field('sidebar_highlighted_link', 'option')['url'] ?>" <?php echo get_target_link(get_field('sidebar_highlighted_link', 'option')['target'], get_field('sidebar_highlighted_link', 'option')['title']) ?> class="c--sidenav-a__list-group__item__link c--sidenav-a__list-group__item__link--second">
                <span><?php echo get_field('sidebar_highlighted_link', 'option')['title'] ?></span>
                <?php include(locate_template('public/assets/btn-03-arrow.svg', false, false)); ?>
            </a>
        </li>
        <?php endif; ?>
    </ul>
    <?php endif; ?>
    <button class="c--sidenav-a__link js--close" aria-label="Close">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1 1L17 17M17 1L1 17" stroke="#000" stroke-width="2"></path>
        </svg>
    </button>
</nav>
<div class="c--overlay-a"></div>
<div class="c--overlay-b"></div>