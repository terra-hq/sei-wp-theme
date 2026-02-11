import CoreHandler from "../CoreHandler";

class Handler extends CoreHandler {
    constructor(payload) {
        super(payload);

        this.config = ({element}) => {
            return {
                element,
                hero: element.getAttribute("data-hero"),
            };
        };

        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            elements: document.querySelectorAll(`.js--zoom-b`),
        };
    }

    init() {
        super.getLibraryName("ZoomScroll");
    }

    events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;

            super.assignInstances({
                elementGroups: [
                    {
                        elements: this.DOM.elements,
                        config: this.config,
                        boostify: { distance: 30 },
                    },
                ],
            });
        });

        this.emitter.on("MitterWillReplaceContent", () => {
            if (this.DOM.elements.length) {
                super.destroyInstances();
            }
        });
    }
}

export default Handler;
