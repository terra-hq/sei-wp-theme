import Swup from "swup";
import SwupHeadPlugin from "@swup/head-plugin";
import SwupDebugPlugin from "@swup/debug-plugin";
import SwupScriptsPlugin from "@swup/scripts-plugin";
import SwupJsPlugin from "@swup/js-plugin";
import SwupFormsPlugin from "@swup/forms-plugin";
import mitt from "mitt"

import { createTransitionOptions } from "@jsMotion/transition/index";

import Blazy from "blazy";

class Core {
  constructor(payload) {
    this.terraDebug = payload.terraDebug;
    this.isBlazy = payload.blazy;
    this.boostify = payload.boostify;
    this.form7 = payload.form7.enable;
    this.emitter = mitt();
    this.instances = [];
    const commonPlugins = [new SwupHeadPlugin({ persistAssets: true }), ...(this.terraDebug ? [new SwupDebugPlugin({ globalInstance: true })] : []), new SwupJsPlugin(createTransitionOptions({ boostify: this.boostify, forceScroll: payload.swup.transition.forceScrollTop }))];
    const virtualPlugins = [...commonPlugins, new SwupScriptsPlugin({ head: true, body: true })];

    this.swup = new Swup({
      linkSelector: "a[href]:not([href$='.pdf']), area[href], svg a[*|href]",
      plugins: import.meta.env.VITE_TERRA_VIRTUAL != "false" ? virtualPlugins : commonPlugins,
    });

    if (this.form7) {
      this.swup.plugins.push(new SwupFormsPlugin({ formSelector: "div.wpcf7 > form" }));
    }

    this.firstLoad = true;
  }
  async init() {
    var { default: Navbar } = await import("@jsModules/navbar/Navbar.js");
    new Navbar({
      burguer: document.querySelector(".js--burger"),
      navbar: document.querySelector(".js--navbar"),
      boostify: this.boostify,

    });
  }

  events() {
    if (document.readyState === "complete" || (document.readyState !== "loading" && !document.documentElement.doScroll)) {
      this.contentReplaced();
    } else {
      document.addEventListener("DOMContentLoaded", () => {
        this.contentReplaced();
      });
    }
    this.swup.hooks.on("content:replace", () => {
      this.contentReplaced();
    });

    this.swup.hooks.before("content:replace", () => {
      this.willReplaceContent();
    });

     this.swup.hooks.on("page:view", async (data) => {
          if (!window.dataLayer) window.dataLayer = [];
          this.terraDebug && console.log(data);
          this.terraDebug && console.log(window.location.href);
          this.terraDebug && console.log(document.title);
          this.terraDebug && console.log(window.location.pathname);
          this.terraDebug && console.log(window.location.protocol + "//" + window.location.host + data?.from?.url);
          window.dataLayer.push({
              event: "VirtualPageview",
              virtualPageURL: window.location.href, // URL completa
              virtualPageTitle: document.title, // Título de la página
              virtualPagePath: window.location.pathname, // Path sin el hostname
              virtualPageReferrer: window.location.protocol + "//" + window.location.host + data?.from?.url, // Referente, si aplica
          });
      });
  }

  contentReplaced() {
    // import.meta.env.VITE_TERRA_VIRTUAL is true in virtual, false in local and production
    if (this.form7 && document.querySelector("div.wpcf7") && import.meta.env.VITE_TERRA_VIRTUAL == "false" && !this.firstLoad) {
      document.querySelectorAll("div.wpcf7 > form").forEach((element) => {
        wpcf7.init(element);
      });
    }

    if (this.isBlazy?.enable) {
      var lazySelector = this.isBlazy.selector ? this.isBlazy.selector : "g--lazy-01";
      this.instances["Blazy"] = new Blazy({
        selector: "." + lazySelector,
        successClass: `${lazySelector}--is-loaded`,
        errorClass: `${lazySelector}--is-error`,
        loadInvisible: true,
      });
    }

    this.firstLoad = false;
  }

  willReplaceContent() {
    if (this.isBlazy?.enable) {
      if (this.instances["Blazy"]) {
        this.instances["Blazy"].destroy();
        this.instances["Blazy"] = false
      }
    }

    /** Clear window.WL to allow for new lotties with the same data-name to load on navigation */
    if (document.querySelectorAll(".js--lottie-element").length) {
      window.WL = [];
    }
  }
}

export default Core;
