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
            elements: document.querySelectorAll(".js--load-all-jobs"),
        }

        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            elements: document.querySelectorAll(".js--load-all-jobs"),
        };
    }

    init() {
        if (this.DOM.elements.length) {
            this.instances["GetAllJobs"] = [];
            this.DOM.elements.forEach((element, index) => {
                if (isElementInViewport({ el: element, debug: this.terraDebug })) {
                    this.initializeGetAllJobs(element, index);
                } else {
                    this.boostify.observer({
                        options: {
                            root: null,
                            rootMargin: "0px",
                            threshold: 0.5,
                        },
                        element: element,
                        callback: () => {
                            this.initializeGetAllJobs(element, index);
                        },
                    });
                }
            });
        }
    }

    async initializeGetAllJobs(element, index) {
        import("@jsModules/GetAllJobs")
        .then(({ default: GetAllJobs }) => {
            this.instances["GetAllJobs"][index] = new GetAllJobs({
                element: element,
                resultsContainer: document.getElementById("js--load-all-job-results"),
                filterLocation: document.getElementById("js--filter-locations"),
                filterPracticeAreas: document.getElementById("js--filter-pratice-areas"),
                loader: document.querySelector(".js--loading"),
            });
        }).catch((error) => {
            console.error("Error loading GetAllJobs module:", error);
        });
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
            Array.isArray(this.instances["GetAllJobs"]) &&
            this.instances["GetAllJobs"].length
        ) {
            this.instances["GetAllJobs"].forEach((instance, index) => {
                if (instance && typeof instance.destroy === "function") {
                    instance.destroy();
                }
            });
            this.instances["GetAllJobs"] = [];
        }
    }
}

export default Handler;
