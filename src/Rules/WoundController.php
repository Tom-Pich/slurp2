<?php

namespace App\Rules;

class WoundController
{

	public const general_levels = [
		"-3" => [
			"description" => "Mort automatique",
			"for-multiplier" => 0,
			"dex-modifier" => -INF,
			"int-modifier" => -INF,
			"vit-multiplier" => 0,
		],
		"-2" => [
			"description" => "Jet de <i>San</i>-5 pour ne pas mourir au moment où ce seuil est franchi.",
			"for-multiplier" => 0,
			"dex-modifier" => -INF,
			"int-modifier" => -INF,
			"vit-multiplier" => 0,
		],
		"-1.5" => [
			"description" => "Jet de <i>San</i>-2 pour ne pas mourir au moment où ce seuil est franchi.",
			"for-multiplier" => 0,
			"dex-modifier" => -INF,
			"int-modifier" => -INF,
			"vit-multiplier" => 0,
		],
		"-1" => [
			"description" => "Perte de conscience et jet de <i>San</i> pour ne pas mourir au moment où ce seuil est franchi.",
			"for-multiplier" => 0,
			"dex-modifier" => -INF,
			"int-modifier" => -INF,
			"vit-multiplier" => 0,
		],
		"0" => [
			"description" => "Jet de <i>Vol</i>-3 à chaque round pour ne pas perdre conscience. Le personnage ne peut pas se tenir debout. Il peut reprendre conscience ultérieurement, mais ne pourra rien faire et sera semi-conscient jusqu’à ce que ses PdV soient de nouveau positifs.",
			"for-multiplier" => 0.3,
			"dex-modifier" => -7,
			"int-modifier" => -7,
			"vit-multiplier" => 0,
		],
		"0.25" => [
			"description" => "<i>For</i>×0.5, <i>Vitesse</i>×0.2, <i>Dex</i> et <i>Int</i> à -5",
			"for-multiplier" => 0.5,
			"dex-modifier" => -5,
			"int-modifier" => -5,
			"vit-multiplier" => 0.2,
		],
		"0.5" => [
			"description" => "<i>For</i>×0.75, <i>Vitesse</i>×0.5, <i>Dex</i> et <i>Int</i> à -3",
			"for-multiplier" => 0.75,
			"dex-modifier" => -3,
			"int-modifier" => -3,
			"vit-multiplier" => 0.5,
		],
		"0.75" => [
			"description" => "<i>For</i>×0.9, <i>Vitesse</i>×0.8, <i>Dex</i> et <i>Int</i> à -1",
			"for-multiplier" => 0.9,
			"dex-modifier" => -1,
			"int-modifier" => -1,
			"vit-multiplier" => 0.8,
		],
	];

	public const members_levels = [
		"-1" => ["description" => "Membre détruit"],
		"0" => ["description" => "Blessure invalidante"],
		"0.5" => ["description" => "Inutilisable"],
		"0.75" => ["description" => "-3 pour utiliser"],
	];

	public const members_pdv = [
		"bras" => 0.4,
		"main" => 0.25,
		"jambe" => 0.5,
		"pied" => 0.33,
	];

	public const member_abbreviation = [
		"BD" => ["full-name" => "bras droit", "member" => "bras"],
		"BG" => ["full-name" => "bras gauche", "member" => "bras"],
		"MD" => ["full-name" => "main droite", "member" => "main"],
		"MG" => ["full-name" => "main gauche", "member" => "main"],
		"JD" => ["full-name" => "jambe droite", "member" => "jambe"],
		"JG" => ["full-name" => "jambe gauche", "member" => "jambe"],
		"PD" => ["full-name" => "pied droit", "member" => "pied"],
		"PG" => ["full-name" => "pied gauche", "member" => "pied"],
	];

	public const localisation = [
		3 => ["Main arrière", "main"],
		4 => ["Main avant", "main"],
		5 => ["Crâne", "crane"],
		6 => ["Cou", "cou"],
		7 => ["Visage (ou crâne)", "visage"],
		8 => ["Bras (avant)", "bras"],
		9 => ["Torse", "torse"],
		10 => ["Torse", "torse"],
		11 => ["Torse", "torse"],
		12 => ["Torse", "torse"],
		13 => ["Torse", "torse"],
		14 => ["Jambe (avant)", "jambe"],
		15 => ["Cœur (ou torse)", "coeur"],
		16 => ["Bras (arrière)", "bras"],
		17 => ["Jambe (arrière)", "jambe"],
		18 => ["Jambe (arrière)", "jambe"]
	];

