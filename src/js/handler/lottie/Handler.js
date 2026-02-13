import CoreHandler from "../CoreHandler";

class Handler extends CoreHandler {
    constructor(payload) {
        super(payload);
        this.initialized = false;
        this.config = ({element}) => {
        };

        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            elements: document.querySelectorAll(`.js--lottie-element`),
            elementA: document.querySelectorAll(`.js--lottie-element-a`),
        };
    }

    init() {
        super.getLibraryName("Lotties");
    }

    events() {
        this.emitter.on("Lottie:load", async () => {
            this.DOM = this.updateTheDOM;
            if (this.initialized === false) {
                super.assignInstances({
                    elementGroups: [
                    {
                        elements: this.DOM.elements,
                        config: this.config,
                        boostify: { distance: 30 },
                    },
                    ],
                })
            }
        });
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;

            if (this.initialized === false) {
                super.assignInstances({
                    elementGroups: [
                    {
                        elements: this.DOM.elements,
                        config: this.config,
                        boostify: { distance: 30 },
                    },
                    ],
                })
            }
            if (this.DOM.elementA.length) {
                this.DOM.elementA.forEach((element) => {
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
                                 super.assignInstances({
                                    elementGroups: [
                                    {
                                        elements: this.DOM.elementA,
                                        config: this.config,
                                    },
                                    ],
                                })
                                this.initialized = true;
                            }
                        }
                    })
                })
            }
        });



        this.emitter.on("MitterWillReplaceContent", () => {
            if (this.DOM.elements.length || this.DOM.elementA.length) {
                super.destroyInstances();
            }
        });
    }
}

export default Handler;