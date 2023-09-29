<?php
use App\Repository\CharacterRepository;

global $pages_data;
$character_repo = new CharacterRepository;
$characters_list = $character_repo->getCharactersFromUser($_SESSION["id"], with_name: true);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="utf-8">
	<meta name="google-site-verification" content="Yap48CUfjcjJnXZufVRoH0B0KB5-_UXQArZJiRkn_Qs">
	<meta name="viewport" content="initial-scale=1.0, user-scalable=yes">
	<meta name="description" content="<?= $page["description"] ?>">
	<link rel="stylesheet" href="/styles.min.css">
	<link rel="shortcut icon" href="/assets/img/favicon.ico">
	<title><?= $page["title"] ?></title>

	<?php if (!empty($page["canonical"])) { ?>
		<link rel="canonical" href="https://jdr.pichegru.net/<?= $page["canonical"] ?>">
		<meta property="og:title" content="<?= $page["title"] ?>">
		<meta property="og:type" content="Website">
		<meta property="og:url" content="https://jdr.pichegru.net/<?= $page["canonical"] ?? "" ?>">
		<meta property="og:description" content="<?= $page["description"] ?>">
		<meta property="og:image" content="https://jdr.pichegru.net/assets/img/dices.png">
	<?php } ?>

	<!-- <script src="/fonctions/_general_header.js"></script> -->
	<script type="module" src="/scripts/main.js" defer></script>
</head>

<body class="<?= $page["body-class"] ?>">

	<header>

		<a id="logo" href="/" title="Accueil"><img src="/assets/img/favicon.ico" width="40" height="40"></a>

		<!-- Titres -->
		<div class="px-1">
			<h2>SLURP</h2>
			<h1><?= $page["title"] ?></h1>
		</div>

		<!-- login et bouton connexion/déconnexion -->
		<div id="login-element" <?= DB_ACTIVE ? "" : "hidden" ?>>

			<div class="flex-s gap-½ ai-center jc-center fs-500">
				<b><a href="/mon-compte"><?= $_SESSION['login']; ?></a></b>
				<button id="connection-btn" class="nude ff-fas" data-state="<?= $_SESSION["Statut"] ?>" title="<?= $_SESSION["Statut"] ? "Se déconnecter" : "Se connecter" ?>">
					<?= $_SESSION["Statut"] ? "&#xf08b;" : "&#xf023;" ?>
				</button>
			</div>

			<dialog id="connexion-dialog" class="p-1">
				<button class="nude ff-fas" data-action="close-modal">&#xf00d;</button>
				<form method="post" action="/submit/log-in" class="grid gap-½ mt-2">
					<input type="text" name="login" placeholder="Nom d’utilisateur" required>
					<input type="password" name="password" placeholder="Mot de passe" required>
					<input hidden name="token" value="<?= $_SESSION["token"] ?>">
					<input hidden name="redirect-url" value="<?= $_SERVER['REQUEST_URI'] ?>">
					<button class="mx-auto">Connexion</button>
				</form>
			</dialog>

			<?php if ($_SESSION["attempt"] and $_SESSION["attempt"] < 3) { ?>
				<p class="ta-center">Login/password erronés</p>
			<?php } elseif ($_SESSION["attempt"] >= 3) { ?>
				<p class="ta-center">Vous êtes banni&nbsp;!</p>
			<?php } ?>

		</div>

		<button id="show-nav-on-mobile" class="nude fs-600 fw-600 ff-fas">&#xf0c9;</button>

		<nav>
			<ul>
				<li>
					<h4>Règles principales</h4>
					<ul class="sub-menu" style="--height: 14rem;">
						<li><a href="/personnages"><?= $pages_data['personnages']["title"] ?></a></li>
						<li><a href="/avdesav-comp-sorts"><?= $pages_data['avdesav-comp-sorts']["title"] ?></a></li>
						<li><a href="/armes-armures"><?= $pages_data['armes-armures']["title"] ?></a></li>
						<li><a href="/bases-systeme"><?= $pages_data['bases-systeme']["title"] ?></a></li>
						<li><a href="/combat"><?= $pages_data['combat']["title"] ?></a></li>
						<li><a href="/blessures-dangers"><?= $pages_data['blessures-dangers']["title"] ?></a></li>
						<li><a href="/magie"><?= $pages_data['magie']["title"] ?></a></li>
						<li><a href="/animaux"><?= $pages_data['animaux']["title"] ?></a></li>
					</ul>
				</li>
				<li>
					<h4>En version bêta</h4>
					<ul class="sub-menu">
						<li><a href="/psioniques"><?= $pages_data['psioniques']["title"] ?></a></li>
						<li><a href="/vehicules"><?= $pages_data['vehicules']["title"] ?></a></li>
						<li><a href="/high-tech"><?= $pages_data['high-tech']["title"] ?></a></li>
					</ul>
				</li>
				<li>
					<h4>Univers de jeu</h4>
					<ul class="sub-menu">
						<li><a href="/adapted-dungeons-dragons"><?= $pages_data['adapted-dungeons-dragons']["title"] ?></a></li>
						<li><a href="/in-nomine"><?= $pages_data['in-nomine']["title"] ?></a></li>
						<li><a href="/cthulhu"><?= $pages_data['cthulhu']["title"] ?></a></li>
					</ul>
				</li>
				<li>
					<h4>Aides de jeu</h4>
					<ul class="sub-menu">
						<li><a href="/ecrire-scenario"><?= $pages_data['ecrire-scenario']["title"] ?></a></li>
						<li><a href="/aide-de-jeu-medfan"><?= $pages_data['aide-de-jeu-medfan']["title"] ?></a></li>
						<li><a href="/bibliotheque-liens"><?= $pages_data['bibliotheque-liens']["title"] ?></a></li>
						<?php if ($_SESSION['Statut'] >= 3) { ?>
							<li><a href="/paorn"><?= $pages_data['paorn']["title"] ?></a></li>
							<li><a href="/test">Test</a></li>
						<?php } ?>
					</ul>
				</li>
				<li>
					<h4>Mes personnages</h4>
					<ul class="sub-menu">
						<?php if ($_SESSION['Statut']) {
							if (count($characters_list)) {
								foreach ($characters_list as $character) { ?>
									<li><a href="/personnage-fiche?perso=<?= $character['id'] ?>"><?= $character['Nom'] ?></a></li>
								<?php }
							} else { ?>
								<li><i>Vous n’avez pas de personnage actif</i></li>
							<?php }
						} else { ?>
							<li><i>Connectez-vous pour accéder à vos personnages</i></li>
						<?php } ?>
					</ul>
				</li>
				<?php if ($_SESSION['Statut'] >= 2) { ?>
					<li>
						<h4><a href="/gestionnaire-mj"><?= $pages_data['gestionnaire-mj']["title"] ?></a></h4>
					</li>
				<?php } ?>
				<li>
					<h4><a href="/table-jeu"><?= $pages_data['table-jeu']["title"] ?></a></h4>
				</li>
			</ul>

		</nav>

	</header>

	<main>