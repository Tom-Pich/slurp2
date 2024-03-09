import { qs, qsa, ce, calculate } from "./utilities.js";
import morphdom from 'https://cdn.skypack.dev/morphdom';

const characterId = qs("#character-name").dataset.id;
const formEquipment = qs("#form-equipment");
const membersWrapper = qs("[data-role=members-wrapper]")
const itemInputs = formEquipment.querySelectorAll("input");
let newObjectNumber = 0;

// ––– Web Socket character ping sender –––
const wsServerURL = window.location.hostname === "site-jdr" ? "ws://127.0.0.1:1337" : "wss://web-chat.pichegru.net:443";
const wsTchatClient = new WebSocket(wsServerURL)
wsTchatClient.onopen = () => {
	const initMsg = { type: "character-registration", id: parseInt(characterId), key: "a78D_Kj!45" }
	wsTchatClient.send(JSON.stringify(initMsg))
}

wsTchatClient.onmessage = (rawMessage) => {
	const message = JSON.parse(rawMessage.data);
	updateCharacter(characterId)
}

// ––– functions ––––––––––––––––––––––––––––––––––––––

// ––– fetch the character sheet from server and update DOM with DOM diffing
function updateCharacter(id) {
	fetch("personnage-fiche?perso=" + id)
		.then(response => response.text())
		.then(response => {
			const parser = new DOMParser();
			const virtualDoc = parser.parseFromString(response, "text/html")
			const source = virtualDoc.querySelector("main")
			const target = qs("main")
			morphdom(target, source);
			containerOpenCloseStateManager()
		})
}


// ––– handling containers state (open or close)
function containerOpenCloseStateManager() {

	const containers = qsa("[data-role=container-wrapper]");

	containers.forEach(container => {
		if (localStorage.getItem(`container-${container.dataset.place}`) === "true") {
			container.setAttribute("open", true);
		}
		container.children[0].addEventListener("click", (e) => {
			const opening = !e.target.closest("details").hasAttribute("open");
			localStorage.setItem(`container-${container.dataset.place}`, opening);
		})
	})
}

// ––– submit character equipment
function submitEquipment() {
	// getting ordered inputs (FF bug ?) for list ordering
	let formData = new FormData();
	formEquipment.querySelectorAll("input").forEach(input => {
		if (input.type === 'checkbox') {
			formData.append(input.name, input.checked ? input.value : '');
		} else {
			formData.append(input.name, input.value)
		}
	})

	fetch("/submit/equipment-list", {
		method: 'post',
		body: formData
	})
		.then(() => {
			updateCharacter(characterId)
		})
}

// ––– event listeners –––––––––––––––––––––––––––––––––––––

// event listeners for moving container and adding item
formEquipment.addEventListener("click", (e) => {
	//e.preventDefault();
	const target = e.target

	if (target.dataset.role === "container-up") {
		const containerWrapper = target.closest("[data-role=container-wrapper]");
		const previousContainerWrapper = containerWrapper.previousElementSibling;
		if (previousContainerWrapper) {
			formEquipment.insertBefore(containerWrapper, previousContainerWrapper);
			submitEquipment();
		}
	}
	else if (target.dataset.role === "container-down") {
		const containerWrapper = target.closest("[data-role=container-wrapper]");
		const nextContainerWrapper = containerWrapper.nextElementSibling;
		if (nextContainerWrapper.dataset.role === "container-wrapper") {
			nextContainerWrapper.after(containerWrapper);
			submitEquipment();
		}
	}
	else if (target.dataset.role === "add-item") {
		newObjectNumber++;
		const containerWrapper = target.closest("[data-role=container-wrapper]");
		let itemWrapper = ce("details", ["items-list"])
		itemWrapper.innerHTML = `
			<summary class="grid gap-½ ai-center">
				<div class="ff-fas" draggable="true" data-role="item-grip">&#xf58e;</div>
				<input name="nouvel-objet[${newObjectNumber}][Nom]"	type="text" placeholder = "Nouvel objet" >
				<input name="nouvel-objet[${newObjectNumber}][Poids]" type="text" class="ta-center">
				<input hidden name="nouvel-objet[${newObjectNumber}][Lieu]" value="${containerWrapper.dataset.place}">
			</summary>
			<div class="italic ta-center mt-½">
				Enregistrer les modifications avant de pouvoir ajouter des notes
			</div>
		`
		containerWrapper.appendChild(itemWrapper);
	}

})

