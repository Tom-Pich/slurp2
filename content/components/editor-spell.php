<article>
	<h2>Sort</h2>

	<form method="post" action="/submit/set-spell" autocomplete="off">

		<div class="flex gap-2 mx-1">
			<div class="fl-1">
				<div class="flex-s gap-½">
					<input type="text" name="Nom" value="<?= $sort->name ?>" class="fl-1" placeholder="Nom du sort">
					<input type="text" name="Niv" value="<?= $sort->readableNiv ?>" style="width: 8ch" class="ta-center" placeholder="I-V" required>
				</div>
				<div class="flex-s gap-½ mt-½ ai-first-baseline">
					<div style="width: 15ch">Origine</div>
					<input type="text" class="fl-1" name="Origine" value="<?= $sort->origin ?>" list="existing-origins" required>
					<datalist id="existing-origins">
						<?php foreach ($liste_origines as $origine) { ?>
							<option value="<?= $origine ?>"></option>
						<?php } ?>
					</datalist>
				</div>
				<div class="flex-s gap-½ mt-½ ai-first-baseline">
					<div style="width: 15ch">Collège(s)</div>
					<input type="text" class="fl-1" name="Collège" value="<?= join(", ", $sort->colleges) ?>" required>
				</div>
				<div class="mt-½ fs-300">
					À séparer par une virgule.
					<?php foreach ($liste_colleges as $id => $college) {
						echo $id . ".&nbsp;" . $college . ($id !== array_key_last($liste_colleges) ? ", " : "");
					} ?>
				</div>

				<p>Pour supprimer le sort, effacer son nom.</p>

				<div class="mt-1 grid gap-½ ai-center" style="grid-template-columns: 18ch 1fr">

					<label>Classe (déf. <i>Régulier</i>)</label>
					<input type="text" name="Classe" value="<?= $sort->class ?>" placeholder="Classe" list="existing-classes">
					<datalist id="existing-classes">
						<?php foreach ($liste_classes as $classe) { ?>
							<option value="<?= $classe ?>"></option>
						<?php } ?>
					</datalist>

					<label>Durée</label>
					<input type="text" name="Durée" value="<?= $sort->duration ?>" placeholder="Durée">

					<label>Temps (déf. <i>court</i>)</label>
					<input type="text" name="Temps" value="<?= $sort->time ?>" placeholder="Temps" list="suggested-duration">
					<datalist id="suggested-duration">
						<option value="long"></option>
					</datalist>

					<label>Zone (déf. 3 m)</label>
					<input type="text" name="Zone" value="<?= $sort->zone ?>" placeholder="Zone">

					<label>Résistance</label>
					<input type="text" name="Résistance" value="<?= $sort->resistance ?>" placeholder="Résistance">

				</div>
			</div>
			<textarea name="Description" placeholder="Description du sort" class="fl-1" required><?= $sort->description ?></textarea>
		</div>

		<input hidden name="id" value="<?= $sort->id ?>">
		<button class="mx-auto mt-2 ff-fas">&#xf0c7;</button>

	</form>

</article>