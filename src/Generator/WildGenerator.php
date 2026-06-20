<?php

namespace App\Generator;

use App\Lib\AiService;
use App\Lib\TableReader;

class WildGenerator
{
	static function generateResult(array $parameters)
	{
		//return json_encode($parameters);
		$category = $parameters["category"];
		$use_ai = isset($parameters["use-ai"]);
		$file = null;
		$subcategory = null;

		// cherche my-file[my-subcategory]
		$pattern = '/^([^\[]+)(?:\[([^\]]+)\])?$/';

		if (preg_match($pattern, $category, $matches)) {
			$file = $matches[1]; // $matches[1] contient le nom du fichier
			$subcategory = isset($matches[2]) ? $matches[2] : null;  // $matches[2], si existe, contient la sous-catégorie
		}

		// chargement du fichier et de l’éventuel sous-tableau
		$file_path = __DIR__ . "/tables/$file.php";
		if (!is_file($file_path)) return "<i>Catégorie non valide</i>";
		$table = include $file_path;
		if ($subcategory) {
			if (!isset($table[$subcategory])) return "<i>Sous-catégorie non valide</i>";
			$table = $table[$subcategory];
		}

		// génération du résultat
		$result = TableReader::pickResult($table);

		// utiliser l’IA pour développer si statut MJ et demande excplicite
		if ($_SESSION["Statut"] >= 2 && $use_ai) {
			$ai = new AiService;

			$context = [
				"fantasy-street" => "dans les rues d’une ville médiévale.",
				"castle" => "dans un château médiéval.",
			];
			$current_context = isset($context[$file]) ? $context[$file] : "aucun";
			
			$prompt = "Contexte : " . $current_context . " → « " . $result . " ». Élabore une petite description sur cette base, n’invente pas de nom.";
			$result = $ai->ask($prompt);
		}
		return $result;
	}
}
