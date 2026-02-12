/**
 * @function updateScrollTriggers
 * @description Refreshes all active GSAP ScrollTrigger instances.
 *
 * This utility is meant to be executed whenever layout changes occur
 * (e.g. after expanding/collapsing content, lazy-loaded media, or
 * dynamic DOM injections that alter page height or scroll positions).
 *
 * The ScrollTrigger library must already be registered inside the Manager.
 * If ScrollTrigger is not available in the Manager, this function will throw.
 *
 * @example
 * * Assuming ScrollTrigger is already loaded into Manager:
 * updateScrollTriggers({ Manager });
 *
 * @param {Object} options
 * @param {Manager} options.Manager - The Terra Manager instance.
 */
export function updateScrollTriggers({ Manager }) {
    const ScrollTriggerLib = Manager.getLibrary("ScrollTrigger");
    ScrollTriggerLib.refresh();
}