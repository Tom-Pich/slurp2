<?php

namespace App\Rules;

use Exception;

class EncumbranceController {
	
	public const levels = [
		"1" => [ "name" => "nul", "description" => "aucun effet", "dex-modifier" => 0, "vit-multiplier" => 1],
		"2" => [ "name" => "léger", "description" => "-1 en <i>Dex</i>, <i>Vit</i>×0.8", "dex-modifier" => -1, "vit-multiplier" => 0.8],
		"3" => ["name" => "moyen", "description" => "-2 en <i>Dex</i>, <i>Vit</i>×0.5", "dex-modifier" => -2, "vit-multiplier" => 0.5],
		"6" => ["name" => "pesant", "description" => "-3 en <i>Dex</i>, <i>Vit</i>×0.2", "dex-modifier" => -3, "vit-multiplier" => 0.2],
		"10" => ["name" => "très pesant", "description" => "-4 en <i>Dex</i>, <i>Vit</i>×0.1", "dex-modifier" => -4, "vit-multiplier" => 0.1],
		"12.5" => [ "name" => "max", "description" => "aucun jet, aucun déplacement", "dex-modifier" => -INF, "vit-multiplier" => 0],
	];

	static function getEffects(float $weight, int $for){
		if ($for === 0){ $ratio = INF; }
		else { $ratio = $weight / $for; }
		foreach(self::levels as $level => $effects){
			$level = (float) $level;
			if ($ratio <= $level){
				return $effects;
			}
		}
		return [ "name" => "trop élevé&nbsp;! Impossible de porter ce poids.", "description" => "impossible de porter un tel poids&nbsp;!", "dex-modifier" => -INF, "vit-multiplier" => 0];
	}
}