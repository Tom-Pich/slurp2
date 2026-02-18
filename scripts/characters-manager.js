import { qs, qsa } from "./lib/dom-utils.js";
import { calculate, int } from "./utilities.js";
import { wsURL, Message } from "./ws-utilities.js";
import { updateDOM } from "./update-dom.js";
import { fetchResult } from "./game-table-utilities.js";
import { showSpinningWheel } from "./main-utilities.js";

const sessionId = qs("#ws-data").dataset.sessionId;
const wsKey = qs("#ws-data").dataset.wsKey;
const groupWrappers = qsa("[data-group]");

// Web Socket character ping sender
const ws = new WebSocket(wsURL);
ws.onopen = () => {}; // nothing to do (yet)
ws.onmessage = (rawMessage) => {
    const message = JSON.parse(rawMessage.data);
    //console.log(message);
    if (message.type === "character-ping") {
        fetch("gestionnaire-mj")
            .then((response) => response.text())
            .then((response) => {
                updateDOM(`#state-form-character-${message.content}`, response).then(() => getCharacterDetails(parseInt(message.content)));
            });
    }
};

// calulate pdx cells content
const pdxCells = qsa("[data-role=pdx-cell]");
pdxCells.forEach((cell) => {
    cell.addEventListener("blur", (e) => {
        if (e.target.value) {
            const result = calculate(e.target.value);
            cell.value = result;
        }
    });
});

// export button events
const exportBtns = qsa("[data-role=export-character]");
exportBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
        const characterId = e.target.dataset.id;
        let data = new FormData();
        data.append("id", characterId);
        fetch("/submit/export-character", {
            method: "post",
            body: data,
        })
            .then((response) => response.text())
            .then((response) => {
                const responseWrapper = qs(`#confirm-export-${characterId}`);
                responseWrapper.innerText = response;
            });
    });
});

// remember group state (open/close)
groupWrappers.forEach((group) => {
    if (localStorage.getItem(`group-${group.dataset.group}`) === "true") {
        group.setAttribute("open", true);
    }
    group.addEventListener("toggle", (e) => {
        const opening = e.target.hasAttribute("open");
        localStorage.setItem(`group-${group.dataset.group}`, opening);
    });
});

// submit character form and update
function submitCharacterForm(form) {
    const pdxCells = form.querySelectorAll("[data-role=pdx-cell]");
    pdxCells.forEach((cell) => {
        cell.value = calculate(cell.value);
    });
    let form_id = form.getAttribute("id"); // don’t use form.id because of one input which name is id
    const form_data = new FormData(form);
    fetch("/submit/update-character-state", {
        method: "post",
        body: form_data,
    }).then(() => {
        const ping = new Message(sessionId, wsKey, "character-ping", parseInt(form_data.get("id")));
        ws.send(ping.stringify());
    });
}

// character forms events
const characterStateForms = qsa("[data-role=character-state-form]");
characterStateForms.forEach((form) => {
    const saveBtn = form.querySelector("[data-role=save-character]");
    let allowSaveBtnColorChange = true;

    // if form submitted manually (with "enter" key)
    form.addEventListener("submit", (e) => {
        e.preventDefault();
        submitCharacterForm(form);
    });

    // submit form with save-character btn
    saveBtn.addEventListener("click", (e) => {
        e.preventDefault();
        submitCharacterForm(form);
    });

    // highlight save btn on change
    form.addEventListener("change", () => {
        if (allowSaveBtnColorChange) saveBtn.classList.add("clr-invalid");
        allowSaveBtnColorChange = true;
    });

    form.addEventListener("keydown", (e) => {
        if (e.ctrlKey && e.key === "s") {
            e.preventDefault();
            submitCharacterForm(form);
            allowSaveBtnColorChange = false;
        }
    });

    // click listener on element with details callable in dialog
    form.addEventListener("click", async (e) => {
        const target = e.target;
        if (target.hasAttribute("data-details")) {
            const id = int(target.dataset.id);
            const detailsDialog = qs("[data-name=details]");
            if (target.dataset.type === "avdesav" || (target.dataset.type === "power" && target.dataset.origin === "avantage")) {
                const avdesav = await fetchResult("/api/get-avdesav?id=" + id);
                detailsDialog.querySelector("h4").innerText = `${avdesav.name} (${avdesav.displayCost})`;
                detailsDialog.querySelector("div").innerHTML = avdesav.description;
            }
            if (target.dataset.type === "power" && target.dataset.origin === "sort") {
                const spell = await fetchResult("/api/get-spell?id=" + id);
                detailsDialog.querySelector("h4").innerText = `${spell.name} (${spell.readableNiv})`;
                detailsDialog.querySelector("div").innerHTML = spell.fullDescription;
            }
            detailsDialog.showModal();
            document.activeElement.blur();
        }
    });
});

