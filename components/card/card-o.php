<div class="c--card-o">
    <div class="f--row f--gap-c">
        <div class="f--col-8 f--col-tabletm-12 u--display-flex u--flex-direction-column u--height-100">

            <?php if (!empty($title)) : ?>
                <div class="c--card-o__hd">
                    <h2 class="c--card-o__hd__title"><?= htmlspecialchars($title, ENT_QUOTES); ?></h2>
                </div>
            <?php endif; ?>

            <?php if (!empty($columns_left_content) || !empty($columns_right_content)) : ?>
                <div class="c--card-o__bd">
                    <div class="f--row f--gap-c">
                        <?php if (!empty($columns_left_content)) : ?>
                            <div class="f--col-6 f--col-tablets-12">
                                <?php if (!empty($columns_left_label)) : ?>
                                    <p class="c--card-o__bd__subtitle c--card-o__bd__subtitle--second"><?= htmlspecialchars($columns_left_label, ENT_QUOTES); ?></p>
                                <?php endif; ?>
                                <div class="c--card-o__bd__content c--card-o__bd__content--second">
                                    <?= apply_filters('the_content', $columns_left_content); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($columns_right_content)) : ?>
                            <div class="f--col-6 f--col-tablets-12">
                                <?php if (!empty($columns_right_label)) : ?>
                                    <p class="c--card-o__bd__subtitle"><?= htmlspecialchars($columns_right_label, ENT_QUOTES); ?></p>
                                <?php endif; ?>
                                <div class="c--card-o__bd__content">
                                    <?= apply_filters('the_content', $columns_right_content); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($bottom_cards)) : ?>
                <div class="c--card-o__ft">
                    <div class="f--row">
                        <div class="f--col-12">
                            <?php if (!empty($bottom_label)) : ?>
                                <p class="c--card-o__ft__subtitle"><?= htmlspecialchars($bottom_label, ENT_QUOTES); ?></p>
                            <?php endif; ?>
                            
                            <div class="f--row f--gap-d">
                                <?php foreach ($bottom_cards as $card) : ?>
                                    <div class="f--col-4 f--col-tablets-12">
                                        <div class="c--card-o__ft__item">
                                            <?php if (!empty($card['card_title'])) : ?>
                                                <h4 class="c--card-o__ft__item__title"><?= htmlspecialchars($card['card_title'], ENT_QUOTES); ?></h4>
                                            <?php endif; ?>
                                            <?php if (!empty($card['card_subtitle'])) : ?>
                                                <p class="c--card-o__ft__item__subtitle"><?= htmlspecialchars($card['card_subtitle'], ENT_QUOTES); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>

        <div class="f--col-4 f--col-tabletm-12">

            <div class="u--display-flex u--flex-direction-column u--height-100">

                <div class="c--card-o__media-wrapper">
                    <?php if (!empty($pills)) : ?>
                        <div class="c--card-o__media-wrapper__overlay">
                            <?php foreach ($pills as $pill) : ?>
                                <?php if (!empty($pill)) : ?>
                                    <span class="c--card-o__media-wrapper__overlay__pill"><?= htmlspecialchars($pill, ENT_QUOTES); ?></span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($image)) : ?>
                        <?php
                            $image_tag_args = [
                                'image' => $image,
                                'sizes' => '580px',
                                'class' => 'c--card-o__media-wrapper__media',
                                'isLazy' => true,
                                'lazyClass' => 'g--lazy-01',
                                'showAspectRatio' => true,
                                'decodingAsync' => true,
                                'fetchPriority' => false,
                                'addFigcaption' => false,
                            ];
                            generate_image_tag($image_tag_args);
                        ?>
                    <?php endif; ?>
                </div>
            
                <?php if (!empty($button_label)) : ?>
                    <button 
                        data-modal-open="my-modal"
                        data-modal-form-type="form-b"
                        data-modal-form-portal-id="<?= htmlspecialchars($form_portal_id, ENT_QUOTES); ?>"
                        data-modal-form-id="<?= htmlspecialchars($form_id, ENT_QUOTES); ?>"
                        class="c--card-o__btn"
                    >
                        <svg class="c--card-o__btn__artwork" xmlns="http://www.w3.org/2000/svg" width="22" height="18" viewBox="0 0 22 18" fill="none">
                            <path d="M1 8.91406L21 8.91406M21 8.91406L13.5 16.4141M21 8.91406L13.5 1.41406" stroke="#FFFFF8" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/>
                        </svg>
                        <span><?= htmlspecialchars($button_label, ENT_QUOTES); ?></span>
                    </button>
                <?php endif; ?>

            </div>

        </div>
    </div>
</div>
