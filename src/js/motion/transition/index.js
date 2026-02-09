import gsap from "gsap";
import In from "./In";
import Out from "./Out";
import { hideDropdown, hideSidenav, smoothScrollToTop } from "./utilities";
import { u_take_your_time } from '@andresclua/jsutil';

export const createTransitionOptions = (payload) => {
  var {boostify, forceScroll } = payload;
  return [
    {
      from: "(.*)",
      to: "(.*)",

      in: async (next, infos) => {
        // Preload Images
        var images = document.querySelector("img");
        if(images){
            if (!window["lib"]["preloadImages"]) {
                const { preloadImages } = await import("@terrahq/helpers/preloadImages");
                window["lib"]["preloadImages"] = preloadImages;
            }
            await window["lib"]["preloadImages"]("img");
        }

        // Load Hero Animations
        if (document.querySelector(".c--hero-a")) {
          if (!window["animations"]["heroA"]) {
            window["animations"]["heroA"] = await import("@jsMotion/intros/heroA");
          }
        }
        if (document.querySelector(".c--hero-b")) {
          if (!window["animations"]["heroB"]) {
            window["animations"]["heroB"] = await import("@jsMotion/intros/heroB");
          }
        }

        // Load HubSpot Forms
        const hubspotChecker = document.querySelectorAll(".js--hubspot-script");
        if(hubspotChecker.length){
          hubspotChecker.forEach(async (element) => {
            try {
              await boostify.loadScript({
                url: "https://js.hsforms.net/forms/v2.js",
              });
              await boostify.loadScript({
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
        }

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
          onComplete: async () => {
            if (forceScroll) {
              if (window.scrollY !== 0) {
                /**
                 *  We add this last step in order to prevent animations being executed while the page is scrolling to top
                 *  This is a common issue when the user clicks on a link and the page is scrolled to top
                 *  NOTE : This is the first project we do this, so we need to test it in other projects, and could be a good reference
                 *  for the rest of the team, last but not least we add ad {u_take_your_time} to gain a few milliseconds before the next page is loaded
                 * !you can change the value of forceScroll in Main.js
                 */
                await smoothScrollToTop();
              }
              await u_take_your_time(150);
            }
            next();
          }
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
