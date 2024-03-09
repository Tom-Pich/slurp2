<?php
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
			<legend>État général (PdV)</legend>
			<form class="flex-s gap-½" id="general-state-widget">
				<select class="fl-1 px-1" data-type="name-selector">
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
						<select class="fl-1 px-1" data-type="name-selector">
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
							<option value="org_gen">Org. génitaux</option>
						</select>
					</div>
				</div>

				<button class="nude">🎲</button>
			</form>
		</fieldset>

		<form hidden onsubmit="return false"><!-- dégâts objets -->
			<fieldset>
				<legend>Dégâts aux objets (expérimental)</legend>
				<div class="flex-between">
					<div>
						<div>
							<input type="text" size="3" id="do_pdsm" class="center" placeholder="PdSm" title="Pts de structure maxi de l’objet" />
							<input type="text" size="3" id="do_pds" class="center" placeholder="PdS" title="Pts de structure actuels de l’objet" />
							<input type="text" size="3" id="do_integ" class="center" placeholder="Intég." title="Intégrité de l’objet" />
							<input type="text" size="3" id="do_rd" class="center" placeholder="RD" title="RD de l’objet" />
							<input type="text" size="3" id="do_deg" class="center" placeholder="xd±y" title="Dégâts infligés à l’objet" />
						</div>
						<p>
							<select id="do_type_deg" style="width: 95px" title="Type de dégâts">
								<option value="norm">Normaux</option>
								<option value="tr-loc" selected>Localisés</option>
							</select>
							<select id="do_type_objet" style="width: 80px" title="Type d’objet">
								<option value="0">&nbsp;---</option>
								<option selected>Voiture</option>
								<option>Moto</option>
								<option>Robot</option>
								<option>Quadricoptère</option>
							</select>

							<select id="do_orientation" style="width: 65px" title="localisation des dégâts">
								<option>Avant</option>
								<option>Latéral</option>
								<option>Arrière</option>
							</select>

						</p>
					</div>
					<button class="nude" onclick="calcul_degats_objet()">&#x1F3B2;</button>
				</div>
			</fieldset>
		</form>

		<form hidden onsubmit="return false"><!-- collision véhicule -->
			<fieldset>
				<legend>Collision de véhicule (expérimental)</legend>
				<div class="flex-between">
					<div>
						<select id="collision_gravite" style="width: 100px">
							<option value="1">Très Légère</option>
							<option value="2">Légère</option>
							<option value="3">Moyenne</option>
							<option value="4">Grave</option>
							<option value="5">Extrême</option>
						</select>&emsp;
						<input type="text" size="3" id="collision_pdsm" class="center" placeholder="PdSm" />
					</div>
					<button class="nude" onclick="collision()">&#x1F3B2;</button>
				</div>
			</fieldset>
		</form>

		<form hidden onsubmit="return false"><!-- explosion -->
			<fieldset>
				<legend>Explosions</legend>
				<div class="flex-between">
					<div>
						<span style="display: inline-block; width: 40px">Dégâts</span>
						<input type="text" size="5" id="exp_degats" class="center" placeholder="xd±y" title="Dégâts de référence de l’explosion" />
						Distance
						<input type="text" size="3" id="exp_distance" class="center" placeholder="Dist." title="Distance de la cible" onkeyup="calc_frac_explosion()" />
						<br />
						<span style="display: inline-block; width: 40px">Blast</span>
						<input type="text" size="5" id="exp_surface_blast" class="center" placeholder="Surface" title="Surface de la cible (m²)" onkeyup="calc_frac_explosion()" />
						<span style="display: inline-block; width: 37px; text-align: center"><b>ou</b></span>
						<input type="text" size="5" id="exp_%_blast" class="center" placeholder="%" title="Pourcentage du blast reçu" /> %
						<br />
						<span style="display: inline-block; width: 40px">Frag.</span>
						<input type="text" size="5" id="exp_surface_frag" class="center" placeholder="Surface" title="Surface de la cible (m²)" onkeyup="calc_frac_explosion()" />
						<span style="display: inline-block; width: 37px; text-align: center"><b>ou</b></span>
						<input type="text" size="5" id="exp_%_frag" class="center" placeholder="%" title="Pourcentage des éclats reçus" /> %
						<br />
						<label for="exp_frag">Nombreux éclats</label>
						<input type="checkbox" id="exp_frag" title="Engin explosif à fragmentation ?" />
					</div>
					<button class="nude" onclick="calcul_deg_explosion()">&#x1F3B2;</button>
				</div>
			</fieldset>
		</form>

	</div>

</div>

<sidebar id="chat-container">

	<div id="connected-users" class="color1">
		<?php if(!$_SESSION["id"]){ ?>
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