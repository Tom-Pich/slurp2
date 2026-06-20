<?php

namespace App\Generator;

use App\Lib\AiService;
use App\Lib\TableReader;

class NPCGenerator
{
	// weight array name must be w-gender-region-profile
	// one or two parameters can be ommitted (e.g. w-region-profile or w-region) but always in the same order
	// if no weight array matches the parameters, it will select w-default
	// see weightArraySelector for priorities

	const hairLength = [
		"value" => ["très longs", "longs", "mi-longs", "courts", "très courts", "rasés"],
		"w-default" => [0, 1, 2, 4, 4, 1],
		"w-female" => [1, 8, 8, 1, 0, 0],
		"w-male-sordolia" => [0, 1, 3, 1, 1, 1],
	];

	const hairType = [
		"value" => ["frisés", "bouclés", "ondulés", "raides"],
		"w-default" => [1, 2, 3, 4],
		"w-taol-kaer" => [0, 1, 2, 4],
		"w-sordolia" => [0, 1, 2, 4],
	];

	const hairColor = [
		"value" => ["noirs", "bruns", "chatains", "chatains clairs", "blonds", "roux"],
		"w-default" => [2, 4, 4, 4, 4, 1],
		"w-artaille" => [8, 8, 2, 1, 1, 1],
		"w-sordolia" => [1, 1, 1, 4, 8, 1],
		"w-lauria" => [8, 3, 1, 1, 0, 0],
		"w-french" => [4, 8, 8, 6, 2, 1],
		"w-taol-kaer" => [1, 1, 2, 4, 4, 2],
	];

	const facialHair = [
		"value" => ["glabre", "moustaches", "bouc", "barbe taillée", "barbe broussailleuse", "grande barbe", "fantaisiste"],
		"w-default" => [10, 2, 3, 6, 3, 2, 1],
		"w-sordolia" => [1, 1, 0, 2, 2, 2, 0],
	];

	const eyes = [
		"value" => ["foncés", "gris", "brun-vert", "bruns", "verts", "bleu-vert", "bleus"],
		"w-default" => [15, 3, 9, 15, 6, 6, 6],
		"w-artaille" => [15, 1, 9, 25, 3, 3, 2],
		"w-sordolia" => [1, 2, 3, 1, 2, 4, 4],
		"w-taol-kaer" => [1, 1, 2, 2, 3, 3, 3],
	];

	const build = [
		"value" => ["maigre", "mince", "corpulence moyenne", "léger embonpoint", "gros(se)", "obèse", "athlétique", "barraqué(e)", "armoire à glace",],
		"w-default" => [2, 6, 12, 6, 4, 1, 2, 0, 0],
		"w-female" => [2, 6, 12, 6, 4, 1, 1, 0, 0],
		"w-male-warrior" => [0, 2, 6, 3, 1, 0, 6, 3, 2],
	];

	const size = [
		"value" => ["petite taille", "assez petite taille", "taille moyenne", "assez grand(e)", "grand(e)", "très grand(e)"],
		"w-default" => [1, 3, 6, 3, 2, 1],
		"w-warrior" => [0, 1, 4, 4, 3, 2],
		"w-sordolia" => [0, 1, 4, 4, 3, 2],
		"w-sordolia-warrior" => [0, 0, 2, 4, 4, 3],
	];

	const beauty = [
		"value" => ["laid", "pas très beau", "apparence moyenne", "apparence agréable", "beau", "très beau"],
		"w-default" => [1, 6, 12, 6, 4, 1],
	];

	const intelligence = [
		"value" => ["pas fûté(e)", "intelligence moyenne", "assez intelligent", "intelligence vive"],
		"w-default" => [1, 10, 3, 1],
		"w-warrior" => [1, 5, 1, 0],
	];

	const social = [
		"value" => ["attitude brutale", "désagréable", "condescendant(e)", "attitude distante", "attitude plutôt agréable", "assez jovial", "sympathique", "chaleureux"],
		"w-default" => [1, 2, 1, 5, 5, 2, 2, 1],
		"w-warrior" => [2, 2, 2, 2, 1, 0, 0, 0],
	];

