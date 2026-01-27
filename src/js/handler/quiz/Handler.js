import { isElementInViewport } from "@terrahq/helpers/isElementInViewport";

class Handler {
    constructor(payload) {
        var { emitter, instances, boostify, terraDebug, libManager } = payload;
        this.boostify = boostify;
        this.emitter = emitter;
        this.instances = instances;
        this.terraDebug = terraDebug;
        this.libManager = libManager;

        this.DOM = {
            elements: document.querySelectorAll(".js--quiz-a"),
        }

        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            elements: document.querySelectorAll(".js--quiz-a"),
        };
    }

    init() {
        if (this.DOM.elements.length) {
            this.instances["Quiz"] = [];
            this.DOM.elements.forEach((element, index) => {
                if (isElementInViewport({ el: element, debug: this.terraDebug })) {
                    this.initializeQuiz(element, index);
                } else {
                    this.boostify.scroll({
                        distance: 300,
                        name: "Quiz",
                        callback: () => {
                            this.initializeQuiz(element, index);
                        },
                    });
                }
            });
        }
    }

    async initializeQuiz(element, index) {
        if (!window["lib"]) {
            window["lib"] = {};
        }

        import("@jsHandler/quiz/Quiz")
        .then(({ default: Quiz }) => {
            window["lib"]["Quiz"] = Quiz;
            this.instances["Quiz"][index] = new Quiz();
        })
        .catch((e) => {
            this.terraDebug && console.error("Error loading @jsHandler/quiz/Quiz", e);
        });
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
            this.instances["Quiz"] &&
            this.instances["Quiz"].length
        ) {
            this.boostify.destroyscroll({ distance: 300, name: "Quiz" });
            this.DOM.elements.forEach((element, index) => {
                if (this.instances["Quiz"][index]) {
                    if (typeof this.instances["Quiz"][index].destroy === "function") {
                        this.instances["Quiz"][index].destroy();
                    }
                }
            });
            this.instances["Quiz"] = [];
        }
    }
}

export default Handler;

