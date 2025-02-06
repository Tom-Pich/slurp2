<form method="post" action="/submit/set-creature" autocomplete="off">
	<div class="flex gap-2">
		<div class="flow fl-1">

			<input type="text" class="full-width" name="Nom" value="<?= $creature->name ?>" placeholder="Nom">

			<div class="flex-s gap-1 mt-1 ai-first-baseline">
				<div style="width: 10ch">Catégorie</div>
				<input type="text" class="fl-1" name="Catégorie" value="<?= $creature->category ?>" placeholder="Catégorie" list="existing-categories" required>
				<datalist id="existing-categories">
					<?php foreach ($liste_categories as $categorie) { ?>
						<option value="<?= $categorie ?>"></option>
					<?php } ?>
				</datalist>
				<div>Origine</div>
				<input type="text" style="width: 8ch" name="Origine" value="<?= $creature->origin ?>" placeholder="Origine" list="existing-origins" required>
				<datalist id="existing-origins">
					<?php foreach ($liste_origines as $origine) { ?>
						<option value="<?= $origine ?>"></option>
					<?php } ?>
				</datalist>
			</div>
			<div class="flex-s gap-1 mt-1 ai-first-baseline">
				<div style="width: 10ch">Poids</div>
				<div>
					<input type="text" name="Pds1" value="<?= $creature->weight_min ?>" style="width: 6ch" placeholder="min" class="ta-center" title="poids min" required> –
					<input type="text" name="Pds2" value="<?= $creature->weight_max ?>" style="width: 6ch" placeholder="max" class="ta-center" title="poids max" required>
				</div>
			</div>
			<div class="flex-s gap-1 mt-1 ai-first-baseline">
				<div style="width: 10ch">Taille</div>
				<input type="text" name="Taille" class="fl-1" value="<?= $creature->size ?>" placeholder="Taille">
			</div>
			<?php if ($creature->image): ?>
				<div>
					<img src="<?= $creature::creature_folder . $creature->image ?>" class="aspect-square mx-auto" style="max-width: 150px">
				</div>
			<?php endif ?>
			<div class="flex-s gap-1 mt-1 ai-first-baseline">
				<div style="width: 10ch">Image</div>
				<?php if ($creature->id): ?>
					<input type="file" class="fl-1" name="Image">
				<?php else: ?>
					<div class="fl-1">Enregistrez la créature avant de pouvoir insérer une image</div>
				<?php endif ?>
			</div>

			<div class="flex-s gap-1 mt-2 ai-center jc-space-between">
				<?php $mult_pds_for = $creature->w_mult_strength !== 1.0 ? $creature->w_mult_strength : "" ?>
				<?php $mult_pds_pdv = $creature->w_mult_pdv !== 1.0 ? $creature->w_mult_pdv : "" ?>

				<div class="flex-s gap-½ ai-first-baseline">
					<div>For*</div>
					<input type="text" style="width: 5ch" class="ta-center" name="Options[Mult_pds_for]" value="<?= $mult_pds_for ?>" placeholder="For">
				</div>
				<div class="flex-s gap-½ ai-first-baseline">
					<div>Int</div>
					<input type="text" class="ta-center" style="width: 5ch" name="Int" value="<?= $creature->int ?>" placeholder="Int" required>
				</div>
				<div class="flex-s gap-½ ai-first-baseline">
					<div>PdV*</div>
					<input type="text" class="ta-center" style="width: 5ch" name="Options[Mult_pds_pdv]" value="<?= $mult_pds_pdv ?>" placeholder="PdV">
				</div>
				<div class="flex-s gap-½ ai-first-baseline">
					<div>RD</div>
					<input type="text" class="ta-center" name="RD" class="ta-center" style="width: 12ch" value="<?= $creature->rd ?>" placeholder="RD" required>
				</div>
				<div class="flex-s gap-½ ai-first-baseline">
					<div>Vitesse</div>
					<input type="text" class="ta-center" style="width: 5ch" name="Vitesse" value="<?= $creature->speed ?>" placeholder="Vit" required>
				</div>
			</div>

			<div class="mt-½">* Multiplicateur de poids pour la calcul de la <i>For</i> et des PdV. (par défaut&nbsp;: 1).</div>

			<div class="mt-1">
				<label>
					<input type="checkbox" name="Options[Sans_pds]" <?= isset($creature->options["Sans_pds"]) ? "checked" : "" ?>>
					&nbsp;<b>La créature n’a pas de poids</b>. Celui-ci n’apparaîtra pas sur sa fiche. Il sert juste de base de calcul de la <i>For</i> et de PdV.
				</label>
			</div>

			<div class="mt-½">
				<label>
					<input type="checkbox" id="Sans_for" name="Options[Sans_for]" <?= isset($creature->options["Sans_for"]) ? "checked" : "" ?>>
					&nbsp;La caractéristique <i>Force</i> n’est pas pertinente pour cette créature.
				</label>
			</div>

			<h4>Avantages &amp; désavantage</h4>
			<textarea class="p-1 full-width" name="Avdesav" placeholder="Avantages &amp; Désavantages" style="height: 5em; min-height: 0;"><?= $creature->avdesav ?></textarea>

			<h4>Pouvoirs</h4>
			<textarea class="p-1 full-width" name="Pouvoirs" placeholder="Pouvoirs" style="height: 5em; min-height: 0;"><?= $creature->powers ?></textarea>

			<p class="mt-1">Pour supprimer la créature, effacer son nom.</p>
		</div>

		<div class="flow fl-1">
			<h4>Description</h4>
			<textarea name="Description" placeholder="Description" class="p-1 full-width" tinyMCE><?= $creature->description ?></textarea>

			<h4>Combat</h4>
			<textarea name="Combat" placeholder="Combat" class="p-1 full-width" tinyMCE><?= $creature->combat ?></textarea>
		</div>

	</div>

	<input hidden name="id" value="<?= $creature->id ?>">
	<input hidden name="Image" value="<?= $creature->image ?>">
	<button class="btn-primary mx-auto mt-2 ff-fas">&#xf0c7;</button>
</form>