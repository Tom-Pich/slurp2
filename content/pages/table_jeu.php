<?php

use \App\Rules\ObjectController;

$nbre_protagonistes = 7;
$nbre_competences = 15;
?>

<div id="widgets-container">

	<button id="widgets-help-dialog-btn" class="ff-fas btn-primary px-½ py-¼" data-role="open-dialog" data-dialog-name="widgets-help" title="configuration des widgets">&#xf085;</button>

	<div class="widgets-column">

		<!-- test caractéristique / compétence -->
		<fieldset data-name="score-tester">
			<legend>Jets de réussite</legend>
			<?php for ($i = 1; $i <= $nbre_competences; $i++) { ?>
				<form class="flex-s gap-½ mt-¼">
					<input type="text" style="width: 70%" data-type="skill-name" data-skill-number=<?= $i ?> placeholder="Comp. ou carac." list="liste-carac-comp">
					<datalist id="liste-carac-comp">
						<option value="Force"></option>
						<option value="Dextérité"></option>
						<option value="Intelligence"></option>
						<option value="Santé"></option>
						<option value="Perception"></option>
						<option value="Volonté"></option>
						<option value="Esquive"></option>
						<option value="Hache/Masse"></option>
						<option value="Épée"></option>
						<option value="Arc"></option>
						<option value="Arbalète"></option>
						<option value="Combat à mains nues"></option>
						<option value="Culture générale"></option>
						<option value="Furtivité"></option>
					</datalist>
					<input type="text" data-type="score" style="width: 7ch" class="ta-center" placeholder="score" title="score">
					<input type="text" data-type="modif" style="width: 7ch" class="ta-center" placeholder="modif" title="Modif (vide = zéro)">
					<button class="nude">🎲</button>
				</form>
			<?php } ?>
		</fieldset>

	</div>
	
	<div class="widgets-column">
		<!-- Protagonistes -->
		<fieldset data-name="opponents" hidden>
			<legend>Protagonistes</legend>

			<?php for ($i = 1; $i <= $nbre_protagonistes; $i++) { ?>
				<div class="mt-1" data-role="opponent-wrapper" data-opponent="<?= $i ?>">
					<div class="flex-s gap-½">
						<input type="text" class="fl-1" data-type="name" placeholder="Nom">
						<select data-type="category" style="width: 6ch" title="cnb: non-biologique">
							<option value="std">std</option>
							<option value="cnb">cnb</option>
						</select>
						<input type="text" style="width: 5ch" data-type="dex" class="ta-center" placeholder="Dex" title="Dextérité" value="<?= $i === 0 ? 11 : "" ?>">
						<input type="text" style="width: 5ch" data-type="san" class="ta-center" placeholder="San" title="Santé" value="<?= $i === 0 ? 12 : "" ?>">
						<input type="text" style="width: 5ch" data-type="pain-resistance" class="ta-center" placeholder="Doul." title="Résistance à la douleur (-1, 0, 1)">
					</div>
					<div class="flex-s gap-½ mt-½">
						<input type="text" style="width: 6ch" data-type="pdvm" class="ta-center" placeholder="PdVm" title="PdV maxi" value="<?= $i === 0 ? 12 : "" ?>">
						<input type="text" style="width: 6ch" data-type="pdv" class="ta-center" placeholder="PdV" title="PdV actuels" value="<?= $i === 0 ? 12 : "" ?>">
						<input type="text" class="fl-1" style="width: 6ch" data-type="members" placeholder="Blessures membres" title="Par exemple BD 2, PG 1">
					</div>
				</div>
			<?php } ?>

		</fieldset>
	</div>

	<div class="widgets-column">

		<!-- jet de dés simple -->
		<fieldset data-name="simple-roll">
			<legend>Jet de dés simple</legend>
			<form class="flex-s ai-flex-between">
				<div class="fl-1 ta-center">
					<input type="text" size="5" data-type="dice-expression" class="ta-center" placeholder="xd±y" value="3d" title="xd(y)(+-/* z)">
				</div>
				<button class="nude">🎲</button>
			</form>
		</fieldset>

		<!-- jet de réaction -->
		<fieldset data-name="widget-reaction" hidden>
			<legend>Jet de réaction</legend>
			<form class="flex-s ai-flex-between">
				<div class="fl-1 ta-center">
					<input type="text" size="5" data-type="reaction-modifier" class="ta-center" placeholder="±x" title="Modificateur de réaction">
				</div>
				<button class="nude">🎲</button>
			</form>
		</fieldset>

		<!-- dégâts et localisation -->
		<fieldset data-name="widget-damage-location">
			<legend>Dégâts et localisation</legend>
			<form class="flex-s gap-½ ai-first-baseline" id="weapon-damage-widget">
				<input type="text" style="width: 5ch" data-type="strength" class="ta-center" placeholder="For" title="For de l’attaquant">
				<input type="text" style="width: 5ch" data-type="weapon-code" class="ta-center" placeholder="Code" title="Code dégâts de l’arme">
				<select id="as-mains" class="fl-1" data-type="hands" title="Préciser le maniement de l’arme">
					<option value="1M">1 main</option>
					<option value="2M-opt">2 mains opt.</option>
					<option value="2M">2 mains</option>
				</select>
				<div class="fw-500 ta-center">ou</div>
				<input type="text" style="width: 5ch" data-type="dice-code" class="ta-center" placeholder="xd±y" title="Expression des dégâts de type xd(y)(+-/* z)">
				<button class="nude">🎲</button>
			</form>
		</fieldset>

		<!-- critiques & maladresses -->
		<fieldset data-name="widget-criticals">
			<legend>Critiques &amp; maladresses</legend>
			<form class="flex-s gap-½" id="critical-widget">
				<select class="fl-1 px-1" data-type="critical-categories">
					<option value="attack_success">Réussite critique en attaque</option>
					<option value="contact_weapon_miss">Échec critique arme de contact</option>
					<option value="missile_weapon_miss">Échec critique arme à projectiles</option>
					<option value="throwing_weapon_miss">Échec critique arme de jet</option>
					<option value="movement_miss">Échec critique en mouvement</option>
					<option value="spell_miss">Échec critique en magie</option>
				</select>
				<button class="nude">🎲</button>
			</form>
		</fieldset>

		<!-- rafale -->
		<fieldset data-name="widget-burst" hidden>
			<legend>Tir en rafale</legend>
			<form class="flex-s gap-½" id="burst-widget">
				<div class="flex-s gap-½ fl-1 jc-space-between">
					<input type="text" class="fl-1 ta-center" data-type="rcl" placeholder="Rcl" title="Rcl de l’arme">
					<input type="text" class="fl-1 ta-center" data-type="fired-bullets" placeholder="Balles" title="Nombre de balles tirées">
					<input type="text" class="fl-1 ta-center" data-type="mr" placeholder="MR" title="Marge de réussite du tir">
					<input type="text" class="fl-1 ta-center" data-type="damage-dices" placeholder="xd±y" title="Dégâts de chaque balle">
				</div>
				<button class="nude">🎲</button>
			</form>
		</fieldset>

		<!-- État général -->
		<fieldset data-name="general-health-state" hidden>
			<legend>État général &amp; PdV</legend>
			<form class="flex-s gap-½" id="general-state-widget">
				<select class="fl-1" data-type="name-selector">
					<?php for ($i = 1; $i <= $nbre_protagonistes; $i++) { ?>
						<option value="<?= $i ?>">Protagoniste <?= $i ?></option>
					<?php } ?>
				</select>
				<button class="nude">🎲</button>
			</form>
		</fieldset>

		<!-- Effet blessure -->
		<fieldset data-name="wound-effect" hidden>
			<legend>Effets d’une blessure</legend>
			<form class="flex-s gap-½ ai-center">

				<div class="fl-1">
					<div class="flex-s gap-½">
						<select class="fl-1" data-type="name-selector">
							<?php for ($i = 1; $i <= $nbre_protagonistes; $i++) { ?>
								<option value="<?= $i ?>">Protagoniste <?= $i ?></option>
							<?php } ?>
						</select>
						<input type="text" style="width: 6ch" class="ta-center" data-type="raw-dmg" placeholder="xd±y" title="Dégâts bruts">
						<input type="text" style="width: 6ch" class="ta-center" data-type="rd" placeholder="RD" title="RD localisation">
					</div>

					<div class="mt-½ flex-s gap-½">
						<select class="fl-1" data-type="dmg-type" style="width: 6ch">
							<option value="br">Broyage</option>
							<option value="tr" selected>Tranchant</option>
							<option value="pe">Perforant</option>
							<option value="mn">Mains nues</option>
							<option value="b1">Balle</option>
							<option value="b0">Balle (–)</option>
							<option value="b2">Balle (+)</option>
							<option value="b3">Balle (++)</option>
							<option value="exp">Explosion</option>
						</select>
						<select class="fl-1" data-type="bullet-type" disabled style="width: 6ch">
							<option value="std">standard</option>
							<option value="bpa">perce-armure</option>
							<option value="bpc">pointe creuse</option>
						</select>
						<select class="fl-1" data-type="localisation" style="width: 6ch">
							<option value="torse">Torse</option>
							<option value="coeur">Cœur</option>
							<option value="crane">Crâne</option>
							<option value="visage">Visage</option>
							<option value="cou">Cou</option>
							<option value="jambe">Jambe</option>
							<option value="bras">Bras</option>
							<option value="pied">Pied</option>
							<option value="main">Main</option>
							<option value="oeil">Œil</option>
							<option value="org_gen">Org. gén.</option>
						</select>
					</div>
				</div>

				<button class="nude">🎲</button>
			</form>
		</fieldset>

	</div>

	<div class="widgets-column">

		<!-- Explosion -->
		<fieldset data-name="explosion" hidden>
			<legend>Explosions</legend>
			<form class="flex-s gap-½" id="explosion-widget">
				<div class="fl-1">
					<div class="flex-s gap-½ ai-center">
						<input type="text" data-type="explosion-dmg" class="ta-center fl-1" placeholder="xd±y" title="Dégâts de l’explosion">
						<input type="text" data-type="explosion-distance" class="ta-center fl-1" placeholder="Distance" title="Distance de la cible : interne (i), recouvert (r), contact (c) ou distance en mètres.">
						<input type="text" data-type="explosion-frag-surface" class="ta-center fl-1" placeholder="S. fragments" title="Surface cible exposée aux fragments (un homme de face offre une surface de 0,75 m²)">
						<input type="checkbox" data-type="explosion-frag-device" title="Engin explosif à fragmentation ?">
					</div>
				</div>
				<button class="nude">🎲</button>
			</form>
		</fieldset>

		<!-- dégâts objets -->
		<fieldset data-name="object-damages" hidden>
			<legend>Dégâts aux objets</legend>
			<form class="flex-s gap-½" id="object-damages-widget">
				<div class="fl-1">
					<div class="flex-s gap-½">
						<input type="text" data-type="object-damages-pdsm" class="ta-center fl-1" placeholder="PdSm" title="Pts de structure maxi de l’objet">
						<input type="text" data-type="object-damages-pds" class="ta-center fl-1" placeholder="PdS" title="Pts de structure actuels de l’objet">
						<input type="text" data-type="object-damages-integrite" class="ta-center fl-1" placeholder="Intég." title="Intégrité de l’objet">
						<input type="text" data-type="object-damages-rd" class="ta-center fl-1" placeholder="RD" title="RD de l’objet">
						<input type="text" data-type="object-damages-damages-code" class="ta-center fl-1" placeholder="xd±y" title="Dégâts infligés à l’objet">
					</div>
					<div class="flex-s mt-½ gap-½">
						<select class="fl-1" data-type="object-damages-damages-type" title="Type de dégâts">
							<option value="normaux">Normaux</option>
							<option value="tres-localises">Localisés</option>
						</select>
						<select class="fl-1" data-type="object-damages-object-type" title="Type d’objet">
							<?php foreach (ObjectController::object_types as $index => $object) { ?>
								<option><?= ucfirst($index) ?></option>
							<?php } ?>
						</select>

						<select class="fl-1" data-type="object-damages-localisation-options" title="localisation des dégâts">
							<?php foreach (ObjectController::object_types["voiture"]["localisations"] as $index => $object) { ?>
								<option><?= ucfirst($index) ?></option>
							<?php } ?>
						</select>

					</div>
				</div>
				<button class="nude">🎲</button>
			</form>
		</fieldset>

		<!-- Collision véhicule -->
		<fieldset data-name="vehicle-collision" hidden>
			<legend>Collision de véhicules</legend>
			<form class="flex-s gap-½" id="vehicle-collision-widget">
				<div class="fl-1 flex-s gap-½">
					<select class="fl-1" data-type="vehicle-collision-severity">
						<option value="1">Très Légère</option>
						<option value="2">Légère</option>
						<option value="3">Moyenne</option>
						<option value="4">Grave</option>
						<option value="5">Extrême</option>
					</select>
					<input type="text" size="4" data-type="vehicle-collision-pdsm" class="ta-center" placeholder="PdSm" />
				</div>
				<button class="nude">🎲</button>
			</form>
		</fieldset>

		<!-- Generate NPC -->
		 <fieldset data-name="npc-generator" hidden >
			<legend>Générer un PNJ</legend>
			<form class="flex-s gap-½">
				<div class="fl-1 flex-s gap-½">
					<select class="fl-1" data-type="gender">
						<option value="male">Masculin</option>
						<option value="female">Féminin</option>
					</select>
					<select class="fl-1" data-type="region" title="Région d’origine">
						<option value="artaille">Artaille</option>
						<option value="french">Français</option>
					</select>
					<select class="fl-1" data-type="profile" title="profil du PNJ">
						<option value="default">Standard</option>
						<option value="warrior">Guerrier</option>
					</select>
				</div>
				<button class="nude">🎲</button>
			</form>

		 </fieldset>

	</div>

