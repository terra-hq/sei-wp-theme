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
            elements: document.querySelectorAll(".js--load-all-jobs"),
        };
    }

    init() {}

    createInstanceGetAllJobs({element, index}) {
        const GetAllJobs = window['lib']['GetAllJobs'];
        this.instances["GetAllJobs"][index] = new GetAllJobs({
            element: element,
            resultsContainer: document.getElementById("js--load-all-job-results"),
            filterLocation: document.getElementById("js--filter-locations"),
            filterPracticeAreas: document.getElementById("js--filter-pratice-areas"),
            loader: document.querySelector(".js--loading"),
        });
    }

    events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;
            if (this.DOM.elements.length) {
            this.instances["GetAllJobs"] = [];
                if (!window['lib']['GetAllJobs']) {
                        const { default: GetAllJobs } = await import ("@jsHandler/jobs/GetAllJobs");
                        window['lib']['GetAllJobs'] = GetAllJobs;
                }
                this.DOM.elements.forEach((element, index) => {
                    if (isElementInViewport({ el: element, debug: this.terraDebug })) {
                        this.createInstanceGetAllJobs({element, index});
                    } else {
                        this.boostify.scroll({
                            distance: 10,
                            name: "GetAllJobs",
                            callback: () => {
                                this.createInstanceGetAllJobs({element, index});
                            },
                        });
                    }
                });
            }
        });

        this.emitter.on("MitterWillReplaceContent", () => {
            this.DOM = this.updateTheDOM;
            this.boostify.destroyscroll({ distance: 10, name: "GetAllJobs" });
            if (this.DOM?.elements?.length && this.instances["GetAllJobs"]?.length) {
                this.DOM.elements.forEach((_, index) => {
                    if (this.instances["GetAllJobs"][index]?.destroy) {
                        this.instances["GetAllJobs"][index].destroy();
                    }
                });
                this.instances["GetAllJobs"] = [];
            }
        });
    }
}

export default Handler;
