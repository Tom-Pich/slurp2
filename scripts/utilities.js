export function calculate(str) {
    if (str === null) return "";
    str = str.replace(/[+-]+$/g, ""); // trim + and - at the end
    str = str.replace(/[^-\(\)\d/\*+\.]/g, ""); // only allow - + / * ( ) 0-9 and .
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