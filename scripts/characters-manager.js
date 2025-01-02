import { qs, qsa, calculate } from "./utilities.js";
import { wsURL, Message } from "./ws-utilities.js";
import { updateDOM } from "./update-dom.js";

const sessionId = qs("#ws-data").dataset.sessionId;
const wsKey = qs("#ws-data").dataset.wsKey;
const groupWrappers = qsa("[data-group]");

// Web Socket character ping sender
const ws = new WebSocket(wsURL);
ws.onopen = () => {}; // nothing to do (yet)
ws.onmessage = (rawMessage) => {
    const message = JSON.parse(rawMessage.data);
    console.log(message);
    if (message.type === "character-ping") {
        fetch("gestionnaire-mj")
            .then((response) => response.text())
            .then((response) => {
                updateDOM(`#state-form-character-${message.content}`, response);
            });
		setTimeout(() => { getCharacterDetails(parseInt(message.content)) }, 200);
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
    group.addEventListener("click", (e) => {
        if (e.target.tagName === "SUMMARY") {
            const opening = !e.target.closest("details").hasAttribute("open");
            localStorage.setItem(`group-${group.dataset.group}`, opening);
        }
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
    //console.log(form_data)
    fetch("/submit/update-character-state", {
        method: "post",
        body: form_data,
    }).then(() => {
        fetch("/gestionnaire-mj")
            .then((response) => response.text())
            .then((response) => {
                updateDOM(`#${form_id}`, response);

                // ping character
                const ping = new Message(sessionId, wsKey, "character-ping", parseInt(form_data.get("id")));
                ws.send(ping.stringify());
            });
        //return response;
    });
}

// character forms events
const characterStateForms = qsa("[data-role=character-state-form]");
characterStateForms.forEach((form) => {
    // if form submitted manually (with "enter" key)
    form.addEventListener("submit", (e) => {
        e.preventDefault();
        submitCharacterForm(form);
    });

    let timeoutId;

    // submit form on keyup with delay : 🖐️ provoque 2 pings – un pour le keyup, un autre pour le change
    form.addEventListener("keyup", (e) => {
        if (timeoutId) clearTimeout(timeoutId);
        timeoutId = setTimeout(function () {
            submitCharacterForm(form);
        }, 3000);
    });

    // submit form on change
    form.addEventListener("change", (e) => {
        if (timeoutId) clearTimeout(timeoutId);
        submitCharacterForm(form);
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
        .then((response) => response.json())
        .then((response) => response.data)
        .then((data) => {
            //console.log(data);
            fillCharacterSummary(id, data);
        });
}

function fillCharacterSummary(id, data) {
    const card = qs("#state-form-character-" + id);
    const cardSummaryWrapper = card.querySelector("[data-role=character-summary]");
    const template = qs("#character-details");
    const clone = template.content.cloneNode(true);

    ["For", "Dex", "Int", "San", "Per", "Vol"].forEach((attr) => {
        fillValueInTemplate(clone, attr, data.attributes[attr]);
    });

	const ignoredAvdesav = []; // liste des AvDésav inutiles pou le MJ
	const avdesavCategories = ["Avantage", "Désavantage", "Travers", "Réputation"];
	avdesavCategories.forEach( category => {
		const filteredElements = data.avdesav.filter((elem) => elem.catégorie === category && !ignoredAvdesav.includes(elem.id));
		const displayedElement = [];
		filteredElements.forEach((elem) => displayedElement.push(`${elem.label} (${elem.points})`));
		fillValueInTemplate(clone, category, displayedElement.join(", "));
	})

    cardSummaryWrapper.appendChild(clone);
}

function fillValueInTemplate(template, label, value) {
    template.querySelector(`[data-content=${label}]`).innerHTML = value;
}
