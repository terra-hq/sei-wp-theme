import { getQueryParam } from "@js/utilities/getQueryParam";
import Manager from "@js/managers/Manager";
import mitt from "mitt";
import AssetManager from "./managers/AssetManager";

class Project {

    constructor() {
        window.isFired = true;
        this.DOM = {
            boostifyScripts: document.querySelectorAll('script[type="text/boostify"]'),
            preloader: document.querySelector(".c--preloader-a"),
            preloaderMedia: document.querySelector(".c--preloader-a__media-wrapper__media"),
            preloaderPath: document.querySelector(".c--preloader-a__artwork path"),
        };

        // terra debug mode, add ?debug to the url to enable debug mode
        this.terraDebug = getQueryParam("debug");
        // terra dev debug mode, with panels, always active in dev, add ?dev-debug to enable in deployed version
        this.devDebug = getQueryParam("dev-debug");
        this.debug = {
            import() {},
            instance() {},
            manager() {},
            events() {},
            error() {},
            info() {},
            timing() {}
        };
        
        this.emitter = mitt();

        this.#init();
    }
    isDesktop() {
    return window.innerWidth > 810;
    }

    async #init() {
        try {
            if (import.meta.env.MODE === "development" || this.devDebug) {
                const mod = await import("./managers/DebugManager");
                this.debug = mod.debug;
            }

            this.Manager = new Manager({ debug: this.debug });
            this.assetManager = new AssetManager({
                debug: this.debug,
                emitter: this.emitter,
                libraryManager: this.Manager,
            });

            await this.assetManager.getLibraries();
            await this.assetManager.calculateProgress();
            await this.assetManager.loadLibraries();

            var Boostify = this.Manager.getLibrary("Boostify");

            this.boostify = new Boostify({
                debug: this.terraDebug,
            });

            // Store boostify instance in Manager for lazy loading access (e.g., reCAPTCHA)
            this.Manager.addLibrary({ name: "boostify", lib: this.boostify });

            this.GSAPLIB = this.Manager.getLibrary("GSAP");
            this.gsap = this.GSAPLIB.gsap;
            if (!this.GSAPLIB || !this.GSAPLIB.gsap) {
                this.debug.error("GSAP library not found or not properly loaded");
            }
            this.GSAPLIB.gsap.registerPlugin(this.Manager.getLibrary("ScrollTrigger"), this.Manager.getLibrary("Flip"));

            const eventSystemLib = this.Manager.getLibrary("EventSystem");
            this.eventSystem = new eventSystemLib({emitter: this.emitter, debug: this.debug});

            const { default: Main } = await import("@js/Main.js");
            new Main({
                boostify: this.boostify,
                terraDebug: this.terraDebug,
                debug: this.debug,
                Manager: this.Manager,
                emitter: this.emitter,
                assetManager: this.assetManager,
                eventSystem: this.eventSystem
            });
        } catch (err) {
            this.debug.error(`Error setting up Project.js, check console`);
            console.error(err);
        } finally {
            let tl = this.gsap?.timeline({
                defaults: {
                    duration: 0.1,
                    ease: "power1.inOut",
                },
                onStart: () => {
                    this.DOM.preloader.style.pointerEvents = "none";
                    if (this.DOM.boostifyScripts.length) {
                        this.boostify.onload({
                            maxTime: 1200,
                            worker: true,
                            callback: async () => {
                                if (!window.dataLayer) window.dataLayer = [];
                                window.dataLayer.push({
                                    event: "VirtualPageview",
                                    virtualPageURL: window.location.href, // full URL
                                    virtualPageTitle: document.title, // Page title
                                    virtualPagePath: window.location.pathname, // Path w/o hostname
                                });
                            },
                        });
                    }
                },
            });

            tl.to(this.DOM.preloader, { duration: 1, autoAlpha: 0, pointerEvents: "none" });
            tl.to(this.DOM.preloaderPath, {
                duration: 0.3,
                ease: "power2.in",
                attr: {
                d: this.isDesktop()
                    ? "M 0 0 V 50 Q 50 0 100 50 V 0 z"
                    : "M 0 0 V 20 Q 50 0 100 20 V 0 z",
                },
            });
            tl.to(this.DOM.preloaderPath, {
                duration: 0.8,
                ease: "power4",
                attr: { d: "M 0 0 V 0 Q 50 0 100 0 V 0 z" },
            });

            tl = await this.assetManager.importAutoAnimations({ tl, eventSystem: this.eventSystem });
            
          
        }
    }
}
if (!window.isFired) {
    new Project();
}
