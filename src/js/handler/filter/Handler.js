import { isElementInViewport } from "@terrahq/helpers/isElementInViewport";

class Handler {
    constructor(payload) {
        var { emitter, instances, boostify, terraDebug, libManager, DOM } = payload;
        this.boostify = boostify;
        this.emitter = emitter;
        this.instances = instances;
        this.terraDebug = terraDebug;
        this.libManager = libManager;

        this.currentTrigger = null;
        this.triggerClickHandler = null;

        this.DOM = {
            selectElement: document.querySelector("#team-grid-location"),
            resultsSection: document.querySelector("#team-grid-people"),
        }

        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            selectElement: document.querySelector("#team-grid-location"),
            resultsSection: document.querySelector("#team-grid-people"),
        };
    }

    init() {
        if (this.DOM.selectElement && this.DOM.resultsSection) {
            if (isElementInViewport({ el: this.DOM.resultsSection, debug: this.terraDebug })) {
                this.initializeFilterPeople();
            } else {
                this.boostify.observer({
                    options: {
                        root: null,
                        rootMargin: "0px",
                        threshold: 0.5,
                    },
                    element: this.DOM.selectElement,
                    callback: () => {
                        this.initializeFilterPeople();
                    },
                });
            }
        }
    }

    async initializeFilterPeople() {
        import("@js/handler/filter/FilterPeople")
        .then(({ default: FilterPeople }) => {
            this.instances["FilterPeople"] = new FilterPeople({
                selectId: "team-grid-location",
                cardSelector: "#team-grid-people",
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
        if (this.instances["FilterPeople"] && this.instances["FilterPeople"].length > 0) {
            this.instances["FilterPeople"].destroy();
            this.instances["FilterPeople"] = [];
        }
    }
}

export default Handler;
