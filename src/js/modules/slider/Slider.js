import { tns } from "/node_modules/tiny-slider/src/tiny-slider.js";
import { digElement } from "@terrahq/helpers/digElement";
import gsap from "gsap";

class Slider {
    constructor(payload) {
        this.DOM = {
            slider: payload.slider,
            controls: payload.controls,
            navcontainer: payload.navcontainer,
        };
        this.config = payload.config;
        this.windowName = payload.windowName;
        this.index = payload.index;
        if (!this.DOM.slider) return;
        if (!this.config) return;
        this.init();
    }

    init() {
        this.config.container = this.DOM.slider;
        this.config.controlsContainer = this.DOM.controls;
        this.config.navContainer = this.DOM.navcontainer;
        this.slider = tns(this.config);
        gsap.to(this.DOM.slider, { opacity: 1, duration: 0.5, ease: "power4.in"});
    }

    isReady = async () => {
        return Promise.all(
            Array.from(this.DOM.slider.children).map(async (element) => {
                await digElement({
                    element: element,
                    search: {
                        type: "class",
                        lookFor: "tns-item",
                    },
                    intervalFrequency: 500,
                    timer: 5000,
                });
            })
        )
            .then(() => {
                if (!window[this.windowName]) {
                    window[this.windowName] = [];
                }
                window[this.windowName][this.index] = { isReady: true };
            })
            .catch((error) => console.log(error.message));
    };

    destroy() {
        if (this.slider) {
            this.slider.destroy();
        }
        if (window[this.windowName]) {
            window[this.windowName][this.index] = null;
            this.slider = null;
        }
    }
}
export default Slider;