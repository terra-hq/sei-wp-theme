import { horizontalLoop } from "@andresclua/infinite-marquee-gsap";
import { u_stringToBoolean } from "@andresclua/jsutil";
import gsap from "gsap";

class InfiniteMarquee {
  constructor(payload) {
    this.DOM = {
      element: payload.element,
    };
    var reversed = u_stringToBoolean(payload.reversed);
    this.reversed =
      payload.reversed === undefined || payload.reversed === null
        ? false
        : reversed;
    this.speed = payload.speed === undefined ? 1 : payload.speed;
    this.controlsOnHover =
      payload.controlsOnHover === undefined ? false : payload.controlsOnHover;
    this.init();
    this.events();
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
  init() {
    this.loop = horizontalLoop(this.DOM.element.children, {
      paused: false,
      repeat: -1,
      reversed: this.reversed,
      speed: this.speed,
    });
  }
  destroy() {
    if (this.loop) {
      this.loop.clear();
    }
    this.loop = null;
    this.DOM = null;
  }

  pause() {
    gsap.to(this.loop, { timeScale: 0, overwrite: true });
  }
  play() {
    gsap.to(this.loop, { timeScale: 1, overwrite: true });
  }
}
export default InfiniteMarquee;
