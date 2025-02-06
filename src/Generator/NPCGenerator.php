<?php

namespace App\Generator;

use App\Lib\TableReader;

class NPCGenerator
{

	const names = [
		"male-artaille" => [
			"Aldus",
			"Alès",
			"Almius",
			"Alsendre",
			"Ander",
			"Anto",
			"Aurel",
			"Balderico",
			"Covio",
			"Edar",
			"Eldri",
			"Elio",
			"Enz",
			"Fransesc",
			"Gabri",
			"Garvi",
			"Giovan",
			"Ivo",
			"Lenar",
			"Lorenz",
			"Luca",
			"Lucius",
			"Marco",
			"Mati",
			"Matio",
			"Metho",
			"Noco",
			"Ragno",
			"Ricald",
			"Rissep",
			"Romald",
			"Sémis",
			"Suartone",
			"Umbreti",
			"Vine",
		],
		"female-artaille" => [
			"Branca",
			"Julia",
			"Lucila",
			"Aurora",
			"Clara",
			"Emma",
			"Ginevra",
			"Jorgia",
			"Sofia",
			"Beata",
			"Isala",
			"Anna",
			"Arina",
			"Cicelia",
			"Fransesca",
			"Alessie",
			"Aliana",
			"Angila",
			"Aria",
			"Camida",
			"Emina",
			"Gabraella",
			"Léona",
			"Almaria",
			"Liora",
			"Elara",
			"Mina",
			"Miucce",
			"Griana"
		],
		"male-french" => [
			"Alain",
			"Alexandre",
			"Anthony",
			"Antoine",
			"Arnaud",
			"Bernard",
			"Bruno",
			"Cédric",
			"Christian",
			"Christophe",
			"Claude",
			"Daniel",
			"David",
			"Didier",
			"Dominique",
			"Éric",
			"Fabrice",
			"Franck",
			"François",
			"Frédéric",
			"Gérard",
			"Gilles",
			"Guillaume",
			"Hervé",
			"Jacques",
			"Jean",
			"Jean-Pierre",
			"Jérôme",
			"Julien",
			"Kevin",
			"Laurent",
			"Marc",
			"Mathieu",
			"Maxime",
			"Michel",
			"Nicolas",
			"Olivier",
			"Pascal",
			"Patrick",
			"Patrice",
			"Paul",
			"Philippe",
			"Pierre",
			"Romain",
			"Serge",
			"Stéphane",
			"Sylvain",
			"Thierry",
			"Thomas",
			"Vincent"
		],
		"female-french" => [
			"Anne",
			"Annie",
			"Audrey",
			"Aurélie",
			"Béatrice",
			"Brigitte",
			"Camille",
			"Carole",
			"Caroline",
			"Catherine",
			"Cécile",
			"Céline",
			"Chantal",
			"Christelle",
			"Christine",
			"Claire",
			"Corinne",
			"Delphine",
			"Dominique",
			"Élisabeth",
			"Élodie",
			"Émilie",
			"Évelyne",
			"Fabienne",
			"Florence",
			"Françoise",
			"Hélène",
			"Isabelle",
			"Julie",
			"Karine",
			"Laetitia",
			"Laura",
			"Laurence",
			"Marie",
			"Marion",
			"Martine",
			"Mélanie",
			"Monique",
			"Nadine",
			"Nathalie",
			"Nicole",
			"Patricia",
			"Sandra",
			"Sandrine",
			"Sophie",
			"Stéphanie",
			"Sylvie",
			"Valérie",
			"Véronique",
			"Virginie"
		],
		"surname-french" => [
			"Adam",
			"André",
			"Antoine",
			"Arnaud",
			"Aubert",
			"Aubry",
			"Bailly",
			"Barbier",
			"Baron",
			"Barre",
			"Barthelemy",
			"Benard",
			"Benoît",
			"Berger",
			"Bernard",
			"Bertin",
			"Bertrand",
			"Besson",
			"Blanc",
			"Blanchard",
			"Bonnet",
			"Boucher",
			"Bouchet",
			"Boulanger",
			"Bourgeois",
			"Bouvier",
			"Boyer",
			"Breton",
			"Brun",
			"Brunet",
			"Carlier",
			"Caron",
			"Carpentier",
			"Carre",
			"Charles",
			"Charpentier",
			"Chauvin",
			"Chevalier",
			"Chevallier",
			"Clement",
			"Colin",
			"Collet",
			"Collin",
			"Cordier",
			"Cousin",
			"Da Silva",
			"Daniel",
			"David",
			"Delaunay",
			"Denis",
			"Deschamps",
			"Dubois",
			"Dufour",
			"Dumas",
			"Dumont",
			"Dupont",
			"Dupuis",
			"Dupuy",
			"Durand",
			"Duval",
			"Étienne",
			"Fabre",
			"Faure",
			"Fernandez",
			"Fleury",
			"Fontaine",
			"Fournier",
			"Francois",
			"Gaillard",
			"Garcia",
			"Garnier",
			"Gauthier",
			"Gautier",
			"Gay",
			"Gerard",
			"Germain",
			"Gilbert",
			"Gillet",
			"Girard",
			"Giraud",
			"Grondin",
			"Guerin",
			"Guichard",
			"Guillaume",
			"Guillot",
			"Guyot",
			"Hamon",
			"Henry",
			"Herve",
			"Hoarau",
			"Hubert",
			"Huet",
			"Humbert",
			"Jacob",
			"Jacquet",
			"Jean",
			"Joly",
			"Julien",
			"Klein",
			"Lacroix",
			"Lambert",
			"Lamy",
			"Langlois",
			"Laporte",
			"Laurent",
			"Le Gall",
			"Le Goff",
			"Le Roux",
			"Leblanc",
			"Lebrun",
			"Leclerc",
			"Leclercq",
			"Lecomte",
			"Lefebvre",
			"Lefevre",
			"Leger",
			"Legrand",
			"Lejeune",
			"Lemaire",
			"Lemaitre",
			"Lemoine",
			"Leroux",
			"Leroy",
			"Lévêque",
			"Lopez",
			"Louis",
			"Lucas",
			"Maillard",
			"Mallet",
			"Marchal",
			"Marchand",
			"Marechal",
			"Marie",
			"Martin",
			"Martinez",
			"Marty",
			"Masson",
			"Mathieu",
			"Ménard",
			"Mercier",
			"Meunier",
			"Meyer",
			"Michaud",
			"Michel",
			"Millet",
			"Monnier",
			"Moreau",
			"Morel",
			"Morin",
			"Moulin",
			"Muller",
			"Nicolas",
			"Noël",
			"Olivier",
			"Paris",
			"Pasquier",
			"Payet",
			"Pelletier",
			"Perez",
			"Perret",
			"Perrier",
			"Perrin",
			"Perrot",
			"Petit",
			"Philippe",
			"Picard",
			"Pichon",
			"Pierre",
			"Poirier",
			"Poulain",
			"Prevost",
			"Remy",
			"Renard",
			"Renaud",
			"Renault",
			"Rey",
			"Reynaud",
			"Richard",
			"Riviere",
			"Robert",
			"Robin",
			"Roche",
			"Rodriguez",
			"Roger",
			"Rolland",
			"Rousseau",
			"Roussel",
			"Roux",
			"Roy",
			"Royer",
			"Sanchez",
			"Schmitt",
			"Schneider",
			"Simon",
			"Tessier",
			"Thomas",
			"Vasseur",
			"Vidal",
			"Vincent",
			"Weber"
		],
		"male-taol-kaer" => [
			"Aessan",
			"Alban",
			"Algwich",
			"Arenthel",
			"Baorìg",
			"Braeden",
			"Branfubh",
			"Braonan",
			"Boadach",
			"Caemgen",
			"Cahir",
			"Calvhag",
			"Dalaigh",
			"Deorn",
			"Doern",
			"Ean",
			"Erald",
			"Erwan",
			"Fanch",
			"Goater",
			"Harald",
			"Herven",
			"Irvan",
			"Irwin",
			"Jaeron",
			"Jobenn",
			"Jos",
			"Keogh",
			"Liam",
			"Loeg",
			"Manec",
			"Maorn",
			"Meog",
			"Mòr",
			"Naelen",
			"Nar",
			"Octar",
			"Osvan",
			"Tadh",
			"Teren",
			"Vaugh",
			"Venec",
			"Wylard"
		],
		"female-taol-kaer" => [
			"Aïnlis",
			"Arven",
			"Aslin",
			"Aylin",
			"Ailis",
			"Alanagh",
			"Aoibheann",
			"Avelin",
			"Brigh",
			"Caytlin",
			"Ceyla",
			"Cyàn",
			"Deilen",
			"Dyànair",
			"Édel",
			"Édena",
			"Ghilair",
			"Glen",
			"Jili",
			"Maella",
			"Maiwenn",
			"Maoda",
			"Neala",
			"Neamis",
			"Rodina",
			"Thailis",
			"Wailen",
			"Yldiane",
			"Yvine",
			"Zaig"
		],
		"male-lauria" => [
			"Abercius",
			"Aegisthos",
			"Aegon",
			"Aétion",
			"Aetius",
			"Agabos",
			"Agapenor",
			"Agénor",
			"Alector",
			"Alkeon",
			"Aristonis",
			"Athenios",
			"Calystron",
			"Cleonides",
			"Damianos",
			"Demetrios",
			"Dorianos",
			"Éaque",
			"Erythion",
			"Erythios",
			"Eryxion",
			"Éthlios",
			"Eudor",
			"Galenios",
			"Galenor",
			"Heliodor",
			"Herakion",
			"Iasonis",
			"Jurgos",
			"Kallion",
			"Kallistos",
			"Kyrios",
			"Leontios",
			"Lysandor",
			"Lysimachos",
			"Melanthor",
			"Myronides",
			"Myronis",
			"Nikandros",
			"Phaedron",
			"Phaedros",
			"Philemonis",
			"Phrixos",
			"Pyrrhos",
			"Pythion",
			"Selenios",
			"Thalassios",
			"Thalios",
			"Thalios",
			"Theonides",
			"Theronides",
			"Thesandor",
			"Thesandros",
			"Timaeos",
			"Xanthios",
			"Xenandros",
			"Yanis",
			"Zenos",
			"Zephyron",
			"Zephyros"
		],
		"female-lauria" => [
			"Acidine",
			"Adamantia",
			"Adrastée",
			"Aegina",
			"Aegistha",
			"Agathonice",
			"Agnodice",
			"Agrippia",
			"Alectra",
			"Alkeia",
			"Ananie",
			"Aristonis",
			"Athanasia",
			"Athenia",
			"Calysta",
			"Cleonida",
			"Damiana",
			"Demetra",
			"Doriana",
			"Églée",
			"Erythia",
			"Erythina",
			"Eryxia",
			"Eudora",
			"Galena",
			"Galenia",
			"Heliodora",
			"Herakia",
			"Iasona",
			"Kallia",
			"Kallista",
			"Kyria",
			"Leontia",
			"Lysandra",
			"Lysimacha",
			"Melantha",
			"Myrina",
			"Myrinia",
			"Nikandra",
			"Phaedra",
			"Phaedra",
			"Philema",
			"Phrixa",
			"Pyrrha",
			"Pythia",
			"Selenia",
			"Thalassa",
			"Thalia",
			"Thalia",
			"Theonida",
			"Theronida",
			"Thesandra",
			"Timaea",
			"Xanthia",
			"Xenandra",
			"Zena",
			"Zephyra"
		],
	];

