<article>
	<h2>Pouvoir psionique</h2>

	<form method="post" action="/submit/set-psi" autocomplete="off">

		<div class="flex gap-2 mx-1">
			<div class="fl-1">
				<div class="flex-s gap-½">
					<input type="text" name="Nom" value="<?= $psi->name ?>" class="fl-1" placeholder="Nom du sort">
					<input type="text" name="Niv" value="<?= $psi->data->readableNiv ?>" style="width: 8ch" class="ta-center" placeholder="I-V" required>
				</div>
				<div class="flex-s gap-½ mt-½ ai-first-baseline">
					<div style="width: 15ch">Origine</div>
					<input type="text" class="fl-1" name="Origine" value="<?= $psi->data->origin ?>" list="existing-origins" required>
					<datalist id="existing-origins">
						<?php foreach ($liste_origines as $origine) { ?>
							<option value="<?= $origine ?>"></option>
						<?php } ?>
					</datalist>
				</div>
				<div class="flex-s gap-½ mt-½ ai-first-baseline">
					<div style="width: 15ch">Discipline</div>
					<input type="text" class="fl-1" name="Discipline" value="<?= join(", ", $psi->data->colleges) ?>" required>
				</div>
				<div class="mt-½ fs-300">
					À séparer par une virgule.
					<?php foreach ($liste_disciplines as $id => $discipline) {
						echo $id . ".&nbsp;" . $discipline . ($id !== array_key_last($liste_disciplines) ? ", " : "");
					} ?>
				</div>

				<p>Pour supprimer le pouvoir, effacer son nom.</p>

				<div class="mt-1 grid gap-½ ai-center" style="grid-template-columns: 18ch 1fr">

					<label>Classe (déf. <i>Régulier</i>)</label>
					<input type="text" name="Classe" value="<?= $psi->data->class ?>" placeholder="Classe" list="existing-classes">
					<datalist id="existing-classes">
						<?php foreach ($liste_classes as $classe) { ?>
							<option value="<?= $classe ?>"></option>
						<?php } ?>
					</datalist>

					<label>Durée</label>
					<input type="text" name="Durée" value="<?= $psi->data->duration ?>" placeholder="Durée">

					<label>Temps (déf. <i>court</i>)</label>
					<input type="text" name="Temps" value="<?= $psi->data->time ?>" placeholder="Temps" list="suggested-duration">
					<datalist id="suggested-duration">
						<option value="long"></option>
					</datalist>

					<label>Zone (déf. 3 m)</label>
					<input type="text" name="Zone" value="<?= $psi->data->zone ?>" placeholder="Zone">

					<label>Résistance</label>
					<input type="text" name="Résistance" value="<?= $psi->data->resistance ?>" placeholder="Résistance">

				</div>
			</div>
			<textarea name="Description" placeholder="Description du sort" class="fl-1" required><?= $psi->data->description ?></textarea>
		</div>

		<input hidden name="id" value="<?= $psi->id ?>">
		<button class="mx-auto mt-2 ff-fas">&#xf0c7;</button>

	</form>

</article>