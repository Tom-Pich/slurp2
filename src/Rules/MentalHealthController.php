<?php

namespace App\Rules;

class MentalHealthController {
	
	public const levels = [
		0 => [
			"description" => "Catatonie. Position fœtale et semi-conscience. Le personnage ne résistera pas si quelqu’un veut le déplacer. Il restera fou si ses PdE atteignent définitivement 0. <b>Perte définitive de 2 pts de <i>Sang-froid</i> et de 3 PdE.</b>",
			"sf-modifier" => -INF,
			"vol-modifier" => -INF,
		],
		"2.0" => [
			"description" => "Le personnage est très instable et peut basculer dans une crise de folie aisément. -2 en <i>Volonté</i>, -4 à tous les jets de <i>Sang-froid</i>. <b>Perte définitive d’un pt de <i>Sang-froid</i> et d’un PdE</b>",
			"sf-modifier" => -3,
			"vol-modifier" => -2,
		],
		"5.0" => [
			"description" => "Le comportement du personnage change suffisamment pour être remarqué aisément. -1 en <i>Volonté</i>, -2 aux jets de <i>Sang-froid</i>. Tant qu’il reste en dessous de ce seuil, le personnage souffre d’un désavantage mental à -5 choisi par le MJ. <b>Perte définitive d’un PdE.</b>",
			"sf-modifier" => -1,
			"vol-modifier" => -1,
		],

	];

	static function getEffects(int $pde, int $pdem){
		//$ratio = $pde / $pdem;
		foreach(self::levels as $level => $effects){
			$level = (int) $level;
			if ($pde <= $level){
				return $effects;
			}
		}
		return ["description" => "Bonne santé mentale", "sf-modifier" => 0,];
	}
}