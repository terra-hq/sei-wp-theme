import { isElementInViewport } from "@terrahq/helpers/isElementInViewport";

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
            this.DOM.elements.forEach((element, index) => {
                if (isElementInViewport({ el: element, debug: this.terraDebug })) {
                    this.initializeHeroScroll(element, index);
                } else {
                    this.boostify.observer({
                        options: {
                            root: null,
                            rootMargin: "0px",
                            threshold: 0.5,
                        },
                        element: element,
                        callback: () => {
                            this.initializeHeroScroll(element, index);
                        },
                    });
                }
            });
        }
    }

    async initializeHeroScroll(element, index) {
        import("@jsModules/HeroScroll")
        .then(({ default: HeroScroll }) => {
            window["lib"]["HeroScroll"] = HeroScroll;
            this.instances["HeroScroll"][index] = new window["lib"]["HeroScroll"]({
                element: element,
            });
        }).catch((error) => {
            console.error("Error loading HeroScroll module:", error);
        });
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
