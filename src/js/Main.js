import Core from "./Core";
import GetAllJobs from "./modules/GetAllJobs";

class Main extends Core {
    constructor(payload) {
        super({
            blazy: {
                enable: true,
                selector: "g--lazy-01",
            },
            form7: {
                enable: true,
            },
            boostify: payload.boostify,
            terraDebug: payload.terraDebug,
        });
    }

    async contentReplaced() {
        super.contentReplaced();
        
        //Inject cookie
        if (document.querySelectorAll(".js--inyect-cookie").length) {
            this.instances["Cookies"] = [];
            await import("./modules/SetCookies").then(({ default: Cookies }) => {
              document.querySelectorAll(".js--inyect-cookie").forEach(async (element, index) => {
                this.instances["Cookies"][index] = new Cookies({ cookieContainer: element });
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
            document.querySelectorAll(".js--load-all-jobs").forEach((element, index) => {
              this.instances["GetAllJobs"][index] = new GetAllJobs({
                element: element,
                resultsContainer: document.getElementById("js--load-all-job-results"),
                filterLocation: document.getElementById("js--filter-locations"),
                filterPracticeAreas: document.getElementById("js--filter-pratice-areas"),
                loader: document.querySelector('.js--loading')
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
                  this.instances["HeroScroll"][index] = new window["lib"]["HeroScroll"]({
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
                  this.instances["ZoomScroll"][index] = new window["lib"]["ZoomScroll"]({
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
          const { sliderAConfig } = await import("@jsModules/slider/slidersConfig");
          const { default: Slider } = await import("@jsModules/slider/Slider.js");
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
    }

    willReplaceContent() {
        super.willReplaceContent();

        // destroy marquee and it's bstf trigger
        if (document.querySelectorAll(".js--marquee").length && this.instances["marqueeA"].length) {
            document.querySelectorAll(".js--marquee").forEach((element, index) => {
                this.instances["marqueeA"][index].destroy();
            });
            this.instances["marqueeA"] = [];
        }

        //Destroy accordion-a
        if (document.querySelectorAll(".js--accordion-a").length && this.instances["accordionA"].length) {            
            document.querySelectorAll(".js--accordion-a").forEach((element, index) => {
                this.instances["accordionA"][index].destroy();
            });
            this.instances["accordionA"] = [];
        }

        //Destroy accordion-02
        if (document.querySelectorAll(".js--accordion-02").length && this.instances["accordion02"].length) {            
            document.querySelectorAll(".js--accordion-02").forEach((element, index) => {
                this.instances["accordion02"][index].destroy();
            });
            this.instances["accordion02"] = [];
        }

        // destroy iframes bstf trigger
        if(document.querySelectorAll(".js--boostify-embed")) {
            this.boostify.destroyscroll({ distance: 10, name: "iframes" });
        }

        // destroy videos bstf trigger
        if(document.querySelectorAll(".js--boostify-player")) {
            this.boostify.destroyscroll({ distance: 10, name: "videos" });
        }

        // destroy slider
        if (document.querySelectorAll(".js--slider-a").length && this.instances["sliderA"].length) {            
            document.querySelectorAll(".js--slider-a").forEach((element, index) => {
                this.instances["sliderA"][index].destroy();
            });
            this.instances["sliderA"] = [];
        }
    }
}

export default Main;
