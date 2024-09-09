import gsap from "gsap";

class HeaderA {
    constructor() {
        this.DOM = {
            header: document.querySelector(".c--header-a"),
        };
        
        return this.init();
    }
    init() {

        var tl = gsap.timeline({
            defaults: {
                duration: 1,
                ease: "power2.out",
            }
        });

        if(this.DOM.header) {
            tl.from(this.DOM.header, { 
                transform: "translateY(-100%)",
            })
        }
        

        return tl;
    }

}
export default HeaderA;