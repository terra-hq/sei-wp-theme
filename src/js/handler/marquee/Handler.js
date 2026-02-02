import { isElementInViewport } from "@terrahq/helpers/isElementInViewport";
import { breakpoints } from "@terrahq/helpers/breakpoints";

class Handler {
    constructor(payload) {
        var { emitter, instances, boostify, terraDebug, libManager } = payload;
        this.boostify = boostify;
        this.emitter = emitter;
        this.instances = instances;
        this.terraDebug = terraDebug;
        this.libManager = libManager;

        this.bk = breakpoints.reduce((target, inner) => Object.assign(target, inner), {});

        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            marqueeA: document.querySelectorAll(".js--marquee"),
            marqueeB: document.querySelectorAll(".js--marquee-b"),
        };
    }

    init() {}

    createInstanceMarqueeA({element, index}) {
        const InfiniteMarquee = window['lib']['InfiniteMarquee'];

        const itemCount = element.querySelectorAll(
            ".c--marquee-a__item"
        ).length;

        this.isMobile = window.innerWidth <= this.bk.mobile;
        this.isTablets = window.innerWidth <= this.bk.tablets;
        this.isTabletm = window.innerWidth <= this.bk.tabletm;

        const shouldInit =
            (this.isMobile && itemCount >= 3) ||
            (!this.isMobile && itemCount >= 7) ||
            (this.isTablets && itemCount >= 5) ||
            (this.isTabletm && itemCount >= 4);

        if (!shouldInit) {
            element.classList.add("js--marquee--disabled");
            return;
        }

        this.instances["InfiniteMarquee"][index] = new InfiniteMarquee({
            element: element,
            speed: element.getAttribute("data-speed")
                ? parseFloat(element.getAttribute("data-speed"))
                : 1,
            controlsOnHover: element.getAttribute("data-controls-on-hover"),
            reversed: element.getAttribute("data-reversed"),
        });
    }

    createInstanceMarqueeB({element, index}) {
        const InfiniteMarquee = window['lib']['InfiniteMarquee'];
        this.instances["InfiniteMarquee"][index] = new InfiniteMarquee({
            element: element,
            speed: element.getAttribute("data-speed")
                ? parseFloat(element.getAttribute("data-speed"))
                : 1,
            controlsOnHover: element.getAttribute("data-controls-on-hover"),
            reversed: element.getAttribute("data-reversed"),
        })
    }

    events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;
            if (this.DOM.marqueeA.length > 0) {
                this.instances["InfiniteMarquee"] = [];
                if (!window['lib']['InfiniteMarquee']) {
                    const { default: InfiniteMarquee } = await import ("@jsHandler/marquee/InfiniteMarquee.js");
                    window['lib']['InfiniteMarquee'] = InfiniteMarquee;
                }
                this.DOM.marqueeA.forEach((element, index) => {
                    if (isElementInViewport({ el: element, debug: this.terraDebug})) {
                        this.createInstanceMarqueeA({ element, index });
                    } else {
                        this.boostify.scroll({
                            distance: 10,
                            name: "InfiniteMarquee",
                            callback: async () => {
                                try {
                                    this.createInstanceMarqueeA({ element, index });
                                } catch (error) {
                                    this.terraDebug && console.log("Error loading InfiniteMarquee", error);
                                }
                            }
                        });
                    }
                })
            }
            if (this.DOM.marqueeB.length > 0) {
                this.instances["InfiniteMarquee"] = [];
                if (!window['lib']['InfiniteMarquee']) {
                    const { default: InfiniteMarquee } = await import ("@jsHandler/marquee/InfiniteMarquee.js");
                    window['lib']['InfiniteMarquee'] = InfiniteMarquee;
                }
                this.DOM.marqueeB.forEach((element, index) => {
                    if (isElementInViewport({ el: element, debug: this.terraDebug})) {
                        this.createInstanceMarqueeB({ element, index });
                    } else {
                        this.boostify.scroll({
                            distance: 10,
                            name: "InfiniteMarquee",
                            callback: async () => {
                                try {
                                    this.createInstanceMarqueeB({ element, index });
                                } catch (error) {
                                    this.terraDebug && console.log("Error loading InfiniteMarquee", error);
                                }
                            }
                        });
                    }
                })
            }
        });
        this.emitter.on("MitterWillReplaceContent", () => {
            this.DOM = this.updateTheDOM;
            if (this.DOM?.marqueeA?.length && this.instances["InfiniteMarquee"]?.length) {
                this.boostify.destroyscroll({ distance: 10, name: "InfiniteMarquee" });
                this.DOM.marqueeA.forEach((_, index) => {
                    if (this.instances["InfiniteMarquee"][index]?.destroy) {
                        this.instances["InfiniteMarquee"][index].destroy();
                    }
                });
                this.instances["InfiniteMarquee"] = [];
            }
            if (this.DOM?.marqueeB?.length && this.instances["InfiniteMarquee"]?.length) {
                this.boostify.destroyscroll({ distance: 10, name: "InfiniteMarquee" });
                this.DOM.marqueeB.forEach((_, index) => {
                    if (this.instances["InfiniteMarquee"][index]?.destroy) {
                        this.instances["InfiniteMarquee"][index].destroy();
                    }
                });
                this.instances["InfiniteMarquee"] = [];
            }
        });
    }

}

export default Handler;
