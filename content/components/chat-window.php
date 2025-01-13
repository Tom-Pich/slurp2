<?php
$playNotif = $playNotif ?? true;
$displayEmojis = $displayEmojis ?? true;
?>

<div id="chat-container" data-sound="<?= $playNotif ?>">

	<div id="connected-users">
		<?php if (!$_SESSION["id"]) { ?><div class="ta-center italic">Vous n’êtes pas connecté</div><?php } ?>
	</div>

	<button id="chat-help-dialog-btn" class="ff-far btn-primary btn-square" data-role="open-dialog" data-dialog-name="chat-help" title="mode d’emploi du chat">
		&#xf059;
	</button>

	<div id="chat-dialog-wrapper" class="flow">
		<?php if (!$_SESSION["id"]) { ?><p class="ta-center fw-700">Les résultats des widgets s’affichent ici</p><?php } ?>
	</div>

	<div id="chat-input-wrapper" data-id="<?= $_SESSION["id"] ?>" data-login="<?= $_SESSION["login"] ?>" data-key="<?= $_SESSION["id"] ? WS_KEY : "0" ?>">

		<?php if ($displayEmojis): ?>
			<div class="flex-s fl-wrap gap-¼ jc-center desktop" data-role="emojis-wrapper">
				<?php
				$emojis = ["😊", "😁", "😄", "😅", "😉", "😎", "😏", "😐", "😑", "😕", "😔", "😇", "😘", "😜", "😮", "🙄", "😱", "😈", "🃏", "🖕", "💩"];
				foreach ($emojis as $emoji):
				?>
				<button data-role="emoji-button" class="nude"><?= $emoji ?></button>
				<?php endforeach ?>
			</div>
		<?php endif ?>

		<textarea id="msg-input"></textarea>

	</div>

</div>

<dialog data-name="chat-help">
	<button data-role="close-modal" class="ff-fas">&#xf00d;</button>
	<h4>Fonctionnalités du tchat</h4>
	<ul class="mt-1 flow">
		<li><b>Message privé&nbsp;:</b> "/" + n° du ou des destinataire(s), séparés par une virgule et <i>sans espace</i> – ex. «&nbsp;/2,3 Coucou&nbsp;»</li>
		<li><b>Jet de widget privé&nbsp;:</b> même principe que pour les messages privés. Entrez /x,y pour spécifier les destinataires, puis utilisez le widget de votre choix.</li>
		<li><b>Jet de réussite dans un message&nbsp;:</b> insérez dans votre message un score précédé du signe #. Un jet sera fait, avec affichage de la MR et d’un éventuel critique – ex. «&nbsp;Blabla #12 blabla.&nbsp;»</li>
		<li><b>Jet classique dans un message&nbsp;:</b> insérez dans votre message une expression correspondant à un jet, précédée du signe #. Ex. «&nbsp;bla bla #2d+1&nbsp;». Il est possible de mélanger jets de réussite et jets classiques – ex. «&nbsp;Blabla #12 et blibli #1d+2&nbsp;»</li>
		<li><b>Jet de dégâts dans un message&nbsp;:</b> insérez dans votre message une expression correspondant à un jet, précédée de la lettre «&nbsp;D&nbsp;» majuscule. Ça aura pour effet, en plus de faire le tirage, de préciser une locaisation aléatoire.</li>
		<li><b>Mise en forme du message&nbsp;:</b> des mots entre astérisques (*) seront affichés en gras. Des mots entre underscores (_) seront affichés en italique.</li>
		<li><b>Retour à la ligne&nbsp;:</b> vous pouvez insérer un retour à la ligne dans un message en faisant <key>Shift + Entrée</key>
		</li>
	</ul>
</dialog>

<script type="module" src="/scripts/chat-window<?= PRODUCTION ? ".min" : "" ?>.js?v=<?= VERSION ?>" defer></script>