<?php

use App\Entity\Power;
use App\Rules\WeaponsController;
use App\Repository\AvDesavRepository;
use App\Repository\CreatureRepository;
use App\Repository\SpellRepository;
use App\Rules\ArmorsController;

$avdesav_repo = new AvDesavRepository;
$spells_repo = new SpellRepository;
$creatures_repo = new CreatureRepository;
?>

<article><!-- Personnages -->
	<h2>Personnage</h2>

	<details>
		<summary class="h3">Points de personnage</summary>
		<p><b>Personnage débutant&nbsp;:</b> 120 pts</p>
		<ul>
			<li><b>Caractéristiques&nbsp;:</b> 60 à 90 pts</li>
			<li><b>Avantages &amp; désavantages&nbsp;:</b> -10 à 25 pts</li>
			<li><b>Compétences&nbsp;:</b> 10 à 35 pts</li>
			<li><b>Sorts &amp; pouvoirs&nbsp;:</b> 15 à 20 pts pour un mage ou un prêtre.</li>
		</ul>
	</details>

	<details>
		<summary class="h3">Avantages &amp; Désavantages</summary>
		<p><b>• Alphabétisation&nbsp;:</b> semi-alphabétisation par défaut. <i>Illettrisme</i>&nbsp;: -5 pts&nbsp;; <i>Alphabétisation</i>&nbsp;: 5 pts.</p>
		<p><b>• Magerie&nbsp;:</b> peut être innée jusqu’au niveau 3. Un personnage peut gagner, au cours de sa vie, jusqu’à 2 niveaux. La version «&nbsp;AD&amp;D&nbsp;» de cet avantage coûte 5 pts de moins que le coût standard à cause des pénalités imposées par les armures.</p>
		<p><b>• Richesse de base&nbsp;:</b> 1000 pc pour un aventurier sans attache. Un personnage «&nbsp;installé&nbsp;» (profession et domicile) dispose de 20&nbsp;% de cette somme en argent et des possessions en adéquation avec son niveau de richesse.</p>

		<h4>Avantages &amp; désavantages spécifiques</h4>
		<?php
		$avdesav_list = $avdesav_repo->getAvDesavByCategory("ADD");
		foreach ($avdesav_list as $avdesav) {
			$avdesav->displayInRules(show_edit_link: $_SESSION["Statut"] === 3);
		}
		?>
	</details>

	<details>
		<summary class="h3">Races non humaines</summary>
		<p>Éléments à prendre en compte pour créer un personnage non humain&nbsp;:</p>
		<p>• Caractéristiques<br>
			• Taille&nbsp;: <i>Taille peu pratique</i>, PdV, <i>Vitesse réduite</i>.<br>
			• <i>Résistances</i> et <i>Immunités</i>.<br>
			• Dons pour certaines compétences<br>
			• Pouvoirs innés</p>
	</details>

	<details>
		<summary class="h3">Mages &amp; lanceurs de sorts</summary>

		<h4>Avantages &amp; compétences nécessaires</h4>
		<p>Lancer des sorts nécessite <i>Magerie</i>. Les sorts s’apprennent dans les livres (<i>Alphabétisation</i>) ou avec un professeur. Implique une certaine connaissance des arcanes (<i>Sciences occultes</i>). Les sorts <i>Projectiles</i> nécessitent la compétence <i>Lancer de sorts</i>.</p>

		<h4>Spécificités des mages AD&amp;D</h4>
		<p> • <b>Le port d’une armure</b> entraîne des pénalités pour lancer un sort.<br>
			• Les mages ne peuvent pas faire de magie collective.<br>
			• Les mages n’ont pas accès au collège <i>Sacré</i>.</p>
	</details>

	<details>
		<summary class="h3">Prêtres &amp; serviteurs de divinité</summary>

		<h4>Avantages, désavantages &amp; compétences nécessaires</h4>
		<p>Si le personnage fait partie d’un clergé «&nbsp;reconnu&nbsp;», il faut l’avantage <i>Statut religieux</i>.</p>
		<p>Le respect des obligations et interdits religieux est couvert par le désavantage <i>Dévotion</i> (à détailler pour chaque type de prêtre et/ou de religion).</p>
		<p>Les obligations morales sont couvertes par les désavantages <i>Vœux</i> et/ou <i>Code de conduite</i>.</p>
		<p>Un prêtre a le plus souvent des obligations professionnelles couvertes par <i>Devoir</i>.</p>
		<p>L’organisation cléricale peut éventuellement jouer le rôle de <i>Protecteur</i>.</p>
		<p>Un prêtre doit avoir des connaissances de sa divinité et de la cosmogonie, par la compétence <i>Théologie</i>.</p>

		<h4>Pouvoirs divins</h4>
		<p>Sorts ou avantages surnaturels offerts par une (ou plusieurs) divinité(s) à ceux qui la servent. Le niveau de puissance maximum accessible à un personnage prêtre dépend de son statut, de son background, etc. Parlez-en à votre MJ au moment de la création de votre personnage.</p>

		<p>
			Par défaut, le multiplicateur de coût (en points de perso) de ces pouvoirs est de <b>×<?= Power::priest_mult ?></b>.<br>
			L’avantage optionnel <i><?= $avdesav_repo->getAvDesav(183)->name ?></i> permet d’acquérir des pouvoirs de niveau inférieur ou égal l’avantage à <b>×<?= Power::priest_mult_low ?></b>.
		</p>

		<p>Ces pouvoirs sont perdus si le personnage ne sert plus sa divinité – d’où le fait qu’ils ne sont payés que <?= Power::priest_mult * 100 ?>&nbsp;% du prix normal. S’il commet une offense envers elle, celle-ci peut suspendre les pouvoirs jusqu’à accomplissement une pénitence appropriée.</p>

		<p><b>Améliorations &amp; limitations</b><br>
			Ces pouvoirs peuvent bénéficier d’améliorations ou de limitations. Les multiplicateurs indiqués s’appliquent aux multiplicateurs des pouvoirs de prêtres.<br>
			<b>• Demi-coût énergétique (×1,5)&nbsp;:</b> réduction de moitié du coût énergétique au lancé comme pour le maintien.
		</p>
		<p><b>Récupération de PdM</b><br>
			6 par heure de prière (aucun coût). Ce rythme et les conditions de récupération peuvent varier selon le type de prêtre.
		</p>
		<p><b>PdM supplémentaires</b><br>
			autant qu’un mage dont le niveau de <i>Magerie</i> serait le même que le niveau de puissance du pouvoir le plus puissant dont le prêtre dispose.
		</p>
		<p><b>Magie collective</b><br>
			Elle est possible pour les prêtres. De plus, chaque sympathisant présent lors du rituel peut donner 1 PdM, même s’il ne connaît pas le pouvoir qui est lancé.
		</p>

		<h4>Personnage mages-prêtres</h4>
		<p>Un personnage disposant à la fois de sorts et/ou de pouvoirs raciaux et de pouvoirs de prêtre bénéficie des deux modes de récupération (4 PdM/h de repos et 6 PdM/h de prière) mais il doit tenir un décompte différencié de ses PdM&nbsp;: ceux dépensés dans des sorts ou pouvoirs raciaux et ceux dépensés dans des pouvoirs de prêtre.</p>
		<p>Les premiers seront récupérés au rythme standard, les seconds au rythme des prêtres. Peu importe comment le personnage utilise ses PdM, tant que l’ensemble des PdM dépensés ne dépasse pas la réserve dont dispose le personnage.</p>
		<p><b>Remarque n°1&nbsp;:</b> la prière n’est pas du repos (en termes de récupération de PdM)&nbsp;; les modes de récupérations ne se cumulent pas.</p>
		<p><b>Remarque n°2&nbsp;:</b> un personnage mage-prêtre ne peut pas utiliser de pierre de puissance pour utiliser un pouvoir de prêtre.</p>
		<p>Un personnage prêtre ayant également <i>Magerie</i> paiera ses pouvoirs comme s’il avait l’avantage <i>Prêtrise</i> au même niveau que <i>Magerie</i>.</p>
	</details>

	<details>
		<summary class="h3">Kits de personnage</summary>
		<h4>Druide</h4>
		<p>• <b>Dévotion (-10 pts)&nbsp;:</b> protéger la Nature (venir en aide aux animaux blessés, empêcher la destruction de la Nature, ne pas prélever plus de vies que le strict nécessaire), mener une vie frugale, assister aux réunions de druides deux fois par an (solstice d’été et solstice d’hiver).</p>
		<p>• <b>Vœux (-15 pts)&nbsp;:</b> Pacifisme (légitime défense)</p>
		<p>• <b>Devoir (-5 pts)&nbsp;:</b> assister la communauté dont il a la charge (soigner les blessés et les malades, servir d’assistant au chef du village dans le rendu de la justice et pour d’autres décisions importantes, aider à la production agricole par ses pouvoirs).</p>
		<p><b>Récupération de PdM (-4 pts)&nbsp;:</b> 6 par heure de prière/méditation sauf en zone urbanisée, où ce rythme tombe à 2 PdM / heure.</p>

		<h4>Ranger</h4>
		<p>Le ranger est un guerrier au service de la Nature, capable d’avoir des pouvoirs des collèges <i>Animalier</i> et <i>Végétal</i>. Il obtient ses pouvoirs directement de la Nature, qui est une «&nbsp;divinité&nbsp;» peu exigeante en termes d’obligations de conduite. Le multiplicateur de coût de pouvoirs est de <b>×0,8</b>.</p>
		<p>• <b>Code de conduite (-15 pts)&nbsp;:</b> le ranger est pacifique. Il ne combat qu’en situation de légitime défense sauf lorsqu’il s’agit de créatures et humanoïdes maléfiques. Il protège la Nature contre les influences maléfiques et ne tuera jamais un animal sans nécessité absolue (se nourrir en est une).</p>
		<p><b>Récupération de PdM (-4 pts)&nbsp;:</b> comme les druides.</p>
	</details>

