<a class="c--card-l <?= $modifierClass ? "c--card-l--$modifierClass" : "" ?>" href="<?= $card['permalink'] ?>" <?php echo $card['target'] ?> >
    <?php if (isset($modifierClass) && $modifierClass === "third") : ?>
        <img src="<?php bloginfo('template_url'); ?>/assets/frontend/background/card-l-bg.webp" 
            class="c--card-l__bg-items" 
        >
    <?php endif; ?>
    <div class="c--card-l__wrapper">
        <span class="c--card-l__wrapper__subtitle">
            <?php if (isset($modifierClass) && $modifierClass === "third") { echo 'featured'; } ?>
            <?= $card['subtitle'] ?>
        </span>
        <h3 class="c--card-l__wrapper__title">
            <?= $card['title'] ?>
        </h3>
        <ul class="c--card-l__wrapper__list-group">
            <?php foreach ($card['tags'] as $tag): ?>
                <li class="c--card-l__wrapper__list-group__list-item">
                    <?= $tag ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</a>