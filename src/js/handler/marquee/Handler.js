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
            marqueeA: document.querySelectorAll(".js--marquee"),
            marqueeB: document.querySelectorAll(".js--marquee-b"),
        }

        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            marqueeA: document.querySelectorAll(".js--marquee"),
            marqueeB: document.querySelectorAll(".js--marquee-b"),
        };
    }

    init() {
        if (this.DOM.marqueeA.length || this.DOM.marqueeB.length) {
            this.instances["Marquee"] = [];
            this.initializeMarqueeA();
            this.initializeMarqueeB();
        }
    }

    initializeMarqueeA() {
        this.DOM.marqueeA.forEach((element, index) => {
            if (isElementInViewport({ el: element, debug: this.terraDebug })) {
                this.initMarqueeA(element, index);
            } else {
                this.boostify.observer({
                    options: {
                        root: null,
                        rootMargin: "0px",
                        threshold: 0.5,
                    },
                    element: element,
                    callback: () => {
                        this.initMarqueeA(element, index);
                    },
                });
            }
        });
    }

    initMarqueeA(element, index) {
        const items = element.querySelectorAll(".c--marquee-a__item");
        const itemCount = element.querySelectorAll(
            ".c--marquee-a__item"
        ).length;
        const isMobile = window.innerWidth <= 768;
        const isTablets = window.innerWidth <= 810;
        const isTabletm = window.innerWidth <= 1024;

        const shouldInit =
            (isMobile && itemCount >= 3) 
            || (!isMobile && itemCount >= 7) 
            || (isTablets && itemCount >= 5) 
            || (isTabletm && itemCount >= 4)
        ;
        if (!shouldInit) {
            element.classList.add("js--marquee--disabled");
            return;
        }

        this.createMarqueeInstance(element, index);
    }

    initializeMarqueeB() {
        this.DOM.marqueeB.forEach((element, index) => {
            const actualIndex = this.DOM.marqueeA.length + index;
            if (isElementInViewport({ el: element, debug: this.terraDebug })) {
                this.createMarqueeInstance(element, actualIndex);
            } else {
                this.boostify.observer({
                    options: {
                        root: null,
                        rootMargin: "0px",
                        threshold: 0.5,
                    },
                    element: element,
                    callback: () => {
                        this.createMarqueeInstance(element, actualIndex);
                    },
                });
            }
        });
    }

    async createMarqueeInstance(element, index) {
        import("@jsHandler/marquee/InfiniteMarquee.js")
        .then(({ default: InfiniteMarquee }) => {
            window["lib"]["InfiniteMarquee"] = InfiniteMarquee;
            this.instances["Marquee"][index] = new InfiniteMarquee({
                element: element,
                speed: element.getAttribute("data-speed")
                    ? parseFloat(element.getAttribute("data-speed"))
                    : 1,
                controlsOnHover: element.getAttribute("data-controls-on-hover"),
                reversed: element.getAttribute("data-reversed"),
            });
        })
        .catch((e) => {
            this.terraDebug && console.error("Error loading @jsHandler/marquee/InfiniteMarquee.js", e);
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
            (this.DOM.marqueeA.length || this.DOM.marqueeB.length) &&
            this.instances["Marquee"] &&
            this.instances["Marquee"].length
        ) {
            this.DOM.marqueeA.forEach((element, index) => {
                if (this.instances["Marquee"][index]) {
                    if (typeof this.instances["Marquee"][index].destroy === "function") {
                        this.instances["Marquee"][index].destroy();
                    }
                }
            });
            this.DOM.marqueeB.forEach((element, index) => {
                const actualIndex = this.DOM.marqueeA.length + index;
                if (this.instances["Marquee"][actualIndex]) {
                    if (typeof this.instances["Marquee"][actualIndex].destroy === "function") {
                        this.instances["Marquee"][actualIndex].destroy();
                    }
                }
            });
            this.instances["Marquee"] = [];
        }
    }
}

export default Handler;