</article>

<article><!-- Équipement -->
	<h2>Équipement</h2>

	<details>
		<summary class="h3">Système monétaire</summary>

		<h4>Système monétaire</h4>
		<p>1 po = 20 pa = 80 pc</p>
		<p>pièce d’or&nbsp;: taille d’une pièce de 20 ¢, 15 g<br>
			pièce d’argent&nbsp;: taille d’une pièce de 20 ¢, 10 g<br>
			pièce de cuivre&nbsp;: taille d’une pièce de 50 ¢, 10 g<br>
			piécette (½ pc)&nbsp;: taille d’une pièce de 2 ¢, 5 g</p>
		<p>Conversion AD&amp;D&nbsp;: 1 po AD&D = 12 pc = 0,15 po</p>

		<h4>Échelle de valeurs</h4>
		<p>1 pc représente environ 5 euros</p>
		<p>Salaire journalier pauvre&nbsp;: 4 à 6 pc<br>
			Salaire journalier moyen&nbsp;: 15 à 20 pc<br>
			Salaire journalier confortable&nbsp;: 30 à 40 pc<br>
			Salaire journalier très élevé&nbsp;: 150+ pc<br>
			Coût de la vie minimum&nbsp;: 50 pc/mois<br>
			Coût de la vie, statut social -1&nbsp;: 100 pc/mois<br>
			Coût de la vie, statut social 0&nbsp;: 200 pc/mois<br>
			Coût de la vie, statut social 1&nbsp;: 400 pc/mois<br>
			Coût de la vie, statut social 2&nbsp;: 800 pc/mois</p>

	</details>

	<details>
		<summary class="h3">Armes</summary>

		<?php
		$weapons = array_filter(WeaponsController::weapons, fn ($weapon) => !(in_array($weapon["catégorie"], ["exclu", "spéciale"]) || in_array($weapon["nom"], ["Javelot", "Sarbacane", "Rapière", "Sabre", "Trident"])));
		//$weapons = Sorter::sort($weapons, "nom");
		WeaponsController::displayWeaponsList($weapons, false, true, "prix-add");
		?>

		<h4>Notes diverses</h4>
		<ul class="fs-300">
			<li>Pour les notes sur les armes, voir <a href="/armes-armures">Armes &amp; armures</a>.</li>
			<li>Le coût des armes est donnée en pc.</li>
			<li>Carquois (10 flèches)&nbsp;: poids négligeable, 10 pc</li>
			<li>Flèches et carreaux (10)&nbsp;: 0,5 kg, 20 pc</li>
		</ul>

		<h4>Qualité des armes</h4>
		<ul class="fs-300">
			<li>Arme tranchante MQ&nbsp;: prix ×0,7</li>
			<li>Épée BQ/TBQ&nbsp;: prix ×2 / ×5</li>
			<li>Armes tranchantes/perf. BQ/TBQ&nbsp;: prix ×5/×12</li>
			<li>Arme de broyage BQ&nbsp;: prix ×1,5</li>
			<li>Arcs et arbalètes BQ&nbsp;: prix ×2</li>
		</ul>

	</details>

	<details>
		<summary class="h3">Armures &amp; boucliers</summary>

		<h4>Armures</h4>

		<p>Composez votre armure en respectant un certain réalisme. Le prix et le poids d’une armure dépendent de plusieurs facteurs.</p>

		<ul>
			<li>
				<b>sa taille&nbsp;:</b>
				<ul>
					<li>petite (femme, elfe, nain)&nbsp;: poids ×0.8, prix ×0.9</li>
					<li>très petite (hobbit)&nbsp;: poids ×0.6, prix ×0.8</li>
				</ul>

			</li>
			<li><b>son type</b> (cuir, cotte de maille&hellip;)</li>
			<li><b>sa qualité</b></li>
			<li><b>son niveau d’enchantement</b> (ici, seul l’impact sur le poids est calculé).</li>
		</ul>

		<div class="mt-2 p-1 bg-accent fs-300" id="armor-widget">

			<p>Sélectionner des paramètres globaux si vous le souhaitez</p>

			<div class="grid ai-center" style="grid-template-columns: 1fr 1fr;">
				<span>Taille de l’armure</span>
				<select id="armor-size">
					<?php foreach (ArmorsController::armor_sizes as $size) { ?>
						<option data-weight="<?= $size["mult_poids"] ?>" data-price="<?= $size["mult_prix"] ?>"><?= ucfirst($size["nom"]) ?></option>
					<?php } ?>
				</select>
			</div>

			<div class="grid ai-center mt-½" style="grid-template-columns: 1fr 1fr;">
				<span>Type global</span>
				<select id="armor-type">
					<option value="0" data-weight="0" data-price="0">–</option>
					<?php foreach (ArmorsController::armors as $index => $armor) { ?>
						<option value="<?= $index ?>"><?= ucfirst($armor["nom"]) ?></option>
					<?php } ?>
				</select>
			</div>

			<div class="grid ai-center mt-½" style="grid-template-columns: 1fr 1fr;">
				<span>Qualité globale</span>
				<select id="armor-quality">
					<?php foreach (ArmorsController::armor_qualities as $index => $data) { ?>
						<option value="<?= $index ?>"><?= ucfirst($data["nom"]) ?></option>
					<?php } ?>
				</select>
			</div>

			<div class="grid ai-center mt-½" style="grid-template-columns: 1fr 1fr;">
				<span>Enchantement global</span>
				<select id="armor-enchantment">
					<option value="0">Non magique</option>
					<option value="1">+1 ou +2</option>
					<option value="2">+2 ou +3</option>
				</select>
			</div>

			<table class="alternate-e mt-2 left-1">
				<tr>
					<th></th>
					<th style="width: 9ch">Poids</th>
					<th style="width: 9ch">Prix</th>
				</tr>
				<!-- Parties d’armure -->
				<?php foreach (ArmorsController::armor_parts as $index => $part) { ?>
					<tr data-type="armor-row" data-weight="<?= $part["mult_poids"] ?>" data-price="<?= $part["mult_prix"] ?>">
						<td class="py-½">

							<div class="flex-s gap-½">
								<b class="fl-1"><?= $part["nom"] ?></b>
								<label>(½) <input type="checkbox"></label>
							</div>

							<select class="full-width mt-¼" data-type="armor-type">
								<option value="0" data-weight="0" data-price="0">–</option>
								<?php foreach (ArmorsController::armors as $index => $armor) { ?>
									<option value="<?= $index ?>" data-weight="<?= $armor["poids"] ?>" data-price="<?= $armor["prix-add"] ?>"><?= ucfirst($armor["nom"]) ?></option>
								<?php } ?>
							</select>

							<select class="full-width mt-¼" data-type="armor-quality">
								<?php foreach (ArmorsController::armor_qualities as $index => $data) { ?>
									<option value="<?= $index ?>" data-weight="<?= $data["mult_poids"] ?>" data-price="<?= $data["mult_prix"] ?>"><?= ucfirst($data["nom"]) ?></option>
								<?php } ?>
							</select>

							<select class="full-width mt-¼" data-type="armor-enchantment">
								<option value="0" data-weight="1">Non magique</option>
								<option value="1" data-weight="0.67">+1 ou +2</option>
								<option value="2" data-weight="0.5">+2 ou +3</option>
							</select>
						</td>
						<td></td>
						<td></td>
					</tr>
				<?php } ?>
				<tr id="armor-total">
					<th>Total</th>
					<th></th>
					<th></th>
				</tr>
			</table>

		</div>

		<h4>Qualité des armures</h4>
		<p>
			Bonne qualité&nbsp;: Même RD&nbsp;; poids -10&nbsp;%&nbsp;; coût ×1,25<br>
			Très bonne qualité&nbsp;: RD+1&nbsp;; poids -20&nbsp;%&nbsp;; coût ×4
		</p>

		<h4>Boucliers</h4>
		<table class="left-1 alternate-e">
			<tr>
				<th>Bouclier</th>
				<th>DP</th>
				<th>Poids</th>
				<th>Prix</th>
			</tr>
			<?php foreach (ArmorsController::shields as $shield) { ?>
				<tr>
					<td><?= $shield["nom"] ?></td>
					<td><?= $shield["DP"] ?></td>
					<td><?= $shield["poids"] ?> kg</td>
					<td><?= $shield["prix-add"] ?> pc</td>
				</tr>
			<?php } ?>
		</table>

	</details>

	<details>
		<summary class="h3">Équipement divers</summary>

		<h4>Vêtements</h4>
		<table class="left-1 fs-300 alternate-o">
			<tr>
				<td>Haillons*</td>
				<td>2 pc&nbsp;; 1 kg</td>
			</tr>
			<tr>
				<td>Vêtements pauvres*</td>
				<td>10 pc&nbsp;; 1 kg</td>
			</tr>
			<tr>
				<td>Vêtements moyens*</td>
				<td>40 pc&nbsp;; 1 kg</td>
			</tr>
			<tr>
				<td>Vêtements bourgeois*</td>
				<td>200 pc&nbsp;; 1 kg</td>
			</tr>
			<tr>
				<td>Vêtements nobles*</td>
				<td>1000 pc+&nbsp;; 1 kg</td>
			</tr>
			<tr>
				<td>Vêtements d’hiver** (RD1)</td>
				<td>prix ×2&nbsp;; 2,5 kg</td>
			</tr>
			<tr>
				<td>Tunique</td>
				<td>30 pc&nbsp;; 0,25 kg</td>
			</tr>
			<tr>
				<td>Veste de cuir (souple, RD1)</td>
				<td>75 pc&nbsp;; 1,5 kg</td>
			</tr>
			<tr>
				<td>Pardessus chaud (cuir et laine, RD1)</td>
				<td>50 pc&nbsp;; 3kg</td>
			</tr>
			<tr>
				<td>Sandales</td>
				<td>2 pc&nbsp;; -</td>
			</tr>
			<tr>
				<td>Mocassins</td>
				<td>5 pc&nbsp;; 0,25 kg</td>
			</tr>
			<tr>
				<td>Chaussures bourgeoises, de ville</td>
				<td>25 pc&nbsp;; 0,25 kg</td>
			</tr>
			<tr>
				<td>Chaussures de marche cuir souple (RD1)</td>
				<td>15 pc&nbsp;; 0,5 kg</td>
			</tr>
			<tr>
				<td>Cape basique</td>
				<td>20 pc&nbsp;; 0,5 kg</td>
			</tr>
			<tr>
				<td>Cape en belle fourrure</td>
				<td>500 pc&nbsp;; 1,5 kg</td>
			</tr>
			<tr>
				<td>Cape lourde (tissu épais)</td>
				<td>40 pc&nbsp;; 1 kg</td>
			</tr>
			<tr>
				<td>Chapeau de feutre</td>
				<td>5 pc&nbsp;; -</td>
			</tr>
			<tr>
				<td>Chapeau de paille</td>
				<td>2 pc&nbsp;; -</td>
			</tr>
			<tr>
				<td>Gants en cuir souple</td>
				<td>10 pc&nbsp;; -</td>
			</tr>
			<tr>
				<td>Gants en laine</td>
				<td>5 pc&nbsp;; -</td>
			</tr>
		</table>
		<p>
			* Les vêtements incluent un pantalon, une chemise, une ceinture et des sous-vêtements, mais ni chaussures, ni veste, ni cape.<br>
			** Les vêtements d’hiver sont plus chauds et plus épais. Ils incluent une veste ou autre protection légère (tunique) contre le froid.
		</p>

		<h4>Équipement spécial</h4>
		<table class="left-1 fs-300 alternate-o">
			<tr>
				<td>Outils de crochetage</td>
				<td>30 pc</td>
			</tr>
			<tr>
				<td>Outils de crochetage BQ, (+1 crochetage)</td>
				<td>200 pc</td>
			</tr>
			<tr>
				<td>Serpe d’or (pour druide)</td>
				<td>500 pc&nbsp;; 0,25 kg</td>
			</tr>
			<tr>
				<td>Trousse premiers secours (+1 comp.)</td>
				<td>30 pc&nbsp;; 1 kg</td>
			</tr>
			<tr>
				<td>Labo d’alchimie improvisé (-2 comp.)</td>
				<td>50 pc&nbsp;; 4 kg</td>
			</tr>
			<tr>
				<td>Labo d’alchimie portable (-1 comp.)</td>
				<td>250 pc&nbsp;; 8 kg</td>
			</tr>
			<tr>
				<td>Labo d’alchimie - atelier domestique</td>
				<td>1200 pc</td>
			</tr>
			<tr>
				<td>Labo d’alchimie, très équipé (+1 comp.)</td>
				<td>4800 pc</td>
			</tr>
			<tr>
				<td>Gourde en mithrill (10 doses de potions)</td>
				<td>300 pc&nbsp;; 0,1 kg</td>
			</tr>
			<tr>
				<td>Caltrops, la centaine</td>
				<td>10 pc&nbsp;; 0,5 kg</td>
			</tr>
		</table>

		<h4>Équipement de voyage</h4>
		<table class="left-1 fs-300 alternate-o">
			<tr>
				<td>Set pour manger (cuillère, petit couteau...)</td>
				<td>5 pc&nbsp;; 0,25 kg</td>
			</tr>
			<tr>
				<td>Bourse</td>
				<td>2 pc&nbsp;; -</td>
			</tr>
			<tr>
				<td>Sacoche / Besace</td>
				<td>10 pc&nbsp;; 0,25 kg</td>
			</tr>
			<tr>
				<td>Sac à dos</td>
				<td>15 pc&nbsp;; 0,5 kg</td>
			</tr>
			<tr>
				<td>Outre, 1 L</td>
				<td>3 pc&nbsp;; -</td>
			</tr>
			<tr>
				<td>Outre, 5 L</td>
				<td>10 pc&nbsp;; -</td>
			</tr>
			<tr>
				<td>Bouteille de céramique, 1 L</td>
				<td>3 pc&nbsp;; 0,5 kg</td>
			</tr>
			<tr>
				<td>Grosse bouteille de céramique, 5 L</td>
				<td>5 pc&nbsp;; 2 kg</td>
			</tr>
			<tr>
				<td>Torche, 1 heure</td>
				<td>½ pc&nbsp;; 0,5 kg</td>
			</tr>
			<tr>
				<td>Lanterne</td>
				<td>20 pc&nbsp;; 1 kg</td>
			</tr>
			<tr>
				<td>Huile de lampe (0,5 L, brûle pendant 24h)</td>
				<td>2 pc&nbsp;; 0,5 kg</td>
			</tr>
			<tr>
				<td>Briquet à amadou</td>
				<td>5 pc</td>
			</tr>
			<tr>
				<td>Tente 4 places (+ 2 perches de 2 m)</td>
				<td>150 pc&nbsp;; 15 kg</td>
			</tr>
			<tr>
				<td>Couverture (grosse laine)</td>
				<td>20 pc&nbsp;; 2,5 kg</td>
			</tr>
			<tr>
				<td>Sac de couchage (pour grand froid)</td>
				<td>100 pc&nbsp;; 6 kg</td>
			</tr>
			<tr>
				<td>Corde (diam. 1 cm, 150 kg), 10 m</td>
				<td>5 pc&nbsp;; 0,75 kg</td>
			</tr>
			<tr>
				<td>Grosse corde (diam. 2 cm, 550 kg), 10 m</td>
				<td>150 pc&nbsp;; 4 kg</td>
			</tr>
			<tr>
				<td>Grappin léger (supporte 150kg)</td>
				<td>20 pc&nbsp;; 1 kg</td>
			</tr>
		</table>

		<h4>Animaux et harnachement</h4>
		<table class="left-1 fs-300 alternate-o">
			<tr>
				<td>Ane</td>
				<td>120 pc</td>
			</tr>
			<tr>
				<td>Mule</td>
				<td>500 pc</td>
			</tr>
			<tr>
				<td>Cheval de selle</td>
				<td>700 pc</td>
			</tr>
			<tr>
				<td>Cheval de guerre</td>
				<td>2500 pc</td>
			</tr>
			<tr>
				<td>Cheval de guerre lourd</td>
				<td>3000 pc</td>
			</tr>
			<tr>
				<td>Selle, mors et rênes</td>
				<td>100 pc</td>
			</tr>
			<tr>
				<td>Sacoches de selle</td>
				<td>50 pc</td>
			</tr>
			<tr>
				<td>Ration d’avoine (par jour et par bête)</td>
				<td>2 kg&nbsp;; 1 pc</td>
			</tr>
			<tr>
				<td>Carriole (pour un cheval, transporte 1 tonne)</td>
				<td>400 pc</td>
			</tr>
			<tr>
				<td>Mouton (50 kg)</td>
				<td>50 pc</td>
			</tr>
			<tr>
				<td>Bœuf</td>
				<td>850 pc</td>
			</tr>
			<tr>
				<td>Poule</td>
				<td>2 pc</td>
			</tr>
			<tr>
				<td>Porc (60 kg)</td>
				<td>45 pc</td>
			</tr>
		</table>
	</details>

	<details>
		<summary class="h3">Nourriture et logement</summary>
		<table class="left-1 fs-300 alternate-o mt-1">
			<tr>
				<td>Couchage dans un dortoir</td>
				<td>2 pc</td>
			</tr>
			<tr>
				<td>Chambre, auberge moyenne</td>
				<td>4-10 pc</td>
			</tr>
			<tr>
				<td>Repas dans une taverne</td>
				<td>2-4 pc</td>
			</tr>
			<tr>
				<td>Chope de bière dans une taverne</td>
				<td>½ pc</td>
			</tr>
			<tr>
				<td>Ration de voyageur (un repas)</td>
				<td>2 pc&nbsp;; 0,25 kg</td>
			</tr>
			<tr>
				<td>Fromage, 1 kg</td>
				<td>2-5 pc</td>
			</tr>
			<tr>
				<td>Lard, 1 kg</td>
				<td>3 pc</td>
			</tr>
			<tr>
				<td>Viande de porc, 1 kg</td>
				<td>2-3 pc</td>
			</tr>
			<tr>
				<td>Œufs, la douzaine</td>
				<td>1 pc</td>
			</tr>
			<tr>
				<td>Pain, 1 kg</td>
				<td>1 pc</td>
			</tr>
			<tr>
				<td>Vin, 1 litre</td>
				<td>1-3 pc</td>
			</tr>
			<tr>
				<td>Liqueur, 1 litre</td>
				<td>3-6 pc</td>
			</tr>
		</table>
	</details>

	<details>
		<summary class="h3">Objets spéciaux &amp; services magiques</summary>

		<h4>Objets spéciaux</h4>
		<p><b>Dague à poison&nbsp;:</b> dague à lame creuse. Réserve de poison dans le manche (1 à 3 doses) qui sont toutes expulsées par la pointe de la lame en cas de choc (même si l’armure n’est pas traversée). Dégâts&nbsp;: P.e (pas de dégâts tranchants). Solide comme arme «&nbsp;bon marché&nbsp;». (500 pc&nbsp;; 0,25 kg)</p>

		<h4>Poisons</h4>
		<p>Le prix est donné pour une dose.</p>
		<ul>
			<li><b>Somnifère (ingéré)&nbsp;:</b> 5-15 min&nbsp;; sommeil / somnolence et -2 à tous les jets (20 pc)</li>
			<li><b>Type A (ingéré)&nbsp;:</b> 10-30 min&nbsp;; 3d / 1d, douleurs, crampes, -2 à tous les jets pendant plusieurs jours (50 pc)</li>
			<li><b>Type F (injecté)&nbsp;:</b> 1d+5 secondes&nbsp;; mort / 2d, douleurs et malaises pendant 2d heures, -2 à tous les jets (100 pc)</li>
		</ul>

		<h4>Herboristerie</h4>
		<ul>
			<li><b>Guronsan&nbsp;:</b> fait récupérer 4 PdF durant 6h, max 2 par jour (5 pc). Un usage régulier peut créer une dépendance.</li>
			<li><b>Onguent de guérison&nbsp;:</b> +2 aux jets de guérison, fabriqué à partir de plantes, 3 pc par dose. Une dose par jour.</li>
		</ul>


		<h4>Services magiques</h4>
		<p><b>Identification de potion&nbsp;:</b> 5 pc</p>
		<p><b>Lancer de sort (légal)&nbsp;:</b> 5/20/50/150/500+ pc</p>

	</details>

