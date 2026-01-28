class Handler {
    constructor(payload) {
        var { emitter, instances, boostify, terraDebug, libManager } = payload;
        this.boostify = boostify;
        this.emitter = emitter;
        this.instances = instances;
        this.terraDebug = terraDebug;
        this.libManager = libManager;

        this.DOM = {
            elements: document.querySelectorAll(".js--inyect-cookie"),
        }

        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            elements: document.querySelectorAll(".js--inyect-cookie"),
        };
    }

    init() {
        if (this.DOM.elements.length) {
            this.instances["Cookies"] = [];
            this.DOM.elements.forEach((element, index) => {
                this.initializeCookies(element, index);
            });
        }
    }

    async initializeCookies(element, index) {
        if (this.instances["Cookies"][index]) {
            return;
        }

        try {
            const { default: Cookies } = await import("@js/handler/cookies/SetCookies");
            this.instances["Cookies"][index] = new Cookies({
                cookieContainer: element,
            });
        } catch (error) {
            console.error("Error loading SetCookies module:", error);
        }
    }

    events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;
            this.init();
        });
        this.emitter.on("MitterWillReplaceContent", () => {
            this.DOM = this.updateTheDOM;
            if (this.DOM?.elements?.length && this.instances["Cookies"]?.length) {
                this.DOM.elements.forEach((_, index) => {
                    if (this.instances["Cookies"][index]?.destroy) {
                        this.instances["Cookies"][index].destroy();
                    }
                });
                this.instances["Cookies"] = [];
            }
        });
    }
}

export default Handler;
