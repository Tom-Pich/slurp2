import { qs, qsa, ce } from "./lib/dom-utils.js";
import { int } from "./utilities.js";
import { flushMsg } from "./ws-utilities.js";
import { roll, getLocalisation, fetchDamageExpression, scoreTester, fetchResult, Opponent, setScoreWidget, mountNewScoreWidget, unmountScoreWidget, getHighestIndexOf } from "./game-table-utilities.js";

// widgets order : opponents, scores, simple-dice, round-counter, damage-localisation, critical, burst, fright-check, general-state, wound-effect, explosion, object-damage, vehicle-collision, generate-npc, reaction-test

const userId = int(qs("#login-element").dataset.id);
const inputEntry = qs("#msg-input");

const allWidgets = qsa("fieldset[data-name]");
const widgetForms = qsa("main form");

let opponents = qsa("[data-role=opponent-wrapper]");
let scoreWidgets = qsa("[data-name=score-tester] form");
const simpleDiceWidget = qs("[data-name=simple-roll] form");
const roundCounterWidget = qs("[data-name=round-counter] form");
const reactionWidget = qs("[data-name=widget-reaction] form");
const weaponDamageWidget = qs("[data-name=widget-damage-location] form");
const woundEffectsWidget = qs("[data-name=wound-effect] form");
const criticalWidget = qs("[data-name=widget-criticals] form");
const burstWidget = qs("[data-name=widget-burst] form");
const generalStateWidget = qs("#general-state-widget");
const frightcheckWidget = qs(["[data-name=fright-check] form"]);
const explosionWidget = qs(["[data-name=explosion-widget] form"]);
const objectDamageWidget = qs("#object-damages-widget");
const vehicleCollisionWidget = qs("#vehicle-collision-widget");
const npcWidget = qs("[data-name=npc-generator] form");

const wdwStrength = weaponDamageWidget.querySelector("[data-type=strength]");
const wdwCode = weaponDamageWidget.querySelector("[data-type=weapon-code]");
const wdwHands = weaponDamageWidget.querySelector("[data-type=hands]");
const wdwExpression = weaponDamageWidget.querySelector("[data-type=dice-code]");

const dmgTypeSelector = woundEffectsWidget.querySelector("[data-type=dmg-type]");
const bulletTypeSelector = woundEffectsWidget.querySelector("[data-type=bullet-type]");

const objectDamagesObjectTypeSelector = qs("[data-type=object-damages-object-type]");
const objectDamagesLocalisationSelector = qs("[data-type=object-damages-localisation-options]");

// prevent default submit on each form
widgetForms.forEach((form) => {
    form.addEventListener("submit", (e) => e.preventDefault());
});

// initiate opponent list widgets
opponents.forEach((opponent) => {
    opponent = new Opponent(opponent);
    opponent.setReactivity();
});

// opponent btns listener
const opponentNumberBtns = qsa("[data-role=set-opponent-number]");
opponentNumberBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
		if (parseInt(btn.value) === 1) Opponent.mountNewOpponent(opponents);
		else if (opponents.length > 1) Opponent.unmountLastOpponent(opponents);
		opponents = qsa("[data-role=opponent-wrapper]"); // refresh opponents
    });
});

// update opponent list length to fit all stored opponents
const opponentNumber = getHighestIndexOf("opponent");
if (opponentNumber > 1 ){
	const plusOneBtn = qs("[data-role=set-opponent-number][value='1']")
	for ( let i = 0; i < parseInt(opponentNumber) -1; i++) plusOneBtn.click();
}

// score tester widgets
scoreWidgets.forEach((widget) => setScoreWidget(widget, inputEntry, flushMsg));

// add/remove score tester
const scoreNumberBtns = qsa("[data-role=set-score-number]");
scoreNumberBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
        if (int(btn.value) === 1) mountNewScoreWidget(scoreWidgets, inputEntry, flushMsg);
        else if (scoreWidgets.length > 1) unmountScoreWidget(scoreWidgets);
        scoreWidgets = qsa("[data-name=score-tester] form"); // refresh scoreWidgets
    });
});

