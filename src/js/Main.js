import Core from "./Core";
import ModalHandler from "./handler/modal/Handler";
import LoadMoreHandler from "./handler/loadmore/Handler";
import FilterPeopleHandler from "./handler/filter/Handler";
import GetAllJobsHandler from "./handler/jobs/Handler";
import HeroScrollHandler from "./handler/heroScroll/Handler";
import LocationJobsHandler from "./handler/locationJobs/Handler";
import CookiesHandler from "./handler/cookies/Handler";
import ZoomScrollHandler from "./handler/zoomScroll/Handler";
import TimelineHandler from "./handler/timeline/Handler";
import SliderHandler from "./handler/slider/Handler";
import CollapsifyHandler from "@jsHandler/collapsify/handler.js";
import QuizHandler from "./handler/quiz/Handler";
import MarqueeHandler from "./handler/marquee/Handler";
import AnchorToHandler from "./handler/anchorTo/Handler";
import LottieHandler from "./handler/lottie/Handler";

class Main extends Core {
  constructor(payload) {
    super({
      blazy: {
        enable: true,
        selector: "g--lazy-01",
      },
      form7: {
        enable: false,
      },
      swup: {
        transition: {
          forceScrollTop: false,
        },
      },
      boostify: payload.boostify,
      terraDebug: payload.terraDebug,
    });
    this.handler = {
      emitter: this.emitter,
      boostify: this.boostify,
      instances: this.instances,
      terraDebug: this.terraDebug,
      libManager: this.libManager,
    };
    this.init();
    this.events();
  }

  init() {
    // Loads Core init function
    super.init();
    new ModalHandler(this.handler);
    new LoadMoreHandler(this.handler);
    new FilterPeopleHandler(this.handler);
    new GetAllJobsHandler(this.handler);
    new HeroScrollHandler(this.handler);
    new LocationJobsHandler(this.handler);
    new CookiesHandler(this.handler);
    new ZoomScrollHandler(this.handler);
    new TimelineHandler(this.handler);
    new SliderHandler(this.handler);
    new CollapsifyHandler(this.handler);
    new QuizHandler(this.handler);
    new MarqueeHandler(this.handler);
    new AnchorToHandler(this.handler);
    new LottieHandler(this.handler);
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
