<article>
	<h2>Avantages &amp; Désavantages</h2>

	<form method="post" action="/submit/set-avdesav" autocomplete="off" data-role="rule-item-editor">

		<div class="flex gap-2 px-1">

			<div class="fl-1">
				<div class="flex-s gap-½">
					<input type="text" name="Nom" value="<?= $avdesav->name ?>" class="fl-1" placeholder="Nom">
					<input type="text" name="Coût" value="<?= $avdesav->id ? $avdesav->displayCostInEditor() : "" ?>" style="width: 12ch" class="ta-center" placeholder="Coût" title="Coût" required>
				</div>
				<div class="mt-½ flex-s gap-½ ai-first-baseline">
					<input type="text" name="Catégorie" value="<?= $avdesav->category ?>" class="fl-1" placeholder="Catégorie" title="Catégorie" list="existing-categories">
					<datalist id="existing-categories">
						<?php foreach ($liste_categories as $categorie) { ?>
							<option value="<?= $categorie ?>"></option>
						<?php } ?>
					</datalist>
					<label>
						<input type="checkbox" name="Niv" <?= $avdesav->hasNiv ? "checked" : "" ?>>
						Niveaux
					</label>
					<label>
						<input type="checkbox" name="Pouvoir" <?= $avdesav->isPower ? "checked" : "" ?>>
						Peut être un pouvoir
					</label>
				</div>
				<p>Pour supprimer l’avantage ou désavantage, effacer son nom.</p>
				<p><b>Coût&nbsp;:</b> à séparer par une virgule s’il y en a plusieurs. Ordre&nbsp;: valeur la plus proche de 0 en premier. Si le coût peut être négatif et positif, valeur négative la plus basse d’abord. S’il y a plus de deux valeurs possibles, préciser les valeurs extrêmes et ajouter "true".</p>
				<p><b>Catégories existantes&nbsp;:</b> <?= implode(", ", $liste_categories) ?></p>
			</div>

			<textarea name="Description" placeholder="Description" class="fl-1"><?= $avdesav->description ?></textarea>

		</div>

		<input hidden name="id" value="<?= $avdesav->id ?>">
		<button type="submit" class="mx-auto mt-2 ff-fas">&#xf0c7;</button>

	</form>

</article>

<script type="module">
	/* import {qs} from "/scripts/utilities.js";
	const form = qs("[data-role=rule-item-editor]");
	form.addEventListener("submit", (e) => {
		e.preventDefaults();
	})
	console.log(form) */
</script>