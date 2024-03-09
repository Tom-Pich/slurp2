import { qs } from "./utilities.js"

export function roll(code) {
	let result = 0, x, y, op, z
	let match = /^(\d+)d(\d{0,3})([+-/*]*)([0-9\.]+)*/.exec(code)

	if (match === null) {
		result = isNaN(parseInt(code)) ? 0 : parseInt(code)
		x = 0, y = "", op = "+", z = result
	}
	else {
		x = parseInt(match[1])
		y = (match[2] != "") ? parseInt(match[2]) : 6
		op = (match[3] != "") ? match[3] : "+"
		z = (match[4] != undefined && match[4] != "") ? parseFloat(match[4]) : 0

		// handling special cases: 1d-2, 1d-3, 1d-4, 1d-5
		if (x === 1 && y === 6 && op === "-" && z === 2){ result = Math.floor(Math.random() * 5) }
		else if (x === 1 && y === 6 && op === "-" && z === 3){ result = Math.floor(Math.random() * 4) }
		else if (x === 1 && y === 6 && op === "-" && z === 4){ result = Math.floor(Math.random() * 3) }
		else if (x === 1 && y === 6 && op === "-" && z === 5){ result = Math.floor(Math.random() * 2) }

		// regular dices throw
		else{
			for (let i = 0; i < x; i++) { result += Math.floor(Math.random() * y) + 1 }
			switch (op) {
				case "+": result += z; break;
				case "-": result -= z; break;
				case "*": result *= z; break;
				case "/": result /= z; break;
			}
		}
	}
	let expression = `${x}d${y === 6 ? "" : y}${op}${z}`;
	expression = expression.replace("+0", "")
	expression = expression.replace("-0", "")
	return { expression: expression, result: result }
}

export async function getLocalisation() {
	let data = new FormData;
	data.append("roll", roll("3d").result);
	const result = await fetch("/api/localisation-table", {
		method: 'post',
		body: data
	})
		.then(result => result.json())
		.then(result => result.data)
	return result
}

export function collectOpponentData(number){
	const opponentWrapper = qs(`[data-opponent="${number}"]`)

	const opponent = {
		name: opponentWrapper.querySelector("[data-type=name]").value || `Protagoniste ${number}`,
		dex: opponentWrapper.querySelector("[data-type=dex]").value || 0,
		san: opponentWrapper.querySelector("[data-type=san]").value || 0,
		pdvm: opponentWrapper.querySelector("[data-type=pdvm]").value || 0,
		pdv: opponentWrapper.querySelector("[data-type=pdv]").value || opponentWrapper.querySelector("[data-type=pdvm]").value,
		painResistance: opponentWrapper.querySelector("[data-type=pain-resistance]").value,
		members: opponentWrapper.querySelector("[data-type=members]").value,
	}

	return opponent
}