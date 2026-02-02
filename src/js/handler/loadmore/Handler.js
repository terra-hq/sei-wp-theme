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
            elementsLoadNews: document.querySelectorAll(".js--section-news"),
            elementsLoadInsights: document.querySelectorAll(".js--section-insights"),
            elementsLoadCaseStudies: document.querySelectorAll(".js--section-case-studies"),
        };
    }

    init() {}

    createInstanceLoadNews({element, index}) {
        const LoadNews = window['lib']['LoadNews'];
        const loadMoreButton = document.querySelector(".js--load-more-news");
        
        const newsLoadMore = {
            dom: {
                resultsContainer: document.querySelector(".js--news-container"),
                triggerElement: loadMoreButton,
            },
            query: {
                postType: loadMoreButton && loadMoreButton.dataset.postType,
                postPerPage: parseInt(
                    loadMoreButton && loadMoreButton.dataset.postsPerPage
                ),
                offset: parseInt(loadMoreButton && loadMoreButton.dataset.offset),
                total: parseInt(loadMoreButton && loadMoreButton.dataset.postsTotal),
                taxonomies: [],
                action: "load_more",
            },
            isPagination: false,
            callback: {
                onStart: () => { },
                onComplete: () => { },
            },
        };
        
        this.instances["LoadNews"][index] = new LoadNews(newsLoadMore);
    }

    createInstanceLoadInsights({element, index}) {
        const LoadInsights = window['lib']['LoadInsights'];
        const loadMoreButton = document.querySelector(".js--load-more-posts");
        const featuredInsightElement = document.querySelector(".js--featured-insight");
        const page_id = featuredInsightElement && featuredInsightElement.dataset.pageId;
        
        const insightsLoadMore = {
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
                page_id: page_id,
                taxonomies: [],
                action: "load_insights",
            },
            isPagination: false,
            callback: {
                onStart: () => { },
                onComplete: () => { },
            },
        };
        
        this.instances["LoadInsights"][index] = new LoadInsights(insightsLoadMore);
    }
    createInstanceLoadCaseStudies({element, index}) {
        const LoadCaseStudies = window['lib']['LoadCaseStudies'];
        const loadMoreButton = document.querySelector(".js--load-more-posts");
        const featuredInsightElement = document.querySelector(".js--featured-insight");
        const page_id = featuredInsightElement && featuredInsightElement.dataset.pageId;
        
        const caseStudiesLoadMore = {
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
            callback: {
                onStart: () => { },
                onComplete: () => { },
            },
        };
        
        this.instances["LoadCaseStudies"][index] = new LoadCaseStudies(caseStudiesLoadMore);
    }
    events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;
            if (this.DOM.elementsLoadNews.length) {
                this.instances["LoadNews"] = [];
                if (!window['lib']['LoadNews']) {
                        const { default: LoadNews } = await import ("@jsHandler/loadmore/LoadNews");
                        window['lib']['LoadNews'] = LoadNews;
                }
                this.DOM.elementsLoadNews.forEach((element, index) => {
                    if (isElementInViewport({ el: element, debug: this.terraDebug })) {
                        this.createInstanceLoadNews({element, index});
                    } else {
                        this.boostify.scroll({
                            distance: 10,
                            name: "LoadNews",
                            callback: () => {
                                this.createInstanceLoadNews({element, index});
                            },
                        });
                    }
                });
            }
            if (this.DOM.elementsLoadInsights.length) {
                this.instances["LoadInsights"] = [];
                if (!window['lib']['LoadInsights']) {
                        const { default: LoadInsights } = await import ("@jsHandler/loadmore/LoadInsights");
                        window['lib']['LoadInsights'] = LoadInsights;
                }
                this.DOM.elementsLoadInsights.forEach((element, index) => {
                    if (isElementInViewport({ el: element, debug: this.terraDebug })) {
                        this.createInstanceLoadInsights({element, index});
                    } else {
                        this.boostify.scroll({
                            distance: 10,
                            name: "LoadInsights",
                            callback: () => {
                                this.createInstanceLoadInsights({element, index});
                            },
                        });
                    }
                });
            }
            if (this.DOM.elementsLoadCaseStudies.length) {
                this.instances["LoadCaseStudies"] = [];
                if (!window['lib']['LoadCaseStudies']) {
                        const { default: LoadCaseStudies } = await import ("@jsHandler/loadmore/LoadCaseStudies");
                        window['lib']['LoadCaseStudies'] = LoadCaseStudies;
                }
                this.DOM.elementsLoadCaseStudies.forEach((element, index) => {
                    if (isElementInViewport({ el: element, debug: this.terraDebug })) {
                        this.createInstanceLoadCaseStudies({element, index});
                    } else {
                        this.boostify.scroll({
                            distance: 10,
                            name: "LoadCaseStudies",
                            callback: () => {
                                this.createInstanceLoadCaseStudies({element, index});
                            },
                        });
                    }
                });
            }
        });

        this.emitter.on("MitterWillReplaceContent", () => {
            this.DOM = this.updateTheDOM;

            if (this.DOM?.elementsLoadNews?.length && this.instances["LoadNews"]?.length) {
                this.boostify.destroyscroll({ distance: 10, name: "LoadNews" });
                this.DOM.elementsLoadNews.forEach((_, index) => {
                    if (this.instances["LoadNews"][index]?.destroy) {
                        this.instances["LoadNews"][index].destroy();
                    }
                });
                this.instances["LoadNews"] = [];
            }

            if (this.DOM?.elementsLoadInsights?.length && this.instances["LoadInsights"]?.length) {
                this.boostify.destroyscroll({ distance: 10, name: "LoadInsights" });
                this.DOM.elementsLoadInsights.forEach((_, index) => {
                    if (this.instances["LoadInsights"][index]?.destroy) {
                        this.instances["LoadInsights"][index].destroy();
                    }
                });
                this.instances["LoadInsights"] = [];
            }

            if (this.DOM?.elementsLoadCaseStudies?.length && this.instances["LoadCaseStudies"]?.length) {
                this.boostify.destroyscroll({ distance: 10, name: "LoadCaseStudies" });
                this.DOM.elementsLoadCaseStudies.forEach((_, index) => {
                    if (this.instances["LoadCaseStudies"][index]?.destroy) {
                        this.instances["LoadCaseStudies"][index].destroy();
                    }
                });
                this.instances["LoadCaseStudies"] = [];
            }
        });
    }
}

export default Handler;