// update score list length to fit all stored score
const scoreWidgetNumber = getHighestIndexOf("skill");
if (scoreWidgetNumber > 3 ){
	const plusOneBtn = qs("[data-role=set-score-number][value='1']")
	for ( let i = 0; i < scoreWidgetNumber -3; i++) plusOneBtn.click();
}

// simple dice thrower
simpleDiceWidget.addEventListener("submit", (e) => {
    const expression = simpleDiceWidget.querySelector("[name=dice-expression]").value;
    const rollDice = roll(expression);
    inputEntry.value += `${rollDice.expression} → ${rollDice.result}`;
    flushMsg("chat-roll");
});

// round counter widget
roundCounterWidget.addEventListener("submit", (e) => {
    e.preventDefault();
	const opponents = qsa("[data-role=opponent-wrapper]"); // refresh opponents
    const roundNumberInput = roundCounterWidget.querySelector("[data-type=round-number]");
    const roundNumber = Math.max(int(roundNumberInput.value), 1);
    const roundMsgInput = roundCounterWidget.querySelector("[data-type=initiative-order]");

    // transform roundMsgInput into filtered array of number (default [])
    let numbersInitiativeOrder = roundMsgInput.value.match(/\d+/g); // keep only digits
    numbersInitiativeOrder = numbersInitiativeOrder || [];
    numbersInitiativeOrder = numbersInitiativeOrder.map(Number);

    // filter impossible opponent number and fetch matching names in the opponent widget (with default value)
    numbersInitiativeOrder = numbersInitiativeOrder.filter((num) => num <= opponents.length && num >= 1 && Number.isInteger(num));
    const opponentsInitiativeOrder = numbersInitiativeOrder.map((num) => opponents[num - 1].querySelector("[name=name]").value || `Protagoniste ${num}`);

    // add message to input entry and flush message as standard chat message
	inputEntry.value += `*Round ${roundNumber}* – `;
    if (!opponentsInitiativeOrder.length) inputEntry.value += roundMsgInput.value;
    else inputEntry.value += `*Round ${roundNumber}* – ${opponentsInitiativeOrder.join(", ")}`;
    flushMsg("chat-message");
    roundNumberInput.value = roundNumber + 1;
});

// reaction test widget
reactionWidget.addEventListener("submit", async (e) => {
    const reactionModifier = int(reactionWidget.querySelector("[data-type=reaction-modifier]").value.trim("+"));
    const reactionTest = roll("1d").result + reactionModifier;
    let data = new FormData();
    data.append("reaction-test", reactionTest);
    let result = await fetchResult("/api/reaction-test", data);
    inputEntry.value += `Jet de réaction (${reactionTest}) → ${result}`;
    flushMsg("chat-roll");
});

// weapon damage and localisation widget
wdwStrength.addEventListener("keyup", async (e) => {
    const expression = await fetchDamageExpression(wdwStrength.value, wdwCode.value, wdwHands.value);
    if (expression !== undefined) wdwExpression.value = expression;
});
wdwCode.addEventListener("keyup", async (e) => {
    const expression = await fetchDamageExpression(wdwStrength.value, wdwCode.value, wdwHands.value);
    if (expression !== undefined) wdwExpression.value = expression;
});
wdwHands.addEventListener("change", async (e) => {
    const expression = await fetchDamageExpression(wdwStrength.value, wdwCode.value, wdwHands.value);
    if (expression !== undefined) wdwExpression.value = expression;
});
weaponDamageWidget.addEventListener("submit", async (e) => {
    const damages = roll(wdwExpression.value);
    const localisation = await getLocalisation();

    // updating wounds effect widget
    woundEffectsWidget.querySelector("[data-type=raw-dmg]").value = damages.result;
    woundEffectsWidget.querySelector("[data-type=localisation]").value = localisation[1];

    // flushing result
    inputEntry.value += `Dégâts (${damages.expression})&nbsp;: ${damages.result} – ${localisation[0]}`;
    flushMsg("chat-roll");
});

