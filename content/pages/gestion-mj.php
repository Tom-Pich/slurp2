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

$liste_objets_orphelins = $equipment_repo->getOrphanEquiment($_SESSION["id"]);
for ($k = 0; $k < 3; $k++) {
	$nouvel_objet = new Equipment();
	$nouvel_objet->id_gm = $_SESSION["id"];
	$liste_objets_orphelins[] = $nouvel_objet;
}

$admin = $_SESSION["Statut"] === 3;
$users = $user_repo->getAllUsers();
$groups = $admin ? $group_repo->getAllGroups() : $group_repo->getGMGroups($_SESSION["id"]);
$characters_id = $admin ? $character_repo->getAllCharacters() : $character_repo->getCharactersFromGM($_SESSION["id"]);

$characters = [];
foreach ($characters_id as $id) $characters[] = new Character($id);
$statusOrder = ["Actif", "Création", "Archivé", "Mort"];

// sort characters by status
usort($characters, function ($a, $b) use ($statusOrder) {
	$posA = array_search($a->status, $statusOrder);
	$posB = array_search($b->status, $statusOrder);
	return $posA - $posB;
});

// chat window
$playNotif = false;
?>

<div id="ws-data" hidden data-session-id="<?= $_SESSION["id"] ?>" data-ws-key="<?= WS_KEY ?>"></div>

<!-- Objets orphelins -->
<article>
	<h2 class="flex-s gap-½">
		Objets orphelins
		<button class="nude ff-fas" data-role="open-dialog" data-dialog-name="orphan-objects-dialog" title="mode d’emploi">&#xf059;</button>
	</h2>
	<!-- <form id="items-form-test" class="grid gap-½" action="/submit/equipment-list" method="post"> -->
	<form id="items-form" class="grid gap-½">
		<?php
		$n = 0;
		foreach ($liste_objets_orphelins as $objet) { ?>
			<div class="grid single-item-wrapper gap-½-1">
				<div class="ta-right fs-300" style="grid-area: id; align-self: center" title="id de l’objet"><?= $objet->id ?></div>
				<input type="text" name="objet-gestionnaire[<?= $n ?>][Nom]" value="<?= $objet->name ?>" placeholder="Nom de l’objet" style="grid-area: name" title="Nom de l’objet">
				<div class="flex-s ai-center">
					<label class="ff-fas" title="contenant ?">
						&#xf187;
						<input type="checkbox" name="objet-gestionnaire[<?= $n ?>][Contenant]" <?= $objet->isContainer ? "checked" : "" ?> >
					</label>
				</div>
				<input type="text" name="objet-gestionnaire[<?= $n ?>][Poids]" value="<?= $objet->weight ?>" class="ta-center" placeholder="Pds" title="poids">
				<input type="text" name="objet-gestionnaire[<?= $n ?>][Lieu]" value="<?= $objet->place ?>" class="ta-center" placeholder="Lieu" title="code lieu">
				<input type="text" name="objet-gestionnaire[<?= $n ?>][Notes]" value="<?= $objet->notes ?>" placeholder="Notes" style="grid-area: notes" title="Notes visibles par le joueur">
				<input type="text" name="objet-gestionnaire[<?= $n ?>][Secret]" value="<?= $objet->secret ?>" class="clr-invalid" placeholder="Notes du MJ" style="grid-area: notes-mj" title="Notes secrètes du MJ">
				<input hidden name="objet-gestionnaire[<?= $n ?>][id]" value="<?= $objet->id ?>">
				<input hidden name="objet-gestionnaire[<?= $n ?>][MJ]" value="<?= $_SESSION["id"] ?>">
			</div>
		<?php
			$n++;
		} ?>
		<button type="submit" class="btn-primary fs-500 ff-fas mx-auto mt-½">&#xf0c7;</button>
	</form>
</article>

