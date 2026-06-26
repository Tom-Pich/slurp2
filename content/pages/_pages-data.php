<?php
// voir Page Controller pour les données possibles
return $pages_data = [

	"home" => [
		"title" => "Le moteur de JdR universel",
		"description" => "Système de jeu de rôle Souple Léger Universel Rapide et Précis (SLURP)",
		"file" => "00-home",
		"body-class" => "home",
		"aside-left" => "aside-home-left",
		"aside-right" => "aside-home-right",
	],
	"personnages" => [
		"title" => "Personnages",
		"description" => "Les règles concernant la création de personnage",
		"file" => "01a-personnage",
	],
	"avdesav-comp-sorts" => [
		"title" => "Listes pour le personnage",
		"description" => "Tous les avantages, désavantages, compétences et sorts",
		"file" => "01b-listes",
	],
	"armes-armures" => [
		"title" => "Armes &amp; armures",
		"description" => "Règles et listes portant sur les armes et les armures",
		"file" => "02-armes-armures",
	],
	"bases-systeme" => [
		"title" => "Bases du système",
		"description" => "Les fondamentaux des règles de SLURP – jets de réussite",
		"file" => "03-bases",
	],
	"combat" => [
		"title" => "Combat",
		"description" => "Toutes les règles concernant les différentes situations de combat",
		"file" => "04-combat",
	],
	"blessures-dangers" => [
		"title" => "Blessures &amp; dangers",
		"description" => "Les blessures et leurs effets, la guérison et les effets de divers dangers",
		"file" => "05-blessures-dangers",
	],
	"magie" => [
		"title" => "Magie",
		"description" => "Les règles sur la magie – sorts, pouvoirs magiques, objets magiques, alchimie&hellip;",
		"file" => "06-magie",
	],
	"animaux" => [
		"title" => "Animaux",
		"description" => "Les règles sur les animaux – leurs caractéristiques, leur gestion en combat&hellip;",
		"file" => "07-animaux",
	],

	// En version bêta
	"psioniques" => [
		"title" => "Psioniques",
		"description" => "Les pouvoirs psioniques",
		"file" => "08-psioniques",
	],
	"vehicules" => [
		"title" => "Véhicules",
		"description" => "Tout sur les véhicules&nbsp;: caractéristiques, règles de poursuites, combat, dégâts&hellip;",
		"file" => "09-vehicules",
	],
	"high-tech" => [
		"title" => "High-tech",
		"description" => "Armes technologiques, informatique, robots, cyberprothèses&hellip;",
		"file" => "10-high-tech",
	],

	// Univers
	"adapted-dungeons-dragons" => [
		"title" => "AD&D",
		"description" => "Ce qu’il faut pour jouer dans l’esprit <i>Donjons &amp; Dragons</i>, sans le système abject d20.",
		"file" => "univers_add",
	],
	"in-nomine" => [
		"title" => "In Nomine",
		"description" => "Une adaptation relativement libre de l’incontournable «&nbsp;Magna Veritas&nbsp;»",
		"file" => "univers_in_nomine",
	],
	"cthulhu" => [
		"title" => "Cthulhu",
		"description" => "Quelques éléments pour jouer un <i>Cthulhu</i>",
		"file" => "univers_cthulhu",
	],
	"ombres-esteren" => [
		"title" => "Les Ombres d’Esteren",
		"description" => "Une adaptation libre des <i>Ombres d’Esteren</i>",
		"file" => "univers_ombres_esteren",
	],

	// Aides de jeu
	"ecrire-scenario" => [
		"title" => "Écrire un scénario",
		"description" => "Une évolution de l’article précédemment publié dans PTGPTB faisant la synthèse de nombreux articles sur la création de scénario",
		"file" => "s_scenario",
		"body-class" => "standard-page writing-scenario",
	],
	/* "aide-de-jeu-medfan" => [
		"title" => "Le Moyen Âge",
		"description" => "Quelques éléments sur le Moyen-Âge",
		"file" => "s_adj_med",
	], */
	"bibliotheque-liens" => [
		"title" => "Bibliothèque de liens",
		"description" => "Quelques liens utiles",
		"file" => "s_liens",
	],
	"concevoir-personnage" => [
		"title" => "Concevoir son perso",
		"description" => "Une liste de traits de caractère pour aider à la création de PJ et de PNJ",
		"file" => "s_concevoir_perso",
	],
	"vocabulaire-relief" => [
		"title" => "Vocabulaire du relief",
		"description" => "Une liste de vocabulaire permettant de décrire le relief d’un terrain, des plus grosses structures jusqu’au détails à l’échelle humaine",
		"file" => "s_vocabulaire_relief",
	],
	"qualite-jeu" => [
		"title" => "Améliorer le jeu",
		"description" => "Quelques trucs et astuces pour améliorer la qualité des parties – pour le MJ et pour les joueurs.",
		"file" => "s_qualite_jeu",
	],
	"test" => [
		"title" => "Test",
		"description" => "",
		"file" => "test",
		"body-class" => "test",
		"access-restriction" => 3,
	],

	// Personnage (fiche et gestionnaire)
	"personnage-fiche" => [
		"title" => "", // nom du perso
		"description" => "",
		"file" => "personnage-fiche",
		"body-class" => "personnage-fiche",
		"aside-right" => "chat-window",
	],
	"personnage-gestion" => [
		"title" => "Gestionnaire de personnages",
		"description" => "",
		"file" => "personnage-gestion",
		"body-class" => "personnage-gestion",
	],

	// Administration
	"gestionnaire-mj" => [
		"title" => "Gestionnaire du MJ",
		"description" => "",
		"file" => "gestion-mj",
		"body-class" => "standard-page gestionnaire-mj",
		"access-restriction" => 2,
		"aside-right" => "chat-window",
	],
	"gestion-listes" => [
		"title" => "Gestionnaire des RdB",
		"description" => "",
		"file" => "gestion-listes",
		"body-class" => "basic-page",
		"access-restriction" => 3,
	],
	"mon-compte" => [
		"title" => "Mon compte",
		"description" => "",
		"body-class" => "basic-page account-page",
		"access-restriction" => 1,
		"file" => "gestion-compte",
	],

	// Table de jeu
	"table-jeu" => [
		"title" => "Table de jeu",
		"description" => "Un ensemble de widget permettant la gestion de la partie assistée par ordinateur, ainsi qu’une fenêtre de tchat",
		"file" => "table_jeu",
		"body-class" => "table-jeu",
		"aside-right" => "chat-window",
	],

	// Licence
	"licence" => [
		"title" => "Licence",
		"description" => "Licence d’utilisation du JdR SLURP.",
		"body-class" => "basic-page",
		"file" => "licence",
	]

];
