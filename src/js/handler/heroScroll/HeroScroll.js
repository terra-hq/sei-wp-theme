class HeroScroll {
    constructor(payload) {
        this.DOM = {
            element: payload.element,
            
        };
        this.Manager = payload.Manager;
        this.gsap = this.Manager.getLibrary("GSAP").gsap;

        if (this.DOM.element) {
            this.init();
        }
    }

    init() {

        this.tl = this.gsap.to(this.DOM.element, {
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
        if (this.tl && this.tl.scrollTrigger) {
            this.tl.scrollTrigger.kill();
        }
    }
}

export default HeroScroll;
