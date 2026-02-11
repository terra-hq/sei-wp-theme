import { horizontalLoop } from "@andresclua/infinite-marquee-gsap";

class InfiniteMarquee {
  constructor(payload) {
    this.DOM = {
      element: payload.element,
    };
    let reversed = '';
    this.reversed = payload.reversed === undefined || payload.reversed === null ? false : reversed;
    this.speed = payload.speed === undefined ? 1 : payload.speed;
    this.controlsOnHover = payload.controlsOnHover === undefined ? false : payload.controlsOnHover;
    this.paused = payload.paused ?? false;
    this.Manager = payload.Manager;
    this.gsap = this.Manager.getLibrary("GSAP").gsap;
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
      paused: this.paused,
      repeat: -1,
      reversed: this.reversed,
      speed: this.speed,
    });
  }
  destroy() {
    this.speed = null;
    this.loop.clear();
  }

  pause() {
    this.gsap.to(this.loop, { timeScale: 0, overwrite: true });
  }
  play() {
    this.gsap.to(this.loop, { timeScale: 1, overwrite: true });
  }
}
export default InfiniteMarquee;
