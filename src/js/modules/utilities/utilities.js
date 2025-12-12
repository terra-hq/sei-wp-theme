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
