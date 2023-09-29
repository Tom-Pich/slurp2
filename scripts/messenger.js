"use strict"

class Message
{
	constructor(id, login, key, type, content, receivers = "[]")
	{
		const now = new Date();

		this.login_client = login;
		this.id_client = id;
		this.key = key;
		this.type = type;
		this.time = ('0'+now.getHours()).slice(-2) + ":" + ('0'+now.getMinutes()).slice(-2) + ":" + ('0'+now.getSeconds()).slice(-2);
		this.content = content;
		this.receivers = receivers;
	}

	toString(){
		return JSON.stringify(this)
	}
}

export class Messenger
{
	constructor(id, login, key, serverURL, dialogWrapper, usersWrapper){

		this.id = id;
		this.login = login;
		this.key = key;
		this.serverURL = serverURL;
		this.dialogWrapper = dialogWrapper;
		this.usersWrapper = usersWrapper;
		this.wsClient = new WebSocket(serverURL);
		let messenger = this;

		this.wsClient.onopen = function(){
			messenger.readyState = this.readyState
			const initMessage = new Message(messenger.id, messenger.login, messenger.key, "init", "")
			this.send(initMessage.toString())
		}

		this.wsClient.onmessage = function(message){
			
			message = JSON.parse(message.data);

			if(message.type === "online_users_list"){
				messenger.usersWrapper.innerText = JSON.parse(message.content).join(" ; ")
				let notif = new Audio('/chat/notif_logout.mp3');
				notif.play();
			}
			
			else{
				let msg_ref = document.createElement("b");
				msg_ref.innerHTML = message.time + " " + message.login_client
				if (message.receivers != "[]"){
					let a_qui = JSON.parse(message.receivers_login).length ? JSON.parse(message.receivers_login).join(", ") : "?"
					msg_ref.innerHTML += " (à " + a_qui + ")"}
				msg_ref.innerHTML += "&nbsp;: "
				
				let msg_content = document.createElement("span")
				msg_content.innerHTML = message.content
				if (message.type == "jet"){msg_content.className = "color1"}
				
				let msg_container = document.createElement("p");
				msg_container.appendChild(msg_ref)
				msg_container.appendChild(msg_content)
		
				setTimeout(() => {messenger.dialogWrapper.appendChild(msg_container)}, 100)
		
				if(!message.history){
					if(message.type == "jet" && message.receivers == "[]"){var notif = new Audio('/chat/notif_dices.mp3'); notif.play();}
					if(message.type == "standard" && message.receivers == "[]" && message.id_client != id){var notif = new Audio('/chat/notif_standard.mp3'); notif.play();}
					if(message.receivers != "[]" && message.id_client != id){var notif = new Audio('/chat/notif_secret.mp3'); notif.play();}
				}
			}
		
			if (messenger.dialogWrapper.scrollHeight-(messenger.dialogWrapper.offsetHeight+messenger.dialogWrapper.scrollTop) < 100){setTimeout(() => {messenger.dialogWrapper.scrollTop = messenger.dialogWrapper.scrollHeight-messenger.dialogWrapper.offsetHeight+5;},500)}
		}

		this.send = function (type, content){

			if(this.readyState === 1){
				let msg = new Message(this.id, this.login, this.key, type, content)

				if(!this.id){
					const newEntry = document.createElement("div");
					newEntry.classList.add("mt-½")
					newEntry.innerHTML = inputEntry.value;
					chatBox.appendChild(newEntry);
					setTimeout(()=>{inputEntry.value = ""},5)
					return
				}
			
				// parsing recipients from input
				const regex_recipients = /^\/(\d+,){0,10}\d+/;
				let result = regex_recipients.exec(msg.content);
				msg.receivers = result === null ? "[]" : "["+result[0].substring(1)+"]";
				msg.content = result === null ? msg.content :  msg.content.replace(result[0], "").trim()

				// sanitizing input
				if (msg.type !== "jet"){
					
					msg.content = msg.content.replace(/</g, "&lt;")
					msg.content = msg.content.replace(/>/g, "&gt;")
				}
			
				// sending message
				if((msg.content !== "" || msg.type === "init") && msg.id !== 0){
					this.wsClient.send(msg.toString());
				}
			}
		}
	}
}