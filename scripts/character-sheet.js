import { qs, qsa, ce } from "./lib/dom-utils.js";
import { calculate, int, trimModifier, explicitSign } from "./utilities.js";
import { wsURL, Message } from "./ws-utilities.js";
import { updateDOM } from "./update-dom.js";
import { roll, scoreTester } from "./game-table-utilities.js";
import { showAlert } from "./lib/alert.js";

const sessionId = qs("#ws-data").dataset.sessionId;
const wsKey = qs("#ws-data").dataset.wsKey;

const characterId = parseInt(qs("#character-name").dataset.id);
const gmId = parseInt(qs("#character-name").dataset.gm);
const formEquipment = qs("#form-equipment");
const membersWrapper = qs("[data-role=members-wrapper]"); // group members
let newObjectNumber = 0;

// ––– Web Socket character ping sender –––
const ws = new WebSocket(wsURL);
ws.onopen = () => {}; // nothing to do

ws.onmessage = (rawMessage) => {
    const message = JSON.parse(rawMessage.data);
    if (message.type === "character-ping" && [0, characterId].includes(message.content)) {
        refreshCharacterIfIdle();
    }
};

// on page load update sheet state
containerOpenCloseStateManager();
fillPdMCount();

// reload character on style change
const channel = new BroadcastChannel("display-options");
channel.onmessage = (event) => {
    if (event.data.option === "style") refreshCharacterIfIdle();
};

// ––– déclenche la mise à jour du personnage si c’est possible
function refreshCharacterIfIdle() {
    if (dirty || saving) return;
    updateCharacter(characterId);
}

// ––– Mise à jour de la fiche de personnage
function updateCharacter(id) {
    fetch("personnage-fiche?perso=" + id)
        .then((response) => response.text())
        .then((response) => {
            updateDOM("main", response)
                .then(() => showAlert("Personnage mis à jour !", "valid"))
                .then(() => fillPdMCount());
        });
}

// ––– Gestion de l’équipement ––––––––––––––––––––––––––––––––––––––

// ––– handling containers state (open or close)
function containerOpenCloseStateManager() {
    const containers = qsa("[data-role=container-wrapper]");

    containers.forEach((container) => {
        if (localStorage.getItem(`container-${container.dataset.place}`) === "true") {
            container.setAttribute("open", true);
        }
        container.children[0].addEventListener("click", (e) => {
            const opening = !e.target.closest("details").hasAttribute("open");
            localStorage.setItem(`container-${container.dataset.place}`, opening);
        });
    });
}

// ––– Sauvegarde de la liste du matériel

// ––– État de la sauvegarde
const SAVE_DELAY = 5000; // text edits
const QUICK_SAVE_DELAY = 1000; // discrete actions (move, checkbox)
const equipmentStatus = qs("#equipment-status");
const transferTargets = new Set(); // les personnages recevant un objet par drag and drop
let dirty = false; // modifications locales pas encore envoyées
let saving = false; // requête d’envoi en cours
let pingAllPending = false; // prevenir tous les personnages après la prochaine sauvegarde
let saveTimer; // le timer de sauvegarde
let hoveredPortrait = null; // portrait actuellement surligné

// gère l’affichage du statut de la sauvegarde
function setStatus(state) {
    // "dirty" | "saving" | null
    equipmentStatus.hidden = state === null;
    equipmentStatus.dataset.state = state ?? "";
    equipmentStatus.querySelector("[data-role=status-label]").textContent = state === "saving" ? "Saving…" : "● Modifs…";
}

// marque en dirty, commande affichage status, annule le delay et en réarme un nouveau
function markDirty(delay = SAVE_DELAY, pingAll = false) {
    dirty = true;
    pingAllPending ||= pingAll; // the flag must survive until the delayed save
    if (!saving) setStatus("dirty");
    clearTimeout(saveTimer);
    saveTimer = setTimeout(flushEquipment, delay);
}