</div>

<sidebar id="chat-container">

	<div id="connected-users">
		<?php if (!$_SESSION["id"]) { ?>
			<div class="ta-center italic">Vous n’êtes pas connecté</div>
		<?php } ?>
	</div>

	<button id="chat-help-dialog-btn" class="ff-far btn-primary px-½ py-¼" data-role="open-dialog" data-dialog-name="chat-help" title="mode d’emploi de la fenêtre de chat">&#xf059;</button>

	<div id="chat-dialog-wrapper" class="flow">
		<?php if (!$_SESSION["id"]) { ?>
			<p class="ta-center fw-700"> Les résultats des widgets s’affichent ici</p>
		<?php } ?>
	</div>

	<div id="chat-input-wrapper" data-id="<?= $_SESSION["id"] ?>" data-login="<?= $_SESSION["login"] ?>" data-key="<?= $_SESSION["id"] ? WS_KEY : "0" ?>">

		<div class="flex-s fl-wrap gap-¼ fs-500 jc-center desktop" data-role="emojis-wrapper">
			<button data-role="emoji-button" class="nude">😊</button>
			<button data-role="emoji-button" class="nude">😁</button>
			<button data-role="emoji-button" class="nude">😄</button>
			<button data-role="emoji-button" class="nude">😅</button>
			<button data-role="emoji-button" class="nude">😉</button>
			<button data-role="emoji-button" class="nude">😎</button>
			<button data-role="emoji-button" class="nude">😏</button>
			<button data-role="emoji-button" class="nude">😐</button>
			<button data-role="emoji-button" class="nude">😑</button>
			<button data-role="emoji-button" class="nude">😕</button>
			<button data-role="emoji-button" class="nude">😔</button>
			<button data-role="emoji-button" class="nude">😇</button>
			<button data-role="emoji-button" class="nude">😘</button>
			<button data-role="emoji-button" class="nude">😜</button>
			<button data-role="emoji-button" class="nude">😮</button>
			<button data-role="emoji-button" class="nude">🙄</button>
			<button data-role="emoji-button" class="nude">😱</button>
			<button data-role="emoji-button" class="nude">😈</button>
			<button data-role="emoji-button" class="nude">🃏</button>
			<button data-role="emoji-button" class="nude">🖕</button>
			<button data-role="emoji-button" class="nude">💩</button>
		</div>

		<textarea id="msg-input"></textarea>

	</div>

