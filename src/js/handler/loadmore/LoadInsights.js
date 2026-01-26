import axios from "axios";
import qs from "qs";
import { u_addClass, u_removeClass, u_style } from "@andresclua/jsutil";
import { createHistoryRecord } from 'swup';
const postURL = base_wp_api.ajax_url;

class LoadInsights {
    constructor(payload) {
        this.payload = payload;
        const { postType, postPerPage, offset, total, taxonomies, action } = this.payload.query;
        const { resultsContainer, searchBar, typesFilter, capabilityFilter, topicsFilter, triggerElement, noResultsElement, resultsNumber, loader, spinner } = this.payload.dom;
        this.init();
        this.events();
    }

    init() {
        this.payload.dom.loader.style.display = 'none';
        this.payload.dom.spinner.style.display = 'none';
        this.payload.dom.resultsNumber.style.display = 'none';
        var postTotal = this.payload.dom.triggerElement.dataset.postsTotal
        this.payload.dom.resultsContainer.style.display = postTotal == 0 ? 'block' : 'flex';
        this.checkVisibilityLoadMore();
        if (this.payload.dom.searchBar) {
            this.searchBarFunctionality();
        }

        if (this.payload.dom.typesFilter) {
            this.taxonomyFiltersFunctionality(this.payload.dom.typesFilter);
        }

        if (this.payload.dom.capabilityFilter) {
            this.taxonomyFiltersFunctionality(this.payload.dom.capabilityFilter);
        }

        if (this.payload.dom.topicsFilter) {
            this.taxonomyFiltersFunctionality(this.payload.dom.topicsFilter);
        }

        this.checkUrlParams();
    }

    events() {
        this.payload.dom.triggerElement && this.payload.dom.triggerElement.addEventListener("click", this.handleTriggerElementClick);
    }

    checkUrlParams() {
        const urlParams = new URLSearchParams(window.location.search);
        if (!urlParams.has('cap') && !urlParams.has('topic') && !urlParams.has('query')) {
            this.payload.dom.resultsNumber.style.display = 'none';
        } else {
            this.payload.dom.resultsNumber.style.display = 'block';
            var postsTotal = this.payload.dom.triggerElement.dataset.postsTotal ? this.payload.dom.triggerElement.dataset.postsTotal : 0;this.payload.dom.triggerElement.dataset.postsTotal
            this.payload.dom.resultsNumber.children[0].innerHTML = `${postsTotal} ${postsTotal === 1 ? 'result' : 'results'}`;
        }
    }

    handleTriggerElementClick = () => {
        this.payload.dom.spinner.style.display = 'block';
        this.payload.query.offset += this.payload.query.postPerPage;
        this.loadMore(false);
    };

    async loadMore(resetHtml, bool = true) {
        try {
            if(!bool){
                this.payload.dom.loader.style.display = 'block';
                this.payload.dom.triggerElement.style.display = 'none';
                this.payload.dom.resultsContainer.style.display = 'none';
            }
            this.payload.query.isLoadMore = bool;
            const results = await this.loadMoreServicePost(this.payload.query);
            resetHtml ? (this.payload.dom.resultsContainer.innerHTML = results.data.html) : (this.payload.dom.resultsContainer.innerHTML += results.data.html);
            if (!this.payload.query.repeater) {
                this.payload.query.total = results.data.postsTotal;
            }

            if(!bool){
                this.payload.dom.resultsNumber.style.display = 'block';
                this.payload.dom.resultsNumber.children[0].innerHTML = `${results.data.postsTotal} ${results.data.postsTotal === 1 ? 'result' : 'results'}`;
                this.payload.dom.loader.style.display = 'none';
                this.payload.dom.triggerElement.style.display = 'block';
                this.payload.dom.resultsContainer.style.display = 'flex';
            }

            this.payload.dom.spinner.style.display = 'none';


            this.checkForEmptyParams();
            this.checkVisibilityLoadMore();

            u_style(this.payload.dom.noResultsElement, [{ display: results.data.postsTotal === 0 ? "block" : "none" }]);

            if (this.payload.callback.onComplete) {
                this.payload.callback.onComplete();
            }
        } catch (error) {
            console.log(error);
        }
    }

    searchBarFunctionality() {
        if (this.payload.dom.searchBar.value) {
            this.payload.query.searchTerm = this.payload.dom.searchBar.value;
        }

        this.payload.dom.searchBar.addEventListener("keydown", (event) => {
            if (event.key === "Enter") {
                event.preventDefault();
            }
        });

        this.payload.dom.searchBar.addEventListener("keyup", this.handleSearchBarKeyup);
    }

    handleSearchBarKeyup = () => {
        this.payload.query.offset = 0;
        this.payload.query.searchTerm = this.payload.dom.searchBar.value;
        this.handleQueryParams("query", this.payload.dom.searchBar.value);
        this.loadMore(true, false);
    };

    taxonomyFiltersFunctionality(filters) {
        filters.forEach((filter) => {
            for (let i = 0; i < filter.options.length; i++) {
                const option = filter.options[i];
                if (option.selected && option.value !== "all") {
                    this.payload.query.taxonomies.push({ [filter.dataset.type]: option.value });
                }
            }
            filter.addEventListener("change", this.handleFilterChange);
        });
    }

    handleFilterChange = (event) => {
        const filter = event.target;
        this.payload.query.offset = 0;
        this.payload.query.taxonomies = this.payload.query.taxonomies.filter((taxonomy) => !taxonomy.hasOwnProperty(filter.dataset.type));
        if (filter.value !== "all") {
            this.payload.query.taxonomies.push({ [filter.dataset.type]: filter.value });
        }
        this.handleQueryParams(filter.dataset.type, filter.value, filter.dataset.taxonomySlug);
        this.loadMore(true, false);
    };

    checkForEmptyParams() {
        const urlParams = new URLSearchParams(window.location.search);
        if (!urlParams.has('cap') && !urlParams.has('topic') && !urlParams.has('query')) {
            this.payload.dom.resultsNumber.style.display = 'none';
        } else {
            this.payload.dom.resultsNumber.style.display = 'block';
        }
    }

    async loadMoreServicePost(query) {
        let dataToSubmit = null;
        try {
            dataToSubmit = await axios.post(postURL, qs.stringify(query));
        } catch (error) {
            console.log(error);
        }
        return dataToSubmit;
    }

    checkVisibilityLoadMore() {
        var postCount = this.payload.query.offset + this.payload.query.postPerPage;
        var postTotal = this.payload.query.total;
        this.payload.dom.triggerElement && u_style(this.payload.dom.triggerElement, [{ display: postCount < postTotal ? "flex" : "none" }]);
    }

    handleQueryParams(query, value, slug) {
        const urlParams = new URLSearchParams(window.location.search);
        if (query !== "query" && query !== "pagination") {
        value !== "all" ? urlParams.set(slug, value) : urlParams.delete(slug);
        } else if (query == "pagination") {
        urlParams.set(query, value);
        } else {
        value ? urlParams.set(query, value) : urlParams.delete(query);
        }

        const newSearch = urlParams.toString();
        const newUrl = newSearch ? `${location.pathname}?${newSearch}` : `${location.pathname}`;

        createHistoryRecord(newUrl);
        return;
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

export default LoadInsights;
