import { qs, qsa, calculate } from "./utilities.js";
import { wsURL, Message } from "./ws-utilities.js";
import { updateDOM } from "./update-dom.js";

const sessionId = qs("#ws-data").dataset.sessionId;
const wsKey = qs("#ws-data").dataset.wsKey;

// Web Socket character ping sender
const ws = new WebSocket(wsURL)
ws.onopen = () => { } // nothing to do (yet)
ws.onmessage = (rawMessage) => {
	const message = JSON.parse(rawMessage.data);
	console.log(message)
	if (message.type === "character-ping") {
		fetch("gestionnaire-mj")
			.then(response => response.text())
			.then(response => {
				updateDOM(`#state-form-character-${message.content}`, response)
			})
	}
}


// calulate pdx cells content
const pdxCells = qsa("[data-role=pdx-cell]");
pdxCells.forEach(cell => {
	cell.addEventListener("blur", e => {
		if (e.target.value) {
			const result = calculate(e.target.value);
			cell.value = result;
		}
	})
})

// export button events
const exportBtns = qsa("[data-role=export-character]");
exportBtns.forEach(btn => {
	btn.addEventListener("click", (e) => {
		const characterId = e.target.dataset.id;
		let data = new FormData();
		data.append("id", characterId);
		fetch("/submit/export-character", {
			method: 'post',
			body: data
		})
			.then(response => response.text())
			.then(response => {
				const responseWrapper = qs(`#confirm-export-${characterId}`);
				responseWrapper.innerText = response;
			})
	})
})

// remember group state (open/close)
const groupWrappers = qsa("[data-group]");
groupWrappers.forEach(group => {
	if (localStorage.getItem(`group-${group.dataset.group}`) === "true") {
		group.setAttribute("open", true);
	}
	group.addEventListener("click", (e) => {
		if (e.target.tagName === "SUMMARY") {
			const opening = !e.target.closest("details").hasAttribute("open");
			localStorage.setItem(`group-${group.dataset.group}`, opening);
		}
	})
})

// submit character form and update
function submitCharacterForm(form) {
	const pdxCells = form.querySelectorAll("[data-role=pdx-cell]");
	pdxCells.forEach(cell => {
		cell.value = calculate(cell.value);
	})
	let form_id = form.getAttribute("id") // don’t use form.id because of one input which name is id
	const form_data = new FormData(form);
	//console.log(form_data)
	fetch("/submit/update-character-state", {
		method: 'post',
		body: form_data
	})
		.then(() => {
			fetch("/gestionnaire-mj")
				.then(response => response.text())
				.then(response => {
					updateDOM(`#${form_id}`, response)

					// ping character
					const ping = new Message(sessionId, wsKey, "character-ping", parseInt(form_data.get("id")));
					ws.send(ping.stringify())
				})
		})
}

// character forms events
const characterStateForms = qsa("[data-role=character-state-form]")
characterStateForms.forEach(form => {

	// if form submitted manually (with "enter" key)
	form.addEventListener("submit", (e) => {
		e.preventDefault();
		submitCharacterForm(form)
	})

	let timeoutId

	// submit form on keyup with delay
	form.addEventListener("keyup", (e) => {
		if (timeoutId) {
			clearTimeout(timeoutId);
		}
		timeoutId = setTimeout(function () {
			submitCharacterForm(form);
		}, 1000);
	})

	// submit form on change
	form.addEventListener("change", (e) => {
		submitCharacterForm(form)
	})
})

// submit items form and update
const itemsForm = qs("#items-form")
itemsForm.addEventListener("submit", (e) => {
	e.preventDefault();
	fetch("/submit/equipment-list", {
		method: 'post',
		body: new FormData(itemsForm)
	})
		.then(() => {
			fetch("/gestionnaire-mj")
				.then(response => response.text())
				.then(response => {
					updateDOM("#items-form", response)
				})
		})
})