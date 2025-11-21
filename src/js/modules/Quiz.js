import Collapsify from "@terrahq/collapsify";

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

    setProgressBar() {
        const steps = Array.from(this.DOM.steps);

        steps.forEach((step) => {
            const stepIndex = steps.indexOf(step);
            const progress = (stepIndex / (steps.length - 1)) * 100;
            step.querySelector(".js--progressbar-wrapper").setAttribute("aria-valuenow", progress);
            step.querySelector(".js--progressbar-item").style.width = progress + "%";
            step.querySelector(".js--progressbar-text").textContent = Math.round(progress) + "%";
        });
    }

    destroy() {
        if (this.collapsify && typeof this.collapsify.destroy === "function") {
            this.collapsify.destroy();
        }
    }
}

export default Quiz;
