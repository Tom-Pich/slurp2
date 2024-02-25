<?php

namespace App\Rules;

class FatigueController {
	
	public const levels = [
		"0" => [
			"name" => "Évanoui",
			"description" => "perte de conscience, <i>San</i> à -3",
			"for-multiplier" => 0,
			"dex-modifier" => -INF,
			"int-modifier" => -INF,
			"san-modifier" => -3,
			"per-modifier" => -INF,
			"vol-modifier" => -INF,
			"vit-multiplier" => 0,
		],
		"0.1" => [
			"name" => "Exténué",
			"description" => "aucune action physique, <i>Int</i>, <i>Per</i> et <i>Vol</i> à -5, <i>San</i> à -2",
			"for-multiplier" => 0.5,
			"dex-modifier" => -INF,
			"int-modifier" => -5,
			"san-modifier" => -2,
			"per-modifier" => -5,
			"vol-modifier" => -5,
			"vit-multiplier" => 0,
		],
		"0.2" => [
			"name" => "Épuisé",
			"description" => "<i>For</i> et <i>Vitesse</i> ×0.7, <i>San</i> à -1, autres caractéristiques principales à -3",
			"for-multiplier" => 0.7,
			"dex-modifier" => -3,
			"int-modifier" => -3,
			"san-modifier" => -1,
			"per-modifier" => -3,
			"vol-modifier" => -3,
			"vit-multiplier" => 0.7,
		],
		"0.35" => [
			"name" => "Très fatigué",
			"description" => "<i>For</i> et <i>Vitesse</i> ×0.8, autres caractéristiques principales à -2 sauf la <i>San</i>",
			"for-multiplier" => 0.8,
			"dex-modifier" => -2,
			"int-modifier" => -2,
			"san-modifier" => -0,
			"per-modifier" => -2,
			"vol-modifier" => -2,
			"vit-multiplier" => 0.8,
		],
		"0.5" => [
			"name" => "Fatigué",
			"description" => "<i>For</i> et <i>Vitesse</i> ×0.9, autres caractéristiques principales à -1 sauf la <i>San</i>",
			"for-multiplier" => 0.9,
			"dex-modifier" => -1,
			"int-modifier" => -1,
			"san-modifier" => -0,
			"per-modifier" => -1,
			"vol-modifier" => -1,
			"vit-multiplier" => 0.9,
		],
	];

	static function getEffects(int $pdf, int $pdfm){
		$ratio = $pdf / $pdfm;
		foreach(self::levels as $level => $effects){
			$level = (float) $level;
			if ($ratio <= $level){
				return $effects;
			}
		}
		return [
			"name" => "Fatigue négligeable",
			"description" => "aucun effet",
			"for-multiplier" => 1,
			"dex-modifier" => 0,
			"int-modifier" => 0,
			"san-modifier" => 0,
			"per-modifier" => 0,
			"vol-modifier" => 0,
		];
	}
}