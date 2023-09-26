<?php

use App\Lib\TextParser;
use App\Repository\EquipmentRepository;

$character = $page["character"];
$character->processCharacter(with_state_modifiers: true);
$attributes_names = ["For", "Dex", "Int", "San", "Per", "Vol"];
$pdx_names = ["PdV", "PdF", "PdM", "PdE"];
?>

<!-- Description, caractéristiques, état perso & Avantages-Désavantages -->
<article>

	<div class="flex-s ai-center mt-½ gap-½">
		<h3 class="fl-1" id="character-name" data-id="<?= $character->id ?>"><?= $character->name ?></h3>
		<a href="personnage-gestion?perso=<?= $character->id ?>" title="Éditer – Alt+Shift+E" accesskey="e" class="btn ff-fas ">&#xf013;</a>
		<button type="submit" form="form-equipment" class="ff-fas" title="Sauvegarder (enter)">&#xf0c7;</button>
		<button type="button" data-role="refresh-character" class="ff-fas" title="Actualiser">&#xf2f1;</button>
	</div>
	<div class="ta-center mt-½ fs-300">
		Pts&nbsp;: <?= $character->points ?> | éco&nbsp;: <?= $character->points - $character->points_count["total"] ?>
	</div>
	<div class="mt-1">
		<?= nl2br($character->description) ?>
	</div>

	<!-- Caractéristiques -->
	<div class="flex-s gap-¾ mt-1 jc-center">
		<?php foreach ($attributes_names as $attr_name) { ?>
			<div>
				<b><?= $attr_name ?></b> <?= $character->attributes[$attr_name] ?>
			</div>
		<?php } ?>
	</div>

	<div class="ta-center mt-½">
		<b>Dégâts</b> <?= $character->attributes["Dégâts"]['estoc'] . '/' . $character->attributes["Dégâts"]['taille']; ?>&emsp;
		<b>Réf </b> <?= $character->attributes["Réflexes"] ?>&emsp;
		<b>S-F </b> <?= $character->attributes["Sang-Froid"] ?>&emsp;
		<b>Vit </b> <?= $character->attributes["Vitesse"] ?>
	</div>

	<!-- PdV, PdF, PdM, PdE -->
	<div class="flex-s gap-¾ jc-center mt-½">
		<?php foreach ($pdx_names as $pdx_name) {
			$pdxm = $character->attributes[$pdx_name];
			$pdx = $character->state[$pdx_name];
		?>
			<div class="ta-center">
				<b><?= $pdx_name ?></b> <?= $pdxm ?><br>
				<meter min="0" low="<?= $pdxm * 0.26 ?>" high="<?= $pdxm * 0.5 ?>" optimum="<?= $pdxm * 0.51 ?>" max="<?= $pdxm ?>" value="<?= $pdx ?>" title="<?= $pdx ?>"></meter>
			</div>
		<?php } ?>
	</div>

	<!-- État du personnage -->
	<fieldset class="mt-1">
		<legend>État</legend>
		<ul>
			<li><b>Encombrement&nbsp;:</b> <?= $character->carried_weight ?> kg – <?= $character->state["Encombrement"]["description"] ?></li>
			<?php if ($character->state["Fatigue"]["dex-modifier"]) { ?>
				<li><b>Fatigue&nbsp;:</b> <?= $character->state["Fatigue"]["description"] ?></li>
			<?php } ?>
			<?php if ($character->state["Stress"]["sf-modifier"]) { ?>
				<li><b>Stress&nbsp;:</b> <?= $character->state["Stress"]["description"] ?></li>
			<?php } ?>
			<?php if ($character->state["Santé-mentale"]["sf-modifier"]) { ?>
				<li><b>Santé mentale&nbsp;:</b> <?= $character->state["Santé-mentale"]["description"] ?></li>
			<?php } ?>
			<?php if ($character->state["Blessures"]["dex-modifier"]) { ?>
				<li><b>Blessures générales&nbsp;:</b> <?= $character->state["Blessures"]["description"] ?></li>
			<?php } ?>
			<?php foreach ($character->state["Membres"] as $member) { ?>
				<li><?= $member ?></li>
			<?php } ?>
			<?php foreach ($character->state["Autres"] as $other_element) { ?>
				<li><?= trim($other_element) ?></li>
			<?php } ?>
			<?php foreach ($character->state["Compteurs-equipement"] ?? [] as $counter) { ?>
				<li>
					<div class="flex-s ai-first-baseline">
						<div class="fl-1">
							<?= $counter["label"] ?>
							<?php if ($counter["unit"] !== "%") { ?>
								(<?= $counter["max"] ?> <?= $counter["unit"] ?>)
							<?php } ?>
						</div>
						<meter min="0" low="<?= $counter["max"] / 3.99 ?>" high="<?= $counter["max"] / 2 ?>" optimum="<?= $counter["max"] / 1.99 ?>" max="<?= $counter["max"] ?>" value="<?= $counter["current"] ?>" title="<?= $counter["current"] ?> <?= $counter["unit"] ?>" style="width: 6ch"></meter>
					</div>
				</li>
			<?php } ?>
		</ul>
		<!-- pour calcul dégâts armes (character.js) -->
		<div id="for-deg" hidden><?= $character->attributes["For"] + $character->modifiers["Dégâts"] ?></div>
	</fieldset>

	<!-- Avantages, Désavantages & Travers -->
	<h4 class="mt-1">Avantages &amp; Désavantages</h4>
	<?php
	foreach (["Zéro", "Avantage", "Désavantage", "Réputation", "Travers"] as $categorie) {
		$sublist = [];
		foreach ($character->avdesav as $avdesav) {
			if ($avdesav["catégorie"] === $categorie and !in_array("caché", $avdesav['options'])) {
				$sublist[] = $avdesav["label"];
			}
		}
	?>
		<div class="mt-½"><?= implode("&nbsp;; ", $sublist) ?></div>
	<?php } ?>

