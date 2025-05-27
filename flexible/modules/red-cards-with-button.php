<?php $cards = $module['cards']; ?>
<?php if ($cards) : ?>
    <section class="<?php echo $module['bg_color'] ?> <?= get_spacing($module['section_spacing']); ?>">
        <div class="f--container">
            <div class="f--row f--row--remove-gutter u--justify-content-center">
                <?php foreach ($cards as $key => $card) : 
                    switch ($key) {
                        case 1:
                           $customClass = 'g--card-09--second';
                            break;
                        case 2:
                            $customClass = 'g--card-09--third';
                                break;
                        case 3:
                            $customClass = 'g--card-09--fourth';
                                break;
                        
                        default:
                            # code...
                            break;
                    }?>
                    <div class="f--col-3 f--col-laptop-5 f--col-tabletm-6 f--col-tablets-12">
                        <div class="g--card-09 <?php echo $customClass ?>">
                            <div class="g--card-09__ft-items">
                                <h3 class="g--card-09__ft-items__item-primary"><?php echo $card['title'] ?></h3>
                                <p class="g--card-09__ft-items__item-secondary">
                                    <?php echo $card['subtitle'] ?>
                                </p>
                                <?php if($card['button']): ?>
                                    <div class="g--card-09__ft-items__list-group">
                                        <a href="<?php echo $card['button']['url'] ?>"  <?= get_target_link($card['button']['target'], $card['button']['title'] )?> rel="noopener noreferrer" class="g--card-09__ft-items__list-group__item">
                                            <span class="g--btn-03__content">
                                                <?php echo $card['button']['title'] ?>
                                            </span>
                                            <?php include(locate_template('img/btn-03-arrow.svg', false, false)); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php unset($cards, $customClass); ?>