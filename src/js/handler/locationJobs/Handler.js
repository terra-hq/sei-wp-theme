import { isElementInViewport } from "@terrahq/helpers/isElementInViewport";

class Handler {
    constructor(payload) {
        var { emitter, instances, boostify, terraDebug, libManager } = payload;
        this.boostify = boostify;
        this.emitter = emitter;
        this.instances = instances;
        this.terraDebug = terraDebug;
        this.libManager = libManager;

        this.DOM = {
            elements: document.querySelectorAll(".js--load-jobs"),
        }

        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            elements: document.querySelectorAll(".js--load-jobs"),
        };
    }

    init() {
        if (this.DOM.elements.length) {
            this.instances["LocationJobs"] = [];
            this.DOM.elements.forEach((element, index) => {
                if (isElementInViewport({ el: element, debug: this.terraDebug })) {
                    this.initializeLocationJobs(element, index);
                } else {
                    this.boostify.observer({
                        options: {
                            root: null,
                            rootMargin: "0px",
                            threshold: 0.5,
                        },
                        element: element,
                        callback: () => {
                            this.initializeLocationJobs(element, index);
                        },
                    });
                }
            });
        }
    }

    async initializeLocationJobs(element, index) {
        import("@jsModules/LocationJobs")
        .then(({ default: LocationJobs }) => {
            this.instances["LocationJobs"][index] = new LocationJobs({
                element: element,
                job_id: element.getAttribute("data-location-id"),
            });
        })
    }

    events() {
        this.emitter.on("MitterWillReplaceContent", () => {
            this.destroy();
        });
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;
            this.init();
        });
    }

    destroy() {
        if (
            this.DOM.elements.length &&
            this.instances["LocationJobs"] &&
            this.instances["LocationJobs"].length
        ) {
            this.boostify.destroyscroll({ distance: 1, name: "LocationJobs" });
            this.DOM.elements.forEach((element, index) => {
                if (this.instances["LocationJobs"][index]) {
                    this.instances["LocationJobs"][index].destroy();
                }
            });
            this.instances["LocationJobs"] = [];
        }
    }
}

export default Handler;
