<?php

use App\Entity\Character;
use App\Entity\Equipment;
use App\Repository\UserRepository;
use App\Repository\GroupRepository;
use App\Repository\CharacterRepository;
use App\Repository\EquipmentRepository;

$user_repo = new UserRepository;
$equipment_repo = new EquipmentRepository;
$group_repo = new GroupRepository;
$character_repo = new CharacterRepository;

$liste_objets_orphelins = $equipment_repo->getOrphanEquiment();
for ($k = 0; $k < 3; $k++) {
	$liste_objets_orphelins[] = new Equipment();
}

$admin = $_SESSION["Statut"] === 3;
$users = $user_repo->getAllUsers();
$groups = $admin ? $group_repo->getAllGroups() : $group_repo->getGMGroups($_SESSION["id"]);
$characters_id = $admin ? $character_repo->getAllCharacters() : $character_repo->getCharactersFromGM($_SESSION["id"]);
$characters = [];
foreach ($characters_id as $character) {
	$characters[] = new Character($character["id"]);
}
?>

<div id="ws-data" hidden data-session-id="<?= $_SESSION["id"] ?>" data-ws-key="<?= WS_KEY ?>"></div>

<article><!-- Objets orphelins -->
	<h2>Objets orphelins</h2>
	<form id="items-form" class="grid gap-¼"><!-- method="post" action="/submit/equipment-list" -->
		<?php
		$n = 0;
		foreach ($liste_objets_orphelins as $objet) { ?>
			<div class="flex-s fl-wrap gap-½ ai-first-baseline">
				<div class="ta-right" style="width: 4ch"><?= $objet->id ?></div class="ta-right">
				<input type="text" name="objet-gestionnaire[<?= $n ?>][Nom]" value="<?= $objet->name ?>" size="30" placeholder="Nom de l’objet">
				<div>
					<label class="ff-fas">
						&#xf187;
						<input type="checkbox" name="objet-gestionnaire[<?= $n ?>][Contenant]" <?= $objet->isContainer ? "checked" : "" ?> title="contenant ?">
					</label>
				</div>
				<input type="text" name="objet-gestionnaire[<?= $n ?>][Poids]" value="<?= $objet->weight ?>" size="2" placeholder="Pds" class="ta-center" title="poids">
				<input type="text" name="objet-gestionnaire[<?= $n ?>][Lieu]" value="<?= $objet->place ?>" size="5" class="ta-center" placeholder="Lieu">
				<input type="text" name="objet-gestionnaire[<?= $n ?>][Notes]" value="<?= $objet->notes ?>" class="fl-1" placeholder="Notes">
				<input type="text" name="objet-gestionnaire[<?= $n ?>][Secret]" value="<?= $objet->secret ?>" class="fl-1 clr-warning" placeholder="Notes du MJ">
				<input hidden name="objet-gestionnaire[<?= $n ?>][id]" value="<?= $objet->id ?>">
			</div>
		<?php
			$n++;
		} ?>
		<button type="submit" class="fs-500 ff-fas mx-auto mt-½">&#xf0c7;</button>
	</form>
</article>

