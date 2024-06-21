<?php

use App\Lib\Sorter;
use App\Entity\Spell;
use App\Lib\TextParser;
use App\Repository\AvDesavRepository;
use App\Repository\SkillRepository;
use App\Repository\CollegeRepository;
use App\Repository\PowerRepository;
use App\Repository\DisciplineRepository;

$avdesav_repo = new AvDesavRepository;
$skills_repo = new SkillRepository;
$colleges_repo = new CollegeRepository;
$powers_repo = new PowerRepository;
$disciplines_repo = new DisciplineRepository;

$character = $page["character"];
$character->processCharacter(with_state_modifiers: false);
$attributes_names = ["For", "Dex", "Int", "San", "Per", "Vol"];
$pdx_names = ["PdV", "PdF", "PdM", "PdE"];
?>

<form id="noyau" method="post" action="/submit/update-character" enctype="multipart/form-data">

	<input hidden name="id" value="<?= $character->id ?>">
	<input hidden name="Pts" value="<?= $character->points ?>">
	<input hidden name="Portrait" value="<?= $character->portrait ?>">

	<!-- Portrait, description, background, notes -->
	<article class="flow">

		<!-- Nom, sauvegarde et retour fiche perso -->
		<div class="flex-s jc-space-between gap-1 ai-first-baseline">
			<input name="Nom" type="text" value="<?= $character->name ?>" class="fs-500 fw-600 fl-1 px-½">
			<button type="submit" class="ff-fas btn-primary" title="Enregistrer – Alt+Shift+S" accesskey="s">&#xf0c7;</button>
			<a href="personnage-fiche?perso=<?= $character->id ?>" class="btn btn-primary ff-fas" title="Retour à la fiche de perso">&#xf2bb;</a>
		</div>

		<!-- Portrait -->
		<div class="mt-1">
			<img src="<?= $character->portrait ?>" class="fit-cover mx-auto" style="max-height: 350px; max-width: 80%;">
			<label title="Sélectionner une image" class="btn btn-primary mx-auto mt-½">
				Télécharger image (max. 500 ko)
				<input type="file" name="image" data-role=add-portrait hidden>
			</label>
			<p id="file" class="ta-center clr-grey-500"></p>
		</div>

		<h4>Description</h4>
		<p>Cette description sera visible par les autres membres du groupe. Soyez évocateur, sans être trop long.</p>
		<textarea name="Description" form="noyau" placeholder="Description du personnage" class="mt-1" style="min-height: 12em;"><?= $character->description ?></textarea>

		<!-- Background -->
		<details class="mt-1">
			<summary class="h3">Background</summary>
			<textarea name="Background" form="noyau" placeholder="Background du personnage" class="mt-½" style="min-height: 12em;"><?= $character->background ?></textarea>
		</details>

		<!-- Notes -->
		<details class="mt-1">
			<summary class="h3">Notes</summary>
			<textarea name="Notes" form="noyau" placeholder="Notes diverses" class="mt-½" style="min-height: 12em;"><?= $character->notes ?></textarea>
		</details>

		<p class="mt-1 fs-300">Le background et les notes peuvent être mis en forme&nbsp;: *<b>gras</b>*, _<i>italique</i>_ et **<b>titre</b></p>

		<!-- Bilan pts -->
		<fieldset class="mt-1">
			<legend>Bilan des points de personnage</legend>
			<ul>
				<li><b>Valeur du personnage&nbsp;:</b> <?= $character->points ?></li>
				<li><b>Points économisés&nbsp;:</b> <?= $character->points - $character->points_count["total"] ?></li>
			</ul>
			<ul class="mt-½">
				<li><b>Caractéristiques&nbsp;:</b> <?= $character->points_count["attributes"]["total"] ?></li>
				<li><b>Avantages &amp; Désavantages&nbsp;:</b> <?= $character->points_count["avdesav"] ?></li>
				<li><b>Compétences&nbsp;:</b> <?= $character->points_count["skills"] ?></li>
				<?php if ($character->special_traits["magerie"]) { ?>
					<li><b>Magie :</b> <?= $character->points_count["colleges"] + $character->points_count["spells"]; ?></li>
				<?php }
				if ($character->special_traits["pouvoirs"]) { ?>
					<li><b>Pouvoirs :</b> <?= $character->points_count["powers"]  ?></li>
				<?php }
				if ($character->special_traits["psi"]) { ?>
					<li><b>Psi :</b> <?= $character->points_count["disciplines"] + $character->points_count["psi"]; ?></li>
				<?php } ?>
			</ul>
		</fieldset>

	</article>

	<!-- Caractéristiques, Avantages & Désavantages -->
	<article>

		<!-- Caractéristiques -->
		<div>
			<h3 class="mt-0 h3">Caractéristiques</h3>
			<table class="mt-1">
				<tr>
					<?php foreach ($attributes_names as $attr_name) { ?>
						<th><?= $attr_name ?></th>
					<?php } ?>
				</tr>
				<tr>
					<?php foreach ($attributes_names as $attr_name) { ?>
						<td>
							<input name="Caractéristiques[<?= $attr_name ?>]" type="text" value="<?= $character->attributes[$attr_name] ?>" size="1" class="ta-center border-grey-700 fs-500">
						</td>
					<?php } ?>
				</tr>
			</table>
			<div class="ta-center mt-1">
				<b>Dégâts</b> <?= $character->attributes["Dégâts"]['estoc'] . '/' . $character->attributes["Dégâts"]['taille']; ?>&emsp;
				<b>Réf </b> <?= $character->attributes["Réflexes"] ?>&emsp;
				<b>S-F </b> <?= $character->attributes["Sang-Froid"] ?>&emsp;
				<b>Vit </b> <?= round($character->attributes["Vitesse"], 1) ?>
			</div>
			<!-- PdV, PdF, PdM, PdE -->
			<div class="flex-s gap-¾ jc-center mt-½">
				<?php foreach ($pdx_names as $pdx_name) { ?>
					<div>
						<b><?= $pdx_name ?></b> <?= $character->attributes[$pdx_name] ?>
					</div>
				<?php } ?>
			</div>
			<!-- Pouvoirs et psi -->
			<p class="mt-1">
				Le personnage dispose de
				<label>
					<input type="checkbox" name="MPP[pouvoirs]" <?= $character->special_traits["pouvoirs"] ? 'checked' : '' ?>>
					<i>pouvoirs magiques</i>
				</label>
				ou de
				<label>
					<input type="checkbox" name="MPP[psi]" <?= $character->special_traits["psi"] ? 'checked' : '' ?>>
					<i>pouvoirs psioniques</i> (voyez ça avec votre MJ).
				</label>
			</p>
		</div>

		<!-- Mode d’emploi Avdésav -->
		<details class="mt-3-5 border-bottom-grey-700">
			<summary class="h3">Avantages &amp; Désavantages</summary>
			<div class="mt-½">
				<p>
					<b>Nom&nbsp;:</b> à ne modifier que si une précision est nécessaire.<br>
					<b>Coût&nbsp;:</b> coût en pts de personnage. Par défaut, le coût choisi est celui le plus proche de zéro<br>
					<b>Case 1&nbsp;:</b> coût affiché sur la fiche de personnage. Nécessaire s’il y a plusieurs coûts possibles.<br>
					<b>Case 2&nbsp;:</b> non affiché sur la fiche de personnage (mais pris en compte). Utile pour les avantages type <i>PdM supp</i>.
				</p>
				<p><b>Pour supprimer un élément,</b> effacer son nom.</p>
			</div>
		</details>

		<!-- Liste Avdésav du perso -->
		<div class="mt-1" id="avdesav-wrapper">
			<?php
			$n_post = 0;
			$liste_nom_avdesav_perso = [];
			foreach (["Zéro", "Avantage", "Désavantage", "Réputation", "Travers"] as $categorie) { ?>
				<div class="mt-1">
					<?php
					foreach ($character->avdesav as $avdesav) {
						if ($avdesav['catégorie'] === $categorie) { ?>
							<input hidden name="Avdesav[<?= $n_post ?>][id]" value="<?= $avdesav['id'] ?? 0 ?>">
							<details>
								<summary>
									<input type="text" name="Avdesav[<?= $n_post ?>][nom]" value="<?= $avdesav['nom'] ?>" class="fl-1">
									<input type="text" title="Coût" name="Avdesav[<?= $n_post ?>][points]" value="<?= $avdesav['points'] ?>" size="2" class="ta-center" <?= $avdesav['catégorie'] === "Travers" ? "disabled" : "" ?>>
									<div hidden>
										<input type="checkbox" title="Afficher coût" name="Avdesav[<?= $n_post ?>][options][aff_coût]" <?= in_array("aff_coût", $avdesav['options']) ? 'checked' : '' ?> <?= $avdesav['catégorie'] === "Travers" ? "disabled" : "" ?>>
										<input type="checkbox" title="Pas sur fiche" name="Avdesav[<?= $n_post ?>][options][caché]" <?= in_array("caché", $avdesav['options']) ? 'checked' : '' ?> <?= $avdesav['catégorie'] === "Travers" ? "disabled" : "" ?>>
									</div>
								</summary>
								<div class="mt-½ fs-300"><?= $avdesav["description"] ?? "Un travers est un trait de caractère mineur ne constituant pas un désavantage. Il est possible de prendre jusqu’à 5 travers." ?></div>
							</details>
					<?php
							$n_post++;
							$liste_nom_avdesav_perso[] = $avdesav['nom'];
						}
					} ?>
				</div>
			<?php } ?>
		</div>

		<!-- Nouveaux Avdésav -->
		<details>
			<summary class="add-character-element">Ajouter des avantages et désavantages</summary>

			<?php foreach ($avdesav_repo->getDistinctCategories() as $categorie) { ?>
				<details>
					<summary class="h4"><?= $categorie ?></summary>
					<?php foreach ($avdesav_repo->getAvDesavByCategory($categorie) as $avdesav) {
						if (!in_array($avdesav->name, $liste_nom_avdesav_perso)) { ?>
							<details>
								<summary>
									<label class="fl-1">
										<input type="checkbox" name="Avdesav[<?= $n_post ?>][id]" value="<?= $avdesav->id ?>">
										<?= $avdesav->name ?>
									</label>
									<div><?= $avdesav->displayCost() ?></div>&nbsp;
								</summary>
								<div class="mt-½ fs-300"><?= $avdesav->description ?></div>
							</details>
					<?php $n_post++;
						}
					} ?>
				</details>
			<?php } ?>

			<button data-role="add-quirk" type="button" class="mt-1 mx-auto" data-number="<?= $n_post ?>">Ajouter un travers</button>
		</details>


		<!-- Mode d’emploi compétences -->
		<details class="mt-3-5">
			<summary class="h3">Compétences</summary>
			<div class="border-bottom-grey-700 mt-½">
				<p>
					<b>Nom&nbsp;:</b> préciser éventuellement le nom de la compétence<br>
					<b>Modificateur&nbsp;:</b> ajouter le modificateur entre parenthèse à côté du nom. Par exemple&nbsp;: (+2) ou (-1).<br>
					<b>Compétence de background&nbsp;:</b> ajoutez une astéristique à côté du nom.<br>
					<b>Spécialité&nbsp;:</b> indiquer, à côté du nom et entre parenthèses, le nom de la spécialité <i>optionnelle</i>, et le bonus souhaité. Par exemple&nbsp;: Commerce (joaillerie +3).<br>
					<b>Score&nbsp;:</b> indiquer le score souhaité. Si ce score est inférieur au score par défaut, il sera automatiquement ramené au score par défaut.<br>
					<b>Pts &nbsp;:</b> cette valeur est <i>calculée</i> à partir du score souhaité et des différents paramètres que vous avez indiqués (modificateur, &hellip;)<br>
				</p>
				<p>Pour <b>supprimer</b> une compétence, effacer son nom.</p>
				<p><b>Attention&nbsp;:</b> les modificateurs dus à des <i>Avantages</i> ou des <i>Désavantages</i> doivent être rajoutés manuellement.</p>
			</div>
		</details>

		<!-- Liste compétences du perso -->
		<div class="mt-½">
			<?php
			$liste_nom_comp_perso = [];
			foreach ($character->skills as $comp) { ?>

				<div class="flex-s gap-½ ai-first-baseline">
					<input type="text" name="Compétences[<?= $n_post ?>][label]" value="<?= $comp['label'] ?>" class="fl-1">
					<div class="fs-300 ta-center" style="width: 3ch" title="points"><?= $comp['points'] ?></div>
					<input type="text" name="Compétences[<?= $n_post ?>][score]" value="<?= $comp['score'] ?>" size="2" class="ta-center" title="score">
					<input type="hidden" name="Compétences[<?= $n_post ?>][former-score]" value="<?= (int) $comp['score'] ? $comp['score'] : $comp["virtual-score"] ?>">
					<input type="hidden" name="Compétences[<?= $n_post ?>][former-niv]" value="<?= $comp['niv'] ?>">
					<input type="hidden" name="Compétences[<?= $n_post ?>][id]" value="<?= $comp['id'] ?>">
				</div>

			<?php
				$n_post++;
				$liste_nom_comp_perso[] = $comp['label'];
			} ?>
		</div>

		<!-- Nouvelles compétences -->
		<details>
			<summary class="add-character-element">Ajouter des compétences</summary>
			<?php
			$liste_categories_competences_rdb = $skills_repo->getDistinctCategories();
			foreach ($liste_categories_competences_rdb as $categorie) { ?>
				<details>
					<summary class="h4"><?= $categorie ?></summary>
					<?php $liste_choix_comp = $skills_repo->getSkillsByCategory($categorie);

					foreach ($liste_choix_comp as $comp) {
						if (!in_array($comp->name, $liste_nom_comp_perso)) {	?>
							<details>
								<summary>
									<label class="fl-1">
										<input type="checkbox" name="Compétences[<?= $n_post ?>][id]" value="<?= $comp->id ?>">&nbsp;
										<?= $comp->name ?>
									</label>
									<div><?= $comp->base . $comp->readableDifficulty ?></div>&nbsp;
								</summary>
								<div class="mt-½"><?= $comp->description ?></div>
							</details>
					<?php $n_post++;
						}
					} ?>
				</details>
			<?php } ?>
		</details>


		<!-- Magie -->
		<?php if ($character->special_traits["magerie"]) { ?>

			<!-- Mode d’emploi collège et sorts -->
			<details class="mt-3-5">
				<summary class="h3">Collèges &amp; sorts</summary>
				<div class="border-bottom-grey-700 mt-½">
					<p>
						<b>Collèges&nbsp;:</b> même principe que pour les compétences. Vous pouvez ajouter un modificateur entre parenthèse à côté du nom.<br>
						<b>Sorts&nbsp;:</b> préciser le nombre de points investis dans chaque sort (max 5). Vous pouvez ajouter un modificateur à côté du nom du sort.
					</p>
				</div>
			</details>

			<!-- Collèges et sorts -->
			<div class="mt-½">
				<?php
				foreach ($character->colleges as $college) {
				?>
					<details>
						<summary class="flex-s gap-½ ai-first-baseline">
							<input type="text" name="Collèges[<?= $n_post ?>][name]" value="<?= $college["name"] ?>" class="fl-1">
							<div class="ta-center fs-300" style="width: 3ch" title="Pts"><?= $college["points"] ?></div>
							<input type="text" name="Collèges[<?= $n_post ?>][score]" value="<?= $college["score"] ?>" style="width: 3ch" class="ta-center" title="Score">
							<input hidden name="Collèges[<?= $n_post ?>][id]" value="<?= $college["id"] ?>">
							<input hidden name="Collèges[<?= $n_post ?>][former-score]" value="<?= $college["score"] ?>">
							<input hidden name="Collèges[<?= $n_post ?>][former-niv]" value="<?= $college["niv"] ?>">
						</summary>
						<div class="mt-½">
							<?php $n_post++; ?>

							<?php
							foreach ($character->spells as $sort) {
								if (in_array($college["id"], $sort["data"]->colleges)) {
							?>

									<div class="flex-s gap-½ ai-first-baseline">
										<input type="text" name="Sorts[<?= $n_post ?>][name]" value="<?= $sort["label"] ?>" class="fl-1">
										<input type="text" name="Sorts[<?= $n_post ?>][points]" value="<?= $sort["points"] ?>" style="width: 3ch" class="ta-center">
										<div style="width: 11ch" class="ta-right fs-300"><?= $sort["readable_scores"] ?></div>
										<input hidden name="Sorts[<?= $n_post ?>][id]" value="<?= $sort["id"] ?>" />
										<input hidden name="Sorts[<?= $n_post ?>][former-points]" value="<?= $sort["points"] ?>" />
										<input hidden name="Sorts[<?= $n_post ?>][former-modif]" value="<?= $sort["modif"] ?>" />
									</div>

							<?php
									$n_post++;
								}
							}
							?>
						</div>

					</details>
				<?php } ?>
			</div>

			<!-- Nouveaux collèges -->
			<details>
				<summary class="add-character-element">Ajouter des collèges</summary>
				<?php
				$all_colleges = $colleges_repo->getAllColleges();
				$known_colleges_id = array_map(fn ($x) => $x["id"], $character->colleges);
				foreach ($all_colleges as $college) {
					if (!(in_array($college->id, $known_colleges_id) || $college->id === 22)) { ?>

						<div>
							<label>
								<input type="checkbox" name="Collèges[<?= $n_post++ ?>][id]" value="<?= $college->id ?>">
								<?= $college->name ?>
							</label>

						</div>
				<?php $n_post++;
					}
				} ?>
			</details>

		<?php } ?>

		<!-- Pouvoirs -->
		<?php if ($character->special_traits["pouvoirs"]) { ?>

			<!-- Mode d’emploi pouvoirs -->
			<details  class="mt-3-5">
				<summary class="h3">Pouvoirs</summary>
				<div class="border-bottom-grey-700 mt-½">
					<p>
						<b>Ajouter un pouvoir&nbsp;:</b> sélectionner le pouvoir souhaité. Il sera ajouté à son coût minimum.<br>
						<b>Modificateur&nbsp;:</b> à préciser à côté du nom du pouvoir.
						<b>Case «&nbsp;Pts&nbsp;»&nbsp;:</b> points investis dans le <i>score</i> du pouvoir s’il s'agit d’un sort, ou dans le pouvoir lui-même s'il est de type <i>Avantage</i><br>
						<b>×&nbsp;:</b> Multiplicateur de points investis. Il vaut 1 par défaut. Pour les pouvoirs de type <i>Avantage</i>, le multiplicateur s’applique aux points indiqués dans la case Pts. Il faut donc indiquer dans cette case le coût <i>normal</i> du pouvoir.<br>
						<b>Supprimer un pouvoir&nbsp;:</b> effacer son nom.
					</p>
				</div>
			</details>

			<!-- Pouvoirs acquis -->
			<div class="mt-½">
				<?php foreach ($character->powers as $pouvoir) {
					$type = $pouvoir["data"]->specific["Type"] ?? $pouvoir["origine"];
					$niv_min = $pouvoir['data']->data->niv_min ?? 0;
					$niv_max = $pouvoir['data']->data->niv_max ?? 0;
					$global_mult = ($pouvoir["data"]->specific["Mult"] ?? 1) * ($pouvoir["mult"] ?? 1);
				?>
					<details class="fs-300">
						<summary>
							<input type="text" class="fl-1" name="Pouvoirs[<?= $n_post ?>][nom]" value="<?= $pouvoir["data"]->specific["Nom"] ??  $pouvoir["data"]->data->name . (isset($pouvoir["modif"]) ? " (+" . $pouvoir["modif"] . ")" : "") ?>">
							<div class="flex-s jc-space-between ai-first-baseline">
								<div class="radio-wrapper">
									<?php if ($type === "sort") {
										for ($i = 1; $i <= 5; $i++) {
											$is_possible = $niv_min <= $i && $niv_max >= $i; ?>

											<input type="radio" name="Pouvoirs[<?= $n_post ?>][niv]" value="<?= $i ?>" <?= $pouvoir['niv'] === $i ? 'checked' : '' ?> <?= (!$is_possible) ? "disabled" : "" ?> title="<?= $is_possible ? (Spell::cost_as_power[$i - 1] * $global_mult . " pts") : "" ?>">

										<?php }
									} elseif ($type === "avantage") { ?>
										<i>Avantage</i>
									<?php } ?>
								</div>
								<input type="text" name="Pouvoirs[<?= $n_post ?>][points]" value="<?= $pouvoir["points"] ? $pouvoir["points"] : "" ?>" size="1" class="ta-center" placeholder="pts" />&nbsp;
							</div>
						</summary>
						<div class="flex-s jc-space-between mt-½ gap-½">
							<input type="text" name="Pouvoirs[<?= $n_post ?>][mult]" value="<?= $pouvoir["mult"] ?? "" ?>" style="width: 6ch" class="ta-center" placeholder="×" title="Multiplicateur de coût en pts de personage">
							<input type="text" name="Pouvoirs[<?= $n_post ?>][notes]" value="<?= $pouvoir["notes"] ?? "" ?>" class="fl-1" placeholder="Notes">&nbsp;
						</div>
						<div class="fs-300">
							<?php if ($type === "sort") {
								$pouvoir["data"]->data->displayFullDescription();
							} else { ?>
								<div class="mt-½">
									<?= $pouvoir["data"]->data->description ?>
								</div>
							<?php } ?>
						</div>
						<input hidden name="Pouvoirs[<?= $n_post ?>][origine]" value="<?= $pouvoir["origine"] ?>">
						<input hidden name="Pouvoirs[<?= $n_post ?>][id]" value="<?= $pouvoir["id"] ?>">
					</details>
				<?php
					$n_post++;
				} ?>
			</div>

			<!-- Nouveaux pouvoirs -->
			<details>
				<summary class="add-character-element">Ajouter des pouvoirs</summary>

				<?php if (!in_array($character->special_traits["type-perso"], ["ins"])) { ?>
					<details>
						<summary class="h4">Pouvoirs type Avantage</summary>
						<div class="mt-½ fs-300">
							<?php
							$avdesav_powers = $powers_repo->getAllPowers("avantage");
							foreach ($avdesav_powers as $power) { ?>
								<label class="flex-s gap-½">
									<input type="checkbox" name="Nouveaux-pouvoirs[avantage][<?= $power->id ?>][id]" value="<?= $power->id ?>">
									<div class="fl-1"><?= $power->data->name ?></div>
									<div><?= $power->data->displayCost() ?></div>
								</label>
							<?php } ?>
						</div>
					</details>
					<details class="mt-1">
						<summary class="h4">Pouvoirs type Sort</summary>
						<div class="mt-½ fs-300">
							Il y a de trop nombreux sorts pour en faire la liste ici. Aller sur la page <a href="/avdesav-comp-sorts">Listes pour le personnage</a> et noter les id des sorts que vous souhaitez obtenir en tant que pouvoirs dans la case ci-dessous. Pour obtenir l’id d’un sort, placer le curseur sur son nom.
							<input type="text" name="Nouveaux-pouvoirs[sort]" class="full-width mt-½">
						</div>
					</details>
				<?php } ?>

				<?php if ($character->special_traits["type-perso"] === "ins") { ?>
					<details class="mt-1">
						<summary class="h4">Pouvoirs In Nomine Ange</summary>
						<div class="mt-½ fs-300">
							<?php
							$ins_powers = $powers_repo->getAllPowers("ins");
							$angel_powers = array_filter($ins_powers, fn ($x) => $x->specific["Domaine"] !== "Démon");
							$angel_powers = Sorter::sortPowersByName($angel_powers);
							foreach ($angel_powers as $power) { ?>
								<label class="flex-s gap-½">
									<input type="checkbox" name="Nouveaux-pouvoirs[ins][<?= $power->id ?>][id]" value="<?= $power->id ?>">
									<div class="fl-1">
										<?= $power->specific["Nom"] ?? $power->data->name ?>
										<?= isset($power->data->readableNiv) ? " (" . $power->data->readableNiv . ")" : "" ?>
									</div>
									<div><?= $power->data->displayCost($power->specific["Mult"] ?? 1) ?></div>
								</label>
							<?php } ?>
						</div>
					</details>
					<details class="mt-1">
						<summary class="h4">Pouvoirs In Nomine Démon</summary>
						<div class="mt-½ fs-300">
							<?php
							$ins_powers = $powers_repo->getAllPowers("ins");
							$demon_powers = array_filter($ins_powers, fn ($x) => $x->specific["Domaine"] !== "Ange");
							$demon_powers = Sorter::sortPowersByName($demon_powers);
							foreach ($demon_powers as $power) { ?>
								<label class="flex-s gap-½">
									<input type="checkbox" name="Nouveaux-pouvoirs[ins][<?= $power->id ?>][id]" value="<?= $power->id ?>">
									<div class="fl-1">
										<?= $power->specific["Nom"] ?? $power->data->name ?>
										<?= isset($power->data->readableNiv) ? " (" . $power->data->readableNiv . ")" : "" ?>
									</div>
									<div><?= $power->data->displayCost($power->specific["Mult"] ?? 1) ?></div>
								</label>
							<?php } ?>
						</div>
					</details>
				<?php } ?>


			</details>

		<?php } ?>

		<!-- Psionique -->
		<?php if ($character->special_traits["psi"]) { ?>

			<!-- Mode d’emploi psi -->
			<details  class="mt-3-5">
				<summary class="h3">Psi</summary>
				<div class="bored-bottom-grey-700 mt-½">
					<p>
						<b>Ajouter une nouvelle discipline&nbsp;:</b> sélectionner la discipline souhaitée. Elle sera ajoutée au niveau 1.<br>
						<b>×&nbsp;:</b> multiplicateur de coût dû à d’éventuelles limitations ou améliorations.<br>
						<b>Notes&nbsp;:</b> préciser les éventuelles limitations ou améliorations.<br>
						<b>Pouvoirs&nbsp;:</b> préciser le score souhaité. Ajouter un éventuel modificateur à côté du nom du pouvoir.<br>
						<b>Supprimer une discipline&nbsp;:</b> mettre son niveau à 0.<br>
						<b>Supprimer un pouvoir&nbsp;:</b> mettre son score à 0.
					</p>
				</div>
			</details>

			<!-- Disciplines et pouvoirs connus -->
			<div class="mt-½">
				<?php
				$disciplines_connues_id = [];
				foreach ($character->disciplines as $discipline) {
					$disciplines_connues_id[] = $discipline["id"];
				?>
					<details>
						<summary>
							<div class="fl-1"><?= $discipline["nom"] ?></div>
							<div>
								<input type="text" name="Psi-disciplines[<?= $n_post ?>][niv]" value="<?= $discipline["niv"] ?>" size="1" class="ta-center" title="Niveau">
								<input type="text" name="Psi-disciplines[<?= $n_post ?>][mult]" value="<?= $discipline["mult"] ?? "" ?>" size="2" class="ta-center" placeholder="×" title="Multipliateur dû à une amélioration ou une limitation">&nbsp;
							</div>
							<input hidden name="Psi-disciplines[<?= $n_post ?>][id]" value="<?= $discipline["id"] ?>">
						</summary>
						<input type="text" name="Psi-disciplines[<?= $n_post ?>][notes]" value="<?= $discipline["notes"] ?? "" ?>" class="full-width mb-½" placeholder="Notes">
						<?php
						$n_post++;
						foreach ($character->psi as $pouvoir) {
							if (in_array($discipline["id"], $pouvoir["data"]->data->colleges)) {
						?>
								<div class="flex-s gap-½ fs-300 ai-first-baseline">
									<input type="text" class="fl-1" name="Psi-pouvoirs[<?= $n_post ?>][nom]" value="<?= $pouvoir["data"]->name ?> (<?= $pouvoir["data"]->data->readableNiv ?>) <?= $pouvoir["modif"] ? ("(" . TextParser::parseInt2Modif($pouvoir["modif"]) . ")") : "" ?>">
									<div><?= $pouvoir["points"] ?></div>
									<input type="text" name="Psi-pouvoirs[<?= $n_post ?>][score]" value="<?= $pouvoir["base-score"] ?>" style="width: 3ch" class="ta-center">
									<input hidden name="Psi-pouvoirs[<?= $n_post ?>][id]" value="<?= $pouvoir["id"] ?>">
									<input hidden name="Psi-pouvoirs[<?= $n_post ?>][former-score]" value="<?= $pouvoir["base-score"] ?>">
									<input hidden name="Psi-pouvoirs[<?= $n_post ?>][former-niv]" value="<?= $pouvoir["niv"] ?>">
								</div>
						<?php $n_post++;
							}
						} ?>
					</details>
				<?php } ?>
			</div>

			<!-- Nouvelles disciplines psi -->
			<?php $disciplines = $disciplines_repo->getAllDisciplines(); ?>
			<details>
				<summary class="add-character-element">Ajouter des disciplines</summary>
				<?php
				foreach ($disciplines as $discipline) {
					if (!in_array($discipline->id, $disciplines_connues_id)) {
				?>
						<label class="flex-s gap-½">
							<input type="checkbox" name="Psi-disciplines[<?= $n_post ?>][id]" value="<?= $discipline->id ?>">
							<?= $discipline->name ?>
						</label>
				<?php }
				} ?>

			</details>
		<?php } ?>

	</article>

	<input hidden name="for-processing[init-attributes][For]" value="<?= $character->attributes["For"] ?>">
	<input hidden name="for-processing[init-attributes][Dex]" value="<?= $character->attributes["Dex"] ?>">
	<input hidden name="for-processing[init-attributes][Int]" value="<?= $character->attributes["Int"] ?>">
	<input hidden name="for-processing[init-attributes][San]" value="<?= $character->attributes["San"] ?>">
	<input hidden name="for-processing[init-attributes][Per]" value="<?= $character->attributes["Per"] ?>">
	<input hidden name="for-processing[init-attributes][Vol]" value="<?= $character->attributes["Vol"] ?>">

	<input hidden name="for-processing[cost-mult][For]" value="<?= $character->attr_cost_multipliers["For"] ?>">
	<input hidden name="for-processing[cost-mult][Dex]" value="<?= $character->attr_cost_multipliers["Dex"] ?>">
	<input hidden name="for-processing[cost-mult][Int]" value="<?= $character->attr_cost_multipliers["Int"] ?>">
	<input hidden name="for-processing[cost-mult][San]" value="<?= $character->attr_cost_multipliers["San"] ?>">
	<input hidden name="for-processing[cost-mult][Per]" value="<?= $character->attr_cost_multipliers["Per"] ?>">
	<input hidden name="for-processing[cost-mult][Vol]" value="<?= $character->attr_cost_multipliers["Vol"] ?>">

	<input hidden name="for-processing[status]" value="<?= $character->status ?>">

</form>

<script src="/scripts/character-edit<?= PRODUCTION ? ".min" : "" ?>.js?v=<?= VERSION ?>" type="module"></script>