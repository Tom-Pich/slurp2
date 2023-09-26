<div id="connected-users" class="color1"></div>

<div id="chat-box">
	<p><b>Message privé&nbsp;:</b> "/" + n° destinataire(s) séparés par virgule – ex. "/2,3 Coucou"</p>
</div>

<form class="center" id="entree-chat" autocomplete="off" onsubmit="return false">
	
	<div id="smiley-bar">
			<span class="pointer" onclick="insert_smiley(this.innerText)" title="^^" >&#128522;</span>
			<span class="pointer" onclick="insert_smiley(this.innerText)" >&#128513;</span>
			<span class="pointer" onclick="insert_smiley(this.innerText)" >&#128516;</span>
			<span class="pointer" onclick="insert_smiley(this.innerText)" >&#128517;</span>
			<span class="pointer" onclick="insert_smiley(this.innerText)" >&#128521;</span>
			<span class="pointer" onclick="insert_smiley(this.innerText)" >&#128526;</span>
			<span class="pointer" onclick="insert_smiley(this.innerText)" >&#128527;</span>
			<span class="pointer" onclick="insert_smiley(this.innerText)" >&#128528;</span>
			<span class="pointer" onclick="insert_smiley(this.innerText)" >&#128529;</span>
			<span class="pointer" onclick="insert_smiley(this.innerText)" >&#128533;</span>
			<span class="pointer" onclick="insert_smiley(this.innerText)" >&#128532;</span><br/>
			<span class="pointer" onclick="insert_smiley(this.innerText)" >&#128519;</span>
			<span class="pointer" onclick="insert_smiley(this.innerText)" >&#128536;</span>
			<span class="pointer" onclick="insert_smiley(this.innerText)" >&#128540;</span>
			<span class="pointer" onclick="insert_smiley(this.innerText)" >&#128577;</span>
			<span class="pointer" onclick="insert_smiley(this.innerText)" >&#128558;</span>
			<span class="pointer" onclick="insert_smiley(this.innerText)" >&#128580;</span>
			<span class="pointer" onclick="insert_smiley(this.innerText)" >&#128561;</span>
			<span class="pointer" onclick="insert_smiley(this.innerText)" >&#128520;</span>
			<span class="pointer" onclick="insert_smiley(this.innerText)" >&#127183;</span>
			<span class="pointer" onclick="insert_smiley(this.innerText)" >&#128405;</span>
			<span class="pointer" onclick="insert_smiley(this.innerText)" >&#128169;</span>	
	</div>

	<textarea id="msg-content"></textarea>
	<input hidden id="id_client"	value="<?= $_SESSION["id"] ?>" />
	<input hidden id="login" 		value="<?= $_SESSION["login"] ?>" />

</form>

<script src="chat/chat_ws.js?v=1.1"></script>