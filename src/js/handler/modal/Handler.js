import { isElementInViewport } from "@terrahq/helpers/isElementInViewport";
import { u_matches, u_addClass, u_removeClass } from "@andresclua/jsutil";
import gsap from "gsap";
import Modal from "./Modal.js"; // 👈 asegúrate de tener este import

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

        // Config centralizada para los modales
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
            modalAElements: document.querySelectorAll(`.js--modal`),
        };
    }

    init() { }

    events() {
        // Captura el último trigger que disparó un modal
        this.triggerClickHandler = (e) => {
            const trigger = e.target.closest(`[${this.modalConfig.openTrigger}]`);
            if (trigger) {
                this.currentTrigger = trigger;
            }
        };
        document.addEventListener("click", this.triggerClickHandler, true);

        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM; // Re-query elements

            if (this.DOM.modalAElements.length > 0) {
                this.instances["Modal"] = [];

                this.DOM.modalAElements.forEach(async (modal, index) => {
                    if (isElementInViewport({ el: modal, debug: this.terraDebug })) {
                        this.instances["Modal"][index] = new Modal({
                            selector: `#${modal.id}`,
                            debug: true,
                            ...this.modalConfig, // 👈 inyectamos triggers centralizados
                            onShow: (modal) => {
                                if (!this.currentTrigger) return;

                                if (this.currentTrigger.getAttribute("data-modal-video-type") === "file") {
                                    this.boostify.videoPlayer({
                                        url: {
                                            mp4: this.currentTrigger.getAttribute("data-modal-video-url"),
                                        },
                                        style: { aspectRatio: "16/7", width: "100%" },
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
                                        style: { aspectRatio: "16/7", width: "100%" },
                                    });
                                }
                            },
                            onClose: (modal) => {
                                this.currentTrigger = null;
                                modal.querySelector(".g--modal-01__wrapper__content").innerHTML = "";
                            },
                        });
                    }
                });
            }
        });

        // Destroy Elements
        this.emitter.on("MitterWillReplaceContent", () => {
            if (
                this.DOM.modalAElements.length &&
                this.instances["Modal"] &&
                this.instances["Modal"].length
            ) {
                this.DOM.modalAElements.forEach((_, index) => {
                    this.instances["Modal"][index].destroy();
                });
                this.instances["Modal"] = [];
            }
        });
    }
}

export default Handler;
