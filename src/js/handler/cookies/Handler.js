import CoreHandler from "../CoreHandler";

class Handler extends CoreHandler {
    constructor(payload) {
        super(payload);

        this.config = ({element}) => ({
            cookieContainer: element,
        });

        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            cookieContainer: document.querySelectorAll(`.js--inyect-cookie`),
        };
    }

    init() {
        super.getLibraryName("SetCookies");
    }

    events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;

            super.assignInstances({
                elementGroups: [
                    {
                        elements: this.DOM.cookieContainer,
                        config: this.config,
                    },
                ],
            });
        });

        this.emitter.on("MitterWillReplaceContent", () => {
            if (this.DOM?.cookieContainer?.length) {
                super.destroyInstances();
            }
        });
    }
}

export default Handler;