	// weight array name must be w-gender-region-profile
	// one or two parameters can be ommitted (e.g. w-region-profile or w-region) but always in the same order
	// if no weight array matches the parameters, it will select w-default
	// see see wightArraySelector for priorities

	const hairLength = [
		"value" => ["très longs", "longs", "mi-longs", "courts", "très courts", "rasés"],
		"w-default" => [0, 1, 2, 4, 4, 1],
		"w-female" => [1, 8, 8, 1, 0, 0],
	];

	const hairType = [
		"value" => ["frisés", "bouclés", "ondulés", "raides"],
		"w-default" => [1, 2, 3, 4],
		"w-taol-kaer" => [0, 1, 2, 4],
	];

	const hairColor = [
		"value" => ["noirs", "bruns", "chatains", "chatains clairs", "blonds", "roux"],
		"w-default" => [2, 4, 4, 4, 4, 1],
		"w-artaille" => [8, 8, 2, 1, 1, 1],
		"w-lauria" => [8, 3, 1, 1, 0, 0],
		"w-french" => [4, 8, 8, 6, 2, 1],
		"w-taol-kaer" => [1, 1, 2, 4, 4, 2],
	];

	const facialHair = [
		"value" => ["glabre", "moustaches", "bouc", "barbe taillée", "barbe broussailleuse", "grande barbe", "fantaisiste"],
		"w-default" => [10, 2, 3, 6, 3, 2, 1],
	];

