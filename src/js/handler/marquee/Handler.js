import CoreHandler from "../CoreHandler";
import { breakpoints } from "@terrahq/helpers/breakpoints";

class Handler extends CoreHandler {
    constructor(payload) {
        super(payload);
       
        this.configMarqueeA = ({element}) => {
            const itemCount = element.querySelectorAll(".c--marquee-a__wrapper").length;
            this.bk = breakpoints.reduce((target, inner) => Object.assign(target, inner), {});

            this.isMobile = window.innerWidth <= this.bk.mobile;
            this.isTablets = window.innerWidth <= this.bk.tablets;
            this.isTabletm = window.innerWidth <= this.bk.tabletm;
            const shouldInit =
            (this.isMobile && itemCount >= 3) ||
            (!this.isMobile && itemCount >= 7) ||
            (this.isTablets && itemCount >= 5) ||
            (this.isTabletm && itemCount >= 4);

            if (!shouldInit) {
                element.classList.add("c--marquee-a--second");
                return {
                    element: element,
                    paused: true,
                    Manager: this.Manager,
                } 
            } else {
                return {
                    element: element,
                    Manager: this.Manager,
                    speed: element.getAttribute("data-speed") 
                    ? parseFloat(element.getAttribute("data-speed"))
                    : 1,
                    controlsOnHover: element.getAttribute("data-controls-on-hover") ?? false,
                    reversed: element.getAttribute("data-reversed") ?? false,
                }
            }
        };
        
        this.configMarqueeB = ({element}) => {
            return {
                element: element,
                Manager: this.Manager, // ✅ ¡Añadimos el Manager aquí para evitar que explote InfiniteMarquee!
                speed: element.getAttribute("data-speed")
                ? parseFloat(element.getAttribute("data-speed"))
                : 1,
                controlsOnHover: element.getAttribute("data-controls-on-hover"),
                reversed: element.getAttribute("data-reversed"),
            }
        };

        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            marqueeA: document.querySelectorAll(".js--marquee"),
            marqueeB: document.querySelectorAll(".js--marquee-b"),
        };
    }

    init() {
        super.getLibraryName("Marquee");
    }

    events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;

            super.assignInstances({
                elementGroups: [
                    {
                        elements: this.DOM.marqueeA,
                        config: this.configMarqueeA,
                        boostify: { distance: 30 },
                    },
                    {
                        elements: this.DOM.marqueeB,
                        config: this.configMarqueeB,
                        boostify: { distance: 30 },
                    },
                ],
            });
        });

        this.emitter.on("MitterWillReplaceContent", () => {
            if (this.DOM.marqueeA.length || this.DOM.marqueeB.length) {
                super.destroyInstances();
            }
        });
    }
}

export default Handler;