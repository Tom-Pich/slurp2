"use strict"

export const wsURL = window.location.hostname === "site-jdr" ? "ws://127.0.0.1:1337" : "wss://web-chat.pichegru.net:443";

export class Message {
	constructor(sender, key, type, content, recipients = []){
		this.sender = parseInt(sender); // sender ID
		this.key = key; // "secret" key (see .env)
		this.type = type;
		this.timestamp = Date.now();
		this.content = content;
		this.recipients = recipients;
	}
	stringify(){
		return JSON.stringify(this)
	}
}