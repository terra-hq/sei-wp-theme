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
            elements: document.querySelectorAll(".js--zoom-b"),
        }

        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            elements: document.querySelectorAll(".js--zoom-b"),
        };
    }

    init() {
        if (this.DOM.elements.length) {
            this.instances["ZoomScroll"] = [];
            this.DOM.elements.forEach((element, index) => {
                if (isElementInViewport(element)) {
                    this.initializeZoomScroll(element, index);
                } else {
                    this.boostify.observer({
                        options: {
                            root: null,
                            rootMargin: "0px",
                            threshold: 0.5,
                        },
                        element: element,
                        callback: () => {
                            this.initializeZoomScroll(element, index);
                        },
                    });
                }
            });
        }
    }

    async initializeZoomScroll(element, index) {
        import("@jsModules/ZoomScroll")
        .then(({ default: ZoomScroll }) => {
            window["lib"]["ZoomScroll"] = ZoomScroll;
            this.instances["ZoomScroll"][index] = new window["lib"]["ZoomScroll"]({
                element: element,
                hero: element.getAttribute("data-hero") || false,
            });
        })
        .catch((error) => {
            console.error("Error loading ZoomScroll module:", error);
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
            Array.isArray(this.instances["ZoomScroll"]) &&
            this.instances["ZoomScroll"].length
        ) {
            this.boostify.destroyscroll({ distance: 5, name: "ZoomScroll" });
            this.DOM.elements.forEach((element, index) => {
                if (this.instances["ZoomScroll"][index]) {
                    this.instances["ZoomScroll"][index].destroy();
                }
            });
            this.instances["ZoomScroll"] = [];
        }
    }
}

export default Handler;
