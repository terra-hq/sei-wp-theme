import CoreHandler from "../CoreHandler";

class Handler extends CoreHandler {
    constructor(payload) {
        super(payload);

        this.configLoadInsights = ({element}) => {
            const loadMoreButton = document.querySelector(".js--load-more-posts");
            const featuredInsightElement = document.querySelector(".js--featured-insight");
            const page_id = featuredInsightElement && featuredInsightElement.dataset.pageId;
            return {
                dom: {
                    resultsContainer: document.querySelector(".js--results-container"),
                    searchBar: document.querySelector(".js--posts-search"),
                    typesFilter: document.querySelectorAll(".js--insight-types-dropdown"),
                    capabilityFilter: document.querySelectorAll(".js--insight-capability-dropdown"),
                    topicsFilter: document.querySelectorAll(".js--topics-dropdown"),
                    triggerElement: loadMoreButton,
                    noResultsElement: document.querySelector(".js--no-results-message"),
                    resultsNumber: document.querySelector(".js--results-number"),
                    loader: document.querySelector(".js--loading"),
                    spinner: document.querySelector(".js--spinner-load-more"),
                },
                query: {
                    postType: loadMoreButton && loadMoreButton.dataset.postType,
                    postPerPage: parseInt(
                        loadMoreButton && loadMoreButton.dataset.postsPerPage
                    ),
                    offset: parseInt(loadMoreButton && loadMoreButton.dataset.offset),
                    total: parseInt(loadMoreButton && loadMoreButton.dataset.postsTotal),
                    page_id,
                    taxonomies: [],
                    action: "load_insights",
                },
                isPagination: false,
            };
        };
        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            elementsLoadInsights: document.querySelectorAll(".js--section-insights"),
        };
    }

    init() {
        super.getLibraryName("LoadInsights");
    }

    events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;

            super.assignInstances({
                elementGroups: [
                    {
                        elements: this.DOM.elementsLoadInsights,
                        config: this.configLoadInsights,
                        boostify: { distance: 30 },
                    },
                ],
            });
        });

        this.emitter.on("MitterWillReplaceContent", () => {
            if (this.DOM.elementsLoadInsights.length) {
                super.destroyInstances();
            }
        });
    }
}

export default Handler;
