<?php

namespace App\Generator;

use App\Lib\TableReader;

class WildGenerator
{

	public const herbs = ["Cassidre dorée", "Pourprine à petites feuilles", "Faux-avoine", "Mandragone violette", "Baulemoisse"];
	public const books = ["En cours d’élaboration"];

	static function generateResult(array $parameters)
	{
		$category = $parameters["category"];
		if (!defined("self::$category")) return "Catégorie non valide";
		$result = TableReader::pickRandomArrayElements(constant("self::$category"));
		return $result;
	}
}