// critical widget
criticalWidget.addEventListener("submit", async (e) => {
    const table = criticalWidget.querySelector("[data-type=critical-categories]").value;
    let data = new FormData();
    data.append("table", table);
    data.append("roll-3d", roll("3d").result);
    data.append("roll-1d", roll("1d").result);
    const critical = await fetchResult("/api/critical-tables", data);
    inputEntry.value += `${critical}`;
    flushMsg("chat-roll");
});

// burst widget
burstWidget.addEventListener("submit", async (e) => {
    const rcl = burstWidget.querySelector("[data-type=rcl]").value;
    const bullets = burstWidget.querySelector("[data-type=fired-bullets]").value;
    const mr = burstWidget.querySelector("[data-type=mr]").value;
    const damagesDices = burstWidget.querySelector("[data-type=damage-dices]").value;

    // get hit numbers
    let data = new FormData();
    data.append("rcl", rcl);
    data.append("bullets", bullets);
    data.append("mr", mr);
    const hitNumbers = await fetch("/api/burst-hits", {
        method: "post",
        body: data,
    })
        .then((result) => result.json())
        .then((result) => result.data);

    // get localisation and damages for each hit
    let hits = [];
    for (let i = 0; i < hitNumbers; i++) {
        const damages = roll(damagesDices).result;
        const localisation = await getLocalisation();
        hits.push(`${damages} – ${localisation}`);
    }

    // formatting answer
    let formattedMsg = `<b>Rafale&nbsp;:</b> Rcl ${rcl} – Balles ${bullets} – MR ${mr}`;
    hits.forEach((value, index) => {
        formattedMsg += `<br><b>${index + 1}.</b> ${value}`;
    });

    inputEntry.value += formattedMsg;
    flushMsg("chat-roll");
});

// general state widget (add category !)
generalStateWidget.addEventListener("submit", async (e) => {
    const opponentNumber = generalStateWidget.querySelector("[name=opponent-selector]").value;
    const opponent = new Opponent(opponents[opponentNumber - 1]);

    const data = new FormData();
    data.append("san", opponent.san.value);
    data.append("pdvm", opponent.pdvm.value);
    data.append("pdv", opponent.pdv.value);
    data.append("pain-resistance", opponent["pain-resistance"].value);
    data.append("members", opponent.members.value);

    const response = await fetchResult("/api/general-state", data);

    let formattedMsg = `État général de <b>${opponent.name.value || "Protagoniste " + opponent.number}</b><br>${response.general}`;
    if (response.members !== undefined) {
		for (const [member, state] of Object.entries(response.members)) formattedMsg += `<br>${member}&nbsp;: ${state}`;
    }
	if (response["members-error"]) formattedMsg += `<br>Membres&nbsp;: données incohérentes`;
    inputEntry.value += formattedMsg;
    flushMsg("chat-roll");
});

