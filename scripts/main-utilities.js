import { qs, qsa } from "./lib/dom-utils";

export function activateLoginDialog() {
    const connectionBtn = qs("#connection-btn");
    const connectionDialog = qs("#connexion-dialog");
    qs("[data-role=close-modal]").addEventListener("click", () => connectionDialog.close());
    if (connectionBtn.dataset.state === "0") {
        connectionBtn.addEventListener("click", () => connectionDialog.showModal());
    } else {
        connectionBtn.addEventListener("click", () => window.open("/submit/log-out", "_self"));
    }
}

export function activateMobileNav() {
    const navBtn = qs("#show-nav-on-mobile");
    const navBar = qs("header nav");
    navBtn.addEventListener("click", () => {
        navBar.classList.toggle("active");
        navBtn.classList.toggle("active");
        if (navBtn.classList.contains("active")) navBtn.innerText = "\uf00d";
        else navBtn.innerText = "\uf0c9";
    });
}

export function activateDialogs() {
    const dialogOpenerBtns = qsa("[data-role=open-dialog]");
    const dialogCloseBtns = qsa("[data-role=close-modal]");

    dialogOpenerBtns.forEach((btn) => {
        btn.addEventListener("click", (e) => {
            const dialog = qs(`[data-name=${btn.dataset.dialogName}]`);
            dialog.showModal();
        });
    });

    dialogCloseBtns.forEach((btn) => {
        btn.addEventListener("click", (e) => {
            const dialog = btn.closest("dialog");
            dialog.close();
        });
    });
}

export function applyColorScheme() {
    const colorSchemeDark = window.matchMedia("(prefers-color-scheme: dark)");
    const html = document.documentElement;
    if (html.dataset.preset === "auto" && colorSchemeDark.matches) html.dataset.mode = "dark";
    else if (html.dataset.preset === "auto" && !colorSchemeDark.matches) html.dataset.mode = "light";
}

export function showSpinningWheel(targetForm = null){
	qs("#loading-spinner").style.display = 'block';
	if(targetForm) targetForm.querySelector("[type=submit]").disabled = true;
}

export function hideSpinningWheel(){
	qs("#loading-spinner").style.display = 'none';
	//console.log(qs("#loading-spinner"))
}