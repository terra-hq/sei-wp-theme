import { breakpoints } from "@terrahq/helpers/breakpoints";
import Gradient from "../../modules/HeroBg";
import confetti from "https://esm.sh/canvas-confetti@1";
import { getCookie } from "@jsModules/utilities/utilities.js";
import Form from "./Form.js";
import FormConfigs from "./FormConfigs.js";

class Quiz {

    constructor() {
        this.DOM = {
            quiz: document.querySelector(".js--quiz-a"),
            steps: null,
        };

        this.form = null;
        this.progress = 0;

        if (this.DOM.quiz) {
            this.DOM.form = this.DOM.quiz.querySelector("form.hs-form");
            this.DOM.steps = this.DOM.quiz.querySelectorAll(".c--quiz-a__wrapper");
            this.DOM.progress = {
                wrapper: this.DOM.quiz.querySelector(".js--progressbar-wrapper"),
                item: this.DOM.quiz.querySelector(".js--progressbar-item"),
                text: this.DOM.quiz.querySelector(".js--progressbar-text"),
            };
            this.handleButtonClick = this.handleButtonClick.bind(this);
            this.init();
        }
    }

    init() {
        this.collapsify = new Collapsify({
            nameSpace: "tab",
            isTab: true,
            closeOthers: true,
        });

        this.attachButtonListeners();
        this.initForm();
        this.setProgressBar();

        let heroBg = document.querySelector("#gradient-canvas");
        if (heroBg) {
            const bk = breakpoints.reduce((target, inner) => Object.assign(target, inner), {});
            const viewport = window.innerWidth;
            if (viewport < bk.mobile) {
                return;
            }
            new Gradient().initGradient("#gradient-canvas");
        }
    }

    initForm() {
        this.form = new Form({
            element: this.DOM.form,
            fields: FormConfigs(),
            submitButtonSelector: ".c--quiz-a__wrapper__ft__btn[type='submit']",
            onComplete: async () => {
                this.showConfetti();
            },
            onSubmit: async (data) => {
                await this.submitForm({
                    data
                });
            },
            onError: (invalidFields) => {
                console.error("Form contains errors:", invalidFields);
            },
        });
    }

    attachButtonListeners() {
        const buttons = this.DOM.quiz.querySelectorAll(".c--quiz-a__wrapper__ft__btn, .c--quiz-a__wrapper__ft__link");

        buttons.forEach((button) => {
            button.addEventListener("click", this.handleButtonClick);
        });
    }

    async handleButtonClick(event) {
        event.preventDefault();
        
        const button = event.currentTarget;
        const currentStep = button.closest(".c--quiz-a__wrapper");

        if (!currentStep) {
            return;
        }

        const currentStepID = currentStep.getAttribute("data-tab-content");
        const isPrevious = button.classList.contains("c--quiz-a__wrapper__ft__link");
        const buttonText = button.textContent.trim().toLowerCase();
        const isSubmit = button.classList.contains("c--quiz-a__wrapper__ft__btn") && buttonText === "submit";
        const isNext = button.classList.contains("c--quiz-a__wrapper__ft__btn") && !isSubmit && !isPrevious;

        if (isNext || isSubmit) {
            const isValid = this.isStepValid(currentStep);
            
            if (!isValid) {
                return;
            }
        }

        let targetStepID = null;

        if (isNext || isSubmit) {
            const currentStepIndex = Array.from(this.DOM.steps).indexOf(currentStep);
            const nextStep = this.DOM.steps[currentStepIndex + 1];
            
            if (nextStep) {
                targetStepID = nextStep.getAttribute("data-tab-content");
            }
        } else if (isPrevious) {
            const currentStepIndex = Array.from(this.DOM.steps).indexOf(currentStep);
            const previousStep = this.DOM.steps[currentStepIndex - 1];
            
            if (previousStep) {
                targetStepID = previousStep.getAttribute("data-tab-content");
            }
        }

        if (targetStepID) {
            this.collapsify.close(currentStepID, true, true);
            this.collapsify.open(targetStepID, true, true);
            const upcomingStep = Array.from(this.DOM.steps).find(
                (step) => step.getAttribute("data-tab-content") === targetStepID
            );
            this.setProgressBar(upcomingStep);
        }
    }

    isStepValid(stepElement) {
        if (!stepElement) {
            return true;
        }

        const fields = stepElement.querySelectorAll("input, select, textarea");
        let isValid = true;

        fields.forEach((field) => {
            let fieldToValidate = this.form.fields.find((f) => f.element === field);
            if(fieldToValidate) {
                let result = this.form.validateField(fieldToValidate);
                if(!result.isValid) {
                    isValid = false;
                    return isValid;
                }
            }
        });
        return isValid;
    }

