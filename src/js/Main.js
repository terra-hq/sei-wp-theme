import Core from "./Core";
import ModalHandler from "./handler/modal/Handler";
import LoadMoreHandler from "./handler/loadmore/Handler";
import FilterPeopleHandler from "./handler/filter/Handler";
import GetAllJobsHandler from "./handler/jobs/Handler";
import HeroScrollHandler from "./handler/heroScroll/Handler";

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
  }

  events() {
    // Loads Core events function
    super.events();
  }

  async contentReplaced() {
    super.contentReplaced();
    this.emitter.emit("MitterContentReplaced");

    //Inject cookie
    if (document.querySelectorAll(".js--inyect-cookie").length) {
      this.instances["Cookies"] = [];
      await import("./modules/SetCookies").then(({ default: Cookies }) => {
        document
          .querySelectorAll(".js--inyect-cookie")
          .forEach(async (element, index) => {
            this.instances["Cookies"][index] = new Cookies({
              cookieContainer: element,
            });
          });
      });
    }

    //get jobs
    if (document.querySelectorAll(".js--load-jobs").length) {
      this.instances["LocationJobs"] = [];
      document.querySelectorAll(".js--load-jobs").forEach((element, index) => {
        this.boostify.observer({
          options: {
            root: null,
            rootMargin: "0px",
            threshold: 0.5,
          },
          element: element,
          callback: () => {
            import("@jsModules/LocationJobs")
              .then(({ default: LocationJobs }) => {
                this.instances["LocationJobs"][index] = new LocationJobs({
                  element: element,
                  job_id: element.getAttribute("data-location-id"),
                });
              })
              .catch((error) => {
                console.error("Error loading LocationJobs module:", error);
              });
          },
        });
      });
    }




    //Zoom b
    if (document.querySelectorAll(".js--zoom-b").length) {
      this.instances["ZoomScroll"] = [];
      this.boostify.scroll({
        distance: 50,
        name: "ZoomScroll",
        callback: async () => {
          const { default: ZoomScroll } = await import("@jsModules/ZoomScroll");
          window["lib"]["ZoomScroll"] = ZoomScroll;
          document.querySelectorAll(".js--zoom-b").forEach((element, index) => {
            this.instances["ZoomScroll"][index] = new window["lib"][
              "ZoomScroll"
            ]({
              element: element,
              hero: element.getAttribute("data-hero"),
            });
          });
        },
      });
    }

    /**
     * Testimonial slider
     */
    let sliderAElements = document.querySelectorAll(".js--slider-a");
    if (sliderAElements.length) {
      this.instances["sliderA"] = [];
      this.boostify.scroll({
        distance: 15,
        name: "sliderA",
        callback: async () => {
          const { sliderAConfig } = await import(
            "@jsModules/slider/slidersConfig"
          );
          const { default: Slider } = await import(
            "@jsModules/slider/Slider.js"
          );
          window["lib"]["Slider"] = Slider;

          sliderAElements.forEach((slider, index) => {
            this.instances["sliderA"][index] = new window["lib"]["Slider"]({
              slider: slider,
              nav: slider.nextElementSibling,
              config: sliderAConfig,
              windowName: "SliderA",
              index: index,
            });
          });
        },
      });
    }

    /**
     * Images slider (gutenberg)
     */
    let sliderBElements = document.querySelectorAll(".js--slider-b");
    if (sliderBElements.length) {
      this.instances["sliderB"] = [];
      this.boostify.scroll({
        distance: 15,
        name: "sliderB",
        callback: async () => {
          const { sliderBConfig } = await import(
            "@jsModules/slider/slidersConfig"
          );
          const { default: SliderB } = await import(
            "@jsModules/slider/Slider.js"
          );
          window["lib"]["SliderB"] = SliderB;

          sliderBElements.forEach((slider, index) => {
            this.instances["sliderB"][index] = new window["lib"]["SliderB"]({
              slider: slider,
              nav: slider.nextElementSibling,
              config: sliderBConfig,
              windowName: "SliderB",
              index: index,
            });
          });
        },
      });
    }

    let sliderCElements = document.querySelectorAll(".js--slider-c");
    if (sliderCElements.length) {
      this.instances["sliderC"] = [];
      this.boostify.scroll({
        distance: 15,
        name: "sliderC",
        callback: async () => {
          const { sliderCConfig } = await import(
            "@jsModules/slider/slidersConfig"
          );
          const { default: SliderC } = await import(
            "@jsModules/slider/Slider.js"
          );
          window["lib"]["SliderC"] = SliderC;

          sliderCElements.forEach((slider, index) => {
            this.instances["sliderC"][index] = new window["lib"]["SliderC"]({
              slider: slider,
              nav: slider.nextElementSibling,
              config: sliderCConfig,
              windowName: "SliderC",
              index: index,
            });
          });
        },
      });
    }

    let sliderDElements = document.querySelectorAll(".js--slider-d");
    if (sliderDElements.length) {
      this.instances["sliderD"] = [];
      this.boostify.scroll({
        distance: 15,
        name: "sliderD",
        callback: async () => {
          const { sliderDConfig } = await import(
            "@jsModules/slider/slidersConfig"
          );
          const { default: SliderD } = await import(
            "@jsModules/slider/Slider.js"
          );
          window["lib"]["SliderD"] = SliderD;

          sliderDElements.forEach((slider, index) => {
            this.instances["sliderD"][index] = new window["lib"]["SliderD"]({
              slider: slider,
              nav: slider.nextElementSibling,
              config: sliderDConfig,
              windowName: "SliderD",
              index: index,
            });
          });
        },
      });
    }

    let sliderEElements = document.querySelectorAll(".js--slider-e");
    if (sliderEElements.length) {
      this.instances["sliderE"] = [];
      this.boostify.observer({
        options: {
            root: null,
            rootMargin: '0px',
            threshold: 0.01
        },
        element: document.querySelector(".js--slider-e"),
        callback: async () => {
          const { sliderEConfig } = await import(
            "@jsModules/slider/slidersConfig"
          );
          const { default: SliderE } = await import(
            "@jsModules/slider/Slider.js"
          );
          window["lib"]["SliderE"] = SliderE;

          sliderEElements.forEach((slider, index) => {
            this.instances["sliderE"][index] = new window["lib"]["SliderE"]({
              slider: slider,
              nav: slider.nextElementSibling,
              config: sliderEConfig,
              windowName: "SliderE",
              index: index,
            });
          });
        },
      });
    }
    /**
     * GSAP animation for timeline-a
     */
    if (document.querySelectorAll(".js--timeline-a").length) {
      this.instances["Timeline"] = [];
      this.boostify.scroll({
        distance: 15,
        name: "Timeline",
        callback: async () => {
          const { default: Timeline } = await import(
            "@jsModules/timeline/Timeline"
          );
          window["lib"]["Timeline"] = Timeline;
          document
            .querySelectorAll(".js--timeline-a")
            .forEach((element, index) => {
              this.instances["Timeline"][index] = new window["lib"]["Timeline"](
                {
                  element: element,
                }
              );
            });
        },
      });
    }


    /**
     * Horizontal accordion
     */
    if (document.querySelectorAll(".c--accordion-a").length) {
      this.instances["AccordionA"] = [];
      this.boostify.scroll({
        distance: 300,
        name: "AccordionA",
        callback: async () => {
          const { default: AccordionA } = await import("@jsModules/AccordionA");
          window["lib"]["AccordionA"] = AccordionA;
          document
            .querySelectorAll(".c--accordion-a")
            .forEach((element, index) => {
              this.instances["AccordionA"][index] = new window["lib"][
                "AccordionA"
              ]({});
            });
        },
      });
    }
    /**
     * Awards accordion
     */
    if (document.querySelectorAll(".js--accordion-b").length) {
      this.instances["AccordionB"] = [];
      const { default: AccordionB } = await import("@jsModules/AccordionB");
      window["lib"]["AccordionB"] = AccordionB;
      document
        .querySelectorAll(".js--accordion-b")
        .forEach((element, index) => {
          this.instances["AccordionB"][index] = new window["lib"]["AccordionB"](
            element
          );
        });
    }

    /**
     * Accordion-02
     */
    if (document.querySelectorAll(".js--accordion-02").length) {
      this.instances["Accordion02"] = [];
      const { default: Accordion02 } = await import("@terrahq/collapsify");
      window["lib"]["Accordion02"] = Accordion02;
      document
        .querySelectorAll(".js--accordion-02")
        .forEach((element, index) => {
          this.instances["Accordion02"][index] = new window["lib"][
            "Accordion02"
          ]({
            nameSpace: "accordion02",
            closeOthers: true,
          });
        });
    }

    //LocationJobs
    if (document.querySelectorAll(".js--load-jobs").length) {
      this.instances["LocationJobs"] = [];
      document.querySelectorAll(".js--load-jobs").forEach((element, index) => {
        this.boostify.observer({
          options: {
            root: null,
            rootMargin: "0px",
            threshold: 0.5,
          },
          element: element,
          callback: () => {
            import("@jsModules/LocationJobs")
              .then(({ default: LocationJobs }) => {
                this.instances["LocationJobs"][index] = new LocationJobs({
                  element: element,
                  job_id: element.getAttribute("data-location-id"),
                });
              })
              .catch((error) => {
                console.error("Error loading Comparison module:", error);
              });
          },
        });
      });
    }
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

    if (
      document.querySelectorAll(".js--load-jobs").length &&
      this.instances["LocationJobs"].length
    ) {
      this.boostify.destroyscroll({ distance: 1, name: "LocationJobs" });
      document.querySelectorAll(".js--load-jobs").forEach((element, index) => {
        this.instances["LocationJobs"][index].destroy();
      });
      this.instances["LocationJobs"] = [];
    }



    if (document.querySelectorAll(".js--zoom-b").length) {
      this.boostify.destroyscroll({ distance: 5, name: "ZoomScroll" });
      document.querySelectorAll(".js--zoom-b").forEach((element, index) => {
        if (this.instances["ZoomScroll"][index]) {
          this.instances["ZoomScroll"][index].destroy();
        }
      });
      this.instances["ZoomScroll"] = [];
    }

    //Destroy timeline
    if (
      document.querySelectorAll(".js--timeline-a").length &&
      this.instances["Timeline"].length
    ) {
      this.boostify.destroyscroll({ distance: 15, name: "Timeline" });
      document.querySelectorAll(".js--timeline-a").forEach((element, index) => {
        this.instances["Timeline"][index].destroy();
      });
      this.instances["Timeline"] = [];
    }

    //Destroy slider
    if (
      document.querySelectorAll(".js--slider-a").length &&
      this.instances["sliderA"].length
    ) {
      this.boostify.destroyscroll({ distance: 15, name: "sliderA" });
      document.querySelectorAll(".js--slider-a").forEach((element, index) => {
        this.instances["sliderA"][index].destroy();
      });
      this.instances["sliderA"] = [];
    }

    if (
      document.querySelectorAll(".js--slider-b").length &&
      this.instances["sliderB"].length
    ) {
      this.boostify.destroyscroll({ distance: 15, name: "sliderB" });
      document.querySelectorAll(".js--slider-b").forEach((element, index) => {
        this.instances["sliderB"][index].destroy();
      });
      this.instances["sliderB"] = [];
    }

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

    //Destroy accordion
    if (
      document.querySelectorAll(".c--accordion-a").length &&
      this.instances["AccordionA"].length
    ) {
      this.boostify.destroyscroll({ distance: 300, name: "AccordionA" });
      document.querySelectorAll(".c--accordion-a").forEach((element, index) => {
        this.instances["AccordionA"][index].destroy();
      });
      this.instances["AccordionA"] = [];
    }

    //Destroy accordion-02
    if (
      document.querySelectorAll(".js--accordion-02").length &&
      this.instances["Accordion02"].length
    ) {
      document
        .querySelectorAll(".js--accordion-02")
        .forEach((element, index) => {
          this.instances["Accordion02"][index].destroy();
        });
      this.instances["Accordion02"] = [];
    }

    //Destroy filter people
    if (
      document.querySelectorAll("#team-grid-location").length &&
      this.instances["FilterPeople"].length
    ) {
      this.boostify.destroyscroll({ distance: 1, name: "FilterPeople" });
      document
        .querySelectorAll("#team-grid-location")
        .forEach((element, index) => {
          this.instances["FilterPeople"][index].destroy();
        });
      this.instances["FilterPeople"] = [];
    }

    //Destroy collapse
    if (
      document.querySelectorAll(".js--collapse").length &&
      this.instances["Collapse"].length
    ) {
      this.boostify.destroyscroll({ distance: 300, name: "Collapse" });
      document.querySelectorAll(".js--collapse").forEach((element, index) => {
        this.instances["Collapse"][index].destroy();
      });
      this.instances["Collapse"] = [];
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
