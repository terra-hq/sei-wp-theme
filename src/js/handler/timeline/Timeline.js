import gsap from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";

class Timeline {
    constructor(payload) {
        this.DOM = {
            timeline: payload.element,
        };


        this.endElement = this.DOM.timeline.lastElementChild;
        this.bottomValue;

        this.init();
        this.events();
    }

    events() {
        window.addEventListener("resize", () => {
            this.updateBar();
            this.loadingBar();
        });
    }

    init() {
        this.updateBar();
        this.loadingBar();
        this.loadingItems();
    }

    //Calc height values for the bar
    updateBar() {
        if (this.endElement) {
            let lastItemHeight = this.endElement.offsetHeight;
            this.bottomValue = (lastItemHeight * 0.9) + 20;
            this.DOM.timeline.style.setProperty('--bottom-value', `${this.bottomValue}px`);
        }
    }

    //Animation loading timeline bar
    loadingBar() {
        gsap.registerPlugin(ScrollTrigger);

        this.loadingBarItem = gsap.timeline({
            scrollTrigger: {
                trigger: this.DOM.timeline,
                start: "+=30 center",
                end: `100%-=${this.bottomValue - 30} center`,
                scrub: true,
                onLeave: () => {
                    //Loading bar stays red at the end
                    this.DOM.timeline.style.setProperty('--finish-color-value', "#F01840");
                },
                repeatRefresh: true
            },
        });

        //Loading bar updates width scroll down
        this.loadingBarItem.to(this.DOM.timeline, {
            ease: "none",
            "--loading-value": `calc(100% - ${this.bottomValue}px)`,
        });
    }

    //Animation loading timeline items
    loadingItems() {
        for (const child of this.DOM.timeline.children) {
            this.loadingItem = gsap.timeline({
                scrollTrigger: {
                    trigger: child,
                    start: "10% center",
                    end: "10%+=20 center",
                    scrub: false,
                    repeatRefresh: true,
                },
            });

            //Text opacity and bullet color change
            this.loadingItem.to(child, { "--color-value": "#F01840", ease: "none", duration: 0 })
            .fromTo(child, {"--opacity-value": 0.3}, { "--opacity-value": 1, ease: "ease", duration: 0.8 }, "<");
        }
    }

    destroy() {
        this.loadingBarItem.scrollTrigger.kill();
        this.loadingItem.scrollTrigger.kill();
        gsap.killTweensOf(this.loadingBarItem);
        gsap.killTweensOf(this.loadingItem);
        ScrollTrigger.getAll().forEach(st => {
            if (st.vars.trigger === this.timeline) {
                st.kill();
            }
        });
    }
}

export default Timeline;