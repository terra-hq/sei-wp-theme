import { gsap } from "gsap";

class Burger {
    constructor(payload) {
        // DOM references
        this.DOM = {
            burger: document.querySelector('.js--burger'),
            close: document.querySelector('.js--close'),
            sidenav: document.querySelector('.c--sidenav-a'),
            overlay: document.querySelector('.c--overlay-a'),
        };
        // Initialize event listeners
        this.init();
    }

    init() {
        // Toggle menu on burger button click
        this.DOM.burger.addEventListener('click', () => {
            this.toggleMenu();
        });

        // Close menu on close button click
        this.DOM.close.addEventListener('click', () => {
            this.closeMenu();
        });

        // Close the menu when clicking outside of it
        document.addEventListener('click', (event) => {
            if (!this.DOM.sidenav.contains(event.target) && !this.DOM.burger.contains(event.target)) {
                this.closeMenu();
            }
        });
    }

    // Toggle the visibility of the side navigation and overlay
    toggleMenu() {
        if (this.DOM.sidenav.classList.contains('c--sidenav-a--is-active')) {
            this.closeMenu();
        } else {
            this.openMenu();
        }
    }

    // Open the side navigation and overlay with animation
    openMenu() {
        this.DOM.sidenav.classList.add('c--sidenav-a--is-active');
        gsap.to(this.DOM.sidenav, {
            right: '0%',
            duration: 0.5,
            ease: "power2.out"
        });
        gsap.set(this.DOM.overlay, {display: 'block'}); // Set display to block before fading in
        gsap.to(this.DOM.overlay, {
            autoAlpha: 1, // Fade in effect for the overlay
            duration: 0.5,
            ease: "power2.out"
        });
    }

    // Close the side navigation and overlay with animation
    closeMenu() {
        this.DOM.sidenav.classList.remove('c--sidenav-a--is-active');
        gsap.to(this.DOM.sidenav, {
            right: '-200%',
            duration: 0.5,
            ease: "power2.in"
        });
        gsap.to(this.DOM.overlay, {
            autoAlpha: 0, // Fade out effect for the overlay
            duration: 0.5,
            ease: "power2.in",
            onComplete: () => {
                gsap.set(this.DOM.overlay, {display: 'none'}); // Set display to none after fading out
            }
        });
    }
}

export default Burger;
