import { qs, ce } from "./utilities";
"use strict"

class Message {
	constructor(id, login, key, type, content, receivers = "[]") {
		const now = new Date();

		this.login = login; // name of the user
		this.id = id; // id of the user
		this.key = key; // code key found id data-key attribute (not used?)
		this.type = type; //standard, init, ...
		this.time = ('0' + now.getHours()).slice(-2) + ":" + ('0' + now.getMinutes()).slice(-2) + ":" + ('0' + now.getSeconds()).slice(-2); // time of creation hh:mm:ss
		this.content = content; // message content
		this.receivers = receivers; // receivers (if not for every body)
	}

	toString() {
		return JSON.stringify(this)
	}
}

export class Messenger {
	/**
	 * Sending and receiving messages via WebSocket
	 * @constructor
	 * @param {int} id - id of the user
	 * @param {string} login - login of the user
	 * @param {string} key - key to prevent spamming
	 * @param {string} serverURL - WS server URL
	 * @param {HTMLElement} dialogWrapper - HTML node where received msg will be displayed
	 * @param {HTMLElement} usersWrapper - HTML node where connected users login will be displayed
	 */
	constructor(id, login, key, serverURL, dialogWrapper, usersWrapper) {

		this.id = id;
		this.login = login;
		this.key = key;
		this.serverURL = serverURL;
		this.dialogWrapper = dialogWrapper;
		this.usersWrapper = usersWrapper;
		this.wsClient = new WebSocket(serverURL);
		let messenger = this;

		// what happens when the connection is established
		this.wsClient.onopen = function () {
			const initMessage = new Message(messenger.id, messenger.login, messenger.key, "init", "")
			if (messenger.id) { this.send(initMessage.toString()) }
			else { messenger.usersWrapper.innerHTML = `<div class="ta-center italic">Vous n’êtes pas connecté.</div>`; }
		}

		// when a message is received
		this.wsClient.onmessage = function (message) {

			message = JSON.parse(message.data);

			if (message.type === "online_users_list") {
				messenger.usersWrapper.innerText = JSON.parse(message.content).join(" ; ")
				let notif = new Audio('/assets/notifs/notif_logout.mp3');
				notif.play();
			}

			else {

				// message header
				let msg_ref = ce("b");
				msg_ref.innerHTML = message.time + " " + message.login
				if (message.receivers !== "[]") {
					let a_qui = JSON.parse(message.receivers_login).length ? JSON.parse(message.receivers_login).join(", ") : "?"
					msg_ref.innerHTML += " (à " + a_qui + ")"
				}
				msg_ref.innerHTML += "&nbsp;: "

				// message content
				let msg_content = ce("span")
				msg_content.innerHTML = message.content // sanitization done on server
				if (message.type == "jet") { msg_content.className = "color1" }

				// message wrapper
				let msg_container = ce("p");
				msg_container.appendChild(msg_ref)
				msg_container.appendChild(msg_content)

				setTimeout(() => { messenger.dialogWrapper.appendChild(msg_container) }, 100)

				if (!message.history) {
					if (message.type == "jet" && message.receivers == "[]") { var notif = new Audio('/assets/notifs/notif_dices.mp3'); notif.play(); }
					if (message.type == "standard" && message.receivers == "[]" && message.id != this.id) { var notif = new Audio('/assets/notifs/notif_standard.mp3'); notif.play(); }
					if (message.receivers != "[]" && message.id != this.id) { var notif = new Audio('/assets/notifs/notif_secret.mp3'); notif.play(); }
				}
			}

			// scroll the dialog down to the bottom
			if (messenger.dialogWrapper.scrollHeight - (messenger.dialogWrapper.offsetHeight + messenger.dialogWrapper.scrollTop) < 150) {
				setTimeout(() => { messenger.dialogWrapper.scrollTop = messenger.dialogWrapper.scrollHeight - messenger.dialogWrapper.offsetHeight + 5; }, 400)
			}
		}

		// when a message is sent
		this.send = function (type, content) {

			// if user is not connected or WS connection has been refused, display it directly in the dialog wrapper
			if (!this.id || this.wsClient.readyState !== 1) {
				const inputEntry = qs("#msg-input");
				const newEntry = ce("p");
				newEntry.innerHTML = inputEntry.value;
				this.dialogWrapper.appendChild(newEntry);
				inputEntry.value = ""
				return
			}

			let msg = new Message(this.id, this.login, this.key, type, content)

			// parsing recipients from input
			const regex_recipients = /^\/(\d+,){0,10}\d+/;
			let result = regex_recipients.exec(msg.content);
			msg.receivers = result === null ? "[]" : "[" + result[0].substring(1) + "]";
			msg.content = result === null ? msg.content : msg.content.replace(result[0], "").trim()

			// sending message
			if ((msg.content !== "" || msg.type === "init") && msg.id !== 0) {
				this.wsClient.send(msg.toString());
			}
		}
	}
}