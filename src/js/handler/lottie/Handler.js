import { isElementInViewport } from "@terrahq/helpers/isElementInViewport";

class Handler {
    constructor(payload) {
        var { emitter, instances, boostify, terraDebug, libManager } = payload;
        this.boostify = boostify;
        this.emitter = emitter;
        this.instances = instances;
        this.terraDebug = terraDebug;
        this.libManager = libManager;

        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            elements: document.querySelectorAll(".js--lottie-element"),
        };
    }

    init() {}

    async initializeLottie({ element, index }) {
        const preloadLotties = window['lib']['Lottie'];
        this.instances["Lottie"][index] = await preloadLotties({
        selector: element,
        debug: this.terraDebug,
        callback: (payload) => {
            this.terraDebug && console.log("Lottie loaded", index, element, payload);
            payload.play();
        },
        });
    }


    events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;
            if (this.DOM.elements.length > 0) {
                this.instances["Lottie"] = [];
                
                if (!window['lib']['Lottie']) {
                    const { preloadLotties } = await import("@terrahq/helpers/preloadLotties");
                    window['lib']['Lottie'] = preloadLotties;
                }
                
                this.DOM.elements.forEach((element, index) => {
                    if (isElementInViewport({ el: element, debug: this.terraDebug })) {
                        this.initializeLottie({ element, index });
                    } else {
                        this.boostify.observer({
                            options: {
                            root: null,
                            rootMargin: "0px",
                            threshold: 0.5,
                            },
                            name: "Lottie",
                            element: element,
                            callback: async () => {
                                try {
                                    this.initializeLottie({ element, index });
                                } catch (error) {
                                    this.terraDebug && console.log("Error loading Lottie", error);
                                }
                            }
                        });
                    }
                });
            }
        });

        this.emitter.on("MitterWillReplaceContent", () => {
            this.DOM = this.updateTheDOM;
            this.boostify.destroyscroll({ distance: 10, name: "Lottie" });
            
            if (this.DOM?.elements?.length && this.instances["Lottie"]?.length) {
                this.DOM.elements.forEach((_, index) => {
                    if (this.instances["Lottie"][index]?.destroy) {
                        this.instances["Lottie"][index].destroy();
                    }
                });
                this.instances["Lottie"] = [];
            }
        });
    }
}

export default Handler;