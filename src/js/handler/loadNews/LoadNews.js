import axios from "axios";
import qs from "qs";
import { u_style } from "@andresclua/jsutil";
const postURL = base_wp_api.ajax_url;

class LoadNews {
    constructor(payload) {
        this.payload = payload;

        const { postType, taxonomy, offset, orderBy, order, ...filteredQuery } = this.payload.query;
        const { searchBar, taxonomyFilters, ...filteredDom } = this.payload.dom;
        this.validateProps({ ...filteredDom, ...filteredQuery });

        this.init();
        this.events();
    }

    init() {
        this.checkVisibilityLoadMore();
        if (this.payload.query.postType) {
            this.convertPostType(this.payload.query.postType);
        }
        if (this.payload.dom.searchBar) {
            this.searchBarFunctionality();
        }
        if (this.payload.dom.taxonomyFilters) {
            this.taxonomyFiltersFunctionality();
        }
    }

    events() {
        this.payload.dom.triggerElement && this.payload.dom.triggerElement.addEventListener("click", this.handleTriggerElementClick);
    }

    handleTriggerElementClick = () => {
        this.payload.query.offset += this.payload.query.postPerPage;
        this.loadMore(false);
    };

    async loadMore(resetHtml) {
        try {
            const results = await this.loadMoreServicePost(this.payload.query);
            resetHtml ? (this.payload.dom.resultsContainer.innerHTML = results.data.html) : (this.payload.dom.resultsContainer.innerHTML += results.data.html);
            if (!this.payload.query.repeater) {
                this.payload.query.total = results.data.postsTotal;
            }
            this.checkVisibilityLoadMore();
            if (results.data.postsTotal === 0) {
                this.payload.dom.resultsContainer.innerHTML = this.payload.noResultsMessage;
            }
            this.payload.callback.onComplete &&
                setTimeout(() => {
                    this.payload.callback.onComplete();
                }, 400);
        } catch (error) {
            console.log(error);
        }
    }

    searchBarFunctionality() {
        if (this.payload.dom.searchBar.value) {
            this.payload.query.searchTerm = this.payload.dom.searchBar.value;
        }

        this.payload.dom.searchBar.addEventListener("keyup", this.handleSearchBarKeyup);
    }

    handleSearchBarKeyup = () => {
        this.payload.query.offset = 0;
        this.payload.query.searchTerm = this.payload.dom.searchBar.value;
        this.handleQueryParams("query", this.payload.dom.searchBar.value);
        this.loadMore(true);
    };

    taxonomyFiltersFunctionality() {
        this.payload.dom.taxonomyFilters.forEach((filter) => {
            for (let i = 0; i < filter.options.length; i++) {
                const option = filter.options[i];
                if (option.selected && option.value !== "all") {
                    this.payload.query.taxonomies.push({ [filter.dataset.taxonomy]: option.value });
                }
            }

            filter.addEventListener("change", this.handleFilterChange);
        });
    }

    handleFilterChange = (event) => {
        const filter = event.target;
        this.payload.query.offset = 0;
        this.payload.query.taxonomies = this.payload.query.taxonomies.filter((taxonomy) => !taxonomy.hasOwnProperty(filter.dataset.taxonomy));
        if (filter.value !== "all") {
            this.payload.query.taxonomies.push({ [filter.dataset.taxonomy]: filter.value });
        }
        this.handleQueryParams(filter.dataset.taxonomy, filter.value, filter.dataset.taxonomySlug);
        this.loadMore(true);
    };

    async loadMoreServicePost(query) {
        if (this.payload.callback.onStart) {
            this.payload.callback.onStart();
        }
        let dataToSubmit = null;
        try {
            dataToSubmit = await axios.post(postURL, qs.stringify(query));
        } catch (error) {
            console.log(error);
        }
        return dataToSubmit;
    }

    convertPostType(obj) {
        const string = JSON.stringify(obj);
        this.payload.query.postType = string.replace(/[\[\]]/g, "");
    }

    checkVisibilityLoadMore() {
        var postCount = this.payload.query.offset + this.payload.query.postPerPage;
        var postTotal = this.payload.query.total;
        if (this.payload.dom.triggerElement) {
            u_style(this.payload.dom.triggerElement, [{ display: postCount < postTotal ? "flex" : "none" }]);
            u_style(this.payload.dom.row, [{ display: postCount < postTotal ? "inline-block" : "none" }]);
        }
    }

    errorMessage(message) {
        console.log(`%cLoadMore: The ${message} attribute is required`, "color: red; font-size: 11px; font-weight: bold;");
    }

    validateProps(requiredProps) {
        for (let prop in requiredProps) {
            if (!requiredProps[prop]) {
                this.errorMessage(prop);
            }
        }
    }

    handleQueryParams(query, value, slug) {
        const urlParams = new URLSearchParams(window.location.search);
        if (query !== "query") {
            value !== "all" ? urlParams.set(slug, value) : urlParams.delete(slug);
        } else {
            value ? urlParams.set(query, value) : urlParams.delete(query);
        }
        if (urlParams.size > 0) {
            window.history.replaceState({}, "", `${location.pathname}?${urlParams}`);
        } else {
            window.history.replaceState({}, "", `${location.pathname}`);
        }
    }

    destroy() {
        this.payload.dom.triggerElement && this.payload.dom.triggerElement.removeEventListener("click", this.handleTriggerElementClick);
        this.payload.dom.searchBar && this.payload.dom.searchBar.removeEventListener("keyup", this.handleSearchBarKeyup);
        this.payload.dom.taxonomyFilters &&
            this.payload.dom.taxonomyFilters.forEach((filter) => {
                filter && filter.removeEventListener("change", this.handleFilterChange);
            });
    }
}
export default LoadNews;
