class AccordionB {
    constructor(element) {
        this.accordion = element;
        // DOM references
        this.DOM = {
            header: this.accordion.querySelector(".c--accordion-b__hd"),
            button: this.accordion.querySelector(".c--accordion-b__hd__btn"),
        };

        if (this.accordion) {
            this.init();
        }
    }

    init() {
        // Bind the event handler to maintain the correct 'this' context
        this.toggleAccordion = this.toggleAccordion.bind(this);

        // Add click event listener to the button
        this.DOM.header.addEventListener("click", this.toggleAccordion);
    }

    toggleAccordion() {
        // Toggle the 'c--accordion-b--is-active' class on the accordion element
        this.accordion.classList.toggle("c--accordion-b--is-active");
    }

    destroy() {
        // Remove the event listener when the component is destroyed
        this.DOM.header.removeEventListener("click", this.toggleAccordion);
    }
}

export default AccordionB;
