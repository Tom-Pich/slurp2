import { activateLoginDialog, activateMobileNav, activateDialogs, applyColorScheme } from "./main-utilities";

activateLoginDialog();
activateMobileNav();
activateDialogs();

// browser color scheme handling
const colorSchemeQuery = window.matchMedia("(prefers-color-scheme: dark)");
colorSchemeQuery.addEventListener("change", () => applyColorScheme());
applyColorScheme();

// color scheme option change broadcast
const channel = new BroadcastChannel("display-options");
const html = document.documentElement;
channel.onmessage = (event) => {
    if (event.data.option === "mode" && html.dataset.preset !== event.data.value) {
        html.dataset.preset = event.data.value;
        html.dataset.mode = event.data.value;
        applyColorScheme();
    } else if (event.data.option === "style") {
        event.data.value === "compact" ? document.body.classList.add("compact") : document.body.classList.remove("compact");
    } else if (event.data.option === "theme") {
        document.documentElement.dataset.theme = event.data.value;
    }
};
