<div class="g--card-07<?= isset($modifierClass) ? " g--card-07--$modifierClass" : "" ?>">
    <div class="g--card-07__ft-items">
        <h3 class="g--card-07__ft-items__item-primary">Need to add rapid prototyping to your product development checklist? Chat with an SEI consultant today to learn more.</h3>
        <div class="g--card-07__ft-items__list-group">
            <?php if ($modifierClass == 'third') { ?>
                <p class="g--card-07__ft-items__list-group__item">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate libero et velit interdum, ac aliquet odio mattis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
            <?php } else { ?>
                <a href="#" class="g--card-07__ft-items__list-group__item">
                    <span>Talk to Us!</span>
                    <?php include(locate_template('assets/frontend/btn-03-arrow.svg', false, false)); ?>
                </a>
            <?php } ?>
        </div>
    </div>
</div>