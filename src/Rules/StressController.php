<?php

namespace App\Rules;

class StressController {
	
	public const levels = [
		[
			"level" => 0,
			"name" => "Pas de stress",
			"description" => "aucun effet",
			"for-multiplier" => 1,
			"dex-modifier" => 0,
			"int-modifier" => 0,
			"per-modifier" => 0,
			"ref-modifier" => 0,
			"sf-modifier" => 0,
			"pde-loss" => 0,
		],
		[
			"level" => 1,
			"name" => "Moyen",
			"description" => "+1 en <i>Réflexes</i>, -1 en <i>Int</i>, <i>Per</i> et <i>Sang-Froid</i>.",
			"for-multiplier" => 1,
			"dex-modifier" => 0,
			"int-modifier" => -1,
			"per-modifier" => -1,
			"ref-modifier" => 1,
			"sf-modifier" => -1,
			"pde-loss" => 0,
		],
		[
			"level" => 2,
			"name" => "Fort",
			"description" => "+1 en <i>Réflexes</i>, <i>For</i>×1.1, -1 en <i>Dex</i>, -2 en <i>Int</i>, <i>Per</i> et <i>Sang-Froid</i>. Perte de 1 PdE.",
			"for-multiplier" => 1.1,
			"dex-modifier" => -1,
			"int-modifier" => -2,
			"per-modifier" => -2,
			"ref-modifier" => 1,
			"sf-modifier" => -2,
			"pde-loss" => 1,
		],
		[
			"level" => 3,
			"name" => "Extrême",
			"description" => "Panique. <i>For</i>×1.1, -2 en <i>Dex</i>, -5 en <i>Int</i>, <i>Per</i> et <i>Sang-Froid</i>. Perte de 2 PdE.",
			"for-multiplier" => 1.2,
			"dex-modifier" => -2,
			"int-modifier" => -5,
			"per-modifier" => -5,
			"ref-modifier" => 0,
			"sf-modifier" => -5,
			"pde-loss" => 2,
		],
	];

	static function getEffects(int $stress_level){
		$stress_level = min($stress_level, 3);
		return self::levels[$stress_level] ?? self::levels[0] ;
	}
}