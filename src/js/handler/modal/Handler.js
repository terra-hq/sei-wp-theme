import CoreHandler from "../CoreHandler.js";
class Handler extends CoreHandler {
    constructor(payload) {
        super(payload);
        this.init();
        this.triggerEl = null;

        this.config = ({element}) => ({
            selector: document.querySelector(".g--modal-01"),
            debug: this.terraDebug,
            openClass: 'g--modal-01--is-open',
            ...this.modalConfig,
            onShow: (element) => {
                const trigger = this.triggerEl;
                if (!trigger) return;

                const type = trigger.getAttribute("data-modal-video-type");
                const url = trigger.getAttribute("data-modal-video-url");
                const wrapper = document.querySelector(".g--modal-01__wrapper__content");
                if (!wrapper) return;
                wrapper.innerHTML = "";

                if (type === "file") {
                    this.boostify.videoPlayer({
                        url: { mp4: url },
                        style: { aspectRatio: "16/9", width: "100%", height: "100%" },
                        attributes: {
                            class: "video-file",
                            id: "MyVideo",
                            loop: false,
                            muted: true,
                            controls: true,
                            autoplay: true,
                            playsinline: true,
                        },
                        appendTo: wrapper,
                        
                    });
                } else if (type === "embed") {
                    this.boostify.videoEmbed({
                        url: url,
                        autoplay: true,
                        appendTo: wrapper,
                        style: { aspectRatio: "16/9", width: "100%", height: "100%" },
                    });
                }
            },
            onClose: (element) => {
                this.triggerEl = null;
                const wrapper = document.querySelector(".g--modal-01__wrapper__content");
                if(wrapper) wrapper.innerHTML = "";
                this.eventSystem.destroyEvent({library: 'Modal', where: 'Modal'})
            },
        });
       
        this.events();
    }

    get updateTheDOM() {
        return {
            modalButton: document.querySelectorAll(".js--modal-btn"),
        };
    }

    init() {
        super.getLibraryName("Modal");
    }

    events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM; // Re-query elements each time this is called

            this.DOM.modalButton.forEach((btn) => {
                btn.addEventListener("click", () => {
                    this.triggerEl = btn;
                });
            });

            super.assignInstances({
                elementGroups: [
                    {
                        elements: this.DOM.modalButton,
                        config: this.config,
                        boostify: { method: 'click', distance: 30 },
                    },
                ],
            });
        });

        this.emitter.on("MitterWillReplaceContent", () => {
            if (this.DOM.modalButton.length) {
                super.destroyInstances();
            }
        });

        this.emitter.on("Modal:destroy", () => {
            if (this.DOM.modalButton.length) {
                super.destroyInstances();
            }
        });
    }
}

export default Handler;