// wound effects widget
woundEffectsWidget.addEventListener("submit", async (e) => {
    const opponentNumber = woundEffectsWidget.querySelector("[name=opponent-selector]").value;
    const opponent = new Opponent(opponents[opponentNumber - 1]);
    const rawDmg = roll(woundEffectsWidget.querySelector("[data-type=raw-dmg]").value).result;
    const rd = woundEffectsWidget.querySelector("[data-type=rd]").value;
    const dmgType = woundEffectsWidget.querySelector("[data-type=dmg-type]").value;
    const bulletType = woundEffectsWidget.querySelector("[data-type=bullet-type]").value;
    const localisation = woundEffectsWidget.querySelector("[data-type=localisation]").value;
    const rolls = [];
    for (let i = 0; i < 7; i++) rolls.push(roll("3d").result);

    const data = new FormData();
    data.append("category", opponent.category.value);
    data.append("dex", opponent.dex.value);
    data.append("san", opponent.san.value);
    data.append("pdvm", opponent.pdvm.value);
    data.append("pdv", opponent.pdv.value);
    data.append("pain-resistance", opponent["pain-resistance"].value);
    data.append("raw-dmg", rawDmg || 0);
    data.append("rd", rd || 0);
    data.append("dmg-type", dmgType);
    data.append("bullet-type", bulletType);
    data.append("localisation", localisation);
    data.append("rolls", rolls);

    const result = await fetchResult("/api/wound-effects", data);

    if (result.erreur) {
        inputEntry.value += "Data opposants manquantes";
        flushMsg("chat-roll");
        return;
    }

    let formattedMsg = `<b>${opponent.name.value || "Protagoniste " + opponent.number} – ${result["dégâts bruts"]} ( ${result["type dégâts"]} ${result["localisation"]})</b>`;
    let isNotDead = true;
    formattedMsg += `<br>Dégâts effectifs&nbsp;: ${result["dégâts effectifs"]}`;
    if (result["recul"]) formattedMsg += `<br>Recul de ${result["recul"]}&nbsp;m.`;
    if (result["mort"]) {
        formattedMsg += `<br>${result["mort"]}`;
        isNotDead = false;
    }
    if (isNotDead) {
        if (result["autres effets"]) {
            formattedMsg += `<br>${result["autres effets"]}`;
        }
        if (result["sonné"] && !result["perte de conscience"]) {
            formattedMsg += `<br>${result["sonné"]}`;
        }
        if (result["perte de conscience"]) {
            formattedMsg += `<br>Le personnage perd conscience.`;
        }
        if (result["chute"] && !result["perte de conscience"]) {
            formattedMsg += `<br>Le personnage chûte.`;
        }
        if (result["dégâts membre"]) {
            formattedMsg += `<br>${result["dégâts membre"]}`;
            if (result["état membre"] !== "") {
                formattedMsg += ` (${result["état membre"]})`;
            }
        }
    }

    inputEntry.value += formattedMsg;
    flushMsg("chat-roll");
    opponent.pdv.value = result["pdv"];
});

// unfreeze bullet type
dmgTypeSelector.addEventListener("change", (e) => {
    if (["b0", "b1", "b2", "b3"].includes(dmgTypeSelector.value)) {
        bulletTypeSelector.disabled = false;
    } else {
        bulletTypeSelector.value = "std";
        bulletTypeSelector.disabled = true;
    }
});

// fright check Widget
frightcheckWidget.addEventListener("submit", async (e) => {
    const frightLevel = frightcheckWidget.querySelector(["[data-type=fright-level]"]).value;
    const sfScore = int(frightcheckWidget.querySelector(["[data-type=sf-score]"]).value);
    const sfModif = int(frightcheckWidget.querySelector(["[data-type=sf-modif]"]).value);
    const sanScore = int(frightcheckWidget.querySelector(["[data-type=san-score]"]).value);
    const netScore = sfScore + sfModif;

    if (sfScore <= 0 || (sanScore <= 0 && frightLevel >= 5)) {
        e.preventDefault();
        return;
    }

    const data = new FormData();
    const frighcheck = scoreTester(netScore, roll("3d").result);
    const rolls = [];
    for (let i = 0; i <= 6; i++) {
        rolls.push(roll("3d").result);
    }

    data.append("fright-level", frightLevel);
    data.append("sf-score", sfScore);
    data.append("san-score", sanScore);
    data.append("frightcheck-MR", frighcheck.MR);
    data.append("frightcheck-symbol", frighcheck.symbol);
    data.append("frightcheck-critical", frighcheck.critical);
    data.append("rolls", rolls.join(","));

    let result = await fetchResult("/api/fright-check", data);
    inputEntry.value = result;
    flushMsg("chat-roll", frighcheck.symbol);
});

