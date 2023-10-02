import { qs, qsa, calculate } from "./utilities.js"
import { Messenger } from "./messenger.js"
import { roll, getLocalisation, collectOpponentData } from "./game-table-utilities.js"

// ––– Websocket Chat Client ––––––––––––––––––––––––
const wsServerURL = window.location.hostname === "site-jdr" ? "ws://127.0.0.1:1337" : "wss://web-chat.pichegru.net:443";

const chatEntry = qs("#chat-input-wrapper");
const id = parseInt(chatEntry.dataset.id);
const login = chatEntry.dataset.login;
const key = chatEntry.dataset.key;

const usersWrapper = qs("#connected-users")
const chatBox = qs("#chat-dialog-wrapper")
const emojiBtns = qsa("[data-role=emoji-button]")
const inputEntry = qs("#msg-input")

const messenger = new Messenger(id, login, key, wsServerURL, chatBox, usersWrapper)

// ––– chat controllers (message input and emoji buttons)
inputEntry.addEventListener("keydown", function (e) {
	if (e.keyCode === 13) { flushMsg("standard") }
});

function flushMsg(type) {
	messenger.send(type, inputEntry.value);
	inputEntry.value = ""
	setTimeout(() => { inputEntry.value = "" }, 10)
}

emojiBtns.forEach(btn => {
	btn.addEventListener("click", (e) => {
		inputEntry.value += e.target.innerText;
		inputEntry.focus();
	})
})

// ––– Widgets ––––––––––––––––––––––––––––––––––––––––––––––––––––––––

// prevent default submit on each form
let widgetForms = qsa("#widgets-container form")
widgetForms.forEach(form => {
	form.addEventListener("submit", e => {
		e.preventDefault();
	})
})

// simple dice thrower
const simpleDiceWidget = qs("#simple-dice-widget")
simpleDiceWidget.addEventListener("submit", (e) => {
	const expression = simpleDiceWidget.querySelector("[data-type=dice-expression]").value
	let rollDice = roll(expression);
	inputEntry.value += `${rollDice.expression} → ${rollDice.result}`
	flushMsg("jet")
})

// score tester
const scoreWidgets = qsa("[data-role=score-tester]")
scoreWidgets.forEach(widget => {

	const skillNameInput = widget.querySelector("[data-type=skill-name]");
	const skillNumber = skillNameInput.dataset.skillNumber;
	const skillScoreInput = widget.querySelector("[data-type=score]");
	skillNameInput.value = localStorage.getItem(`skill-${skillNumber}-name`)
	skillScoreInput.value = localStorage.getItem(`skill-${skillNumber}-score`)

	widget.addEventListener("submit", (e) => {
		const skillName = skillNameInput.value;
		const score = parseInt(skillScoreInput.value);

		localStorage.setItem(`skill-${skillNumber}-name`, skillName);
		localStorage.setItem(`skill-${skillNumber}-score`, score);

		let modif = parseInt(widget.querySelector("[data-type=modif]").value);
		modif = isNaN(modif) ? 0 : modif;
		let netScore = score + modif
		const diceResult = roll("3d").result
		const MR = netScore - diceResult

		let symbol = MR >= 0 ? "🟢" : "🔴";

		if (diceResult === 18) { symbol = "😖" }
		else if (diceResult === 17) { symbol = netScore >= 16 ? "🔴" : "😖" }
		else if (diceResult === 4) { symbol = netScore < 6 ? "🟢" : "😎" }
		else if (diceResult === 3) { symbol = "😎" }
		else if (MR <= -10) { symbol = "😖" }
		else if (MR >= 10 && diceResult <= 7) { symbol = "😎" }

		inputEntry.value += `${skillName} (${score + modif}) → ${diceResult} (MR ${MR} ${symbol})`
		flushMsg("jet")
	})
})

// damages and wounds widgets (interacting, must be defined at this stage)
const weaponDamageWidget = qs("#weapon-damage-widget")
const woundEffectsWidget = qs("#wound-effect-widget")

// weapon damage widget
const wdwStrength = weaponDamageWidget.querySelector("[data-type=strength]")
const wdwCode = weaponDamageWidget.querySelector("[data-type=weapon-code]")
const wdwHands = weaponDamageWidget.querySelector("[data-type=hands]")
const wdwExpression = weaponDamageWidget.querySelector("[data-type=dice-code]")

