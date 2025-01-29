import { qs } from "./lib/dom-utils";
import { showAlert } from "./lib/alert";

function checkPasswordStrength(password) {
    const digit = /\d+/.test(password);
    const length = password.length >= 8;
    const specialchars = /\W+/.test(password);
    const space = /\s+/.test(password);
    const uppercase = /[A-Z]/.test(password);
    const lowercase = /[a-z]/.test(password);
    const isStrong = digit && length && specialchars && !space && uppercase && lowercase;
    return isStrong;
}

const form = qs("#pwd-change-form");
const pwd0 = qs("#pwd0");
const pwd1 = qs("#pwd1");
const pwd2 = qs("#pwd2");

let pwdIsStrong = false;
let pwdMatch = false;

// check if password 1 is strong
pwd1.addEventListener("keyup", () => {
    if (checkPasswordStrength(pwd1.value)) {
        pwdIsStrong = true;
        pwd1.setCustomValidity("");
    } else {
        pwdIsStrong = false;
        pwd1.setCustomValidity("Mot de passe faible");
    }
});

// check if password 2 matches password 1
pwd2.addEventListener("keyup", () => {
    if (pwd1.value === pwd2.value) {
        pwd2.setCustomValidity("");
        pwdMatch = true;
    } else {
        pwd2.setCustomValidity("Les mots de passe ne correspondent pas");
        pwdMatch = false;
    }
});

// new password submit
form.addEventListener("submit", (e) => {
    e.preventDefault();
    if (pwdIsStrong && pwdMatch) {
        fetch("/submit/change-password", {
            method: "post",
            body: new FormData(form),
        })
            .then((response) => response.json())
            .then((response) => showAlert(response.msg, response.error ? "invalid" : "valid"))
            .then(() => {
                pwd0.value = "";
                pwd1.value = "";
                pwd2.value = "";
            });
    } else if (!pwdMatch) showAlert("Les mots de passe donnés sont différents !", "invalid");
    else showAlert("Votre nouveau mot de passe n’est pas assez fort", "invalid");
});

// ––– user options
const userOptions = qs("form[data-role=user-options]");
const channel = new BroadcastChannel("display-options");

// option changes
userOptions.addEventListener("change", (e) => {
    if (e.target.name === "mode") {
        document.documentElement.dataset.mode = e.target.value;
        document.documentElement.dataset.preset = e.target.value;
    } else if (e.target.name === "style"){
		e.target.value === "compact" ? document.body.classList.add("compact") : document.body.classList.remove("compact")
	}
    const data = new FormData();
    data.append("option", e.target.name);
    data.append("value", e.target.value);
    fetch("/submit/set-user-option", {
        method: "post",
        body: data,
    })
        .then(() => showAlert("Préférences modifiées", "valid"))
        .then(() => channel.postMessage({ option: e.target.name, value: e.target.value }));
});
