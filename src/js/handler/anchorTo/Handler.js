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
            elements: document.querySelectorAll(".js--scroll-to"),
        }

        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            elements: document.querySelectorAll(".js--scroll-to"),
        };
    }

    init() {}

    initializeAnchorTo({element, index}) {
        const AnchorTo = window['lib']['AnchorTo'];
        this.instances["AnchorTo"][index] = new AnchorTo({
            element: element,
            checkUrl: false,
            anchorTo: "tf-data-target",
            offsetTopAttribute: "tf-data-distance",
            speed: 500,
            emitEvents: true,
            onComplete: () => {
                console.log("Scroll completo", index, element);
            },
        });
    }

    events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;
            if (this.DOM.elements.length > 0) {
                this.instances["AnchorTo"] = [];
                if (!window['lib']['AnchorTo']) {
                    const { default: AnchorTo } = await import ("@teamthunderfoot/anchor-to");
                    window['lib']['AnchorTo'] = AnchorTo;
                }
                this.DOM.elements.forEach((element, index) => {
                    if (isElementInViewport({ el: element, debug: this.terraDebug})) {
                        this.initializeAnchorTo({ element, index });
                    } else {
                        this.boostify.scroll({
                            distance: 10,
                            name: "AnchorTo",
                            callback: async () => {
                                try {
                                    this.initializeAnchorTo({ element, index });
                                } catch (error) {
                                    this.terraDebug && console.log("Error loading AnchorTo", error);
                                }
                            }
                        });
                    }
                })
            }
        });

        this.emitter.on("MitterWillReplaceContent", () => {
            this.DOM = this.updateTheDOM;
            this.boostify.destroyscroll({ distance: 10, name: "AnchorTo" });
            if (this.DOM?.elements?.length && this.instances["AnchorTo"]?.length) {
                this.DOM.elements.forEach((_, index) => {
                    if (this.instances["AnchorTo"][index]?.destroy) {
                        this.instances["AnchorTo"][index].destroy();
                    }
                });
                this.instances["AnchorTo"] = [];
            }
        });
 
    }
}

export default Handler;
