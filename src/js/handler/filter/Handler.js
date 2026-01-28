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

    init() {}

    get updateTheDOM() {
        return {
            filterContainers: document.querySelectorAll("#team-grid-location"),
        };
    }

    initializeFilterPeople({ filterSelect, index }) {
        const FilterPeople = window['lib']['FilterPeople'];
        
        this.instances["FilterPeople"][index] = new FilterPeople({
            selectId: "team-grid-location",
            cardSelector: "#team-grid-people"
        });
    }

    events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;
            
            if (this.DOM.filterContainers.length > 0) {
                this.instances["FilterPeople"] = [];
                
                if (!window['lib']['FilterPeople']) {
                    const { default: FilterPeople } = await import("./FilterPeople");
                    window['lib']['FilterPeople'] = FilterPeople;
                }
                
                this.DOM.filterContainers.forEach((filterSelect, index) => {
                    if (isElementInViewport({ el: filterSelect, debug: this.terraDebug })) {
                        this.initializeFilterPeople({ filterSelect, index });
                    } else {
                        this.boostify.scroll({
                            distance: 10,
                            name: "FilterPeople",
                            callback: async () => {
                                try {
                                    this.initializeFilterPeople({ filterSelect, index });
                                } catch (error) {
                                    this.terraDebug && console.log("Error loading FilterPeople", error);
                                }
                            }
                        });
                    }
                });
            }
        });

        this.emitter.on("MitterWillReplaceContent", () => {
            this.DOM = this.updateTheDOM;
            this.boostify.destroyscroll({ distance: 10, name: "FilterPeople" });
            
            if (this.DOM?.filterContainers?.length && this.instances["FilterPeople"]?.length) {
                this.DOM.filterContainers.forEach((_, index) => {
                    if (this.instances["FilterPeople"][index]?.destroy) {
                        this.instances["FilterPeople"][index].destroy();
                    }
                });
                this.instances["FilterPeople"] = [];
            }
        });
    }
}

export default Handler;