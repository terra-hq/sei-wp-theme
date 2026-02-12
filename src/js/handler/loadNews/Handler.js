import CoreHandler from "../CoreHandler";

class Handler extends CoreHandler {
    constructor(payload) {
        super(payload);

        this.configLoadNews = ({element}) => {
            const loadMoreButton = document.querySelector(".js--load-more-news");
            return {
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
        };

        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            elementsLoadNews: document.querySelectorAll(".js--section-news"),
        };
    }

    init() {
        super.getLibraryName("LoadNews");
    }

    events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;

            super.assignInstances({
                elementGroups: [
                    {
                        elements: this.DOM.elementsLoadNews,
                        config: this.configLoadNews,
                        boostify: { distance: 30 },
                    },
                ],
            });
        });

        this.emitter.on("MitterWillReplaceContent", () => {
            if (this.DOM.elementsLoadNews.length) {
                super.destroyInstances();
            }
        });
    }
}

export default Handler;
