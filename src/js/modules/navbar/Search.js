import { gsap } from "gsap";
import Searchbar from "./Searchbar";

class Search {
  constructor(options) {
    this.closeAllMenus = options.closeAllMenus;
    // DOM references
    this.DOM = {
      searchButton: document.querySelector('.js--search'),
      searchOverlay: document.querySelector('.c--search-a'), // Combined element for search and overlay
      searchMedia: document.querySelector('.c--search-a__media-wrapper'), 
      headerWrapper: document.querySelector('.c--header-a__wrapper'),
      searchInput: document.querySelector('.js--search-input'),
      results: document.getElementById("js--search-results__number"),
      resultsContainer: document.getElementById("js--search-results"),
    };
    // State to track if the search is open
    this.isOpen = false;
    // Store the initial inner HTML of the search button
    this.initialButtonHTML = this.DOM.searchButton.innerHTML;
    // Initialize event listeners
    this.init();
    // Set initial GSAP properties
    gsap.set(this.DOM.searchOverlay, {autoAlpha: 0, maxHeight: 0});
  }

  init() {
    // Toggle search overlay on search button click
    this.DOM.searchButton.addEventListener('click', (event) => {
      event.stopPropagation(); // Stop the click event from propagating to the document
      this.DOM.searchOverlay.style.display = 'block';
      this.toggleSearch();
    });

    // Close the search when clicking outside of the search interface
    // document.addEventListener('click', (event) => {
    //   if (this.isOpen && !this.DOM.searchOverlay.contains(event.target) && event.target !== this.DOM.searchButton) {
    //     this.closeSearch();
    //   }
    // });
  }

  toggleSearch() {
    if (this.isOpen) {
      this.closeSearch();
    } else {
      this.openSearch();
    }
  }

  openSearch() {
    this.isOpen = true;
    this.closeAllMenus(); // Close all menus when search opens
    gsap.to(this.DOM.searchOverlay, {
      autoAlpha: 1,
      maxHeight: '100vh', // Adjust based on your overlay's desired expanded size
      duration: 0.3,
      ease: "power2.out"
    });
    this.DOM.searchButton.innerHTML = '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1L17 17M17 1L1 17" stroke="#000" stroke-width="2"></path></svg>';
    new Searchbar(this.closeSearch.bind(this)); // Pass closeSearch method to Searchbar
  }

  closeSearch() {
    this.isOpen = false;
    gsap.to(this.DOM.searchOverlay, {
      autoAlpha: 0,
      maxHeight: 0,
      duration: 0.3,
      ease: "power2.in"
    });
    this.DOM.searchButton.innerHTML = this.initialButtonHTML; // Restore the original icon

    
  }
}

export default Search;
