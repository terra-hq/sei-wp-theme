import gsap from "gsap";
import { u_stringToBoolean } from "@andresclua/jsutil";
import { horizontalLoop } from "@andresclua/infinite-marquee-gsap";

class Marquee {
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
  init() {
    this.loop = horizontalLoop(this.DOM.element.children, {
      paused: false,
      repeat: -1,
      reversed: this.reversed,
      speed: this.speed,
    });
  }
  events() {
    /**
     * pause marquee on hover
     */
    if (this.controlsOnHover) {
      this.DOM.element.addEventListener("mouseenter", () => this.pause());
      this.DOM.element.addEventListener("mouseleave", () => this.play());
    }
  }
  pause() {
    gsap.to(this.loop, { timeScale: 0, overwrite: true });
  }
  play() {
    gsap.to(this.loop, { timeScale: 1, overwrite: true });
  }
}
export default Marquee;
