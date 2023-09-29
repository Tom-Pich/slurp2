function process_msg_receivers(msg){
	var regex_receivers = /^\/(\d+,){0,10}\d+/;
	var result = regex_receivers.exec(msg.content);
	msg.receivers = result == null ? "[]" : "["+result[0].substring(1)+"]";
	msg.content = result == null ? msg.content :  msg.content.replace(result[0], "").trim()
	return msg
}

function insert_smiley(elem){
	input.value += elem
	input.focus()
}

function now(){
	let now = new Date()
	return ('0'+now.getHours()).slice(-2) + ":" + ('0'+now.getMinutes()).slice(-2) + ":" + ('0'+now.getSeconds()).slice(-2);
}

function process_msg_content(msg){
	msg.content = msg.content.replace(/\^\^/, "😊")
	if (msg.type !== "jet"){
		msg.content = msg.content.replace(/</g, "&lt;")
		msg.content = msg.content.replace(/>/g, "&gt;")
	}
	return msg
}

function send_msg(type){
	var msg = {"login_client": login, "id_client": id, "type":type, "time" : now(), "content" : input.value, "receivers" : "[]"}
	msg = process_msg_receivers(msg)
	msg = process_msg_content(msg)
	if(msg.content != "" || msg.type == "init"){connection.send(JSON.stringify(msg));}
	input.value = ""
	setTimeout(()=>{input.value = ""},10)
}

function display_msg(message){

	message = JSON.parse(message.data);

	if(message.type == "online_users_list"){
		let online_users_list = document.querySelector("#connected-users")
		let online_users_list_content = JSON.parse(message.content).join(" ; ")
		online_users_list.innerHTML = online_users_list_content
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

		setTimeout(() => {chat_box.appendChild(msg_container)},400)

		if(!message.history){
			if(message.type == "jet" && message.receivers == "[]"){var notif = new Audio('/chat/notif_dices.mp3'); notif.play();}
			if(message.type == "standard" && message.receivers == "[]" && message.id_client != id){var notif = new Audio('/chat/notif_standard.mp3'); notif.play();}
			if(message.receivers != "[]" && message.id_client != id){var notif = new Audio('/chat/notif_secret.mp3'); notif.play();}
		}
	}

	if (chat_box.scrollHeight-(chat_box.offsetHeight+chat_box.scrollTop) < 100){setTimeout(() => {chat_box.scrollTop = chat_box.scrollHeight-chat_box.offsetHeight+5;},500)}

}

function activate_ws() {
	window.WebSocket = window.WebSocket || window.MozWebSocket;
	connection.onopen = function (){send_msg("init")}
	connection.onerror = function (error) {console.log("erreur de connexion")};
	connection.onmessage = function (message) {display_msg(message)};
	input.addEventListener("keydown", function(e) {if (e.keyCode === 13) {send_msg("standard");}});
};

if (window.location.hostname == "site-jdr"){var connection = new WebSocket('ws://127.0.0.1:1337');}
else{var connection = new WebSocket('wss://web-chat.pichegru.net:443');}

var id = parseInt(document.querySelector("#id_client").value);
var login = document.querySelector("#login").value;
var input = document.querySelector("#msg-content")
var chat_box = document.getElementById("chat-box")

activate_ws()