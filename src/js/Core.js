import Swup from "swup";
import SwupHeadPlugin from "@swup/head-plugin";
import SwupDebugPlugin from "@swup/debug-plugin";
import SwupScriptsPlugin from "@swup/scripts-plugin";
import SwupBodyClassPlugin from "@swup/body-class-plugin";
import SwupJsPlugin from "@swup/js-plugin";
import SwupScrollPlugin from "@swup/scroll-plugin";
import Blazy from "blazy";
import { createTransitionOptions } from "@js/motion/transition/index.js";
import TransitionTimings from "@js/utilities/TransitionTimings.js";
class Core {
    constructor(payload) {
        const { blazy, terraDebug, Manager, assetManager, debug, swup, form7, eventSystem } = payload;
        
        this.eventSystem = eventSystem;
        this.blazy = blazy;
        this.terraDebug = terraDebug;
        this.Manager = Manager;
        this.debug = debug;
        this.form7 = form7.enable;
        this.swupEnabled = swup.enable;
        if (this.swupEnabled) {
            
            this.swup = new Swup({
                linkSelector: "a[href]:not([href$='.pdf']), area[href], svg a[*|href]",
                containers: ["#swup"],
                plugins: [
                    new SwupHeadPlugin({ persistAssets: true }),
                    new SwupBodyClassPlugin(),
                    new SwupScriptsPlugin({ head: true, body: true }),

                    ...(terraDebug ? [new SwupDebugPlugin({ globalInstance: true })] : []),
                    new SwupJsPlugin(
                        createTransitionOptions({
                            Manager: this.Manager,
                            debug: this.debug,
                            assetManager: assetManager,
                            eventSystem: this.eventSystem
                        })
                    ),
                    new SwupScrollPlugin({ 
                        animateScroll: {
                        betweenPages: false,
                        samePageWithHash: true,
                        samePage: true
                        }
                    })
                ]
            });

            if (this.form7 && this.swupEnabled) {
                // ! If needed, install the plugin and uncomment this
                this.swup.plugins.push(
                    new SwupFormsPlugin({ formSelector: "div.wpcf7 > form" })
                );
            }
        }
    }
    async init() {
        if (this.terraDebug) {
            (async () => {
                try {
                    const { terraDebugger } = await import("@terrahq/helpers/terraDebugger");
                    terraDebugger({
                        submitQA: "https://app.clickup.com/2197638/v/l/6-901701608554-1",
                    });
                } catch (error) {
                    console.error("Error loading the debugger module:", error);
                }
            })();
        }
    }
    events() {
        if (
            document.readyState === "complete" ||
            (document.readyState !== "loading" && !document.documentElement.doScroll)
        ) {
            this.contentReplaced();
        } else {
            document.addEventListener("DOMContentLoaded", () => {
                this.contentReplaced();
            });
        }

        // Initialize transition timings utility
        if (this.swup) {
            this.transitionTimings = new TransitionTimings({
                swup: this.swup,
                debug: this.debug
            });
            this.transitionTimings.init();
        }

        this.swup && this.swup.hooks.on("content:replace", () => {
            this.contentReplaced();
        });

        this.swup && this.swup.hooks.before("content:replace", () => {
            this.willReplaceContent();
        });

        this.swup && this.swup.hooks.on("page:view", async (data) => {
            if (!window.dataLayer) window.dataLayer = [];
            
            window.dataLayer.push({
                event: "VirtualPageview",
                virtualPageURL: window.location.href, // full URL
                virtualPageTitle: document.title, // Page title
                virtualPagePath: window.location.pathname, // Path w/o hostname
                virtualPageReferrer: window.location.protocol + "//" + window.location.host + data?.from?.url, // Referrer, if there is one
            });
        });
    }
    contentReplaced() {
        if (this.blazy?.enable) {
            const lazySelector = this.blazy?.selector ? this.blazy?.selector : "g--lazy-01";
            this.Manager.addInstance({
                name: "Blazy",
                instance: new Blazy({
                    selector: "." + lazySelector,
                    successClass: `${lazySelector}--is-loaded`,
                    errorClass: `${lazySelector}--is-error`,
                    loadInvisible: true,
                }),
                method: "Core",
            });
        }

        this.firstLoad = false;
    }

    willReplaceContent() {
        if (this.blazy.enable) {
            this.debug.instance(`❌ Destroy: Blazy`, { color: "red" });

            if (this.Manager.instances["Blazy"]) {
                this.Manager.instances["Blazy"].forEach((instance) => {
                    instance.instance.destroy();
                });
            }
            this.Manager.cleanInstances("Blazy");
        }
    }
}
export default Core;
