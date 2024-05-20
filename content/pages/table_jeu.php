<?php

use \App\Rules\ObjectController;

$nbre_protagonistes = 7;
?>

<div id="widgets-container">

	<div class="widgets-column">

		<!-- jet de dés simple -->
		<fieldset>
			<legend>Jet de dés simple</legend>
			<form class="flex-s ai-flex-between" id="simple-dice-widget">
				<div class="fl-1 ta-center">
					<input type="text" size="5" data-type="dice-expression" class="ta-center" placeholder="xd±y" value="3d" title="xd(y)(+-/* z)">
				</div>
				<button class="nude">🎲</button>
			</form>
		</fieldset>

		<!-- test caractéristique / compétence -->
		<fieldset>
			<legend>Jets de réussite</legend>
			<?php for ($i = 1; $i <= 7; $i++) { ?>
				<form data-role="score-tester" class="flex-s gap-½ mt-¼">
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

		<!-- dégâts et localisation -->
		<fieldset>
			<legend>Dégâts et localisation</legend>
			<form class="flex-s gap-½ ai-first-baseline" id="weapon-damage-widget">
				<input type="text" style="width: 5ch" data-type="strength" class="ta-center" placeholder="For" title="For de l’attaquant"><!-- style="width: 6ch" -->
				<input type="text" style="width: 6ch" data-type="weapon-code" class="ta-center" placeholder="Code" title="Code dégâts de l’arme"><!-- style="width: 8ch" -->
				<select id="as-mains" style="width: 12ch" data-type="hands" title="Préciser le maniement de l’arme">
					<option value="1M">1 main</option>
					<option value="2M-opt">2 mains opt.</option>
					<option value="2M">2 mains</option>
				</select>
				<div class="fl-1 fw-500 ta-center">ou</div>
				<input type="text" style="width: 6ch" data-type="dice-code" class="ta-center" placeholder="xd±y" title="Expression des dégâts de type xd(y)(+-/* z)">
				<button class="nude">🎲</button>
			</form>
		</fieldset>

		<!-- critiques & maladresses -->
		<fieldset>
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
		<fieldset>
			<legend>Tir en rafale</legend>
			<form class="flex-s gap-½" id="burst-widget">
				<div class="flex-s gap-½ fl-1 jc-space-between">
					<input type="text" style="width: 8ch" class="ta-center" data-type="rcl" placeholder="Rcl" title="Rcl de l’arme">
					<input type="text" style="width: 8ch" class="ta-center" data-type="fired-bullets" placeholder="Balles" title="Nombre de balles tirées">
					<input type="text" style="width: 8ch" class="ta-center" data-type="mr" placeholder="MR" title="Marge de réussite du tir">
					<input type="text" style="width: 8ch" class="ta-center" data-type="damage-dices" placeholder="xd±y" title="Dégâts de chaque balle">
				</div>
				<button class="nude">🎲</button>
			</form>
		</fieldset>

	</div>

	<div class="widgets-column desktop">
		<!-- Protagonistes -->
		<fieldset>
			<legend>Protagonistes</legend>

			<?php for ($i = 1; $i <= $nbre_protagonistes; $i++) { ?>
				<div class="mt-1" data-role="opponent-wrapper" data-opponent="<?= $i ?>">
					<div class="flex-s gap-½">
						<input type="text" class="fl-1" data-type="name" placeholder="Nom" value="<?= $i === 0 ? "Mr Test" : "" ?>">
						<input type="text" style="width: 6ch" data-type="dex" class="ta-center" placeholder="Dex" title="Dextérité" value="<?= $i === 0 ? 11 : "" ?>">
						<input type="text" style="width: 6ch" data-type="san" class="ta-center" placeholder="San" title="Santé" value="<?= $i === 0 ? 12 : "" ?>">
						<input type="text" style="width: 6ch" data-type="pain-resistance" class="ta-center" placeholder="Doul." title="Résistance à la douleur (-1, 0, 1)">
					</div>
					<div class="flex-s gap-½ mt-½">
						<input type="text" style="width: 6ch" data-type="pdvm" class="ta-center" placeholder="PdVm" title="PdV maxi" value="<?= $i === 0 ? 12 : "" ?>">
						<input type="text" style="width: 6ch" data-type="pdv" class="ta-center" placeholder="PdV" title="PdV actuels" value="<?= $i === 0 ? 12 : "" ?>">
						<input type="text" class="fl-1" data-type="members" placeholder="Blessures membres" title="Par exemple BD 2, PG 1">
					</div>
				</div>
			<?php } ?>

		</fieldset>
	</div>

	<div class="widgets-column desktop">

		<!-- État général -->
		<fieldset>
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
		<fieldset>
			<legend>Effets d’une blessure</legend>
			<form class="flex-s gap-½ ai-center" id="wound-effect-widget">

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
						<select class="fl-1" data-type="dmg-type">
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
						<select class="fl-1" data-type="bullet-type" disabled>
							<option value="std">standard</option>
							<option value="bpa">perce-armure</option>
							<option value="bpc">pointe creuse</option>
						</select>
						<select class="fl-1" data-type="localisation">
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

		<!-- Explosion -->
		<fieldset>
			<legend>Explosions</legend>
			<form class="flex-s gap-½" id="explosion-widget">
				<div class="fl-1">
					<div class="flex-s gap-½ ai-center">
						<input type="text" size="1" data-type="explosion-dmg" class="ta-center fl-1" placeholder="xd±y" title="Dégâts de l’explosion">
						<input type="text" size="1" data-type="explosion-distance" class="ta-center fl-1" placeholder="Distance" title="Distance de la cible (I, R, C ou valeur en m)">
						<input type="text" size="1" data-type="explosion-frag-surface" class="ta-center fl-1" placeholder="S. fragments" title="Surface cible exposée aux fragments">
						<input type="checkbox" data-type="explosion-frag-device" title="Engin explosif à fragmentation ?" />
					</div>
				</div>
				<button class="nude">🎲</button>
			</form>
			<p class="clr-white mt-½ fs-300">
				<b>Distance&nbsp;:</b> interne (i), recouvert (r), contact (c) ou distance en mètres.<br>
				<b>Surface exposée aux fragments&nbsp;:</b> un homme de face offre une surface de 0,75 m².
			</p>
		</fieldset>

		<!-- dégâts objets -->
		<fieldset>
			<legend>Dégâts aux objets</legend>
			<form class="flex-s gap-½" id="object-damages-widget">
				<div class="fl-1">
					<div class="flex-s gap-½">
						<input type="text" size="1" data-type="object-damages-pdsm" class="ta-center fl-1" placeholder="PdSm" title="Pts de structure maxi de l’objet" />
						<input type="text" size="1" data-type="object-damages-pds" class="ta-center fl-1" placeholder="PdS" title="Pts de structure actuels de l’objet" />
						<input type="text" size="1" data-type="object-damages-integrite" class="ta-center fl-1" placeholder="Intég." title="Intégrité de l’objet" />
						<input type="text" size="1" data-type="object-damages-rd" class="ta-center fl-1" placeholder="RD" title="RD de l’objet" />
						<input type="text" size="1" data-type="object-damages-damages-code" class="ta-center fl-1" placeholder="xd±y" title="Dégâts infligés à l’objet" />
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
		<fieldset>
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

	</div>

</div>

<sidebar id="chat-container">

	<div id="connected-users" class="color1">
		<?php if (!$_SESSION["id"]) { ?>
			<div class="ta-center italic">Vous n’êtes pas connecté</div>
		<?php } ?>
	</div>

	<div id="chat-dialog-wrapper" class="flow">
		<?php if ($_SESSION["id"]) { ?>
			<p><b>Message privé&nbsp;:</b> "/" + n° destinataire(s) séparés par virgule – ex. "/2,3 Coucou"</p>
		<?php } else { ?>
			<p class="ta-center fw-700"> Les résultats des widgets s’affichent ici</p>
		<?php } ?>
	</div>

	<div id="chat-input-wrapper" data-id="<?= $_SESSION["id"] ?>" data-login="<?= $_SESSION["login"] ?>" data-key="<?= $_SESSION["id"] ? "a78D_Kj!45" : "0" ?>">

		<div class="flex-s fl-wrap gap-½ fs-500 jc-center" data-role="emojis-wrapper">
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

		<textarea id="msg-input" <?= !$_SESSION["id"] ? "disabled" : "" ?>></textarea>

	</div>

</sidebar>

<script type="module" src="/scripts/game-table.js?v=<?= VERSION ?>"></script>