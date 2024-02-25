/**
 * alias for document.querySelector
 * @param {string} selector 
 * @returns HTML node
 */
export function qs(selector) {
	return document.querySelector(selector);
}

/**
 * alias for document.querySelectorAll
 * @param {string} selector 
 * @returns Nodelist
 */
export function qsa(selector) {
	return document.querySelectorAll(selector);
}

/**
 * create an HTML element with classes in array
 * @param {string} tag 
 * @param {array} classes 
 * @returns HTML element
 */
export function ce(tag, classes = []) {
	let element = document.createElement(tag);
	if (classes) {
		classes.forEach(CSSclass => {
			element.classList.add(CSSclass);
		})
	}
	return element;
}

/**
 * check if str as digits, specialchars, no space, uppercase and lowercase characters \
 * and if length >= 8
 * @param {string} password the password to check
 */
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

/**
 * calulate the result of a simple calculus string
 * @param {string} str 
 * @returns result of calculation
 */
export function calculate(str) {
	str = str.replace(/[^-()\d/*+\.]/g, '');
	let result = eval(str);
	result = result === undefined ? "" : result;
	return result;
}

/**
 * reload (and re-execute) all scripts with data-type=reloadable \
 * after DOM change
 */
export function reloadScripts() {
	const scripts = qsa("[data-type=reloadable]");
	scripts.forEach(script => {
		script.remove()
		const newScript = ce("script")
		newScript.type = script.type
		const scriptURL = new URL (script.src)
		newScript.src = scriptURL.pathname + "?v=" + new Date().getTime()
		newScript.dataset.type = "reloadable"
		qs("main").appendChild(newScript)
	})
}


/**
 * update HTML
 * @param {string} selector css-like selectore targeting a unique element
 * @param {*} content html-formatted string
 */
export function updateDOM(selector, content) {
	const parser = new DOMParser();
	const virtualDoc = parser.parseFromString(content, "text/html")
	const source = virtualDoc.querySelector(selector)
	const target = qs(selector)
	target.innerHTML = source.innerHTML
}

export function int(x){
	return isNaN(parseInt(x)) ? 0 : parseInt(x)
}

// round a value with precision depending on value
export function coarseRound(x) {
	let isNegative = false;
	if (x < 0) { x *= -1; isNegative = true; }

	if (x < 50) { x = Math.round(x); }
	else if (x < 200) { x = Math.round(x / 5) * 5; }
	else if (x < 500) { x = Math.round(x / 10) * 10; }
	else if (x < 2000) { x = Math.round(x / 50) * 50; }
	else { x = Math.round(x / 100) * 100; }

	if (isNegative) { x *= -1 }

	return x
}