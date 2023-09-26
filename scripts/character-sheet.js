import { qs, qsa, ce, updateDOM, reloadScripts } from "./utilities.js";

// ––– update character
function updateCharacter(id) {
	fetch("personnage-fiche?perso=" + id)
		.then(response => response.text())
		.then(response => {
			updateDOM("main", response)
			reloadScripts();
		})
}

const characterId = qs("#character-name").dataset.id;

// ––– Equipment –––––––––––––––––––––––––––––––––––––
const formEquipment = qs("#form-equipment");
const moveContainerUpBtns = qsa("[data-role=container-up]")
const moveContainerDownBtns = qsa("[data-role=container-down]")
const addItemBtns = qsa("[data-role=item-add]")
const containers = qsa("[data-role=container-wrapper]");

let newObjectNumber = 0;

// ––– Containers control buttons
moveContainerUpBtns.forEach(btn => {
	btn.addEventListener("click", (e) => {
		e.preventDefault();
		const containerWrapper = btn.closest("[data-role=container-wrapper]");
		const previousContainerWrapper = containerWrapper.previousElementSibling;
		if (previousContainerWrapper) {
			formEquipment.insertBefore(containerWrapper, previousContainerWrapper);
		}
	})
})

moveContainerDownBtns.forEach(btn => {
	btn.addEventListener("click", (e) => {
		e.preventDefault();
		const containerWrapper = btn.closest("[data-role=container-wrapper]");
		const nextContainerWrapper = containerWrapper.nextElementSibling;
		if (nextContainerWrapper.dataset.role === "container-wrapper") {
			nextContainerWrapper.after(containerWrapper);
		}
	})
})

addItemBtns.forEach(btn => {
	btn.addEventListener("click", (e) => {
		e.preventDefault();
		newObjectNumber++;
		const containerWrapper = btn.closest("[data-role=container-wrapper]");
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
	})
})

// ––– Drag & Drop – possible events : drag, dragend, dragenter, dragleave, dragover, dragstart, drop
const itemInputs = formEquipment.querySelectorAll("input");
const grips = qsa("[data-role=item-grip]");
const freeItemSlots = qsa("[data-role=free-slot]");
const groupTransfer = qsa("[data-role=item-transfer]")

let draggedItem = null;

grips.forEach((item) => {

	item.addEventListener("drag", (e) => {
		itemInputs.forEach(input => { input.disabled = true; })
	})

	item.addEventListener("dragstart", (e) => {
		draggedItem = e.target.closest("[data-role=item-wrapper]");
	})

	item.addEventListener("dragend", (e) => {
		itemInputs.forEach(input => { input.disabled = false; })
	})

	item.addEventListener("dragover", (e) => {
		e.preventDefault();
	})

	item.addEventListener("dragenter", (e) => {
		let container = e.target.closest("[data-role=container-wrapper]")
		let target = e.target.closest("[data-role=item-wrapper]")
		container.insertBefore(draggedItem, target)
		draggedItem.querySelector("[data-role=item-place]").value = container.dataset.place
	})

	//item.addEventListener("dragleave", (e) => {  })

	//item.addEventListener("drop", (e) => {  })

})

freeItemSlots.forEach(slot => {

	slot.addEventListener("dragover", (e) => {
		e.preventDefault();
	})

	slot.addEventListener("dragenter", (e) => {
		let container = e.target.closest("[data-role=container-wrapper]")
		let target = e.target
		container.insertBefore(draggedItem, target)
		draggedItem.querySelector("[data-role=item-place]").value = container.dataset.place
	})

})

groupTransfer.forEach(member => {
	member.addEventListener("dragover", (e) => {
		e.preventDefault();
	})

	member.addEventListener("drop", (e) => {
		const container = qs("#item-transfer");
		const transferLabel = ce("div", ["mt-½", "fw-600"]);
		const target = e.target.closest("[data-role=item-transfer]")
		transferLabel.innerText = `Transfert à ${target.dataset.name}`
		container.append(transferLabel, draggedItem);
		draggedItem.querySelector("[data-role=item-place]").value = target.dataset.place;
	})
})

// ––– get weapon damage on hover
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

// ––– Memorizing container wrapper state (open/closed)
containers.forEach(container => {
	if (localStorage.getItem(`container-${container.dataset.place}`) === "true") {
		container.setAttribute("open", true);
	}
	container.children[0].addEventListener("click", (e) => {
		const opening = !e.target.closest("details").hasAttribute("open");
		localStorage.setItem(`container-${container.dataset.place}`, opening);
	})
})

// ––– submit character equipment
formEquipment.addEventListener("submit", (e) => {
	e.preventDefault();
	fetch("/submit/equipment-list", {
		method: 'post',
		body: new FormData(formEquipment)
	})
		.then(() => {
			updateCharacter(characterId)
		})
})

// refresh character button
const refreshBtn = qs("[data-role=refresh-character]");
refreshBtn.addEventListener("click", (e) => {
	updateCharacter(characterId)
})