// gère l’envoi de l’équipement via sendEquipment et tout les à-côtés
async function flushEquipment({ keepalive = false } = {}) {
    clearTimeout(saveTimer);
    if (!dirty) return; // rien à envoyer
    if (saving) {
        // envoi déjà en cours
        saveTimer = setTimeout(() => flushEquipment({ keepalive }), 300);
        return;
    }
    saving = true;
    dirty = false; // edits made during the request will set it again
    const pingAll = pingAllPending;
    const targets = [...transferTargets];
    pingAllPending = false;
    transferTargets.clear();
    setStatus("saving");

    try {
        await sendEquipment({ keepalive });
        const recipients = pingAll ? [0] : [characterId, ...targets];
        if (!keepalive) {
            recipients.forEach((id) => ws.send(new Message(sessionId, wsKey, "character-ping", id).stringify()));
        }
    } catch (error) {
        dirty = true;
        pingAllPending ||= pingAll;
        targets.forEach((id) => transferTargets.add(id));
        showAlert("Échec de l’enregistrement, nouvel essai…", "invalid"); // adapte le type à lib/alert.js
        saveTimer = setTimeout(flushEquipment, SAVE_DELAY);
    } finally {
        saving = false;
        setStatus(dirty ? "dirty" : null);
    }
}

// envoie les données au serveur (voir Equipment::processEquipmentSubmit)
async function sendEquipment({ keepalive = false } = {}) {
    const { formData, newRows } = buildEquipmentFormData();
    const response = await fetch("/submit/equipment-list", { method: "post", body: formData, keepalive });
    if (!response.ok) throw new Error("equipment save failed");
    newRows.forEach((row) => (row.dataset.sent = "1"));
}

// ––– getting ordered inputs for list ordering
function buildEquipmentFormData() {
    const formData = new FormData();
    const newRows = new Set();
    formEquipment.querySelectorAll("input").forEach((input) => {
        if (input.name.startsWith("nouvel-objet")) {
            const row = input.closest("details");
            if (!isNewRowSendable(row)) return;
            newRows.add(row);
        }
        formData.append(input.name, input.type === "checkbox" ? (input.checked ? input.value : "") : input.value);
    });
    return { formData, newRows };
}

// ––– vérifie si le nouvel objet n’a pas déjà été envoyé et s’il a un nom
function isNewRowSendable(row) {
    return !row.dataset.sent && row.querySelector("[name$='[Nom]']").value.trim() !== "";
}

// ––– event listeners –––––––––––––––––––––––––––––––––––––

// event listeners for moving container and adding item
formEquipment.addEventListener("click", (e) => {
    //e.preventDefault();
    const target = e.target;

    if (target.dataset.role === "container-up") {
        const containerWrapper = target.closest("[data-role=container-wrapper]");
        const previousContainerWrapper = containerWrapper.previousElementSibling;
        if (previousContainerWrapper) {
            formEquipment.insertBefore(containerWrapper, previousContainerWrapper);
            markDirty(QUICK_SAVE_DELAY);
        }
    } else if (target.dataset.role === "container-down") {
        const containerWrapper = target.closest("[data-role=container-wrapper]");
        const nextContainerWrapper = containerWrapper.nextElementSibling;
        if (nextContainerWrapper.dataset.role === "container-wrapper") {
            nextContainerWrapper.after(containerWrapper);
            markDirty(QUICK_SAVE_DELAY);
        }
    } else if (target.dataset.role === "add-item") {
        newObjectNumber++;
        const containerWrapper = target.closest("[data-role=container-wrapper]");
        const freeSlot = containerWrapper.querySelector("[data-role=free-slot]");
        const itemWrapper = ce("details", ["items-list"]);
        itemWrapper.dataset.role = "item-wrapper";
        itemWrapper.innerHTML = `
			<summary class="grid gap-½ ai-center">
				<div class="ff-fas" draggable="true" data-role="item-grip">&#xf58e;</div>
				<input name="nouvel-objet[${newObjectNumber}][Nom]"	type="text" placeholder = "Nouvel objet">
				<input name="nouvel-objet[${newObjectNumber}][Poids]" type="text" class="ta-center">
				<input hidden name="nouvel-objet[${newObjectNumber}][Lieu]" value="${containerWrapper.dataset.place}" data-role="item-place">
				<input hidden name="nouvel-objet[${newObjectNumber}][MJ]" value="${gmId}">
			</summary>
			<div class="italic ta-center mt-½">
				Enregistrer les modifications avant de pouvoir ajouter des notes
			</div>
		`;
        //containerWrapper.appendChild(itemWrapper);
        containerWrapper.insertBefore(itemWrapper, freeSlot);
    }
});

