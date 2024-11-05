import Swup from "swup";
import SwupHeadPlugin from "@swup/head-plugin";
import SwupDebugPlugin from "@swup/debug-plugin";
import SwupScriptsPlugin from "@swup/scripts-plugin";
import SwupJsPlugin from "@swup/js-plugin";
import SwupFormsPlugin from "@swup/forms-plugin";

import { createTransitionOptions } from "@jsMotion/transition/index";

import Blazy from "blazy";

class Core {
  constructor(payload) {
    this.terraDebug = payload.terraDebug;
    this.isBlazy = payload.blazy;
    this.boostify = payload.boostify;
    this.form7 = payload.form7.enable;
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
 
    /**
     *  Since we are using Boostify, we need to check if the Google Scripts are loaded a few seconds after the page is loaded
     *  If they are, we load the GTM script
     *  This project utilizes page transitions, necessitating a custom event after each page change to correspond with a page view in GTM.
     */
    var response = await import("@terrahq/helpers/hasGoogleScripts");
    const hasGoogleScripts = response.hasGoogleScripts;
    await hasGoogleScripts({ maxTime: 5000 }).then((detected) => {
      if (detected) {
        window.dataLayer.push({
          event: "VirtualPageview",
          virtualPageURL: window.location.pathname + window.location.search,
          virtualPageTitle: document.title,
        });
      } else {
        //console.log("Google Scripts not detected");
      }
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
  }
}

export default Core;
