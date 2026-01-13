const sliderAConfig = {
  loop: true,
  items: 1,
  gutter: 32,
  slideBy: 1,
  controls: false,
  nav: true,
  navPosition: "bottom",
  rewind: false,
  swipeAngle: 60,
  lazyload: true,
  lazyloadSelector: ".tns-lazy-img",
  autoplay: true,
  mouseDrag: true,
  autoplayButtonOutput: false,
  speed: 350,
  autoplayTimeout: 40000,
  preventActionWhenRunning: true,
  preventScrollOnTouch: "auto",
  touch: true,
};

const sliderBConfig = {
  loop: true,
  items: 1,
  gutter: 32,
  slideBy: 1,
  controls: true,
  controlsContainer: ".c--slider-b__controls",
  nav: false,
  rewind: false,
  swipeAngle: 60,
  lazyload: false,
  autoplay: false,
  mouseDrag: true,
  autoplayButtonOutput: false,
  speed: 350,
  autoplayTimeout: 40000,
  preventActionWhenRunning: true,
  preventScrollOnTouch: "auto",
  touch: false,
  autoWidth: true,
  responsive: {
    580: {
      items: 2,
    },
    1024: {
      items: 3,
    },
  },
};

const sliderCConfig = {
  loop: false,
  items: 1,
  gutter: 32,
  slideBy: 1,
  controls: false,
  nav: true,
  navPosition: "bottom",
  rewind: false,
  swipeAngle: 60,
  lazyload: false,
  autoplay: true,
  mouseDrag: true,
  autoplayButtonOutput: false,
  speed: 350,
  autoplayTimeout: 40000,
  preventActionWhenRunning: true,
  preventScrollOnTouch: "auto",
  touch: true,
  responsive: {
    580: {
      items: 1,
    },
    810: {
      items: 2,
    },
    1300: { items: 3 },
  },
};

const sliderDConfig = {
  loop: true,
  items: 1,
  gutter: 32,
  slideBy: 1,
  controls: false,
  nav: true,
  navPosition: "bottom",
  rewind: false,
  swipeAngle: 60,
  lazyload: true,
  lazyloadSelector: ".tns-lazy-img",
  autoplay: true,
  mouseDrag: true,
  autoplayButtonOutput: false,
  speed: 350,
  autoplayTimeout: 40000,
  preventActionWhenRunning: true,
  preventScrollOnTouch: "auto",
  touch: true,
  responsive: {
    0: {
      disable: true,
    },
    811: {
      disable: false,
    }
  }
};

const sliderEConfig = {
  loop: true,
  items: 1,
  gutter: 32,
  slideBy: 1,
  controls: false,
  nav: true,
  navPosition: "bottom",
  rewind: false,
  swipeAngle: 60,
  lazyload: true,
  lazyloadSelector: ".tns-lazy-img",
  autoplay: true,
  mouseDrag: true,
  autoplayButtonOutput: false,
  speed: 350,
  autoplayTimeout: 40000,
  preventActionWhenRunning: true,
  preventScrollOnTouch: "auto",
  touch: true,
  responsive: {
    0: {
      disable: false,
    },
    811: {
      disable: false,
    }
  }
};

export { sliderAConfig, sliderBConfig, sliderCConfig, sliderDConfig, sliderEConfig };
