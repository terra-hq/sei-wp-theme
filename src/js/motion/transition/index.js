import In from "./In";
import Out from "./Out";
import { hideDropdown, hideSidenav } from "./utilities";

export const createTransitionOptions = (payload) => {
    var { forceScroll, Manager, debug,assetManager, eventSystem } = payload;
    var gsap = Manager.getLibrary("GSAP").gsap;
    if(!gsap) debug.error("⚠️ GSAP library not found or not properly loaded")
    return [
        {
            from: "(.*)",
            to: "(.*)",
            in: async (next, infos) => {
                var tl = gsap.timeline({
                    onComplete: async (next) => {
                        next;
                    },
                });
   
                tl.add(
                    new In({
                        element: document.querySelector(".js--transition"),
                        Manager: Manager,
                    })
                ).add("transitionFinished");
                
                tl = await assetManager.importAutoAnimations({tl, eventSystem})

            },
            out: (next, infos) => {
                assetManager.destroyAutoAnimations();
                var tl = gsap.timeline({
                    onComplete: async () => {
                        if (window.scrollY !== 0) {
                        }
                        next();
                    },
                });
				const activeHeader = document.querySelector(".c--header-a--is-active");
				if (activeHeader) {
				tl.add(hideDropdown(payload), "-=0.5");
				}

				const activeBurger = document.querySelector(".c--sidenav-a--is-active");
				if (activeBurger) {
				tl.add(hideSidenav(payload), "-=0.5");
				}
                tl.add(
                    new Out({
                        element: document.querySelector(".js--transition"),
                        Manager: Manager,
                    })
                );
            },
        },
    ];
};