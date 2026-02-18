import { qs, ce, qsa } from "./dom-utils"
export function showAlert(msgContent, msgType){
	const activeAlerts = qsa(".alert");
	const alertWindow = ce("div", ["alert", `alert-${activeAlerts.length+1}`])
	alertWindow.innerHTML = msgContent;
	alertWindow.classList.add(msgType);
	const pageWrapper = qs("#page-wrapper");
	document.body.insertBefore(alertWindow, pageWrapper)
	setTimeout( () => alertWindow.classList.add("active"), 100 )
	setTimeout( () => alertWindow.classList.remove("active"), 2000 )
	setTimeout(() => alertWindow.remove(), 2100)
}