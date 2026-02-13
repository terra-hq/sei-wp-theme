import In from "./In";
import Out from "./Out";
import { hideDropdown, hideSidenav, smoothScrollToTop } from "./utilities";
import { u_take_your_time } from '@andresclua/jsutil';

export const createTransitionOptions = (payload) => {
  var {boostify, forceScroll, assetManager, eventSystem, Manager } = payload;
  var gsap = Manager.getLibrary("GSAP").gsap;
  return [
    {
      from: "(.*)",
      to: "(.*)",

      in: async (next, infos) => {
        // Timeline Animations
        var tl = gsap.timeline({
          onComplete: next,
        });
        tl.add(new In(payload));
        tl = await assetManager.importAutoAnimations({tl, eventSystem})
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
          tl.add(hideDropdown(payload), "-=0.5");
        }

        const activeBurger = document.querySelector(".c--sidenav-a--is-active");
        if (activeBurger) {
          tl.add(hideSidenav(payload), "-=0.5");
        }

        tl.add(new Out(payload));
      },
    },
  ];
};
