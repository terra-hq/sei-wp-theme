import Core from "./Core";
import EventSystem from "@js/utilities/EventSystem";
import AccordionHandler from "@jsHandler/accordion/Handler";
import AnchorToHandler from "@jsHandler/anchorTo/Handler";
import CollapsifyHandler from "@jsHandler/collapsify/Handler.js";
import CookiesHandler from "@jsHandler/cookies/Handler";
import FilterPeopleHandler from "@jsHandler/filter/Handler";
import HeroScrollHandler from "@jsHandler/heroScroll/Handler";
import GetAllJobsHandler from "@jsHandler/jobs/Handler";
import LoadInsightsHandler from "@jsHandler/loadInsights/Handler";
import LoadNewsHandler from "@jsHandler/loadNews/Handler";
import LoadCaseStudies from "@jsHandler/loadCaseStudies/Handler";
import LocationJobsHandler from "@jsHandler/locationJobs/Handler";
import LottieHandler from "@jsHandler/lottie/Handler";
import MarqueeHandler from "@jsHandler/marquee/Handler";
import ModalHandler from "@jsHandler/modal/Handler";
import QuizHandler from "@jsHandler/quiz/Handler";
import SliderHandler from "@jsHandler/slider/Handler";
import TimelineHandler from "@jsHandler/timeline/Handler";
import ZoomScrollHandler from "@jsHandler/zoomScroll/Handler";
import HubspotHandler from "@jsHandler/hubspot/Handler";

class Main extends Core {
   constructor(payload) {
        const { terraDebug, Manager, emitter, assetManager, debug, boostify, eventSystem } = payload;

        // Call the parent class (Core) constructor with specific configurations
        super({
            lazy: {
                enable: true, // Enable lazy loading for images or elements
                selector: "g--lazy-01", // Selector for lazy loading elements
            },
            form7: {
                enable: false,
            },
            swup: {
                enable: true
            },
            terraDebug: terraDebug, // Pass terraDebug object from payload
            Manager: Manager, // Pass libManager object from payload
            assetManager,
            debug,
            eventSystem
        });
        this.emitter = emitter
        this.boostify = boostify

        this.handler = {
            emitter: this.emitter,
            boostify: this.boostify,
            terraDebug: this.terraDebug,
            Manager: this.Manager,
            debug,
            eventSystem: this.eventSystem,
        };

        this.init();
        this.events();
  }

  async init() {
    // Loads Core init function
    super.init();
    new AccordionHandler(this.handler);
    new AnchorToHandler(this.handler);
    new CollapsifyHandler(this.handler);
    new CookiesHandler(this.handler);
    new FilterPeopleHandler(this.handler);
    new HeroScrollHandler(this.handler);
    new GetAllJobsHandler(this.handler);
    new LoadInsightsHandler(this.handler);
    new LoadNewsHandler(this.handler);
    new LoadCaseStudies(this.handler);
    new LocationJobsHandler(this.handler);
    new LottieHandler(this.handler);
    new MarqueeHandler(this.handler);
    new ModalHandler(this.handler);
    new QuizHandler(this.handler);
    new SliderHandler(this.handler);
    new TimelineHandler(this.handler);
    new ZoomScrollHandler(this.handler);
    new HubspotHandler(this.handler);

    const { default: Navbar } = await import("@jsModules/navbar/Navbar.js");
    new Navbar({
      burguer: document.querySelector(".js--burger"),
      navbar: document.querySelector(".js--navbar"),
      boostify: this.boostify,
      Manager: this.Manager,
    });
    }
    

	events() {
		// Loads Core events function
		super.events();
	}

	async contentReplaced() {
		super.contentReplaced();
		this.emitter.emit("MitterContentReplaced");
	}

	willReplaceContent() {
		super.willReplaceContent();
		this.emitter.emit("MitterWillReplaceContent");
	}
}

export default Main;
