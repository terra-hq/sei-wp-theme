import Core from "./Core";
import GetAllJobs from "./modules/GetAllJobs";
import ModalHandler from "./handler/modal/Handler";

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

    //Get all jobs

    if (document.querySelectorAll(".js--load-all-jobs").length) {
      this.instances["GetAllJobs"] = [];
      document
        .querySelectorAll(".js--load-all-jobs")
        .forEach((element, index) => {
          this.instances["GetAllJobs"][index] = new GetAllJobs({
            element: element,
            resultsContainer: document.getElementById(
              "js--load-all-job-results"
            ),
            filterLocation: document.getElementById("js--filter-locations"),
            filterPracticeAreas: document.getElementById(
              "js--filter-pratice-areas"
            ),
            loader: document.querySelector(".js--loading"),
          });
        });
    }


    //Zoom a
    if (document.querySelectorAll(".js--zoom").length) {
      this.instances["HeroScroll"] = [];
      this.boostify.scroll({
        distance: 1,
        name: "HeroScroll",
        callback: async () => {
          const { default: HeroScroll } = await import("@jsModules/HeroScroll");
          window["lib"]["HeroScroll"] = HeroScroll;
          document.querySelectorAll(".js--zoom").forEach((element, index) => {
            this.instances["HeroScroll"][index] = new window["lib"][
              "HeroScroll"
            ]({
              element: element,
            });
          });
        },
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

            const shouldInit =
              (isMobile && itemCount >= 3) || (!isMobile && itemCount >= 7);
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
     * Filter people
     */
    if (document.getElementById("team-grid-location")) {
      this.instances["FilterPeople"] = [];
      this.boostify.observer({
        options: {
          root: null,
          rootMargin: "0px",
          threshold: 0.5,
        },
        element: document.getElementById("team-grid-location"),
        callback: () => {
          import("@jsModules/FilterPeople")
            .then(({ default: FilterPeople }) => {
              this.instances["FilterPeople"] = new FilterPeople({
                selectId: "team-grid-location",
                cardSelector: "#team-grid-people",
              });
            })
            .catch((error) => {
              console.error("Error loading FilterPeople module:", error);
            });
        },
      });
    }
    /**
     * News Filter
     */
    if (document.querySelectorAll(".js--section-news").length) {
      const loadMoreButton = document.querySelector(".js--load-more-news");
      const newsLoadMore = {
        dom: {
          resultsContainer: document.querySelector(".js--news-container"),
          triggerElement: loadMoreButton,
        },
        query: {
          postType: loadMoreButton && loadMoreButton.dataset.postType,
          postPerPage: parseInt(
            loadMoreButton && loadMoreButton.dataset.postsPerPage
          ),
          offset: parseInt(loadMoreButton && loadMoreButton.dataset.offset),
          total: parseInt(loadMoreButton && loadMoreButton.dataset.postsTotal),
          taxonomies: [],
          action: "load_more",
        },
        isPagination: false,
        callback: {
          onStart: () => { },
          onComplete: () => { },
        },
      };
      document
        .querySelectorAll(".js--section-news")
        .forEach((element, index) => {
          this.boostify.observer({
            options: {
              root: null,
              rootMargin: "0px",
              threshold: 0,
            },
            element: element,
            callback: async () => {
              this.instances["LoadNews"] = [];
              await import("@jsModules/loadMore/LoadNews").then(
                ({ default: LoadNews }) => {
                  window["lib"]["LoadNews"] = LoadNews;
                }
              );

              this.instances["LoadNews"][index] = new window["lib"]["LoadNews"](
                newsLoadMore
              );
            },
          });
        });
    }
    /**
     * Insights Filter
     */
    if (document.querySelectorAll(".js--section-container").length) {
      const loadMoreButton = document.querySelector(".js--load-more-posts");
      const featuredInsightElement = document.querySelector(
        ".js--featured-insight"
      );
      const page_id =
        featuredInsightElement && featuredInsightElement.dataset.pageId;
      
      // Check if we're on success stories page (case studies)
      const isCaseStudiesPage = loadMoreButton && loadMoreButton.dataset.postType === 'case-study';
      
      if (isCaseStudiesPage) {
        // Case Studies configuration
        const caseStudiesLoadMore = {
          dom: {
            resultsContainer: document.querySelector(".js--results-container"),
            searchBar: document.querySelector(".js--posts-search"),
            industryFilter: document.querySelectorAll(".js--case-study-industry-dropdown"),
            capabilityFilter: document.querySelectorAll(".js--case-study-capability-dropdown"),
            triggerElement: loadMoreButton,
            noResultsElement: document.querySelector(".js--no-results-message"),
            resultsNumber: document.querySelector(".js--results-number"),
            loader: document.querySelector(".js--loading"),
            spinner: document.querySelector(".js--spinner-load-more"),
          },
          query: {
            postType: loadMoreButton && loadMoreButton.dataset.postType,
            postPerPage: parseInt(
              loadMoreButton && loadMoreButton.dataset.postsPerPage
            ),
            offset: parseInt(loadMoreButton && loadMoreButton.dataset.offset),
            total: parseInt(loadMoreButton && loadMoreButton.dataset.postsTotal),
            page_id: page_id,
            taxonomies: [],
            action: "load_case_studies",
          },
          isPagination: false,
          callback: {
            onStart: () => { },
            onComplete: () => { },
          },
        };
        
        document
          .querySelectorAll(".js--section-container")
          .forEach((element, index) => {
            this.boostify.observer({
              options: {
                root: null,
                rootMargin: "0px",
                threshold: 0,
              },
              element: element,
              callback: async () => {
              if (element.dataset.caseStudiesLoaded === "true") return;
              element.dataset.caseStudiesLoaded = "true";

              if (!window.lib?.LoadCaseStudies) {
                const { default: LoadCaseStudies } = await import(
                  "@jsModules/loadMore/LoadCaseStudies"
                );
                window.lib = window.lib || {};
                window.lib.LoadCaseStudies = LoadCaseStudies;
              }

              this.instances["LoadCaseStudies"] = this.instances["LoadCaseStudies"] || [];
              this.instances["LoadCaseStudies"][index] = new window.lib.LoadCaseStudies(
                caseStudiesLoadMore
              );
              },
            });
          });
      } else {
        // Original Insights configuration
        const insightsLoadMore = {
          dom: {
            resultsContainer: document.querySelector(".js--results-container"),
            searchBar: document.querySelector(".js--posts-search"),
            typesFilter: document.querySelectorAll(".js--insight-types-dropdown"),
            capabilityFilter: document.querySelectorAll(
              ".js--insight-capability-dropdown"
            ),
            topicsFilter: document.querySelectorAll(".js--topics-dropdown"),
            triggerElement: loadMoreButton,
            noResultsElement: document.querySelector(".js--no-results-message"),
            resultsNumber: document.querySelector(".js--results-number"),
            loader: document.querySelector(".js--loading"),
            spinner: document.querySelector(".js--spinner-load-more"),
          },
          query: {
            postType: loadMoreButton && loadMoreButton.dataset.postType,
            postPerPage: parseInt(
              loadMoreButton && loadMoreButton.dataset.postsPerPage
            ),
            offset: parseInt(loadMoreButton && loadMoreButton.dataset.offset),
            total: parseInt(loadMoreButton && loadMoreButton.dataset.postsTotal),
            page_id: page_id,
            taxonomies: [],
            action: "load_insights",
          },
          isPagination: false,
          callback: {
            onStart: () => { },
            onComplete: () => { },
          },
        };
        document
          .querySelectorAll(".js--section-container")
          .forEach((element, index) => {
            this.boostify.observer({
              options: {
                root: null,
                rootMargin: "0px",
                threshold: 0,
              },
              element: element,
              callback: async () => {
                if (element.dataset.insightsLoaded === "true") return;
                element.dataset.insightsLoaded = "true";

                if (!window.lib?.LoadInsights) {
                  const { default: LoadInsights } = await import(
                    "@jsModules/loadMore/LoadInsights"
                  );
                  window.lib = window.lib || {};
                  window.lib.LoadInsights = LoadInsights;
                }

                this.instances["LoadInsights"] = this.instances["LoadInsights"] || [];
                this.instances["LoadInsights"][index] = new window.lib.LoadInsights(
                  insightsLoadMore
                );
              },
            });
          });
      }
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

    if (
      Array.isArray(this.instances["GetAllJobs"]) && // Ensure GetAllJobs is an array
      this.instances["GetAllJobs"].length // Ensure it has elements
    ) {
      this.instances["GetAllJobs"].forEach((instance, index) => {
        if (instance && typeof instance.destroy === "function") {
          // Check if destroy() exists
          instance.destroy(); // Call destroy
        }
      });
    }

    if (
      document.querySelectorAll(".js--zoom").length &&
      this.instances["HeroScroll"].length
    ) {
      this.boostify.destroyscroll({ distance: 1, name: "HeroScroll" });
      document.querySelectorAll(".js--zoom").forEach((element, index) => {
        if (this.instances["HeroScroll"][index]) {
          this.instances["HeroScroll"][index].destroy();
        }
      });
      this.instances["HeroScroll"] = [];
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

    // Destroy insights
    if (
      document.querySelectorAll(".js--section-container").length &&
      this.instances["LoadInsights"] &&
      this.instances["LoadInsights"].length
    ) {
      document
        .querySelectorAll(".js--section-container")
        .forEach((element, index) => {
          if (this.instances["LoadInsights"][index]) {
            this.instances["LoadInsights"][index].destroy();
          }
        });
      this.instances["LoadInsights"] = [];
    }

    // Destroy case studies
    if (
      document.querySelectorAll(".js--section-container").length &&
      this.instances["LoadCaseStudies"] &&
      this.instances["LoadCaseStudies"].length
    ) {
      document
        .querySelectorAll(".js--section-container")
        .forEach((element, index) => {
          if (this.instances["LoadCaseStudies"][index]) {
            this.instances["LoadCaseStudies"][index].destroy();
          }
        });
      this.instances["LoadCaseStudies"] = [];
    }

    //Destroy News
    if (document.querySelectorAll(".js--load-news").length) {
      document.querySelectorAll(".js--load-news").forEach((element, index) => {
        this.instances["LoadNews"][index].destroy();
      });
      this.instances["LoadNews"] = [];
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
  }
}

export default Main;
