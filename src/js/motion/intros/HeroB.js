class HeroB {
    constructor(payload) {
        this.DOM = {
            title: document.querySelector(".c--hero-b__wrapper__item-left__title"),
            content: document.querySelector(".c--hero-b__wrapper__item-left__subtitle"),
            pills: document.querySelectorAll(".c--hero-b__wrapper__item-left__list-group__item"),
            lottie: document.querySelector(".c--hero-b__wrapper__item-right"),
        };
        this.Manager = payload.Manager;
        this.gsap = this.Manager.getLibrary("GSAP").gsap;
    }
    init() {

        var tl = this.gsap.timeline({});

        if(this.DOM.title) {
            tl.from(this.DOM.title, { 
                duration: 1,
                opacity: 0,
                y: 20,
                ease: "power2.out",
            })
        }
        if(this.DOM.content) {
            tl.from(this.DOM.content, { 
                duration: 1,
                opacity: 0,
                y: 20,
                ease: "power2.out",
            }, "-=.5")
        }
        if(this.DOM.pills) {
            tl.from(this.DOM.pills, { 
                duration: .3,
                opacity: 0,
                y: 20,
                stagger: .2,
                ease: "power2.out",
            }, "-=.5")
        }
        if(this.DOM.lottie) {
            tl.from(this.DOM.lottie, { 
                duration: 1,
                opacity: 0,
                scale: 0,
                ease: "power2.out",
            }, "-=.5")
        }
        this.timeline = tl;
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
export default HeroB;