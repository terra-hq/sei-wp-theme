class HeroA {
    constructor(payload) {
        this.DOM = {
            media: document.querySelector(".c--hero-a__ft-items__wrapper__media"),
            title: document.querySelector(".c--hero-a__ft-items__wrapper__title"),
            btn: document.querySelector(".c--hero-a__ft-items__wrapper__btn"),
        };
        this.Manager = payload.Manager;
        this.gsap = this.Manager.getLibrary("GSAP").gsap;
    }
    init() {

        var tl = this.gsap.timeline({});

        if(this.DOM.media) {
            tl.from(this.DOM.media, { 
                duration: 1,
                opacity: 0,
                y: 20,
                ease: "power2.out",
            })
        }
        if(this.DOM.title) {
            tl.from(this.DOM.title, { 
                duration: 1,
                opacity: 0,
                y: 20,
                ease: "power2.out",
            }, "-=.5")
        }
        if(this.DOM.btn) {
            tl.from(this.DOM.btn, { 
                duration: 1,
                opacity: 0,
                y: 20,
                ease: "power2.out",
            }, "-=.5")
        }
        this.timeline = tl
        return tl;
    }
    destroy() {
        if (this.timeline) {
            this.timeline.kill();
            this.timeline = null;
        }

        this.DOM = null;
        this.Manager = null;
    }

}
export default HeroA;