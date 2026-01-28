import { isElementInViewport } from "@terrahq/helpers/isElementInViewport";
import { 
    sliderAConfig, 
    sliderBConfig, 
    sliderCConfig, 
    sliderDConfig, 
    sliderEConfig 
} from "@jsHandler/slider/slidersConfig";

class SliderHandler {
    constructor(payload) {
        var { boostify, emitter, instances, terraDebug } = payload;
        this.boostify = boostify;
        this.emitter = emitter;
        this.instances = instances;
        this.terraDebug = terraDebug;

        this.init();
        this.events();
    }

    init() {}

    get updateTheDOM() {
        return {
            slidera: document.querySelectorAll('.js--slider-a'),
            sliderb: document.querySelectorAll('.js--slider-b'),
            sliderc: document.querySelectorAll('.js--slider-c'),
            sliderd: document.querySelectorAll('.js--slider-d'),
        };
    }

    createSliderAInstance({ slider, index }) {
        const Slider = window['lib']['Slider'];
        if (!this.instances["SliderA"]) this.instances["SliderA"] = [];

        this.instances["SliderA"][index] = new Slider({
            slider: slider,
            controls: slider.nextElementSibling,
            config: sliderAConfig,
            windowName: "SliderA",
            index: index
        });
    }

    createSliderBInstance({ slider, index }) {
        const Slider = window['lib']['Slider'];
        if (!this.instances["SliderB"]) this.instances["SliderB"] = [];

        this.instances["SliderB"][index] = new Slider({
            slider: slider,
            navcontainer: slider.nextElementSibling,
            config: sliderBConfig,
            windowName: "SliderB",
            index: index
        });
    }

    createSliderCInstance({ slider, index }) {
        const Slider = window['lib']['Slider'];
        if (!this.instances["SliderC"]) this.instances["SliderC"] = [];

        this.instances["SliderC"][index] = new Slider({
            slider: slider,
            config: sliderCConfig,
            windowName: "SliderC",
            index: index
        });
    }

    createSliderDInstance({ slider, index }) {
        const Slider = window['lib']['Slider'];
        if (!this.instances["SliderD"]) this.instances["SliderD"] = [];

        this.instances["SliderD"][index] = new Slider({
            slider: slider,
            controls: slider.nextElementSibling,
            config: sliderDConfig,
            windowName: "SliderD",
            index: index
        });
    }

    events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;

            // --- SLIDER A ---
            if (this.DOM.slidera.length > 0) {
                if (!window['lib'] || !window['lib']['Slider']) {
                    if (!window['lib']) window['lib'] = {};
                    const { default: Slider } = await import("@jsHandler/slider/Slider.js");
                    window['lib']['Slider'] = Slider;
                }

                this.DOM.slidera.forEach((slider, index) => {
                    if (isElementInViewport({ el: slider, debug: this.terraDebug })) {
                        this.createSliderAInstance({ slider, index });
                    } else {
                        this.boostify.scroll({
                            distance: 15,
                            name: "SliderA",
                            callback: async () => {
                                try {
                                    if (!this.instances["SliderA"]?.[index]) {
                                        this.createSliderAInstance({ slider, index });
                                    }
                                } catch (error) {
                                    this.terraDebug && console.log("Error loading SliderA", error);
                                }
                            }
                        });
                    }
                });
            }

            // --- SLIDER B ---
            if (this.DOM.sliderb.length > 0) {
                if (!window['lib'] || !window['lib']['Slider']) {
                    if (!window['lib']) window['lib'] = {};
                    const { default: Slider } = await import("@jsHandler/slider/Slider.js");
                    window['lib']['Slider'] = Slider;
                }

                this.DOM.sliderb.forEach((slider, index) => {
                    if (isElementInViewport({ el: slider, debug: this.terraDebug })) {
                        this.createSliderBInstance({ slider, index });
                    } else {
                        this.boostify.scroll({
                            distance: 15,
                            name: "SliderB",
                            callback: async () => {
                                try {
                                    if (!this.instances["SliderB"]?.[index]) {
                                        this.createSliderBInstance({ slider, index });
                                    }
                                } catch (error) {
                                    this.terraDebug && console.log("Error loading SliderB", error);
                                }
                            }
                        });
                    }
                });
            }

