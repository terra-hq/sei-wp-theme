const sliderAConfig = {
    loop: true,
    items: 1,
    gutter: 16,
    slideBy: 1,
    controls: true,
    nav: false,
    rewind: false,
    swipeAngle: 60,
    lazyload: true,
    lazyloadSelector: '.tns-lazy-img',
    autoplay: false,
    mouseDrag: true,
    autoplayButtonOutput: false,
    speed: 1000,
    autoplayTimeout: 6000,
    preventActionWhenRunning: true,
    preventScrollOnTouch: "auto",
    touch: true,
    responsive: {
        1024: {
            gutter: 32
        },
        1300: {
            gutter: 56
        }   
    }
};

export { sliderAConfig };