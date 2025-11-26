import Collapsify from "@terrahq/collapsify";
import { breakpoints } from "@terrahq/helpers/breakpoints";
import Gradient from "./HeroBg";
import confetti from "https://esm.sh/canvas-confetti@1";

class Quiz {

    constructor(payload) {
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

    handleButtonClick(event) {
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
            const progressBarRect = this.DOM.progress.text.getBoundingClientRect();
            const originX = (progressBarRect.left + progressBarRect.width / 2) / window.innerWidth;
            const originY = (progressBarRect.top + progressBarRect.height / 2) / window.innerHeight;

            // Wait for the progress bar to finish the fill animation
            setTimeout(() => {
                confetti({
                    particleCount: 150,
                    spread: 60,
                    origin: {
                        x: originX,
                        y: originY
                    }
                });
            }, 300);
        }
    }

    destroy() {
        if (this.collapsify && typeof this.collapsify.destroy === "function") {
            this.collapsify.destroy();
        }
    }
}

export default Quiz;
