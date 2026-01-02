import Marquee from "./Marquee";

class MarqueeHandler {
  constructor(payload) {
    var { emitter, instances, boostify, terraDebug, libManager } = payload;
    this.boostify = boostify;
    this.emitter = emitter;
    this.instances = instances;
    this.terraDebug = terraDebug;
    this.libManager = libManager;

    this.DOM = {
      marqueeAElements: document.querySelectorAll(".js--marquee"),
      marqueeBElements: document.querySelectorAll(".js--marquee-b"),
    };

    this.init();
    this.events();
    this.config = (marquee) => ({
        speed: parseFloat(marquee.getAttribute("data-speed")),
        controlsOnHover: marquee.getAttribute("data-controls-on-hover") === "true",
        reversed: marquee.getAttribute("data-reversed"),
        type: marquee.getAttribute("data-orientation"),
    });
  }

  get updateTheDOM() {
    return {
      marqueeAElements: document.querySelectorAll(".js--marquee"),
      marqueeBElements: document.querySelectorAll(".js--marquee-b"),
    };
  }

  init() {
    this.instances["Marquee"] = [];
    this.initMarqueeA();
    this.initMarqueeB();
  }

  events() {
    this.emitter.on("MitterContentReplaced", () => {
        this.DOM = this.updateTheDOM;
        this.initMarqueeA();
        this.initMarqueeB();
    });
    this.emitter.on("MitterWillReplaceContent", () => {
      if (
        this.instances["Marquee"] &&
        this.instances["Marquee"].length
      ) {
        this.instances["Marquee"].forEach((instance, index) => {
          if (instance && typeof instance.destroy === "function") {
            instance.destroy();
          }
        });
        this.instances["Marquee"] = [];
      }
    });
  }

  initMarqueeA() {
        if (this.DOM.marqueeAElements.length) {
            this.DOM.marqueeAElements.forEach((element, index) => {
                this.boostify.scroll({
                    distance: 1,
                    element: element,
                    name: "Marquee",
                    callback: async () => {
                        const itemCount = element.querySelectorAll(".c--marquee-a__item").length;
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

                        this.instances["Marquee"][index] = new Marquee({
                            element: element,
                            speed: element.getAttribute("data-speed") ? parseFloat(element.getAttribute("data-speed")) : 1,
                            controlsOnHover: element.getAttribute("data-controls-on-hover"),
                            reversed: element.getAttribute("data-reversed"),
                        });
                    },
                });
            });
        }
  }

  initMarqueeB() {
    if (this.DOM.marqueeBElements.length) {
      this.DOM.marqueeBElements.forEach((element, index) => {
        this.boostify.scroll({
          distance: 1,
          element: element,
          name: "Marqueeb",
          callback: async () => {
            this.instances["Marquee"][index] = new Marquee({
              element: element,
              speed: element.getAttribute("data-speed") ? parseFloat(element.getAttribute("data-speed")) : 1,
              controlsOnHover: element.getAttribute("data-controls-on-hover"),
              reversed: element.getAttribute("data-reversed"),
            });
          },
        });
      });
    }
  }

  destroy() {
    this.speed = null;
    this.loop.clear();
  }
}
export default MarqueeHandler;