	const specialTraits = [
		"value" => [
			"pommettes saillantes",
			"visage anguleux",
			"boîteux",
			"borgne",
			"marque de naissance au visage",
			"yeux vairrons",
			"sourcils épais",
			"voix rauque",
			"voix agréable",
			"cicatrice(s)",
			"tatouages",
			"dents proéminentes",
			"tâches de rousseur",
			"démarche gracieuse",
			"mèches rebelles",
		],
		"w-default" => [
			2,
			2,
			1,
			1,
			1,
			1,
			1,
			1,
			1,
			1,
			1,
			1,
			1,
			1,
			1
		],
		"w-warrior" => [
			2,
			2,
			1,
			1,
			1,
			1,
			1,
			2,
			1,
			3,
			1,
			1,
			1,
			0,
			1
		],
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
		$use_ai = isset($parameters["use-ai"]);
		$parameters = ["gender" => $gender, "region" => $region, "profile" => $profile];

		// generating name
		$parameters["name"] = "Table de noms manquante";
		$name_file_path = __DIR__ . "/names/$region-$gender.php";
		$surname_file_path = __DIR__ . "/names/$region-surname.php";
		if (is_file($name_file_path)) $parameters["name"] = TableReader::pickResult(include $name_file_path);
		if ($region === "american") {
			$second_name = TableReader::pickResult(["A", "B", "C", "D", "E", "F", "G", "H", "J", "K", "L", "M", "P", "R", "S", "T", "V", "W"]);
			$parameters["name"] .= (" $second_name.");
		}
		if (is_file($surname_file_path)) $parameters["name"] .= (" " . TableReader::pickResult(include $surname_file_path) );
		if ($name_only) return $parameters["name"];

		// selecting weight arrays
		$w_hair_length = self::weightArraySelector(self::hairLength, $parameters);
		$w_hair_type = self::weightArraySelector(self::hairType, $parameters);
		$w_hair_color = self::weightArraySelector(self::hairColor, $parameters);
		$w_facial_hair = self::weightArraySelector(self::facialHair, $parameters);
		$w_eyes = self::weightArraySelector(self::eyes, $parameters);
		$w_build = self::weightArraySelector(self::build, $parameters);
		$w_size = self::weightArraySelector(self::size, $parameters);
		$w_beauty = self::weightArraySelector(self::beauty, $parameters);
		$w_intelligence = self::weightArraySelector(self::intelligence, $parameters);
		$w_social = self::weightArraySelector(self::social, $parameters);
		$w_special_traits = self::weightArraySelector(self::specialTraits, $parameters);

		// generating hair description
		$hair_length = TableReader::pickResult(self::hairLength["value"], $w_hair_length);
		$parameters["hair"] = "cheveux " . $hair_length;
		if (!in_array($hair_length, ["courts", "très courts", "rasés"])) {
			$hair_type = TableReader::pickResult(self::hairType["value"], $w_hair_type);
			$parameters["hair"] .= (" " . $hair_type);
		}
		if ($hair_length !== "rasés") {
			$hair_color = TableReader::pickResult(self::hairColor["value"], $w_hair_color);
			$parameters["hair"] .= (" " . $hair_color);
		}

		// generating regular entries
		$parameters["facialHair"] = false;
		if ($gender === "male") $parameters["facialHair"] = TableReader::pickResult(self::facialHair["value"], $w_facial_hair);
		$parameters["eyes"] = TableReader::pickResult(self::eyes["value"], $w_eyes);
		$parameters["corpulence"] = TableReader::pickResult(self::build["value"], $w_build);
		$parameters["size"] = TableReader::pickResult(self::size["value"], $w_size);
		$parameters["beauty"] = TableReader::pickResult(self::beauty["value"], $w_beauty);
		$parameters["intelligence"] = TableReader::pickResult(self::intelligence["value"], $w_intelligence);
		$parameters["social"] = TableReader::pickResult(self::social["value"], $w_social);

		// special traits
		$special_trait_random = random_int(1, 100);
		if ($special_trait_random <= 30) {
			$parameters["specialTraits"] = [];
			$trait_number = 3;
			for ($i = 0; $i < $trait_number; $i++) {
				$selected_trait = TableReader::pickResult(self::specialTraits["value"], $w_special_traits);
				while (in_array($selected_trait, $parameters["specialTraits"])) {
					$selected_trait = TableReader::pickResult(self::specialTraits["value"], $w_special_traits);
				}
				$parameters["specialTraits"][] = $selected_trait;
			}
			$parameters["specialTraits"] = join(", ", $parameters["specialTraits"]);
		}

		// generating description text
		$description = "<b>{$parameters["name"]}</b> – ";
		$description .= $parameters["hair"] . ", ";
		$description .= $parameters["facialHair"] ? $parameters["facialHair"].", " : "";
		$description .= "yeux " . $parameters["eyes"] . ", ";
		$description .= $parameters["corpulence"] . ", ";
		$description .= $parameters["size"] . ", ";
		$description .= $parameters["beauty"]. ", ";
		$description .= $parameters["intelligence"]. ", ";
		$description .= $parameters["social"]. ".<br>";
		if (isset($parameters["specialTraits"])){
			$description .= "Choisir une particularité parmi <i>{$parameters["specialTraits"]}</i>";
		}

		$parameters["description"] = $description;
		//var_dump($description);

		// use AI for MJ, if required and appropriate
		if ($_SESSION["Statut"] >= 2 && !$name_only && $use_ai){
			$ai = new AiService;
			$prompt = "Voici quelques éléments décrivant une personne. Genre : {$parameters["gender"]}. Description : {$parameters["description"]}. Appuie-toi sur ces éléments pour élaborer un court paragraphe descriptif en conservant le nom (en gras). Si un paramètre est « moyen », ne le mentionne pas, élimine-le. Ne parle ni de ses vêtements, ni de son métier. Si tu dois choisir une particularité (indiqué dans la description), choisis celle qui correspond le mieux au personnage dans son ensemble.";
			$description = $ai->ask($prompt);
		}

		return $description;
	}
};