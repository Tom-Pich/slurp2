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

	"almisie" => ["title" => "Almisie", "section" => "Villes de Burgonnie"],
	"imegie" => ["title" => "Imégie", "section" => "Villes de Burgonnie"],
	"auberge-vieille-tour" => ["title" => "Auberge de la Vieille Tour", "parent" => "imegie", "min-height" => "900px"],
	"port-goshal" => ["title" => "Port Goshal", "section" => "Villes de Burgonnie"],
	"stomilie" => ["title" => "Stomilie", "section" => "Villes de Burgonnie"],

	"mikalas" => [ "title" => "Mikalas", "section" => "Villes de Lauria" ],
	"parna" => [ "title" => "Parna", "section" => "Villes de Lauria", "status" => "🛠️" ],
	"peponia" => [ "title" => "Péponia", "section" => "Villes de Lauria" ],

	"arcania" => ["title" => "Arcania", "section" => "Organisations"],

	"atrimisme" => ["title" => "Atrimisme", "section" => "Culture"],
	"pentatheisme" => ["title" => "Pentathéisme", "section" => "Culture"],
	"langues" => ["title" => "Langues", "section" => "Culture"]
];
