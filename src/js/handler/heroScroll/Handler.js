import { isElementInViewport } from "@terrahq/helpers/isElementInViewport";
// ZoomScroll and HeroScroll use the same library so maybe they can use the same handler
class Handler {
    constructor(payload) {
        var { emitter, instances, boostify, terraDebug, libManager } = payload;
        this.boostify = boostify;
        this.emitter = emitter;
        this.instances = instances;
        this.terraDebug = terraDebug;
        this.libManager = libManager;
        this.usedBoostify = false;

        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            elements: document.querySelectorAll(".js--zoom"),
        };
    }

    init() {}

    initializeHeroScroll({element, index}) {
        const HeroScroll = window['lib']['HeroScroll'];
        this.instances["HeroScroll"][index] = new HeroScroll({
            element: element,
        });
    }

    events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;
            if (this.DOM.elements.length) {
            this.instances["HeroScroll"] = [];
            this.usedBoostify = false;
            if (!window['lib']['HeroScroll']) {
                    const { default: HeroScroll } = await import ("@jsHandler/heroScroll/HeroScroll");
                    window['lib']['HeroScroll'] = HeroScroll;
            }
            this.DOM.elements.forEach((element, index) => {
                if (isElementInViewport({ el: element, debug: this.terraDebug })) {
                    this.initializeHeroScroll({element, index});
                } else {
                    this.usedBoostify = true;
                    this.boostify.scroll({
                        distance: 10,
                        name: "HeroScroll",
                        callback: () => {
                            this.initializeHeroScroll({element, index});
                        },
                    });
                }
            });
        }
           
        });
        
        this.emitter.on("MitterWillReplaceContent", () => {
            this.DOM = this.updateTheDOM;
            if (this.DOM?.elements?.length && this.instances["HeroScroll"]?.length) {
                if (this.usedBoostify) {
                    this.boostify.destroyscroll({ distance: 10, name: "HeroScroll" });
                }
                this.DOM.elements.forEach((_, index) => {
                    if (this.instances["HeroScroll"][index]?.destroy) {
                        this.instances["HeroScroll"][index].destroy();
                    }
                });
                this.instances["HeroScroll"] = [];
            }
        });
    }
}

export default Handler;
