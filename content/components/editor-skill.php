<form method="post" action="/submit/set-skill" autocomplete="off">

	<div class="grid col-2 gap-2">
		<div class="flow">
			<div class="flex-s gap-½">
				<input type="text" name="Nom" value="<?= $comp->name ?>" class="fl-1" placeholder="Nom">
				<input type="text" name="Base" value="<?= $comp->base ?>" style="width: 5ch" placeholder="Base" class="ta-center" title="Base">
				<input type="text" name="Difficulté" value="<?= $comp->readableDifficulty ?>" style="width: 5ch" placeholder="Diff." class="ta-center" title="Difficulté (ex. -4)">
			</div>
			<div class="flex-s mt-½">
				<input type="text" name="Catégorie" value="<?= $comp->category ?>" class="fl-1" placeholder="Catégorie" list="existing-categories">
				<datalist id="existing-categories">
					<?php foreach ($liste_categories as $categorie) { ?>
						<option value="<?= $categorie ?>"></option>
					<?php } ?>
				</datalist>
			</div>
			<p>Pour supprimer la compétence, effacer son nom.</p>
			<p><b>Catégories&nbsp;:</b> <?= implode(", ", $liste_categories) ?></p>
		</div>
		<textarea name="Description" placeholder="Description" class="p-1" tinyMCE><?= $comp->description ?></textarea>
	</div>

	<input hidden name="id" value="<?= $comp->id ?>">
	<button class="btn-primary mx-auto mt-2 ff-fas">&#xf0c7;</button>

</form>