<!-- Groupes et personnages -->
<article>
	<h2 class="flex-s gap-½">
		Groupes &amp; Personnages
		<button class="nude ff-fas" data-role="open-dialog" data-dialog-name="characters-dialog" title="mode d’emploi">&#xf059;</button>
	</h2>

	<?php foreach ($groups as $group) { ?>
		<details data-group="<?= $group->id ?>">
			<summary>
				<h3><?= $group->id ?? "X" ?>. <?= $group->name ?></h3>
			</summary>
			<div class="grid col-auto-fill gap-½ mt-½" style="--col-min-width: 370px">
				<?php
				$group_characters = array_filter($characters, fn($x) => $x->id_group === $group->id);
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

					$style_pattern = "background: linear-gradient(90deg, %s %d%%, var(--white) %d%%);";

					// style des indicateurs d’état des PdV, PdF, PdM et PdE
					if ($r_pdv > 75) $style_pdv = sprintf($style_pattern, "var(--clr-valid)", $r_pdv, $r_pdv);
					elseif ($r_pdv > 50) $style_pdv = sprintf($style_pattern, "var(--clr-fair)", $r_pdv, $r_pdv);
					elseif ($r_pdv > 25) $style_pdv = sprintf($style_pattern, "var(--clr-warning)", $r_pdv, $r_pdv);
					elseif ($r_pdv > 0) $style_pdv = sprintf($style_pattern, "var(--clr-invalid)", $r_pdv, $r_pdv);
					elseif ($r_pdv == 0 and $pdv === "") $style_pdv = "background: none;";
					else $style_pdv = "background: var(--clr-invalid);";

					if ($r_pdf > 50) $style_pdf = sprintf($style_pattern, "var(--clr-valid)", $r_pdf, $r_pdf);
					elseif ($r_pdf > 25) $style_pdf = sprintf($style_pattern, "var(--clr-warning)", $r_pdf, $r_pdf);
					elseif ($r_pdf > 10) $style_pdf = sprintf($style_pattern, "var(--clr-warning)", $r_pdf, $r_pdf);
					elseif ($r_pdf > 0) $style_pdf = sprintf($style_pattern, "var(--clr-invalid)", $r_pdf, $r_pdf);
					elseif ($r_pdf == 0 and $pdf == "") $style_pdf = "background: none;";
					else $style_pdf = "background: var(--clr-invalid);";

					$style_pdm = sprintf($style_pattern, "var(--grey-700)", $r_pdm, $r_pdm);

					if ($r_pde > 50) $style_pde = sprintf($style_pattern, "var(--clr-valid)", $r_pde, $r_pde);
					elseif ($r_pde > 25) $style_pde = sprintf($style_pattern, "var(--clr-warning)", $r_pde, $r_pde);
					elseif ($r_pde > 0) $style_pde = sprintf($style_pattern, "var(--clr-invalid)", $r_pde, $r_pde);
					elseif ($r_pde == 0 and $pde == "") $style_pde = "background: none;";
					else $style_pde = "background : var(--clr-invalid);";
				?>

					<form class="card card-character" data-role="character-state-form" id="state-form-character-<?= $perso->id ?>">

						<input hidden name="id" value="<?= $perso->id ?>">

						<div class="flex-s ai-first-baseline gap-½">
							<h4 class="mt-0 fl-1">
								<?= $perso->id ?>. <?= $perso->name ?>
								<span id="confirm-export-<?= $perso->id ?>"></span>
							</h4>
							<button data-role="save-character" type="submit" title="enregistrer (Ctrl+S)" class="nude ff-fas fs-500" data-id="<?= $perso->id ?>">
								&#xf0c7;
							</button>
							<a href="personnage-fiche?perso=<?= $perso->id ?>" target="_blank" class="ff-fas fs-500 btn nude" title="voir la fiche">
								&#xf2c2;
							</a>
							<button type="button" data-role="export-character" title="exporter en txt" class="nude ff-fas fs-500" data-id="<?= $perso->id ?>">&#xf56e;</button>
						</div>

						<div class="flex-s gap-½ mt-½">
							<input type="text" name="Pts" value="<?= $perso->points ?>" style="width: 5ch" class="ta-center" title="Pts de perso">
							<input type="text" name="id_groupe" value="<?= $perso->id_group ?>" style="width: 5ch" class="ta-center" title="groupe" placeholder="Gr">
							<select name="id_joueur" class="fl-1" title="joueur">
								<?php foreach ($users as $user) { ?>
									<option value="<?= $user->id ?>" <?= $user->id === $perso->id_player ? "selected" : "" ?>><?= $user->login ?></option>
								<?php } ?>
							</select>
							<select name="Statut" class="fl-1" title="statut">
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
							<textarea name="État[Autres]" placeholder="Autres éléments d’état" title="Autres éléments d’état" style="min-height: 5em;"><?= $perso->state["Autres"] ?? "" ?></textarea>
						</div>

						<!-- Détails du personnage -->
						<div class="mt-½ flow" data-role="character-summary">
							<!-- asynchronous fill with template -->
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

<!-- Créer un personnage -->
<article>
	<h2 class="flex-s gap-½">
		Créer un personnage
		<button class="nude ff-fas" data-role="open-dialog" data-dialog-name="create-characters-dialog" title="mode d’emploi">&#xf059;</button>
	</h2>
	<p>Les kits sont cumulatifs. En cas de conflit sur certaines valeurs, les dernières (dans l’ordre de lecture) écrasent les premières.</p>
	<form method="post" action="/submit/create-character">
		<div class="grid col-auto-fit gap-½" style="--col-min-width: 250px">
			<div class="card">
				<label>
					<input type="checkbox" name="kit_base">
					<b>Kit de base</b>
				</label>
				<p><i>Esquive</i>, <i>Furtivité</i>, <i>Culture générale</i>, <i>Baratin</i>, <i>Acteur</i></p>
			</div>
			<div class="card">
				<label>
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
				<p><i>Pack Ange</i>, <i>Force</i> 14, <i>Santé</i> 12, <i>Volonté</i> 12</p>
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
		<button type="submit" class="btn-primary fs-500 ff-fas mx-auto mt-½" title="Créer un nouveau personnage">&#xe541;</button>
	</form>
</article>

<?php if ($admin) { ?>
	<!-- Groupes -->
	<article id="gestionnaire-groupes">
		<h2>Groupes</h2>
		<form action="/submit/groups" method="POST" autocomplete="off">
			<div class="grid col-auto-fit gap-½ fl-wrap jc-center" style="--col-min-width: 250px">

				<?php foreach ($groups as $group) {
					if ($group->id !== NULL) {
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
										<?php if ($user->status >= 2): ?>
											<option value="<?= $user->id ?>" <?= $user->id === $group->id_gm ? "selected" : "" ?>><?= $user->login ?></option>
										<?php endif; ?>
									<?php } ?>
								</select>
							</div>
						</div>
				<?php }
				} ?>

				<div class="card">
					<div class="ta-center italic">Entrez un nom pour créer un groupe</div>
					<input type="text" name="groupes[0][Nom]" class="full-width mt-½" placeholder="Nom du groupe">
					<input hidden name="groupes[0][MJ]" value="1">
				</div>

			</div>
			<button type="submit" class="btn-primary fs-500 ff-fas mx-auto mt-½">&#xf0c7;</button>
		</form>
	</article>
<?php } ?>

