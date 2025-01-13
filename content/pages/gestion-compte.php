<?php

use App\Repository\UserRepository;

$user_repo = new UserRepository;
$user = $user_repo->getUser($_SESSION["id"]);
?>

<?php if (empty($user)) : ?>

	<p>Désolé, il n’est pas possible de se créer soi-même un compte sur ce site. Contactez-moi si vous avez des questions.</p>
	<p>Si vous avez oublié votre mot de passe, envoyez-moi un message pour le réinitialiser.</p>

<?php else : ?>

	<p>Vous pouvez changer votre mot de passe. Celui-ci doit contenir au moins 8 caractères, dont au moins 1 chiffre, 1 caractère spécial, une majuscule, une minuscule et aucun espace.</p>

	<form id="pwd-change-form" class="grid gap-½ mx-auto mt-4" style="max-width: 35ch">
		<input type="password" id="pwd0" name="pwd0" placeholder="Mot de passe actuel" required>
		<input type="password" id="pwd1" name="pwd1" class="watched" placeholder="Nouveau mot de passe" required>
		<input type="password" id="pwd2" name="pwd2" class="watched" placeholder="Répétez le nouveau mot de passe" required>
		<input hidden name="token" value="<?= $_SESSION["token"] ?>">
		<button class="mx-auto mt-½ btn-primary">Valider</button>
	</form>

	<p id="change-pwd-response" class="ta-center mt-2 italic"></p>

<?php endif ?>

<script type="module">
	import {
		qs,
		checkPasswordStrength
	} from "/scripts/utilities.js";

	const form = qs("#pwd-change-form");
	const pwd0 = qs("#pwd0");
	const pwd1 = qs("#pwd1");
	const pwd2 = qs("#pwd2");
	const responseWrapper = qs("#change-pwd-response");

	let pwdIsStrong = false;
	let pwdMatch = false;

	// check if password 1 is strong
	pwd1.addEventListener("keyup", () => {
		console.log(pwdIsStrong)
		if (checkPasswordStrength(pwd1.value)) {
			pwdIsStrong = true;
			pwd1.setCustomValidity("");
		} else {
			pwdIsStrong = false;
			pwd1.setCustomValidity("Mot de passe faible");
		}
	})

	// check if password 2 matches password 1
	pwd2.addEventListener("keyup", () => {
		if (pwd1.value === pwd2.value) {
			pwd2.setCustomValidity("");
			pwdMatch = true;
		} else {
			pwd2.setCustomValidity("Les mots de passe ne correspondent pas");
			pwdMatch = false;
		}
	})

	// submit or reject submission
	form.addEventListener("submit", (e) => {
		e.preventDefault();
		console.log(pwdIsStrong && pwdMatch)
		if (pwdIsStrong && pwdMatch) {
			fetch("/submit/change-password", {
					method: 'post',
					body: new FormData(form)
				})
				.then(response => response.text())
				.then(response => {
					responseWrapper.innerText = response;
				})
			pwd0.value = "";
			pwd1.value = "";
			pwd2.value = "";
		} else if (!pwdMatch) {
			responseWrapper.innerText = "Les mots de passe donnés sont différents !"
		} else {
			responseWrapper.innerText = "Votre nouveau mot de passe n’est pas assez fort."
		}
	})
</script>