	const eyes = [
		"value" => ["foncés", "gris", "brun-vert", "bruns", "verts", "bleu-vert", "bleus"],
		"w-default" => [15, 3, 9, 15, 6, 6, 6],
		"w-artaille" => [15, 1, 9, 25, 3, 3, 2],
		"w-taol-kaer" => [1, 1, 2, 2, 3, 3, 3],
	];

	const corpulence = [
		"value" => ["maigre", "mince", "moyenne", "léger embonpoint", "gros(se)", "obèse", "athlétique", "barraqué", "armoire à glace",],
		"w-default" => [2, 6, 12, 6, 4, 1, 2, 0, 0],
		"w-female" => [2, 6, 12, 6, 4, 1, 1, 0, 0],
		"w-male-warrior" => [0, 2, 6, 3, 1, 0, 6, 3, 2],
	];

	const size = [
		"value" => ["petite taille", "assez petite taille", "moyenne", "assez grande taille", "grand taille", "très grand(e)"],
		"w-default" => [1, 3, 6, 3, 2, 1],
		"w-warrior" => [0, 1, 4, 4, 3, 2],
	];

	const beauty = [
		"value" => ["laid", "pas très beau", "moyenne", "apparence agréable", "beau", "très beau"],
		"w-default" => [1, 6, 12, 6, 4, 1],
	];

