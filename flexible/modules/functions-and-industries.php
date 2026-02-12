<?php
    $spacing = get_spacing($module['spacing']);
    $bgColor = $module['bg_color'];
    // if ($bgColor === 'f--background-c' || $bgColor === 'f--background-d') $color = 'f--color-a'; // blanco
    // else $color = 'f--color-c'; // rojo
    $title = $module['title'];
    $content = $module['content'];
    $functions = $module['functions'];
    $industries = $module['industries'];
?>

<section class="<?= $bgColor ?> <?= $spacing ?>">
    <div class="f--container">
        <div class="f--row f--gap-c u--justify-content-space-between">
            <div class="f--col-3 f--col-laptop-8 f--col-tabletl-10 f--col-tablets-12">
                <h2 class="f--font-c u--mb-4">
                    <?php
                        if ($title) {
                            foreach ($title as $e) {
                                $text = $e['text'];
                                $italic = $e['italic'];
                                if ($italic) {
                                    echo '<span class="f--font-d">' . $text . '</span>';
                                } else {
                                    echo $text . ' ';
                                }
                            }
                        }
                    ?>
                </h2>
                <div class="c--content-a c--content-a--second-text">
                    <?= $content ?>
                </div>
            </div>
            <div class="f--col-8 f--col-laptop-12 f--col-tabletm-12">
                <div class="u--display-flex u--display-tabletl-block">
                    <?php
                        $modifierClass = null;
                        $type = 'function';
                        $card = $functions;
                        $card_posts = $functions['selector'];
                        include (locate_template('components/card/card-i.php', false, false));
                    ?>
                    <?php 
                        $modifierClass = "second";
                        $card = $industries;
                        $type = 'industry';
                        $card_posts = $industries['selector'];
                        include (locate_template('components/card/card-i.php', false, false));
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php unset($spacing, $bgColor, $title, $content, $functions, $industries, $modifierClass, $type, $card, $card_posts); ?>
