import CoreHandler from "../CoreHandler";

class Handler extends CoreHandler {
    constructor(payload) {
        super(payload);

        this.config = ({element}) => {
            return {
                trigger: element,
                destination: document.getElementById(element.getAttribute('tf-data-target')),
                offset: element.getAttribute('tf-data-distance'),
                url: "none",
                eventSystem: this.eventSystem,
            };
        };

        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            anchorElements: document.querySelectorAll(`.js--scroll-to`),
        };
    }

    init() {
        super.getLibraryName("AnchorTo");
    }

    events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;

            super.assignInstances({
                elementGroups: [
                    {
                        elements: this.DOM.anchorElements,
                        config: this.config,
                        boostify: { distance: 30 },
                    },
                ],
            });
        });

        this.emitter.on("MitterWillReplaceContent", () => {
            if (this.DOM.anchorElements.length) {
                super.destroyInstances();
            }
        });
    }
}

export default Handler;
