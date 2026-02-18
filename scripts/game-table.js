import { qs, qsa, ce } from "./lib/dom-utils.js";
import { Widget, Opponents, Scores, roll, scoreTester, fetchDamageExpression, getLocalisation, fetchResult } from "./game-table-utilities.js";
import { int } from "./utilities.js";

// reset older version of localStorage
const version = "2.0";
const storedVersion = localStorage.getItem("version");

if (!storedVersion || storedVersion !== version) {
    localStorage.clear();
	console.info("localStorage has been reset")
    localStorage.setItem("version", version);
}

const userID = parseInt(qs("#login-element").dataset.id);

// special widgets
const opponentsData = JSON.parse(localStorage.getItem("opponents")) ?? [];
const opponents = new Opponents(opponentsData);

const scoresData = JSON.parse(localStorage.getItem("skills")) ?? [];
const scores = new Scores(scoresData);

// standard widgets
const simpleDiceWidget = new Widget("simple-roll", function () {
    const expression = this.form.expression.value;
    const rollDice = roll(expression);
    return `${rollDice.expression} → ${rollDice.result}`;
});

const roundCounterWidget = new Widget("round-counter", function () {
    const roundNumberInput = this.form.round;
    const roundMsgInput = this.form.comment;

    const roundNumber = int(roundNumberInput.value);
    roundNumberInput.value = roundNumber + 1;

    const parsedInput = roundMsgInput.value.replace(/\d+/g, (match) => {
        const index = parseInt(match) - 1;
        if (opponents.list[index] && opponents.list[index].name) return opponents.list[index].name;
        return match;
    });

    // filter tags in parsedInput
    const temp = ce("div");
    temp.innerHTML = parsedInput;
    const safeParsedInput = temp.textContent || temp.innerText;

    return `*Round ${roundNumber}*${safeParsedInput !== "" ? " – " + safeParsedInput : ""}`;
});

const weaponDamageWidget = new Widget("widget-damage-location", async function () {
    const strength = this.form.strength;
    const dmgCode = this.form.code;
    const hands = this.form.hands;
    const dmgExpression = this.form.expression;

    const expression = await fetchDamageExpression(strength.value, dmgCode.value, hands.value);
    if (expression) dmgExpression.value = expression;

    const damages = roll(dmgExpression.value);
    const localisation = await getLocalisation();

    // updating wounds effect widget
    qs("[data-name=wound-effect] [name=raw-dmg]").value = damages.result;
    qs("[data-name=wound-effect] [name=localisation]").value = localisation[1];

    return `Dégâts (${damages.expression})&nbsp;: ${damages.result} – ${localisation[0]}`;
});

const criticalWidget = new Widget("widget-criticals", async function () {
    const data = new FormData(this.form);
    data.append("roll-3d", roll("3d").result);
    data.append("roll-1d", roll("1d").result);
    const critical = await fetchResult("/api/critical-tables", data);
    return critical;
});

const burstWidget = new Widget("widget-burst", async function () {
    const data = new FormData(this.form);
    const hitNumbers = await fetchResult("/api/burst-hits", data);

    const hits = [];
    const damagesExpression = this.form.expression.value;
    for (let i = 0; i < hitNumbers; i++) {
        const damages = roll(damagesExpression).result;
        const localisation = this.form.localisation.checked ? await getLocalisation() : "";
		const localisationString = localisation ? `– ${localisation[0]}` : ""
        hits.push(`${damages} pts ${localisationString}`);
    }

    // formatting answer
    let formattedMsg = `<b>Rafale&nbsp;:</b> Rcl ${this.form.rcl.value} – Balles ${this.form.bullets.value} – MR ${this.form.mr.value}`;
    hits.forEach((value, index) => {
        formattedMsg += `<br><b>${index + 1}.</b> ${value}`;
    });

    return formattedMsg;
});

const frightcheckWidget = new Widget("fright-check", async function () {
    const sfScore = int(this.form.querySelector(["[name=sf-score]"]).value);
    const sfModif = int(this.form.querySelector(["[name=sf-modif]"]).value);

    const data = new FormData(this.form);
    const frighcheck = scoreTester(sfScore + sfModif, roll("3d").result);
    const rolls = [];
    for (let i = 0; i <= 6; i++) rolls.push(roll("3d").result);

    data.append("frightcheck-MR", frighcheck.MR);
    data.append("frightcheck-symbol", frighcheck.symbol);
    data.append("frightcheck-critical", frighcheck.critical);
    data.append("rolls", rolls.join(","));

    const result = await fetchResult("/api/fright-check", data);
    return result;
});