</article>

<article><!-- Magie -->
	<h2>Magie</h2>

	<details>
		<summary class="h3">Magie et armure</summary>
		<p>
			<b>Le port d’une armure</b> entraîne des pénalités pour lancer un sort (mais pas un pouvoir).<br>
			Ces pénalités modifient le <i>score brut</i> du sort (comme celles dues à un fluide faible). Tout se passe comme si, localement, l’armure portée diminuait le fluide entourant le lanceur de sort.<br>
			Cette règle ne s’applique pas aux pouvoirs (qu’ils soient innés, ou que ce soit des pouvoirs de prêtres).
		</p>
		<ul>
			<li>-1 pour une armure de cuir</li>
			<li>-2 pour une armure de cuir lourde</li>
			<li>-3 pour une amure métallique souple (maille, brigandine, armure d’écailles)</li>
			<li>-5 pour une armure de plates ou une armure à bande</li>
			<li>-8 pour une superposition cotte de maille + plate</li>
		</ul>
		<p>Si le personnage ne porte qu’une armure partielle, utiliser les indications suivantes&nbsp;:</p>
		<ul>
			<li>le malus complet est appliqué si la tête <b>et</b> le torse sont protégés.</li>
			<li>La tête (hors visage) est source d’un tiers de malus (la moitié si le visage est aussi couvert).</li>
			<li>Le torse est source des deux-tiers des malus.</li>
			<li>Les bras et les jambes ne comptent que pour 1/5<sup>e</sup> du malus.</li>
			<li>Le malus total ne peut être supérieur à celui qu’aurait le mage en portant l’armure complète.</li>
			<li>On arrondit le malus à l’inférieur</li>
		</ul>
		<div class="exemple">
			Un mage porte une protection de maille couvrant le torse, ainsi qu’un protection de cuir lourd couvrant la tête (mais pas le visage).<br>
			À la louche, on dit -2 pour la cotte de maille sur le torse et -2×⅓ pour la tête, soit un malus total de -2.
		</div>
	</details>

	<details>
		<summary class="h3">Sorts</summary>

		<h4>Sorts de Soins</h4>
		<p>Tous ces sorts nécessitent de toucher le sujet.</p>

		<h4>Invoquer et contrôler un élémental</h4>
		<p>Une invocation de niveau IV permettra d’invoquer un «&nbsp;petit&nbsp;» élémental (2,50 m et force minimale). Une invocation de niveau V permet d’obtenir un élémental dont les caractéristiques sont situées dans la fourchette haute.<br>
			Les sorts de <i>Contrôle d’élémental</i> et d’<i>Invocation d’élémental</i> n’ont pas de version niveau III dans les règles d’AD&amp;D car même le plus petit élémental est doté d’une puissance considérable.<br>
			Les élémentaux sont stupides et sont donc relativement faciles à invoquer et à contrôler. Aucun d’eux n’aime être dérangé et arraché à son plan d’origine. Ils réagissent toujours avec fureur à une invocation.</p>
		<p>Les <b>élémentaux de feu</b> peuvent être invoqués dans n’importe quel endroit ouvert où se trouve un grand feu. Pour fournir une enveloppe corporelle à l’élémental invoqué, le feu allumé doit avoir un diamètre d’au moins 2 m avec des flammes hautes d’au moins 1,20 m.</p>

		<h4>Sorts spécifiques</h4>
		<?php
		$spells = $spells_repo->getSpellsByOrigin("ADD");
		foreach ($spells as $spell) {
			$spell->displayInRules(show_edit_link: $_SESSION["Statut"] === 3);
		}
		?>
	</details>

	<details>
		<summary class="h3">Potions</summary>

		<details class="mt-½">
			<summary class="h4">Fabrication et prix de vente des potions</summary>
			<p>Les potions sont classées en 5 catégories de puissance, comme les sorts (faible, moyenne, forte, très forte, exceptionnelle). La complexité et le coût de leur fabrication dépendent de cette puissance.</p>

			<table class="alternate-e">
				<tr>
					<th></th>
					<th>Matériaux (pc)</th>
					<th>Durée (×4h)</th>
					<th>Malus</th>
				</tr>
				<tr>
					<td>I</td>
					<td>30 - 50</td>
					<td>1</td>
					<td>0 à -1</td>
				</tr>
				<tr>
					<td>II</td>
					<td>70 - 150</td>
					<td>2 à 3</td>
					<td>-1 à -2</td>
				</tr>
				<tr>
					<td>III</td>
					<td>250 - 500</td>
					<td>4 à 5</td>
					<td>-2 à -3</td>
				</tr>
				<tr>
					<td>IV</td>
					<td>750 - 1500</td>
					<td>8 à 15</td>
					<td>-3 à -4</td>
				</tr>
				<tr>
					<td>V</td>
					<td>2500+</td>
					<td>30 et +</td>
					<td>-5 et pire</td>
				</tr>
			</table>

			<p>Il existe des recettes «&nbsp;alternatives&nbsp;» ayant des caractéristiques différentes de celles suggérées ici, par exemple, une recette moins coûteuse en matériaux, mais plus longue et plus difficile.</p>

			<fieldset class="widget mt-1" data-role="widget-potion">
				<legend>Prix de vente d’une potion</legend>
				<div class="grid gap-½" style="grid-template-columns: 1fr 12ch">
					Prix des matériaux (pc)
					<input type="text" class="ta-center" data-type="prix-materiaux">
					Durée en tranches de 4h
					<input type="text" class="ta-center" value="1" data-type="temps-fabrication">
					Malus au jet d’Alchimie
					<input type="text" class="ta-center" value="0" data-type="difficulte-fabrication">
					<label for="illegal-potion">La potion est illégale</label>
					<div class="ta-center"><input type="checkbox" data-type="potion-illegale" id="illegal-potion"></div>
					<div class="fw-700">Prix de vente (pc)</div>
					<div class="ta-center fw-700" data-role="container-prix">–</div>
				</div>
			</fieldset>

		</details>

		<details>
			<summary class="h4">Liste des potions</summary>
			<p>Chaque dose de potion est vendue dans une petite fiole en céramique ou en verre. Conditionnée de la sorte, une potion pèse 0,15 kg.</p>

			<details class="liste">
				<summary>Amnésie <div>1100 pc</div>
				</summary>
				Efface tous les souvenirs des dernières 1d×4 heures (illégale). Le sujet tombe dans une torpeur pendant 2d minutes durant lesquelles il n’est pas conscient de ce qui se passe autour de lui. Résistance par <i>Vol</i>.<br>
				Matériaux&nbsp;: 400 pc&nbsp;; 4×4 h&nbsp;; compétence -2.
			</details>

			<details class="liste">
				<summary>Antidote <div>1000 pc</div>
				</summary>
				Annule les effets de tout autre produit alchimique – sauf ceux ayant trait à la guérison et aux soins. Une potion d’<i>Amnésie</i> ne peut être annulée que pendant les 24 h qui suivent sa consommation.<br>
				Procure une immunité aux produits alchimiques pendant 1d minutes, y compris ceux qui seraient bénéfiques au sujet.<br>
				Matériaux&nbsp;: 500 pc&nbsp;; 4×4 h&nbsp;; compétence -3.
			</details>

			<details class="liste">
				<summary>Dextérité <div>950 pc</div>
				</summary>
				+1d en <i>Dex</i> pendant 1 heure. Matériaux 350 pc&nbsp;; 5×4h&nbsp;; compétence -3.
			</details>

			<details class="liste">
				<summary>Effacement <div>220 pc</div>
				</summary>
				Les liens de l’utilisateur avec les objets lui ayant appartenu ou avec l’initiateur d’un sort de recherche ou de communication sont effacés. Matériaux 110 pc&nbsp;; 2×4h&nbsp;; compétence -1.
			</details>

			<details class="liste">
				<summary>Force <div>500 pc</div>
				</summary>
				+1d en <i>For</i> pendant 1h, influence tous les facteurs dépendant de la <i>For</i>, sauf les PdV. Matériaux 250 pc&nbsp;; 3×4h&nbsp;; compétence -2.
			</details>

			<details class="liste">
				<summary>Haine <div>160 pc</div>
				</summary>
				Le sujet se met à haïr tout ce (et tous ceux) qu’il aimen en temps normal, pendant une heure. Matériaux 70 pc&nbsp;; 2×4h&nbsp;; compétence -1.
			</details>

			<details class="liste">
				<summary>Hydromarche <div>300 pc</div>
				</summary>
				Permet au sujet de marcher sur l’eau pendant 1d minutes. Matériaux 150 pc&nbsp;; 3×4h&nbsp;; compétence -1.
			</details>

			<details class="liste">
				<summary>Invisibilité <div>3200 pc</div>
				</summary>
				Dure 1d minutes. Matériaux 1000 pc&nbsp;; 8×4h&nbsp;; compétence -3.
			</details>

			<details class="liste">
				<summary>Métamorphose <div>500 - 950 pc</div>
				</summary>
				Le sujet se change en animal, comme par le sort homonyme pendant 1d×2 heures. L’alchimiste choisit le type d’animal en lequel le sujet sera transformé (une «&nbsp;recette&nbsp;» par animal). S’il s’agit d’un animal volant, très petit ou très gros (dans les mêmes limites que le sort <i>Métamorphose</i>), la potion est plus complexe à préparer. Matériaux 250-400 pc&nbsp;; (4-5)×4h&nbsp;; compétence -2 à -3.
			</details>

			<details class="liste">
				<summary>Respiration aquatique <div>350 pc</div>
				</summary>
				Le sujet peut respirer dans l’eau et dans l’air pendant 1d heures. Matériaux 150 pc&nbsp;; 3×4h&nbsp;; compétence -2.
			</details>
			<details class="liste">
				<summary>Vol <div>1700 pc</div>
				</summary>
				Permet au buveur de voler comme sous l’effet du sort <i>Vol</i> pendant 1d×10 minutes. Matériaux 750 pc&nbsp;; 8×4h&nbsp;; compétence -3.
			</details>

			<details class="liste mt-1">
				<summary>Élixir de santé <div>2000 pc</div>
				</summary>
				Forme supérieure de la potion de <i>Guérison des maladies</i>. Cette potion guérit la cécité, la surdité, toutes les maladies, la débilité mentale non congénitale, la folie, les infections, l’empoisonnement et le pourrissement. Elle ne fait pas récupérer de PdV. Matériaux 750 pc&nbsp;; 8×4h&nbsp;; compétence -4.
			</details>
			<details class="liste">
				<summary>Guérison des maladies <div>950 pc</div>
				</summary>
				Soigne toutes les maladies. Matériaux 400 pc&nbsp;; 5×4h&nbsp;; compétence -3.
			</details>
			<details class="liste">
				<summary>Huile de dépétrification <div>800 pc</div>
				</summary>
				Appliquée sur une victime d’une <i>Pétrification</i>, cette huile lui rendra son état d’origine. Elle ne pourra rien contre une pétrification de niveau V. Matériaux 300 pc&nbsp;; 5×4h&nbsp;; compétence -3.
			</details>
			<details class="liste">
				<summary>Neutralisation des poisons <div>350 pc</div>
				</summary>
				Neutralise tous les poisons. Matériaux 150 pc&nbsp;; 3×4h&nbsp;; compétence -2.
			</details>
			<details class="liste">
				<summary>Perséphone <div>29000 pc</div>
				</summary>
				Rappelle à la vie un sujet n’ayant pas encaissé plus de [4×PdVm] pts de dégâts et mort depuis moins de 15 minutes. La tête doit être attachée au torse et celui-ci doit être en un seul morceau. La potion ne régénèrera aucun membre perdu. Elle fera récupérer 6d PdV à celui qui l’absorbe (la verser dans la bouche du mort suffit, il faut réussir un jet de San pour pouvoir ressusciter). Le sujet perd définitivement un point de San. Matériaux 7500 pc&nbsp;; 180×4h&nbsp;; compétence -5.
			</details>
			<details class="liste">
				<summary>Régénérescence <div>5400 pc</div>
				</summary>
				Fait repousser un membre ou un œil manquant ou détruit en 1d semaines. Matériaux 1500 pc&nbsp;; 30×4h&nbsp;; compétence-5.
			</details>
			<details class="liste">
				<summary>Restitution <div>2400 pc</div>
				</summary>
				Soignera un membre ou un œil détruit (mais encore présent). Matériaux 750 pc&nbsp;; 15×4h&nbsp;; compétence -4.
			</details>
			<details class="liste">
				<summary>Soin <div>90 pc</div>
				</summary>
				Soigne 1d PdV ou, si ceux-ci sont déjà à leur niveau maximum, fait récupérer 2d PdF (quelle que soit l’origine de la perte des PdF). Matériaux 50 pc&nbsp;; 4h.
			</details>
			<details class="liste">
				<summary>Supersoin <div>210 pc</div>
				</summary>
				Soigne 3d PdV ou, si ceux-ci sont déjà à leur maximum, soigne 6d PdF. Matériaux 100 pc&nbsp;; 2×4h&nbsp;; compétence-1.
			</details>
		</details>

		<details>
			<summary class="h4">Boire plusieurs potions</summary>
			<p>Deux potions ne sont pas toujours compatibles. L’incompatibilité ne peut généralement être vérifiée que par l’expérience, sauf dans les cas de potions identiques (pas d’effets secondaires) et de potions à effets contraires (s’annulent). Dans les autres cas, si une créature boit une potion alors qu’une autre potion différente est déjà active, il peut y avoir des effets secondaires (voir table ci-dessous).</p>

			<table class="alternate-e left-2">
				<tr>
					<th>3d</th>
					<th>Effets</th>
				</tr>
				<tr>
					<td>3</td>
					<td>Le mélange crée un effet spécial&nbsp;: une seule des deux potions est efficace, mais ses effets sont permanents. Le MJ peut décider que des effets secondaires néfastes se développent.</td>
				</tr>
				<tr>
					<td>4-5</td>
					<td>Les potions sont compatibles. L’efficacité ou la durée de l’une est accrue de 50&nbsp;%.</td>
				</tr>
				<tr>
					<td>6-9</td>
					<td>Les potions peuvent être mélangées et ont des effets normaux.</td>
				</tr>
				<tr>
					<td>10</td>
					<td>Les potions sont incompatibles. L’efficacité de chacune est réduite de moitié.</td>
				</tr>
				<tr>
					<td>11</td>
					<td>Les potions sont incompatibles. Les effets de l’une sont annulés&nbsp;; l’autre reste efficace.</td>
				</tr>
				<tr>
					<td>12</td>
					<td>Les potions sont totalement incompatibles. Les effets des deux potions sont annulés.</td>
				</tr>
				<tr>
					<td>13-14</td>
					<td>Poison bénin causant la nausée et la perte d’un point de For et d’un point de Dex pendant 1d h. Les effets d’une des potions sont annulés&nbsp;; l’efficacité et la durée de l’autre sont réduites de moitié.</td>
				</tr>
				<tr>
					<td>15-16</td>
					<td>Poison mortel. Le buveur doit réussir un jet de San. Il meurt en cas d’échec ou subit 4d de dégâts en cas de réussite. Si les deux potions ont été mélangées avant d’être bues, il se forme un nuage de gaz mortel ayant les mêmes effets.</td>
				</tr>
				<tr>
					<td>17-18</td>
					<td>Explosion. 5d de dégâts par potion bue. Si les potions sont mélangées en externe, 1d de dégâts explosifs par potion mélangée.</td>
				</tr>
			</table>
		</details>

	</details>

	<details>
		<summary class="h3">Objets magiques</summary>

		<details class="mt-½">
			<summary class="h4">Fabrication d’objets magiques</summary>

			<table class="alternate-e">
				<tr>
					<th>Puissance</th>
					<th>frais* (pc)</th>
					<th>Durée (mois)</th>
					<th>Prix de vente* (pc)</th>
				</tr>
				<tr>
					<td>I</td>
					<td>200</td>
					<td>0,5</td>
					<td>1500</td>
				</tr>
				<tr>
					<td>II</td>
					<td>500</td>
					<td>1</td>
					<td>3000</td>
				</tr>
				<tr>
					<td>III</td>
					<td>2000</td>
					<td>3</td>
					<td>11.000</td>
				</tr>
				<tr>
					<td>IV</td>
					<td>10.000</td>
					<td>12</td>
					<td>50.000</td>
				</tr>
				<tr>
					<td>V</td>
					<td>50.000+</td>
					<td>24+</td>
					<td>160.000</td>
				</tr>
			</table>

			<p>* en dehors de l’objet lui-même.</p>
		</details>

		<details>
			<summary class="h4">Objets basiques pour mage</summary>

			<details class="liste">
				<summary>Baguette de sorcier</summary>
				<p>Tout ce qu’un <i>Bâton de sorcier</i> touche est considéré comme ayant été touché par le mage lui-même. Un mage peut donc fixer une pierre de puissance sur son bâton et en tirer parti normalement. Pointer un bâton réduit la distance entre le lanceur et la cible d’un mètre.<br>
					Seul un personnage disposant de l’avantage <i>Magerie</i> peut tirer profit d’un tel objet.</p>
				<p><b>Prix&nbsp;:</b> 120 pc</p>
			</details>

			<details class="liste">
				<summary>Parchemin</summary>

				<p>Un <i>Parchemin</i> lu à haute voix par quelqu’un qui comprend et sait lire le langage employé et qui possède l’avantage <i>Magerie</i>, permettra au sort écrit d’être jeté. La magie du parchemin se dissipe alors et celui-ci tombe en poussière.<br>
					Le temps nécessaire pour jeter le sort est multiplié par 2. Aucun coût énergétique pour le lecteur. Faire un jet sous le score de pouvoir du parchemin pour déterminer la réussite du sort. Le lecteur peut prolonger le sort, si le parchemin le permet.<br>
					Un parchemin peut être lu en silence, afin de savoir ce qu’il contient, sans que le sort ne soit jeté. Des dégâts occasionnés à un manuscrit ne l’affecteront pas, tant qu’il demeure lisible.</p>
				<p><b>Prix&nbsp;:</b> 15 / 60 / 150 / 450 / 1500+ pc selon le niveau du sort.</p>
			</details>

			<details class="liste">
				<summary>Pierre de puissance</summary>
				<p>Pierre précieuse servant de réservoir de PdM. Pour pouvoir l’utiliser, le mage doit la toucher physiquement. Un mage ne peut tirer parti de plusieurs pierres pour un même sort. Il peut par contre utiliser à la fois ses propres PdM et des PdM tirés d’une pierre de puissance.<br>
					En fluide normal, une pierre de puissance récupère 1 PdM toutes les 12 heures. Si des pierres sont à 2 m ou moins l’une de l’autre, seule la plus grosse se recharge, sauf si celle-ci est pleine.<br>
					Une pierre de puissance ne peut fournir de PdM pour l’utilisation de pouvoirs innés, de sorts de prêtres, ou des pouvoirs psi.</p>
				<p>La capacité maximale d'une pierre dépend de sa valeur (poids et type de pierre).</p>

				<fieldset class="widget mt-1" data-role="widget-pierre-puissance">
					<legend>Prix des pierres de puissance</legend>
					<table>
						<tr>
							<th>PdM</th>
							<th>Pierre brute (pc)</th>
							<th>Vente (pc)</th>
						</tr>
						<tr>
							<td><input type="text" style="width: 5ch" class="ta-center" data-type="pdm"></td>
							<td data-role="prix-brut"></td>
							<td data-role="prix-vente"></td>
						</tr>
					</table>

				</fieldset>

			</details>

		</details>

		<details>
			<summary class="h4">Armes &amp; armures</summary>

			<details class="liste">
				<summary>Armes magiques</summary>
				Une arme magique procure un bonus de +1 à +4 aux jets de compétence et aux dégâts. Pour les projectiles, le bonus ne s’applique qu’aux dégâts. Pour les armes de tir, le bonus ne s’applique qu’à la compétence.<br>
				<b>Indice de puissance&nbsp;:</b> II pour +1&nbsp;; III pour +2.
				<p><b>Exemples de prix</b></p>
				<ul>
					<li><b>Épée longue BQ+1&nbsp;:</b> 4200 pc</li>
					<li><b>Épée longue TBQ+1&nbsp;:</b> 6000 pc</li>
					<li><b>Poignard TBQ+2&nbsp;:</b> 11500 pc</li>
					<li><b>Épée longue TBQ+2&nbsp;:</b> 14000 pc</li>
				</ul>
			</details>

			<details class="liste">
				<summary>Armures magiques</summary>
				+1 à +5 à la RD. De simples vêtements peuvent également être enchantés (mais attention à leur durée de vie !). En plus du bonus de RD, le poids d’une armure magique est réduit de 33% pour un bonus de +1 ou +2 et 50% pour un bonus &ge; +3.<br>
				Il est possible d’enchanter seulement certaines parties d’une armure. Appliquer le pourcentage du prix des pièces au coût énergétique, au temps nécessaire et au coût des matériaux.<br>
				Les bonus magiques de RD ne se cumulent pas. Si plusieurs bonus de RD s’appliquent à une même localisation, seul le meilleur prévaudra.<br>
				<b>Indice de puissance&nbsp;:</b> I pour +1&nbsp;; II pour +2.

				<p><b>Exemples de prix</b></p>
				<ul>
					<li><b>Cotte de maille complète BQ+1, taille humaine&nbsp;:</b> 2700 pc</li>
				</ul>
			</details>

			<details class="liste">
				<summary>Boucliers magiques</summary>
				+1 à +4 à la compétence <i>Bouclier</i>. Son poids est réduit comme celui d’une armure.
			</details>

			<details class="liste">
				<summary>Cotte de maille elfique</summary>
				À porter par-dessus des vêtements légers, sans coutil. RD4, poids inférieur de 20 % à une cotte de maille normale (sans coutil). Très souple et totalement silencieuse. Ce n’est pas un objet magique à proprement parler, mais elle peut être enchantée.
			</details>

		</details>

		<details>
			<summary class="h4">Objets divers</summary>
			<details class="liste">
				<summary>Anneau de protection</summary>
				Procure un bonus de +1 à +5 à tous les jets de résistance du porteur.
			</details>

			<details class="liste">
				<summary>Cape elfique</summary>
				Procure un bonus de +5 en <i>Furtivité</i>.
			</details>

			<details class="liste">
				<summary>Gantelets de force</summary>
				Augmente la For de leur porteur (de +1 à +5).
			</details>

			<details class="liste">
				<summary>Sac sans fond</summary>
				Son volume intérieur est vingt fois plus grand que son volume extérieur. Son poids vaut 1/20<sup>e</sup> de que ce qu’il contient. S’il est percé ou déchiré (de l’extérieur comme de l’intérieur), il perd ses propriétés et son contenu disparaît. La dimension des objets ne peut pas excéder vingt fois la dimension du sac.
			</details>

			<details class="liste">
				<summary>Baguette de Boules de feu</summary>
				Une baguette de boules de feu est un objet à charge. Elle est définie par le niveau de puissance des boules de feu qu’elle peut envoyer et par le nombre maximum de charges qu’elle peut contenir (généralement 12). Il est possible d’envoyer des boules de feu d’un niveau inférieur (il suffit que son utilisateur le souhaite), mais cela utilisera dans tous les cas une charge entière.
			</details>


		</details>

		<details>
			<summary class="h4">Eau bénite</summary>
			<p>Les prêtres peuvent fabriquer de l’eau bénite, grâce au sort <i>Bénédiction</i>, s’ils ont ce pouvoir à un score de 15 ou plus. Efficace contre les morts-vivants.<br>
				Au niveau III, le pouvoir permet de créer 5 doses à la fois, au niveau IV, 15 doses et au niveau V, 100 doses. Vendue à 10 pc la dose.</p>
		</details>

	</details>

	<details>
		<summary class="h3">Familiers</summary>
		<p>En plus des familiers cités dans les RdB, il est possible pour un mage d’avoir d’autres familiers plus exotiques.</p>

		<p>Pour disposer d’un démon en tant que familier, le mage doit d’abord l’invoquer (avec le sort <i>Invocation de démon</i>), puis l’asservir (avec le sort <i>Asservissement de démon</i>).</p>

		<h4>Imp (35 pts)</h4>
		<p>Un imp (voir bestiaire) pourra être au service d'un mage avec plus ou moins de bonne volonté selon la personnalité et les objectifs du mage. Dans tous les cas, il conservera une grande indépendance.<br>
			Ses pouvoirs en font un familier capable de fournir une <i>Aide importante</i> en permanence, bien que son caractère fantasque et son indépendance limite sa fiabilité.</p>
		<p>L’imp confère certaines capacités à son maître&nbsp;:<br>
			• <b><i>Communication mentale</i></b> et <b><i>Perception interne</i></b> y compris l’<i>Infravision</i>&nbsp;;<br>
			• <b><i>Résistance à la magie</i> +2</b>&nbsp;;<br>
			• Lorsque l’imp se trouve dans un rayon de 30 m, son maître a <b>+1 à tous ses jets</b> pour utiliser ou détecter la magie (-1 si l’imp se trouve à plus d’un km). Ce modificateur affecte le rituel magique et la réduction en PdM. Lorsque l’imp meurt ou est définitivement chassé, le mage voit ses scores dans tous ses collèges définitivement réduits de 1.</p>

		<h4>Imonoth (30 pts)</h4>
		<p>Les imonoths sont de petites créatures servant d’espions aux mages de Laelith. Eux seuls connaissent le secret de leur invocation et leur origine exacte reste un mystère. Cette créature ailée de la taille d’un pigeon possède deux bras et deux jambes entre lesquels se trouve une voile de peau servant d’ailes, un peu à la manière des lézards volants. Leur peau parfaitement lisse, bleu sombre sauf sur le ventre, où elle est de couleur beige. Leur petite tête ronde est dépourvue de nez. Ils ont deux grands yeux rouge sombre sans pupille et une petite bouche avec de dents fines et pointue.</p>
		<p>Ils sont dotés de nombreux pouvoirs de détection&nbsp;: <i>Vision aquiline</i>, <i>Vision obscure</i> (II) et <i>Vision du mage</i>. Ces pouvoirs sont actifs en permanence et ne coûtent aucun PdM à la créature.</p>
		<p>Ils confèrent à leur maître le pouvoir <i>Perception interne animale</i>. Ils ont une intelligence de 7 et comprennent le langage humain, bien qu’ils ne puissent pas eux-mêmes communiquer par la parole ou la télépathie.</p>
		<p><b>Coût&nbsp;:</b> 5 pts (familier volant) + 5 pts (<i>Int</i> 7) + 5 pts (<i>Perception interne animale</i>) + 15 pts (pouvoirs de <i>Vision</i> utilisables uniquement à travers la <i>Perception interne</i>).</p>


	</details>

