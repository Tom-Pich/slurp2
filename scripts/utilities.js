export function qs(selector) {
    return document.querySelector(selector);
}

export function qsa(selector) {
    return document.querySelectorAll(selector);
}

export function ce(tag, classes = []) {
    const element = document.createElement(tag);
	classes.forEach((CSSclass) => element.classList.add(CSSclass));
    /* if (classes.length > 0) {
        classes.forEach((CSSclass) => {
            element.classList.add(CSSclass);
        });
    } */
    return element;
}

export function checkPasswordStrength(password) {
    const digit = /\d+/.test(password);
    const length = password.length >= 8;
    const specialchars = /\W+/.test(password);
    const space = /\s+/.test(password);
    const uppercase = /[A-Z]/.test(password);
    const lowercase = /[a-z]/.test(password);
    const isStrong = digit && length && specialchars && !space && uppercase && lowercase;
    return isStrong;
}

export function calculate(str) {
    if (str === null) return "";
    str = str.replace(/[+-]+$/g, ""); // trim + and - at the end
    str = str.replace(/[^-\(\)\d/\*+\.]/g, ""); // only allow - + / * ( ) 0-9 .
    let result;
    try {
        result = eval(str);
    } catch (e) {
        result = "";
    }
    result = result === undefined ? "" : result;
    return result;
}

export function int(x) {
    return isNaN(parseInt(x)) ? 0 : parseInt(x);
}

// round a value with precision depending on value
export function coarseRound(x) {
    let isNegative = false;
    if (x < 0) {
        x *= -1;
        isNegative = true;
    }
    if (x < 50)  x = Math.round(x);
	else if (x < 200) x = Math.round(x / 5) * 5;
	else if (x < 500) x = Math.round(x / 10) * 10;
	else if (x < 2000) x = Math.round(x / 50) * 50;
	else x = Math.round(x / 100) * 100;

    if (isNegative) x *= -1;

    return x;
}

// delete end modifier, like (+2) or (-1)
export function trimModifier(string) {
    string = string.replace(/\([+-]\d+\)$/g, "");
    string = string.trimEnd();
    return string;
}

// add an explicit sign (+ or -) in front of an integer
export function explicitSign(int) {
    if (int > 0) return `+${int}`;
    return `${int}`;
}