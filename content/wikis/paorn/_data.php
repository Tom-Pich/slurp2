<?php
// key : URL de l’article
// title, section → évident
// parent : position de l’article dans le sommaire
// min-height : pour éviter le débordement des images sur colonne à droite
// status : s’ajoute au titre dans la colonne sommaire

$articles = [

	"home" => ["title" => "Wiki Paorn", "description" => "Diverses notes à propos de Paorn"],

	"artaille" => ["title" => "Artaille", "section" => "Pays &amp; Régions"],
	"lauria" => ["title" => "Lauria", "section" => "Pays &amp; Régions"],

	"almisie" => ["title" => "Almisie", "section" => "Lieux de Burgonnie"],
	"imegie" => ["title" => "Imégie", "section" => "Lieux de Burgonnie"],
	"auberge-vieille-tour" => ["title" => "Auberge de la Vieille Tour", "parent" => "imegie", "min-height" => "900px"],
	"port-goshal" => ["title" => "Port Goshal", "section" => "Lieux de Burgonnie"],
	"stomilie" => ["title" => "Stomilie", "section" => "Lieux de Burgonnie"],

	"mikalas" => [ "title" => "Mikalas", "section" => "Lieux de Lauria" ],
	"parna" => [ "title" => "Parna", "section" => "Lieux de Lauria", "status" => "🛠️" ],
	"peponia" => [ "title" => "Péponia", "section" => "Lieux de Lauria" ],
	"pasganon" => ["title" => "Les Pasganon", "section" => "Lieux de Lauria", "status" => "🛠️"],

	"arcania" => ["title" => "Arcania", "section" => "Organisations"],

	"atrimisme" => ["title" => "Atrimisme", "section" => "Culture"],
	"pentatheisme" => ["title" => "Pentathéisme", "section" => "Culture"],
	"langues" => ["title" => "Langues", "section" => "Culture"]
];
