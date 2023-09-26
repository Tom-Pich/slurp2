<?php

namespace App\Rules;

class MentalHealthController {
	
	public const levels = [
		"0" => [
			"description" => "Catatonie. Position fœtale et semi-conscience, ne résistera pas si quelqu’un veut le déplacer. 3 pts de <i>Sang-froid</i> sont perdus définitivement ainsi que 5 PdE. Le personnage restera fou si ses PdE atteignent définitivement 0. Aucun jet de <i>Sang-Froid</i> ne peut être fait car le personnage n’est pas assez conscient pour cela.",
			"sf-modifier" => -INF,
		],
		"0.25" => [
			"description" => "Le personnage est très instable et peut basculer dans une crise de folie aisément. -4 à tous les jets de <i>Sang-froid</i>. Perte définitive d’un pt de <i>Sang-froid</i> et de 2 PdE",
			"sf-modifier" => -4,
		],
		"0.5" => [
			"description" => "Le comportement du personnage change suffisamment pour être remarqué aisément. -2 aux jets de <i>Sang-froid</i>. Perte définitive d’un PdE.", "sf-modifier" => -2,
		],

	];

	static function getEffects(int $pde, int $pdem){
		$ratio = $pde / $pdem;
		foreach(self::levels as $level => $effects){
			$level = (float) $level;
			if ($ratio <= $level){
				return $effects;
			}
		}
		return ["description" => "Bonne santé mentale", "sf-modifier" => 0,];
	}
}