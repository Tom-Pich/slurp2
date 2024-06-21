<?php

namespace App\Generator;

use App\Lib\TableReader;

class NPCGenerator
{

	const names = [
		"male-artaille" => [
			"Lorenz", "Alsendre", "Lenar", "Mati", "Ander", "Anto", "Fransesc", "Giovan", "Marco", "Alès", "Edar", "Rissep", "Luca", "Ricald",
			"Elio", "Enz", "Gabri", "Noco", "Romald", "Aldus", "Aurel", "Ragno", "Eldri", "Sémis", "Almius", "Metho", "Suartone", "Vine", "Balderico",
			"Lucius", "Covio", "Matio", "Umbreti", "Garvi",
		],
		"female-artaille" => [
			"Branca", "Julia", "Lucila", "Aurora", "Clara", "Emma", "Ginevra", "Jorgia", "Sofia", "Beata", "Isala", "Anna", "Arina", "Cicelia", "Fransesca",
			"Alessie", "Aliana", "Angila", "Aria", "Camida", "Emina", "Gabraella", "Léona", "Almaria", "Liora", "Elara", "Mina", "Miucce", "Griana"
		],
	];

	const hair = [
		"length" => ["très longs", "longs", "mi-longs", "courts", "très courts", "rasés"],
		"length-weight-female" => [1, 8, 8, 1, 0, 0],
		"length-weight-male" => [0, 1, 2, 4, 4, 1],

		"type" => ["frisés", "bouclés", "ondulés", "raides"],
		"type-weight" => [1, 2, 3, 4],

		"color" => ["noirs", "bruns", "chatains", "chatains clairs", "blonds", "roux"],
		"color-weight-default" => [2, 4, 4, 4, 4, 1],
		"color-weight-artaille" => [8, 8, 2, 1, 1, 1],
	];

	const facialHair = [
		"type" => ["glabre", "moustaches", "bouc", "barbe taillée", "barbe broussailleuse", "grande barbe", "fantaisiste"],
		"weight" => [10, 2, 3, 6, 3, 2, 1],
	];

	const eyes = [
		"color" => ["foncés", "gris", "brun-verts", "bruns", "verts", "bleus-verts", "bleus"],
		"weight-default" => [15, 3, 9, 15, 6, 6, 6],
		"weight-artaille" => [15, 1, 9, 25, 3, 3, 2],
	];

	const corpulence = [
		"value" => ["maigre", "mince", "moyenne", "léger embonpoint", "gros(se)", "obèse", "athlétique", "barraqué", "armoire à glace",],
		"weight-female" => [2, 6, 12, 6, 4, 1, 1, 0, 0],
		"weight-male" => [2, 6, 12, 6, 4, 1, 2, 0, 0],
		"weight-male-warrior" => [0, 2, 6, 3, 1, 0, 6, 3, 2],
	];
	const size = [
		"value" => ["petite taille", "assez petite taille", "moyenne", "assez grande taille", "grand taille", "très grand(e)"],
		"weight-default" => [1, 3, 6, 3, 2, 1],
		"weight-warrior" => [0, 1, 4, 4, 3, 2],
	];
	const beauty = [
		"value" => ["laid", "pas très beau", "moyenne", "apparence agréable", "beau", "très beau"],
		"weight" => [1, 6, 12, 6, 4, 1],
	];
	const intelligence = [
		 "value" => ["pas très fûté(e)", "moyenne", "assez fûté(e)", "intelligence vive"],
		 "weight-default" => [1, 10, 3, 1],
		 "weight-warrior" => [1, 5, 1, 0],
	];
	const social = [
		 "value" => ["brute", "désagréable", "condescendant(e)", "attitude distante", "attitude plutôt agréable", "assez jovial", "sympathique", "chaleureux"],
		 "weight" => [1, 2, 1, 5, 5, 2, 2, 1]
	];
	const special = [
		"pomettes saillantes", "visage anguleux", "boîteux", "borgne", "marque de naissance au visage", "yeux vairrons", "sourcils épais", "voix rauque", "voix mélodieuse", "cicatrice(s)", "tatouages", "dents proéminentes", "tâches de rousseur", "démarche gracieuse"
	];

