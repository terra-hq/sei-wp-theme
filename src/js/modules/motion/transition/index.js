import gsap from "gsap";
import In from "./In";
import Out from "./Out";
import { hideDropdown, hideSidenav } from "./utilities";

export const createTransitionOptions = (payload) => {
  return [
    {
      from: "(.*)",
      to: "(.*)",

      in: async (next, infos) => {
        // Preload Images
        if (!window["lib"]["preloadImages"]) {
          const { preloadImages } = await import("@terrahq/helpers/preloadImages");
          window["lib"]["preloadImages"] = preloadImages;
          await preloadImages("img");
        } else {
          await window["lib"]["preloadImages"]("img");
        }

        // Preload Lotties
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

        // Load Hero Animations
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

        // Load HubSpot Forms
        const hubspotChecker = document.querySelectorAll(".js--hubspot-script");
        hubspotChecker.forEach(async (element) => {
          try {
            await payload.boostify.loadScript({
              url: "https://js.hsforms.net/forms/v2.js",
            });
            await payload.boostify.loadScript({
              inlineScript: `
                hbspt.forms.create({
                    region: "na1",
                    portalId: "${element.getAttribute("data-portal-id")}",
                    formId: "${element.getAttribute("data-form-id")}"
                });`,
              appendTo: element,
              attributes: ["id=general-hubspot"],
            });
          } catch (error) {
            console.error("Error loading HubSpot script:", error);
          }
        });

        // Timeline Animations
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

        // Hide Dropdown and Sidenav if active
        const activeHeader = document.querySelector(".c--header-a--is-active");
        if (activeHeader) {
          tl.add(hideDropdown(), "-=0.5");
        }

        const activeBurger = document.querySelector(".c--sidenav-a--is-active");
        if (activeBurger) {
          tl.add(hideSidenav(), "-=0.5");
        }

        tl.add(new Out());
      },
    },
  ];
};
