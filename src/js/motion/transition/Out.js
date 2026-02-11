class Out {
    constructor(payload) {
        this.DOM = {
            transitionPath: document.querySelector(".js--transition .c--transition-a__artwork path"),
            transitionMedia: document.querySelector(".js--transition .c--transition-a__media-wrapper__media"),
        };
        this.Manager = payload.Manager;
        this.gsap = this.Manager.getLibrary("GSAP").gsap;
        console.log(this.gsap);

        return this.init();
    }

    isDesktop() {
        return window.innerWidth > 810;
    }

    init() {
        var tl = this.gsap.timeline({});

        tl.set(this.DOM.transitionPath, {
            attr: { d: 'M 0 100 V 100 Q 50 100 100 100 V 100 z' }
        })
        tl.to(this.DOM.transitionPath, { 
            duration: 0.8,
            ease: 'power4.in',
            attr: { d: this.isDesktop() ? 'M 0 100 V 50 Q 50 0 100 50 V 100 z' : 'M 0 100 V 20 Q 50 0 100 20 V 100 z' }
        }, 0)
        tl.to(this.DOM.transitionPath, { 
            duration: 0.3,
            ease: 'power2',
            attr: { d: 'M 0 100 V 0 Q 50 0 100 0 V 100 z' },
        })
        tl.to(this.DOM.transitionMedia, {
            duration: 0.3,
            opacity: 1,
        })


        return tl;
    }
}
export default Out;
