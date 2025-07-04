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
const itemInputs = formEquipment.querySelectorAll("input");
let newObjectNumber = 0;

// ––– Web Socket character ping sender –––
const ws = new WebSocket(wsURL);
ws.onopen = () => {}; // nothing to do

ws.onmessage = (rawMessage) => {
  const message = JSON.parse(rawMessage.data);
  console.log(message);
  if (message.type === "character-ping" && [0, characterId].includes(message.content)) {
    updateCharacter(characterId);
  }
};

// on page load update sheet state
containerOpenCloseStateManager();
fillPdMCount();

// reload character on style change
const channel = new BroadcastChannel("display-options");
channel.onmessage = (event) => {
	if (event.data.option === "style") updateCharacter(characterId);
};

// ––– functions ––––––––––––––––––––––––––––––––––––––

// ––– fetch the character sheet from server and update DOM with morphdom
function updateCharacter(id) {
  fetch("personnage-fiche?perso=" + id)
    .then((response) => response.text())
    .then((response) => {
      updateDOM("main", response)
	  .then( () => showAlert("Personnage mis à jour&nbsp;!", "valid") )
	  .then( () => fillPdMCount() );
      //fillPdMCount();
    });
}

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

// ––– submit character equipment and send a character ping
function submitEquipment(pingAllCharacter = false) {
  // getting ordered inputs (FF bug ?) for list ordering
  let formData = new FormData();
  formEquipment.querySelectorAll("input").forEach((input) => {
    if (input.type === "checkbox") {
      formData.append(input.name, input.checked ? input.value : "");
    } else {
      formData.append(input.name, input.value);
    }
  });

  fetch("/submit/equipment-list", {
    method: "post",
    body: formData,
  })
    //.then((response) => response.text()) // for test
	//.then( (response => console.log(response))) // for test
    .then(() => {
      const ping = new Message(sessionId, wsKey, "character-ping", pingAllCharacter ? 0 : characterId);
      ws.send(ping.stringify());
    });
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
      submitEquipment();
    }
  } else if (target.dataset.role === "container-down") {
    const containerWrapper = target.closest("[data-role=container-wrapper]");
    const nextContainerWrapper = containerWrapper.nextElementSibling;
    if (nextContainerWrapper.dataset.role === "container-wrapper") {
      nextContainerWrapper.after(containerWrapper);
      submitEquipment();
    }
  } else if (target.dataset.role === "add-item") {
    newObjectNumber++;
    const containerWrapper = target.closest("[data-role=container-wrapper]");
	const freeSlot = containerWrapper.querySelector("[data-role=free-slot]")
    const itemWrapper = ce("details", ["items-list"]);
    itemWrapper.innerHTML = `
			<summary class="grid gap-½ ai-center">
				<div class="ff-fas" draggable="true" data-role="item-grip">&#xf58e;</div>
				<input name="nouvel-objet[${newObjectNumber}][Nom]"	type="text" placeholder = "Nouvel objet">
				<input name="nouvel-objet[${newObjectNumber}][Poids]" type="text" class="ta-center">
				<input hidden name="nouvel-objet[${newObjectNumber}][Lieu]" value="${containerWrapper.dataset.place}">
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

// event listeners for saving equipment after input change
formEquipment.addEventListener("change", (e) => {
  const pingAllCharacter = e.target.dataset.pingAll !== undefined ? true : false;
  submitEquipment(pingAllCharacter);
});

// event listener for drag and drop (not used: drag, dragleave, drop)
let draggedItem = null;
let timeoutId; // delay before opening a container wrapper

formEquipment.addEventListener("dragover", (e) => {
  e.preventDefault();
});

formEquipment.addEventListener("dragstart", (e) => {
  if (e.target.dataset.role === "item-grip") {
    itemInputs.forEach((input) => {
      input.disabled = true;
    });
    draggedItem = e.target.closest("[data-role=item-wrapper]");
  }
});

formEquipment.addEventListener("dragend", (e) => {
  if (e.target.dataset.role === "item-grip") {
    itemInputs.forEach((input) => {
      input.disabled = false;
    });
    submitEquipment();
  }
});

formEquipment.addEventListener("dragenter", (e) => {
  if (e.target.dataset.role === "item-grip") {
    if (timeoutId) clearTimeout(timeoutId);
    let container = e.target.closest("[data-role=container-wrapper]");
    let target = e.target.closest("[data-role=item-wrapper]");
    container.insertBefore(draggedItem, target);
    draggedItem.querySelector("[data-role=item-place]").value = container.dataset.place;
  } else if (e.target.dataset.role === "free-slot") {
    if (timeoutId) clearTimeout(timeoutId);
    let container = e.target.closest("[data-role=container-wrapper]");
    let target = e.target;
    container.insertBefore(draggedItem, target);
    draggedItem.querySelector("[data-role=item-place]").value = container.dataset.place;
  } else if (e.target.closest("summary") && e.target.closest("summary").dataset.role === "container-title-wrapper") {
    if (timeoutId) clearTimeout(timeoutId);
    timeoutId = setTimeout(function () {
      let container = e.target.closest("[data-role=container-wrapper]");
      container.open = true;
    }, 500);
  }
});

membersWrapper.addEventListener("dragover", (e) => {
  e.preventDefault();
});

membersWrapper.addEventListener("drop", (e) => {
  const target = e.target.closest("[data-role=item-transfer]");

  if (target) {
    const container = qs("#item-transfer");
    draggedItem.querySelector("[data-role=item-place]").value = target.dataset.place;
    container.append(draggedItem);

    // ping character after change
    setTimeout(() => {
      const characterTargetId = parseInt(target.dataset.place.substr(3));
      const ping = new Message(sessionId, wsKey, "character-ping", characterTargetId);
      ws.send(ping.stringify());
    }, 300);
  }
});

// event listener for submitting form (still necessary if "Enter" is pressed)
formEquipment.addEventListener("submit", (e) => {
  e.preventDefault();
  submitEquipment();
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

// ––– other stuff ––––––––––––––––––––––––––––––––––

// pdm counter save
const pdmInput = qs("[name=pdm_counter]");
if (pdmInput) {
  let timeoutId;
  pdmInput.addEventListener("keyup", (e) => {
    if (timeoutId) {
      clearTimeout(timeoutId);
    }
    timeoutId = setTimeout(() => submitPdMChange(), 1000);
  });
}

// make a test on game table
const throwableItems = qsa("[data-type=throwable-label], [data-type=throwable-score]");
const testDialog = qs("dialog[data-type=character-sheet-roll]");
const testDialogBtn = testDialog.querySelector("[data-type=send-test]");
const modifierInput = testDialog.querySelector("[data-type=test-modifier-value]");
let label, score;

throwableItems.forEach((item) => {
  item.addEventListener("click", (e) => {

	const wrapper = item.closest("[data-type=throwable-wrapper]");
	const isThrowableInSummary = wrapper.tagName === "SUMMARY";

	// click on label in summary → only open details, don’t roll
	if (isThrowableInSummary && e.target.dataset.type === "throwable-label" ) return;

	e.preventDefault();

    testDialog.showModal();
    modifierInput.focus();
    modifierInput.value = ""; // reset modifier value

    
    label = trimModifier(wrapper.querySelector("[data-type=throwable-label]").innerText);
    score = wrapper.querySelector("[data-type=throwable-score]").innerText;
    testDialog.querySelector("[data-content=label]").innerText = label;
    testDialog.querySelector("[data-content=score]").value = score;
  });
});

testDialogBtn.addEventListener("click", (e) => {
  const modifier = int(modifierInput.value);
  const readableModif = modifier === 0 ? "" : explicitSign(modifier);
  const effectiveScore = parseInt(testDialog.querySelector("[data-content=score]").value);
  const rollResult = roll("3d").result;
  const outcome = scoreTester(effectiveScore + modifier, rollResult);
  const messageContent = `${label} (${effectiveScore}${readableModif}) → ${rollResult} (MR ${outcome.MR} ${outcome.symbol})`;
  const isSecretTest = testDialog.querySelector("[data-type=secret-test-checkbox]").checked;
  const recipients = isSecretTest ? [gmId] : [];
  const message = new Message(sessionId, wsKey, "chat-roll", messageContent, recipients, outcome.symbol);
  ws.send(message.stringify());
  testDialog.close();
});

testDialog.addEventListener("keydown", (e) => {
  if (e.keyCode === 13) {
	e.preventDefault();
    testDialogBtn.click();
  }
});
