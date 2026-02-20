
// animations will run once, and
export const getAnimations = () => {
    return [
    ];
};

export const getAutoAnimations = () => {             
    return [
        {
            name: "HeroA",
            resource: async () => {
                const { default: HeroA } = await import("@js/motion/intros/HeroA.js");
                return HeroA;
            },
            options: {
                selector: document.querySelector(".js--hero-a")
            },
        },
        {
            name: "HeroB",
            resource: async () => {
                const { default: HeroB } = await import("@js/motion/intros/HeroB.js");
                return HeroB;
            },
            options: {
                selector: document.querySelector(".js--hero-b"),
            },
        },
        {
            name: "HeaderA",
            resource: async () => {
                const { default: HeaderA } = await import("@js/motion/intros/HeaderA.js");
                return HeaderA;
            },
            options: {
                selector: document.querySelector(".c--header-a"),
            },
        },
    ];
};

// this libraries are used by the framework, they load once and are available globally
export const getMinimal = () => {
    return [
        {
            name: "isElementInViewport",
            resource: async () => {
                const { isElementInViewport } = await import("@terrahq/helpers/isElementInViewport");
                return isElementInViewport;
            },
        },
        {
            name: "GSAP",
            resource: async () => {
                const module = await import("gsap");
                return { ...module };
            },
        },
        {
            name: "ScrollTrigger",
            resource: async () => {
                const { ScrollTrigger } = await import("gsap/ScrollTrigger");
                return ScrollTrigger;
            },
        },
        {
            name: "Boostify",
            resource: async () => {
                const { default: Boostify } = await import("boostify");
                return Boostify;
            },
        },
        {
            name: "digElement",
            resource: async () => {
                const { digElement } = await import("@terrahq/helpers/digElement");
                return digElement;
            },
        },
        {
            name: "EventSystem",
            resource: async () => {
                const {default: EventSystem} = await import("@js/utilities/EventSystem");
                return EventSystem;
            },
        }
    ];
};

export const getModules = () => {
    return [
        {
            name: "AccordionA",
            resource: async () => {
                const { default: AccordionA } = await import("@jsHandler/accordion/AccordionA");
                return AccordionA;
            },
            options: {
                modifyHeight: true,
            },
        },
		{
            name: "AnchorTo",
            resource: async () => {
                const { default: AnchorTo } = await import("@jsHandler/anchorTo/AnchorTo");
                return AnchorTo;
            },
        },
		{
            name: "Collapsify",
            resource: async () => {
                const { default: Collapsify } = await import("@terrahq/collapsify");
                return Collapsify;
            },
            options: {
                modifyHeight: true,
            },
        },
        {
            name: "SetCookies",
            resource: async () => {
                const { default: SetCookies } = await import("@jsHandler/cookies/SetCookies");
                return SetCookies;
            },
        },
        {
            name: "FilterPeople",
            resource: async () => {
                const { default: FilterPeople } = await import("@jsHandler/filter/FilterPeople.js");
                return FilterPeople ;
            },
        },
        {
            name: "HeroScroll",
            resource: async () => {
                const { default: HeroScroll } = await import("@jsHandler/heroScroll/HeroScroll");
                return HeroScroll;
            },
      
        },
        {
            name: "GetAllJobs",
            resource: async () => {
                const { default: GetAllJobs } = await import("@jsHandler/jobs/GetAllJobs.js");
                return GetAllJobs;
            },
        },
        {
            name: "LoadCaseStudies",
            resource: async () => {
                const { default: LoadCaseStudies } = await import("@jsHandler/loadCaseStudies/LoadCaseStudies.js");
                return LoadCaseStudies;
            },
        },
		{
            name: "LoadInsights",
            resource: async () => {
                const { default: LoadInsights } = await import("@jsHandler/loadInsights/LoadInsights.js");
                return LoadInsights;
            },
        },
		{
            name: "LoadNews",
            resource: async () => {
                const { default: LoadNews } = await import("@jsHandler/loadNews/LoadNews.js");
                return LoadNews;
            },
        },
		{
            name: "LocationJobs",
            resource: async () => {
                const { default: LocationJobs } = await import("@jsHandler/locationJobs/LocationJobs.js");
                return LocationJobs;
            },
        },
		{
            name: "Lotties",
            resource: async () => {
                const { default: Lotties } = await import("@jsHandler/lottie/Lotties.js");
                return Lotties;
            },
            options: {
                modifyHeight: true,
            },
        },
		{
            name: "InfiniteMarquee",
            resource: async () => {
                const { default: InfiniteMarquee } = await import("@jsHandler/marquee/InfiniteMarquee");
                return InfiniteMarquee;
            },
        },
        {
            name: "Modal",
            resource: async () => {
                const { default: Modal } = await import("@jsHandler/modal/Modal");
                return Modal;
            },
        },
        {
            name: "Quiz",
            resource: async () => {
                const { default: Quiz } = await import("@jsHandler/quiz/Quiz.js");
                return Quiz;
            },
        },
        {
            name: "Slider",
            resource: async () => {
                const { default: Slider } = await import("@jsHandler/slider/Slider.js");
                return Slider;
            },
			options: {
                modifyHeight: true,
            },
        },
        {
            name: "Timeline",
            resource: async () => {
                const { default: Timeline } = await import("@jsHandler/timeline/Timeline.js");
                return Timeline;
            },
        },
        {
            name: "ZoomScroll",
            resource: async () => {
                const { default: ZoomScroll } = await import("@jsHandler/zoomScroll/ZoomScroll.js");
                return ZoomScroll;
            },
        },
    ];
};

export const loadLibrary = async (payload) => {
    const { libraryName } = payload;

    const modules = getModules();
    const library = modules.filter((mod) => mod.name == libraryName)[0];
    if (library?.options?.condition && typeof library?.options?.condition == "function") {
        const shouldLoad = await library.options?.condition();
        if (shouldLoad === false) {
            return `⏩ Library ${libraryName} skipped by condition`;
        }
    }
    return library;
};
