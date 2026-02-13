import CoreHandler from "../CoreHandler";

class Handler extends CoreHandler {
    constructor(payload) {
        super(payload);

        this.config = ({element}) => {
            return {
                element: element,
                resultsContainer: document.getElementById("js--load-all-job-results"),
                filterLocation: document.getElementById("js--filter-locations"),
                filterPracticeAreas: document.getElementById("js--filter-pratice-areas"),
                loader: document.querySelector(".js--loading"),
            };
        };

        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            elements: document.querySelectorAll(`.js--load-all-jobs`),
        };
    }

    init() {
        super.getLibraryName("GetAllJobs");
    }

    events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;

            super.assignInstances({
                elementGroups: [
                    {
                        elements: this.DOM.elements,
                        config: this.config,
                        boostify: { distance: 30 },
                    },
                ],
            });
        });

        this.emitter.on("MitterWillReplaceContent", () => {
            if (this.DOM.elements.length) {
                super.destroyInstances();
            }
        });
    }
}

export default Handler;
