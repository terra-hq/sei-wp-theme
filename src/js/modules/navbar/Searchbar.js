import { debounce } from "./../../../../node_modules/@andresclua/debounce-throttle/dist/debounce-trottle.es";
import { GET_CUSTOM_ENDPOINT } from "./../../services/GET/index.js";

class Searchbar {
  constructor(closeSearchCallback) {
    this.DOM = {
      searchBar: document.getElementById("js--search-input"),
      results: document.getElementById("js--search-results__number"),
      resultsContainer: document.getElementById("js--search-results"),
      spinner: document.querySelector(".g--spinner-01"),
    };
    this.keyword = "";
    this.debouncedHandleSearchBarKeyup = debounce(this.handleSearchBarKeyup, 300);
    this.events();
    this.closeSearchCallback = closeSearchCallback;
  }

  events() {
    this.DOM.spinner.style.display = 'none';
    this.DOM.searchBar.addEventListener("keyup", this.debouncedHandleSearchBarKeyup);
    this.DOM.searchBar.addEventListener("focus", this.handleSearchBarFocus);
  }

  handleSearchBarFocus = () => {
    // Add a delay to prevent immediate closure of the search bar
    setTimeout(() => {
      this.DOM.searchBar.focus();
    }, 100);
  }

  handleSearchBarKeyup = (e) => {
    const currentKeyword = e.target.value.trim();

    if (currentKeyword === "") {
      this.DOM.spinner.style.display = 'none';
      this.DOM.resultsContainer.innerHTML = "";
      this.DOM.results.innerHTML = "";
      return;
    }

    this.DOM.spinner.style.display = 'flex';

    if (currentKeyword !== this.keyword) {
      this.keyword = currentKeyword;

      // Reset after a new search
      this.DOM.resultsContainer.innerHTML = "";
      this.DOM.results.innerHTML = "";

      this.getContent(this.keyword)
        .then((results) => {
          this.DOM.spinner.style.display = 'none';
          if (results.data.length > 0) {
            const keyword = this.keyword.toLowerCase();
            let filteredResults = results.data.filter((element) => element.post_title.toLowerCase().includes(keyword));

            // Order by post type
            filteredResults.sort((a, b) => {
              const postTypeOrder = {
                page: 1,
                capability: 2,
                industry: 3,
                location: 4,
                partnerships: 5,
                insight: 6,
              };

              // If it's not contemplated in postTypeOrder it goes last
              const typeA = postTypeOrder[a.post_type] || 99;
              const typeB = postTypeOrder[b.post_type] || 99;

              return typeA - typeB;
            });

            // Reset
            this.DOM.resultsContainer.innerHTML = "";
            this.DOM.results.innerHTML = filteredResults.length === 1 ? "1 result" : `${filteredResults.length} results`;

            filteredResults.forEach((element) => {
              const link = document.createElement("a");
              link.href = element.permalink;
              link.innerHTML = element.post_title;
              link.classList.add("c--search-a__ft__item");
              link.addEventListener('click', (event) => {
                this.closeSearchCallback(); // Call the callback to reset the search
                setTimeout(() => {
                  this.clearSearch(); // Clear the search input and results after a short delay
                }, 100);
              });
              this.DOM.resultsContainer.appendChild(link);
            });
            if (filteredResults.length === 0) {
              const link = document.createElement("p");
              link.textContent = "No results found. Please try another search.";
              link.classList.add("c--search-a__ft__title");
              this.DOM.resultsContainer.appendChild(link);
            }
          } else {
            const link = document.createElement("p");
            link.textContent = "No results found. Please try another search.";
            link.classList.add("c--search-a__ft__title");
            this.DOM.resultsContainer.appendChild(link);
          }
        })
        .catch((error) => {
          console.error(error);
          this.DOM.spinner.style.display = 'none'; // Hide spinner on error
        });
    } else {
      this.DOM.spinner.style.display = 'none';
    }
  };

  clearSearch() {
    this.DOM.searchBar.value = "";
    this.DOM.resultsContainer.innerHTML = "";
    this.DOM.results.innerHTML = "";
  }

  async getContent(obj) {
    return await GET_CUSTOM_ENDPOINT({
      ACTION: "get_results",
      keyword: obj,
    });
  }
}

export default Searchbar;