// event listener sur l’entrée de texte
formEquipment.addEventListener("input", (e) => {
    if (e.target.type === "checkbox") return;
    markDirty(SAVE_DELAY);
});

// event listener sur une case à cocher
formEquipment.addEventListener("change", (e) => {
    if (e.target.type !== "checkbox") return; // text is already handled by "input"
    markDirty(QUICK_SAVE_DELAY, e.target.dataset.pingAll !== undefined);
});

// gestion du drag & drop
let draggedItem = null;
const placeholder = ce("div", ["drag-placeholder"]); // utilisé à chaque drag
let openContainerTimer; // delay before opening a container wrapper
let moved = false; // un drop valide a eu lieu (lu par dragend)

// place le placeholder dans parent, avant reference (null = en dernier)
function placeAt(parent, reference) {
    if (placeholder.parentElement === parent && placeholder.nextElementSibling === reference) return;
    parent.insertBefore(placeholder, reference);
}

// true si déposer item dans container créerait une boucle
function wouldCreateCycle(item, container) {
    const ownPlace = `ct_${item.id.replace("item-", "")}`; // le lieu que cet objet crée s’il est un contenant
    let place = container.dataset.place;
    while (place?.startsWith("ct_")) {
        if (place === ownPlace) return true;
        const holder = qs(`#item-${place.slice(3)}`); // l’objet-contenant qui correspond à ce lieu
        place = holder?.closest("[data-role=container-wrapper]")?.dataset.place;
    }
    return false; // on est remonté à pi_xx / pe_xx (ou plus rien) : pas de boucle
}

// surligne portrait (ou rien si null) et retire la surbrillance de l’ancien
function highlightPortrait(portrait) {
    if (portrait === hoveredPortrait) return;
    hoveredPortrait?.classList.remove("drop-target");
    portrait?.classList.add("drop-target");
    hoveredPortrait = portrait;
}

formEquipment.addEventListener("dragstart", (e) => {
    if (e.target.dataset.role !== "item-grip") return;

    draggedItem = e.target.closest("[data-role=item-wrapper]");

    e.dataTransfer.setData("text/plain", ""); // requis par Firefox pour amorcer le drag
    e.dataTransfer.effectAllowed = "move";

    // l’image fantôme est toute la ligne, pas seulement l’icône
    const summary = draggedItem.querySelector("summary");
    const rect = summary.getBoundingClientRect();
    e.dataTransfer.setDragImage(summary, e.clientX - rect.left, e.clientY - rect.top);
    placeholder.style.height = `${rect.height}px`;

    // différé : si on masque tout de suite, le navigateur capture une image fantôme vide
    requestAnimationFrame(() => (draggedItem.hidden = true));
});

formEquipment.addEventListener("dragover", (e) => {
    if (!draggedItem) return;
    e.preventDefault();
    e.dataTransfer.dropEffect = "move";

    const itemWrapper = e.target.closest("[data-role=item-wrapper]");
    const freeSlot = e.target.closest("[data-role=free-slot]");

    if (itemWrapper && itemWrapper !== draggedItem) {
        // moitié haute : avant l’objet ; moitié basse : après
        const rect = itemWrapper.querySelector("summary").getBoundingClientRect();
        const before = e.clientY < rect.top + rect.height / 2;
        const reference = before ? itemWrapper : itemWrapper.nextElementSibling;
        placeAt(itemWrapper.parentElement, reference);
    } else if (freeSlot) {
        placeAt(freeSlot.parentElement, freeSlot);
    }
});

formEquipment.addEventListener("drop", (e) => {
    if (!draggedItem || !placeholder.parentElement) return;
    e.preventDefault();

    const container = placeholder.closest("[data-role=container-wrapper]");
    if (!container || wouldCreateCycle(draggedItem, container)) return;

    placeholder.replaceWith(draggedItem); // l’objet prend la place exacte du placeholder
    draggedItem.querySelector("[data-role=item-place]").value = container.dataset.place;
    moved = true;
});

