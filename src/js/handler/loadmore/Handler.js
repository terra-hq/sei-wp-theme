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

        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            loadMoreSections: [
                this.loadMoreNewsConfig(),
                this.loadMorePostsConfig(),
                this.loadMoreInsightsConfig()
            ]
        };
    }

    init() {
        this.DOM = this.updateTheDOM;
        this.initializeLoadMore();
    }

    initializeLoadMore() {
        this.DOM.loadMoreSections.forEach(async (sectionConfig, index) =>  {
            let config = sectionConfig[Object.keys(sectionConfig)[0]];
            
            this.instances[config.libName] = [];

            if (config.dom.triggerElement && (config.condition() !== false)) {
                if (isElementInViewport({ el: config.dom.triggerElement, debug: this.terraDebug })) {
                    this.loadLib(config, index);
                } else {
                    this.boostify.scroll({
                        distance: 0,
                        name: "LoadMore",
                        callback: async () => {
                            this.loadLib(config, index);
                        },
                    });
                }
            }
        });
    }

    events() {
        this.emitter.on("MitterWillReplaceContent", () => {
            this.destroy();
        });
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;
            this.initializeLoadMore();
        });
    }

    destroy() {
        if (this.DOM && this.DOM.loadMoreSections) {
            this.boostify.destroyscroll({ distance: 0, name: "LoadMore" });
            this.DOM.loadMoreSections.forEach((sectionConfig, index) => {
                let config = sectionConfig[Object.keys(sectionConfig)[0]];
                config.destroy?.(index);
            });
        }
    }

    async loadLib(config, index) {
        const LoadLib = await config.lib();
        this.instances[config.libName][index] = new LoadLib(config);
    }

    loadMoreNewsConfig() {
        let triggerElement = document.querySelector(".js--load-more-news");
        return {
            news: {
                libName: 'LoadNews',
                lib: async () => {
                    await import("@js/handler/loadmore/LoadNews").then(({ default: LoadNews }) => {
                        window["lib"]["LoadNews"] = LoadNews;
                    });
                    return window["lib"]["LoadNews"];
                },
                condition: () => {
                    let isNewsPage = triggerElement && triggerElement.dataset.postType === 'news';
                    return isNewsPage;
                },
                dom: {
                    section: document.querySelector(".js--section-news"),
                    triggerElement: triggerElement,
                    resultsContainer: document.querySelector(".js--news-container"),
                },
                query: {
                    postType: triggerElement && triggerElement.dataset.postType,
                    postPerPage: parseInt(
                        triggerElement && triggerElement.dataset.postsPerPage
                    ),
                    offset: parseInt(triggerElement && triggerElement.dataset.offset),
                    total: parseInt(triggerElement && triggerElement.dataset.postsTotal),
                    taxonomies: [],
                    action: "load_more",
                },
                isPagination: false,
                callback: {
                    onStart: () => { },
                    onComplete: () => { },
                },
                destroy: (index) => {
                    this.instances["LoadNews"][index]?.payload.destroy();
                    this.instances["LoadNews"] = [];
                }
            }
        };
    }

    loadMorePostsConfig() {
        let triggerElement = document.querySelector(".js--load-more-posts");
        return {
            caseStudies: {
                libName: 'LoadCaseStudies',
                lib: async () => {
                    await import("@js/handler/loadmore/LoadCaseStudies").then(({ default: LoadCaseStudies }) => {
                        window["lib"]["LoadCaseStudies"] = LoadCaseStudies;
                    });
                    return window["lib"]["LoadCaseStudies"];
                },
                condition: () => {
                    let isCaseStudiesPage = triggerElement && triggerElement.dataset.postType === 'case-study';
                    return isCaseStudiesPage;
                },
                dom: {
                    section: document.querySelector(".js--section-container"),
                    resultsContainer: document.querySelector(".js--results-container"),
                    searchBar: document.querySelector(".js--posts-search"),
                    industryFilter: document.querySelectorAll(".js--case-study-industry-dropdown"),
                    capabilityFilter: document.querySelectorAll(".js--case-study-capability-dropdown"),
                    triggerElement: triggerElement,
                    noResultsElement: document.querySelector(".js--no-results-message"),
                    resultsNumber: document.querySelector(".js--results-number"),
                    loader: document.querySelector(".js--loading"),
                    spinner: document.querySelector(".js--spinner-load-more"),
                },
                query: {
                    postType: triggerElement && triggerElement.dataset.postType,
                    postPerPage: parseInt(
                        triggerElement && triggerElement.dataset.postsPerPage
                    ),
                    offset: parseInt(triggerElement && triggerElement.dataset.offset),
                    total: parseInt(triggerElement && triggerElement.dataset.postsTotal),
                    taxonomies: [],
                    action: "load_case_studies",
                },
                isPagination: false,
                callback: {
                    onStart: () => { },
                    onComplete: () => { },
                },
                destroy: (index) => {
                    this.instances["LoadCaseStudies"][index]?.payload.destroy();
                    this.instances["LoadCaseStudies"] = [];
                }
            }
        };
    }

    loadMoreInsightsConfig() {
        let triggerElement = document.querySelector(".js--load-more-posts");
        let featuredInsightElement = document.querySelector(".js--featured-insight");
        return {
            insights: {
                libName: 'LoadInsights',
                lib: async () => {
                    await import("@js/handler/loadmore/LoadInsights").then(({ default: LoadInsights }) => {
                        window["lib"]["LoadInsights"] = LoadInsights;
                    });
                    return window["lib"]["LoadInsights"];
                },
                condition: () => {
                    let isInsightsPage = triggerElement && triggerElement.dataset.postType === 'insight';
                    return isInsightsPage;
                },
                dom: {
                    section: document.querySelector(".js--section-container"),
                    resultsContainer: document.querySelector(".js--results-container"),
                    searchBar: document.querySelector(".js--posts-search"),
                    typesFilter: document.querySelectorAll(".js--insight-types-dropdown"),
                    capabilityFilter: document.querySelectorAll(".js--insight-capability-dropdown"),
                    topicsFilter: document.querySelectorAll(".js--topics-dropdown"),
                    triggerElement: triggerElement,
                    noResultsElement: document.querySelector(".js--no-results-message"),
                    resultsNumber: document.querySelector(".js--results-number"),
                    loader: document.querySelector(".js--loading"),
                    spinner: document.querySelector(".js--spinner-load-more"),
                },
                query: {
                    postType: triggerElement && triggerElement.dataset.postType,
                    postPerPage: parseInt(triggerElement && triggerElement.dataset.postsPerPage),
                    offset: parseInt(triggerElement && triggerElement.dataset.offset),
                    total: parseInt(triggerElement && triggerElement.dataset.postsTotal),
                    page_id: featuredInsightElement && featuredInsightElement.dataset.pageId,
                    taxonomies: [],
                    action: "load_insights",
                },
                isPagination: false,
                callback: {
                    onStart: () => { },
                    onComplete: () => { },
                },
                destroy: (index) => {
                    this.instances["LoadInsights"][index]?.payload.destroy();
                    this.instances["LoadInsights"] = [];
                }
            }
        }
    }
}

export default Handler;
