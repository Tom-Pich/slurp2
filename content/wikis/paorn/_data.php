<?php
// key : URL de l’article
// title, description → comme une page classique
// section : groupe dans le sommaire
// parent : position de l’article dans le sommaire et retrait
// status : s’ajoute au titre dans la colonne sommaire

return $articles = [

	"home" => ["title" => "Wiki Paorn", "titleH1" =>"L’encyclopédie de Paorn", "description" => "Diverses notes à propos de Paorn"],
	"burgonnie" => ["title" => "Burgonnie", "titleH1" =>"La Burgonnie",],
	

	"artaille" => ["title" => "Artaille", "titleH1" => "L’Artaille, douce province du sud", "section" => "Artaille",],
	"duche-elmora" => ["title" => "Duché d’Elmora", "section" => "Artaille"],
	"imegie" => ["title" => "Imégie", "titleH1" => "Imégie, capitale de l’Artaille", "section" => "Artaille"],
	"auberge-vieille-tour" => ["title" => "Auberge de la Vieille Tour", "parent" => "imegie"],
	"almisie" => ["title" => "Almisie", "titleH1" => "Almisie, la cité qui travaille", "section" => "Artaille"],
	"stomilie" => ["title" => "Stomilie", "titleH1" => "Stomilie, la ville sainte", "section" => "Artaille"],
	"port-goshal" => ["title" => "Port Goshal", "section" => "Artaille"],

	"sordolia" => ["title" => "Sordolia", "titleH1" => "La Sordolia, province sauvage du Nord", "section" => "Sordolia",],
	"sardam" => ["title" => "Sardam", "titleH1" => "Sardam, capitale de la Sordolia", "section" => "Sordolia",],
	"maison-avrelanche" => ["title" => "La Maison d’Avrelanche", "parent" => "sardam" ],
	"chateau-sardam" => ["title" => "Le château de Sardam", "parent" => "sardam" ],
	"solidam" => ["title" => "Solidam", "section" => "Sordolia"],
	"lardam" => ["title" => "Lardam", "titleH1" => "Lardam, capitale économique de la Sordolia", "section" => "Sordolia", "status" => "🛠️"],
	"fort-leck" => ["title" => "Fort de Leck", "titleH1" => "Le fort de Leck", "section" => "Sordolia"],
	"fallenbeck" => ["title" => "Fallenbeck", "titleH1" => "Fallenbeck, gros village au nord de Sardam", "section" => "Sordolia"],
	"sigherd" => ["title" => "Sigherd (fleuve)", "titleH1" => "Le Sigherd, long fleuve sauvage", "section" => "Sordolia"],
	
	"lauria" => ["title" => "Lauria", "titleH1" => "L’Île de la Lauria", "section" => "Lauria"],
	"mikalas" => [ "title" => "Mikalas", "titleH1" => "Mikalas, grand port de commerce", "section" => "Lauria" ],
	"parna" => [ "title" => "Parna", "titleH1" => "Parna, capitale de la Lauria", "section" => "Lauria", "status" => "🛠️" ],
	"peponia" => [ "title" => "Péponia", "titleH1" => "Péponia, petit village de Lauria", "section" => "Lauria" ],
	"pasganon" => ["title" => "Les Pasganon", "section" => "Lauria"],

	"arcania" => ["title" => "Arcania", "titleH1" => "L’Arcania, police burgonne de la magie", "section" => "Organisations"],

	"atrimisme" => ["title" => "Atrimisme", "section" => "Culture", "status" => "🛠️"],
	"pentatheisme" => ["title" => "Pentathéisme", "section" => "Culture"],
	"langues" => ["title" => "Langues", "titleH1" => "Langues de Paorn", "section" => "Culture"],
	"calendrier-burgon" => ["title" => "Calendrier burgon", "titleH1" => "Âges &amp; calendrier burgon", "section" => "Culture"],
];