// explosion widget
explosionWidget.addEventListener("submit", (e) => {
    const dmgExpression = qs("[data-type=explosion-dmg]").value;
    const distance = qs("[data-type=explosion-distance]").value;
    const fragSurface = qs("[data-type=explosion-frag-surface]").value;
    const isFragmentationDevice = qs("[data-type=explosion-frag-device]").checked;

    // evaluate damages – compression around a mathematical expectation of 5 per dice
    const roll1 = roll(dmgExpression).result;
    const roll2 = roll(dmgExpression).result;
    const roll3 = roll(dmgExpression).result;
    const dmgValue = ((roll1 + roll2 + roll3) / 3) * 1.43;

    const data = new FormData();
    data.append("damages", dmgValue);
    data.append("distance", distance);
    data.append("fragmentation-surface", fragSurface);
    data.append("is-fragmentation-device", isFragmentationDevice);

    fetch("/api/explosion-damages", {
        method: "post",
        body: data,
    })
        .then((response) => response.json())
        .then((response) => {
            const results = response.data;
            const formattedMsg = `<b>Explosion&nbsp;:</b> dégâts ${results.damages} – fragment(s) ${results.fragments} – hauteur de chute ${results.height}&nbsp;m`;
            inputEntry.value += formattedMsg;
            flushMsg("chat-roll");
        });
});

// object damages widget – modify localisation options according to object type
objectDamagesObjectTypeSelector.addEventListener("change", (e) => {
    const data = new FormData();
    data.append("object-type", objectDamagesObjectTypeSelector.value);
    fetch("/api/object-localisation-options", {
        method: "post",
        body: data,
    })
        .then((response) => response.json())
        .then((response) => {
            objectDamagesLocalisationSelector.innerHTML = "";
            response.data.forEach((localisation) => {
                localisation = localisation.charAt(0).toUpperCase() + localisation.slice(1);
                const option = ce("option");
                option.innerText = localisation;
                objectDamagesLocalisationSelector.appendChild(option);
            });
        });
});

// object damages widget – submit
objectDamageWidget.addEventListener("submit", (e) => {
    const pdsm = qs("[data-type=object-damages-pdsm]").value;
    const pds = qs("[data-type=object-damages-pds]").value;
    const integrite = qs("[data-type=object-damages-integrite]").value;
    const rd = qs("[data-type=object-damages-rd]").value;
    const dmgCode = qs("[data-type=object-damages-damages-code]").value;
    const dmgValue = roll(dmgCode).result;

    if (isNaN(parseInt(pdsm)) || isNaN(parseInt(integrite)) || isNaN(parseInt(dmgValue))) {
        return;
    }

    const data = new FormData();
    data.append("pdsm", pdsm);
    data.append("pds", pds);
    data.append("integrite", integrite);
    data.append("rd", rd);
    data.append("dmgValue", dmgValue);
    data.append("dmgType", qs("[data-type=object-damages-damages-type]").value);
    data.append("objectType", objectDamagesObjectTypeSelector.value);
    data.append("localisation", objectDamagesLocalisationSelector.value);
    data.append("rolls", [roll("3d").result, roll("3d").result, roll("3d").result, roll("3d").result]);

    fetch("/api/object-damages-effects", {
        method: "post",
        body: data,
    })
        .then((response) => response.json())
        .then((response) => {
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
                formattedMsg += "<br>";
                for (let effect of results.sideEffects) {
                    formattedMsg += `•&nbsp;${effect[0]} niv. ${effect[1]}<br>`;
                }
            }
            inputEntry.value += formattedMsg;
            flushMsg("chat-roll");
        });
});

