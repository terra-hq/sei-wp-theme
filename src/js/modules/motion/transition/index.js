import gsap from 'gsap';
export const transition = [{
    from: '(.*)',
    to: '(.*)',
    out: (next, infos) => {
      gsap.to('#swup', { opacity: 0, duration: .25 ,onComplete: next });
    },
    in: async (next, infos) => {
      gsap.fromTo('#swup', { opacity: 0 }, { opacity: 1, duration: .25,onComplete: next });
    }
  }];
  