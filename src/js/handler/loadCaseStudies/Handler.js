import CoreHandler from "../CoreHandler";

class Handler extends CoreHandler {
    constructor(payload) {
        super(payload);
        this.configLoadCaseStudies = ({element}) => {
            const loadMoreButton = document.querySelector(".js--load-more-posts");
            const featuredInsightElement = document.querySelector(".js--featured-insight");
            const page_id = featuredInsightElement && featuredInsightElement.dataset.pageId;
            return {
                dom: {
                    resultsContainer: document.querySelector(".js--results-container"),
                    searchBar: document.querySelector(".js--posts-search"),
                    industryFilter: document.querySelectorAll(".js--case-study-industry-dropdown"),
                    capabilityFilter: document.querySelectorAll(".js--case-study-capability-dropdown"),
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
                    page_id: page_id,
                    taxonomies: [],
                    action: "load_case_studies",
                },
                isPagination: false,
            };
        };

        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            elementsLoadCaseStudies: document.querySelectorAll(".js--section-case-studies"),
        };
    }

    init() {
        super.getLibraryName("LoadCaseStudies");
    }

    events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;

            super.assignInstances({
                elementGroups: [
                    {
                        elements: this.DOM.elementsLoadCaseStudies,
                        config: this.configLoadCaseStudies,
                        boostify: { distance: 30 },
                    },
                ],
            });
        });

        this.emitter.on("MitterWillReplaceContent", () => {
            if (this.DOM.elementsLoadCaseStudies.length ) {
                super.destroyInstances();
            }
        });
    }
}

export default Handler;
