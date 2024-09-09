import gsap from "gsap";

class HeroA {
    constructor() {
        this.DOM = {
            media: document.querySelector(".c--hero-a__media"),
            title: document.querySelector(".c--hero-a__title"),
            content: document.querySelector(".c--hero-a__content"),
            btn: document.querySelector(".c--hero-a__link"),
        };
        
        return this.init();
    }
    init() {

        var tl = gsap.timeline({
            defaults: {
                duration: 1,
                ease: "power2.out",
                opacity: 0,
            }
        });

        if(this.DOM.media) {
            tl.from(this.DOM.media, { 
                y: 20,
            })
        }
        if(this.DOM.title) {
            tl.from(this.DOM.title, { 
                x: -20,
            }, "<")
        }
        if(this.DOM.content) {
            tl.from(this.DOM.content, { 
                x: 20,
            }, "<")
        }
        if(this.DOM.btn) {
            tl.from(this.DOM.btn, { 
                x: 20,
            }, "<+=.1")
        }

        return tl;
    }

}
export default HeroA;