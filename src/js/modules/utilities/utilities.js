export function modifyTag({ selector = null, element = null, attributes, delay = 5000 }) {
    return new Promise((resolve, reject) => {
        // Using setTimeout to introduce a configurable delay
        setTimeout(() => {
            try {
                // Selecting the desired element either via selector or directly if an element is provided
                let targetElement = element || document.querySelector(selector);

                if (!targetElement) {
                    throw new Error(`Element not found.`);
                }

                // Adding the provided attributes to the target element
                Object.keys(attributes).forEach(key => {
                    targetElement.setAttribute(key, attributes[key]);
                });

                // Resolving the promise with the modified element
                resolve(targetElement);
            } catch (error) {
                // Rejecting the promise if an error occurs
                reject('Error modifying the element: ' + error.message);
            }
        }, delay); // Configurable delay
    });
}

export function getCookie (name){
    if (typeof document === "undefined") return null;
    const match = document.cookie.match(new RegExp("(^| )" + name + "=([^;]+)"));
    return match ? decodeURIComponent(match[2]) : null;
}

// export const tf_sto = (time) =>
//     new Promise(async (resolve) => {
//         setTimeout(
//             () => {
//                 resolve()
//             },
//             time ? time : 200
//         )
//     })
