import { isElementInViewport } from "@terrahq/helpers/isElementInViewport";
import { modifyTag } from "@jsModules/utilities/utilities.js";
class Handler {
    constructor(payload) {
            let { emitter, boostify, terraDebug, Manager, name, debug, eventSystem } = payload;
            this.boostify = boostify;
            this.emitter = emitter;
            this.name = name || "CoreHandler";
            this.terraDebug = terraDebug;
            this.debug = debug;
            this.eventSystem = eventSystem;

            this.init();
            this.events();
    }

    get updateTheDOM() {
        return {
            hubspotFooterChecker: document.querySelectorAll(".js--hubspot-script--footer"),
            hubspotChecker: document.querySelectorAll(".js--hubspot-script"),
        };
    }

    init() {
      this.DOM = this.updateTheDOM;
    }


    async loadHubspotScriptOnce() {
        if (window.__hubspotScriptLoaded) return;
        
        if (document.querySelector('script[src="https://js.hsforms.net/forms/v2.js"]')) {
            window.__hubspotScriptLoaded = true;
            return;
        }

        await this.boostify.loadScript({
            url: "https://js.hsforms.net/forms/v2.js",
        });

        window.__hubspotScriptLoaded = true;
    }


    async initializeHubspot({ element, index }) {
        if (!element.id) element.id = `hubspot-general-${index}`;

        await this.loadHubspotScriptOnce();

        await this.boostify.loadScript({
        inlineScript: `
            hbspt.forms.create({
            region: "na1",
            portalId: "${element.getAttribute("data-portal-id")}",
            formId: "${element.getAttribute("data-form-id")}",
            });
        `,
        appendTo: element,
        attributes: [`id=general-hubspot-${index}`],
        });

        modifyTag({
        element: element.children[0],
        attributes: { "data-swup-ignore-script": "" },
        delay: 250,
        });
    }
 

    events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;
            if (this.DOM.hubspotFooterChecker.length) {
                this.DOM.hubspotFooterChecker.forEach((element) => {
                let executed = false; 
                this.boostify.observer({
                    options: {
                    root: null,
                    rootMargin: "0px",
                    threshold: 0.5,
                    },
                    element: element,
                    callback: async () => {
                    if (executed) return; 
                    executed = true; 
                    if (element.hasAttribute('data-hubspot-initialized')) return;
                    element.setAttribute('data-hubspot-initialized', 'true');
                    await this.loadHubspotScriptOnce();
                    await this.boostify.loadScript({
                    inlineScript: `
                                hbspt.forms.create({
                                region: "na1",
                                portalId: "${element.getAttribute("data-portal-id")}",
                                formId: "${element.getAttribute("data-form-id")}"
                                });`,
                    appendTo: element,
                    attributes: ["id=footer-hubspot"],
                    });
        
                    modifyTag({
                    element: element.children[0],
                    attributes: {
                        "data-swup-ignore-script": "",
                    },
                    delay: 250,
                    });
                    },
                });
            });
            }
            if (this.DOM.hubspotChecker.length) {
                this.DOM.hubspotChecker.forEach((element, index) => {
                if(isElementInViewport({el: element, debug: this.terraDebug})) {
                    this.initializeHubspot({ element, index });
                } else {
                    this.boostify.scroll({
                        distance: 10,
                        element: element,
                        callback: async () => {
                           this.initializeHubspot({ element, index });
                        },
                    });
                }
            });
            }
        });

        this.emitter.on("MitterWillReplaceContent", () => {
            this.DOM = this.updateTheDOM;
       
        });
    }
}

export default Handler;