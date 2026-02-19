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


        this.configAccordionA = ({element}) => {
            return {
                onComplete: ({element}) => {
                    if(element.querySelector('.js--lottie-element')){
                        this.eventSystem.loadEvent({library: 'Lotties', where: 'AccordionA'});
                    }
                }
            };
        };

        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            accordionElementsA: document.querySelectorAll(`.c--accordion-a`),
        };
    }

    init() {
        super.getLibraryName("AccordionA");
    }

     events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;
            await super.assignInstances({
                elementGroups: [
                    {
                        elements: this.DOM.accordionElementsA,
                        config: this.configAccordionA,
                        boostify: { distance: 30 },
                    },
                ],
            });
        });

        this.emitter.on("MitterWillReplaceContent", () => {
            if (this.DOM.accordionElementsA.length) {
                super.destroyInstances();
            }
        });
    }
}

export default Handler;