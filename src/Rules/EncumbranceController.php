<?php

namespace App\Rules;

class EncumbranceController {
	
	public const levels = [
		"1" => ["description" => "nul", "dex-modifier" => 0, "vit-multiplier" => 1],
		"2" => ["description" => "léger (-1 en <i>Dex</i>, <i>Vit</i>×0.8)", "dex-modifier" => -1, "vit-multiplier" => 0.8],
		"3" => ["description" => "moyen (-2 en <i>Dex</i>, <i>Vit</i>×0.5)", "dex-modifier" => -2, "vit-multiplier" => 0.5],
		"6" => ["description" => "pesant (-3 en <i>Dex</i>, <i>Vit</i>×0.2)", "dex-modifier" => -3, "vit-multiplier" => 0.2],
		"10" => ["description" => "très pesant (-4 en <i>Dex</i>, <i>Vit</i>×0.1)", "dex-modifier" => -4, "vit-multiplier" => 0.1],
		"12.5" => ["description" => "max – aucun jet, aucun déplacement", "dex-modifier" => -INF, "vit-multiplier" => 0],
	];

	static function getEffects(float $weight, int $for){
		$ratio = $weight / $for;
		foreach(self::levels as $level => $effects){
			$level = (float) $level;
			if ($ratio <= $level){
				return $effects;
			}
		}
		return ["description" => "impossible de porter un tel poids&nbsp;!", "dex-modifier" => -INF, "vit-multiplier" => 0];
	}
}