	public static function getGeneralEffects(int $pdv, int $pdvm, bool $has_pain_resistance = false)
	{
		$ratio = $pdvm === 0 ? 1 : $pdv / $pdvm;
		if ($has_pain_resistance && $ratio > -1) {
			$ratio += 0.25;
		}
		foreach (self::general_levels as $level => $effects) {
			$level = (float) $level;
			if ($ratio <= $level) {
				return $effects;
			}
		}
		return  [
			"description" => "Pas d’effets",
			"for-multiplier" => 1,
			"dex-modifier" => 0,
			"int-modifier" => 0,
			"vit-multiplier" => 1,
		];
	}

	public static function getMemberEffects(int $dmg, int $pdvm, string $member, bool $has_pain_resistance = false)
	{
		$member_pdv = self::members_pdv[$member] * $pdvm ?? self::members_pdv["bras"] * $pdvm;
		$ratio = $pdvm === 0 ? 1 : ($member_pdv - $dmg) / $member_pdv;
		if ($has_pain_resistance && $ratio > 0) {
			$ratio += 0.25;
		}
		foreach (self::members_levels as $level => $effects) {
			$level = (float) $level;
			if ($ratio <= $level) {
				if ($effects["description"] === "-3 pour utiliser") {
					if (in_array($member, ["jambe", "pied"])) {
						$effects["description"] = "<i>Boiteux</i>";
					} else {
						$effects["description"] .= $member === "bras" ? " ce bras" : " cette main";
					}
				}
				return $effects;
			}
		}
		return ["description" => "Aucun effet"];
	}

