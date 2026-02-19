import CoreHandler from "../CoreHandler";
class Handler extends CoreHandler {
    constructor(payload) {
        super(payload);

        this.config = ({ element }) => ({
            element,
            selectId: "team-grid-location",
            cardSelector: "#team-grid-people"
        });

        this.init();
        this.events();
    }
    init() {
        super.getLibraryName("FilterPeople");
    }
    get updateTheDOM() {
        return {
            filterContainers: document.querySelectorAll(`#team-grid-location`),
        };
    }
    events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;

            await super.assignInstances({
                elementGroups: [
                    {
                        elements: this.DOM.filterContainers,
                        config: this.config,
                    },
                ],
            });
        });
        this.emitter.on("MitterWillReplaceContent", () => {
            this.DOM = this.updateTheDOM;

            if (this.DOM?.filterContainers?.length) {
                super.destroyInstances();
            }
        });
    }
}
export default Handler;