<article><!-- Groupes et personnages -->
	<h2>Groupes &amp; Personnages</h2>

	<?php foreach ($groups as $group) { ?>
		<details data-group="<?= $group->id ?>">
			<summary class="h3"><?= $group->id ?>. <?= $group->name ?></summary>
			<div class="flex gap-½ fl-wrap mt-½">
				<?php
				$group_characters = array_filter($characters, fn ($x) => $x->id_group === $group->id);
				foreach ($group_characters as $perso) {

					// ratio des PdV, PdF, PdM et PdE
					$pdv = $perso->state["PdV"] ?? "";
					$pdvm = $perso->pdxm["PdVm"] ?? "";
					$r_pdv = !$pdvm ? 0 : ($pdv ? $pdv / $pdvm * 100 : 0);
					$pdf = $perso->state["PdF"] ?? "";
					$pdfm = $perso->pdxm["PdFm"] ?? "";
					$r_pdf = !$pdfm ? 0 : ($pdf ? $pdf / $pdfm * 100 : 0);
					$pdm = $perso->state["PdM"] ?? "";
					$pdmm = $perso->pdxm["PdMm"] ?? "";
					$r_pdm = !$pdmm ? 0 : ($pdm ? $pdm / $pdmm * 100 : 0);
					$pde = $perso->state["PdE"] ?? "";
					$pdem = $perso->pdxm["PdEm"] ?? "";
					$r_pde = !$pdem ? 0 : ($pde ? $pde / $pdem * 100 : 0);

					// style des indicateurs d’état des PdV, PdF, PdM et PdE
					if ($r_pdv > 75) {
						$style_pdv = "background : linear-gradient(90deg, DarkSeaGreen $r_pdv%, white $r_pdv%);";
					} elseif ($r_pdv > 50) {
						$style_pdv = "background : linear-gradient(90deg, BlanchedAlmond $r_pdv%, white $r_pdv%);";
					} elseif ($r_pdv > 25) {
						$style_pdv = "background : linear-gradient(90deg, LightSalmon $r_pdv%, white $r_pdv%);";
					} elseif ($r_pdv > 0) {
						$style_pdv = "background : linear-gradient(90deg, LightCoral $r_pdv%, white $r_pdv%);";
					} elseif ($r_pdv == 0 and $pdv == "") {
						$style_pdv = "background : none;";
					} else {
						$style_pdv = "background : LightCoral;";
					}

					if ($r_pdf > 50) {
						$style_pdf = "background : linear-gradient(90deg, DarkSeaGreen $r_pdf%, white $r_pdf%);";
					} elseif ($r_pdf > 25) {
						$style_pdf = "background : linear-gradient(90deg, BlanchedAlmond $r_pdf%, white $r_pdf%);";
					} elseif ($r_pdf > 10) {
						$style_pdf = "background : linear-gradient(90deg, LightSalmon $r_pdf%, white $r_pdf%);";
					} elseif ($r_pdf > 0) {
						$style_pdf = "background : linear-gradient(90deg, LightCoral $r_pdf%, white $r_pdf%);";
					} elseif ($r_pdf == 0 and $pdf == "") {
						$style_pdf = "background : none;";
					} else {
						$style_pdf = "background : LightCoral;";
					}

					$style_pdm = "background : linear-gradient(90deg, LightBlue $r_pdm%, white $r_pdm%);";

					if ($r_pde > 50) {
						$style_pde = "background : linear-gradient(90deg, DarkSeaGreen $r_pde%, white $r_pde%);";
					} elseif ($r_pde > 25) {
						$style_pde = "background : linear-gradient(90deg, LightSalmon $r_pde%, white $r_pde%);";
					} elseif ($r_pde > 0) {
						$style_pde = "background : linear-gradient(90deg, LightCoral $r_pde%, white $r_pde%);";
					} elseif ($r_pde == 0 and $pde == "") {
						$style_pde = "background : none;";
					} else {
						$style_pde = "background : LightCoral;";
					} ?>

					<form class="card" data-role="character-state-form" id="state-form-character-<?= $perso->id ?>">

						<input hidden name="id" value="<?= $perso->id ?>">

						<div class="flex-s ai-first-baseline gap-¾">
							<h4 class="mt-0 fl-1">
								<?= $perso->id ?>. <?= $perso->name ?>
								<span id="confirm-export-<?= $perso->id ?>"></span>
							</h4>
							<a href="personnage-fiche?perso=<?= $perso->id ?>" target="_blank" class="ff-fas fs-500 btn nude" title="voir fiche">&#xf2c2;</a>
							<button type="button" data-role="export-character" title="exporter" class="nude ff-fas fs-500" data-id="<?= $perso->id ?>">&#xf56e;</button>
						</div>

						<div class="flex-s gap-½ mt-½">
							<input type="text" name="Pts" value="<?= $perso->points ?>" style="width: 5ch" class="ta-center" title="Pts de perso">
							<input type="text" name="id_groupe" value="<?= $perso->id_group ?>" style="width: 5ch" class="ta-center" title="groupe">
							<select name="id_joueur" class="fl-1">
								<?php foreach ($users as $user) { ?>
									<option value="<?= $user->id ?>" <?= $user->id === $perso->id_player ? "selected" : "" ?>><?= $user->login ?></option>
								<?php } ?>
							</select>
							<select name="Statut" class="fl-1">
								<option <?= $perso->status === "Création" ? "selected" : "" ?>>Création</option>
								<option <?= $perso->status === "Actif" ? "selected" : "" ?>>Actif</option>
								<option <?= $perso->status === "Archivé" ? "selected" : "" ?>>Archivé</option>
								<option <?= $perso->status === "Mort" ? "selected" : "" ?>>Mort</option>
							</select>
						</div>

						<!-- Compteurs PdV PdF PdM PdE -->
						<div class="flex-s gap-½ mt-½">
							<input type="text" name="État[PdV]" value="<?= $pdv ?>" class="fl-1 ta-center" placeholder="PdV <?= $pdvm ?>" data-role="pdx-cell" title="PdVm <?= $pdvm ?>" style="<?= $style_pdv ?>">

							<input type="text" name="État[PdF]" value="<?= $pdf ?>" class="fl-1 ta-center" placeholder="PdF <?= $pdfm ?>" data-role="pdx-cell" title="PdFm <?= $pdfm ?>" style="<?= $style_pdf ?>">

							<input type="text" disabled name="État[PdM]" value="<?= $pdm ?>" class="fl-1 ta-center" placeholder="PdM <?= $pdmm ?>" data-role="pdx-cell" title="PdMm <?= $pdmm ?>" style="<?= $style_pdm ?>">

							<input type="text" name="État[PdE]" value="<?= $pde ?>" class="fl-1 ta-center" placeholder="PdE <?= $pdem ?>" data-role="pdx-cell" title="PdEm <?= $pdem ?>" style="<?= $style_pde ?>">
						</div>

						<!-- Modificateurs caractéristiques ligne 1 -->
						<div class="flex-s gap-½ mt-½">
							<input type="text" name="État[For_global]" value="<?= $perso->state["For_global"] ?? "" ?>" class="fl-1 ta-center" placeholder="For" title="Modif force global">
							<input type="text" name="État[Dex]" value="<?= $perso->state["Dex"] ?? "" ?>" class="fl-1 ta-center" placeholder="Dex" title="Modif Dextérité">
							<input type="text" name="État[Int]" value="<?= $perso->state["Int"] ?? "" ?>" class="fl-1 ta-center" placeholder="Int" title="Modif Intelligence">
							<input type="text" name="État[San]" value="<?= $perso->state["San"] ?? "" ?>" class="fl-1 ta-center" placeholder="San" title="Modif Santé">
							<input type="text" name="État[Per]" value="<?= $perso->state["Per"] ?? "" ?>" class="fl-1 ta-center" placeholder="Per" title="Modif Perception">
							<input type="text" name="État[Vol]" value="<?= $perso->state["Vol"] ?? "" ?>" class="fl-1 ta-center" placeholder="Vol" title="Modif Volonté">

						</div>

						<!-- Modificateurs caractéristiques ligne 2 -->
						<div class="flex-s gap-½ mt-½">
							<input type="text" name="État[For_deg]" value="<?= $perso->state["For_deg"] ?? "" ?>" class="fl-1 ta-center" placeholder="For D" title="Modif Force dégâts">
							<input type="text" name="État[Réflexes]" value="<?= $perso->state["Réflexes"] ?? "" ?>" class="fl-1 ta-center" placeholder="Réf." title="Modif Réflexes">
							<input type="text" name="État[Sang-Froid]" value="<?= $perso->state["Sang-Froid"] ?? "" ?>" class="fl-1 ta-center" placeholder="S.-F." title="Modif Sang-Froid">
							<input type="text" name="État[Stress]" value="<?= $perso->state["Stress"] ?? "" ?>" class="fl-1 ta-center" placeholder="Stress" title="Niveau de stress">
							<input type="text" name="État[Magie]" value="<?= $perso->state["Magie"] ?? "" ?>" class="fl-1 ta-center" placeholder="Magie" title="Modif Collèges magie">
						</div>

						<!-- Blessures aux membres -->
						<div class="flex-s gap-½ mt-½">
							<input type="text" name="État[Membres]" value="<?= $perso->state["Membres"] ?? "" ?>" class="fl-1" placeholder="Membres" title="Ex format : BG 4 ; JD 2 ; PD D">
						</div>

						<!-- Autres éléments d’état -->
						<div class="flex-s gap-½ mt-½">
							<!--  -->
							<textarea name="État[Autres]" placeholder="Autres éléments d’état" title="Autres éléments d’état – séparateur ;"><?= $perso->state["Autres"] ?? "" ?></textarea>
						</div>

						<input hidden name="Calculs[PdVm]" value="<?= $perso->pdxm["PdVm"] ?? "" ?>">
						<input hidden name="Calculs[PdFm]" value="<?= $perso->pdxm["PdFm"] ?? "" ?>">
						<input hidden name="Calculs[PdEm]" value="<?= $perso->pdxm["PdEm"] ?? "" ?>">
						<input hidden name="Calculs[PdMm]" value="<?= $perso->pdxm["PdMm"] ?? "" ?>">

					</form>

				<?php } ?>
			</div>
		</details>
	<?php } ?>

