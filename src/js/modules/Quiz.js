import Collapsify from "@terrahq/collapsify";

class Quiz {

    constructor(payload) {
        this.DOM = {
            quiz: document.querySelector(".js--quiz-a"),
            steps: null,
            buttons: null,
        };

        this.handleButtonClick = this.handleButtonClick.bind(this);

        if (this.DOM.quiz) {
            this.DOM.form = this.DOM.quiz.querySelector("form.hs-form");
            this.DOM.steps = this.DOM.quiz.querySelectorAll(".c--quiz-a");
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
    }

    attachButtonListeners() {
        const buttons = this.DOM.quiz.querySelectorAll(".c--quiz-a__bd__ft__btn, .c--quiz-a__bd__ft__link");

        buttons.forEach((button) => {
            button.addEventListener("click", this.handleButtonClick);
        });
    }

    handleButtonClick(event) {
        event.preventDefault();
        
        const button = event.currentTarget;
        const currentStep = button.closest(".c--quiz-a");

        if (!currentStep) {
            return;
        }

        const currentStepID = currentStep.getAttribute("data-tab-content");
        const isPrevious = button.classList.contains("c--quiz-a__bd__ft__link");
        const buttonText = button.textContent.trim().toLowerCase();
        const isSubmit = button.classList.contains("c--quiz-a__bd__ft__btn") && buttonText === "submit";
        const isNext = button.classList.contains("c--quiz-a__bd__ft__btn") && !isSubmit && !isPrevious;

        if (isNext || isSubmit) {
            const isValid = this.isStepValid(currentStep);
            
            if (!isValid) {
                return;
            }
        }

        if (isSubmit) {
            if (this.DOM.form) {
                this.DOM.form.submit();
            }
            return;
        }

        let targetStepID = null;

        if (isNext) {
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

    isStepValid(stepElement) {
        if (!stepElement) {
            return true;
        }

        const fields = stepElement.querySelectorAll("input, select, textarea");
        let isValid = true;
        let firstInvalid = null;

        fields.forEach((field) => {
            if (!field.checkValidity()) {
                isValid = false;
                if (!firstInvalid) {
                    firstInvalid = field;
                }
            }
        });

        if (!isValid && firstInvalid) {
            firstInvalid.reportValidity();
        }

        return isValid;
    }

    destroy() {
        if (this.collapsify && typeof this.collapsify.destroy === "function") {
            this.collapsify.destroy();
        }
    }
}

export default Quiz;
