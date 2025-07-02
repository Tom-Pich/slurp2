<?php

use \App\Rules\ObjectController;

?>

<!-- Protagonistes -->
<fieldset data-name="opponents" hidden>
	<legend class="flex-s gap-1 ai-center">
		Protagonistes
		<div class="flex-s gap-½">
			<button class="nude ff-fas" data-role="open-dialog" data-dialog-name="opponents-dialog" title="mode d’emploi">&#xf059;</button>
			<!-- <button class="nude ff-fas" data-role="set-opponent-number" value="1">&#xf055;</button>
			<button class="nude ff-fas" data-role="set-opponent-number" value="-1">&#xf056;</button> -->
		</div>
	</legend>
	<div class="flex gap-½ fl-column" data-role="opponents-wrapper"><!-- Filled with JS --></div>

	<template>
		<div class="flex-s gap-¼ fl-1" data-role="opponent-wrapper">
			<div class="px-½ bg-black flex-s jc-center ai-center clr-white fw-700" data-role="opponent-number"></div>
			<div class="fl-1">
				<div class="flex-s gap-¼">
					<input type="text" class="fl-1" name="name" placeholder="Nom" title="Nom du protagoniste">
					<select name="category" style="width: 7ch" title="Catégorie – voir l’aide">
						<option value="std">std</option>
						<option value="nbh">nbh</option>
						<option value="nbx">nbx</option>
						<option value="ins">ins</option>
						<option value="ci">ci</option>
					</select>
					<input type="text" name="dex" class="ta-center" placeholder="Dex" title="Dextérité">
					<input type="text" name="san" class="ta-center" placeholder="San" title="Santé">
					<input type="text" name="pain-resistance" class="ta-center" placeholder="Doul." title="Résistance à la douleur (-1, 0, 1)">
				</div>
				<div class="flex-s gap-¼ mt-¼">
					<input type="text" name="pdvm" class="ta-center" placeholder="PdVm" title="PdV maxi" style="width: 6ch">
					<input type="text" name="pdv" class="ta-center" placeholder="PdV" title="PdV actuels">
					<input type="text" class="fl-1" name="members" placeholder="Blessures membres" title="Blessures aux membres – par exemple BD 2, PG 1">
				</div>
			</div>
		</div>
	</template>

</fieldset>
<dialog data-name="opponents-dialog">
	<button data-role="close-modal" class="ff-fas">&#xf00d;</button>
	<h4>Widget Protagonistes</h4>
	<div class="mt-1 flow">
		<p>Pour pouvoir utiliser les widgets <i>État général et PdV</i>, <i>Effets d’une blessure</i> et <i>Hémorragie</i>, il est nécessaire de remplir au moins une entrée protagoniste. Ces widgets se servent des caractéristiques des protagonistes.</p>
		<p><b>Catégorie&nbsp;:</b> sélectionner la «&nbsp;catégorie&nbsp;» du protagoniste. Les effets des blessures en dépendent.</p>
		<ul>
			<li><b>std&nbsp;:</b> standard – le protagoniste est une créature biologique de type mammifère/reptile. Les règles standard des blessures s’appliquent.</li>
			<li><b>nbh&nbsp;:</b> non biologique humanoïde – ces créatures sont insensibles à la douleur, n’ont pas d’organes vitaux, et meurent à 0 PdV. Elles ont cependant une sensibilité accrue à la tête. Exemple typique&nbsp;: zombie.</li>
			<li><b>nbx&nbsp;:</b> non biologique quelconque – comme « nbh », sauf que ces créatures n’ont pas de tête, ou bien la tête n’a pas de rôle particulier dans le fonctionnement de la créature.</li>
			<li><b>ins&nbsp;:</b> ange ou démon <i>In Nomine</i> – mêmes règles que les créatures standard, sauf que leur PdV doublés n’ont pas d’influence sur le recul causé par des dégâts bruts.</li>
			<li><b>ci&nbsp;:</b> créatures insectoïde – ces créatures possèdent 6 pattes (ou plus) et sont très résistantes à la douleur.</li>
		</ul>
		<p><b>Résistance à la douleur&nbsp;:</b> -1 pour <i>Douillet</i> ou 1 pour <i>Résistance à la douleur</i>. Sinon, mettre 0 ou laisser vide.</p>
		<p><b>Blessure membres&nbsp;:</b> Mettre la première lettre du membre (Bras, Main, Jambe, Pied) et la première lettre du côté (Droit ou Gauche), puis indiquer les dégâts reçus. Séparer les différents membres par une virgule. Exemple&nbsp;: MD 1, BD 3 signifie une blessure de 1 pt à la main droite et une blessure de 3 points au bras droit.</p>

		<p><b>Pour supprimer</b> un protagoniste, effacer son nom.</p>
	</div>
