import Core from "./Core";
import GetAllJobs from "./modules/GetAllJobs";

class Main extends Core {
    constructor(payload) {
        super({
            blazy: {
                enable: true,
                selector: "g--lazy-01",
            },
            form7: {
                enable: true,
            },
            boostify: payload.boostify,
            terraDebug: payload.terraDebug,
        });
    }

    async contentReplaced() {
        super.contentReplaced();
        
        if (document.querySelectorAll(".js--inyect-cookie").length) {
            this.instances["Cookies"] = [];
            await import("./modules/SetCookies").then(({ default: Cookies }) => {
              document.querySelectorAll(".js--inyect-cookie").forEach(async (element, index) => {
                this.instances["Cookies"][index] = new Cookies({ cookieContainer: element });
              });
            });
          }
    }

    willReplaceContent() {
        super.willReplaceContent();

        // destroy marquee and it's bstf trigger
        if (document.querySelectorAll(".js--marquee").length && this.instances["marqueeA"].length) {
            document.querySelectorAll(".js--marquee").forEach((element, index) => {
                this.instances["marqueeA"][index].destroy();
            });
            this.instances["marqueeA"] = [];
        }

        //Destroy accordion-a
        if (document.querySelectorAll(".js--accordion-a").length && this.instances["accordionA"].length) {            
            document.querySelectorAll(".js--accordion-a").forEach((element, index) => {
                this.instances["accordionA"][index].destroy();
            });
            this.instances["accordionA"] = [];
        }

        //Destroy accordion-02
        if (document.querySelectorAll(".js--accordion-02").length && this.instances["accordion02"].length) {            
            document.querySelectorAll(".js--accordion-02").forEach((element, index) => {
                this.instances["accordion02"][index].destroy();
            });
            this.instances["accordion02"] = [];
        }

        // destroy iframes bstf trigger
        if(document.querySelectorAll(".js--boostify-embed")) {
            this.boostify.destroyscroll({ distance: 10, name: "iframes" });
        }

        // destroy videos bstf trigger
        if(document.querySelectorAll(".js--boostify-player")) {
            this.boostify.destroyscroll({ distance: 10, name: "videos" });
        }

        // destroy slider
        if (document.querySelectorAll(".js--slider-a").length && this.instances["sliderA"].length) {            
            document.querySelectorAll(".js--slider-a").forEach((element, index) => {
                this.instances["sliderA"][index].destroy();
            });
            this.instances["sliderA"] = [];
        }
    }
}

export default Main;