            // --- SLIDER C ---
            if (this.DOM.sliderc.length > 0) {
                if (!window['lib'] || !window['lib']['Slider']) {
                    if (!window['lib']) window['lib'] = {};
                    const { default: Slider } = await import("@jsHandler/slider/Slider.js");
                    window['lib']['Slider'] = Slider;
                }

                this.DOM.sliderc.forEach((slider, index) => {
                    if (isElementInViewport({ el: slider, debug: this.terraDebug })) {
                        this.createSliderCInstance({ slider, index });
                    } else {
                        this.boostify.scroll({
                            distance: 15,
                            name: "SliderC",
                            callback: async () => {
                                try {
                                    if (!this.instances["SliderC"]?.[index]) {
                                        this.createSliderCInstance({ slider, index });
                                    }
                                } catch (error) {
                                    this.terraDebug && console.log("Error loading SliderC", error);
                                }
                            }
                        });
                    }
                });
            }

            // --- SLIDER D ---
            if (this.DOM.sliderd.length > 0) {
                if (!window['lib'] || !window['lib']['Slider']) {
                    if (!window['lib']) window['lib'] = {};
                    const { default: Slider } = await import("@jsHandler/slider/Slider.js");
                    window['lib']['Slider'] = Slider;
                }

                this.DOM.sliderd.forEach((slider, index) => {
                    if (isElementInViewport({ el: slider, debug: this.terraDebug })) {
                        this.createSliderDInstance({ slider, index });
                    } else {
                        this.boostify.scroll({
                            distance: 15,
                            name: "SliderD",
                            callback: async () => {
                                try {
                                    if (!this.instances["SliderD"]?.[index]) {
                                        this.createSliderDInstance({ slider, index });
                                    }
                                } catch (error) {
                                    this.terraDebug && console.log("Error loading SliderD", error);
                                }
                            }
                        });
                    }
                });
            }
        });

        this.emitter.on("MitterWillReplaceContent", () => {
            this.DOM = this.updateTheDOM;

            // --- DESTROY SLIDER A ---
            if (this.DOM.slidera?.length && this.instances["SliderA"]?.length) {
                this.boostify.destroyscroll({ distance: 15, name: "SliderA" });
                this.DOM.slidera.forEach((_, index) => {
                    this.instances["SliderA"][index]?.destroy?.();
                });
                this.instances["SliderA"] = [];
            }

            // --- DESTROY SLIDER B ---
            if (this.DOM.sliderb?.length && this.instances["SliderB"]?.length) {
                this.boostify.destroyscroll({ distance: 15, name: "SliderB" });
                this.DOM.sliderb.forEach((_, index) => {
                    this.instances["SliderB"][index]?.destroy?.();
                });
                this.instances["SliderB"] = [];
            }

            // --- DESTROY SLIDER C ---
            if (this.DOM.sliderc?.length && this.instances["SliderC"]?.length) {
                this.boostify.destroyscroll({ distance: 15, name: "SliderC" });
                this.DOM.sliderc.forEach((_, index) => {
                    this.instances["SliderC"][index]?.destroy?.();
                });
                this.instances["SliderC"] = [];
            }

            // --- DESTROY SLIDER D ---
            if (this.DOM.sliderd?.length && this.instances["SliderD"]?.length) {
                this.boostify.destroyscroll({ distance: 15, name: "SliderD" });
                this.DOM.sliderd.forEach((_, index) => {
                    this.instances["SliderD"][index]?.destroy?.();
                });
                this.instances["SliderD"] = [];
            }

        });
    }
}

export default SliderHandler;