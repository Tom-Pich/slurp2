import { qs, qsa, calculate, updateDOM } from "./utilities.js";

// Web Socket character ping sender
const wsServerURL = window.location.hostname === "site-jdr" ? "ws://127.0.0.1:1337" : "wss://web-chat.pichegru.net:443";
const wsTchatClient = new WebSocket(wsServerURL)
wsTchatClient.onopen = () => { } // nothing to do (yet)
wsTchatClient.onmessage = (rawMessage) => { }  // nothing to do (yet)

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

// change events
const inputs = qsa("input, select");
inputs.forEach(input => {
	input.addEventListener("change", (e) => {
		const saveBtn = input.closest("form").querySelector("button[type=submit]");
		saveBtn.classList.add("color1")
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
const characterStateForms = qsa("[data-role=character-state-form]")
characterStateForms.forEach(form => {
	form.addEventListener("submit", (e) => {
		e.preventDefault();
		const pdxCells = form.querySelectorAll("[data-role=pdx-cell]");
		pdxCells.forEach(cell => {
			cell.value = calculate(cell.value);
		})
		let form_id = form.getAttribute("id") // don’t use form.id because of one input which name is id
		const form_data = new FormData(form);
		// console.log(form_data)
		fetch("/submit/update-character-state", {
			method: 'post',
			body: form_data
		})
			.then(() => {
				fetch("/gestionnaire-mj")
					.then(response => response.text())
					.then(response => {
						updateDOM(`#${form_id}`, response)
						const characterStateForms = qsa("[data-role=character-state-form]")

						// ping character
						const initMsg = { type: "character-ping", id: parseInt(form.id.value), key: "a78D_Kj!45" }
						wsTchatClient.send(JSON.stringify(initMsg))
					})
			})
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
					//console.log("reloading scripts")
					//reloadScripts();
				})
		})
})