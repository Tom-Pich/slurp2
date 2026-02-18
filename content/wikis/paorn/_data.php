<?php
// key : URL de l’article
// title, section → évident
// parent : position de l’article dans le sommaire
// min-height : pour éviter le débordement des images sur colonne à droite
// status : s’ajoute au titre dans la colonne sommaire

$articles = [

	"home" => ["title" => "Wiki Paorn", "description" => "Diverses notes à propos de Paorn"],
	"burgonnie" => ["title" => "Burgonnie",],
	

	"artaille" => ["title" => "Artaille", "section" => "Artaille",],
	"duche-elmora" => ["title" => "Duché d’Elmora", "section" => "Artaille"],
	"imegie" => ["title" => "Imégie", "section" => "Artaille"],
	"auberge-vieille-tour" => ["title" => "Auberge de la Vieille Tour", "parent" => "imegie", "min-height" => "900px"],
	"almisie" => ["title" => "Almisie", "section" => "Artaille"],
	"stomilie" => ["title" => "Stomilie", "section" => "Artaille"],
	"port-goshal" => ["title" => "Port Goshal", "section" => "Artaille"],

	"sordolia" => ["title" => "Sordolia", "section" => "Sordolia",],
	"solidam" => ["title" => "Solidam", "section" => "Sordolia"],
	
	"lauria" => ["title" => "Lauria", "section" => "Lauria"],
	"mikalas" => [ "title" => "Mikalas", "section" => "Lauria" ],
	"parna" => [ "title" => "Parna", "section" => "Lauria", "status" => "🛠️" ],
	"peponia" => [ "title" => "Péponia", "section" => "Lauria" ],
	"pasganon" => ["title" => "Pasganon", "section" => "Lauria"],

	"arcania" => ["title" => "Arcania", "section" => "Organisations"],

	"atrimisme" => ["title" => "Atrimisme", "section" => "Culture", "status" => "🛠️"],
	"pentatheisme" => ["title" => "Pentathéisme", "section" => "Culture"],
	"langues" => ["title" => "Langues", "section" => "Culture"]
];