// event listeners for saving after input change
formEquipment.addEventListener("change", (e) => {
	const target = e.target
	if (target.tagName === "INPUT") {
		submitEquipment();
	}
})

// event listener for drag and drop (not used: drag, dragleave, drop)
let draggedItem = null;

formEquipment.addEventListener("dragover", (e) => {
	e.preventDefault();
})

formEquipment.addEventListener("dragstart", (e) => {
	if (e.target.dataset.role === "item-grip") {
		itemInputs.forEach(input => { input.disabled = true; })
		draggedItem = e.target.closest("[data-role=item-wrapper]");
	}
})

formEquipment.addEventListener("dragend", (e) => {
	if (e.target.dataset.role === "item-grip") {
		itemInputs.forEach(input => { input.disabled = false; })
		submitEquipment();
	}
})

formEquipment.addEventListener("dragenter", (e) => {
	if (e.target.dataset.role === "item-grip") {
		let container = e.target.closest("[data-role=container-wrapper]")
		let target = e.target.closest("[data-role=item-wrapper]")
		container.insertBefore(draggedItem, target)
		draggedItem.querySelector("[data-role=item-place]").value = container.dataset.place
	}
	else if (e.target.dataset.role === "free-slot") {
		let container = e.target.closest("[data-role=container-wrapper]")
		let target = e.target
		container.insertBefore(draggedItem, target)
		draggedItem.querySelector("[data-role=item-place]").value = container.dataset.place
	}
})

membersWrapper.addEventListener("dragover", (e) => {
	e.preventDefault();
})

membersWrapper.addEventListener("drop", (e) => {
	const target = e.target.closest("[data-role=item-transfer]")
	if (target) {
		const container = qs("#item-transfer");
		draggedItem.querySelector("[data-role=item-place]").value = target.dataset.place;
		container.append(draggedItem);

		// ping character after change
		setTimeout(() => {
			const characterTargetId = parseInt(target.dataset.place.substr(3));
			const pingMsg = { type: "character-ping", id: characterTargetId, key: "a78D_Kj!45" };
			wsTchatClient.send(JSON.stringify(pingMsg));
		}, 500)
	}
})

// event listener for submitting form (still necessary if "Enter" is pressed)
formEquipment.addEventListener("submit", (e) => {
	e.preventDefault();
	submitEquipment();
})

// get weapon damage on hover
const itemNotes = qsa("[data-role=item-notes]")
itemNotes.forEach(note => {
	note.addEventListener("mouseover", (e) => {
		if (e.target.value !== "") {
			let data = new FormData();
			data.append("for", qs("#for-deg").innerText);
			data.append("notes", e.target.value);
			fetch("/api/weapon-damages", {
				method: 'post',
				body: data
			})
				.then(response => response.json())
				.then(response => e.target.title = response.data.damages)
		}
	})
})

// ––– other stuff ––––––––––––––––––––––––––––––––––
// apply container state
containerOpenCloseStateManager()

// pdm counter
const pdmInput = qs("[name=pdm_counter]")
if (pdmInput) {

	let pdm_value = null

	pdmInput.addEventListener("blur", (e) => {
		try {
			pdm_value = pdmInput.value === "" ? "" : calculate(pdmInput.value)
			let data = new FormData;
			data.append("id", characterId);
			data.append("pdm", pdm_value)
			data.append("max", pdmInput.dataset.pdmMax)
			if (pdm_value < 0) { alert("Vous ne pouvez pas dépenser autant de PdM !") }
			else {
				fetch("/submit/update-character-pdm", {
					method: 'post',
					body: data
				})
					.then(response => response.text())
					.then(response => updatePdmMeter(response))
			}
		} catch (error) {
			alert("Expression invalide")
		}
	})
}

function updatePdmMeter(pdm) {
	const meter = qs("meter[name=PdM]");
	meter.value = pdm;
	meter.title = pdm;
}


