import morphdom from './vendor/morphdom-esm.js';

/**
 * update the DOM part corresponding to selector with
 * the provided source document.
 * Needs Morphdom
 * @param {string} selector like for querySelector. Target element must be unique.
 * @param {string} source an HTML page with updated values
 */

export function updateDOM(selector, source) {
    return new Promise((resolve, reject) => {
        try {
            const parser = new DOMParser();
            const virtualDoc = parser.parseFromString(source, "text/html");
            const sourceElement = virtualDoc.querySelector(selector);
            const targetElement = document.querySelector(selector);
            
            morphdom(targetElement, sourceElement, {
                onBeforeElUpdated: function (fromEl, toEl) {
                    // keep <details> state (open/close) if id are the same
                    if (fromEl.tagName === "DETAILS" && fromEl.id === toEl.id) toEl.open = fromEl.open;
                    if (fromEl.dataset.morphdom === "ignore") return false;
                }
            });

            // Resolve the promise with any data you want to return
            resolve('DOM updated successfully');
        } catch (error) {
            // Reject the promise if an error occurs
            reject(error);
        }
    });
}

// Usage
/* updateDOM('selector', 'source').then((data) => {
    console.log(data);
}).catch((error) => {
    console.error('Error updating DOM:', error);
}); */
