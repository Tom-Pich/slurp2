<?php

use App\Lib\TextParser;
use App\Repository\EquipmentRepository;

$character = $page["character"];
$character->processCharacter(with_state_modifiers: true);
$character_uses_pdm = $character->special_traits["magerie"] || $character->special_traits["pouvoirs"];
$attributes_names = ["For", "Dex", "Int", "San", "Per", "Vol"];
$pdx_names = ["PdV", "PdF", "PdM", "PdE"];
$compact = $page["style"] === "compact";

// modifies text color if score has changed due to character state
function color_modifier($original_score, $actual_score)
{
	if ($actual_score < $original_score) return "style='color: var(--clr-invalid)'";
	elseif ($actual_score > $original_score) return "style='color: var(--clr-secondary-500)'";
	return "";
}
?>

<div id="ws-data" hidden data-session-id="<?= $_SESSION["id"] ?>" data-ws-key="<?= WS_KEY ?>"></div>

<!-- Description, caractéristiques, état, portraits -->
<div class="no-break">
	<!-- Nom + accès éditeur -->
	<div class="flex-s gap-1 jc-space-between ai-center" style="padding-top: .25em;">
		<h3 id="character-name" data-id="<?= $character->id ?>" data-gm="<?= $character->id_gm ?>">
			<?= $character->name ?>
		</h3>
		<a href="personnage-gestion?perso=<?= $character->id ?>" title="Éditer – Alt+Shift+E" accesskey="e" class="ff-fas edit-link">&#xf013;</a>
	</div>

	<!-- Points -->
	<div class="fs-300 no-print">
		Pts&nbsp;: <?= $character->points ?> | éco&nbsp;: <?= $character->points - $character->points_count["total"] ?>
	</div>

	<!-- Description -->
	<?php if (!$compact): ?>
		<details class="no-print mt-½">
			<summary>
				<h3>Description</h3>
			</summary>
			<div class="mt-½ ta-justify">
				<?= nl2br($character->description) ?>
			</div>
		</details>
	<?php endif ?>

	<!-- Background -->
	<?php if (!empty($character->background) && !$compact): ?>
		<details class="no-print mt-½ hidden-when-compact">
			<summary>
				<h3>Background</h3>
			</summary>
			<div class="mt-½ flow ta-justify"><?= TextParser::pseudoMDParser($character->background) ?></div>
		</details>
	<?php endif; ?>

	<!-- Caractéristiques -->
	<fieldset>

		<legend>Caractéristiques</legend>

		<!-- Caractéristiques principale -->
		<div class="flex-s gap-½ fs-450 jc-space-between ta-center">
			<?php foreach ($attributes_names as $attr_name) { ?>
				<div data-type="throwable-wrapper">
					<b data-type="throwable-label"><?= $attr_name ?></b>
					<span <?= color_modifier($character->raw_attributes[$attr_name], $character->attributes[$attr_name]) ?> data-type="throwable-score">
						<?= $character->attributes[$attr_name] ?>
					</span>
				</div>
			<?php } ?>
		</div>

		<!-- Caractéristiques secondaires -->
		<div class="flex-s gap-½ jc-space-between mt-½ py-½ ta-center" style="border-top: .5px solid var(--grey-900)">
			<div>
				<b>Dégâts</b>
				<span <?= color_modifier($character->raw_attributes["For"], $character->attributes["For"] + $character->modifiers["Dégâts"]) ?>>
					<?= $character->attributes["Dégâts"]['estoc'] . '/' . $character->attributes["Dégâts"]['taille']; ?>
				</span>
			</div>

			<div data-type="throwable-wrapper">
				<b data-type="throwable-label">Réf</b>
				<span <?= color_modifier($character->raw_attributes["Réflexes"], $character->attributes["Réflexes"]) ?> data-type="throwable-score">
					<?= $character->attributes["Réflexes"] ?>
				</span>
			</div>

			<div data-type="throwable-wrapper">
				<b data-type="throwable-label">S-F</b>
				<span <?= color_modifier($character->raw_attributes["Sang-Froid"], $character->attributes["Sang-Froid"]) ?> data-type="throwable-score">
					<?= $character->attributes["Sang-Froid"] ?>
				</span>
			</div>

			<div>
				<b>Vit</b>
				<span <?= color_modifier($character->raw_attributes["Vitesse"], $character->attributes["Vitesse"]) ?>>
					<?= $character->attributes["Vitesse"] ?>
				</span>
			</div>
		</div>

		<!-- PdV, PdF, PdM, PdE -->
		<div class="flex-s gap-½ jc-space-between" style="border-top: .5px solid var(--grey-900); padding-top: .75em;">
			<?php foreach ($pdx_names as $pdx_name) {
				$pdxm = $character->attributes[$pdx_name];
				$pdx = $character->state[$pdx_name];
			?>
				<div class="ta-center <?= $pdx_name === "PdM" && !$character_uses_pdm ? "clr-grey-500" : "" ?>" style="line-height: 1.2em;">
					<b><?= $pdx_name ?></b> <?= $pdxm ?><br>
					<meter class="pdx-meter" min="0" low="<?= $pdxm * 0.26 ?>" high="<?= $pdxm * 0.5 ?>" optimum="<?= $pdxm * 0.51 ?>" max="<?= $pdxm ?>" value="<?= $pdx ?>" title="<?= $pdx ?>" name="<?= $pdx_name ?>"></meter>
				</div>
			<?php } ?>
		</div>

	</fieldset>

	<!-- État du personnage -->
	<fieldset>
		<legend>État</legend>

		<ul>
			<?php if ($character_uses_pdm) { ?>
				<li>
					<?php  ?>
					<div class="grid gap-½ ai-center" style="grid-template-columns: auto 1fr">
						<b>PdM</b>
						<input type="text" name="pdm_counter" data-pdm-max="<?= $character->attributes["PdM"] ?>" data-pdm-current="<?= $character->state["PdM"] ?>" style="padding-bottom: .1em;">
						<!--  value="|?= $character->state["PdM"] === $character->attributes["PdM"] ? "" : $character->state["PdM"] ?|" -->
					</div>
				</li>
			<?php } ?>
			<li>
				<b>Encombrement&nbsp;:</b>
				<?= $character->carried_weight ?> kg –
				<?= $character->state["Encombrement"]["name"] ?>
			</li>
			<?php if ($character->state["Fatigue"]["dex-modifier"]) { ?>
				<li><b>Fatigue&nbsp;:</b> <?= $character->state["Fatigue"]["name"] ?></li>
			<?php } ?>
			<?php if ($character->state["Stress"]["sf-modifier"]) { ?>
				<li>
					<b>Stress&nbsp;:</b>
					<?= $character->state["Stress"]["name"] ?>
					<?= $character->state["Stress"]["pde-loss"] ? "– perte de " . $character->state["Stress"]["pde-loss"] . " PdE" : "" ?>
				</li>
			<?php } ?>
			<?php if ($character->state["Santé-mentale"]["sf-modifier"]) { ?>
				<li><b>Santé mentale&nbsp;:</b> <?= $character->state["Santé-mentale"]["description"] ?></li>
			<?php } ?>
			<?php if ($character->state["Blessures"]["dex-modifier"]) { ?>
				<li><b>Blessures&nbsp;:</b> <?= $character->state["Blessures"]["name"] ?></li>
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
								(<?= $counter["max"] . ($counter["unit"] ? " " . $counter["unit"] : "") ?>)
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

	<!-- Portraits -->
	<?php
	if (count($character->group_members) === 0) $group_size = "none";
	elseif (count($character->group_members) <= 2) $group_size = "small";
	elseif (count($character->group_members) <= 4) $group_size = "medium";
	else $group_size = "big";
	?>

	<div class="portraits-wrapper group-<?= $group_size ?> mt-1 no-print" data-role="members-wrapper">

		<div class="character-portrait aspect-square"><img class="fit-cover" src="<?= $character->portrait ?>"></div>

		<?php if ($character->id_group !== NULL) {
			foreach ($character->group_members as $group_member) { ?>
				<div class="group-portrait"
					data-place="pi_<?= $group_member->id ?>"
					data-role="item-transfer"
					data-name="<?= $group_member->name ?>">
					<img class="fit-cover" src="<?= $group_member->portrait ?>" title="<?= $group_member->description ?>">
					<div class="group-member-name fs-300"><?= strtok($group_member->name, " ") ?></div>
				</div>
		<?php }
		} ?>

	</div>
</div>

<!-- Avantages, Désavantages & Travers -->
<fieldset class="flow">
	<legend>Avantages &amp; Désavantages</legend>
	<?php
	foreach (["Zéro", "Avantage", "Désavantage", "Réputation", "Travers"] as $categorie):

		$sublist = [];
		$avdesav_not_displayed = [158, 159, 160, 161, 162, 163]; // PdX modifiers + SF & Ref modifiers
		foreach ($character->avdesav as $avdesav) {
			if ($avdesav["catégorie"] === $categorie && !in_array($avdesav["id"], $avdesav_not_displayed)) {
				if ($compact) $sublist[] = $avdesav["nom"] . " (" . $avdesav["points"] . ")";
				else $sublist[] = $avdesav;
			};
		} ?>

		<?php if (count($sublist) && !$compact): ?>
			<div>
				<?php foreach ($sublist as $avdesav) {
					if ($avdesav["catégorie"] !== "Travers") : ?>

						<?php if ($compact): ?><p><?= join(", ", $sublist) ?></p>
						<?php else: ?>
							<details class="liste">
								<summary>
									<div>
										<div><?= $avdesav["nom"] ?></div>
										<div><?= $avdesav["points"] ?></div>
									</div>
								</summary>
								<div class="fs-300 flow"><?= $avdesav["description"] ?? "" ?></div>
							</details>
						<?php endif ?>

					<?php else : ?>

						<div class="flex-s gap-½">
							<div class="fl-1"><?= $avdesav["nom"] ?></div>
							<div><?= $avdesav["points"] ?></div>
						</div>

					<?php endif ?>

				<?php } ?>
			</div>
		<?php elseif (count($sublist) && $compact): ?>
			<p><?= join(", ", $sublist) ?></p>
		<?php endif; ?>

	<?php endforeach ?>
</fieldset>

<!-- Compétences -->
<fieldset>
	<legend>Compétences</legend>

	<?php if ($compact):
		$skill_display_array = [];
	?>
			<?php foreach ($character->skills as $comp):
				$skill_display_array [] = "<span data-type='throwable-wrapper'><span data-type='throwable-label'>" . $comp["label"]. "</span><span data-type='throwable-score'" . color_modifier($comp["raw-base"], $comp["base"]). "> ". $comp["score"]. "</span></span>";
				?>
			<?php endforeach ?>
			<p><?= join(", ", $skill_display_array) ?></p>
	<?php else: ?>
		<?php foreach ($character->skills as $comp): ?>

			<details class="liste">
				<summary data-type="throwable-wrapper">
					<div>
						<div data-type="throwable-label"><?= $comp["label"] ?></div>
						<div data-type="throwable-score" <?= color_modifier($comp["raw-base"], $comp["base"]) ?>><?= $comp["score"] ?></div>
					</div>
				</summary>
				<div class="fs-300 ta-justify">
					<?= $comp["description"] ?>
				</div>
			</details>


		<?php endforeach ?>
	<?php endif ?>

</fieldset>

<!-- Magie -->
<?php if ($character->special_traits["magerie"]): ?>
	<fieldset>
		<legend>Magie</legend>

		<?php foreach ($character->colleges as $college) { ?>

			<details class="liste">
				<summary>
					<div>
						<div><?= $college["name"] ?></div>
						<div <?= color_modifier(0, $character->modifiers["Int"] + $character->modifiers["Magie"]) ?>><?= $college["score"] ?></div>
					</div>
				</summary>

				<?php foreach ($character->spells as $sort) {
					if (in_array($college["id"], $sort["data"]->colleges) && (max($sort["scores"]) >= 12)) { ?>

						<details class="sous-liste">
							<summary data-type="throwable-wrapper">
								<div class="flex-s gap-½">
									<div class="fl-1" data-type="throwable-label">
										<?= $sort["label"] ?>
										<?php if (!in_array($sort["data"]->class, ["Enchantement"])) { ?>
											[<?= $sort["readable_costs"] ?>]
										<?php } ?>
									</div>
									<div data-type="throwable-score"><?= $sort["readable_scores"] ?></div>
								</div>
							</summary>

							<div class="fs-300 ta-justify">
								<?= $sort["data"]->getFullDescription($sort["readable_time"]) ?>
							</div>
						</details>

				<?php }
				} ?>

			</details>
		<?php } ?>

	</fieldset>
<?php endif ?>

<!-- Pouvoirs -->
<?php if ($character->special_traits["pouvoirs"] && count($character->powers)): ?>
	<fieldset>
		<legend>Pouvoirs</legend>
		<?php
		foreach ($character->powers as $pouvoir) {
			$type = $pouvoir["data"]->specific["Type"] ?? $pouvoir["origine"];
		?>
			<details class="liste">
				<summary data-type="throwable-wrapper">
					<div>
						<div data-type="throwable-label"><?= $pouvoir["label"] ?></div>
						<div data-type="throwable-score" <?= color_modifier(0, $character->modifiers["Int"]) ?>><?= $pouvoir["score"] ?></div>
					</div>
				</summary>
				<div class="fs-300">
					<?php
					if ($type === "sort") echo $pouvoir["data"]->data->getFullDescription();
					else echo $pouvoir["data"]->data->description;
					?>
				</div>
			</details>
		<?php } ?>
	</fieldset>
<?php endif ?>

<!-- Psi -->
<?php if ($character->special_traits["psi"]):	?>
	<fieldset>
		<legend>Psi</legend>
		<?php foreach ($character->disciplines as $discipline) { ?>
			<details class="liste">
				<summary>
					<div>
						<div><?= $discipline["nom"] ?></div>
						<div>Niv. <?= $discipline["niv"] ?></div>
					</div>
				</summary>
				<?php if (isset($discipline["notes"])) { ?>
					<div><i><?= $discipline["notes"] ?></i></div>
				<?php } ?>
				<?php foreach ($character->psi as $pouvoir) {
					if (in_array($discipline["id"], $pouvoir["data"]->disciplines) && $pouvoir["readable-score"]) { ?>
						<details class="sous-liste">
							<summary data-type="throwable-wrapper">
								<div class="flex-s gap-½">
									<div class="fl-1" data-type="throwable-label"><?= $pouvoir["data"]->name ?> (<?= $pouvoir["data"]->readableNiv ?>) [<?= $pouvoir["readable-cost"] ?>]</div>
									<div data-type="throwable-score" <?= color_modifier(0, $character->modifiers["Int"]) ?>><?= $pouvoir["readable-score"] ?></div>
								</div>
							</summary>
							<div class="fs-300">
								<?= $pouvoir["data"]->getFullDescription(); ?>
							</div>
						</details>
				<?php }
				} ?>
			</details>
		<?php } ?>
	</fieldset>
<?php endif ?>

<div class="no-break">
	<!-- Possessions -->
	<fieldset>
		<legend class="flex-s gap-½ ai-center">
			Possessions
			<button class="ff-far fs-200 btn-primary btn-square" data-role="open-dialog" data-dialog-name="possession-notice" title="mode d’emploi de la liste de possession">&#xf059;</button>
		</legend>

		<form id="form-equipment" class="flow">
			<?php
			//$n_obj = 0;
			foreach ($character->equipment as $sublist) {
				$sublist["lieu"] = in_array($sublist["lieu"], ["pi", "pe"]) ? ($sublist["lieu"] . "_" . $character->id) : $sublist["lieu"];
			?>
				<!-- Container wrapper -->
				<details class="container-wrapper" data-role="container-wrapper" data-place="<?= $sublist["lieu"] ?>" tabindex="-1" id="container-wrapper-<?= $sublist["lieu"] ?>">
					<!-- Container title -->
					<summary data-role="container-title-wrapper" title="<?= $sublist["lieu"] ?>">
						<h5 class="flex-s gap-½">
							<div class="fl-1"><?= $sublist["nom"] ?></div>
							<div><?= $sublist["sur-soi"] ? (round($sublist["poids"] ?? 0, 1) . "&nbsp;kg") : "" ?></div>
						</h5>
					</summary>
					<!-- Container controls -->
					<div class="flex-s ai-center gap-1 mt-½" data-role="container-controls">
						<button class="ff-fas nude clr-primary-500" title="ajouter un objet" data-role="add-item" type="button">
							&#xf055;
						</button>
						<div class="flex-s gap-½ fl-1">
							<button class="ff-fas nude" title="monter le bloc" data-role="container-up" type="button">&#xf0aa;</button>
							<button class="ff-fas nude" title="descendre le bloc" data-role="container-down" type="button">&#xf0ab;</button>
						</div>
						<?php if ($sublist["id"]) { ?>
							<label class="ff-fas clr-invalid cursor-pointer" title="transformer en objet simple (si vide seulement !)">
								&#xf057;
								<input type="checkbox" name="sub-list[<?= $sublist["id"] ?>][Contenant-off]" <?= $sublist["non-vide"] ? "disabled" : "" ?> hidden>
							</label>
							<label class="ff-fas clr-secondary-500 cursor-pointer group-share-input px-¼" title="rendre visible pour le groupe">
								&#xe533;
								<input type="checkbox" hidden name="sub-list[<?= $sublist["id"] ?>][Groupe]" <?= !empty($sublist["groupe"]) ? "checked" : "" ?> value="<?= $character->id_group ?>" data-ping-all>
							</label>
						<?php } ?>
					</div>
					<!-- Items list -->
					<?php foreach ($sublist["liste"] as $item) {
						/* $n_obj++ */ ?>
						<details class="items-list" id="item-<?= $item->id ?>" data-role="item-wrapper">
							<summary class="grid gap-½ ai-center">
								<div class="ff-fas" draggable="true" data-role="item-grip">&#xf58e;</div>
								<input name="objet[<?= $item->id ?>][Nom]" type="text" value="<?= $item->name ?>" placeholder="Nouvel objet" <?= $item->isContainer ? "class=\"fw-600\"" : "" ?>>
								<input name="objet[<?= $item->id ?>][Poids]" title="poids" type="text" value="<?= $item->weight ?>" class="ta-center watched <?= $item->isContainer ? "clr-grey-700" : "" ?>" required>
							</summary>
							<div class="grid fs-300">
								<input name="objet[<?= $item->id ?>][Notes]" type="text" value="<?= $item->notes ?>" placeholder="Notes" data-role="item-notes">
								<?php if ($_SESSION["Statut"] >= 2 && ($character->id_gm === $_SESSION["id"] || !$character->id_gm)) { ?>
									<input name="objet[<?= $item->id ?>][Secret]" type="text" value="<?= $item->secret ?>" placeholder="Notes du MJ" class="clr-invalid" data-role="item-notes">
								<?php } ?>
								<input hidden name="objet[<?= $item->id ?>][Lieu]" value="<?= $item->place ?>" data-role="item-place">
								<input hidden name="objet[<?= $item->id ?>][Contenant]" value="<?= $item->isContainer ?>">
								<input hidden name="objet[<?= $item->id ?>][MJ]" value="<?= $character->id_gm ?>">
							</div>
						</details>
					<?php } ?>
					<div data-role=free-slot style="height: 0.75em;"></div>
				</details>
			<?php } ?>
			<div id="item-transfer" class="mt-0"><!-- temporary wrapper for item transfer, used in character.js --></div>
			<input type="hidden" name="id_perso" value="<?= $character->id ?>">
		</form>


		<!-- Équipement de groupe -->
		<?php
		if (!empty($character->id_group)):
			$equipement_repo = new EquipmentRepository;
			$possessions_communes = $equipement_repo->getCommonGroupEquipment($character->id_group);
			if ($possessions_communes) { ?>
				<details class="mt-1 fs-300 no-print">
					<summary class="clr-grey-500">
						<h5>Possessions de groupe</h5>
					</summary>
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
		<?php endif; ?>
	</fieldset>

	<!--Notes -->
	<?php if (!empty($character->notes)) { ?>
		<details class="mt-1 no-print">
			<summary>
				<h3>Notes</h3>
			</summary>
			<div class="mt-½ flow">
				<?= TextParser::pseudoMDParser($character->notes) ?>
			</div>
		</details>
	<?php } ?>
</div>

<?php
// chat window parameters
$playNotif = false;
$displayEmojis = false;
?>

<!-- Modal pour les jets -->
<dialog data-type="character-sheet-roll" class="ta-center" data-morphdom="ignore">
	<button data-role="close-modal" class="ff-fas">&#xf00d;</button>
	<div class="flex-s gap-1 jc-center ai-center">
		<div data-content="label"></div>
		<input type="text" data-content="score" class="ta-center" style="width: 8ch"></input>
	</div>
	<div class="grid gap-½ mt-½">
		<label>
			Modificateur <input type="text" data-type="test-modifier-value" class="ta-center" style="width: 5ch">
		</label>
		<label>
			Jet secret pour le MJ <input type="checkbox" data-type="secret-test-checkbox">
		</label>
	</div>
	<button class="btn-primary mt-1 mx-auto" data-type="send-test">Faire le jet</button>
</dialog>

<!-- Modal pour les possessions -->
<dialog data-name="possession-notice" class="flow" data-morphdom="ignore">
	<button data-role="close-modal" class="ff-fas">&#xf00d;</button>
	<p class="mt-0"><b>Ajouter un objet&nbsp;:</b> cliquer sur <span class="ff-fas clr-primary-500">&#xf055;</span> dans l’emplacement désiré.</p>
	<p><b>Supprimer un objet&nbsp;:</b> effacer son nom. Attention&nbsp;: si vous effacez un objet-contenant, vous perdrez tout son contenu avec&nbsp;!</p>
	<p><b>Transformer un objet en contenant&nbsp;:</b> Insérer * devant son nom.</p>
	<p><b>Transformer un contenant en objet simple&nbsp;:</b> cocher la case <span class="ff-fas clr-invalid">&#xf057;</span> dans la liste associée au contenant (pas possible si le contenant n’est pas vide).</p>
	<p><b>Changer l’ordre des contenants&nbsp;:</b> utiliser les boutons <span class="ff-fas">&#xf0aa;</span> et <span class="ff-fas">&#xf0ab;</span>. Attention&nbsp;: un contenant vide peut perturber le positionnement des autres contenants. Dans ce cas, transformez-le en objet simple.</p>
	<p><b>Déplacer un objet</b> (vers un autre endroit, ou à l’intérieur d’une liste, ou vers un autre personnage)&nbsp;: faire un <i>glisser-déposer</i> en vous servant de la poignée <span class="ff-fas">&#xf58e;</span> . Si la liste de destination est repliée, maintenant votre objet une demi-seconde sur son nom pour qu’elle s’ouvre automatiquement.</p>
	<p><b>Partager</b> le contenu d’un contenant&nbsp;: cliquer sur la case <span class="ff-fas clr-secondary-dark">&#xe533;</span>. Les autres membres du groupe pourront voir ce contenu (mais pas le modifier).</p>
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
</dialog>

<script src="scripts/character-sheet<?= PRODUCTION ? ".min" : "" ?>.js?v=<?= VERSION ?>" type="module"></script>