</article>

<article><!-- Créer un personnage -->
	<h2>Créer un personnage</h2>
	<form method="post" action="/submit/create-character">
		<div class="flex gap-1">
			<div class="card">
				<label>
					<input type="checkbox" name="kit_base">
					<b>Kit de base</b>
				</label>
				<p><i>Esquive</i>, <i>Furtivité</i>, <i>Culture générale</i>, <i>Langue maternelle</i>, <i>Baratin</i>, <i>Acteur</i></p>
			</div>
			<div class="card">
				<label for="kit_combattant">
					<input type="checkbox" name="kit_combattant">
					<b>Kit Combattant</b>
				</label>
				<p><i>Réflexes de combat</i>, <i>Résistance à la douleur</i>, <i>Combat à Mains nues</i>, <i>Esquive</i></p>
			</div>
			<div class="card">
				<label>
					<input type="checkbox" name="kit_magicien">
					<b>Kit Magicien</b>
				</label>
				<p><i>Int</i> 13, <i>Magerie</i>, <i>Alphabétisation</i>, <i>Sciences occultes</i></p>
			</div>
			<div class="card">
				<label>
					<input type="checkbox" name="kit_ange">
					<b>Kit Ange</b>
				</label>
				<p><i>Pack Ange</i>, <i>Force</i> 14, <i>Santé</i> et <i>Volonté</i> à 12</p>
			</div>
			<div class="card">
				<label>
					<input type="checkbox" name="kit_demon">
					<b>Kit Démon</b>
				</label>
				<p><i>Pack Démon</i>, <i>Force</i> 14, <i>Santé</i> 12</p>
			</div>
			<input hidden name="createur" value="<?= $_SESSION["id"] ?>">
		</div>
		<button type="submit" class="fs-500 ff-fas mx-auto mt-½" title="Créer un nouveau personnage">&#xe541;</button>
	</form>
