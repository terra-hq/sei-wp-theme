import { isElementInViewport } from "@terrahq/helpers/isElementInViewport";
import { u_stringToBoolean } from '@andresclua/jsutil';
class Handler {
    constructor(payload) {
        var {boostify, emitter, instances, terraDebug} = payload;
        this.boostify = boostify;
        this.emitter = emitter;
        this.instances = instances;
        this.terraDebug = terraDebug;
        this.init();
        this.events();
    }

    init() {}

    get updateTheDOM() {
        return {
          accordionElementsA: document.querySelectorAll(`.c--accordion-a`),
          accordionElementsB: document.querySelectorAll(`.js--accordion-02`),
          collapseElements: document.querySelectorAll(`.js--collapse`),
        };
    }

    createInstanceAccordionA({element, index}) {
        const Accordion = window['lib']['CollapsifyA'];
        this.instances["CollapsifyA"][index] = new Accordion({});
    }

    createInstanceAccordionB({element, index}) {
        const Accordion = window['lib']['Collapsify'];
        const closeOther = element.getAttribute("closeOthers") ? u_stringToBoolean(element.getAttribute("closeOthers")) : true;
        this.instances["Collapsify"][index] = new Accordion({
            nameSpace: "accordion02",
            index: index,
            closeOthers: closeOther,
            animationSpeed: 400,
            cssEasing: "ease",
        });
    }

    createInstanceCollapse({element, index}) {
        const Collapse = window['lib']['Collapse'];
        this.instances["Collapse"][index] = new Collapse({
            nameSpace: `collapsify`,
            closeOthers: false,
            onSlideStart: (isOpen, contentID) => {
                element.classList.add("u--display-none"),
                element.parentNode
                    .querySelector(".c--overlay-c")
                    .classList.add("u--display-none");
            },
        });
    }

    events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;

            if (this.DOM.accordionElementsA.length > 0) {
                this.instances["CollapsifyA"] = [];
                if (!window['lib']['CollapsifyA']) {
                    const { default: Collapsify } = await import ("@jsHandler/collapsify/AccordionA");
                    window['lib']['CollapsifyA'] = Collapsify;
                }
                this.DOM.accordionElementsA.forEach((element, index) => {
                    if (isElementInViewport({ el: element, debug: this.terraDebug})) {
                        this.createInstanceAccordionA({ element, index });
                    } else {
                        this.boostify.scroll({
                            distance: 10,
                            name: "CollapsifyA",
                            callback: async () => {
                                try {
                                    this.createInstanceAccordionA({ element, index });
                                } catch (error) {
                                    this.terraDebug && console.log("Error loading Collapsify", error);
                                }
                            }
                        });
                    }
                })
            }

            if (this.DOM.accordionElementsB.length > 0) {
                this.instances["Collapsify"] = [];
                if (!window['lib']['Collapsify']) {
                    const { default: Collapsify } = await import ("@terrahq/collapsify");
                    window['lib']['Collapsify'] = Collapsify;
                }
                this.DOM.accordionElementsB.forEach((element, index) => {
                    if (isElementInViewport({ el: element, debug: this.terraDebug})) {
                        this.createInstanceAccordionB({ element, index });
                    } else {
                        this.boostify.scroll({
                            distance: 10,
                            name: "Collapsify",
                            callback: async () => {
                                try {
                                    this.createInstanceAccordionB({ element, index });
                                } catch (error) {
                                    this.terraDebug && console.log("Error loading Collapsify", error);
                                }
                            }
                        });
                    }
                })
            }

            if (this.DOM.collapseElements.length > 0) {
                this.instances["Collapse"] = [];
                if (!window['lib']['Collapse']) {
                    const { default: Collapse } = await import("@terrahq/collapsify");
                    window['lib']['Collapse'] = Collapse;
                }
                this.DOM.collapseElements.forEach((element, index) => {
                    if (isElementInViewport({ el: element, debug: this.terraDebug})) {
                        this.createInstanceCollapse({ element, index });
                    } else {
                        this.boostify.scroll({
                            distance: 10,
                            name: "Collapse",
                            callback: async () => {
                                try {
                                    this.createInstanceCollapse({ element, index });
                                } catch (error) {
                                    this.terraDebug && console.log("Error loading Collapse", error);
                                }
                            }
                        });
                    }
                });
            }
        });

        this.emitter.on("MitterWillReplaceContent", () => {
            this.DOM = this.updateTheDOM;

            //Destroy Accordion
            if(this.DOM?.accordionElementsA?.length && this.instances["CollapsifyA"]?.length) {
                this.boostify.destroyscroll({ distance: 10, name: "CollapsifyA"});

                this.DOM.accordionElementsA.forEach((_, index) => {
                    if (this.instances["CollapsifyA"][index]) {
                        this.instances["CollapsifyA"][index].destroy();
                    }
                });
                this.instances["CollapsifyA"] = [];
            }

            if(this.DOM?.accordionElementsB?.length && this.instances["Collapsify"]?.length) {
                this.boostify.destroyscroll({ distance: 10, name: "Collapsify"});

                this.DOM.accordionElementsB.forEach((_, index) => {
                    if (this.instances["Collapsify"][index]) {
                        this.instances["Collapsify"][index].destroy();
                    }
                });
                this.instances["Collapsify"] = [];
            }
            
            if(this.DOM?.collapseElements?.length && this.instances["Collapse"]?.length) {
                this.boostify.destroyscroll({ distance: 10, name: "Collapse"});

                this.DOM.collapseElements.forEach((_, index) => {
                    if (this.instances["Collapse"][index]) {
                        this.instances["Collapse"][index].destroy();
                    }
                });
                this.instances["Collapse"] = [];
            }
        });
    }
}
export default Handler;