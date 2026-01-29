import { isElementInViewport } from "@terrahq/helpers/isElementInViewport";

class TimelineHandler {
    constructor(payload) {
        var { boostify, emitter, instances, terraDebug } = payload;
        this.boostify = boostify;
        this.emitter = emitter;
        this.instances = instances;
        this.terraDebug = terraDebug;

        this.selectors = {
            element: ".js--timeline-a"
        };

        this.init();
        this.events();
    }

    init() {}

    get updateTheDOM() {
        return {
            timelines: document.querySelectorAll(this.selectors.element),
        };
    }

    createInstance({ element, index }) {
        const TimelineClass = window['lib']['Timeline'];
        
        this.instances["Timeline"][index] = new TimelineClass({
            element: element,
        });
    }

    events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;

            if (this.DOM.timelines.length > 0) {
              
                this.instances["Timeline"] = [];
                if (!window['lib']['Timeline']) {
                    const { default: Timeline } = await import ("@jsHandler/timeline/Timeline.js");
                    window['lib']['Timeline'] = Timeline;
                }

                this.DOM.timelines.forEach((element, index) => {
                    if (isElementInViewport({ el: element, debug: this.terraDebug })) {
                        this.createInstance({ element, index });
                    } else {
                        this.boostify.scroll({
                            distance: 10,
                            name: "Timeline",
                            callback: async () => {
                                try {
                                    if (!this.instances["Timeline"][index]) {
                                        this.createInstance({ element, index });
                                    }
                                } catch (error) {
                                    this.terraDebug && console.log("Error loading Timeline", error);
                                }
                            }
                        });
                    }
                });
            }
        });

        this.emitter.on("MitterWillReplaceContent", () => {
            this.DOM = this.updateTheDOM;
            if (this.DOM?.timelines?.length && this.instances["Timeline"]?.length) {
                this.boostify.destroyscroll({ distance: 15, name: "Timeline" });
                
                this.DOM.timelines.forEach((_, index) => {
                    if (this.instances["Timeline"] && this.instances["Timeline"][index]) {
                        if (typeof this.instances["Timeline"][index].destroy === 'function') {
                            this.instances["Timeline"][index].destroy();
                        }
                    }
                });
                this.instances["Timeline"] = [];
            }
        });
    }
}

export default TimelineHandler;