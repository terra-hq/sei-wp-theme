import { isElementInViewport } from "@terrahq/helpers/isElementInViewport";
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
          accordionElementsB: document.querySelectorAll(`.js--accordion-b`),
          accordionElementsC: document.querySelectorAll(`.js--accordion-02`),
        };
    }
    createInstanceAccordionA({element, index}) {
        const Accordion = window['lib']['CollapsifyA'];
        this.instances["CollapsifyA"][index] = new Accordion({});
    }
    createInstanceAccordionB({element, index}) {
        const Accordion = window['lib']['CollapsifyB'];
        this.instances["CollapsifyB"][index] = new Accordion(element);
    }
    createInstanceAccordionC({element, index}) {
        const Accordion = window['lib']['Collapsify'];
        this.instances["Collapsify"][index] = new Accordion({
            nameSpace: "accordion02",
            index: index,
            closeOthers: true,
            animationSpeed: 400,
            cssEasing: "ease",
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
                this.instances["CollapsifyB"] = [];
               
                if (!window['lib']['CollapsifyB']) {
                    const { default: Collapsify } = await import ("@jsHandler/collapsify/AccordionB");
                    window['lib']['CollapsifyB'] = Collapsify;
                }
                this.DOM.accordionElementsB.forEach((element, index) => {
                    if (isElementInViewport({ el: element, debug: this.terraDebug})) {
                        this.createInstanceAccordionB({ element, index });
                    } else {
                        this.boostify.scroll({
                            distance: 10,
                            name: "CollapsifyB",
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
            if (this.DOM.accordionElementsC.length > 0) {
                this.instances["Collapsify"] = [];
                if (!window['lib']['Collapsify']) {
                    const { default: Collapsify } = await import ("@terrahq/collapsify");
                    window['lib']['Collapsify'] = Collapsify;
                }
                this.DOM.accordionElementsC.forEach((element, index) => {
                    if (isElementInViewport({ el: element, debug: this.terraDebug})) {
                        this.createInstanceAccordionC({ element, index });
                    } else {
                        this.boostify.scroll({
                            distance: 10,
                            name: "Collapsify",
                            callback: async () => {
                                try {
                                    this.createInstanceAccordionC({ element, index });
                                } catch (error) {
                                    this.terraDebug && console.log("Error loading Collapsify", error);
                                }
                            }
                        });
                    }
                })
            }
        });
        this.emitter.on("MitterWillReplaceContent", () => {
            this.DOM = this.updateTheDOM;

            //Destroy Accordion
            if(this.DOM?.accordionElementsA?.lenght && this.instances["CollapsifyA"]?.lenght) {
                this.boostify.destroyscroll({ distance: 10, name: "CollapsifyA"});

                this.DOM.accordionElementsA.forEach((_, index) => {
                    if (this.instances["CollapsifyA"][index]) {
                        this.instances["CollapsifyA"][index].destroy();
                    }
                });
                this.instances["CollapsifyA"] = [];
            }
            if(this.DOM?.accordionElementsA?.lenght && this.instances["CollapsifyB"]?.lenght) {
                this.boostify.destroyscroll({ distance: 10, name: "CollapsifyB"});

                this.DOM.accordionElementsA.forEach((_, index) => {
                    if (this.instances["CollapsifyB"][index]) {
                        this.instances["CollapsifyB"][index].destroy();
                    }
                });
                this.instances["CollapsifyB"] = [];
            }
            if(this.DOM?.accordionElementsC?.lenght && this.instances["Collapsify"]?.lenght) {
                this.boostify.destroyscroll({ distance: 10, name: "Collapsify"});

                this.DOM.accordionElementsC.forEach((_, index) => {
                    if (this.instances["Collapsify"][index]) {
                        this.instances["Collapsify"][index].destroy();
                    }
                });
                this.instances["Collapsify"] = [];
            }
        })
    }
}
export default Handler;