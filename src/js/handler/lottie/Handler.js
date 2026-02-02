import { isElementInViewport } from "@terrahq/helpers/isElementInViewport";

class Handler {
    constructor(payload) {
        var { emitter, instances, boostify, terraDebug, libManager } = payload;
        this.boostify = boostify;
        this.emitter = emitter;
        this.instances = instances;
        this.terraDebug = terraDebug;
        this.libManager = libManager;
        this.initialized = false;

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
        const Lottie = window["lib"]["Lottie"];
        this.instances["Lottie"][index] = new Lottie({ element });
    }

    events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;
            if (this.DOM.elements.length > 0) {
                this.instances["Lottie"] = [];

                if (!window["lib"]["Lottie"]) {
                    const { default: Lottie } = await import("@jsHandler/lottie/Lotties");
                    window["lib"]["Lottie"] = Lottie;
                }

                this.DOM.elements.forEach((element, index) => {
                    if (isElementInViewport({ el: element, debug: this.terraDebug })) {
                        if (this.initialized == false) {
                            this.initialized = true;
                            this.initializeLottie({ element, index });
                        }
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
                                if (this.initialized == false) {
                                    try {
                                        this.initialized = true;
                                        this.initializeLottie({ element, index });
                                    } catch (error) {
                                        this.terraDebug && console.log("Error loading Lottie", error);
                                    }
                                }
                            },
                        });
                    }
                });
            }
            this.initialized = false;
        });

        this.emitter.on("Lottie:load", async () => {
            this.DOM = this.updateTheDOM;
            if (this.initialized === false) {
                if (this.DOM.elements.length > 0) {
                    this.instances["Lottie"] = [];

                    if (!window["lib"]["Lottie"]) {
                        const { default: Lottie } = await import("@jsHandler/lottie/Lotties");
                        window["lib"]["Lottie"] = Lottie;
                    }
                    this.DOM.elements.forEach((element, index) => {
                        this.initializeLottie({ element, index });
                        this.initialized = true;
                    });
                }
            }
        });

        this.emitter.on("MitterWillReplaceContent", () => {
            this.DOM = this.updateTheDOM;
            
            if (this.DOM?.elements?.length && this.instances["Lottie"]?.length) {
                this.boostify.destroyobserver({ distance: 10, name: "Lottie" });
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
