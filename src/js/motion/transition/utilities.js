// hide dropdown utility to hide it when user exits current page
export const hideDropdown = (payload) => {
  const gsap = payload.Manager.getLibrary("GSAP").gsap; // ✅
  const tl = gsap.timeline();

  tl.to(".js--dropdown", {
    maxHeight: 0,
    duration: 0.6,
    ease: "power2.in",
    onComplete: () => {
      const activeBurger = document.querySelector('.c--sidenav-a--is-active');
      const activeHeader = document.querySelector('.c--header-a--is-active');
      if (activeHeader) {
        activeHeader.classList.remove('c--header-a--is-active');
        //console.log('Active class removed from header');
      }
      if (activeBurger) {
        activeBurger.classList.remove('c--sidenav-a--is-active');
        //console.log('Active class removed from burger');
      }
    }
  });

  tl.to(".c--overlay-b", { // Animate overlay visibility
    autoAlpha: 0,
    duration: 0.7,
    ease: "linear",
    onComplete: () => {
      const overlay = document.querySelector('.c--overlay-b');
      if(overlay){
        overlay.classList.remove('c--overlay-b--is-visible');
        overlay.style.visibility = 'hidden';
        //console.log('Overlay hidden and visible class removed.');
      }
      
    }
  }, ">"); // The ">" means start this animation after the previous one completes

  return tl;
};

// hide sidenav utility to hide it when user exits current page
export const hideSidenav = (payload) => {
  let tl = this.gsap.timeline();
  tl.to(".c--sidenav-a", {
    right: "-200%",
    duration: 1.2,
    ease: "power2.in",
  });
  tl.to(
    ".c--overlay-a",
    {
      autoAlpha: 0, // Fade out effect for the overlay
      duration: 0.5,
      ease: "power2.in",
      onComplete: () => {
        const activeBurger = document.querySelector('.c--sidenav-a--is-active');
        this.gsap.set(".c--overlay-a", { display: "none" }); // Set display to none after fading out
        if (activeBurger) {
          activeBurger.classList.remove('c--sidenav-a--is-active');
          //console.log('Active class removed from sidenav');
        }
      },
    },
    ">"
  );

  return tl;
};

export const checkItems = async (payload) => {
  var intervalIndex = [];
  for (let index = 0; index < payload.items.length; index++) {
    const element = payload.items[index];
    var selectedElements = document.querySelectorAll(`.${element.class}`);
    if (selectedElements) {
      for (let i = 0; i < selectedElements.length; i++) {
        await new Promise((innerResolve) => {
          intervalIndex[i] = setInterval(() => {
            if (window[element.windowName] && window[element.windowName][i]?.isReady) {
              clearInterval(intervalIndex[i]);
              innerResolve();
            }
          }, payload.frequency);
        });
      }
    }
  }
};


export function smoothScrollToTop(payload) {
  return new Promise((resolve) => {
    const scrollStep = () => {
      if (window.scrollY === 0) {
        resolve();
      } else {
        requestAnimationFrame(scrollStep);
      }
    };
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
    scrollStep();
  });
}
