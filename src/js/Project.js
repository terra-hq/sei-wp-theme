// Styles
import "@scss/style.scss";

// JS Starts here

const terraVirtual = import.meta.env.VITE_TERRA_VIRTUAL;
console.log("server is running in " + import.meta.env.MODE + " mode");
console.log('Terra Virtual Variable:', terraVirtual);

import gsap from 'gsap';
import Boostify from 'boostify';
import { modifyTag } from "@jsModules/utilities/utilities.js";

function getQueryParam(param) {
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.has(param); // returns true if the parameter is present, otherwise false
}

class Project {
  constructor() {
    window.isFired = true; // prevent multiple instances of the project class

    // terra debug mode, add ?debug to the url to enable debug mode
    this.terraDebug = getQueryParam('debug');

    this.DOM = {
      preloaderPath: document.querySelector(".c--preloader-a__artwork path"),
      preloaderMedia: document.querySelector(".c--preloader-a__media-wrapper__media"),
      heroA: document.querySelector(".c--hero-a"),
      heroB: document.querySelector(".c--hero-b"),
    };

    window["lib"] = {};
    window["animations"] = {};

    this.boostify = new Boostify({
      debug: false,
      license: import.meta.env.VITE_LICENSE_KEY,
    });

    this.boostify.onload({
      // if performance is low, increment number 
      maxTime: 1200,
    })


    this.init()
  }

  isDesktop() {
    return window.innerWidth > 810;
  }

  async init() {
    try {

      // Dynamically import the preloadImages function,
      // and store it in the window.lib object for later use
      const { preloadImages } = await import("@terrahq/helpers/preloadImages");
      window["lib"]["preloadImages"] = preloadImages;
      await preloadImages("img");

      // Dynamically import the preloadLotties function,
      // and store it in the window.lib object for later use
      const { preloadLotties } = await import("@terrahq/helpers/preloadLotties");
      window["lib"]["preloadLotties"] = preloadLotties;
      await preloadLotties();

      if (this.DOM.heroA) {
        window["animations"]["heroA"] = await import("@jsModules/motion/intros/heroA");
      }

      if (this.DOM.heroB) {
        window["animations"]["heroB"] = await import("@jsModules/motion/intros/heroB");
      }

      // ? BOOSTIFY LOAD FORM SCRIPT GENERAL
      const hubspotChecker = document.querySelectorAll(".js--hubspot-script");
      hubspotChecker.forEach(async (element) => {
        try {
          await this.boostify.loadScript({
            url: "https://js.hsforms.net/forms/v2.js",
          });
          await this.boostify.loadScript({
            inlineScript: `
                hbspt.forms.create({
                    region: "na1",
                    portalId: "${element.getAttribute("data-portal-id")}",
                    formId: "${element.getAttribute("data-form-id")}"
                });`,
            appendTo: element,
            attributes: ["id=general-hubspot"],
          });
          // * the previous code adds the [data-swup-ignore-script] attribute to the script to avoid Swup reloading it ^
        } catch (error) {
          console.error("Error loading HubSpot script:", error);
        }
      });
      // * BOOSTIFY LOAD FORM SCRIPT footer
      // check if there's a div with the class js--hubspot-script
      // if there is, load the hubspot form script as attribute data-portal-id and data-form-id
      const hubspotFooterChecker = document.querySelectorAll(".js--hubspot-script--footer");
      hubspotFooterChecker.forEach((element) => {
        let executed = false; // Bandera para controlar la ejecución
        this.boostify.observer({
          options: {
            root: null,
            rootMargin: "0px",
            threshold: 0.5,
          },
          element: element,
          callback: async () => {
            if (executed) return; // Si ya se ejecutó, no hacemos nada
            executed = true; // Marcamos como ejecutado

            await this.boostify.loadScript({
              url: "https://js.hsforms.net/forms/v2.js",
            });

            await this.boostify.loadScript({
              inlineScript: `
                      hbspt.forms.create({
                        region: "na1",
                        portalId: "${element.getAttribute("data-portal-id")}",
                        formId: "${element.getAttribute("data-form-id")}"
                      });`,
              appendTo: element,
              attributes: ["id=footer-hubspot"],
            });

            modifyTag({
              element: element.children[0],
              attributes: {
                "data-swup-ignore-script": "",
              },
              delay: 250,
            });
          },
        });
      });

    }
    catch (e) {
      console.log(e);
    }
    finally {
      var tl = gsap.timeline({
        defaults: { duration: 0.8, ease: "power1.inOut" },
        onUpdate: async () => {
          // //* Check if the animation is at least 50% complete and the function hasn't been executed yet
          if (tl.progress() >= 0.5 && !this.halfwayExecuted) {
            this.halfwayExecuted = true;
            const { default: Main } = await import("@js/Main.js");
            new Main({
              boostify: this.boostify,
              debug: this.terraDebug,
            });

          }

          if (this.terraDebug) {
            (async () => {
              try {
                const { terraDebugger } = await import('@terrahq/helpers/terraDebugger');
                terraDebugger({ submitQA: 'clickup-url' });
              } catch (error) {
                console.error('Error loading the debugger module:', error);
              }
            })();
          }
        },
      });
      
      tl.to(this.DOM.preloaderMedia, {
        duration: 1,
        autoAlpha: 0,
        // delay: .5,
      });
      tl.to(this.DOM.preloaderPath, {
        duration: 0.3,
        ease: "power2.in",
        attr: { d: this.isDesktop() ? "M 0 0 V 50 Q 50 0 100 50 V 0 z" : "M 0 0 V 20 Q 50 0 100 20 V 0 z" },
      });
      tl.to(this.DOM.preloaderPath, {
        duration: 0.8,
        ease: "power4",
        attr: { d: "M 0 0 V 0 Q 50 0 100 0 V 0 z" },
      });
      if (this.DOM.heroA) {
        tl.add(new window["animations"]["heroA"].default(), "-=.3");
      }
      if (this.DOM.heroB) {
        tl.add(new window["animations"]["heroB"].default(), "-=.3");
      }

    }
  }
};

if (!window.isFired) {
  new Project();
}


