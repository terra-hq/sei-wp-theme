<div class="c--marquee-b">
    <a href="<?php echo $module['marquee_click_destination'] ?>" target="_blank" class="c--marquee-b__list-group js--marquee-b"  data-speed="1"
                 data-controls-on-hover="false"
                  data-reversed="0">
        <?php for ($i = 0; $i < 5; $i++) : ?>
            <div class="c--marquee-b__list-group__list-item">
                <img src="<?php echo get_template_directory_uri(); ?>/public/assets/img/vector.webp" alt="Leadership team" class="c--marquee-b__media" width="116" height="116" />
                <?php foreach($module['marquee_text'] as $key => $item): ?>
                    <p>
                        <?php if ($item['italic']): ?>
                            <span class="c--marquee-b__ft"><?php echo $item['text']; ?></span>
                        <?php else: ?>
                            <?php echo $item['text']; ?>
                        <?php endif; ?>
                    </p>
                <?php endforeach; ?>
            </div>
        <?php endfor; ?>
    </a>
</div>