	public static function generateNPC(array $parameters)
	{
		$gender = $parameters["gender"] ?? "male";
		$region = $parameters["region"] ?? "artaille";
		$profile = $parameters["profile"] ?? "default";

		// validating parameters
		$valid_parameters = in_array($gender, ["male", "female"])
			&& in_array($profile, ["default", "warrior"])
			&& !empty(self::names[$gender . "-" . $region]);
		$parameters["error"] = !$valid_parameters;
		if (!$valid_parameters) return $parameters; // stop generation here

		// selecting weight arrays
		$w_hair_length = self::hair["length-weight-" . $gender];
		$w_hair_type = self::hair["type-weight"];
		$w_hair_color = self::hair["color-weight-" . $region] ?? self::hair["color-weight-default"];
		$w_facial_hair = self::facialHair["weight"];
		$w_eyes_color = self::eyes["weight-" . $region] ?? self::eyes["weight-default"];
		$w_corpulence = self::corpulence["weight-" . $gender];
		if ($gender === "male" && $profile === "warrior") $w_corpulence = self::corpulence["weight-male-warrior"];
		$w_size = self::size["weight-" . $profile] ?? self::size["weight-default"];
		$w_beauty = self::beauty["weight"];
		$w_intelligence = self::intelligence["weight-" . $profile];
		$w_social = self::social["weight"];

		// generating name
		$parameters["name"] = TableReader::pickRandomArrayElement(self::names[$gender . "-" . $region]);

		// generating hair description
		$hair_length = TableReader::getWeightedResult(self::hair["length"], $w_hair_length);
		$parameters["hair"] = "cheveux " . $hair_length;
		if (!in_array($hair_length, ["courts", "très courts", "rasés"])) {
			$hair_type = TableReader::getWeightedResult(self::hair["type"], $w_hair_type);
			$parameters["hair"] .= (" " . $hair_type);
		}
		if ($hair_length !== "rasés") {
			$hair_color = TableReader::getWeightedResult(self::hair["color"], $w_hair_color);
			$parameters["hair"] .= (" " . $hair_color);
		}

		// generating facial hair
		if ($gender === "male") {
			$parameters["facialHair"] = TableReader::getWeightedResult(self::facialHair["type"], $w_facial_hair);
		}

		// generating regular entries
		$parameters["eyes"] = TableReader::getWeightedResult(self::eyes["color"], $w_eyes_color);
		$parameters["corpulence"] = TableReader::getWeightedResult(self::corpulence["value"], $w_corpulence);
		$parameters["size"] = TableReader::getWeightedResult(self::size["value"], $w_size);
		$parameters["beauty"] = TableReader::getWeightedResult(self::beauty["value"], $w_beauty);
		$parameters["intelligence"] = TableReader::getWeightedResult(self::intelligence["value"], $w_intelligence);
		$parameters["social"] = TableReader::getWeightedResult(self::social["value"], $w_social);

		// special traits
		if(random_int(1, 100) <= 10){
			$special_traits = self::special;
			$special_trait1 = TableReader::pickRandomArrayElement($special_traits);
			$special_traits = array_values(array_filter($special_traits, fn ($trait) => $trait !== $special_trait1));
			$special_trait2 = TableReader::pickRandomArrayElement($special_traits);
			$special_traits = array_values(array_filter($special_traits, fn ($trait) => $trait !== $special_trait2));
			$special_trait3 = TableReader::pickRandomArrayElement($special_traits);
			$parameters["specialTraits"] = join(", ", [$special_trait1, $special_trait2, $special_trait3]);
		}

		return $parameters;
	}
}
