class HeaderA {
    constructor(payload) {
        this.DOM = {
            header: document.querySelector(".c--header-a"),
        };
        this.Manager = payload.Manager;
        this.gsap = this.Manager.getLibrary("GSAP").gsap;
    }
    init() {

        var tl = this.gsap.timeline({
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
export default HeaderA;