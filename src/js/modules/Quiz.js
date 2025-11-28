import Collapsify from "@terrahq/collapsify";
import { breakpoints } from "@terrahq/helpers/breakpoints";
import Gradient from "./HeroBg";
import confetti from "https://esm.sh/canvas-confetti@1";
import { getCookie } from "@jsModules/utilities/utilities.js";

class Quiz {

    constructor() {
        this.DOM = {
            quiz: document.querySelector(".js--quiz-a"),
            steps: null,
        };

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
        this.setupFieldValidation();
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

            if(isSubmit){
                this.submitForm()
                
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

    setupFieldValidation() {
        const fields = this.DOM.quiz.querySelectorAll("input, select, textarea");

        fields.forEach((field) => {
            field.addEventListener("blur", () => {
                this.validateField(field);
            });

            if (field.tagName === "SELECT") {
                field.addEventListener("change", () => {
                    this.validateField(field);
                });
            }
        });
    }

    validateField(field) {
        const formGroup = field.closest(".c--form-group-a");
        if (!formGroup) return;

        let errorSpan = formGroup.querySelector(".c--form-error-a");

        if (!errorSpan) {
            errorSpan = document.createElement("span");
            errorSpan.classList.add("c--form-error-a");
            errorSpan.style.display = "none";
            formGroup.appendChild(errorSpan);
        }

        if (!field.checkValidity()) {
            const customMessage = this.getCustomErrorMessage(field);
            errorSpan.textContent = customMessage || field.validationMessage;
            errorSpan.style.display = "block";
        } else {
            errorSpan.textContent = "";
            errorSpan.style.display = "none";
        }
    }

    getCustomErrorMessage(field) {
        if (field.validity.valueMissing) {
            if (field.id === "quiz-company") {
                return "Company name cannot be empty";
            }
            if (field.id === "quiz-email") {
                return "Email address cannot be empty";
            }
            if (field.id === "quiz-role") {
                return "Please select your role";
            }
            if (field.id === "quiz-industry") {
                return "Please select your industry";
            }
            if (field.id === "quiz-journey") {
                return "Please select where you are in your AI transformation journey";
            }
            return "This field is required";
        }

        if (field.validity.typeMismatch && field.type === "email") {
            return "Please enter a valid email address";
        }

        return null;
    }

    isStepValid(stepElement) {
        if (!stepElement) {
            return true;
        }

        const fields = stepElement.querySelectorAll("input, select, textarea");
        let isValid = true;
        let firstInvalid = null;

        fields.forEach((field) => {
            this.validateField(field);

            if (!field.checkValidity()) {
                isValid = false;
                if (!firstInvalid) {
                    firstInvalid = field;
                }
            }
        });

        if (!isValid && firstInvalid) {
            firstInvalid.focus();
        }

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

        if (progress === 100) {

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

            // Wait for the progress bar to finish the fill animation
            setTimeout(() => {
                myConfetti({
                    particleCount: 150,
                    spread: 60,
                    origin: {
                        x: originX,
                        y: originY
                    },
                    zIndex: 4
                });
            }, 300);
        }
    }

    /**
     * Submits the form to HubSpot using reCAPTCHA v3.
     * Steps:
     * 1) Load reCAPTCHA script
     * 2) Get client token
     * 3) Build HubSpot payload (including hutk cookie for contact attribution)
     * 4) Submit to HubSpot
     */
    async submitForm(){
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

        if(google_access_token){
            const hutk = getCookie("hubspotutk");

            const formData = new FormData(this.DOM.form);
            const formDataObject = Object.fromEntries(formData.entries());
            
            var payload = {
                portalId: "6210663",
                formId: "7bede634-3926-4c37-89a0-f351dd4b8f7b",
                formInputs: {
                    company: formDataObject.company ?? "",
                    email: formDataObject.email ?? "",
                    ai_form__what_is_your_role_: formDataObject.role ?? "",
                    ai_form__what_s_your_industry_ : formDataObject.industry ?? "",
                    ai_form__what_s_your_purpose_for_using_ai_ : formDataObject.purpose ?? "",
                    ai_form__where_are_you_in_your_ai_transformation_journey_ : formDataObject.journey ?? "",
                    ai_form__context : formDataObject.context ?? "",
                },
                context: {
                    hutk,                     // ✅ critical bit
                    pageUri: window.location.href,
                    pageName: document.title,
                },
            }
            
            console.log(payload);
            
            // try {
            //     const submissionResult = await submitToHubspot(payload);
            //     console.log(submissionResult.message);
            // } catch (error) {
            //     console.error("Submission error:", error.message);
            // }
        } else {
            console.log("Recaptcha Failed: " + res.message);
        }
    }

    destroy() {
        if (this.collapsify && typeof this.collapsify.destroy === "function") {
            this.collapsify.destroy();
        }
    }
}

export default Quiz;
