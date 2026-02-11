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
        });

        this.emitter.on("MitterWillReplaceContent", () => {
            if (this.DOM.elements.length) {
                super.destroyInstances();
            }
        });
    }
}

export default Handler;