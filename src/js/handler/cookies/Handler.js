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
            cookieContainer: document.querySelector(".js--inyect-cookie"),
        };
    }

    init() {}

    initializeSetCookies() {
        const SetCookies = window['lib']['SetCookies'];
        this.instances["SetCookies"] = new SetCookies({
            cookieContainer: this.DOM.cookieContainer,
        });
    }

    events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;
            if (this.DOM.cookieContainer) {
                if (!window['lib']['SetCookies']) {
                    const { default: SetCookies } = await import("@jsHandler/cookies/SetCookies");
                    window['lib']['SetCookies'] = SetCookies;
                }
                this.initializeSetCookies();
            }
        });

        this.emitter.on("MitterWillReplaceContent", () => {
            if (this.instances["SetCookies"]?.destroy) {
                this.instances["SetCookies"].destroy();
            }
            this.instances["SetCookies"] = null;
        });
    }
}

export default Handler;