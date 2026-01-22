class Handler {
    constructor(payload) {
        var { emitter, instances, boostify, terraDebug, libManager } = payload;
        this.boostify = boostify;
        this.emitter = emitter;
        this.instances = instances;
        this.terraDebug = terraDebug;
        this.libManager = libManager;

        this.DOM = {
            elements: document.querySelectorAll(".js--zoom"),
        }

        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            elements: document.querySelectorAll(".js--zoom"),
        };
    }

    init() {
        if (this.DOM.elements.length) {
            this.instances["HeroScroll"] = [];
            this.boostify.scroll({
                distance: 1,
                name: "HeroScroll",
                callback: async () => {
                    const { default: HeroScroll } = await import("@jsModules/HeroScroll");
                    window["lib"]["HeroScroll"] = HeroScroll;
                    this.DOM.elements.forEach((element, index) => {
                        this.instances["HeroScroll"][index] = new window["lib"]["HeroScroll"]({
                            element: element,
                        });
                    });
                },
            });
        }
    }

    events() {
        this.emitter.on("MitterWillReplaceContent", () => {
            this.destroy();
        });
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;
            this.init();
        });
    }

    destroy() {
        if (
            this.DOM.elements.length &&
            this.instances["HeroScroll"] &&
            this.instances["HeroScroll"].length
        ) {
            this.boostify.destroyscroll({ distance: 1, name: "HeroScroll" });
            this.DOM.elements.forEach((element, index) => {
                if (this.instances["HeroScroll"][index]) {
                    this.instances["HeroScroll"][index].destroy();
                }
            });
            this.instances["HeroScroll"] = [];
        }
    }
}

export default Handler;
