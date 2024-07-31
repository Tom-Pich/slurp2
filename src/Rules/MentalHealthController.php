<?php

namespace App\Rules;

class MentalHealthController {
	
	public const levels = [
		0 => [
			"name" => "catatonie",
			"description" => "Catatonie. Position fœtale et semi-conscience. Le personnage ne résistera pas si quelqu’un veut le déplacer. Il restera fou si ses PdE atteignent définitivement 0. <b>Perte définitive d’un pt de <i>Volonté</i>, d’un pt de <i>Sang-froid</i> et de 2 PdE</b>.",
			"attributes-effects" => "<i>Volonté</i> et <i>Sang-Froid</i> réduits à 0.",
			"sf-modifier" => -INF,
			"vol-modifier" => -INF,
		],
		"0.25" => [
			"name" => "instable",
			"description" => "Le personnage est très instable et peut basculer dans une crise de folie aisément. Tant qu’il reste en dessous de ce seuil, le personnage souffre d’un désavantage mental à -15 choisi par le MJ. <b>Perte définitive d’un pt de <i>Sang-froid</i> et d’un PdE</b>.",
			"attributes-effects" => "-2 en <i>Volonté</i>, -4 à tous les jets de <i>Sang-froid</i>.",
			"sf-modifier" => -3,
			"vol-modifier" => -2,
		],
		"0.5" => [
			"name" => "perturbé",
			"description" => "Le comportement du personnage change suffisamment pour être remarqué aisément. Tant qu’il reste en dessous de ce seuil, le personnage souffre d’un désavantage mental à -5 choisi par le MJ. <b>Perte définitive d’un PdE</b>.",
			"attributes-effects" => "-1 en <i>Volonté</i>, -2 aux jets de <i>Sang-froid</i>.",
			"sf-modifier" => -1,
			"vol-modifier" => -1,
		],

	];

	static function getEffects(int $pde, int $pdem){
		$ratio = $pde / $pdem;
		foreach(self::levels as $level => $effects){
			//$level = (int) $level;
			if ($ratio <= $level){
				return $effects;
			}
		}
		return ["description" => "Bonne santé mentale", "sf-modifier" => 0,];
	}
}