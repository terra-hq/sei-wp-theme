<?php
$spacing = get_spacing($module['spacing']);
?>

<section class="c--slider-a <?= $spacing ?>">
    <div class="f--container">
        <div class="f--row">
            <div class="f--col-12">
                <div class="c--slider-a__wrapper js--slider-c">
                    <?php if (!empty($module['custom_cards'])): ?>
                        <?php foreach ($module['custom_cards'] as $key => $card):
                            $title = $card['title'];
                            $content = $card['content'];
                            $image = $card['image'];
                            $scroll_to_form = $card['scroll_to_form'] ?? false;
                            $scroll_to_form_title = $card['scroll_to_form_title'] ?? '';
                            $button = $card['button'];
                            $permalink = $button['url'] ?? '#';
                            $target = !empty($button['target']) ? 'target="_blank" rel="noopener noreferrer"' : '';
                            $label = $button['title'] ?? '';
                            include(locate_template('components/card/card-05.php', false, false));
                        endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
    unset(
        $spacing, 
        $module, 
        $title, 
        $content, 
        $image, 
        $scroll_to_form, 
        $scroll_to_form_title, 
        $button, 
        $permalink, 
        $target, 
        $label
    );
?>