function fetchDamageExpression(strength, code, hands) {
	if (parseInt(strength) && code) {
		let weaponCode = "B." + code;
		let data = new FormData;
		data.append("for", strength);
		data.append("notes", weaponCode);
		data.append("mains", hands);
		fetch("/api/weapon-damages", {
			method: 'post',
			body: data
		})
			.then(response => response.json())
			.then(response => response.data.damages.slice(2))
			.then(damage => wdwExpression.value = damage)
	}
}

[wdwStrength, wdwCode].forEach(input => {
	input.addEventListener("keyup", e => {
		fetchDamageExpression(wdwStrength.value, wdwCode.value, wdwHands.value)
	})
})
wdwHands.addEventListener("change", (e) => {
	fetchDamageExpression(wdwStrength.value, wdwCode.value, wdwHands.value)
})
weaponDamageWidget.addEventListener("submit", async (e) => {
	const damages = roll(wdwExpression.value);
	const localisation = await getLocalisation();

	// updating wounds effect widget
	woundEffectsWidget.querySelector("[data-type=raw-dmg]").value = damages.result
	woundEffectsWidget.querySelector("[data-type=localisation]").value = localisation[1];

	// flushing result
	inputEntry.value += `Dégâts (${damages.expression})&nbsp;: ${damages.result} – ${localisation[0]}`
	flushMsg("jet")
})

// critical widget
const criticalWidget = qs("#critical-widget")
criticalWidget.addEventListener("submit", (e) => {
	const table = criticalWidget.querySelector("[data-type=critical-categories]").value
	let data = new FormData;
	data.append("table", table);
	data.append("roll-3d", roll("3d").result);
	data.append("roll-1d", roll("1d").result);
	fetch("/api/critical-tables", {
		method: 'post',
		body: data
	})
		.then(result => result.json())
		.then(result => result.data)
		.then(critical => {
			inputEntry.value += `${critical}`
			flushMsg("jet")
		})
})

// burst widget
const burstWidget = qs("#burst-widget")
burstWidget.addEventListener("submit", async (e) => {
	const rcl = burstWidget.querySelector("[data-type=rcl]").value
	const bullets = burstWidget.querySelector("[data-type=fired-bullets]").value
	const mr = burstWidget.querySelector("[data-type=mr]").value
	const damagesDices = burstWidget.querySelector("[data-type=damage-dices]").value

	// get hit numbers
	let data = new FormData;
	data.append("rcl", rcl)
	data.append("bullets", bullets)
	data.append("mr", mr)
	const hitNumbers = await fetch("/api/burst-hits", {
		method: "post",
		body: data
	})
		.then(result => result.json())
		.then(result => result.data)

	// get localisation and damages for each hit
	let hits = [];
	for (let i = 0; i < hitNumbers; i++) {
		const damages = roll(damagesDices).result;
		const localisation = await getLocalisation();
		hits.push(`${damages} – ${localisation}`)
	}

	// formatting answer
	let formattedMsg = `<b>Rafale&nbsp;:</b> Rcl ${rcl} – Balles ${bullets} – MR ${mr}`
	hits.forEach((value, index) => {
		formattedMsg += `<br><b>${index + 1}.</b> ${value}`;
	})

	inputEntry.value += formattedMsg;
	flushMsg("jet")
})

// opponents list
const opponents = qsa("[data-role=opponent-wrapper]")
const opponentSelects = qsa("[data-type=name-selector]")

opponents.forEach(opponent => {

	const nameWrapper = opponent.querySelector("[data-type=name]")
	const pdvmWrapper = opponent.querySelector("[data-type=pdvm]")
	const pdvWrapper = opponent.querySelector("[data-type=pdv]")

	// update name in names selectors (general state and wound effects)
	nameWrapper.addEventListener("keyup", (e) => {
		const number = opponent.dataset.opponent
		opponentSelects.forEach(select => {
			select.options[number - 1].innerText = nameWrapper.value !== "" ? nameWrapper.value : `Protagoniste ${number}`
		})
	})

	// complete pdv if empty
	pdvmWrapper.addEventListener("blur", e => {
		if (pdvWrapper.value === "") { pdvWrapper.value = pdvmWrapper.value }
	})

	// calculate pdv
	pdvWrapper.addEventListener("blur", e => {
		pdvWrapper.value = calculate(pdvWrapper.value)
	})
})

