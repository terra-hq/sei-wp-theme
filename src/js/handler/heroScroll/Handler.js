import CoreHandler from "../CoreHandler";

class Handler extends CoreHandler {
    constructor(payload) {
        super(payload);

        this.config = ({element}) => ({
            zoomContainer: element,
            Manager: this.Manager,
        });

        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            zoomContainer: document.querySelectorAll(`.js--zoom`),
        };
    }

    init() {
        super.getLibraryName("HeroScroll");
    }

    events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;

            super.assignInstances({
                elementGroups: [
                    {
                        elements: this.DOM.zoomContainer,
                        config: this.config,
                    },
                ],
            });
        });

        this.emitter.on("MitterWillReplaceContent", () => {
            if (this.DOM?.zoomContainer?.length) {
                super.destroyInstances();
            }
        });
    }
}

export default Handler;
