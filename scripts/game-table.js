import { qs, qsa, ce, calculate, int } from "./utilities.js"
import { wsURL, Message } from "./ws-utilities.js"
import { roll, getLocalisation, collectOpponentData, scoreTester } from "./game-table-utilities.js"

// ––– Websocket Chat Client ––––––––––––––––––––––––

const chatEntry = qs("#chat-input-wrapper");
const id = parseInt(chatEntry.dataset.id);
const login = chatEntry.dataset.login;
const key = chatEntry.dataset.key;

const usersWrapper = qs("#connected-users")
const dialogWrapper = qs("#chat-dialog-wrapper")
const emojiBtns = qsa("[data-role=emoji-button]")
const inputEntry = qs("#msg-input")

const ws = new WebSocket(wsURL);

let users = {};
let lastSender = 0;
let lastMessageTime = 0;
let lastRecipients = "[]"; // in JSON, to compare with message.recipients

ws.onopen = () => {
	let initMessage = new Message(id, key, "chat-init", login);
	ws.send(initMessage.stringify());
}

ws.onmessage = (rawMessage) => {

	const message = JSON.parse(rawMessage.data);
	console.log(message)

	// create user list and display it in the tchat
	if (message.type === "chat-users") {
		users = message.content; // { "id1" : { login : "login1", isConnected : bool}, ... }
		const userList = [];
		Object.entries(users).forEach(([id, user]) => {
			if (user.isConnected) userList.push(`${user.login} (${id})`); // filling userList
		})
		usersWrapper.innerText = userList.join(", "); // display userList
		if (message.isDeconnection === undefined) {
			let notif = new Audio('/assets/notifs/user-log.mp3');
			notif.play();
		}
	}

	// handle new message in tchat
	if (message.type === "chat-message" || message.type === "chat-roll") {

		const jsonRecipients = JSON.stringify(message.recipients);

		const p = ce("div", ["chat-message-wrapper"])
		const messageRef = ce("div", ["chat-message-header"]);
		const messageText = ce("div", ["chat-message-content"]);

		// message global CSS classes
		if (message.type === "chat-roll") messageText.classList.add("color1");
		if (message.sender === id) p.classList.add("self-message");
		if (message.sender !== id) p.classList.add("bg-color-user-" + (message.sender % 7 + 1));
		if (message.sender === lastSender  && jsonRecipients === lastRecipients && (message.timestamp - lastMessageTime) < 15000) p.classList.add("same-routing");
		if (message.recipients.length > 0) p.classList.add("is-private");

		// building message "header"
		if (message.sender !== id) { messageRef.innerText = users[message.sender].login; }
		if (message.recipients.length) {
			const recipientLogins = [];
			message.recipients.forEach(recipientId => {
				const login = users[recipientId] === undefined ? "?" : users[recipientId].login;
				recipientLogins.push(login)
			})
			messageRef.innerText += ` (à ${recipientLogins.join(", ")})`;
		}
		const time = new Date(message.timestamp);
		const readableTime = time.toLocaleTimeString('fr-FR');
		messageRef.innerText += ` ${readableTime}`;

		// finishing message building : content + injection in DOM
		messageText.innerHTML = message.content; // sanitized on server
		p.append(messageRef, messageText);
		dialogWrapper.append(p);

		// notifications
		if (message.type === "chat-roll" && message.history === undefined) {
			let notif = new Audio('/assets/notifs/dice-roll.mp3');
			notif.play();
		}
		if (message.type === "chat-message" && message.sender !== id && message.history === undefined) {
			let notif = message.recipients.length ? new Audio('/assets/notifs/secret.mp3') : new Audio('/assets/notifs/message.mp3');
			notif.play();
		}

		// scroll the dialog down to the bottom
		if (dialogWrapper.scrollHeight - (dialogWrapper.offsetHeight + dialogWrapper.scrollTop) < 250) {
			setTimeout(() => { dialogWrapper.scrollTop = dialogWrapper.scrollHeight - dialogWrapper.offsetHeight + 5; }, 200)
		}

		lastSender = message.sender;
		lastMessageTime = message.timestamp;
		lastRecipients = jsonRecipients;
	}
}