// vehicle collision widget
vehicleCollisionWidget.addEventListener("submit", (e) => {
    const pdsm = parseInt(qs("[data-type=vehicle-collision-pdsm]").value);
    const severity = qs("[data-type=vehicle-collision-severity]");
    const severityIndex = parseInt(severity.value);
    const severityLevel = severity.options[severity.selectedIndex].innerText;

    if (!pdsm) {
        return;
    }
    let damages;
    switch (severityIndex) {
        case 1:
            damages = Math.round(((15 + roll("3d").result) / 100) * pdsm);
            break;
        case 2:
            damages = Math.round(((40 + roll("3d").result) / 100) * pdsm);
            break;
        case 3:
            damages = Math.round(((90 + roll("3d").result) / 100) * pdsm);
            break;
        case 4:
            damages = Math.round(((180 + roll("6d").result) / 100) * pdsm);
            break;
        case 5:
            damages = "véhicule détruit";
            break;
        default:
            damages = 0;
    }

    const formattedMsg = `<b>Collision</b> ${severityLevel}&nbsp;: dégâts ${damages}`;
    inputEntry.value += formattedMsg;
    flushMsg("chat-roll");
});

// NPC widget
const npcRegion = npcWidget.querySelector("[name=region]");
if (localStorage.getItem("npc-region") !== null) npcRegion.value = localStorage.getItem("npc-region");
npcWidget.addEventListener("change", () => {
    localStorage.setItem("npc-region", npcRegion.value);
});
npcWidget.addEventListener("submit", async (e) => {
    const data = new FormData(npcWidget);

    let result = await fetchResult("/api/npc-generator", data);
	inputEntry.value = `/${userId} `; // always secret

    if (result.error) {
        inputEntry.value += "Paramètres PNJ invalides";
        flushMsg("chat-roll");
        return;
    }

    if (result["name-only"]) {
        inputEntry.value += result.name;
        flushMsg("chat-roll");
        return;
    }

    const facialHair = result.facialHair ? `${result.facialHair},` : "";
    const corpulence = result.corpulence !== "moyenne" ? `${result.corpulence}, ` : "";
    const size = result.size !== "moyenne" ? `${result.size}, ` : "";
    const beauty = result.beauty !== "moyenne" ? `${result.beauty}, ` : "";
    const intelligence = result.intelligence !== "moyenne" ? `${result.intelligence}, ` : "";
    const specialTraits = result.specialTraits ? `<br>Choisir une particularité parmi&nbsp;: <i>${result.specialTraits}</i>` : "";

    inputEntry.value += `
		<b>${result.name}</b><br>
		${result.hair},
		${facialHair}
		yeux ${result.eyes},
		${corpulence}
		${size}
		${beauty}
		${intelligence}
		${result.social}
		${specialTraits}
	`;
    flushMsg("chat-roll");
});

// ––– Widgets config ––––––––––––––––––––––––––––––––––––––––––––––––––––––––
//localStorage.removeItem("display-widgets") // reset localStorage (for dev purpose)

const checkboxesWrapper = qs("[data-role=widget-choices]");
const checkboxTemplate = qs("[data-role=widget-choices] template");
const defaultDisplayedWidgets = { "simple-roll": true, "score-tester": true, "widget-damage-location": true, "widget-criticals": true };
const displayedWidgets = JSON.parse(localStorage.getItem("display-widgets")) || defaultDisplayedWidgets;

// build widgets choice dialog
allWidgets.forEach((widget) => {
    const widgetEntry = checkboxTemplate.content.cloneNode(true); // get template clone

    const checkbox = widgetEntry.querySelector("input"); // handling checkbox functionnalities
    checkbox.dataset.name = widget.dataset.name;
    if (displayedWidgets[widget.dataset.name]) checkbox.checked = true;
    checkbox.addEventListener("change", (e) => {
        displayedWidgets[checkbox.dataset.name] = checkbox.checked; // update displayedWidgets
        localStorage.setItem("display-widgets", JSON.stringify(displayedWidgets)); // store state in localStorage
        udpateDisplayedWidget(); // update display
    });

    widgetEntry.querySelector("span").innerHTML = widget.querySelector("legend").childNodes[0].textContent.trim();
    checkboxesWrapper.appendChild(widgetEntry);
});

/** update displayed widgets and checkboxes according to stored state */
function udpateDisplayedWidget() {
    allWidgets.forEach((widget) => (widget.hidden = !displayedWidgets[widget.dataset.name]));
}

udpateDisplayedWidget();