const generalStateWidget = new Widget("general-health-state", async function () {
    const opponentIndex = this.form.querySelector("[name=opponent-selector]").value;
    const opponent = opponents.list[opponentIndex];

    if (!opponent || !opponent.pdvm) return null;

    const data = new FormData();
    data.append("san", opponent.san ?? null);
    data.append("pdvm", opponent.pdvm ?? null);
    data.append("pdv", opponent.pdv ?? opponent.pdvm);
    data.append("pain-resistance", opponent["painResistance"] ?? 0);
    data.append("members", opponent.members ?? null);

    const response = await fetchResult("/api/general-state", data);

    let formattedMsg = `État général de <b>${opponent.name}</b><br>${response.general}`;
    if (response.members !== undefined && !response["members-error"]) {
        for (const [member, state] of Object.entries(response.members)) formattedMsg += `<br>${member}&nbsp;: ${state.description}`;
    }
    if (response["members-error"]) formattedMsg += `<br>Membres&nbsp;: données incohérentes`;

    return formattedMsg;
});

const woundEffectsWidget = new Widget("wound-effect", async function () {
    const opponentIndex = this.form["opponent-selector"].value;
    const opponent = opponents.list[opponentIndex];
    const rawDmg = roll(this.form["raw-dmg"].value).result;
    const rolls = [];
    for (let i = 0; i < 7; i++) rolls.push(roll("3d").result);

    const data = new FormData(this.form);
    data.append("category", opponent.category ?? "std");
    data.append("dex", opponent.dex);
    data.append("san", opponent.san);
    data.append("pdvm", opponent.pdvm);
    data.append("pdv", opponent.pdv ?? opponent.pdvm);
    data.append("pain-resistance", opponent.painResistance);
    data.set("raw-dmg", rawDmg);
    data.append("rolls", rolls);

    const result = await fetchResult("/api/wound-effects", data);

    if (result.erreur) return "Données manquantes";

    let formattedMsg = `<b>${opponent.name} – ${result["dégâts bruts"]} ( ${result["type dégâts"]} ${result["localisation"]})</b>`;
    formattedMsg += `<br>Dégâts effectifs&nbsp;: ${result["dégâts effectifs"]}`;
    if (result["recul"]) formattedMsg += `<br>Recul de ${result["recul"]}&nbsp;m.`;
    if (result["mort"]) formattedMsg += `<br>${result["mort"]}`;
    const immediateDeath = result["mort"] && result["mort"].includes("😵");
    if (!immediateDeath) {
        if (result["autres effets"]) formattedMsg += `<br>${result["autres effets"]}`;
        if (result["sonné"] && !result["perte de conscience"]) formattedMsg += `<br>${result["sonné"]}`;
        if (result["perte de conscience"]) formattedMsg += `<br>Le personnage perd conscience.`;
        if (result["chute"] && !result["perte de conscience"]) formattedMsg += `<br>Le personnage chûte.`;
        if (result["dégâts membre"]) formattedMsg += `<br>${result["dégâts membre"]}`;
        if (result["état membre"] !== "") formattedMsg += ` (${result["état membre"]})`;
    }

    // update opponent pdv
    const pdvInput = qs(`[data-role="opponent-wrapper"][data-index="${opponentIndex}"]`).querySelector("[name=pdv]");
    pdvInput.value = result["pdv"];
    pdvInput.dispatchEvent(new Event("change", { bubbles: true }));

    return formattedMsg;
});

// unfreeze bullet type in woundEffectsWidget
const dmgTypeSelector = woundEffectsWidget.form["dmg-type"];
dmgTypeSelector.addEventListener("change", (e) => {
    const bulletTypeSelector = woundEffectsWidget.form["bullet-type"];
    if (["b0", "b1", "b2", "b3"].includes(dmgTypeSelector.value)) {
        bulletTypeSelector.disabled = false;
    } else {
        bulletTypeSelector.value = "std";
        bulletTypeSelector.disabled = true;
    }
});

const bleedingWidget = new Widget("bleeding-widget", async function () {
    const opponentIndex = this.form["opponent-selector"].value;
    const opponent = opponents.list[opponentIndex];
    if (!opponent.san || !opponent.pdvm) return "Données manquantes";

    const sanModif = int(this.form.modif.value);
    const severity = int(this.form.severity.value);
    const sanTest = scoreTester(opponent.san + sanModif, roll("3d").result);

    const data = new FormData();
    data.append("san-test", JSON.stringify(sanTest));
    data.append("pdvm", opponent.pdvm);
    data.append("severity", severity);

    const result = await fetchResult("/api/bleeding-effects", data);
    if (result.error) return "Données entrées incohérentes et/ou manquantes";

    let formattedMsg = `Hémorragie : PdV perdu(s) ${result["pdv-loss"]}`;
    if (result.comment) formattedMsg += `<br>${result.comment}`;

    // update opponent pdv
    const pdvInput = qs(`[data-role="opponent-wrapper"][data-index="${opponentIndex}"]`).querySelector("[name=pdv]");
    if (pdvInput.value === "") pdvInput.value = opponent.pdvm;
    pdvInput.value -= result["pdv-loss"];
    pdvInput.dispatchEvent(new Event("change", { bubbles: true }));

    return formattedMsg;
});

