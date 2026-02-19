import CoreHandler from "../CoreHandler";
import { 
    sliderAConfig, 
    sliderBConfig, 
    sliderCConfig, 
    sliderDConfig, 
} from "@jsHandler/slider/slidersConfig";

class Handler extends CoreHandler {
    constructor(payload) {
        super(payload);

        this.configSliderA = ({element}) => {
            return {
                slider: element,
                controls: element.nextElementSibling,
                config: sliderAConfig,
                windowName: "SliderA",
                Manager: this.Manager,
            };
        };
        this.configSliderB = ({element}) => {
            return {
                slider: element,
                navcontainer: element.nextElementSibling,
                config: sliderBConfig,
                windowName: "SliderB",
                Manager: this.Manager,
            };
        };
        this.configSliderC = ({element}) => {
            return {
                slider: element,
                config: sliderCConfig,
                windowName: "SliderC",
                Manager: this.Manager,
            };
        };
        this.configSliderD = ({element}) => {
            return {
                slider: element,
                controls: element.nextElementSibling,
                config: sliderDConfig,
                windowName: "SliderD",
                Manager: this.Manager,
            };
        };

        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            sliderA: document.querySelectorAll('.js--slider-a'),
            sliderB: document.querySelectorAll('.js--slider-b'),
            sliderC: document.querySelectorAll('.js--slider-c'),
            sliderD: document.querySelectorAll('.js--slider-d'),
        };
    }

    init() {
        super.getLibraryName("Slider");
    }

    events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;

            super.assignInstances({
                elementGroups: [
                    {
                        elements: this.DOM.sliderA,
                        config: this.configSliderA,
                        boostify: { distance: 30 },
                    },
                    {
                        elements: this.DOM.sliderB,
                        config: this.configSliderB,
                        boostify: { distance: 30 },
                    },
                    {
                        elements: this.DOM.sliderC,
                        config: this.configSliderC,
                        boostify: { distance: 30 },
                    },
                    {
                        elements: this.DOM.sliderD,
                        config: this.configSliderD,
                        boostify: { distance: 30 },
                    },
                ],
            });
        });

        this.emitter.on("MitterWillReplaceContent", () => {
            if (this.DOM.sliderA.length || this.DOM.sliderB.length || this.DOM.sliderC.length || this.DOM.sliderD.length) {
                super.destroyInstances();
            }
        });
    }
}

export default Handler;