</dialog>

<!-- test caractéristique / compétence -->
<fieldset data-name="scores-tester" hidden>
	<legend class="flex-s gap-1 ai-center">
		Jets de réussite
		<div class="flex-s gap-½">
			<button class="nude ff-fas" data-role="sort-scores">&#xf15d;</button>
		</div>
	</legend>
	<div class="flex gap-½ fl-column" data-role="scores-wrapper"><!-- Filled with JS --></div>
	<template>
		<form class="flex-s gap-½">
			<input type="text" class="fl-1" name="name" placeholder="Comp. ou carac." list="liste-carac-comp">
			<datalist>
				<option value="Force"></option>
				<option value="Dextérité"></option>
				<option value="Intelligence"></option>
				<option value="Santé"></option>
				<option value="Perception"></option>
				<option value="Volonté"></option>
				<option value="Réflexes"></option>
				<option value="Esquive"></option>
				<option value="Hache/Masse"></option>
				<option value="Épée"></option>
				<option value="Arc"></option>
				<option value="Arbalète"></option>
				<option value="Combat à mains nues"></option>
				<option value="Culture générale"></option>
				<option value="Furtivité"></option>
			</datalist>
			<input type="text" name="score" style="width: 6ch" class="ta-center" placeholder="score" title="score">
			<input type="text" name="modif" style="width: 6ch" class="ta-center" placeholder="±" title="Modif (vide = zéro)">
			<button class="nude">🎲</button>
		</form>
	</template>
</fieldset>

<!-- jet de dés simple -->
<fieldset data-name="simple-roll" hidden>
	<legend>Jet de dés simple</legend>
	<form class="flex-s">
		<div class="fl-1 ta-center">
			<input type="text" name="expression" class="ta-center" placeholder="xd±y" value="3d" title="xd(y)(+-/* z)" required style="width: 8ch">
		</div>
		<button class="nude">🎲</button>
	</form>
</fieldset>

<!-- Compteur de round -->
<fieldset data-name="round-counter" hidden>
	<legend>Compteur de round</legend>
	<form class="flex-s gap-½">
		<div class="flex-s gap-½ fl-1">
			<input type="text" name="round" class="ta-center" placeholder="round" title="N° du round" value="1">
			<input type="text" name="comment" class="fl-1" placeholder="Ordre initiative" title="Entrez le n° des opposants dans l’ordre d’initiative ou bien un texte simple">
		</div>
		<button class="nude">🎲</button>
	</form>
</fieldset>

<!-- dégâts et localisation -->
<fieldset data-name="widget-damage-location">
	<legend>Dégâts et localisation</legend>
	<form class="flex-s gap-½ ai-center">
		<input type="text" name="strength" class="ta-center" placeholder="For" title="For de l’attaquant">
		<input type="text" name="code" class="ta-center" placeholder="t/e" title="Code dégâts de l’arme">
		<select id="as-mains" class="fl-1" name="hands" title="Préciser le maniement de l’arme">
			<option value="1M">1 main</option>
			<option value="2M-opt">2 mains opt.</option>
			<option value="2M">2 mains</option>
		</select>
		<div class="fw-700 ta-center">ou</div>
		<input type="text" style="width: 7ch" name="expression" class="ta-center" placeholder="xd±y" title="Expression type xd(y)(+-/* z)">
		<button class="nude">🎲</button>
	</form>
</fieldset>

