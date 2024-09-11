import Burger from './Burger';
import MenuItem from './MenuItem';
import Search from './Search';
import { gsap } from "gsap";
import Flip from "gsap/Flip";
gsap.registerPlugin(Flip);

class Navbar {
    constructor(payload) {
        this.DOM = {
            burger: payload.burger,
            navbar: payload.navbar,
            searchOverlay: payload.searchOverlay,
            searchButton: payload.searchButton,
            menuItem: document.querySelectorAll('.js--nav-item'),
            dropdown: document.querySelectorAll('.js--dropdown'),
            header: document.querySelector('.c--header-a'),
            headerWrapper: document.querySelector('.c--header-a__wrapper'),
            brand: document.querySelector('.c--brand-a__bd__media'),
            listItems: document.querySelectorAll('.c--nav-a__list-group__item'),
        };
        this.menuItems = [];
        this.init();
        this.events();

        this.moveItems();  // Initial call on load
    }

    init() {
        this.burger = new Burger({
            burger: this.DOM.burger,
            navbar: this.DOM.navbar
        });
        this.search = new Search({
            searchOverlay: this.DOM.searchOverlay,
            searchButton: this.DOM.searchButton,
            closeAllMenus: this.closeAllMenuItems.bind(this),
        });

        this.DOM.menuItem.forEach((menuItem, index) => {
            const dropdown = this.DOM.dropdown[index];
            this.menuItems.push(new MenuItem({
                menuItem: menuItem,
                dropdown: dropdown
            }));
        });
        //header fix for mobile flickering
        gsap.to(this.DOM.header, { opacity: 1, duration: 2 });

        // Dynamically import the smooth-scrollbar function,
        // and store it in the window.lib object
        window["boostify"].click({
            element: document.querySelector(".c--header-a__wrapper"),
            callback: async () => {
                try {
                    // Dynamically import smooth-scrollbar
                    const smoothScrollbarModule = await import(/* webpackChunkName: "smooth-scrollbar" */ "smooth-scrollbar");
                    window.lib.smoothScrollbar = smoothScrollbarModule;
                    // Custom options for the scrollbar
                    const options = {
                        damping: 0.1,
                        thumbMinSize: 20,
                        renderByPixels: true,
                        alwaysShowTracks: true,
                    };
        
                    const scrollbarContainer = document.querySelector(".c--search-a__ft");
                    const scrollbarContainer2 = document.querySelector(".c--dropdown-a--second .c--dropdown-a__content");
        
                    if (scrollbarContainer) {
                        // Initialize the scrollbar using the loaded module
                        window.scrollbarInstance1 = window.lib.smoothScrollbar.default.init(scrollbarContainer, options);
                    } else {
                        console.error("Scrollbar container not found.");
                    }
        
                    function initializeScrollbarContainer2() {
                        if (scrollbarContainer2) {
                            if (window.innerWidth <= 1024) {
                                if (!window.scrollbarInstance2) {
                                    // Initialize the scrollbar for the second container if width is 1024px or below
                                    window.scrollbarInstance2 = window.lib.smoothScrollbar.default.init(scrollbarContainer2, options);
                                }
                            } else {
                                if (window.scrollbarInstance2) {
                                    // Destroy the scrollbar if it was previously initialized
                                    window.scrollbarInstance2.destroy();
                                    window.scrollbarInstance2 = null;
                                }
                                // Remove the data-scrollbar attribute and related styles if width is above 1024px
                                scrollbarContainer2.removeAttribute("data-scrollbar");
                                scrollbarContainer2.removeAttribute("tabindex");
                                scrollbarContainer2.style.overflow = '';
                                scrollbarContainer2.style.outline = '';
                            }
                        } else {
                            //console.error("Second scrollbar container not found.");
                        }
                    }
        
                    // Initialize or destroy the scrollbar based on the initial window width
                    initializeScrollbarContainer2();
        
                    // Add event listener for window resize to dynamically initialize/destroy the scrollbar
                    window.addEventListener('resize', initializeScrollbarContainer2);
        
                } catch (error) {
                    //console.error("Error loading script or initializing scrollbar:", error);
                }
            },
        });
        
        
    }

    events() {
        window.addEventListener('resize', () => {
            this.moveItems();  // Handle the menu items position for mobile
            this.closeAllMenuItems();  // Close all menu items when the window is resized
        });

        this.menuItems.forEach((menuItem, index) => {
            const item = this.DOM.menuItem[index];
            const dropdown = this.DOM.dropdown[index];

            // Toggle menu on click
            item.addEventListener('click', event => {
                event.stopPropagation(); // Prevent the event from bubbling up
                //Close search
                if (this.search.isOpen) {
                    this.search.closeSearch();
                }
                if (menuItem.isOpen) {
                    menuItem.collapse();
                    menuItem.isOpen = false;
                } else {
                    this.menuItems.forEach(mi => mi !== menuItem && mi.collapse()); // Collapse all other menus
                    menuItem.open();
                }
            });
        });

        //This function needs improvement
        document.addEventListener('click', () => {
            // Collapse all menu items when clicking outside
            //this.menuItems.forEach(item => item.collapse());
            if (this.search.isOpen) {
                // this.search.closeSearch();
            }
        });
    }

    closeAllMenuItems() {
        this.menuItems.forEach(item => item.collapse());
    }

    moveItems() {
        const width = window.innerWidth;

        const originalContainer = document.querySelector('.c--nav-a__list-group');
        const targetContainer = document.querySelector('.c--sidenav-a__list-group__item--second');//empty li inside the sidenav
        const items = document.querySelectorAll('.c--nav-b');
        const dropdowns = document.querySelectorAll('.c--dropdown-a')

        const shouldMove = width < 1025;
        const toContainer = shouldMove ? targetContainer : originalContainer;

        const state = Flip.getState(items);

        items.forEach(item => {
            toContainer.prepend(item);
        });

        Flip.from(state, {
            duration: 0.0,
            absolute: false
        });
    }
}

export default Navbar;
