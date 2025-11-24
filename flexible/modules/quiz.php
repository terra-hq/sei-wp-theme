<?php load_template(locate_template('flexible/modules/webgl-gradient-canvas.php', false, false)); ?>

<section class="js--quiz-a u--pt-30 u--pb-22 u--pt-mobile-2 u--pb-mobile-0">
    <div class="f--container f--container--tablets-fluid">
        <div class="f--row u--justify-content-center">
            <div class="f--col-5 f--col-desktop-6 f--col-laptop-8 f--col-tabletm-10 f--col-mobile-12 u--pl-mobile-0 u--pr-mobile-0">

                <form class="c--quiz-a hs-form" action="#" method="post" novalidate>

                    <div class="c--quiz-a__hd">
                        <h1 class="c--quiz-a__hd__title">Get insight into your AI readiness</h1>
                        <p class="c--quiz-a__hd__subtitle">See how ready you are for AI implementation with a quick, expert-led evaluation.</p>
                    </div>

                    <!-- Step 1 -->
                    <fieldset class="c--quiz-a__wrapper c--quiz-a__wrapper--is-active" data-step="1" data-tab-content="quiz-step-01" aria-hidden="false">
                        <div class="c--quiz-a__wrapper__hd">
                            <div class="c--progress-a">
                                <span class="c--progress-a__hd js--progressbar-text"></span>
                                <div class="c--progress-a__bd js--progressbar-wrapper" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                    <span class="c--progress-a__bd__item js--progressbar-item" aria-hidden="true"></span>
                                </div>
                            </div>
                        </div>
                        <div class="c--quiz-a__wrapper__bd">
                            <p class="c--quiz-a__wrapper__bd__subtitle">Contact Details</p>
                            <div class="c--form-group-a">
                                <label class="c--label-a" for="quiz-company">Company name*</label>
                                <div class="c--form-input-a">
                                    <input class="c--form-input-a__item" type="text" name="company" id="quiz-company" placeholder="Your company" required />
                                </div>
                            </div>
                            <div class="c--form-group-a">
                                <label class="c--label-a" for="quiz-email">Email address*</label>
                                <div class="c--form-input-a">
                                    <input class="c--form-input-a__item" type="email" name="email" id="quiz-email" placeholder="Your email address" required />
                                </div>
                            </div>
                        </div>
                        <div class="c--quiz-a__wrapper__ft">
                            <button type="button" class="c--quiz-a__wrapper__ft__btn c--quiz-a__wrapper__ft__btn--second">
                                Next step
                            </button>
                        </div>
                    </fieldset>

                    <!-- Step 2 -->
                    <fieldset class="c--quiz-a__wrapper" data-step="2" data-tab-content="quiz-step-02" aria-hidden="true">
                        <div class="c--quiz-a__wrapper__hd">
                            <div class="c--progress-a">
                                <span class="c--progress-a__hd js--progressbar-text"></span>
                                <div class="c--progress-a__bd js--progressbar-wrapper" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                    <span class="c--progress-a__bd__item js--progressbar-item" aria-hidden="true"></span>
                                </div>
                            </div>
                        </div>
                        <div class="c--quiz-a__wrapper__bd">
                            <p class="c--quiz-a__wrapper__bd__subtitle">Position and Sector</p>
                            <div class="c--form-group-a">
                                <label class="c--label-a" for="quiz-role">What is your role?*</label>
                                <div class="c--form-select-a">
                                    <select class="c--form-select-a__item" name="role" id="quiz-role" required>
                                        <option value="">Select your role</option>
                                        <option value="Executive / Leadership">Executive / Leadership</option>
                                        <option value="Business Unit / P&L Leader">Business Unit / P&L Leader</option>
                                        <option value="Operations / Transformation Lead">Operations / Transformation Lead</option>
                                        <option value="Technology / Data Leader">Technology / Data Leader</option>
                                        <option value="Marketing / Growth Leader">Marketing / Growth Leader</option>
                                        <option value="HR / People Leader">HR / People Leader</option>
                                        <option value="Finance / Legal / Risk">Finance / Legal / Risk</option>
                                    </select>
                                </div>
                            </div>
                            <div class="c--form-group-a">
                                <label class="c--label-a" for="quiz-industry">What's your industry?*</label>
                                <div class="c--form-select-a">
                                    <select class="c--form-select-a__item" name="industry" id="quiz-industry" required>
                                        <option value="">Select your industry</option>
                                        <option value="Automotive & Transportation">Automotive & Transportation</option>
                                        <option value="Construction & Real Estate">Construction & Real Estate</option>
                                        <option value="Consumer Products">Consumer Products</option>
                                        <option value="Environmental Services">Environmental Services</option>
                                        <option value="Financial Services">Financial Services</option>
                                        <option value="Government Services">Government Services</option>
                                        <option value="Healthcare">Healthcare</option>
                                        <option value="Higher Education">Higher Education</option>
                                        <option value="Insurance">Insurance</option>
                                        <option value="Leisure & Hospitality">Leisure & Hospitality</option>
                                        <option value="Life Sciences">Life Sciences</option>
                                        <option value="Media & Entertainment">Media & Entertainment</option>
                                        <option value="Nonprofits">Nonprofits</option>
                                        <option value="Professional Services">Professional Services</option>
                                        <option value="Retail & E-Commerce">Retail & E-Commerce</option>
                                        <option value="Supply Chain">Supply Chain</option>
                                        <option value="Utilities">Utilities</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="c--quiz-a__wrapper__ft">
                            <button type="button" class="c--quiz-a__wrapper__ft__link">
                                Previous step
                            </button>
                            <button type="button" class="c--quiz-a__wrapper__ft__btn c--quiz-a__wrapper__ft__btn--second">
                                Next step
                            </button>
                        </div>
                    </fieldset>

                    <!-- Step 3 -->
                    <fieldset class="c--quiz-a__wrapper" data-step="3" data-tab-content="quiz-step-03" aria-hidden="true">
                        <div class="c--quiz-a__wrapper__hd">
                            <div class="c--progress-a">
                                <span class="c--progress-a__hd js--progressbar-text"></span>
                                <div class="c--progress-a__bd js--progressbar-wrapper" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                    <span class="c--progress-a__bd__item js--progressbar-item" aria-hidden="true"></span>
                                </div>
                            </div>
                        </div>
                        <div class="c--quiz-a__wrapper__bd">
                            <p class="c--quiz-a__wrapper__bd__subtitle">Let's Talk About Your Needs</p>
                            <div class="c--form-group-a">
                                <label class="c--label-a" for="quiz-purpose">What's your purpose for using AI?</label>
                                <div class="c--form-select-a">
                                    <select class="c--form-select-a__item" name="purpose" id="quiz-purpose">
                                        <option value="">Select your purpose</option>
                                        <option value="Unclear strategy / use cases">Unclear strategy / use cases</option>
                                        <option value="Talent & skills gap">Talent & skills gap</option>
                                        <option value="Data readiness / infrastructure">Data readiness / infrastructure</option>
                                        <option value="Security & governance concerns">Security & governance concerns</option>
                                        <option value="Budget constraints">Budget constraints</option>
                                        <option value="Change resistance / culture">Change resistance / culture</option>
                                        <option value="Not sure where to start">Not sure where to start</option>
                                    </select>
                                </div>
                            </div>
                            <div class="c--form-group-a">
                                <label class="c--label-a" for="quiz-journey">Where are you in your AI transformation journey?*</label>
                                <div class="c--form-select-a">
                                    <select class="c--form-select-a__item" name="journey" id="quiz-journey" required>
                                        <option value="">Select..</option>
                                        <option value="Exploring">Exploring</option>
                                        <option value="Experimenting / Piloting">Experimenting / Piloting</option>
                                        <option value="Scaling">Scaling</option>
                                        <option value="Transforming">Transforming</option>
                                    </select>
                                </div>
                            </div>
                            <div class="c--form-group-a">
                                <label class="c--label-a" for="quiz-message">Message</label>
                                <div class="c--form-input-a">
                                    <textarea class="c--form-input-a__item" name="message" id="quiz-message" rows="4" placeholder="Share any additional details"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="c--quiz-a__wrapper__ft">
                            <button type="button" class="c--quiz-a__wrapper__ft__link">
                                Previous step
                            </button>
                            <button type="button" class="c--quiz-a__wrapper__ft__btn">
                                Submit
                            </button>
                        </div>
                    </fieldset>

                    <!-- Step 4 -->
                    <fieldset class="c--quiz-a__wrapper" data-step="4" data-tab-content="quiz-step-04" aria-hidden="true">
                        <div class="c--quiz-a__wrapper__hd">
                            <div class="c--progress-a">
                                <span class="c--progress-a__hd js--progressbar-text"></span>
                                <div class="c--progress-a__bd js--progressbar-wrapper" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                    <span class="c--progress-a__bd__item js--progressbar-item" aria-hidden="true"></span>
                                </div>
                            </div>
                        </div>
                        <div class="c--quiz-a__wrapper__bd c--quiz-a__wrapper__bd--second">
                            <h2 class="c--quiz-a__wrapper__bd__title">Thank you</h2>
                            <p class="c--quiz-a__wrapper__bd__text">Thank you for exploring your organization's AI readiness with us. We're looking forward to sharing what we've learned and how our AI expertise can help you take the next step.</p>
                        </div>
                    </fieldset>

                </form>

            </div>
        </div>

    </div>
</section>
