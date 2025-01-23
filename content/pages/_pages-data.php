<?php
$pages_data = [

	"home" => [
		"title" => "Le moteur de JdR universel",
		"description" => "Système de jeu de rôle Souple Léger Universel Rapide et Précis",
		"file" => "00-home",
		"body-class" => "home",
		"version" => 4,
		"aside-left" => "aside-home-left",
		"aside-right" => "aside-home-right",
	],
	"personnages" => [
		"title" => "Personnages",
		"description" => "Les règles concernant la création de personnage",
		"file" => "01a-personnage",
		"version" => 4,
		"aside-left" => "aside-01-left",
	],
	"avdesav-comp-sorts" => [
		"title" => "Listes pour le personnage",
		"description" => "Tous les avantages, désavantages, compétences et sorts",
		"file" => "01b-listes",
		"version" => 4,
	],
	"armes-armures" => [
		"title" => "Armes &amp; armures",
		"description" => "Règles et listes portant sur les armes et les armures",
		"file" => "02-armes-armures",
		"version" => 4,
	],
	"bases-systeme" => [
		"title" => "Bases du système",
		"description" => "Les fondamentaux des règles",
		"file" => "03-bases",
		"version" => 4,
	],
	"combat" => [
		"title" => "Combat",
		"description" => "Toutes les règles concernant les différentes situations de combat",
		"file" => "04-combat",
		"version" => 4,
	],
	"blessures-dangers" => [
		"title" => "Blessures &amp; dangers",
		"description" => "Les blessures et leurs effets, la guérison et les effets de divers dangers",
		"file" => "05-blessures-dangers",
		"version" => 4,
	],
	"magie" => [
		"title" => "Magie",
		"description" => "Les règles sur la magie – sorts, pouvoirs magiques, objets magiques, alchimie&hellip;",
		"file" => "06-magie",
		"version" => 4,
	],
	"animaux" => [
		"title" => "Animaux", 
		"description" => "Les règles sur les animaux – leurs caractéristiques, leur gestion en combat&hellip;", 
		"file" => "07-animaux",
		"version" => 4,
	],

	// En version bêta
	"psioniques" => [
		"title" => "Psioniques", 
		"description" => "Les pouvoirs psioniques", 
		"file" => "08-psioniques",
		"version" => 4,
	],
	"vehicules" => [
		"title" => "Véhicules", 
		"description" => "Tout sur les véhicules&nbsp;: caractéristiques, règles de poursuites, combat, dégâts&hellip;", 
		"file" => "09-vehicules",
		"version" => 4,
	],
	"high-tech" => [
		"title" => "High-tech", 
		"description" => "Armes technologiques, informatique, robots, cyberprothèses&hellip;", 
		"file" => "10-high-tech",
		"version" => 4,
	],
	
	// Univers
	"adapted-dungeons-dragons" => [
		"title" => "AD&D",
		"description" => "Ce qu’il faut pour jouer dans l’esprit <i>Donjons &amp; Dragons</i>, sans le système abject d20.",
		"file" => "univers_add",
		"version" => 4,
	],
	"in-nomine" => [
		"title" => "In Nomine", 
		"description" => "Une adaptation relativement libre de l’incontournable «&nbsp;Magna Veritas&nbsp;»", 
		"file" => "univers_in_nomine",
		"version" => 4,
	],
	"cthulhu" => [
		"title" => "Cthulhu",
		"description" => "Quelques éléments pour jouer un <i>Cthulhu</i>", 
		"file" => "univers_cthulhu",
		"version" => 4,
	],
	"ombres-esteren" => [
		"title" => "Les ombres d’Esteren",
		"description" => "Une adaptation libre des <i>Ombres d’Esteren</i>", 
		"file" => "univers_ombres_esteren",
		"version" => 4,
	],

	// Aides de jeu
	"ecrire-scenario" => [
		"title" => "Écrire un scénario", 
		"description" => "Une évolution de l’article précédemment publié dans PTGPTB faisant la synthèse de nombreux articles sur la création de scénario", 
		"file" => "s_scenario",
		"body-class" => "standard-page writing-scenario",
		"version" => 4,
	],
	"aide-de-jeu-medfan" => [
		"title" => "Le Moyen Âge", 
		"description" => "Quelques éléments sur le Moyen-Âge", 
		"file" => "s_adj_med",
		"version" => 4,
	],
	"bibliotheque-liens" => [
		"title" => "Bibliothèque de liens", 
		"description" => "Quelques liens utiles", 
		"file" => "s_liens",
		"version" => 4,
	],
	"concevoir-personnage" => [
		"title" => "Concevoir son personnage", 
		"description" => "Une liste de traits de caractère pour aider à la création de PJ et de PNJ", 
		"file" => "s_concevoir_perso",
		//"body_class" => "basic-page",
		"version" => 4,
	],
	"test" => [
		"title" => "Test", 
		"description" => "", 
		"file" => "test",
		"body-class" => "test",
		"version" => 4,
	],

	// Personnage (fiche et gestionnaire)
	"personnage-fiche" => [
		"title" => "", // nom du perso 
		"description" => "", 
		"file" => "personnage-fiche",
		"body-class" => "personnage-fiche",
		"version" => 4,
		"aside-right" => "chat-window",
	],
	"personnage-gestion" => [
		"title" => "Gestionnaire de personnages", 
		"description" => "", 
		"file" => "personnage-gestion",
		"body-class" => "personnage-gestion",
		"version" => 4,
	],

	// Administration
	"gestionnaire-mj" => [
		"title" => "Gestionnaire du MJ", 
		"description" => "", 
		"file" => "gestion-mj",
		"body-class" => "standard-page gestionnaire-mj",
		"access-restriction" => 2,
		"version" => 4,
		"aside-right" => "chat-window",
	],
	"gestion-listes" => [
		"title" => "Gestionnaire des RdB",
		"description" => "", 
		"file" => "gestion-listes",
		"body-class" => "basic-page",
		"access-restriction" => 3,
		"version" => 4,
	],
	"mon-compte" => [
		"title" => "Mon compte",
		"description" => "",
		"body-class" => "basic-page",
		"file" => "gestion-compte",
		"version" => 4,
	],

	// Table de jeu
	"table-jeu" => [
		"title" => "Table de jeu",
		"description" => "Un ensemble de widget permettant la gestion de la partie assistée par ordinateur, ainsi qu’une fenêtre de tchat",
		"file" => "table_jeu",
		"body-class" => "table-jeu",
		"version" => 4,
		"aside-right" => "chat-window"
	],

	// Wiki
	"wiki" => [
		"title" => NULL, // géré dans _data.php dans le dossier wikis/{wiki}
		"description" => NULL, // comme ci-dessus
		"file" => "wiki-template",
		"body-class" => "wiki",
		"version" => 4,
		"aside-left" => "aside-wiki-index", 
	],

	// Licence
	"licence" => [
		"title" => "Licence",
		"description" => "Licence d’utilisation du JdR SLURP.",
		"body-class" => "basic-page",
		"file" => "licence",
		"version" => 4,
	]
	
];
