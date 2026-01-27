class Handler {
    constructor(payload) {
        var { emitter, instances, boostify, terraDebug, libManager } = payload;
        this.boostify = boostify;
        this.emitter = emitter;
        this.instances = instances;
        this.terraDebug = terraDebug;
        this.libManager = libManager;

        this.DOM = {
            elements: document.querySelectorAll(".js--scroll-to"),
        }

        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            elements: document.querySelectorAll(".js--scroll-to"),
        };
    }

    init() {
        if (this.DOM.elements.length) {
            this.instances["ZoomScroll"] = [];
            this.DOM.elements.forEach((element, index) => {
                this.initializeAnchorTo(element, index);
            });
        }
    }

    async initializeAnchorTo(element, index) {
        import("@teamthunderfoot/anchor-to")
        .then(({ default: AnchorTo }) => {
            window["lib"]["AnchorTo"] = AnchorTo;
            this.instances["AnchorTo"][index] = new window["lib"]["AnchorTo"]({
                element: el,
                checkUrl: false, // o true si quieres soportar hashes en la URL
                anchorTo: "tf-data-target", // dónde buscar el ID destino
                offsetTopAttribute: "tf-data-distance",
                speed: 500,
                emitEvents: true,
                onComplete: () => console.log("Scroll completo"),
            });
        })
    }

    events() {
        this.emitter.on("MitterWillReplaceContent", () => {
            this.destroy();
        });
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;
            this.init();
        });
    }

    destroy() {
        if (
            this.DOM.elements.length &&
            Array.isArray(this.instances["AnchorTo"]) &&
            this.instances["AnchorTo"].length
        ) {
            this.DOM.elements.forEach((element, index) => {
                if (this.instances["AnchorTo"][index]) {
                    this.instances["AnchorTo"][index].destroy();
                }
            });
            this.instances["AnchorTo"] = [];
        }
    }
}

export default Handler;
