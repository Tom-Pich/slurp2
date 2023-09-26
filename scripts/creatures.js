import { qs, qsa } from "/scripts/utilities.js"

/**
 * @param {string} weight in kg
 * @param {bool} interval interval of strength if true, or only single exact value if false
 * @returns strength
 */
export async function getStrengthFromWeight(weight, interval = false) {
	let strength = await fetch(`/api/weight-strength?weight=${weight}&interval=${interval}`)
		.then(response => response.json())
		.then(response => response.data);
	return strength;
}

/**
 * @param {string} weight in kg
 * @param {bool} interval interval of pdv if true, or only single exact value if false
 * @returns pdv
 */
export async function getPdVFromWeight(weight, interval = false) {
	let pdv = await fetch(`/api/weight-pdv?weight=${weight}&interval=${interval}`)
		.then(response => response.json())
		.then(response => response.data);
	return pdv;
}

export async function getStrengthDamages(strength) {
	let damages = await fetch(`/api/strength-damages?strength=${strength}`)
		.then(response => response.json())
		.then(response => response.data)
	return damages
}

export async function getTramplingDamages(weight) {
	let damages = await fetch(`/api/trampling-damages?weight=${weight}`)
		.then(response => response.json())
		.then(response => response.data)
	return damages
}

const weightInput = qsa("[data-role=weight-input]");
const strengthWrapper = qs("[data-role=strength-wrapper]");
const pdvWrapper = qs("[data-role=pdv-wrapper]");
const withInterval = true;
weightInput[0].addEventListener("keyup", (e) => {
	const weight = parseFloat(e.target.value)
	if (weight) {
		getStrengthFromWeight(weight, withInterval)
			.then(strength => strengthWrapper.innerText = strength);
		getPdVFromWeight(weight, withInterval)
			.then(pdv => pdvWrapper.innerText = pdv);
	}
})

const strengthInput = qs("[data-role=strength-input]")
const estocWrapper = qs("[data-role=estoc-dmg-wrapper]")
const tailleWrapper = qs("[data-role=taille-dmg-wrapper]")
const biteWrapper = qs("[data-role=bite-dmg-wrapper]")
const hornsWrapper = qs("[data-role=horns-dmg-wrapper]")
const tramplingWrapper = qs("[data-role=trampling-dmg-wrapper]")
strengthInput.addEventListener("keyup", (e) => {
	const strength = parseInt(e.target.value)
	if (strength) {
		getStrengthDamages(strength)
			.then(damages => {
				estocWrapper.innerText = damages.estoc;
				tailleWrapper.innerText = damages.taille;
				biteWrapper.innerText = damages.morsure;
				hornsWrapper.innerText = damages.cornes;
			})
	}
})
weightInput[1].addEventListener("keyup", (e) => {
	const weight = parseFloat(e.target.value)
	if (weight) {
		getTramplingDamages(weight)
			.then(damages => {
				tramplingWrapper.innerText = damages
			})
	}
})