<template id="character-details">

	<p data-content="Description"></p>

	<p>
		<b>For</b> <span data-content="For"></span>&nbsp;;
		<b>Dex</b> <span data-content="Dex"></span>&nbsp;;
		<b>Int</b> <span data-content="Int"></span>&nbsp;;
		<b>San</b> <span data-content="San"></span>&nbsp;;
		<b>Per</b> <span data-content="Per"></span>&nbsp;;
		<b>Vol</b> <span data-content="Vol"></span><br>
		<b>Dég.</b> <span data-content="Dégâts"></span>&nbsp;;
		<b>Réf.</b> <span data-content="Réflexes"></span>&nbsp;;
		<b>S.-F.</b> <span data-content="Sang-Froid"></span>&nbsp;;
		<b>Vit.</b> <span data-content="Vitesse"></span><br>
		<b>PdV</b> <span data-content="PdVm"></span>&nbsp;;
		<b>PdF</b> <span data-content="PdFm"></span>&nbsp;;
		<b>PdM</b> <span data-content="PdMm"></span>&nbsp;;
		<b>PdE</b> <span data-content="PdEm"></span>
	</p>

	<p data-content="Avantage"></p>
	<p data-content="Désavantage"></p>
	<p data-content="Travers"></p>
	<p data-content="Réputation"></p>

	<p data-content="Collèges"></p>
	<p data-content="Pouvoirs"></p>

	<p class="mt-1 mb-0 fw-700">Encombrement <span data-content="Encombrement"></span></p>
	<p class="mt-0" data-content="Équipement"></p>
</template>

<!-- Dialog for details displayed on click (PJ avdesav) -->
<dialog data-name="details">
	<button data-role="close-modal" class="ff-fas">&#xf00d;</button>
	<h4 class="mt-½"></h4>
	<div class="mt-½ flow"></div>
</dialog>

<!-- Help for orphan items -->
<dialog data-name="orphan-objects-dialog">
	<button data-role="close-modal" class="ff-fas">&#xf00d;</button>
	<h4 class="mt-½">Objets orphelins</h4>
	<div class="mt-½ flow">
		<p>Cette section sert à gérer les objets sans propriétaire ou se trouvant dans un « lieu » incohérent.</p>
		<p>Lorsqu’un objet est supprimé d’une fiche de personnage, il se retrouve dans cette liste.</p>

		<p><b>Liste des actions possibles :</b></p>
		<ul>
			<li><b>Supprimer définitivement un objet :</b> effacer son nom.</li>
			<li><b>Attribuer un lieu à un objet :</b> pi_{id-personnage}, ou pe_{id-personnage} ou ct_{id-contenant}. Le préfixe pi_ place l’objet dans la liste <i>Possession sur soi</i>, pe_ le place dans <i>Divers</i> et ct_ le place dans un contenant. Si la valeur donnée est incohérente, l’objet restera dans la liste. En passant la souris sur un titre de contenant (dans la fiche de perso correspondante), le code de localisation s’affichera.</li>
			<li><b>Créer un objet :</b> vous pouvez créer un objet et le garder sans propriétaire (localisation pi_0) ou l’attribuer tout de suite.</li>
		</ul>
	</div>