<!-- critiques & maladresses -->
<fieldset data-name="widget-criticals">
	<legend>Critiques &amp; maladresses</legend>
	<form class="flex-s gap-½" id="critical-widget">
		<select class="fl-1 px-1" name="category">
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
	<form class="flex-s gap-½">
		<div class="flex-s gap-½ fl-1 jc-space-between">
			<input type="text" class="fl-1 ta-center" name="rcl" placeholder="Rcl" title="Rcl de l’arme" required>
			<input type="text" class="fl-1 ta-center" name="bullets" placeholder="Balles" title="Nombre de balles tirées" required>
			<input type="text" class="fl-1 ta-center" name="mr" placeholder="MR" title="Marge de réussite du tir" required>
			<input type="text" class="fl-1 ta-center" name="expression" placeholder="xd±y" title="Dégâts de chaque balle" required>
			<input type="checkbox" name="localisation" title="Préciser localisation ?" checked>
		</div>
		<button class="nude">🎲</button>
	</form>
</fieldset>

<!-- Test de frayeur -->
<fieldset data-name="fright-check" hidden>
	<legend>Test de frayeur</legend>
	<form class="flex-s gap-½">
		<div class="fl-1">
			<div class="flex-s gap-½ ai-center">
				<select name="fright-level" title="Intensité de la peur" class="fl-1">
					<option value="1">niv. I</option>
					<option value="2">niv. II</option>
					<option value="3">niv. III</option>
					<option value="4">niv. IV</option>
					<option value="5">niv. V</option>
				</select>
				<input type="text" style="width: 6ch" class="ta-center" name="sf-score" placeholder="S.-F." title="score de Sang-Froid" required>
				<input type="text" style="width: 6ch" class="ta-center" name="sf-modif" placeholder="±" title="Modificateur">
				<input type="text" style="width: 6ch" class="ta-center" name="san-score" placeholder="San" title="Score de Santé" required>
			</div>
		</div>
		<button class="nude">🎲</button>
	</form>

</fieldset>

<!-- État général -->
<fieldset data-name="general-health-state" hidden>
	<legend>État général &amp; PdV</legend>
	<form class="flex-s gap-½" id="general-state-widget">
		<select class="fl-1" name="opponent-selector" title="Sélectionner un protagoniste"><!-- filled with JS --></select>
		<button class="nude">🎲</button>
	</form>
</fieldset>

<!-- Effet blessure -->
<fieldset data-name="wound-effect" hidden>
	<legend>Effets d’une blessure</legend>
	<form class="flex-s gap-½ ai-center">

		<div class="fl-1">
			<div class="flex-s gap-½">
				<select class="fl-1" name="opponent-selector" title="Sélectionner un protagoniste"><!-- filled with JS --></select>
				<input type="text" style="width: 6ch" class="ta-center" name="raw-dmg" placeholder="xd±y" title="Dégâts bruts">
				<input type="text" style="width: 6ch" class="ta-center" name="rd" placeholder="RD" title="RD localisation">
			</div>

			<div class="mt-½ flex-s gap-½">
				<select class="fl-1" name="dmg-type" style="width: 6ch">
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
				<select class="fl-1" name="bullet-type" disabled style="width: 6ch">
					<option value="std">standard</option>
					<option value="bpa">perce-armure</option>
					<option value="bpc">pointe creuse</option>
				</select>
				<select class="fl-1" name="localisation" style="width: 6ch">
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

<!-- Hémorragie -->
<fieldset data-name="bleeding-widget">
	<legend>Hémorragie</legend>
	<form class="flex-s gap-½">
		<select class="fl-1" name="opponent-selector" title="Sélectionner un protagoniste"><!-- filled with JS --></select>
		<select class="fl-1" name="severity">
			<option value="0">Moyenne</option>
			<option value="1">Grave</option>
			<option value="2">Très grave</option>
		</select>
		<input type="text" class="ta-center" name="modif" placeholder="±" title="Modificateurs de San">
		<button class="nude">🎲</button>
	</form>
</fieldset>

<!-- Explosion -->
<fieldset data-name="explosion-widget" hidden>
	<legend>Explosions</legend>
	<form class="flex-s gap-½">
		<div class="fl-1">
			<div class="flex-s gap-½ ai-center">
				<input type="text" name="explosion-dmg" class="ta-center fl-1" placeholder="xd±y" title="Dégâts de l’explosion" required>
				<input type="text" name="distance" class="ta-center fl-1" placeholder="Distance" title="Distance de la cible : interne (i), recouvert (r), contact (c) ou distance en mètres." required>
				<input type="text" name="fragmentation-surface" class="ta-center fl-1" placeholder="Surface" title="Surface cible exposée aux fragments (homme de face → 0,75 m²)" required>
				<input type="checkbox" name="is-fragmentation-device" title="Engin explosif à fragmentation ?">
			</div>
		</div>
		<button class="nude">🎲</button>
	</form>
