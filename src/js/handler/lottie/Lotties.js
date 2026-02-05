import { preloadLotties } from "@terrahq/helpers/preloadLotties";

class Lotties {
  constructor(payload) {
    const { element } = payload;
    this.DOM = { element };
    this.animationName = element?.getAttribute("data-name") || "myLottie"; // nombre asociado
    this.init();
  }

  async init() {

    await preloadLotties({
      debug: false,
      selector: this.DOM.element,
      callback: (animations) => {
      },
    });

    // Guardar la instancia si existe
    this.instance = window.WL?.[this.animationName] || null;
  }

  destroy() {
    if (this.instance && typeof this.instance.destroy === "function") {
      this.instance.destroy();
    }

    // Limpieza global
    if (window.WL && window.WL[this.animationName]) {
      delete window.WL[this.animationName];
    }

    // Limpieza local
    this.instance = null;
    this.DOM = null;
  }
}

export default Lotties;