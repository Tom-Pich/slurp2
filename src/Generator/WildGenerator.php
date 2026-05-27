<?php

namespace App\Generator;

use App\Lib\TableReader;

class WildGenerator
{
	static function generateResult(array $parameters)
	{
		$category = $parameters["category"];
		$table_file = __DIR__ . "/tables/$category.php";
		if (!is_file($table_file)) return "<i>Catégorie non valide</i>";
		$table = include $table_file;
		return TableReader::pickResult($table);
	}
}
