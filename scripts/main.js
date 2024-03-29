import { qs } from "./utilities";

// connection and disconnection
const connectionBtn = qs("#connection-btn")
const connectionDialog = qs("#connexion-dialog")
qs("[data-action=close-modal]").addEventListener("click", () => {
	connectionDialog.close();
})
if (connectionBtn.dataset.state === "0") {
	connectionBtn.addEventListener("click", () => {
		connectionDialog.show();
	})
} else {
	connectionBtn.addEventListener("click", () => {
		window.open("/submit/log-out", "_self")
	})
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