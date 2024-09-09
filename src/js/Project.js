// Styles
import "@scss/style.scss";

// JS Starts here

const terraVirtual = import.meta.env.VITE_TERRA_VIRTUAL;
console.log("server is running in " + import.meta.env.MODE + " mode");
console.log('Terra Virtual Variable:', terraVirtual);

import gsap from 'gsap';
import Boostify from 'boostify';

function getQueryParam(param) {
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.has(param); // returns true if the parameter is present, otherwise false
}

class Project {
  constructor() {
    window.isFired = true; // prevent multiple instances of the project class
    
    // terra debug mode, add ?debug to the url to enable debug mode
    this.terraDebug = getQueryParam('debug');

    window["lib"] = {};
    window["animations"] = {};
    
    this.boostify = new Boostify({
      debug: false,
      license: import.meta.env.VITE_LICENSE_KEY,
    });

    this.init()
  }
  async init(){
    try{

      // Dynamically import the preloadImages function,
      // and store it in the window.lib object for later use
      const { preloadImages } = await import(/* webpackChunkName: "PreloadImages" */ "@terrahq/helpers/preloadImages");
      window["lib"]["preloadImages"] = preloadImages;
      await preloadImages("img");

      // Dynamically import the preloadLotties function,
      // and store it in the window.lib object for later use
      const { preloadLotties } = await import(/* webpackChunkName: "PreloadLotties" */ "@terrahq/helpers/preloadLotties");
      window["lib"]["preloadLotties"] = preloadLotties;
      await preloadLotties();

    }
    catch(e){
      console.log(e);
    }
    finally{
      var tl = gsap.timeline({
        defaults: {duration: 0.8, ease: "power1.inOut"},
        onUpdate: async () => {
           // //* Check if the animation is at least 50% complete and the function hasn't been executed yet
          if (tl.progress() >= 0.5 && !this.halfwayExecuted) {
            this.halfwayExecuted = true;
            const { default: Main}  = await import("@js/Main.js");
            new Main({ 
                boostify: this.boostify,
                debug: this.terraDebug,
            });
            
          }

          if (this.terraDebug) {
            (async () => {
              try {
                const { terraDebugger } = await import('@terrahq/helpers/terraDebugger');
                terraDebugger({ submitQA: 'clickup-url' });
              } catch (error) {
                console.error('Error loading the debugger module:', error);
              }
            })();
          }
        },
      });
      tl.to(".c--preloader-a", {duration: 1, y:'-100%', ease: "power1.inOut"});

    }
  }
};

if (!window.isFired) {
  new Project();
}