// submit items form and update
const itemsForm = qs("#items-form");
itemsForm.addEventListener("submit", (e) => {
    e.preventDefault();
    fetch("/submit/equipment-list", {
        method: "post",
        body: new FormData(itemsForm),
    }).then(() => {
        fetch("/gestionnaire-mj")
            .then((response) => response.text())
            .then((response) => {
                updateDOM("#items-form", response);
            });
    });
});

// load character details on group open
groupWrappers.forEach((wrapper) => {
    wrapper.addEventListener("toggle", (e) => {
        if (!wrapper.open) return;
        const characterCards = wrapper.querySelectorAll("[data-role=character-state-form]");
        characterCards.forEach((card) => {
            const characterStatus = card.querySelector("[name=Statut]").value;
            const characterId = parseInt(card.querySelector("[name=id]").value);
            if (["Création", "Actif"].includes(characterStatus)) getCharacterDetails(characterId);
        });
    });
});

function getCharacterDetails(id) {
    const data = new FormData();
    data.append("id", id);
    fetch("/api/get-character", {
        method: "post",
        body: data,
    })
        //.then((response) => response.text())
        //.then(response => console.log(response))
        .then((response) => response.json())
        .then((response) => response.data)
        .then((data) => {
            fillCharacterSummary(id, data);
        });
}

function fillCharacterSummary(id, data) {
    const card = qs("#state-form-character-" + id);
    const cardSummaryWrapper = card.querySelector("[data-role=character-summary]");
    const template = qs("#character-details");
    const clone = template.content.cloneNode(true);

    // Description
    fillValueInTemplate(clone, "Description", data.description);

    // Caractéristiques
    ["For", "Dex", "Int", "San", "Per", "Vol", "Réflexes", "Sang-Froid", "Vitesse"].forEach((attr) => {
        fillValueInTemplate(clone, attr, data.attributes[attr]);
    });

    // PdXm
    ["PdVm", "PdFm", "PdMm", "PdEm"].forEach((PdX) => {
        fillValueInTemplate(clone, PdX, data.pdxm[PdX]);
    });

    // Dégâts
    fillValueInTemplate(clone, "Dégâts", data.attributes["Dégâts"].estoc + "/" + data.attributes["Dégâts"].taille);

    // Avantages & Désavantages
    const ignoredAvdesav = []; // liste des AvDésav inutiles pour le MJ
    const avdesavCategories = ["Avantage", "Désavantage", "Travers", "Réputation"];
    avdesavCategories.forEach((category) => {
        const filteredElements = data.avdesav.filter((elem) => elem.catégorie === category && !ignoredAvdesav.includes(elem.id));
        const displayedElements = [];
        filteredElements.forEach((elem) => {
            let displayedElement;
            if (elem.description) displayedElement = `<span data-details data-type="avdesav" data-id="${elem.id}">${elem.nom} (${elem.points})</span>`;
            else displayedElement = `${elem.nom} (${elem.points})`;
            displayedElements.push(displayedElement);
        });
        fillValueInTemplate(clone, category, displayedElements.join(", "));
    });

    const colleges = data.colleges.map((college) => `${college.name}–${college.score}`);
    const displayedColleges = colleges.length ? `<b>Collèges&nbsp;:</b> ${colleges.join(", ")}` : "";
    fillValueInTemplate(clone, "Collèges", displayedColleges);

    const powers = data.powers.map((power) => `<span data-details data-type="power" data-id="${power.data.data.id}" data-origin="${power.data.specific.Type || power.data.origin}" >${power.label}</span>`);
    const displayedPowers = powers.length ? `<b>Pouvoirs&nbsp;:</b> ${powers.join(", ")}` : "";
    fillValueInTemplate(clone, "Pouvoirs", displayedPowers);

    fillValueInTemplate(clone, "Encombrement", `${data.state.Encombrement.name} (${data.carried_weight}&nbsp;kg)`);

    const equipment = data.equipment[0].liste;
    const displayedEquipment = equipment.map((item) => `<span title="${item.notes} – ${item.secret}">${item.name}</span>`);
    fillValueInTemplate(clone, "Équipement", displayedEquipment.join(", "));

    cardSummaryWrapper.innerHTML = "";
    cardSummaryWrapper.appendChild(clone);
}

function fillValueInTemplate(template, label, value) {
    if (value === "") template.querySelector(`[data-content=${label}]`).remove();
    else template.querySelector(`[data-content=${label}]`).innerHTML = value;
}

// prevent kits incompatibility
const characterCreationForm = qs("[data-role=character-creation-form]");
characterCreationForm.addEventListener("change", (e) => {
    if (e.target.name === "kit_ange" && e.target.checked) characterCreationForm.kit_demon.checked = false;
    if (e.target.name === "kit_demon" && e.target.checked) characterCreationForm.kit_ange.checked = false;
});
characterCreationForm.addEventListener("submit", (e) => {
    showSpinningWheel(e.target);
});
