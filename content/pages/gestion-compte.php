<h2 class="mt-1">Bonjour <?= $_SESSION["login"] ?> 👋</h2>

<fieldset class="px-1">
	<legend>Mot de passe</legend>
	<div class="grid col-2 gap-2">
		<p>Vous pouvez changer votre mot de passe. Celui-ci doit contenir au moins 8 caractères, dont au moins 1 chiffre, 1 caractère spécial, une majuscule, une minuscule et aucun espace.</p>
		<form id="pwd-change-form" class="grid gap-½">
			<input type="password" id="pwd0" name="pwd0" class="full-width" placeholder="Mot de passe actuel" required>
			<input type="password" id="pwd1" name="pwd1" class="full-width watched" placeholder="Nouveau mot de passe" required>
			<input type="password" id="pwd2" name="pwd2" class="full-width watched" placeholder="Répétez le nouveau mot de passe" required>
			<input hidden name="token" value="<?= $_SESSION["token"] ?>">
			<button class="mx-auto mt-½ btn-primary">Valider</button>
		</form>
	</div>
</fieldset>


<fieldset class="px-1">
	<legend>Options</legend>

	<form data-role="user-options">
		<div class="grid ai-center option-grid">
			<div class="fw-700 bg-grey-900 p-½">Thème</div>
			<div class="flex-s gap-1">
				<label>
					<input type="radio" name="mode" value="light" <?= $page["mode"] === "light" ? "checked" : "" ?>>
					Lumineux
				</label>
				<label>
					<input type="radio" name="mode" value="auto" <?= !in_array($page["mode"], ["light", "dark"]) ? "checked" : "" ?>>
					Automatique
				</label>
				<label>
					<input type="radio" name="mode" value="dark" <?= $page["mode"] === "dark" ? "checked" : "" ?>>
					Sombre
				</label>
			</div>
		</div>
		<div class="grid ai-center option-grid">
			<div class="fw-700 bg-grey-900 p-½">Fiche de perso</div>
			<div class="flex-s gap-1">
				<label>
					<input type="radio" name="style" value="normal" <?= $page["style"] !== "compact" ? "" : "checked" ?>>
					Normale
				</label>
				<label>
					<input type="radio" name="style" value="compact" <?= $page["style"] === "compact" ? "checked" : "" ?>>
					Compacte
				</label>
			</div>
		</div>
	</form>

</fieldset>

<script src="/scripts/account-settings<?= PRODUCTION ? ".min" : "" ?>.js?v=<?= VERSION ?>" type="module"></script>