</sidebar>

<dialog data-name="chat-help">
	<button data-role="close-modal" class="ff-fas">&#xf00d;</button>
	<h4>Fonctionnalités du tchat</h4>
	<ul class="mt-1 flow">
		<li><b>Message privé&nbsp;:</b> "/" + n° du ou des destinataire(s), séparés par une virgule et <i>sans espace</i> – ex. «&nbsp;/2,3 Coucou&nbsp;»</li>
		<li><b>Jet privé&nbsp;:</b> même principe que pour les messages privés. Entrez /x,y pour spécifier les destinataires, puis utilisez le widget de votre choix.</li>
		<li><b>Jet de réussite dans un message&nbsp;:</b> insérez dans votre message un score précédé du signe #. Un jet sera fait, avec affichage de la MR et d’un éventuel critique – ex. «&nbsp;Blabla #12 blabla.&nbsp;»</li>
		<li><b>Jet classique dans un message&nbsp;:</b> insérez dans votre message une expression correspondant à un jet, précédée du signe #. Ex. «&nbsp;bla bla #2d+1&nbsp;». Il est possible de mélanger jets de réussite et jets classiques – ex. «&nbsp;Blabla #12 et blibli #1d+2&nbsp;»</li>
		<li><b>Mise en forme du message&nbsp;:</b> des mots entre astérisques (*) seront affichés en gras. Des mots entre underscores (_) seront affichés en italique.</li>
		<li><b>Retour à la ligne&nbsp;:</b> vous pouvez insérer un retour à la ligne dans un message en faisant <key>Shift + Entrée</key>
		</li>
	</ul>
</dialog>

<dialog data-name="widgets-help">
	<button data-role="close-modal" class="ff-fas">&#xf00d;</button>

	<h4>Paramètres de l’espace widgets</h4>

	<h5 class="mt-1">Widgets à afficher</h5>

	<div class="mt-½" data-role="widget-choices" style="column-count: 2; column-gap: 1em">
		<template>
			<label class="mt-¼" style="display: block;">
				<input type="checkbox" data-role="show-widget" data-name="{widget-name}">
				<span>{widget title}</span>
			</label>
		</template>
	</div>

</dialog>

<script type="module" src="/scripts/game-table<?= PRODUCTION ? ".min" : "" ?>.js?v=<?= VERSION ?>" defer></script>