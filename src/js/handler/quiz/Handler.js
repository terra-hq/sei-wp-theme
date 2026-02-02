import { isElementInViewport } from "@terrahq/helpers/isElementInViewport";
class Handler {
    constructor(payload) {
        var { emitter, instances, boostify, terraDebug, libManager } = payload;
        this.boostify = boostify;
        this.emitter = emitter;
        this.instances = instances;
        this.terraDebug = terraDebug;
        this.libManager = libManager;

        this.init();
        this.events();
    }

    get updateTheDOM() {
        return {
            elements: document.querySelectorAll(".js--quiz-a"),
        };
    }

    init() {}

    createInstanceQuiz({element, index}) {
        const Quiz = window['lib']['Quiz'];
        this.instances["Quiz"][index] = new Quiz();
    }

    events() {
        this.emitter.on("MitterContentReplaced", async () => {
            this.DOM = this.updateTheDOM;
            if (this.DOM.elements.length) {
            this.instances["Quiz"] = [];

                if (!window['lib']['Collapsify']) {
                    const { default: Collapsify } = await import("@terrahq/collapsify");
                    window['lib']['Collapsify'] = Collapsify;
                    window['Collapsify'] = Collapsify;
                }
                if (!window['lib']['Quiz']) {
                    const { default: Quiz } = await import ("@jsHandler/Quiz/Quiz");
                    window['lib']['Quiz'] = Quiz;
                }
          
                this.DOM.elements.forEach((element, index) => {
                    if (isElementInViewport({ el: element, debug: this.terraDebug })) {
                        this.createInstanceQuiz({element, index});
                    } else {
                        this.boostify.scroll({
                            distance: 10,
                            name: "Quiz",
                            callback: () => {
                                this.createInstanceQuiz({element, index});
                            },
                        });
                    }
                });
            }
        });

        this.emitter.on("MitterWillReplaceContent", () => {
            this.DOM = this.updateTheDOM;
            if (this.DOM?.elements?.length && this.instances["Quiz"]?.length) {
                this.boostify.destroyscroll({ distance: 10, name: "Quiz" });
                this.DOM.elements.forEach((_, index) => {
                    if (this.instances["Quiz"][index]?.destroy) {
                        this.instances["Quiz"][index].destroy();
                    }
                });
                this.instances["Quiz"] = [];
            }
        });
    }
}

export default Handler;