formEquipment.addEventListener("dragend", () => {
    if (!draggedItem) return;
    highlightPortrait(null);

    clearTimeout(openContainerTimer);
    placeholder.remove();
    draggedItem.hidden = !!draggedItem.closest("#item-transfer"); // un objet transféré reste masqué
    draggedItem = null;

    if (moved) {
        moved = false;
        markDirty(QUICK_SAVE_DELAY);
    }
});

formEquipment.addEventListener("dragenter", (e) => {
    if (!draggedItem) return;
    clearTimeout(openContainerTimer);

    const title = e.target.closest("[data-role=container-title-wrapper]");
    if (!title) return;
    openContainerTimer = setTimeout(() => {
        title.closest("[data-role=container-wrapper]").open = true;
    }, 500);
});

membersWrapper.addEventListener("dragover", (e) => {
    if (!draggedItem) return;
    const portrait = e.target.closest("[data-role=item-transfer]");
    highlightPortrait(portrait);
    if (!portrait) return; // pas de preventDefault : le drop est refusé, le curseur l’indique
    e.preventDefault();
    e.dataTransfer.dropEffect = "move";
});

membersWrapper.addEventListener("dragleave", (e) => {
    if (!membersWrapper.contains(e.relatedTarget)) highlightPortrait(null); // on sort vraiment de la zone
});

membersWrapper.addEventListener("drop", (e) => {
    if (!draggedItem) return;
    highlightPortrait(null);
    const target = e.target.closest("[data-role=item-transfer]");
    if (!target) return;

    draggedItem.querySelector("[data-role=item-place]").value = target.dataset.place;
    qs("#item-transfer").append(draggedItem);
    transferTargets.add(parseInt(target.dataset.place.substr(3))); // pour pinger le destinataire
    moved = true;
});

// event listener for submitting form (still necessary if "Enter" is pressed)
formEquipment.addEventListener("submit", (e) => {
    e.preventDefault();
    flushEquipment();
});

equipmentStatus.querySelector("[data-role=save-equipment]").addEventListener("click", () => flushEquipment());

document.addEventListener("keydown", (e) => {
    if ((e.ctrlKey || e.metaKey) && e.key === "s") {
        e.preventDefault();
        flushEquipment();
    }
});

// leaving the page or hiding the tab: last chance to save
document.addEventListener("visibilitychange", () => {
    if (document.visibilityState === "hidden" && dirty) flushEquipment({ keepalive: true });
});

// get weapon damage on hover
const itemNotes = qsa("[data-role=item-notes]");
itemNotes.forEach((note) => {
    note.addEventListener("mouseover", (e) => {
        if (e.target.value !== "") {
            let data = new FormData();
            data.append("for", qs("#for-deg").innerText);
            data.append("notes", e.target.value);
            fetch("/api/weapon-damages", {
                method: "post",
                body: data,
            })
                .then((response) => response.json())
                .then((response) => (e.target.title = response.data.damages));
        }
    });
});

// ––– Gestion des PdM ––––––––––––––––––––––––––––––––––

// ––– filling PdM count
function fillPdMCount() {
    const pdmInput = qs("[name=pdm_counter]");

    if (pdmInput) {
        const PdMCount = localStorage.getItem(`pdm-count-${characterId}`); // should be a string with a serie of operations (+2-4-2...)
        const PdMmax = parseInt(pdmInput.dataset.pdmMax);
        const calculatedResult = PdMmax + int(calculate(PdMCount));
        const PdM = parseInt(pdmInput.dataset.pdmCurrent);

        if (calculatedResult === PdM) {
            pdmInput.value = PdMCount;
        } else if (PdM === PdMmax) {
            pdmInput.value = "";
        } else {
            pdmInput.value = PdM - PdMmax;
        }
    }
}