</dialog>

<!-- Help for characters -->
<dialog data-name="characters-dialog">
	<button data-role="close-modal" class="ff-fas">&#xf00d;</button>
	<h4 class="mt-½">Gestion des personnages</h4>
	<div class="mt-½ flow">
		<p>Cette section sert à gérer les personnages sous l’autorité du MJ. Elle est divisée en groupes (un groupe est un ensemble de personnages jouant ensemble). Chaque MJ a accès à ses propres groupes, ainsi qu’au groupe « <i>Personnages test</i> », commun à tous les MJ.</p>
		<p>Vous pouvez gérer les éléments suivants sur chaque personnage – ces éléments ne sont pas gérables par leur joueur :</p>
		<ul>
			<li><b>Nombre total de pts de personnage :</b> à modifier à la fin de chaque scénario lors de l’attribution des pts de perso.</li>
			<li><b>Groupe :</b> placer le personnage dans un groupe en y mettant son id. Rafraîchir la page après modification.</li>
			<li><b>Attribuer le personnage à un joueur</b>.</li>
			<li><b>Attribuer un statut à un personnage :</b> une fois que le personnage a été créé, lui attribuer le statut <i>Actif</i> permet de tenir compte du surcoût en pt de perso des modifications des caractéristiques principales. Le statut <i>Archivé</i> empêche le joueur d’accéder à son personnage. Le statut <i>Mort</i> a les mêmes effets que le statut <i>Archivé</i>. Il est juste indicatif.</li>
			<li><b>Gérer les PdV, PdF et PdE :</b> les joueurs ne peuvent pas le faire. Par contre, ils gèrent eux-même leur PdM. Vous pouvez entrer une opération simple (comme 10-4, par exemple), elle sera automatiquement calculée.</li>
			<li><b>Gérer les modificateurs de caractéristiques :</b> si vous avez besoin de modifier une caractéristique indépendamment de l’effet d’un élément d’état (fatigue, encombrement, blessure&hellip;).</li>
			<li><b>Gérer le stress</b></li>
			<li><b>Gérer le modificateur de magie :</b> en cas de fluide faible, par exemple. Il n’affecte que les sorts (pas les pouvoirs).</li>
			<li>Gérer les blessures aux membres : attention à bien respecter l’écriture (J pour jambe, P pour pied, B pour bras, M pour main, G pour gauche et D pour droite, puis le nombre de pts de dégâts subis). Par exemple : JD 4, BD 1.</li>
			<li><b>Autres éléments d’état :</b> notez ici des indications libres (une par ligne). Elles apparaîtront sur la fiche de perso.</li>
		</ul>
		<p>Vous avez également trois boutons : <span class="ff-far">&#xf0c7;</span> pour sauvegarder les modifications (provoquera une mise à jour de la fiche du perso automatiquement), <span class="ff-far">&#xf2c2;</span> pour voir la fiche complète du personnage et <span class="ff-fas">&#xf56e;</span> pour créer une sauvegarde du personnage dans son état actuel dans un fichier .txt. Pour l’instant, seul moi ai accès à ce fichier.</p>
	</div>
</dialog>

<!-- Help for characters creation -->
<dialog data-name="create-characters-dialog">
	<button data-role="close-modal" class="ff-fas">&#xf00d;</button>
	<h4 class="mt-½">Créer un personnage</h4>
	<div class="mt-½ flow">
		<p>Cette section sert à créer un nouveau personnage (🖐️ merci de ne pas créer des personnages à tort et à travers).</p>
		<p>Vous pouvez attribuer un ou plusieurs kits au personnage. Ça lui attribuera certaines spécificités différentes de valeurs par défaut.</p>
		<p>Après sa création, le personnage créé vous sera attribué et placé dans le groupe « <i>Personnages test</i> ».</p>
	</div>
</dialog>

<script type="module" src="/scripts/characters-manager<?= PRODUCTION ? ".min" : "" ?>.js?v=<?= VERSION ?>" defer></script>