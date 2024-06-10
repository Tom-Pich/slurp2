import { qs, qsa, ce, calculate, int } from "./utilities.js";
import { wsURL, Message } from "./ws-utilities.js";
import { updateDOM } from "./update-dom.js";

const sessionId = qs("#ws-data").dataset.sessionId;
const wsKey = qs("#ws-data").dataset.wsKey;

const characterId = parseInt(qs("#character-name").dataset.id);
const formEquipment = qs("#form-equipment");
const membersWrapper = qs("[data-role=members-wrapper]")
const itemInputs = formEquipment.querySelectorAll("input");
let newObjectNumber = 0;

// ––– Web Socket character ping sender –––
const ws = new WebSocket(wsURL)
ws.onopen = () => { } // nothing to do

ws.onmessage = (rawMessage) => {
	const message = JSON.parse(rawMessage.data);
	console.log(message)
	if (message.type === "character-ping" && [0, characterId].includes(message.content)) {
		updateCharacter(characterId)
	}
}

// on page load update sheet state
containerOpenCloseStateManager();
fillPdMCount();

// ––– functions ––––––––––––––––––––––––––––––––––––––

// ––– fetch the character sheet from server and update DOM with morphdom
function updateCharacter(id) {
	fetch("personnage-fiche?perso=" + id)
		.then(response => response.text())
		.then(response => {
			updateDOM("main", response);
			containerOpenCloseStateManager()
			fillPdMCount()
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

// ––– filling PdM count
function fillPdMCount() {
	const pdmInput = qs("[name=pdm_counter]")

	if (pdmInput) {
		const PdMCount = localStorage.getItem("pdm-count"); // should be a string with a serie of operations (+2-4-2...)
		const PdMmax = parseInt(pdmInput.dataset.pdmMax);
		const calculatedResult = PdMmax + int(calculate(PdMCount));
		const PdM = parseInt(pdmInput.dataset.pdmCurrent);

		if (calculatedResult === PdM) {
			pdmInput.value = PdMCount;
		} else if (PdM === PdMmax) {
			pdmInput.value = ""
		} else {
			pdmInput.value = PdM - PdMmax;
		}
	}
}

// ––– submit character equipment and send a character ping
function submitEquipment(pingAllCharacter = false) {
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
			const ping = new Message(sessionId, wsKey, "character-ping", pingAllCharacter ? 0 : characterId);
			ws.send(ping.stringify());
		})
}

// ––– submit PdM change
function submitPdMChange() {

	const PdMmax = parseInt(pdmInput.dataset.pdmMax);
	const inputExpression = pdmInput.value;
	const inputEvaluation = calculate(pdmInput.value);

	// check if entered value is valid, if not valid → empty value
	const pdmInputIsValid = ["+", "-"].includes(inputExpression.charAt(0)) || inputExpression === "" || inputEvaluation !== ""
	if (pdmInputIsValid) { localStorage.setItem("pdm-count", inputExpression) }
	else { localStorage.setItem("pdm-count", "") }

	// evaluating current PdM value
	let pdm_value
	if (inputExpression === "") { pdm_value = "" } // empty value will erase PdM value in DB
	else { pdm_value = PdMmax + int(inputEvaluation); } // if invalid expression, PdM = PdM max

	// submiting form
	let data = new FormData;
	data.append("id", characterId);
	data.append("pdm", pdm_value)
	data.append("max", PdMmax)
	if (pdm_value < 0) { alert("Vous ne pouvez pas dépenser autant de PdM !"); }
	else {
		fetch("/submit/update-character-pdm", {
			method: 'post',
			body: data
		})
			.then(response => response.text())
			.then(() => {
				const ping = new Message(sessionId, wsKey, "character-ping", characterId);
				ws.send(ping.stringify()); // ping will reload character
			})
	}
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

// event listeners for saving equipment after input change
formEquipment.addEventListener("change", (e) => {
	const pingAllCharacter = e.target.dataset.pingAll !== undefined ? true : false;
	submitEquipment(pingAllCharacter);
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
			const ping = new Message(sessionId, wsKey, "character-ping", characterTargetId);
			ws.send(ping.stringify());
		}, 300)
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


// pdm counter
const pdmInput = qs("[name=pdm_counter]")
if (pdmInput) {

	let timeoutId;
	pdmInput.addEventListener("keyup", (e) => {
		if (timeoutId){
			clearTimeout(timeoutId)
		}
		timeoutId = setTimeout( () => submitPdMChange(), 1000);
	})
}