    setProgressBar(targetStep = null) {
        const steps = Array.from(this.DOM.steps || []);

        if (!steps.length || !this.DOM.progress) {
            return;
        }

        let activeStep = targetStep;

        if (!activeStep) {
            activeStep = this.DOM.quiz.querySelector(".c--quiz-a__wrapper--is-active") || steps[0];
        }

        const activeIndex = steps.indexOf(activeStep);

        if (activeIndex === -1) {
            return;
        }

        const progress = steps.length === 1 ? 100 : (activeIndex / (steps.length - 1)) * 100;

        if (this.DOM.progress.wrapper) {
            this.DOM.progress.wrapper.setAttribute("aria-valuenow", progress);
        }

        if (this.DOM.progress.item) {
            this.DOM.progress.item.style.width = progress + "%";
        }

        if (this.DOM.progress.text) {
            this.DOM.progress.text.textContent = Math.round(progress) + "%";
        }
    }

    showConfetti() {
        // Get the position of the progress bar text
        const formRect = this.DOM.form.getBoundingClientRect();
        const originX = (formRect.left + formRect.width / 2) / window.innerWidth;
        const originY = Math.min(1, Math.max(0, (formRect.bottom + 200) / window.innerHeight));

        const myCanvas = document.createElement('canvas');
        myCanvas.classList.add("c--quiz-a__artwork");
        this.DOM.form.appendChild(myCanvas);

        const myConfetti = confetti.create(myCanvas, {
            resize: true,
            useWorker: false
        });

        const confettiColors = [
            '#fffff8', // $color-a
            '#141018', // $color-b
            '#f01840', // $color-c
            '#c01830', // $color-d
            '#901226', // $color-e
            '#600c1c', // $color-f
            '#300810', // $color-g
            '#d0c8c8', // $color-h
            '#a0949e', // $color-i
            '#705e74', // $color-j
            '#402848', // $color-k
            '#2a1c30'  // $color-l
        ];

        // Wait for the progress bar to finish the fill animation
        setTimeout(() => {
            myConfetti({
                particleCount: 150,
                spread: 60,
                origin: {
                    x: originX,
                    y: originY
                },
                colors: confettiColors,
                zIndex: 4
            });
        }, 300);

    }

    /**
     * Submits the form to HubSpot using reCAPTCHA v3.
     * Steps:
     * 1) Load reCAPTCHA script
     * 2) Get client token
     * 3) Build HubSpot payload (including hutk cookie for contact attribution)
     * 4) Submit to HubSpot
     */
    async submitForm({data}){
        const { submitToHubspot } = await import("@terrahq/helpers/hubspot");
        const { GET_RECAPTCHA_SCRIPT_FROM_GOOGLE, GET_RECAPTCHA_CLIENT_TOKEN } = await import("@terrahq/helpers/recaptcha");

        const publicKey = "6Lc7khosAAAAAMejjgAgi198Ou3YPMluxtocfRQR";
        const loadRecaptchaScript = await GET_RECAPTCHA_SCRIPT_FROM_GOOGLE({
            API_KEY: publicKey,
        });
        const google_access_token = await GET_RECAPTCHA_CLIENT_TOKEN({
            API_KEY: publicKey,
            action: "submit",
        });

        const resp = await fetch(`${base_wp_api.root_url}/wp-json/acf/v2/options`);
        const acfData = await resp.json();
        var hubspotPortalId = acfData?.acf?.form_portal_id || null;
        var hubspotForm = "7bede634-3926-4c37-89a0-f351dd4b8f7b"|| null;
        if(google_access_token){
            const hutk = getCookie("hubspotutk");
            var payload = {
                portalId: hubspotPortalId,
                formId: hubspotForm,
                formInputs: {
                    company: data.quizCompany ?? "",
                    email: data.quizEmail ?? "",
                    ai_form__what_is_your_role_: data.quizRole ?? "",
                    ai_form__what_s_your_industry_ : data.quizIndustry ?? "",
                    ai_form__what_s_your_purpose_for_using_ai_ : data.quizPurpose ?? "",
                    ai_form__where_are_you_in_your_ai_transformation_journey_ : data.quizJourney ?? "",
                    ai_form__context : data.quizMessage ?? "",
                },
                context: {
                    hutk, 
                    pageUri: window.location.href,
                    pageName: document.title,
                },
            }
            
            try {
                const submissionResult = await submitToHubspot(payload);
                // console.log(submissionResult.message);
            } catch (error) {
                console.error("Submission error:", error.message);
            }
        } else {
            console.log("Recaptcha Failed: " + res.message);
        }
    }

    destroy() {
        if (this.collapsify && typeof this.collapsify.destroy === "function") {
            this.collapsify.destroy();
        }
        if (this.form && typeof this.form.destroy === "function") {
            this.form.destroy();
        }
    }
}

export default Quiz;
