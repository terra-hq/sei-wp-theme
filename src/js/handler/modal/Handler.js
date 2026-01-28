import { isElementInViewport } from "@terrahq/helpers/isElementInViewport";

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

        this.modalClassSelector= "#my-modal";

        this.modalConfig = {
            selector: this.modalClassSelector,
            openTrigger: "data-modal-open",
            closeTrigger: "data-modal-close",
            openClass: "g--modal-01--is-open",
            disableScroll: true,
            awaitOpenAnimation: true,
            awaitCloseAnimation: true
        };

        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            modalAElements: document.querySelectorAll(this.modalClassSelector),
        };
    }

    init() {}

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
                this.instances["Modal"] = [];

                if (!window['lib']['Modal']) {
                    const { default: Modal } = await import("@terrahq/modal");
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
                                    this.createModalInstance({ element: modal, index });
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
            this.boostify.destroyscroll({ distance: 10, name: "Modal" });

            if (this.DOM?.modalAElements?.length && this.instances["Modal"]?.length) {
                this.DOM.modalAElements.forEach((_, index) => {
                    if (this.instances["Modal"][index]?.destroy) {
                        this.instances["Modal"][index].destroy();
                    }
                });
                this.instances["Modal"] = [];
            }
        });
    }
}

export default Handler;