</article>

<!-- Compétences -->
<article>
	<h4 class="mb-½">Compétences</h4>
	<?php foreach ($character->skills as $comp) {	?>
		<div class="flex-s alternate-o">
			<div class="fl-1"><?= $comp["label"] ?></div>
			<div><?= $comp["score"] ?></div>
		</div>
	<?php } ?>
</article>

<!-- Possessions, sorts & pouvoirs -->
<article>

	<!-- Possessions -->
	<form id="form-equipment"> <!-- action="/submit/equipment-list" method="post" -->

		<?php
		$n_obj = 0;
		foreach ($character->equipment as $sublist) {
			$sublist["lieu"] = in_array($sublist["lieu"], ["pi", "pe"]) ? ($sublist["lieu"] . "_" . $character->id) : $sublist["lieu"];
		?>

			<!-- Container wrapper -->
			<details class="mb-1 p-½ border-grey-700" data-role="container-wrapper" data-place="<?= $sublist["lieu"] ?>">

				<!-- Container title -->
				<summary class="h4 gap-1 ai-center">
					<h4 class="mt-0 flex-s gap-½ fl-1">
						<div class="fl-1"><?= $sublist["nom"] ?></div>
						<div><?= $sublist["sur-soi"] ? (round($sublist["poids"], 1) . "&nbsp;kg") : "" ?></div>
					</h4>
				</summary>

				<!-- Container controls -->
				<div class="flex-s ai-center gap-1½ py-½" data-role="container-controls">

					<button class="ff-fas nude" title="ajouter un objet" data-role="item-add" type="button">
						&#xf055;
					</button>
					<div class="flex-s gap-½ fl-1">
						<button class="ff-fas nude" title="monter le bloc" data-role="container-up" type="button">&#xf0aa;</button>
						<button class="ff-fas nude" title="descendre le bloc" data-role="container-down" type="button">&#xf0ab;</button>
					</div>

					<?php if ($sublist["id"]) { ?>
						<label class="ff-fas" title="transformer en objet simple">
							&#xf057;
							<input type="checkbox" name="objet[<?= $sublist["id"] ?>][Contenant-off]" <?= $sublist["non-vide"] ? "disabled" : "" ?>>
						</label>
						<label class="ff-fas" title="rendre visible pour le groupe">
							&#xe533;
							<input type="checkbox" name="sub-list[<?= $sublist["id"] ?>][Groupe]" <?= !empty($sublist["groupe"]) ? "checked" : "" ?> value="<?= $character->id_group ?>">
						</label>
					<?php } ?>

				</div>

				<!-- Items list -->
				<?php foreach ($sublist["liste"] as $item) {
					$n_obj++ ?>

					<details class="items-list" id="item-<?= $n_obj ?>" data-role="item-wrapper">
						<summary class="grid gap-½ ai-center">
							<div class="ff-fas" draggable="true" data-role="item-grip">&#xf58e;</div>
							<input name="objet[<?= $item->id ?>][Nom]" type="text" value="<?= $item->name ?>" placeholder="Nouvel objet" <?= $item->isContainer ? "class=\"fw-600\"" : "" ?>>
							<input name="objet[<?= $item->id ?>][Poids]" title="poids" type="text" value="<?= $item->weight ?>" class="ta-center <?= ($item->weight === null && $item->id) ? "manquant" : "" ?> <?= $item->isContainer ? "clr-grey-700" : "" ?>">
						</summary>
						<div class="grid">
							<input name="objet[<?= $item->id ?>][Notes]" type="text" value="<?= $item->notes ?>" placeholder="Notes" data-role="item-notes">
							<?php if ($_SESSION["Statut"] >= 2 && ($character->id_gm === $_SESSION["id"] || !$character->id_gm)) { ?>
								<input name="objet[<?= $item->id ?>][Secret]" type="text" value="<?= $item->secret ?>" placeholder="Notes du MJ" class="color1" data-role="item-notes">
							<?php } ?>
							<input hidden name="objet[<?= $item->id ?>][Lieu]" value="<?= $item->place ?>" data-role="item-place">
							<input hidden name="objet[<?= $item->id ?>][Contenant]" value="<?= $item->isContainer ?>">
						</div>
					</details>

				<?php } ?>

				<div data-role=free-slot style="height: 0.75em;"></div>

			</details>
		<?php } ?>

		<div id="item-transfer"><!-- temporary wrapper for item transfer, used in character.js --></div>
		<input type="hidden" name="id_perso" value="<?= $character->id ?>">

	</form>

	<!-- Magie, pouvoirs, psioniques -->
	<?php if ($character->special_traits["magerie"]) { ?>
		<h4 class="mt-1 mb-½">Magie</h4>
		<?php foreach ($character->colleges as $college) { ?>

			<details class="liste">
				<summary>
					<div><?= $college["name"] ?></div>
					<div><?= $college["score"] ?></div>
				</summary>

				<?php foreach ($character->spells as $sort) {
					if (in_array($college["id"], $sort["data"]->colleges) && (max($sort["scores"]) >= 12)) { ?>

						<details class="sous-liste">
							<summary>
								<div>
									<?= $sort["label"] ?>
									<?php if (!in_array($sort["data"]->class, ["Enchantement"])) { ?>
										[<?= $sort["readable_costs"] ?>]
									<?php } ?>
								</div>
								<div><?= $sort["readable_scores"] ?></div>
							</summary>

							<div class="fs-300">
								<?= $sort["data"]->displayFullDescription($sort["readable_time"]) ?>
							</div>
						</details>

				<?php }
				} ?>

			</details>
		<?php }
	}

	if ($character->special_traits["pouvoirs"]) { ?>
		<h4 class="mt-1 mb-½">Pouvoirs</h4>
		<div>
			<?php
			foreach ($character->powers as $pouvoir) {
				$type = $pouvoir["data"]->specific["Type"] ?? $pouvoir["origine"];
			?>
				<details class="liste">
					<summary>
						<div><?= $pouvoir["label"] ?></div>
						<div><?= $pouvoir["score"] ?></div>
					</summary>
					<div class="fs-300">
						<?php if ($type === "sort") {
							$pouvoir["data"]->data->displayFullDescription();
						} else { ?>
							<div class="mt-½">
								<?= $pouvoir["data"]->data->description ?>
							</div>
						<?php } ?>
					</div>
				</details>
			<?php } ?>
		</div>
	<?php } ?>

	<?php if ($character->special_traits["psi"]) {	?>
		<h4>Psi</h4>
		<?php foreach ($character->disciplines as $discipline) { ?>
			<details class="liste">
				<summary>
					<div><?= $discipline["nom"] ?></div>
					<div>Niv. <?= $discipline["niv"] ?></div>
				</summary>

				<?php if (isset($discipline["notes"])) { ?>
					<div class="mt-½"><i><?= $discipline["notes"] ?></i></div>
				<?php } ?>

				<?php foreach ($character->psi as $pouvoir) {
					if (in_array($discipline["id"], $pouvoir["data"]->data->colleges) && $pouvoir["readable-score"]) { ?>

						<details class="sous-liste">
							<summary>
								<div><?= $pouvoir["data"]->name ?> (<?= $pouvoir["data"]->data->readableNiv ?>) [<?= $pouvoir["readable-cost"] ?>]</div>
								<div><?= $pouvoir["readable-score"] ?></div>
							</summary>
							<div class="fs-300">
								<?php $pouvoir["data"]->data->displayFullDescription(); ?>
							</div>
						</details>

				<?php }
				} ?>

			</details>
	<?php }
	} ?>