// general state widget
const generalStateWidget = qs("#general-state-widget")
generalStateWidget.addEventListener("submit", (e) => {
	const opponentNumber = generalStateWidget.querySelector("[data-type=name-selector]").value
	const opponent = collectOpponentData(opponentNumber);

	const data = new FormData
	//data.append("dex", opponent.dex)
	data.append("san", opponent.san)
	data.append("pdvm", opponent.pdvm)
	data.append("pdv", opponent.pdv)
	data.append("pain-resistance", opponent.painResistance)
	data.append("members", opponent.members)

	fetch("/api/general-state", {
		method: "post",
		body: data,
	})
		.then(response => response.json())
		.then(response => {
			//console.log(response.data)
			let formattedMsg = `
				État général de <b>${opponent.name}</b><br>
				${response.data.general}
			`
			if (response.data.members !== undefined) {
				for (const [member, state] of Object.entries(response.data.members)) {
					formattedMsg += `<br>${member}&nbsp;: ${state}`
				}
			}
			inputEntry.value += formattedMsg;
			flushMsg("jet")
		})
})

// wound effects widget
woundEffectsWidget.addEventListener("submit", e => {
	const opponentNumber = woundEffectsWidget.querySelector("[data-type=name-selector]").value;
	const opponent = collectOpponentData(opponentNumber);
	const rawDmg = roll(woundEffectsWidget.querySelector("[data-type=raw-dmg]").value).result;
	const rd = woundEffectsWidget.querySelector("[data-type=rd]").value;
	const dmgType = woundEffectsWidget.querySelector("[data-type=dmg-type]").value;
	const bulletType = woundEffectsWidget.querySelector("[data-type=bullet-type]").value;
	const localisation = woundEffectsWidget.querySelector("[data-type=localisation]").value;
	const rolls = [];
	for (let i = 0; i < 7; i++) {
		rolls.push(roll("3d").result)
	}
	const data = new FormData
	data.append("dex", opponent.dex)
	data.append("san", opponent.san)
	data.append("pdvm", opponent.pdvm)
	data.append("pdv", opponent.pdv)
	data.append("pain-resistance", opponent.painResistance)
	//data.append("members", opponent.members) // not used
	data.append("raw-dmg", rawDmg || 0)
	data.append("rd", rd || 0)
	data.append("dmg-type", dmgType)
	data.append("bullet-type", bulletType)
	data.append("localisation", localisation)
	data.append("rolls", rolls)
	fetch("/api/wound-effects", {
		method: "post",
		body: data,
	})
		.then(response => response.json())
		.then(response => {
			console.log(response.data)
			const result = response.data

			if (result["pdvm"] <= 0) { throw new Error("Il manque des données."); }

			let formattedMsg = `<b>${opponent.name} – ${result["dégâts bruts"]} ( ${result["type dégâts"]} ${result["localisation"]})</b>`;
			let isNotDead = true;
			formattedMsg += `<br>Dégâts effectifs&nbsp;: ${result["dégâts effectifs"]}`;
			if (result["mort"]) {
				formattedMsg += `<br>${result["mort"]}`;
				isNotDead = false;
			}
			if (result["autres effets"]) {
				formattedMsg += `<br>${result["autres effets"]}`
			}
			if (isNotDead) {
				if (result["sonné"]) {
					formattedMsg += `<br>${result["sonné"]}`
				}
				if (result["perte de conscience"]) {
					formattedMsg += `<br>Le personnage perd conscience.`
				}
				if (result["chute"]) {
					formattedMsg += `<br>Le personnage chûte.`
				}
				if (result["dégâts membre"]) {
					formattedMsg += `<br>${result["dégâts membre"]}`
				}
			}

			inputEntry.value += formattedMsg;
			flushMsg("jet")

			// update opponent widget
			const opponentWrapper = qs(`[data-opponent="${opponentNumber}"]`)
			const pdvWrapper = opponentWrapper.querySelector("[data-type=pdv]")
			pdvWrapper.value = result["pdv"]
		})
})

// unfreeze bullet type
const dmgTypeSelector = woundEffectsWidget.querySelector("[data-type=dmg-type]")
const bulletTypeSelector = woundEffectsWidget.querySelector("[data-type=bullet-type]")
dmgTypeSelector.addEventListener("change", (e) => {
	if (["b0", "b1", "b2", "b3"].includes(dmgTypeSelector.value)) {
		bulletTypeSelector.disabled = false
	} else {
		bulletTypeSelector.value = "std"
		bulletTypeSelector.disabled = true
	}
})

// Memorizing entries
