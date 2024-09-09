import Core from "./Core";
import AnchorTo from "@teamthunderfoot/anchor-to";

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
        /**
         * Accordion
         * dynamically import the collapsify module for accordion-a
         */
        let accordionElements = document.querySelectorAll(".js--accordion-a");
        let accordion02Elements = document.querySelectorAll(".js--accordion-02");
        if (accordionElements.length || accordion02Elements.length ) {

            const { default: Accordion } = await import('@terrahq/collapsify');
            window["lib"]["Accordion"] = Accordion;

            if (accordionElements.length) {
                this.instances["accordionA"] = [];
                accordionElements.forEach((element, index) => {
                    this.instances["accordionA"][index] = new window["lib"]["Accordion"]({
                        nameSpace: "accordionA",
                        closeOthers: false,
                    });
                });
            }

            if (accordion02Elements.length) {
                this.instances["accordion02"] = [];
                accordion02Elements.forEach((element, index) => {
                    this.instances["accordion02"][index] = new window["lib"]["Accordion"]({
                        nameSpace: "accordion02",
                        closeOthers: false,
                    });
                });
            }

        }
        
        /**
         * *infinite marquee
         * dynamically import the infinitemarquee module
         */
        let marqueeElements = document.querySelectorAll(".js--marquee");
        if (marqueeElements.length) {

            const { default: InfiniteMarquee } = await import("@jsModules/marquee/InfiniteMarquee");
            window["lib"]["InfiniteMarquee"] = InfiniteMarquee;

            this.instances["marqueeA"] = [];
            marqueeElements.forEach((marqueeElement, index) => {
                this.instances["marqueeA"][index] = new window["lib"]["InfiniteMarquee"]({
                    element: marqueeElement,
                    speed: parseFloat(marqueeElement.getAttribute("data-speed")),
                    controlsOnHover: marqueeElement.getAttribute("data-controls-on-hover") === "true",
                    reversed: marqueeElement.getAttribute("data-reversed"),
                });
            });
        }

        /* handle iframes loading with boostify for performance */
        let iframes = document.querySelectorAll('.js--boostify-embed');
        if(iframes.length) {
            iframes.forEach(element => {
                this.boostify.scroll({
                    distance: 10,
                    name: 'iframes',
                    callback: () => {
                        this.boostify.videoEmbed({
                            url:element.getAttribute('data-url-youtube'), 
                            autoplay: true,
                            appendTo: element,
                            style : { height: "auto"}
                        });
                    }
                });
            })
        } 
        

        /* handle video loading with boostify for performance */
        let videos = document.querySelectorAll('.js--boostify-player');
        if(videos.length) {
            videos.forEach(element => {
                this.boostify.scroll({
                    distance: 10,
                    name: 'videos',
                    callback: () => {
                        this.boostify.videoPlayer({
                            url: {
                                mp4: element.getAttribute('data-media'),
                            },
                            attributes: {
                                class: "c--media-b__video__item",
                                id: "MyVideo",
                                loop: true,
                                muted:true,
                                controls:true,
                                autoplay:true,
                            },
                            appendTo: element,
                        });
                    }
                });
            })
        }

        /**
         * *SliderA
         * Dynamically import the SliderA config and the slider module
         */
        let sliderAElements = document.querySelectorAll(".js--slider-a");
        if (sliderAElements.length) {

            const { sliderAConfig } = await import("@jsModules/slider/slidersConfig");
            const { default: Slider } = await import("@jsModules/slider/Slider.js");
            window["lib"]["Slider"] = Slider;

            this.instances["sliderA"] = [];
            sliderAElements.forEach((slider, index) => {
                this.instances["sliderA"][index] = new window["lib"]["Slider"]({
                    slider: slider,
                    controls: slider.nextElementSibling,
                    config: sliderAConfig,
                    windowName: "SliderA",
                    index: index,
                });
            });
            
        }
       
        if (document.querySelectorAll(".js--scroll-to").length) {
            this.instances["ScrollTo"] = [];
            document.querySelectorAll(".js--scroll-to").forEach((element, index) => {
                this.instances["ScrollTo"][index] = new AnchorTo({
                    element: element,
                    checkUrl: false,
                    anchorTo: "tf-data-target",
                    offsetTopAttribute: "tf-data-distance",
                    offsetTop: false,
                    offsetTopURL: false,
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