	const intelligence = [
		"value" => ["pas fûté", "intelligence moyenne", "assez intelligent", "intelligence vive"],
		"w-default" => [1, 10, 3, 1],
		"w-warrior" => [1, 5, 1, 0],
	];

	const social = [
		"value" => ["brute", "désagréable", "condescendant(e)", "attitude distante", "attitude plutôt agréable", "assez jovial", "sympathique", "chaleureux"],
		"w-default" => [1, 2, 1, 5, 5, 2, 2, 1],
		"w-warrior" => [2, 2, 2, 2, 1, 0, 0, 0],
	];

	const specialTraits = [
		"value" => ["pommettes saillantes", "visage anguleux", "boîteux", "borgne", "marque de naissance au visage", "yeux vairrons", "sourcils épais", "voix rauque", "voix agréable", "cicatrice(s)", "tatouages", "dents proéminentes", "tâches de rousseur", "démarche gracieuse", "mèches rebelles",],
		"w-default" => [2, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
		"w-warrior" => [2, 2, 1, 1, 1, 1, 1, 2, 1, 3, 1, 1, 1, 0, 1],
	];

	public static function weightArraySelector(array $trait, array $parameters): array
	{
		$gender = $parameters["gender"];
		$region = $parameters["region"];
		$profile = $parameters["profile"];

		$weightNames = [
			"w-" . $gender . "-" . $region . "-" . $profile,
			"w-" . $gender . "-" . $region,
			"w-" . $gender . "-" . $profile,
			"w-" . $region . "-" . $profile,
			"w-" . $profile,
			"w-" . $region,
			"w-" . $gender,
		];

		foreach ($weightNames as $weightName) if (isset($trait[$weightName])) return $trait[$weightName];
		return $trait["w-default"];
	}

	public static function generateNPC(array $parameters)
	{
		$gender = $parameters["gender"] ?? "male";
		$region = $parameters["region"] ?? "artaille";
		$profile = $parameters["profile"] ?? "standard";
		$name_only = isset($parameters["name-only"]);

		// selecting weight arrays
		if (!$name_only) {
			$parameters = ["gender" => $gender, "region" => $region, "profile" => $profile];
			$w_hair_length = self::weightArraySelector(self::hairLength, $parameters);
			$w_hair_type = self::weightArraySelector(self::hairType, $parameters);
			$w_hair_color = self::weightArraySelector(self::hairColor, $parameters);
			$w_facial_hair = self::weightArraySelector(self::facialHair, $parameters);
			$w_eyes = self::weightArraySelector(self::eyes, $parameters);
			$w_corpulence = self::weightArraySelector(self::corpulence, $parameters);
			$w_size = self::weightArraySelector(self::size, $parameters);
			$w_beauty = self::weightArraySelector(self::beauty, $parameters);
			$w_intelligence = self::weightArraySelector(self::intelligence, $parameters);
			$w_social = self::weightArraySelector(self::social, $parameters);
			$w_special_traits = self::weightArraySelector(self::specialTraits, $parameters);
		}

		// generating name
		$parameters["name"] = "Table de noms manquante";
		if (isset(self::names[$gender . "-" . $region])) {
			$parameters["name"] = TableReader::pickRandomArrayElements(self::names[$gender . "-" . $region])[0];
		}
		if (isset(self::names["surname-" . $region])) {
			$surname = TableReader::pickRandomArrayElements(self::names["surname-" . $region])[0];
			$parameters["name"] .= (" " . $surname);
		}

		if ($name_only) return $parameters;

		// generating hair description
		$hair_length = TableReader::getWeightedResult(self::hairLength["value"], $w_hair_length);
		$parameters["hair"] = "cheveux " . $hair_length;
		if (!in_array($hair_length, ["courts", "très courts", "rasés"])) {
			$hair_type = TableReader::getWeightedResult(self::hairType["value"], $w_hair_type);
			$parameters["hair"] .= (" " . $hair_type);
		}
		if ($hair_length !== "rasés") {
			$hair_color = TableReader::getWeightedResult(self::hairColor["value"], $w_hair_color);
			$parameters["hair"] .= (" " . $hair_color);
		}

		// generating regular entries
		if ($gender === "male") $parameters["facialHair"] = TableReader::getWeightedResult(self::facialHair["value"], $w_facial_hair);
		$parameters["eyes"] = TableReader::getWeightedResult(self::eyes["value"], $w_eyes);
		$parameters["corpulence"] = TableReader::getWeightedResult(self::corpulence["value"], $w_corpulence);
		$parameters["size"] = TableReader::getWeightedResult(self::size["value"], $w_size);
		$parameters["beauty"] = TableReader::getWeightedResult(self::beauty["value"], $w_beauty);
		$parameters["intelligence"] = TableReader::getWeightedResult(self::intelligence["value"], $w_intelligence);
		$parameters["social"] = TableReader::getWeightedResult(self::social["value"], $w_social);

		// special traits
		$special_trait_random = random_int(1, 100);
		if ($special_trait_random <= 30) {
			$parameters["specialTraits"] = [];
			//$trait_number = ceil($special_trait_random/10);
			$trait_number = 3;
			for ($i = 0; $i < $trait_number; $i++) {
				$selected_trait = TableReader::getWeightedResult(self::specialTraits["value"], $w_special_traits);
				while (in_array($selected_trait, $parameters["specialTraits"])) {
					$selected_trait = TableReader::getWeightedResult(self::specialTraits["value"], $w_special_traits);
				}
				$parameters["specialTraits"][] = $selected_trait;
			}
			$parameters["specialTraits"] = join(", ", $parameters["specialTraits"]);
		}

		return $parameters;
	}
};
