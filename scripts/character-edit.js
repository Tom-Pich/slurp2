import { qs, qsa, ce } from "./lib/dom-utils.js";
import { updateDOM } from "./update-dom.js";
import { wsURL, Message } from "./ws-utilities.js";
import { activateDialogs } from "./main-utilities.js";

const form = qs("#noyau");
const sessionId = form.dataset.sessionId;
const wsKey = form.dataset.wsKey;
const characterId = qs("[name=id]").value;
const saveBtn = qs("[type=submit]");

// Web Socket character ping sender
const ws = new WebSocket(wsURL);
ws.onopen = () => {}; // nothing to do (yet)
ws.onmessage = (rawMessage) => {
    const message = JSON.parse(rawMessage.data);
    console.log(message);
};

// Portrait select confirmation
const addPortrait = qs("[data-role=add-portrait]");
addPortrait.addEventListener("change", (e) => {
    const file = /[^\\]+\.([\w]{3,4})$/.exec(e.target.value);
    const file_extension = file[1];
    let file_name = file[0];
    if (!["jpg", "jpeg", "webp", "png"].includes(file_extension)) {
        file_name = "format invalide";
    }
    qs("#file").innerText = file_name;
});

// Add Quirk input
const addQuirkBtn = qs("[data-role=add-quirk]");
const avdesavWrapper = qs("#avdesav-wrapper");
addQuirkBtn.addEventListener("click", (e) => {
    console.log(e.target);
    const newQuirkWrapper = ce("div");
    const quirkNumber = e.target.dataset.number;
    newQuirkWrapper.innerHTML = `
		<input hidden name="Avdesav[${quirkNumber}][id]" value="0">
		<details>
			<summary>
				<div class="flex-s gap-½">
					<input type="text" name="Avdesav[${quirkNumber}][nom]" class="fl-1">
					<input type="text" title="Coût" name="Avdesav[${quirkNumber}][points]" value="-1" size="2" class="ta-center" disabled>
				</div>
			</summary>
			<div class="mt-½ fs-300">Un travers est un trait de caractère mineur ne constituant pas un désavantage. Il est possible de prendre jusqu’à 5 travers.</div>
		</details>
	`;
    avdesavWrapper.appendChild(newQuirkWrapper);
    e.target.dataset.number++;
});

// Cancel input modal btn (new avdesav, new skills...), has to be a function because of updateDOM
function activateCloseInputModals() {
    const closeInputModalBtns = qsa("[data-role=close-input-modal]");
    closeInputModalBtns.forEach((btn) => {
        btn.addEventListener("click", (e) => {
            const dialog = e.target.closest("dialog");
            const inputs = dialog.querySelectorAll("input");
            inputs.forEach((input) => (input.checked = false));
            dialog.close();
        });
    });
}
activateCloseInputModals();

// change save btn color when changes are made
let allowSaveBtnColorChange = true;
form.addEventListener("change", () => {
    if (allowSaveBtnColorChange) saveBtn.classList.add("clr-invalid");
    allowSaveBtnColorChange = true;
});

// save on ctrl+s
form.addEventListener("keydown", (e) => {
    if (e.ctrlKey && e.key === "s") {
        e.preventDefault();
        const event = new Event("submit", {
            bubbles: true,
            cancelable: true,
        });
        form.dispatchEvent(event);
        allowSaveBtnColorChange = false;
    }
});

// submit form and reload page with morphdom
form.addEventListener("submit", (e) => {
    e.preventDefault();
    const dialogs = qsa("dialog");
    dialogs.forEach((dialog) => dialog.close());
    fetch("/submit/update-character", {
        method: "post",
        body: new FormData(form),
    })
        .then((response) => response.text())
        .then((response) => updateDOM("main", response))
        .then(() => {
            activateDialogs();
			activateCloseInputModals();
            const ping = new Message(sessionId, wsKey, "character-ping", parseInt(characterId));
            ws.send(ping.stringify());
        });
});
