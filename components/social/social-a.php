<nav class="c--social-a <?php echo $socialCustomClass ?>">
    <?php if (get_field('linkedin_link', 'option')) : ?>
        <a href="<?php echo get_field('linkedin_link', 'option') ?>" target="_blank" rel="noopener noreferrer" class="c--social-a__item" aria-label="linkedin">
            <svg viewBox="0 0 22 22" fill="none">
                <path d="M21 6.11806V15.0069C21 18.0625 18.5 20.5625 15.4444 20.5625H6.55556C3.5 20.5625 1 18.0625 1 15.0069V6.11806C1 3.0625 3.5 0.5625 6.55556 0.5625H15.4444C18.5 0.5625 21 3.0625 21 6.11806Z" stroke="#402848" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M5.44531 16.1176V8.33984" stroke="#402848" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M9.88867 16.1176V12.5065M9.88867 12.5065V8.33984M9.88867 12.5065C9.88867 8.33984 16.5553 8.33984 16.5553 12.5065V16.1176" stroke="#402848" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </a>
    <?php endif; ?>
    <?php if (get_field('x_link', 'option')) : ?>
        <a href="<?php echo get_field('x_link', 'option') ?>" target="_blank" rel="noopener noreferrer" class="c--social-a__item" aria-label="twitter">
            <svg viewBox="0 0 18 20" fill="none">
                <path d="M13.7947 18.3125L0.744694 1.5125C0.444694 1.1125 0.744694 0.5625 1.24469 0.5625H3.74469C3.94469 0.5625 4.09469 0.6625 4.19469 0.8125L17.2447 17.6125C17.5447 18.0125 17.2947 18.5625 16.7947 18.5625H14.2947C14.0947 18.5625 13.9447 18.4625 13.7947 18.3125Z" stroke="#402848" stroke-miterlimit="8" />
                <path d="M16.9941 0.5625L0.994141 18.5625" stroke="#402848" stroke-miterlimit="8" stroke-linecap="round" />
            </svg>
        </a>
    <?php endif; ?>
    <?php if (get_field('instagram_link', 'option')) : ?>
        <a href="<?php echo get_field('instagram_link', 'option') ?>" target="_blank" rel="noopener noreferrer" class="c--social-a__item" aria-label="instagram">
            <svg viewBox="0 0 22 22" fill="none">
                <path d="M10.9991 15.0061C13.4436 15.0061 15.4436 13.0061 15.4436 10.5616C15.4436 8.11719 13.4436 6.11719 10.9991 6.11719C8.55469 6.11719 6.55469 8.11719 6.55469 10.5616C6.55469 13.0061 8.55469 15.0061 10.9991 15.0061Z" stroke="#402848" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M1 15.0069V6.11806C1 3.0625 3.5 0.5625 6.55556 0.5625H15.4444C18.5 0.5625 21 3.0625 21 6.11806V15.0069C21 18.0625 18.5 20.5625 15.4444 20.5625H6.55556C3.5 20.5625 1 18.0625 1 15.0069Z" stroke="#402848" stroke-miterlimit="8" />
            </svg>
        </a>
    <?php endif; ?>
    <?php if (get_field('facebook_link', 'option')) : ?>
    <a href="<?php echo get_field('facebook_link', 'option') ?>" target="_blank" rel="noopener noreferrer" class="c--social-a__item" aria-label="facebook">
        <svg viewBox="0 0 12 22" fill="none">
            <path d="M11.5 0.5625H8.5C7.15 0.5625 5.9 1.1125 4.95 2.0125C4.05 2.9625 3.5 4.2125 3.5 5.5625V8.5625H0.5V12.5625H3.5V20.5625H7.5V12.5625H10.5L11.5 8.5625H7.5V5.5625C7.5 5.3125 7.6 5.0625 7.8 4.8625C8 4.6625 8.25 4.5625 8.5 4.5625H11.5V0.5625Z" stroke="#402848" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </a>
    <?php endif; ?>
</nav>