</fieldset>

<!-- Dégâts objets -->
<fieldset data-name="object-damages" hidden>
	<legend>Dégâts aux objets</legend>
	<form class="flex-s gap-½" id="object-damages-widget">
		<div class="fl-1">
			<div class="flex-s gap-½">
				<input type="text" name="pdsm" class="ta-center fl-1" placeholder="PdSm" title="Pts de structure maxi de l’objet" required>
				<input type="text" name="pds" class="ta-center fl-1" placeholder="PdS" title="Pts de structure actuels de l’objet">
				<input type="text" name="integrite" class="ta-center fl-1" placeholder="Intég." title="Intégrité de l’objet" required>
				<input type="text" name="rd" class="ta-center fl-1" placeholder="RD" title="RD de l’objet" required>
				<input type="text" name="dmg-code" class="ta-center fl-1" placeholder="xd±y" title="Dégâts infligés à l’objet" required>
			</div>
			<div class="flex-s mt-½ gap-½">
				<select class="fl-1" name="dmg-type" title="Type de dégâts">
					<option value="normaux">Normaux</option>
					<option value="localises">Localisés</option>
				</select>
				<select class="fl-1" name="object-type" title="Type d’objet">
					<?php foreach (ObjectController::object_types as $index => $object) { ?>
						<option><?= ucfirst($index) ?></option>
					<?php } ?>
				</select>

				<select class="fl-1" name="localisation" title="localisation des dégâts">
					<?php foreach (ObjectController::object_types["générique"]["localisations"] as $index => $object) { ?>
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
	<form class="flex-s gap-½">
		<div class="fl-1 flex-s gap-½">
			<select class="fl-1" name="severity">
				<option value="1">Très Légère</option>
				<option value="2">Légère</option>
				<option value="3">Moyenne</option>
				<option value="4">Grave</option>
				<option value="5">Extrême</option>
			</select>
			<input type="text" name="pdsm" class="ta-center" placeholder="PdSm" style="width: 6ch;" required />
		</div>
		<button class="nude">🎲</button>
	</form>
</fieldset>

<!-- Générateur PNJ -->
<fieldset data-name="npc-generator" hidden>
	<legend>Générer un PNJ</legend>
	<form class="flex-s gap-½">
		<div class="fl-1 flex-s gap-½">
			<select class="fl-1" name="gender">
				<option value="male">Masculin</option>
				<option value="female">Féminin</option>
			</select>
			<select class="fl-1" name="region" title="Région d’origine">
				<option value="artaille">Artaille</option>
				<option value="lauria">Lauria</option>
				<option value="french">Français</option>
				<option value="taol-kaer">Taol Kaer</option>
			</select>
			<select class="fl-1" name="profile" title="profil du PNJ">
				<option value="standard">Standard</option>
				<option value="warrior">Guerrier</option>
			</select>
			<input type="checkbox" name="name-only" title="seulement un nom">
		</div>
		<button class="nude">🎲</button>
	</form>
</fieldset>

<!-- Jet de réaction -->
<fieldset data-name="widget-reaction" hidden>
	<legend>Jet de réaction</legend>
	<form class="flex-s">
		<div class="fl-1 ta-center">
			<input type="text" name="modifier" class="ta-center" placeholder="±x" title="Modificateur de réaction">
		</div>
		<button class="nude">🎲</button>
	</form>
</fieldset>


<!-- Générateur de trucs divers -->
<fieldset data-name="wild-generator" hidden>
	<legend>Générer un truc</legend>
	<form class="flex-s gap-½">
		<div class="fl-1 flex-s gap-½">
			<select class="fl-1" name="category" required>
				<option value="">--- choisissez une catégorie</option>
				<option value="herbs">Plantes &amp; herbes</option>
				<option value="books">Titre de livre</option>
			</select>
		</div>
		<button class="nude">🎲</button>
	</form>
</fieldset>

<dialog data-name="widgets-help">
	<button data-role="close-modal" class="ff-fas">&#xf00d;</button>

	<h4>Widgets à afficher</h4>

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