// "Enter" event in message input
inputEntry.addEventListener("keydown", function (e) {
	if (e.keyCode === 13) {
		e.preventDefault();
		flushMsg("chat-message");
	}
});

// function fired on "enter" : send the message and clean the text entry
function flushMsg(type) {

	// extract recipients from inputEntry.value
	const recipientsRegexp = /^\/(\d+,){0,10}\d+/;
	const recipientsRegexpResult = recipientsRegexp.exec(inputEntry.value);
	let recipients = [];
	if (recipientsRegexpResult) {
		recipients = recipientsRegexpResult[0].substring(1).split(","); // array of recipients ID
		recipients = recipients.map(id => parseInt(id)); // conversion of IDs in int
		inputEntry.value = inputEntry.value.replace(recipientsRegexpResult[0], "").trim(); // delete recipient from message text
	}

	// handle inline rolls
	const inlineRollRegexp = /\[\d{1,2}\]/g; // search for expressions like [7] or [18] /\[\d{1,2}\]/g;
	const inlineRollRegexpResult = inputEntry.value.match(inlineRollRegexp);
	if (inlineRollRegexpResult) {
		const scores = [];
		inlineRollRegexpResult.forEach(match => {
			scores.push(parseInt(match.replace("[", "").replace("]", ""))); // extract scores from [] and parse them to integer
		})
		scores.forEach(score => {
			const rollResult = roll("3d").result;
			const outcome = scoreTester(score, rollResult);
			const detailledResult = `[ ${score} → ${rollResult} (MR ${outcome.MR} ${outcome.symbol}) ]`;
			const replacementRegexp = new RegExp(`\\[${score}\\]`);
			inputEntry.value = inputEntry.value.replace(replacementRegexp, detailledResult); // replace [xx] by detailled outcome		
		})
		type = "chat-roll"; // changing message type
	}

	let message = new Message(id, key, type, inputEntry.value, recipients);
	ws.send(message.stringify());
	inputEntry.value = "";
}

// add emoji in chat entry
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
	flushMsg("chat-roll")
})

