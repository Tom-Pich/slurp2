import { qs, qsa, ce } from "./lib/dom-utils.js";
import { wsURL, Message, flushMsg } from "./ws-utilities.js";

// ––– Websocket Chat Client ––––––––––––––––––––––––
const chatEntry = qs("#chat-input-wrapper");
const id = parseInt(chatEntry.dataset.id);
const login = chatEntry.dataset.login;
const key = chatEntry.dataset.key;

const usersWrapper = qs("#connected-users");
const dialogWrapper = qs("#chat-dialog-wrapper");
const emojiBtns = qsa("[data-role=emoji-button]");
const inputEntry = qs("#msg-input");
const useNotif = qs("#chat-container").dataset.sound === "1";

const ws = new WebSocket(wsURL);

// make the necessary data for flushMsg available outside of the module scope
window.chat = {
	ws: ws,
	id: id,
	key: key,
	inputEntry: inputEntry
}

let users = {};
let lastSender = 0;
let lastMessageTime = 0;
let lastRecipients = "[]"; // in JSON, to compare with message.recipients

ws.onopen = () => {
  let initMessage = new Message(id, key, "chat-init", login);
  ws.send(initMessage.stringify());
};

ws.onmessage = (rawMessage) => {
  const message = JSON.parse(rawMessage.data);
  //console.log(message);

  // create user list and display it in the tchat
  if (message.type === "chat-users") {
	users = message.content; // { "id1" : { login : "login1", isConnected : bool}, ... }
	const userList = [];
	Object.entries(users).forEach(([id, user]) => {
	  if (user.isConnected) userList.push(`${user.login} (${id})`); // filling userList
	});
	usersWrapper.innerText = userList.join(", "); // display userList
	if (message.isDeconnection === undefined && useNotif) {
	  let notif = new Audio("/assets/notifs/user-log.mp3");
	  notif.play();
	}
  }

  // handle new message in tchat
  if (message.type === "chat-message" || message.type === "chat-roll") {
	const jsonRecipients = JSON.stringify(message.recipients);

	const p = ce("div", ["chat-message-wrapper"]);
	const messageRef = ce("div", ["chat-message-header"]);
	const messageText = ce("div", ["chat-message-content"]);

	// message global CSS classes
	if (message.type === "chat-roll") messageText.classList.add("chat-roll");
	if (message.sender === id) p.classList.add("self-message");
	if (message.sender !== id) p.classList.add("bg-color-user-" + ((message.sender % 7) + 1));
	if (message.sender === lastSender && jsonRecipients === lastRecipients && message.timestamp - lastMessageTime < 15000) p.classList.add("same-routing");
	if (message.recipients.length > 0) p.classList.add("is-private");

	// building message "header"
	if (message.sender !== id) {
	  messageRef.innerText = users[message.sender].login;
	}
	if (message.recipients.length) {
	  const recipientLogins = [];
	  message.recipients.forEach((recipientId) => {
		const login = users[recipientId] === undefined ? "?" : users[recipientId].login;
		recipientLogins.push(login);
	  });
	  messageRef.innerText += ` (à ${recipientLogins.join(", ")})`;
	}
	const time = new Date(message.timestamp);
	const readableTime = time.toLocaleTimeString("fr-FR");
	messageRef.innerText += ` ${readableTime}`;

	// finishing message building : content + injection in DOM
	messageText.innerHTML = message.content; // sanitized on server
	p.append(messageRef, messageText);
	dialogWrapper.append(p);

	// notifications
	let file = null;
	if (message.type === "chat-message" && message.sender !== id) file = "message.mp3";
	if (message.type === "chat-roll") file = "dice-roll.mp3";
	if (message.label === "😎") file = "roll-critical-success.mp3";
	if (message.label === "🟢") file = "roll-success.mp3";
	if (message.label === "🔴") file = "roll-failure.mp3";
	if (message.label === "😖") file = "roll-critical-failure.mp3";
	if (message.recipients.length) file = "secret.mp3";
	if (message.label === "history") file = null;

	if (file !== null && useNotif) {
	  const notif = new Audio("/assets/notifs/" + file);
	  notif.play();
	}

	// scroll the dialog down to the bottom
	if (dialogWrapper.scrollHeight - (dialogWrapper.offsetHeight + dialogWrapper.scrollTop) < 250) {
	  setTimeout(() => {
		dialogWrapper.scrollTop = dialogWrapper.scrollHeight - dialogWrapper.offsetHeight + 5;
	  }, 200);
	}

	lastSender = message.sender;
	lastMessageTime = message.timestamp;
	lastRecipients = jsonRecipients;
  }
};

// "Enter" event in message input
inputEntry.addEventListener("keydown", function (e) {
  if (e.keyCode === 13 && !e.shiftKey) {
	e.preventDefault();
	flushMsg("chat-message");
  } else if (e.keyCode === 13) inputEntry.value += "¬";
});

// add emoji in chat entry
emojiBtns.forEach((btn) => {
  btn.addEventListener("click", (e) => {
	inputEntry.value += e.target.innerText;
	inputEntry.focus();
  });
});