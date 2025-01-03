import { qs, qsa } from "./utilities";

// connection and disconnection
const connectionBtn = qs("#connection-btn")
const connectionDialog = qs("#connexion-dialog")
qs("[data-role=close-modal]").addEventListener("click", () => {
	connectionDialog.close();
})
if (connectionBtn.dataset.state === "0") {
	connectionBtn.addEventListener("click", () => {
		connectionDialog.showModal();
	})
} else {
	connectionBtn.addEventListener("click", () => { window.open("/submit/log-out", "_self") })
}

// nav on mobile
const navBtn = qs("#show-nav-on-mobile")
const navBar = qs("header nav")
navBtn.addEventListener("click", () => {
	navBar.classList.toggle("active")
	navBtn.classList.toggle("active")
	if (navBtn.classList.contains("active")) {
		navBtn.innerText = "\uf00d";
	} else {
		navBtn.innerText = "\uf0c9"
	}
})

// dialogs handling
const dialogOpenerBtns = qsa("[data-role=open-dialog]");
dialogOpenerBtns.forEach(btn => {
	btn.addEventListener("click", (e) => {
		const dialog = qs(`[data-name=${btn.dataset.dialogName}]`)
		dialog.showModal();
	})
})

const dialogCloseBtns = qsa("[data-role=close-modal]");
dialogCloseBtns.forEach(btn => {
	btn.addEventListener("click", (e) => {
		const dialog = btn.closest("dialog")
		dialog.close();
	})
})