// score tester
const scoreWidgets = qsa("[data-role=score-tester]")
scoreWidgets.forEach(widget => {

	const skillNameInput = widget.querySelector("[data-type=skill-name]");
	const skillNumber = skillNameInput.dataset.skillNumber;
	const skillScoreInput = widget.querySelector("[data-type=score]");
	skillNameInput.value = localStorage.getItem(`skill-${skillNumber}-name`)
	skillScoreInput.value = localStorage.getItem(`skill-${skillNumber}-score`)

	widget.addEventListener("keyup", (e) => {
		localStorage.setItem(`skill-${skillNumber}-name`, skillNameInput.value);
		if (skillNameInput.value === "") { skillScoreInput.value = ""; }
		localStorage.setItem(`skill-${skillNumber}-score`, skillScoreInput.value);
	})

	widget.addEventListener("submit", (e) => {
		const skillName = skillNameInput.value;
		const score = parseInt(skillScoreInput.value);

		if (isNaN(score) || skillName === "") { return }

		let modif = parseInt(widget.querySelector("[data-type=modif]").value);
		modif = int(modif);
		const netScore = score + modif
		const diceResult = roll("3d").result
		const outcome = scoreTester(netScore, diceResult)
		inputEntry.value += `${skillName} (${netScore}) → ${diceResult} (MR ${outcome.MR} ${outcome.symbol})`
		flushMsg("chat-roll")
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
	flushMsg("chat-roll")
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
			flushMsg("chat-roll")
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
	flushMsg("chat-roll")
})

// opponents list widget
const opponents = qsa("[data-role=opponent-wrapper]")
const opponentSelects = qsa("[data-type=name-selector]")

opponents.forEach(opponent => {

	const opponentNumber = opponent.dataset.opponent;
	const nameWrapper = opponent.querySelector("[data-type=name]")
	const dexWrapper = opponent.querySelector("[data-type=dex]")
	const sanWrapper = opponent.querySelector("[data-type=san]")
	const painResistanceWrapper = opponent.querySelector("[data-type=pain-resistance]")
	const pdvmWrapper = opponent.querySelector("[data-type=pdvm]")
	const pdvWrapper = opponent.querySelector("[data-type=pdv]")
	const membersWrapper = opponent.querySelector("[data-type=members]")

	// getting localStorage values
	nameWrapper.value = localStorage.getItem(`opponent-${opponentNumber}-name`)
	dexWrapper.value = localStorage.getItem(`opponent-${opponentNumber}-dex`)
	sanWrapper.value = localStorage.getItem(`opponent-${opponentNumber}-san`)
	painResistanceWrapper.value = localStorage.getItem(`opponent-${opponentNumber}-pain-resistance`);
	pdvmWrapper.value = localStorage.getItem(`opponent-${opponentNumber}-pdvm`)
	pdvWrapper.value = localStorage.getItem(`opponent-${opponentNumber}-pdv`)
	membersWrapper.value = localStorage.getItem(`opponent-${opponentNumber}-members`)

	// storing values in localStorage
	opponent.addEventListener("keyup", e => {

		const opponentDataType = ["name", "dex", "san", "pain-resistance", "pdvm", "pdv", "members"]
		// if name empty, reset all inputs for the active oponent
		if (e.target.dataset.type === "name" && e.target.value === "") {
			opponentDataType.forEach(dataType => {
				opponent.querySelector(`[data-type=${dataType}]`).value = "";
				localStorage.removeItem(`opponent-${opponentNumber}-${dataType}`);
			})

			// for "pain-resistance" checkbox
			//opponent.querySelector(`[data-type=pain-resistance]`).checked = false;
			//localStorage.removeItem(`opponent-${opponentNumber}-pain-resistance`);

		}

		const dataType = e.target.dataset.type
		const dataValue = e.target.type === "checkbox" ? e.target.checked : e.target.value;
		localStorage.setItem(`opponent-${opponentNumber}-${dataType}`, dataValue);
	})

	// update name in names selectors (general state and wound effects)
	nameWrapper.addEventListener("keyup", (e) => {
		opponentSelects.forEach(select => {
			select.options[opponentNumber - 1].innerText = nameWrapper.value !== "" ? nameWrapper.value : `Protagoniste ${opponentNumber}`
		})
	})
	// update name in names selectors on load (for localStorage)
	nameWrapper.dispatchEvent(new Event('keyup'));

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
		//.then(response=> response.text())
		//.then(response => console.log(response))
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
			flushMsg("chat-roll")
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
	if (parseInt(opponent.dex) < 0 || parseInt(opponent.san) < 0 || parseInt(opponent.pdvm) <= 0) {
		return
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
			//console.log(response.data)
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
				if (result["sonné"] && !result["perte de conscience"]) {
					formattedMsg += `<br>${result["sonné"]}`
				}
				if (result["perte de conscience"]) {
					formattedMsg += `<br>Le personnage perd conscience.`
				}
				if (result["chute"] && !result["perte de conscience"]) {
					formattedMsg += `<br>Le personnage chûte.`
				}
				if (result["dégâts membre"]) {
					formattedMsg += `<br>${result["dégâts membre"]}`
				}
			}

			inputEntry.value += formattedMsg;
			flushMsg("chat-roll")

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

// explosion widget
const explosionWidget = qs("#explosion-widget")
explosionWidget.addEventListener("submit", (e) => {

	const dmgExpression = qs("[data-type=explosion-dmg]").value;
	const distance = qs("[data-type=explosion-distance]").value;
	const fragSurface = qs("[data-type=explosion-frag-surface]").value;
	const isFragmentationDevice = qs("[data-type=explosion-frag-device]").checked;

	// evaluate damages – compression around a mathematical expectation of 5 per dice
	const roll1 = roll(dmgExpression).result;
	const roll2 = roll(dmgExpression).result;
	const roll3 = roll(dmgExpression).result;
	const dmgValue = (roll1 + roll2 + roll3) / 3 * 1.43;

	const data = new FormData;
	data.append("damages", dmgValue);
	data.append("distance", distance);
	data.append("fragmentation-surface", fragSurface);
	data.append("is-fragmentation-device", isFragmentationDevice);

	fetch("/api/explosion-damages", {
		method: "post",
		body: data,
	})
		.then(response => response.json())
		.then(response => {
			const results = response.data;
			const formattedMsg = `<b>Explosion&nbsp;:</b> dégâts ${results.damages} – fragment(s) ${results.fragments} – hauteur de chute ${results.height}&nbsp;m`;
			inputEntry.value += formattedMsg;
			flushMsg("chat-roll")
		})

})

// object damages widget – modify localisation options according to object type
const objectDamagesObjectTypeSelector = qs("[data-type=object-damages-object-type]")
const objectDamagesLocalisationSelector = qs("[data-type=object-damages-localisation-options]")
objectDamagesObjectTypeSelector.addEventListener("change", (e) => {
	const data = new FormData;
	data.append("object-type", objectDamagesObjectTypeSelector.value);
	fetch("/api/object-localisation-options", {
		method: "post",
		body: data,
	})
		.then(response => response.json())
		.then(response => {
			objectDamagesLocalisationSelector.innerHTML = "";
			response.data.forEach(localisation => {
				localisation = localisation.charAt(0).toUpperCase() + localisation.slice(1);
				const option = ce("option");
				option.innerText = localisation;
				objectDamagesLocalisationSelector.appendChild(option)
			})
		})
})

// object damages widget – submit
const objectDamageWidget = qs("#object-damages-widget")
objectDamageWidget.addEventListener("submit", (e) => {

	const pdsm = qs("[data-type=object-damages-pdsm]").value;
	const pds = qs("[data-type=object-damages-pds]").value;
	const integrite = qs("[data-type=object-damages-integrite]").value;
	const rd = qs("[data-type=object-damages-rd]").value;
	const dmgCode = qs("[data-type=object-damages-damages-code]").value
	const dmgValue = roll(dmgCode).result;

	if (isNaN(parseInt(pdsm)) || isNaN(parseInt(integrite)) || isNaN(parseInt(dmgValue))) { return }

	const data = new FormData;
	data.append("pdsm", pdsm);
	data.append("pds", pds);
	data.append("integrite", integrite);
	data.append("rd", rd);
	data.append("dmgValue", dmgValue);
	data.append("dmgType", qs("[data-type=object-damages-damages-type]").value)
	data.append("objectType", objectDamagesObjectTypeSelector.value)
	data.append("localisation", objectDamagesLocalisationSelector.value)
	data.append("rolls", [roll("3d").result, roll("3d").result, roll("3d").result, roll("3d").result])

	fetch("/api/object-damages-effects", {
		method: "post",
		body: data,
	})
		.then(response => response.json())
		.then(response => {
			const results = response.data;
			console.log(results);
			qs("[data-type=object-damages-pds]").value = results.pds;
			let formattedMsg = `
				<b>Dégâts ${results.objectType}</b><br>
				PdSm&nbsp;: ${results.pdsm} – RD&nbsp;: ${results.rd}<br>
				Dégâts&nbsp;: ${results.netDamages} (${results.damagesLevel})<br>
				PdS restant&nbsp;: ${results.pds} (${results.stateLevel})
			`;
			if (results.sideEffects.length) {
				formattedMsg += "<br>"
				for (let effect of results.sideEffects) {
					formattedMsg += `•&nbsp;${effect[0]} niv. ${effect[1]}<br>`
				}
			}
			inputEntry.value += formattedMsg;
			flushMsg("chat-roll")
		})
})

// vehicle collision widget
const vehicleCollisionWidget = qs("#vehicle-collision-widget")
vehicleCollisionWidget.addEventListener("submit", (e) => {
	const pdsm = parseInt(qs("[data-type=vehicle-collision-pdsm]").value);
	const severity = qs("[data-type=vehicle-collision-severity]");
	const severityIndex = parseInt(severity.value);
	const severityLevel = severity.options[severity.selectedIndex].innerText;

	if (!pdsm) { return }
	let damages;
	switch (severityIndex) {
		case 1: damages = Math.round((15 + roll("3d").result) / 100 * pdsm); break;
		case 2: damages = Math.round((40 + roll("3d").result) / 100 * pdsm); break;
		case 3: damages = Math.round((90 + roll("3d").result) / 100 * pdsm); break;
		case 4: damages = Math.round((180 + roll("6d").result) / 100 * pdsm); break;
		case 5: damages = "véhicule détruit"; break;
		default: damages = 0
	}

	const formattedMsg = `<b>Collision</b> ${severityLevel}&nbsp;: dégâts ${damages}`
	inputEntry.value += formattedMsg;
	flushMsg("chat-roll")
})