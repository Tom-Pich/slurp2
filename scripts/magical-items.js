import { qs, qsa, coarseRound } from "./utilities.js"
"use strict"

function powerStoneRawPrice(pdm) {
	const price = coarseRound(2.5 * pdm ** 2 + 20 * pdm);
	return isNaN(price) ? "" : price
}

function powerStoneSellPrice(pdm) {
	const price = coarseRound(0.4 * pdm ** 3 + 7 * pdm ** 2 + 65 * pdm) 
	return isNaN(price) ? "" : price
}

function potionPrice(materialPrice, preparationDuration = 1, difficultyModifier = 0, isIllegal = false) {
	// console.log(materialPrice)
	difficultyModifier = - Math.abs(difficultyModifier)
	const durationPrice = preparationDuration * 30;
	const mult_malus = 0.0294 * difficultyModifier ** 2 - 0.0675 * difficultyModifier + 1
	const price = coarseRound((materialPrice * 1.2 + durationPrice) * mult_malus * (isIllegal ? 1.5 : 1))
	return isNaN(price) ? "–" : price
}

// ––– Prix des potions
const material = qs("[data-role=widget-potion] [data-type=prix-materiaux]")
const duration = qs("[data-role=widget-potion] [data-type=temps-fabrication]")
const malus = qs("[data-role=widget-potion] [data-type=difficulte-fabrication]")
const illegal = qs("[data-role=widget-potion] [data-type=potion-illegale]")
const priceWrapper = qs("[data-role=widget-potion] [data-role=container-prix]")

qsa("[data-role=widget-potion] input").forEach(input => {
	["keyup", "change"].forEach(event => {
		input.addEventListener(event, e => {
			priceWrapper.innerText = potionPrice(material.value, duration.value, malus.value, illegal.checked)
		})
	})
})

// ––– Prix des pierres de puissance
const pdmWrapper = qs("[data-role=widget-pierre-puissance] [data-type=pdm]")
const rawPriceWrapper = qs("[data-role=widget-pierre-puissance] [data-role=prix-brut]")
const sellPriceWrapper = qs("[data-role=widget-pierre-puissance] [data-role=prix-vente]")

pdmWrapper.addEventListener("keyup", e => {
	rawPriceWrapper.innerText = powerStoneRawPrice(pdmWrapper.value)
	sellPriceWrapper.innerText = powerStoneSellPrice(pdmWrapper.value)
})