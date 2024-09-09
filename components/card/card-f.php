<a class="c--card-f <?= $modifierClass ? "c--card-f--$modifierClass" : "" ?>" href="<?= $card['link'] ?>">
    <div class="c--card-f__wrapper">
        <span class="c--card-f__wrapper__subtitle">
            <?= $card['subtitle'] ?>
        </span>
        <h3 class="c--card-f__wrapper__title">
            <?= $card['title'] ?>
        </h3>
    </div>
    <div class="c--card-f__artwork">
        <svg class="c--card-f__artwork__item" width="28" height="27" viewBox="0 0 28 27" fill="none">
            <rect x="1" y="0.5" width="26" height="26" rx="13" fill="#F01840"/>
            <rect x="1" y="0.5" width="26" height="26" rx="13" stroke="#F01840"/>
            <path d="M7.52002 13.5H20.48" stroke="#FFFFF8" stroke-width="2" stroke-linecap="round"/>
            <path d="M14 7.02002V19.98" stroke="#FFFFF8" stroke-width="2" stroke-linecap="round"/>
        </svg>
    </div>
</a>