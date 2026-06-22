<?php
// key : URL de l’article
// title, description → comme une page classique
// section : groupe dans le sommaire
// parent : position de l’article dans le sommaire et retrait
// status : s’ajoute au titre dans la colonne sommaire

return $articles = [

	"home" => ["title" => "Wiki Paorn", "description" => "Diverses notes à propos de Paorn"],
	"burgonnie" => ["title" => "Burgonnie",],
	

	"artaille" => ["title" => "Artaille", "section" => "Artaille",],
	"duche-elmora" => ["title" => "Duché d’Elmora", "section" => "Artaille"],
	"imegie" => ["title" => "Imégie", "section" => "Artaille"],
	"auberge-vieille-tour" => ["title" => "Auberge de la Vieille Tour", "parent" => "imegie"],
	"almisie" => ["title" => "Almisie", "section" => "Artaille"],
	"stomilie" => ["title" => "Stomilie", "section" => "Artaille"],
	"port-goshal" => ["title" => "Port Goshal", "section" => "Artaille"],

	"sordolia" => ["title" => "Sordolia", "section" => "Sordolia",],
	"sardam" => ["title" => "Sardam", "section" => "Sordolia",],
	"maison-avrelanche" => ["title" => "La Maison d’Avrelanche", "parent" => "sardam" ],
	"chateau-sardam" => ["title" => "Le château de Sardam", "parent" => "sardam" ],
	"solidam" => ["title" => "Solidam", "section" => "Sordolia"],
	"lardam" => ["title" => "Lardam", "section" => "Sordolia", "status" => "🛠️"],
	"fort-leck" => ["title" => "Fort de Leck", "section" => "Sordolia"],
	"fallenbeck" => ["title" => "Fallenbeck", "section" => "Sordolia"],
	"sigherd" => ["title" => "Sigherd (fleuve)", "section" => "Sordolia"],
	
	"lauria" => ["title" => "Lauria", "section" => "Lauria"],
	"mikalas" => [ "title" => "Mikalas", "section" => "Lauria" ],
	"parna" => [ "title" => "Parna", "section" => "Lauria", "status" => "🛠️" ],
	"peponia" => [ "title" => "Péponia", "section" => "Lauria" ],
	"pasganon" => ["title" => "Pasganon", "section" => "Lauria"],

	"arcania" => ["title" => "Arcania", "section" => "Organisations"],

	"atrimisme" => ["title" => "Atrimisme", "section" => "Culture", "status" => "🛠️"],
	"pentatheisme" => ["title" => "Pentathéisme", "section" => "Culture"],
	"langues" => ["title" => "Langues", "section" => "Culture"],
	"calendrier-burgon" => ["title" => "Calendrier burgon", "section" => "Culture"],
];
