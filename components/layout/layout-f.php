<div class="c--layout-f">
    <div class="f--row f--gap-c">
        <div class="f--col-8 f--col-tabletl-7 f--col-tablets-12 u--display-flex u--flex-direction-column">

            <?php if (!empty($title)) : ?>
                <div class="c--layout-f__hd">
                    <h2 class="c--layout-f__hd__title"><?= htmlspecialchars($title, ENT_QUOTES); ?></h2>
                </div>
            <?php endif; ?>

            <?php if (!empty($columns_left_content) || !empty($columns_right_content)) : ?>
                <div class="c--layout-f__bd">
                    <div class="f--row f--gap-c">
                        <?php if (!empty($columns_left_content)) : ?>
                            <div class="f--col-6 f--col-tabletl-12">
                                <?php if (!empty($columns_left_label)) : ?>
                                    <p class="c--layout-f__bd__subtitle c--layout-f__bd__subtitle--second"><?= htmlspecialchars($columns_left_label, ENT_QUOTES); ?></p>
                                <?php endif; ?>
                                <div class="c--layout-f__bd__content c--layout-f__bd__content--second">
                                    <?= apply_filters('the_content', $columns_left_content); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($columns_right_content)) : ?>
                            <div class="f--col-6 f--col-tabletl-12">
                                <?php if (!empty($columns_right_label)) : ?>
                                    <p class="c--layout-f__bd__subtitle"><?= htmlspecialchars($columns_right_label, ENT_QUOTES); ?></p>
                                <?php endif; ?>
                                <div class="c--layout-f__bd__content">
                                    <?= apply_filters('the_content', $columns_right_content); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($bottom_cards)) : ?>
                <div class="c--layout-f__ft">
                    <div class="f--row">
                        <div class="f--col-12">
                            <?php if (!empty($bottom_label)) : ?>
                                <p class="c--layout-f__ft__subtitle"><?= htmlspecialchars($bottom_label, ENT_QUOTES); ?></p>
                            <?php endif; ?>
                            
                            <div class="f--row f--gap-d">
                                <?php foreach ($bottom_cards as $card) : ?>
                                    <div class="f--col-4 f--col-tabletm-12 u--display-flex">
                                        <?php
                                            $title = $card['card_title'] ?? '';
                                            $subtitle = $card['card_subtitle'] ?? '';
                                            include(locate_template('components/card/card-e-second.php', false, false));
                                        ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>

        <div class="f--col-4 f--col-tabletl-5 f--col-tablets-12 u--display-flex u--flex-direction-column">


                <div class="c--layout-f__media-wrapper">
                    <?php if (!empty($pills)) : ?>
                        <div class="c--layout-f__media-wrapper__overlay">
                            <?php foreach ($pills as $pill) : ?>
                                <?php if (!empty($pill)) : ?>
                                    <span class="c--layout-f__media-wrapper__overlay__pill"><?= htmlspecialchars($pill["pill_text"], ENT_QUOTES); ?></span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($image)) : ?>
                        <?php
                            $image_tag_args = [
                                'image' => $image,
                                'sizes' => '580px',
                                'class' => 'c--layout-f__media-wrapper__media',
                                'isLazy' => false,
                                'showAspectRatio' => false,
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
                        class="c--layout-f__btn"
                    >
                        <?php include(locate_template('img/btn-03-arrow.svg', false, false)); ?>
                        <span><?= htmlspecialchars($button_label, ENT_QUOTES); ?></span>
                    </button>
                <?php endif; ?>


        </div>
    </div>
</div>