const explosionWidget = new Widget("explosion-widget", async function () {
    const dmgExpression = this.form["explosion-dmg"].value;

    // evaluate damages – compression around a mathematical expectation of 5 per dice
    const roll1 = roll(dmgExpression).result;
    const roll2 = roll(dmgExpression).result;
    const roll3 = roll(dmgExpression).result;
    const dmgValue = ((roll1 + roll2 + roll3) / 3) * 1.43;

    const data = new FormData(this.form);
    data.append("damages", dmgValue);
    console.log(data);

    const results = await fetchResult("/api/explosion-damages", data);
    const formattedMsg = `<b>Explosion :</b> dégâts ${results.damages} – fragment(s) ${results.fragments} – hauteur de chute ${results.height} m`;
    return formattedMsg;
});

const objectDamageWidget = new Widget("object-damages", async function () {
    const dmgValue = roll(this.form["dmg-code"].value).result;

    const data = new FormData(this.form);
    data.append("dmg-value", dmgValue);
    data.append("rolls", [roll("3d").result, roll("3d").result, roll("3d").result, roll("3d").result]);
    console.log(data);

    const results = await fetchResult("/api/object-damages-effects", data);
    console.log(results);
    this.form.pds.value = results.pds;

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
    return formattedMsg;
});

// modify localisation options according to object type
objectDamageWidget.form["object-type"].addEventListener("change", async (e) => {
    const data = new FormData();
    data.append("object-type", e.target.value);
    console.log(data);
    const options = await fetchResult("/api/object-localisation-options", data);
    objectDamageWidget.form["localisation"].innerHTML = "";
    options.forEach((localisation) => {
        localisation = localisation.charAt(0).toUpperCase() + localisation.slice(1);
        const option = ce("option");
        option.innerText = localisation;
        objectDamageWidget.form["localisation"].appendChild(option);
    });
});

const collisionWidget = new Widget("vehicle-collision", async function () {
    const pdsm = parseInt(this.form.pdsm.value);
    const severity = this.form.severity;
    const severityIndex = parseInt(severity.value);
    const severityLevel = severity.options[severity.selectedIndex].innerText;

    if (!pdsm) return;
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
    return formattedMsg;
});

const npcWidget = new Widget("npc-generator", async function () {
    const data = new FormData(this.form);

    const result = await fetchResult("/api/npc-generator", data);

    if (result.error) return `/${userID} Paramètres PNJ invalides`;

    if (result["name-only"]) return `/${userID} ${result.name}`;

    const facialHair = result.facialHair ? `${result.facialHair},` : "";
    const corpulence = result.corpulence !== "moyenne" ? `${result.corpulence}, ` : "";
    const size = result.size !== "moyenne" ? `${result.size}, ` : "";
    const beauty = result.beauty !== "moyenne" ? `${result.beauty}, ` : "";
    const intelligence = result.intelligence !== "moyenne" ? `${result.intelligence}, ` : "";
    const specialTraits = result.specialTraits ? `<br>Choisir une particularité parmi&nbsp;: <i>${result.specialTraits}</i>` : "";

    const formattedMsg = `/${userID}
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
    return formattedMsg;
});

// set and save NPC region
if (localStorage.getItem("npc-region") !== null) npcWidget.form.region.value = localStorage.getItem("npc-region");
npcWidget.form.region.addEventListener("change", () => {
    localStorage.setItem("npc-region", npcWidget.form.region.value);
});

const reactionWidget = new Widget("widget-reaction", async function () {
    const reactionModifier = int(this.form.modifier.value.trim("+"));
    const reactionTest = roll("1d").result + reactionModifier;
    const data = new FormData();
    data.append("reaction-test", reactionTest);
    const result = await fetchResult("/api/reaction-test", data);
    return `/${userID} Jet de réaction (${reactionTest}) → ${result}`;
});

const wildGeneratorWidget = new Widget("wild-generator", async function () {
    const data = new FormData(this.form);
    const result = await fetchResult("/api/wild-generator", data);
    return `/${userID} ${result}`;
});

// ––– Widgets config ––––––––––––––––––––––––––––––––––––––––––––––––––––––––
//localStorage.removeItem("display-widgets") // reset localStorage (for dev purpose)

const checkboxesWrapper = qs("[data-role=widget-choices]");
const checkboxTemplate = qs("[data-role=widget-choices] template");
const defaultDisplayedWidgets = {/*  "simple-roll": true, "scores-tester": true,  */"widget-damage-location": true, "widget-criticals": true };
const displayedWidgets = JSON.parse(localStorage.getItem("display-widgets")) || defaultDisplayedWidgets;

// build widgets choice dialog
const allWidgets = qsa("fieldset[data-name]");
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

// update displayed widgets and checkboxes according to stored state
function udpateDisplayedWidget() {
    allWidgets.forEach((widget) => (widget.hidden = !displayedWidgets[widget.dataset.name]));
}

udpateDisplayedWidget();