// ––– submit PdM change
function submitPdMChange() {
    const PdMmax = parseInt(pdmInput.dataset.pdmMax);
    const inputExpression = pdmInput.value;
    const inputEvaluation = calculate(pdmInput.value);

    // check if entered value is valid, if not valid → empty value
    const pdmInputIsValid = ["+", "-"].includes(inputExpression.charAt(0)) || inputExpression === "" || inputEvaluation !== "";
    if (pdmInputIsValid) {
        localStorage.setItem(`pdm-count-${characterId}`, inputExpression);
    } else {
        localStorage.setItem(`pdm-count-${characterId}`, "");
    }

    // evaluating current PdM value
    let pdm_value;
    if (inputExpression === "") {
        pdm_value = "";
    } // empty value will erase PdM value in DB
    else {
        pdm_value = PdMmax + int(inputEvaluation);
    } // if invalid expression, PdM = PdM max

    // submiting form
    let data = new FormData();
    data.append("id", characterId);
    data.append("pdm", pdm_value);
    data.append("max", PdMmax);
    if (pdm_value < 0) {
        alert("Vous ne pouvez pas dépenser autant de PdM !");
    } else {
        fetch("/submit/update-character-pdm", {
            method: "post",
            body: data,
        })
            .then((response) => response.text())
            .then(() => {
                const ping = new Message(sessionId, wsKey, "character-ping", characterId);
                ws.send(ping.stringify()); // ping will reload character
            });
    }
}

// ––– pdm counter save
const pdmInput = qs("[name=pdm_counter]");
if (pdmInput) {
    let savePdMTimer;
    pdmInput.addEventListener("keyup", (e) => {
        if (savePdMTimer) clearTimeout(savePdMTimer);
        savePdMTimer = setTimeout(() => submitPdMChange(), 1000);
    });
}

// ––– Faire un jet de compétence ou de caractéristique –––––––––––––––––––––––––––––
const throwableItems = qsa("[data-type=throwable-wrapper]");
const testDialog = qs("dialog[data-type=character-sheet-roll]");
const testDialogBtn = testDialog.querySelector("[data-type=send-test]");
const testDialogModifierInput = testDialog.querySelector("[data-type=test-modifier-value]");
const testDialogLabel = testDialog.querySelector("[data-content=label]");
const testDialogScore = testDialog.querySelector("[data-content=score]");
const testDialogSecretCheckbox = testDialog.querySelector("[data-type=secret-test-checkbox]");

throwableItems.forEach((item) => {
    item.addEventListener("click", (e) => {
        const isThrowableInSummary = item.tagName === "SUMMARY";

        // click on label in summary → only open details, don’t roll
        if (isThrowableInSummary && e.target.dataset.type === "throwable-label") return;

        e.preventDefault();

        testDialog.showModal();
        testDialogModifierInput.focus();
        testDialogModifierInput.value = ""; // reset modifier value

        const label = trimModifier(item.querySelector("[data-type=throwable-label]").innerText);
        const score = item.querySelector("[data-type=throwable-score]").innerText;
        testDialogLabel.innerText = label;
        testDialogScore.value = score;
        testDialogSecretCheckbox.checked = item.dataset.secret === "true";
    });
});

testDialogBtn.addEventListener("click", (e) => {
    const modifier = int(testDialogModifierInput.value);
    const readableModif = modifier === 0 ? "" : explicitSign(modifier);
    const effectiveScore = Number(testDialogScore.value);
    const rollResult = roll("3d").result;
    const outcome = scoreTester(effectiveScore + modifier, rollResult);
    const messageContent = `${testDialogLabel.innerText} (${effectiveScore}${readableModif}) → ${rollResult} (MR ${outcome.MR} ${outcome.symbol})`;
    const isSecretTest = testDialog.querySelector("[data-type=secret-test-checkbox]").checked;
    const recipients = isSecretTest ? [gmId] : [];
    if (Number.isInteger(effectiveScore)) {
        const message = new Message(sessionId, wsKey, "chat-roll", messageContent, recipients, outcome.symbol);
        ws.send(message.stringify());
        testDialog.close();
    }
});

testDialog.addEventListener("keydown", (e) => {
    if (e.keyCode === 13) {
        e.preventDefault();
        testDialogBtn.click();
    }
});
