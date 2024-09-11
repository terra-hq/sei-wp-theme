import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
gsap.registerPlugin(ScrollTrigger);

class HeroScroll {
    constructor(payload) {
        this.DOM = {
            element: payload.element,
        };

        if (this.DOM.element) {
            this.init();
        }
    }

    init() {

        this.tl = gsap.to(this.DOM.element, {
            markers: false,
            duration: 3,
            clipPath: 'circle(100% at 50% 50%)',
            scrollTrigger: {
                trigger: this.DOM.element.parentElement,
                start: "center center-=5px",
                end: "bottom 50%",
                scrub: 1,
                markers: false
            }
        });
    }

    destroy() {
        this.tl.scrollTrigger.kill();
    }
}

export default HeroScroll;
