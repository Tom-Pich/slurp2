export const qs = (selector) => document.querySelector(selector);
export const qsa = (selector) => document.querySelectorAll(selector);

export function ce(tag, classes = []) {
    const element = document.createElement(tag);
	classes.forEach((CSSclass) => element.classList.add(CSSclass));
    return element;
}