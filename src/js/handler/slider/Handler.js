import { isElementInViewport } from "@terrahq/helpers/isElementInViewport";

class SliderHandler {
    constructor(payload) {
        var { boostify, emitter, instances, terraDebug } = payload;
        this.boostify = boostify;
        this.emitter = emitter;
        this.instances = instances;
        this.terraDebug = terraDebug;

        this.slidersDefs = [
            { id: 'sliderA', selector: '.js--slider-a', windowName: 'SliderA' },
            { id: 'sliderB', selector: '.js--slider-b', windowName: 'SliderB' },
            { id: 'sliderC', selector: '.js--slider-c', windowName: 'SliderC' }
        ];

        this.init();
        this.events();
    }

    init() {}

    get updateTheDOM() {
        const domElements = {};
        this.slidersDefs.forEach(def => {
            domElements[def.id] = document.querySelectorAll(def.selector);
        });
        return domElements;
    }

    createInstance({ element, index, typeDef, config }) {
        const SliderClass = window['lib']['Slider'];
        
        if (!this.instances[typeDef.id]) {
            this.instances[typeDef.id] = [];
        }

        this.instances[typeDef.id][index] = new SliderClass({
            slider: element,
            navcontainer: element.nextElementSibling,
            config: config,
            windowName: typeDef.windowName,
            index: index
        });
    }

    events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;

            const hasAnySlider = this.slidersDefs.some(def => this.DOM[def.id].length > 0);

            if (hasAnySlider) {
                if (!window['lib'] || !window['lib']['Slider']) {
                    if (!window['lib']) window['lib'] = {};
                    
                    const [sliderModule, configModule] = await Promise.all([
                        import("@jsHandler/slider/Slider.js"),
                        import("@jsHandler/slider/slidersConfig.js")
                    ]);

                    window['lib']['Slider'] = sliderModule.default;
                    this.configs = configModule; 
                } else if (!this.configs) {
                    this.configs = await import("@jsHandler/slider/slidersConfig.js");
                }

                this.slidersDefs.forEach(def => {
                    const elements = this.DOM[def.id];
                    const configKey = `${def.id}Config`;
                    const config = this.configs[configKey];

                    if (elements.length > 0) {
                        if (!this.instances[def.id]) {
                            this.instances[def.id] = [];
                        }

                        elements.forEach((element, index) => {
                            if (isElementInViewport({ el: element, debug: this.terraDebug })) {
                                this.createInstance({ element, index, typeDef: def, config });
                            } else {
                                this.boostify.scroll({
                                    distance: 15,
                                    name: def.windowName,
                                    callback: async () => {
                                        try {
                                            if (!this.instances[def.id][index]) {
                                                this.createInstance({ element, index, typeDef: def, config });
                                            }
                                        } catch (error) {
                                            this.terraDebug && console.log(`Error loading ${def.windowName}`, error);
                                        }
                                    }
                                });
                            }
                        });
                    }
                });
            }
        });

        this.emitter.on("MitterWillReplaceContent", () => {
            this.DOM = this.updateTheDOM;

            this.slidersDefs.forEach(def => {
                const elements = this.DOM[def.id];
                const instanceArray = this.instances[def.id]; 

                if (elements && elements.length && instanceArray?.length) {
                    this.boostify.destroyscroll({ distance: 15, name: def.windowName });

                    elements.forEach((_, index) => {
                        if (instanceArray[index]) {
                            if (typeof instanceArray[index].destroy === 'function') {
                                instanceArray[index].destroy();
                            }
                        }
                    });
                    this.instances[def.id] = [];
                }
            });
        });
    }
}

export default SliderHandler;