import { isElementInViewport } from "@terrahq/helpers/isElementInViewport";
// ZoomScroll and ZoomScroll use the same library so maybe they can use the same handler
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
            elements: document.querySelectorAll(".js--zoom-b"),
        };
    }

    init() {}

    initializeZoomScroll({element, index}) {
        const ZoomScroll = window['lib']['ZoomScroll'];
        this.instances["ZoomScroll"][index] = new ZoomScroll({
            element: element,
            hero: element.getAttribute("data-hero"),
        });
    }

    events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;
            if (this.DOM.elements.length) {
            this.instances["ZoomScroll"] = [];
            if (!window['lib']['ZoomScroll']) {
                    const { default: ZoomScroll } = await import ("@jsHandler/zoomScroll/zoomScroll");
                    window['lib']['ZoomScroll'] = ZoomScroll;
            }
            this.DOM.elements.forEach((element, index) => {
                if (isElementInViewport({ el: element, debug: this.terraDebug })) {
                    this.initializeZoomScroll({element, index});
                } else {
                    this.boostify.scroll({
                        distance: 300,
                        name: "ZoomScroll",
                        callback: () => {
                            this.initializeZoomScroll({element, index});
                        },
                    });
                }
            });
        }
           
        });
           this.emitter.on("MitterWillReplaceContent", () => {
            this.DOM = this.updateTheDOM;
            this.boostify.destroyscroll({ distance: 10, name: "ZoomScroll" });
            if (this.DOM?.elements?.length && this.instances["ZoomScroll"]?.length) {
                this.DOM.elements.forEach((_, index) => {
                    if (this.instances["ZoomScroll"][index]?.destroy) {
                        this.instances["ZoomScroll"][index].destroy();
                    }
                });
                this.instances["ZoomScroll"] = [];
            }
        });
    }
}

export default Handler;