</article>

<!-- Divers -->
<article class="no-print">

	<!-- Portraits -->
	<div class="mt-½">
		<img src="<?= $character->portrait ?>" width="180" class="mx-auto" />

		<div class="flex-s mt-1 gap-1 jc-center">
			<?php if ($character->id_group < 100) {
				foreach ($character->group_members as $group_member) { ?>
					<div data-place="pi_<?= $group_member->id ?>" data-role="item-transfer" data-name="<?= $group_member->name ?>">
						<img height="<?= count($character->group_members) < 5 ? 70 : 60 ?>" src="<?= $group_member->portrait ?>" class="mx-auto" title="<?= $group_member->description ?>" />
						<div class="ta-center"><?= $group_member->name ?></div>
					</div>
			<?php }
			} ?>
		</div>

	</div>

	<!-- Mode d’emploi form équipement -->
	<details class="mt-1">
		<summary class="fw-700">Mode d’emploi de la liste de possessions</summary>
		<p><b>Ajouter un objet&nbsp;:</b> cliquer sur <span class="ff-fas">&#xf055;</span> dans l’emplacement désiré.</p>
		<p><b>Supprimer un objet&nbsp;:</b> effacer son nom. Attention&nbsp;: si vous effacez un objet-contenant, vous perdrez tout son contenu avec&nbsp;!</p>
		<p><b>Transformer un objet en contenant&nbsp;:</b> Insérer * devant son nom.</p>
		<p><b>Transformer un contenant en objet simple&nbsp;:</b> cocher la case <span class="ff-fas">&#xf057;</span> dans la liste associée au contenant (pas possible si le contenant n’est pas vide).</p>
		<p><b>Déplacer un objet</b> (vers un autre endroit, ou à l’intérieur d’une liste, ou vers un autre personnage)&nbsp;: faire un <i>glisser-déposer</i> en vous servant de la poignée <span class="ff-fas">&#xf58e;</span> . Attention&nbsp;: la liste de destination doit être dépliée pour pouvoir faire le transfert.</p>
		<p><b>Partager</b> le contenu d’un contenant&nbsp;: cliquer sur la case <span class="ff-fas">&#xe533;</span>. Les autres membres du groupe pourront voir ce contenu (mais pas le modifier).</p>
		<p><b>Calcul automatique des dégâts</b> des armes blanches&nbsp;:</p>
		<ol>
			<li>Entrez dans les <b>notes</b> de l’objet le ou les <b>codes de dégâts</b> de l’arme <i>tels que</i> donnés dans les règles (ex. P.e+1, T.t-2, B.t&hellip;), en tenant compte d’un éventuel bonus de qualité ou de magie.</li>
			<li>Pour une <b>arme maniée à deux mains</b>, si le maniement à deux mains est optionnel, insérez le caractère † dans les notes (n’importe où). S’il est obligatoire, entrez le caractère ‡.</li>
			<li>Vous pouvez lire la <b>valeur des dégâts calculés</b> (le cas échéant) en survolant les notes avec le curseur.</li>
		</ol>
		<p>
			<b>Créer un compteur</b> associé à un objet&nbsp;: ajouter au nom de l’objet les motifs <i>nombre/nombre</i> ou <i>(nombre %)</i>.<br>
			Ces nombres peuvent être entiers ou décimaux (séparateur décimal&nbsp;: point).<br>
		</p>

	</details>

	<!--Notes -->
	<?php if (!empty($character->notes)) { ?>
		<details>
			<summary class="h3">Notes</summary>
			<div class="mt-½">
				<?= TextParser::pseudoMDParser($character->notes) ?>
			</div>
		</details>
	<?php } ?>

	<!-- Background -->
	<?php if (!empty($character->background)) { ?>
		<details>
			<summary class="h3">Background</summary>
			<div class="mt-½"><?= TextParser::pseudoMDParser($character->background) ?></div>
		</details>
	<?php } ?>

	<!-- Équipement de groupe -->
	<?php
	$equipement_repo = new EquipmentRepository;
	$possessions_communes = $equipement_repo->getCommonGroupEquipment($character->id_group);
	if ($possessions_communes) { ?>
		<details class="flow">
			<summary class="h3">Possessions de groupe</summary>
			<?php foreach ($possessions_communes as $key => $liste_contenant) {
				$liste_contenant_string = implode("&nbsp;; ", array_map(function ($item) {
					$counter = TextParser::parseObjectCounter($item["Nom"]);
					return $counter ? $counter["label"] : $item["Nom"];
				}, $liste_contenant));
			?>
				<p><b><?= $key ?>&nbsp;:</b> <?= $liste_contenant_string ?></p>
			<?php } ?>
		</details>
	<?php } ?>

</article>

<script src="scripts/character-sheet.js" type="module" data-type="reloadable"></script>