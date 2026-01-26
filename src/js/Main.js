import Core from "./Core";
import ModalHandler from "./handler/modal/Handler";
import LoadMoreHandler from "./handler/loadmore/Handler";
import FilterPeopleHandler from "./handler/filter/Handler";
import GetAllJobsHandler from "./handler/jobs/Handler";
import HeroScrollHandler from "./handler/heroScroll/Handler";
import LocationJobsHandler from "./handler/locationJobs/Handler";
import CookiesHandler from "./handler/cookies/Handler";
import ZoomScrollHandler from "./handler/zoomScroll/Handler";
import TimelineHandler from "./handler/timeline/Handler";
import SliderHandler from "./handler/slider/Handler";
import CollapsifyHandler from "@jsHandler/collapsify/handler.js";

class Main extends Core {
  constructor(payload) {
    super({
      blazy: {
        enable: true,
        selector: "g--lazy-01",
      },
      form7: {
        enable: false,
      },
      swup: {
        transition: {
          forceScrollTop: false,
        },
      },
      boostify: payload.boostify,
      terraDebug: payload.terraDebug,
    });
    this.handler = {
      emitter: this.emitter,
      boostify: this.boostify,
      instances: this.instances,
      terraDebug: this.terraDebug,
      libManager: this.libManager,
    };
    this.init();
    this.events();
  }

  init() {
    // Loads Core init function
    super.init();
    new ModalHandler(this.handler);
    new LoadMoreHandler(this.handler);
    new FilterPeopleHandler(this.handler);
    new GetAllJobsHandler(this.handler);
    new HeroScrollHandler(this.handler);
    new LocationJobsHandler(this.handler);
    new CookiesHandler(this.handler);
    new ZoomScrollHandler(this.handler);
    new TimelineHandler(this.handler);
    new SliderHandler(this.handler);
    new CollapsifyHandler(this.handler);
  }

  events() {
    // Loads Core events function
    super.events();
  }

  async contentReplaced() {
    super.contentReplaced();
    this.emitter.emit("MitterContentReplaced");


    //marqueee
    if (document.querySelectorAll(".js--marquee").length) {
      this.instances["Marquee"] = [];

      document.querySelectorAll(".js--marquee").forEach((element, index) => {
        this.boostify.scroll({
          distance: 1,
          element: element,
          name: "Marquee",

          callback: async () => {
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

            const { default: InfiniteMarquee } = await import(
              "@jsModules/marquee/InfiniteMarquee.js"
            );
            window["lib"]["InfiniteMarquee"] = InfiniteMarquee;

            this.instances["Marquee"][index] = new window["lib"][
              "InfiniteMarquee"
            ]({
              element: element,
              speed: element.getAttribute("data-speed")
                ? parseFloat(element.getAttribute("data-speed"))
                : 1,
              controlsOnHover: element.getAttribute("data-controls-on-hover"),
              reversed: element.getAttribute("data-reversed"),
            });
          },
        });
      });
    }

    if (document.querySelectorAll(".js--marquee-b").length) {
      this.instances["Marquee"] = [];

      document.querySelectorAll(".js--marquee-b").forEach((element, index) => {
        this.boostify.scroll({
          distance: 1,
          element: element,
          name: "Marqueeb",

          callback: async () => {
            const { default: InfiniteMarquee } = await import(
              "@jsModules/marquee/InfiniteMarquee.js"
            );
            window["lib"]["InfiniteMarquee"] = InfiniteMarquee;

            this.instances["Marquee"][index] = new window["lib"][
              "InfiniteMarquee"
            ]({
              element: element,
              speed: element.getAttribute("data-speed")
                ? parseFloat(element.getAttribute("data-speed"))
                : 1,
              controlsOnHover: element.getAttribute("data-controls-on-hover"),
              reversed: element.getAttribute("data-reversed"),
            });
          },
        });
      });
    }
    /**
     * functions collapse
     */
    if (document.querySelectorAll(".js--collapse").length) {
      this.instances["Collapse"] = [];
      this.boostify.scroll({
        distance: 300,
        name: "Collapse",
        callback: async () => {
          const { default: Collapse } = await import("@terrahq/collapsify");
          window["lib"]["Collapse"] = Collapse;
          document
            .querySelectorAll(".js--collapse")
            .forEach((element, index) => {
              this.instances["Collapse"][index] = new window["lib"]["Collapse"](
                {
                  nameSpace: `collapsify`,
                  closeOthers: false,
                  onSlideStart: (isOpen, contentID) => {
                    element.classList.add("u--display-none"),
                      element.parentNode
                        .querySelector(".c--overlay-c")
                        .classList.add("u--display-none");
                  },
                }
              );
            });
        },
      });
    }

    if (document.querySelectorAll(".js--scroll-to").length > 0) {
      const { default: AnchorTo } = await import("@teamthunderfoot/anchor-to");

      document.querySelectorAll(".js--scroll-to").forEach((el, index) => {
        this.instances["AnchorTo"] = this.instances["AnchorTo"] || [];
        this.instances["AnchorTo"][index] = new AnchorTo({
          element: el,
          checkUrl: false, // o true si quieres soportar hashes en la URL
          anchorTo: "tf-data-target", // dónde buscar el ID destino
          offsetTopAttribute: "tf-data-distance",
          speed: 500,
          emitEvents: true,
          onComplete: () => console.log("Scroll completo"),
        });
      });
    }

    if (document.querySelectorAll(".js--quiz-a").length) {
      this.instances["Quiz"] = [];
      this.instances["Collapse"] = [];

      const { default: Quiz } = await import("@jsModules/Quiz");
      window["lib"]["Quiz"] = Quiz;

      const { default: Collapse } = await import("@terrahq/collapsify");
      window["lib"]["Collapse"] = Collapse;

      document.querySelectorAll(".js--quiz-a").forEach((element, index) => {
        this.instances["Quiz"][index] = new window["lib"]["Quiz"]();
      });
    }

  }

  willReplaceContent() {
    super.willReplaceContent();
    this.emitter.emit("MitterWillReplaceContent");

    //Destroy counter
    if (
      document.querySelectorAll(".js--counter").length &&
      this.instances["Counter"].length
    ) {
      this.boostify.destroyscroll({ distance: 15, name: "Counter" });
      document.querySelectorAll(".js--counter").forEach((element, index) => {
        this.instances["Counter"][index].destroy();
      });
      this.instances["Counter"] = [];
    }



    //Destroy marquee
    if (
      document.querySelectorAll(".js--marquee").length &&
      this.instances["Marquee"].length
    ) {
      this.boostify.destroyscroll({ distance: 50, name: "Marquee" });
      document.querySelectorAll(".js--marquee").forEach((element, index) => {
        if (this.instances["Marquee"][index]) {
          this.instances["Marquee"][index].destroy?.(); // Por si tiene método destroy
        }
      });
      this.instances["Marquee"] = [];
    }

    if (document.querySelectorAll(".js--quiz-a").length) {
      this.instances["Quiz"].forEach((instance, index) => {
        if (instance && typeof instance.destroy === "function") {
          instance.destroy();
        }
      });
      this.instances["Quiz"] = [];
    }
  }
}

export default Main;
