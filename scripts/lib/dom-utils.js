export function qs(selector) {
    return document.querySelector(selector);
}

export function qsa(selector) {
    return document.querySelectorAll(selector);
}

export function ce(tag, classes = []) {
    const element = document.createElement(tag);
	classes.forEach((CSSclass) => element.classList.add(CSSclass));
    return element;
}