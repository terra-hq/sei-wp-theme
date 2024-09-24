import gsap from "gsap";

class HeroB {
    constructor() {
        this.DOM = {
            title: document.querySelector(".c--hero-b__wrapper__item-left__title"),
            content: document.querySelector(".c--hero-b__wrapper__item-left__subtitle"),
            pills: document.querySelectorAll(".c--hero-b__wrapper__item-left__list-group__item"),
            lottie: document.querySelector(".c--hero-b__wrapper__item-right"),
        };
        
        return this.init();
    }
    init() {

        var tl = gsap.timeline({});

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

        return tl;
    }

}
export default HeroB;