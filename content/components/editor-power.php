<article>
	<h2>Pouvoirs</h2>

	<form method="post" action="/submit/set-power" autocomplete="off">
		<!--  id, id_RdB, Type, Nom, Catégorie, Domaine, Mult, Origine -->
		<div class="flex gap-2 px-2">
			<div class="fl-1">
				<h4 class="mt-0"><?= $pouvoir->data->name ?? "Nouveau pouvoir" ?></h4>
				<div class="flex-s gap-½ mt-½">
					<input type="text" class="ta-center" name="id_RdB" style="width: 5ch" value="<?= $pouvoir->specific["id_RdB"] ?>" placeholder="id RdB" title="id RdB">
					<select name="Type" style="width: 15ch" title="Type" required>
						<option value="0">-- Type</option>
						<option value="sort" <?= $pouvoir->specific["Type"] === "sort" ? "selected" : "" ?>>Sort</option>
						<option value="avantage" <?= $pouvoir->specific["Type"] === "avantage" ? "selected" : "" ?>>Avantage</option>
					</select>
					<input type="text" class="fl-1" name="Nom" value="<?= $pouvoir->specific["Nom"] ?>" placeholder="Nom spécifique" title="Nom spécifique">
				</div>
				<h4>Catégorie</h4>
				<div class="flex-s mt-½">
					<input type="text" class="fl-1" name="Catégorie" value="<?= $pouvoir->specific["Catégorie"] ?>" placeholder="Catégorie" list="existing-categories">
					<datalist id="existing-categories">
						<?php foreach ($liste_categories as $categorie) { ?>
							<option value="<?= $categorie ?>"></option>
						<?php } ?>
					</datalist>
				</div>
				<h4>Domaine</h4>
				<div class="flex-s mt-½">
					<input type="text" class="fl-1" name="Domaine" value="<?= $pouvoir->specific["Domaine"] ?>" placeholder="Domaine" list="existing-domains">
					<datalist id="existing-domains">
						<?php foreach ($liste_domaines as $domaine) { ?>
							<option value="<?= $domaine ?>"></option>
						<?php } ?>
					</datalist>
				</div>

				<div class="flex mt-2 gap-1">
					<div class="flex-s ai-first-baseline fl-1 gap-½">
						<div>Multiplicateur de coût</div>
						<input type="text" style="width: 8ch" name="Mult" value="<?= $pouvoir->specific["Mult"] ?>" placeholder="Mult" class="ta-center">
					</div>
					<div class="flex-s ai-first-baseline fl-1 gap-½">
						<div class="fl-1 ta-right">Origine</div>
						<input type="text" class="ta-center" style="width: 15ch" name="Origine" value="<?= $pouvoir->specific["Origine"] ?>" placeholder="Origine" list="existing-origins" required>
						<datalist id="existing-origins">
							<?php foreach ($liste_origines as $origine) { ?>
								<option value="<?= $origine ?>"></option>
							<?php } ?>
						</datalist>
					</div>
				</div>

				<p>Pour supprimer un pouvoir, effacer l’id du sort ou du pouvoir auquel il est lié.</p>

			</div>
			<div class="fl-1">
				<fieldset>
					<legend>
						Signification des entrées de pouvoirs
					</legend>
					<p>Chaque pouvoir est rattaché soit à un <i>avantage</i>, soit à un <i>sort</i>.</p>
					<p><b>id_RdB&nbsp;:</b> l’id du sort ou de l’avantage connecté au pouvoir.</p>
					<p><b>Type&nbsp;:</b> nécessairement soit un <i>avantage</i>, soit un <i>sort</i>. Si besoin, créer un nouvel avantage ou un nouveau sort au préalable.</p>
					<p><b>Nom spécifique&nbsp;:</b> ce nom a la priorité sur le nom par défaut de l’avantage ou du sort. À ne compléter que si besoin.</p>
					<p><b>Catégorie&nbsp;:</b> une étiquette de classification qui dépend de l’univers de jeu auquel s’applique le pouvoir.</p>
					<p><b>Domaine&nbsp;:</b> une autre étiquette de classification qui dépend de l’univers de jeu.</p>
					<p><b>Origine&nbsp;:</b> l’univers de jeu pour lequel ce pouvoir est disponible.</p>
				</fieldset>

			</div>

		</div>
		<input hidden name="id" value="<?= $pouvoir->id ?>">
		<button class="mx-auto mt-2 ff-fas">&#xf0c7;</button>
	</form>

</article>