</article>

<article><!-- Créatures -->
	<h2>
		<?php if ($_SESSION["Statut"] == 3) { ?>
			<a href="gestion-listes?req=creature&id=0" class="ff-far edit-link">&#xf044;&nbsp;</a>
		<?php } ?>
		Bestiaire
	</h2>

	<details>
		<summary class="h3">Règles générales d’adaptation</summary>

		<h4>Caractéristiques</h4>

		<?php include "content/components/widget-strength-pdv.php" ?>

		<p>
			L’<b>Intelligence</b> est basée sur la description AD&amp;D.<br>
			<i>Animale</i>&nbsp;: 2-5 (voir chapitre <i>Animaux</i>)<br>
			<i>Partielle</i>&nbsp;: 6<br>
			<i>Faible</i>&nbsp;: 7-8<br>
			<i>Moyenne</i>&nbsp;: 9-11<br>
			<i>Haute</i>&nbsp;: 12-13<br>
			<i>Supérieure</i>&nbsp;: 14-15<br>
			<i>Exceptionnelle</i>&nbsp;: 16-17<br>
			<i>Géniale</i>&nbsp;: 18-19<br>
			<i>Supra-géniale</i>&nbsp;: 20+
		</p>

		<p>La <b>Volonté</b> est égale à l’<i>Int</i> pour une créature intelligente (Int &ge; 7, valeur minimale de la <i>Vol</i>&nbsp;: 10) ou à <i>Int</i>×2 pour un animal ou un monstre ayant une intelligence animale (Int &le; 6).</p>

		<p>La <b><i>Vitesse</i></b> est la valeur AD&amp;D divisée par 2 (sauf pour le vol, même valeur).</p>

		<h4>Dégâts</h4>
		<?php include "content/components/widget-creature-dmg.php" ?>

		<h4>Avantages &amp; Désavantages</h4>
		<p><b>• Crainte&nbsp;:</b> la créature craint ou déteste quelque chose et fera tout pour l’éviter. Ce n’est pas une phobie, aucun jet de <i>Sang-Froid</i> n’est à faire. Si la créature ne peut éviter l’objet de sa crainte, elle subira un malus allant de -1 à -3 à tous ses jets de réussite, selon son degré d’exposition à l’objet de sa <i>Crainte</i>.</p>
		<p><b>• Faiblesse&nbsp;:</b> la créature ne tolère pas une certaine substance ou certaines conditions. L’exposition à l’objet de la <i>Faiblesse</i> a des conséquences diverses (ralentissement, paralysie, nausée, perte de PdF, etc.) mais n’inflige pas de dégâts à la créature.</p>
		<p><b>• Vulnérabilité&nbsp;:</b> la créature est <i>soit</i> particu&shy;lièrement sensible à une forme d’attaque, <i>soit</i> susceptible de prendre de dégâts par une substance ou dans des conditions inoffensives pour un être humain.<br>
			<i>Vulnérabilité (eau bénite)</i>&nbsp;: la créature subit 1d+2 pts de dégâts lorsqu’elle reçoit une dose d’eau bénite.
		</p>
		<p><b>• Immunité&nbsp;:</b> la créature est complètement insensible à une forme de dégâts ou un type de magie.<br>
			<i>Immunité (armes normales)</i>&nbsp;: la créature ne peut être blessée par des attaques physiques, sauf par des armes en argent (qui ne font que la moitié des dégâts normaux) ou magiques. Elle subit tout de même 1/4 des dégâts normaux sous forme de <i>Broyage</i> (quelle que soit l’arme) auxquels s’appliquent sa RD (sauf pour les créatures immatérielles). Ce dernier point ne s’applique pas si la créature est immatérielle.
		</p>
		<p><b>• Immunité partielle&nbsp;:</b> la créature subit la moitié des dégâts d’un certain type d’attaque.</p>

		<h4>Catégories de créatures</h4>
		<p><b>• Extraplanaire&nbsp;:</b> ces créatures ne peuvent être tuées ailleurs que sur leur plan d’origine. Ailleurs, elles se dématérialisent à 0 PdV et retournent à leur plan d’origine.</p>
		<p class="mt-1">
			<b>• Non biologique&nbsp;:</b> créatures dénuées de métabolisme &ndash; morts-vivants, créatures immatérielles, créatures animées par magie, etc. Elles «&nbsp;meurent&nbsp;» à 0 PdV. Insensibles à la douleur, jamais sonnées ni assommées. Pas d’organes vitaux. Pour les morts-vivants matériels, le seul multiplicateur de dégâts qui s’applique concerne le crâne et vaut ×2, en tenant compte de la résistance de la boîte cranienne.<br>
			Pour les créatures immatérielles, la localisation n’a aucune importance&nbsp;: considérez toutes les attaques comme portées au torse.<br>
			Immunisées au poison ainsi qu’aux sorts d’<i>Emprise mentale</i> et de <i>Contrôle physique</i>.
		</p>
		<p><i>Squelettique</i>&nbsp;: -3 au toucher et dégâts réduits au minimum avec des armes perforantes. Dégâts tranchants divisés par 2.</p>
		<p class="mt-1"><b>•&nbsp;Créature végétale&nbsp;:</b> mêmes avantages que les créatures «&nbsp;non biologiques&nbsp;», mais elles ne meurent pas à 0 PdV.</p>
		<p class="mt-1"><b>•&nbsp;Créature d’essence magique&nbsp;:</b> utilisent leurs pouvoirs innés avec un score minimum de 16 et le temps nécessaire à leur déclenchement est divisé par deux. Le rythme de récupération des PdM est doublé et sans condition de repos. Tous les démons sont d'essence magique.</p>

		<h4>Pouvoirs</h4>
		<p><b>Demi-coût&nbsp;:</b> lorsqu'une créature possède un pouvoir dont le coût énergétique est réduit de moitié, le coût de maintien est également réduit de moitié, sauf mention contraire.</p>
		<p><b>Drainage d’énergie vitale&nbsp;:</b> un drainage de 1 niveau entraîne la perte définitive d’un pt de <i>San</i> et de <i>For</i>. Le sort <i>Restauration</i> peut annuler cette perte. Ce drainage ne se fait qu’au toucher, mais sa réussite est automatique (aucune dépense de PdM). Aucun jet de résistance permis.</p>
	</details>

	<?php
	$categories = $creatures_repo->getDistinctCategories("ADD");
	foreach ($categories as $categorie) { ?>
		<details>
			<summary class="h3"><?= $categorie ?></summary>
			<div class="mt-½">
				<?php
				$creatures = $creatures_repo->getCreaturesByCategory($categorie, "ADD");
				foreach ($creatures as $creature) {
					$creature->displayInRules($_SESSION["Statut"] === 3);
				}
				?>
			</div>
		</details>
	<?php } ?>

</article>

<script type="module" src="/scripts/magical-items.js?v=<?= VERSION ?>"></script>
<script type="module" src="/scripts/armor-calculator.js?v=<?= VERSION ?>"></script>
<script type="module" src="/scripts/creatures.js?v=<?= VERSION ?>"></script>