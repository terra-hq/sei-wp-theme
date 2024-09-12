import gsap from "gsap";
import In from "./In";
import Out from "./Out";
import { checkItems, hideDropdown, hideSidenav } from "./utilities";
import { digElement } from "@terrahq/helpers/digElement";

const transitionOptions = [
  {
    from: "(.*)",
    to: "(.*)",

    in: async (next, infos) => {
      // await preloadImages("img");
      // await preloadLotties();

      if (!window["lib"]["preloadImages"]) {
        const { preloadImages } = await import("@terrahq/helpers/preloadImages");
        window["lib"]["preloadImages"] = preloadImages;
        await preloadImages("img");
      } else {
        await window["lib"]["preloadImages"]("img");
      }

      if (!window["lib"]["preloadLotties"]) {
        const { preloadLotties } = await import("@terrahq/helpers/preloadLotties");
        window["lib"]["preloadLotties"] = preloadLotties;
      }
      await window["lib"]["preloadLotties"]({
        debug: true,
        selector: document.querySelectorAll(".js--lottie-element"),
        callback: (payload) => {
          console.log("All lotties loaded", payload);
        },
      });

      if (document.querySelector(".c--hero-a")) {
        if (!window["animations"]["heroA"]) {
          window["animations"]["heroA"] = await import("@jsModules/motion/intros/heroA");
        }
      }
      if (document.querySelector(".c--hero-b")) {
        if (!window["animations"]["heroB"]) {
          window["animations"]["heroB"] = await import("@jsModules/motion/intros/heroB");
        }
      }

      // ? BOOSTIFY LOAD FORM SCRIPT GENERAL
      const hubspotChecker = document.querySelectorAll(".js--hubspot-script");
      hubspotChecker.forEach(async (element) => {
        try {
          await window["boostify"].loadScript({
            url: "https://js.hsforms.net/forms/v2.js",
          });
          await window["boostify"].loadScript({
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

      var tl = gsap.timeline({
        onComplete: next,
      });
      tl.add(new In());
      if (document.querySelector(".c--hero-a")) {
        tl.add(new window["animations"]["heroA"].default(), "-=.3");
      }
      if (document.querySelector(".c--hero-b")) {
        tl.add(new window["animations"]["heroB"].default(), "-=.3");
      }
    },

    out: (next, infos) => {
      var tl = gsap.timeline({
        onComplete: next,
      });

      // Check if header has the active class and remove it
      const activeHeader = document.querySelector(".c--header-a--is-active");
      if (activeHeader) {
        tl.add(hideDropdown(), "-=0.5"); // Add the hideDropdown animation to the timeline
      }

      //TODO this sidenav tl needs to be upgraded
      const activeBurger = document.querySelector(".c--sidenav-a--is-active");
      if (activeBurger) {
        tl.add(hideSidenav(), "-=0.5"); // Add the hideSidenav animation to the timeline
      }

      tl.add(new Out());
    },
  },
];

export { transitionOptions };
