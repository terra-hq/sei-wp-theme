import Swup from "swup";
import SwupHeadPlugin from "@swup/head-plugin";
import SwupDebugPlugin from "@swup/debug-plugin";
import SwupScriptsPlugin from "@swup/scripts-plugin";
import SwupJsPlugin from "@swup/js-plugin";

import { transition } from "@jsModules/motion/transition/index";

import Blazy from "blazy";
import Navbar from "@jsModules/navbar/Navbar.js"

class Core {
    constructor(payload) {
        this.terraDebug = payload.terraDebug;
        
        this.swup = new Swup({
            linkSelector: "a[href]:not([href$='.pdf']), area[href], svg a[*|href]",
            plugins: [
                
                new SwupHeadPlugin({ persistAssets: true }),
                new SwupScriptsPlugin({
                    head: true,
                    body: true,
                }),
                new SwupDebugPlugin({
                    globalInstance: true,
                }),
                new SwupJsPlugin(transition),
            ],
        });
        this.firstLoad = true;
        this.isBlazy = payload.blazy;
        this.boostify = payload.boostify;
        this.instances = [];


        this.eventsCore();
    }
   
    eventsCore() {
        new Navbar({
            burguer: document.querySelector('.js--burger'),
            navbar : document.querySelector('.js--navbar'),
            boostify: this.boostify 
        }) 
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
        if (this.isBlazy.enable) {
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
        if (this.isBlazy) {
            if (this.instances["Blazy"]) {
                this.instances["Blazy"].destroy();
            }
        }
    }
}

export default Core;