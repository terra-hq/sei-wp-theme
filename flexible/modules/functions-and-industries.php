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
            <div class="f--col-3 f--col-tabletl-8 f--col-tabletm-10 f--col-mobile-12">
                <h2 class="f--font-c f--mb-4">
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
            <div class="f--col-8 f--col-tabletl-12 f--col-tablets-12">
                <div class="u--display-flex u--display-tabletm-block">
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
