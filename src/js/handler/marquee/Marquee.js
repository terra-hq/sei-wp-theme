import gsap from "gsap";
import { u_stringToBoolean } from "@andresclua/jsutil";
import { horizontalLoop } from "@andresclua/infinite-marquee-gsap";

/**
 * @class Marquee
 * This class is responsible for the actual marquee functionality.
 * 
 * @returns {Marquee} The Marquee instance.
 * 
 * @example
 * const marquee = new Marquee({
 *   element: element,
 *   speed: element.getAttribute("data-speed") ? parseFloat(element.getAttribute("data-speed")) : 1,
 *   controlsOnHover: element.getAttribute("data-controls-on-hover"),
 *   reversed: element.getAttribute("data-reversed"),
 * });
 * 
 */
class Marquee {

  /**
   * Constructor for the Marquee class.
   * @param {Object} payload - The payload object containing the element, and the necessary configurations.
   * 
   * @returns {void}
   */
  constructor(payload) {
    var { element, speed, controlsOnHover, reversed } = payload;
    this.DOM = {
      element: element,
    };
    this.reversed = reversed === undefined || reversed === null ? false : u_stringToBoolean(reversed);
    this.speed = speed === undefined ? 1 : speed;
    this.controlsOnHover = controlsOnHover === undefined ? false : controlsOnHover;
    this.init();
    this.events();
  }

  /**
   * Initializes the Marquee instance.
   * 
   * @returns {void}
   */
  init() {
    this.loop = horizontalLoop(this.DOM.element.children, {
      paused: false,
      repeat: -1,
      reversed: this.reversed,
      speed: this.speed,
    });
  }

  /**
   * Handles the events for the Marquee instance such as pausing and playing the marquee on hover.
   * 
   * @returns {void}
   */
  events() {
    /**
     * pause marquee on hover
     */
    if (this.controlsOnHover) {
      this.DOM.element.addEventListener("mouseenter", () => this.pause());
      this.DOM.element.addEventListener("mouseleave", () => this.play());
    }
  }

  /**
   * Pauses the Marquee instance.
   * 
   * @returns {void}
   */
  pause() {
    gsap.to(this.loop, { timeScale: 0, overwrite: true });
  }

  /**
   * Plays the Marquee instance.
   * 
   * @returns {void}
   */
  play() {
    gsap.to(this.loop, { timeScale: 1, overwrite: true });
  }
}
export default Marquee;
