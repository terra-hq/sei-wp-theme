import { u_stringToBoolean } from "@andresclua/jsutil";

import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
gsap.registerPlugin(ScrollTrigger);

class ZoomScroll {
    constructor(payload) {
        this.DOM = {
            element: payload.element,
        };

        this.isHero = u_stringToBoolean(payload.hero);

        if (this.DOM.element) {
            this.init();
        }

    }
    init() {
        this.mm = gsap.matchMedia();

        // stop animation on tablets and mobile
        this.mm.add("(min-width: 811px)", () => {
            this.tl = gsap.to(this.DOM.element, {
                duration: 1,
                maxWidth: "100%",
                height: "100%",
                scrollTrigger: {
                    trigger: this.DOM.element,
                    start: this.isHero ? "top 75px" : "top 50%",
                    end: "bottom 50%",
                    scrub: 1,
                    markers: false,
                },
            });
        });
        
    }
    destroy() {
        if (this.tl && this.tl.scrollTrigger) {
            this.tl.scrollTrigger.kill();
            this.mm.revert();
        }
    }
}

export default ZoomScroll;
