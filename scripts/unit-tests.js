import { calculate } from "./utilities";

console.info("unit tests script")

const tests = {
	"4+3" : 7,
	"4-3" : 1,
	"4.5 + 1" : 5.5,
	"blip" : "",
	"6*3/2" : 9,
	"fetch(\"f**x\")" : "",
	"4..5 + 1" : "",
	"4x + 3" : 7,
	"2**3" : 8,
	"2*/3" : "",
	"2*+3" : 6,
	"*/(+(" : "",
	"5+1+" : 6
}

Object.entries(tests).forEach(([expr, result]) => {
	console.assert( calculate(expr) === result, "error evaluating " + expr )
})

console.info("end of unit tests")