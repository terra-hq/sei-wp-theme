import { isElementInViewport } from "@terrahq/helpers/isElementInViewport";
import { u_matches, u_addClass, u_removeClass } from "@andresclua/jsutil";
import gsap from "gsap";

class Handler {
    constructor(payload) {
        var { emitter, instances, boostify, terraDebug, libManager } = payload;
        this.boostify = boostify;
        this.emitter = emitter;
        this.instances = instances;
        this.terraDebug = terraDebug;
        this.libManager = libManager;

        this.currentTrigger = null;
        this.triggerClickHandler = null;

        this.modalConfig = {
            openTrigger: "data-modal-open",
            closeTrigger: "data-modal-close",
            openClass: "g--modal-01--is-open",
        };

        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            modalAElements: document.querySelectorAll(".js--modal"),
        };
    }

    init() { }

    createModalInstance({ element, index }) {
        const Modal = window['lib']['Modal'];

        this.instances["Modal"][index] = new Modal({
            selector: `#${element.id}`,
            debug: this.terraDebug,
            ...this.modalConfig,
            onShow: (modal) => {
                if (!this.currentTrigger) return;

                if (this.currentTrigger.getAttribute("data-modal-video-type") === "file") {
                    this.boostify.videoPlayer({
                        url: {
                            mp4: this.currentTrigger.getAttribute("data-modal-video-url"),
                        },
                        style: { aspectRatio: "16/9", width: "100%", height: "100%" },
                        attributes: {
                            class: "video-file",
                            id: "MyVideo",
                            loop: false,
                            muted: false,
                            controls: true,
                            autoplay: true,
                            playsinline: true,
                        },
                        appendTo: modal.querySelector(".g--modal-01__wrapper__content"),
                    });
                } else if (this.currentTrigger.getAttribute("data-modal-video-type") === "embed") {
                    this.boostify.videoEmbed({
                        url: this.currentTrigger.getAttribute("data-modal-video-url"),
                        autoplay: true,
                        appendTo: modal.querySelector(".g--modal-01__wrapper__content"),
                        style: { aspectRatio: "16/9", width: "100%", height: "100%" },
                    });
                }
            },
            onClose: (modal) => {
                this.currentTrigger = null;
                const content = modal.querySelector(".g--modal-01__wrapper__content");
                if(content) content.innerHTML = "";
            },
        });
    }

    events() {
        this.triggerClickHandler = (e) => {
            const trigger = e.target.closest(`[${this.modalConfig.openTrigger}]`);
            if (trigger) {
                this.currentTrigger = trigger;
            }
        };
        document.addEventListener("click", this.triggerClickHandler, true);

        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;

            if (this.DOM.modalAElements.length > 0) {
                if (!this.instances["Modal"]) {
                    this.instances["Modal"] = [];
                }

                if (!window['lib'] || !window['lib']['Modal']) {
                    if (!window['lib']) window['lib'] = {};
                    
                    const { default: Modal } = await import("./Modal.js");
                    window['lib']['Modal'] = Modal;
                }

                this.DOM.modalAElements.forEach((modal, index) => {
                    if (isElementInViewport({ el: modal, debug: this.terraDebug })) {
                        this.createModalInstance({ element: modal, index });
                    } else {
                        this.boostify.scroll({
                            distance: 10,
                            name: "Modal",
                            callback: async () => {
                                try {
                                    if (!this.instances["Modal"][index]) {
                                        this.createModalInstance({ element: modal, index });
                                    }
                                } catch (error) {
                                    this.terraDebug && console.error("Error creating Modal instance", error);
                                }
                            }
                        });
                    }
                });
            }
        });

        this.emitter.on("MitterWillReplaceContent", () => {
            this.DOM = this.updateTheDOM;

            if (this.DOM?.modalAElements?.length && this.instances["Modal"]?.length) {
                this.boostify.destroyscroll({ distance: 10, name: "Modal" });

                this.DOM.modalAElements.forEach((_, index) => {
                    if (this.instances["Modal"] && this.instances["Modal"][index]) {
                        if(typeof this.instances["Modal"][index].destroy === 'function') {
                            this.instances["Modal"][index].destroy();
                        }
                    }
                });
                this.instances["Modal"] = [];
            }
        });
    }
}

export default Handler;