	public static function getWoundEffects(int $dex, int $san, int $pdvm, int $pdv, bool $has_pain_resistance, int $raw_dmg, int $rd, string $dmg_type, string $bullet_type, string $localisation, array $rolls): array
	{
		$result = [
			"dex" => $dex,
			"san" => $san,
			"pdvm" => $pdvm,
			"pdv_init" => $pdv,
			"res-douleur" => $has_pain_resistance,
			"dégâts bruts" => $raw_dmg,
			"RD" => $rd,
			"type dégâts" => $dmg_type,
			"type balle" => $bullet_type,
			"localisation" => $localisation,
			"jets" => $rolls,
			"separator" => "––––––––––––––––––",

			"dégâts effectifs" => "",
			"dégâts membre" => "",
			"chute" => false,
			"mort" => false,
			"perte de conscience" => false,
			"sonné" => 0,
			"autres effets" => "",
			"pdv" => $pdv,
		];

		// -1 par 10% d’excès de value sur ref (* mult)
		function modif(float $value, float $ref, float $mult = 1)
		{
			return (int) round(- ($value / $ref - 1) * 10 * $mult);
		}

		// check a roll against carac, taking into account 3-4 and 17-18
		function is_success(int $carac, int $roll)
		{
			if ($roll <= 4) {
				return true;
			} elseif ($roll >= 17) {
				return false;
			} else {
				return $roll <= $carac;
			}
		}

		// select a random element in source array with relative probability weight in $indexes_weight
		function get_random_element(array $source, array $indexes_weight)
		{
			$indexes = [];
			foreach ($indexes_weight as $index => $weight) {
				for ($i = 0; $i < $weight; $i++) {
					$indexes[] = $index;
				}
			}
			$picked_index = $indexes[random_int(0, count($indexes) - 1)];
			return $source[$picked_index] ?? "";
		}

		// localisation : torse,  coeur, crane, visage, cou, jambe, bras, pied, main, oeil, org_gen
		// dmg type : br, tr, pe, mn, b0, b1, b2, b3, exp
		// bullet type : std, bpa, bpc

		// base values
		$dmg_multipliers = ["br" => 1, "tr" => 1.5, "pe" => 2, "mn" => 1, "b0" => 0.5, "b1" => 1, "b2" => 1.5, "b3" => 2, "exp" => 1];
		$limits = ["bras" => self::members_pdv["bras"] * 1.25, "jambe" => self::members_pdv["jambe"] * 1.25, "pied" => self::members_pdv["pied"] * 1.25, "main" => self::members_pdv["main"] * 1.25];
		$rcl = ["br" => 1.5, "tr" => 1, "pe" => 0.75, "mn" => 2.5, "b0" => 0.5, "b1" => 0.5, "b2" => 0.75, "b3" => 1, "exp" => 2];

		// variables shorthand
		$is_bullet = in_array($dmg_type, ["b0", "b1", "b2", "b3"]);
		$is_armor_piercing_bullet = $is_bullet && $bullet_type === "bpa";
		$is_hollow_point_bullet = $is_bullet && $bullet_type === "bpc";
		$is_penetrating = $is_bullet || $dmg_type === "pe";
		$is_member = in_array($localisation, ["bras", "main", "pied", "jambe"]);
		$is_vital = in_array($localisation, ["visage", "coeur", "cou", "crâne", "oeil"]);
		$is_head = in_array($localisation, ["crane", "visage", "oeil"]);
		$is_skull = in_array($localisation, ["crane", "oeil"]);
		$is_sensitive = in_array($localisation, ["visage", "org_gen", "crane", "oeil"]);

		// variables inconsistency correction
		$bullet_type = !$is_bullet ? "std" : $bullet_type;
		$localisation = $localisation === "coeur" && $dmg_type === "tr" ? "torse" : $localisation;
		$localisation = $dmg_type === "exp" ? "torse" : $localisation;
		$localisation = $localisation === "oeil" && !$is_penetrating ? "visage" : $localisation;


		// ––– recoil
		$limited_raw_dmg = $is_penetrating ? min($raw_dmg, ($pdvm + $rd) * ($limits[$localisation] ?? 1)) : $raw_dmg;
		$rcl_dmg = $limited_raw_dmg * $rcl[$dmg_type] * ($is_head ? 3 : 1);
		var_dump("rcl dmg " . $rcl_dmg);
		$rcl_modif = modif($rcl_dmg, 0.8 * $pdvm);
		var_dump("rcl modif " . $rcl_modif);
		$result["chute"] = !is_success($dex + $rcl_modif, $rolls[0]);

		// ––– armor and special bullet types
		$rd = $is_armor_piercing_bullet ? floor($rd / 2) : $rd;
		$rd = $is_hollow_point_bullet ? max($rd * 2, 1) : $rd;

		// ––– effective damages
		$net_dmg = $raw_dmg - $rd;
		$net_dmg = $net_dmg >= 0 ? $net_dmg : 0;
		$net_dmg_limit = !$is_vital && $is_penetrating ? ($limits[$localisation] ?? 1) : INF;
		$net_dmg = min($net_dmg, $pdvm * $net_dmg_limit);
		var_dump("net dmg " . $net_dmg);

		$dmg_multiplier = $is_member ? 1 : $dmg_multipliers[$dmg_type];
		$dmg_multiplier = $is_vital ? max($dmg_multiplier * 1.5, 2) : $dmg_multiplier;
		$dmg_multiplier = $is_skull ? 4 : $dmg_multiplier;
		var_dump("dmg multiplier " . $dmg_multiplier);

		$actual_dmg = $net_dmg * $dmg_multiplier;
		$actual_dmg = ($rd === 0 && $is_penetrating) ? max($actual_dmg, 1) : $actual_dmg;
		$actual_dmg *= $is_armor_piercing_bullet ? 0.5 : 1;
		$actual_dmg *= $is_hollow_point_bullet ? 2 : 1;
		$actual_dmg -= ($localisation === "crane") ? min($net_dmg, $pdvm / 5) * 3 : 0;
		var_dump("actual dmg " . $actual_dmg);
		$result["dégâts effectifs"] = round($actual_dmg);
		$pdv -= !$is_member ? $result["dégâts effectifs"] : 0;
		$result["pdv"] = $pdv;

		// ––– fall due to high damages
		$fall_modifier = modif(2 * $actual_dmg, $pdvm);
		var_dump("dmg fall modif : " . $fall_modifier);
		$result["chute"] = $result["chute"] || $actual_dmg && !is_success($san + $fall_modifier, $rolls[1]);

		// ––– stunning
		$stun_level = 0;
		$stun_base_threshold = 0.25 * $pdvm * ($is_sensitive ? 0 : 1);
		var_dump("stun base threshold : " . $stun_base_threshold);
		if ($actual_dmg >= $stun_base_threshold) {

			$stun_level = $actual_dmg >= 2 * max($stun_base_threshold, 0.1 * $pdvm) ? 2 : 1;
			$stun_level = $actual_dmg >= 4 * max($stun_base_threshold, 0.1 * $pdvm) ? 3 : $stun_level;
			$stun_level += $localisation === "org_gen" ? 1 : 0;
			$stun_level -= is_success($san - 2 * $stun_level, $rolls[2]) ? 1 : 0;
			$stun_level -= $has_pain_resistance ? 1 : 0;
			$stun_level = min($stun_level, 3);

			switch ($stun_level) {
				case 3:
					$result["sonné"] = "Sonné niv.3.";
					$result["chute"] = true;
					break;

				case 2:
					$duration = max($rolls[2] - $san + 5, 0);
					$result["sonné"] = "Sonné niv.2 pendant " . $duration + 1 . " action" . ($duration ? "s" : "");
					break;

				case 1:
					$duration = max($rolls[2] - $san, 0);
					$result["sonné"] = "Sonné niv.1 pendant " . $duration + 1 . " action" . ($duration ? "s" : "");
					break;
			}
		}

		// ––– knock out
		if ($is_head) {
			$knock_out_modifier = -$actual_dmg + ($is_penetrating ? 5 : 0);
			var_dump("knock out modif : " . $knock_out_modifier);
			$result["perte de conscience"] = !is_success($san + $knock_out_modifier, $rolls[3]);
		}

		// ––– death 🏴‍☠️
		if ($localisation === "torse" && $pdv <= -$pdvm && $actual_dmg >= 0.5 * $pdvm) {
			$pdv_death_modifier = 5 * ($pdv / $pdvm + 1);
			$dmg_death_modifier = - ($actual_dmg / $pdvm - 0.5) * 5;
			$death_modifier = (int) round(($pdv_death_modifier + $dmg_death_modifier) / 2);
			var_dump("death modif torso : " . $death_modifier);
			$result["mort"] = !is_success($san + $death_modifier, $rolls[4]) ? "Mort en " . round($rolls[5] * 2) . " secondes" : false;
		} elseif ($is_vital && $actual_dmg >= 0.25 * $pdvm) {
			$death_modifier = modif(1.5 * $actual_dmg, $pdvm);
			var_dump("death modif vital : " . $death_modifier);
			$result["mort"] = !is_success($san + $death_modifier, $rolls[4]) ? "Mort immédiate&nbsp;! 😵" : false;
		}

		// ––– special random effects
		$effects_modifier = modif($actual_dmg, $pdvm * 0.75);
		var_dump("effects modif : " . $effects_modifier);
		if ($actual_dmg > 0.25 * $pdvm && !is_success($san + $effects_modifier, $rolls[6])) {
			if ($localisation === "torse") {
				$effects = [
					0 => "colonne vertébrale touchée. Le personnage est paraplégique. Cette lésion peut guérir – la traiter comme une blessure invalidante.",
					1 => "colonne vertébrale touchée. Le personnage est définitivement paraplégique",
					2 => "organe vital touché. Mort en quelques heures, sauf intervention chirurgicale réussie ou soins magiques",
					3 => "organe vital touché. Mort en quelques minutes, sauf intervention chirurgicale réussie ou soins magiques.",

				];
				if ($is_penetrating || $dmg_type === "tr" ) {
					$result["autres effets"] = get_random_element($effects, $actual_dmg <= 0.5 * $pdvm ? [1, 0, 10, 5] : [1, 1, 5, 10]);
				} else {
					$result["autres effets"] = get_random_element($effects, $actual_dmg <= 0.5 * $pdvm ? [2, 0, 2, 1] : [1, 3, 2, 2]);
				}
			} elseif ($localisation === "cou") {
				$effects = [
					0 => "colonne vertébrale touchée. Le personnage est tétraplégique. Cette lésion peut guérir – la traiter comme une blessure invalidante.",
					1 => "colonne vertébrale touchée. Le personnage est définitivement tétraplégique",
					2 => "le personnage ne peut plus respirer et meurt rapidement",
					3 => "Le personnage s’étouffe dans son sang. Mort en quelques minutes, sauf intervention chirurgicale réussie ou soins magiques.",
				];
				if ($is_penetrating || $dmg_type === "tr") {
					$result["autres effets"] = get_random_element($effects, $actual_dmg <= 0.5 * $pdvm ? [1, 0, 1, 6] : [1, 1, 1, 5]);
				} else {
					$result["autres effets"] = get_random_element($effects, $actual_dmg <= 0.5 * $pdvm ? [2, 0, 4, 0] : [1, 3, 4, 0]);
				}
			}
		}

		// ––– member damages
		if ($is_member) {
			$result["dégâts membre"] = ucfirst($localisation) . " " . $result["dégâts effectifs"];
			$result["dégâts effectifs"] = 0;
		}

		return $result;
	}
}
