import CoreHandler from "../CoreHandler";

class Handler extends CoreHandler {
    constructor(payload) {
        super(payload);

        this.callbacks = {
            onComplete: () => {
                // Update scroll triggers after collapsify is initialized
                updateScrollTriggers({ Manager: this.Manager });
            },
            onSlideEnd: (isOpen, contentID) => {
                // Update scroll triggers after collapsify slide ends
                updateScrollTriggers({ Manager: this.Manager });
            },
        };


        this.configAccordionB = ({element}) => {
            const closeOther = element.getAttribute("closeOthers") ? u_stringToBoolean(element.getAttribute("closeOthers")) : true;
            return {
                element,
                nameSpace: "accordion02",
                closeOthers: closeOther,
                animationSpeed: 400,
                cssEasing: "ease",
            };
        };
        this.configCollapse = ({element}) => {
            return {
                element,
                nameSpace: `collapsify`,
                closeOthers: false,
                onSlideStart: (isOpen, contentID) => {
                element.classList.add("u--display-none"),
                element.parentNode
                    .querySelector(".c--overlay-c")
                    .classList.add("u--display-none");
                },
            };
        };

        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            accordionElementsB: document.querySelectorAll(`.js--accordion-02`),
            collapseElements: document.querySelectorAll(`.js--collapse`),
        };
    }

    init() {
        super.getLibraryName("Collapsify");
    }

     events() {
        this.emitter.on("Collapsify:load", async () => {
            await super.assignInstances({
                elementGroups: [
                    {
                        elements: this.DOM.accordionElementsB,
                        config: this.configAccordionB,
                        boostify: { distance: 30 },
                    },
                    {
                        elements: this.DOM.collapseElements,
                        config: this.configCollapse,
                        boostify: { distance: 30 },
                    },
                ],
                forceLoad: true,
            });
        });

        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;
            await super.assignInstances({
                elementGroups: [
                    {
                        elements: this.DOM.accordionElementsB,
                        config: this.configAccordionB,

                        boostify: { distance: 30 },
                    },
                    {
                        elements: this.DOM.collapseElements,
                        config: this.configCollapse,
                        boostify: { distance: 30 },
                    },
                ],
            });
        });

        this.emitter.on("MitterWillReplaceContent", () => {
            if (this.DOM.accordionElementsB.length || this.DOM.collapseElements.length ) {
                super.destroyInstances();
            }
        });
    }
}

export default Handler;