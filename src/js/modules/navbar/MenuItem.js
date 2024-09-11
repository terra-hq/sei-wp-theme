import gsap from "gsap";
import axios from 'axios';

class MenuItem {
  constructor(payload) {
    this.DOM = {
      menuItem: payload.menuItem,
      dropdown: payload.dropdown,
      dropdownItem: payload.dropdownItem,
      header: document.querySelector(".c--header-a"),
      overlay: document.querySelector(".c--overlay-b"), // Add overlay to DOM
    };
    //this.isOpen = false; // Initialize as closed
    this.contentLoaded = false; // Track if the content has been loaded
    this.isLoading = false; // Track if the dropdown is currently loading
    this.init();
    //console.log(this.DOM.dropdown);
  }

  init() {
    // Initial dropdown setting
    gsap.set(this.DOM.dropdown, {
      autoAlpha: 1,
      maxHeight: 0,
      visibility: "hidden",
    });
    gsap.set(this.DOM.overlay, {
      autoAlpha: 0,
      visibility: "hidden",
    });

    // this.DOM.menuItem.addEventListener("click", () => {
    //   if (this.isOpen) {
    //     this.collapse();
    //   } else {
    //     this.open();
    //   }
    // });

    //when overlay-b is clicked closes the dropdown
    this.DOM.overlay.addEventListener('click', () => {
      this.collapse();
    });
  }

  open() {
    //TODO this pointer events logic may require an upgrade 
    document.querySelectorAll('.js--nav-item').forEach(item => {
      item.style.pointerEvents = 'none';
    });
    if (!this.contentLoaded) {
      this.loadContent().then(() => {
        setTimeout(() => {
          this.animateOpen();
        }, 200);
      });
    } else {
      this.animateOpen();
    }
  }

  animateOpen() {
    //console.log("Opening menu...");
    gsap.set(this.DOM.dropdown, {
      overflow: "hidden",
    });
    gsap.to(this.DOM.overlay, {
      // Animate overlay visibility first
      autoAlpha: 1,
      duration: 0.1,
      ease: "linear",
      onStart: () => {
        this.DOM.overlay.classList.add("c--overlay-b--is-visible");
        this.DOM.overlay.style.visibility = "visible";
      },
    });
    gsap.to(this.DOM.dropdown, {
      maxHeight: 500,
      visibility: "inherit",
      duration: 0.2,
      ease: "linear",
      onComplete: () => {
        gsap.set(this.DOM.dropdown, { overflow: "auto" });
        this.DOM.header.classList.add("c--header-a--is-active"); // Add active class to header
        //console.log("Menu opened, active and visible classes added.");
        document.querySelectorAll('.js--nav-item').forEach(item => {
          item.style.pointerEvents = 'auto';
        });
        //we update the isOpen value when clicking the dropdown elements. They're loaded dynamically so we can't bind the event before they exist
        document.querySelectorAll('.js--dropdown a').forEach(link => {
          link.addEventListener('click', () => {
            this.isOpen = false;
          });
        });
      },
    });
  }

  collapse() {
    //console.log("Collapsing menu...");
    gsap.to(this.DOM.dropdown, {
      maxHeight: 0,
      duration: 0.1,
      ease: "power1.in",
      onComplete: () => {
        this.isOpen = false;
        this.DOM.header.classList.remove("c--header-a--is-active"); // Remove active class from header
        setTimeout(() => {
          // Add a delay before hiding the overlay
          if (!document.querySelector(".c--header-a--is-active")) {
            gsap.to(this.DOM.overlay, {
              // Animate overlay visibility
              autoAlpha: 0,
              duration: 0.3,
              ease: "linear",
              onComplete: () => {
                this.DOM.overlay.classList.remove("c--overlay-b--is-visible");
                this.DOM.overlay.style.visibility = "hidden";
              },
            });
          }
        }, 100); // 100ms delay before hiding the overlay
        //console.log("Menu collapsed, active and visible classes removed.");
      },
    });
  }

  async loadContent() {
    try {
      this.DOM.menuItem.classList.add("is-loading");
      this.isLoading = true;
      const params = {
        action: "load_header_dynamic",
        page_id: base_wp_api.page_id,
        index: this.DOM.menuItem.getAttribute("data-id"),
        wrapper: this.DOM.dropdown.getAttribute("data-wrapper"),
      };

      const res = await axios.get(base_wp_api.ajax_url, {
        params: params,
      });

      if (res.data) {
        this.DOM.dropdown.innerHTML = res.data;
        this.contentLoaded = true;
        this.isLoading = false;
      }
    } catch (error) {
      console.error("Failed to load content:", error);
    } finally {
      this.DOM.menuItem.classList.remove("is-loading");

    }
  }

}

export default MenuItem;