</article>

<?php if ($admin) { ?>
	<article id="gestionnaire-groupes"><!-- Groupes -->
		<h2>Groupes</h2>
		<form action="/submit/groups" method="POST" autocomplete="off">
			<div class="flex gap-1 fl-wrap jc-center">

				<?php foreach ($groups as $group) {
					if ($group->id < 100) {
				?>
						<div class="card">
							<div class="flex-s gap-½">
								<div style="width: 3ch"><?= $group->id ?>.</div>
								<input type="text" name="groupes[<?= $group->id ?>][Nom]" value="<?= $group->name ?>" class="fl-1">
							</div>
							<div class="flex-s gap-½ mt-½">
								<div style="width: 3ch">MJ</div>
								<select name="groupes[<?= $group->id ?>][MJ]" class="fl-1">
									<?php foreach ($users as $user) { ?>
										<option value="<?= $user->id ?>" <?= $user->id === $group->id_gm ? "selected" : "" ?>><?= $user->login ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
				<?php }
				} ?>

				<div class="card">
					<div class="ta-center italic">Entrez un nom pour créer un nouveau groupe</div>
					<input type="text" name="groupes[0][Nom]" class="full-width mt-½" placeholder="Nom du groupe">
					<input hidden name="groupes[0][MJ]" value="1">
				</div>

			</div>
			<button type="submit" class="fs-500 ff-fas mx-auto mt-½">&#xf0c7;</button>
		</form>
	</article>
<?php } ?>

<script type="module" src="/scripts/characters-manager<?= PRODUCTION ? ".min" : "" ?>.js?v=<?= VERSION ?>" defer></script>