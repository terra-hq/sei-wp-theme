import { isElementInViewport } from "@terrahq/helpers/isElementInViewport";
class Handler {
    constructor(payload) {
        var { emitter, instances, boostify, terraDebug, libManager } = payload;
        this.boostify = boostify;
        this.emitter = emitter;
        this.instances = instances;
        this.terraDebug = terraDebug;
        this.libManager = libManager;

        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            elements: document.querySelectorAll(".js--load-jobs"),
        };
    }

    init() {}

    createInstanceLocationJobs({element, index}) {
        const LocationJobs = window['lib']['LocationJobs'];
        this.instances["LocationJobs"][index] = new LocationJobs({
            element: element,
            job_id: element.getAttribute("data-location-id"),
        });
    }

    events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;
            if (this.DOM.elements.length) {
            this.instances["LocationJobs"] = [];
                if (!window['lib']['LocationJobs']) {
                        const { default: LocationJobs } = await import ("@jsHandler/locationJobs/LocationJobs");
                        window['lib']['LocationJobs'] = LocationJobs;
                }
                this.DOM.elements.forEach((element, index) => {
                    if (isElementInViewport({ el: element, debug: this.terraDebug })) {
                        this.createInstanceLocationJobs({element, index});
                    } else {
                        this.boostify.scroll({
                            distance: 10,
                            name: "LocationJobs",
                            callback: () => {
                                this.createInstanceLocationJobs({element, index});
                            },
                        });
                    }
                });
            }
        });

        this.emitter.on("MitterWillReplaceContent", () => {
            this.DOM = this.updateTheDOM;
            this.boostify.destroyscroll({ distance: 10, name: "LocationJobs" });
            if (this.DOM?.elements?.length && this.instances["LocationJobs"]?.length) {
                this.DOM.elements.forEach((_, index) => {
                    if (this.instances["LocationJobs"][index]?.destroy) {
                        this.instances["LocationJobs"][index].destroy();
                    }
                });
                this.instances["LocationJobs"] = [];
            }
        });
    }
}

export default Handler;
