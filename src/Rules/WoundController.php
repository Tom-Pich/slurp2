<?php

namespace App\Rules;

use App\Lib\DiceManager;
use App\Lib\TableReader;

class WoundController
{

	public const general_levels = [
		"-3.0" => [
			"description" => "Mort automatique",
			"for-multiplier" => 0,
			"dex-modifier" => -INF,
			"int-modifier" => -INF,
			"vit-multiplier" => 0,
		],
		/* "-2" => [
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
		], */
		"-1.0" => [
			"description" => "Perte de conscience automatique. Tant qu’il ne repasse pas au-dessus de ce seuil, le personnage reste inconscient. Il ne peut ni boire, ni se nourrir.",
			"for-multiplier" => 0,
			"dex-modifier" => -INF,
			"int-modifier" => -INF,
			"vit-multiplier" => 0,
		],
		"0.0" => [
			"description" => "Jet de <i>Vol</i>-3 à chaque round pour ne pas perdre conscience. Le personnage ne peut pas se tenir debout. Il peut reprendre conscience ultérieurement, mais ne pourra rien faire et sera semi-conscient jusqu’à ce que ses PdV repassent au-dessus de ce seuil.",
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
		"0.75" => ["description" => "Malus"],
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

	public static function getGeneralEffects(int $pdv, int $pdvm, int $pain_resistance = 0)
	{
		$ratio = $pdvm === 0 ? 1 : $pdv / $pdvm;
		if ($pain_resistance >= 1 && $ratio > -1) {
			$ratio += 0.25;
		} else if ($pain_resistance <= -1 && $ratio > -1 && $pdv < $pdvm) {
			$ratio -= 0.25;
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

	public static function getMemberEffects(int $dmg, int $pdvm, string $member, int $pain_resistance = 0)
	{
		// validate entries
		if ($pdvm <= 0 || empty(self::members_pdv[$member])) return ["description" => "Paramètres incohérents"];

		$member_pdv = self::members_pdv[$member] * $pdvm; // ?? self::members_pdv["bras"] * $pdvm;
		//$ratio = $pdvm === 0 ? 1 : ($member_pdv - $dmg) / $member_pdv;
		$ratio = ($member_pdv - $dmg) / $member_pdv; // between 1 and negative value
		if ($pain_resistance >= 1 && $ratio > 0) {
			$ratio += 0.25;
		} else if ($pain_resistance <= -1 && $ratio > -1) {
			$ratio -= 0.25;
		}
		foreach (self::members_levels as $level => $effects) {
			$level = (float) $level;
			if ($ratio <= $level) {
				if ($effects["description"] === "Malus") {
					switch ($member) {
						case "bras":
							$effects["description"] = "-3 pour utiliser ce bras";
							break;
						case "main":
							$effects["description"] = "-3 pour utiliser cette main";
							break;
						default:
							$effects["description"] = "Désavantage <i>Boiteux</i>";
					}
				}
				return $effects;
			}
		}
		return ["description" => "Aucun effet"];
	}

	/**
	 * return an array with all wound effects
	 * @param int $pain_resistance : -1, 0 or 1;
	 * @param string $dmg_type : br, tr, pe, mn, b0, b1, b2, b3, exp
	 * @param string $bullet_type : std, bpa, bpc
	 * @param string $localisation : torse,  coeur, crane, visage, cou, jambe, bras, pied, main, oeil, org_gen
	 * @param array $rolls : array with at least 7 int corresponding to rolls of 3d6
	 */
	public static function getWoundEffects(string $category, int $dex, int $san, int $pdvm, int $pdv, int $pain_resistance, int $raw_dmg, int $rd, string $dmg_type, string $bullet_type, string $localisation, array $rolls): array
	{
		// sanitizing string entries
		$category = !in_array($category, ["std", "nbh", "nbx"]) ? "std" : $category;
		$dmg_type = !in_array($dmg_type, ["br", "tr", "pe", "mn", "b0", "b1", "b2", "b3", "exp"]) ? "br" : $dmg_type;
		$bullet_type = !in_array($bullet_type, ["std", "bpa", "bpc"]) ? "std" : $bullet_type;
		$localisation = !in_array($localisation, ["torse",  "coeur", "crane", "visage", "cou", "jambe", "bras", "pied", "main", "oeil", "org_gen"]) ? "torse" : $localisation;

		// base result array
		$result = [
			"categorie" => $category,
			"dex" => $dex,
			"san" => $san,
			"pdvm" => $pdvm,
			"pdv_init" => $pdv,
			"res-douleur" => $pain_resistance,
			"dégâts bruts" => $raw_dmg,
			"RD" => $rd,
			"type dégâts" => $dmg_type,
			"type balle" => $bullet_type,
			"localisation" => $localisation,
			"jets" => $rolls,
			"dégâts effectifs" => "",
			"dégâts membre" => "",
			"recul" => 0,
			"chute" => false,
			"mort" => false,
			"perte de conscience" => false,
			"sonné" => 0,
			"autres effets" => "",
			"pdv" => $pdv,
		];

		if ($pdvm <= 0) {
			return $result; // unable to do any process
		}

		// localisations : torse, coeur, crane, visage, cou, jambe, bras, pied, main, oeil, org_gen
		// dmg type : br, tr, pe, mn, b0, b1, b2, b3, exp | b0: (-), b2: (+), (b3): (++)
		// bullet type : std, bpa, bpc | bpa: balle perce-armure, bpc: balle à pointe creuse

		// base values
		$dmg_multipliers = ["br" => 1, "tr" => 1.5, "pe" => 2, "mn" => 1, "b0" => 0.5, "b1" => 1, "b2" => 1.5, "b3" => 2, "exp" => 1];
		$limits = [
			"bras" => self::members_pdv["bras"] * 1.25, // 0.4×1.25 = 0.5
			"jambe" => self::members_pdv["jambe"] * 1.25, // 0.5×1.25 = 0.625
			"pied" => self::members_pdv["pied"] * 1.25, // 0.33×1.25 = 0.4125
			"main" => self::members_pdv["main"] * 1.25 // 0.25×1.25 = 0.3125
		];
		$rcl = ["br" => 1.5, "tr" => 1, "pe" => 0.75, "mn" => 2.5, "b0" => 0.5, "b1" => 0.5, "b2" => 0.75, "b3" => 1, "exp" => 3];

		// variables shorthand and inconsistency correction
		$is_bullet = in_array($dmg_type, ["b0", "b1", "b2", "b3"]);
		$is_armor_piercing_bullet = $is_bullet && $bullet_type === "bpa";
		$is_hollow_point_bullet = $is_bullet && $bullet_type === "bpc";

		$is_perforating = $is_bullet || $dmg_type === "pe"; // b0, b1, b2, b3, pe
		$is_penetrating = $is_perforating || $dmg_type === "tr"; // b0, b1, b2, b3, pe, tr
		$is_blunting = in_array($dmg_type, ["br", "mn"]); // br, mn

		$localisation = $localisation === "coeur" && $dmg_type === "tr" ? "torse" : $localisation;
		$localisation = $dmg_type === "exp" ? "torse" : $localisation;
		$localisation = $localisation === "oeil" && !$is_perforating ? "visage" : $localisation;
		$result["type balle"] = $bullet_type;
		$result["localisation"] = $localisation;

		$is_member = in_array($localisation, ["bras", "main", "pied", "jambe"]);
		$is_vital = in_array($localisation, ["visage", "coeur", "cou", "crane", "oeil"]);
		$is_head = in_array($localisation, ["crane", "visage", "oeil"]);
		$is_skull = in_array($localisation, ["crane", "oeil"]);
		$is_sensitive = in_array($localisation, ["visage", "org_gen", "crane", "oeil"]);

		// changes for special categories
		if ($category === "nbh" || $category === "nbx") {
			//non biological creature – humanoid (h) or not (x)
			$dmg_multipliers = ["br" => 1, "tr" => 1, "pe" => 1, "mn" => 1, "b0" => 1, "b1" => 1, "b2" => 1, "b3" => 1, "exp" => 1];
			$is_vital = false;
			$is_sensitive = false;
			$skull_dmg_factor = $category === "nbh" ? 2 : 1;
			$no_minimal_penetrating_dmg = true;
			$cannot_be_stunned = true;
			$cannot_be_knocked_out = true;
			$automatic_death = 0; // pdvm mult threshold for automatic death (default -3)
		}

		// ––– recoil
		$limited_raw_dmg = $is_perforating ? min($raw_dmg, ($pdvm + $rd) * ($limits[$localisation] ?? 1)) : $raw_dmg;
		$rcl_dmg = $limited_raw_dmg * $rcl[$dmg_type] * ($is_head ? 3 : 1);
		$rcl_modif = DiceManager::getModifier($rcl_dmg, 0.8 * $pdvm);
		$rcl_distance = $rcl_dmg / $pdvm * 3;
		$rcl_distance = min($rcl_distance, $raw_dmg / 2, $pdvm / 3);
		if ($rcl_distance >= 1) $rcl_distance += (random_int(0, 2) - 1);
		$result["recul"] = floor($rcl_distance);
		if($rcl_modif <= 3)  $result["chute"] = !DiceManager::check_is_successfull($dex + $rcl_modif, $rolls[0]);
		// for bullet and piercing damages → raw_dmg for recoil limited to pdvm + rd (× member limit)
		// rcl_dmg → limited raw_damage × rcl factor depending on dmg type (×3 if head)
		// recoil distance → 3×(rcl_dmg / pdvm), cannot exceed raw_dmg / 2 and pdvm/3
		// if recoil distance > 1, add a random number [-1, 0, 1]
		// recoil distance is rounded down
		// fall modifier : +1 for each 10% excess of recoil_dmg over 80% of pvdm
		// fall test (only if modifier <= +3): use first roll, against Dex + fall modifier

		// ––– armor and special bullet types
		$rd = $is_armor_piercing_bullet ? floor($rd / 2) : $rd;
		$rd = $is_hollow_point_bullet ? max($rd * 2, 1) : $rd;

		// ––– effective damages
		$net_dmg = $raw_dmg - $rd;
		$net_dmg = $net_dmg >= 0 ? $net_dmg : 0;
		$net_dmg_limit_factor = !$is_vital && $is_perforating ? ($limits[$localisation] ?? 1) : INF;
		$net_dmg = min($net_dmg, $pdvm * $net_dmg_limit_factor);
		// for bullet and piercing damages → limité par pdvm membre ou pdvm si torse, jambe, bras, pied, main, org_gen

		$dmg_multiplier = $is_member ? 1 : $dmg_multipliers[$dmg_type];
		$dmg_multiplier = $is_vital ? max($dmg_multiplier * 1.5, 2) : $dmg_multiplier;
		$dmg_multiplier = $is_vital && $is_bullet ? max($dmg_multiplier * 1.5, 3) : $dmg_multiplier;
		$dmg_multiplier = $is_skull ? $skull_dmg_factor ?? 4 : $dmg_multiplier;
		// 1.5 pour tr, 2 pour perf, balle : mult selon calibre 0.5, 1, 1.5, 2
		// si visage, coeur, cou, crane, oeil → mult dégâts × 1.5, minimum 2
		// si visage, coeur, cou, crane, oeil et balle, encore ×1.5, minimum 3
		// si crâne ou oeil → ×4 (sauf si $skull_dmg_factor est spécifié)

		$actual_dmg = $net_dmg * $dmg_multiplier;
		$actual_dmg = ($rd === 0 && $is_penetrating && empty($no_minimal_penetrating_dmg)) ? max($actual_dmg, 1) : $actual_dmg;
		$actual_dmg *= $is_armor_piercing_bullet ? 0.5 : 1;
		$actual_dmg *= $is_hollow_point_bullet ? 2 : 1;
		$actual_dmg -= ($localisation === "crane") ? min($net_dmg, $pdvm / 5) * 3 : 0; //cranial bones protection
		$result["dégâts effectifs"] = floor($actual_dmg);
		$pdv -= !$is_member ? $result["dégâts effectifs"] : 0;
		$result["pdv"] = $pdv;
		$is_significant_wound = $actual_dmg >= 0.25 * $pdvm;
		$is_major_wound = $actual_dmg >= 0.5 * $pdvm;

		// ––– fall due to high damages
		$fall_modifier = DiceManager::getModifier(2 * $actual_dmg, $pdvm);
		$result["chute"] = $result["chute"] || $actual_dmg && !DiceManager::check_is_successfull($san + $fall_modifier, $rolls[1]);

		// ––– stunning
		$stun_level = 0;
		$might_be_stunned = $is_significant_wound || $is_sensitive || $pain_resistance <= -1 && $actual_dmg > 0;
		$might_be_stunned = $might_be_stunned && empty($cannot_be_stunned);

		if ($might_be_stunned) {

			$stun_base_threshold = $is_sensitive ? 0.1 * $pdvm : 0.25 * $pdvm;
			$stun_base_threshold *= ($pain_resistance <= -1) ? 0.5 : 1;

			if ($actual_dmg >= 4 * $stun_base_threshold) {
				$stun_level = 3;
			} elseif ($actual_dmg >= 2 * $stun_base_threshold) {
				$stun_level = 2;
			} elseif ($actual_dmg >= $stun_base_threshold || $is_sensitive) {
				$stun_level = 1;
			}

			$stun_level += $localisation === "org_gen" ? 2 : 0;
			$stun_level -= DiceManager::check_is_successfull($san - 2 * $stun_level, $rolls[2]) ? 1 : 0;
			$stun_level -= $pain_resistance;
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
		if ($is_head && empty($cannot_be_knocked_out)) {
			$knock_out_modifier = round(-$actual_dmg + ($is_penetrating ? 5 : 0));
			$result["perte de conscience"] = !DiceManager::check_is_successfull($san + $knock_out_modifier, $rolls[3]);
		}

		// ––– death
		$is_severly_wounded = $pdv <= -$pdvm && $is_major_wound || $pdv <= -1.5 * $pdvm && $is_significant_wound || $pdv <= -2 * $pdvm && $actual_dmg;
		$is_automatically_dead = $pdv <= ($automatic_death ?? -3) * $pdvm;

		if ($is_automatically_dead) {
			$result["mort"] = "Le personnage est mort&nbsp;! 😵";
		} elseif ($localisation === "torse" && $is_severly_wounded) {
			$pdv_death_modifier = 5 * ($pdv / $pdvm + 1);
			$dmg_death_modifier = - ($actual_dmg / $pdvm - 0.5) * 5;
			$death_modifier = (int) round(($pdv_death_modifier + $dmg_death_modifier) / 2);
			$result["mort"] = !DiceManager::check_is_successfull($san + $death_modifier, $rolls[4]) ? "Mort en " . round($rolls[5] / 2.5) * 5 . " secondes" : false;
		} elseif ($is_vital && $is_significant_wound) {
			$death_modifier = DiceManager::getModifier(1.5 * $actual_dmg, $pdvm);
			$result["mort"] = !DiceManager::check_is_successfull($san + $death_modifier, $rolls[4]) ? "Mort immédiate&nbsp;! 😵" : false;
		}

		// ––– special random effects
		$effects_modifier = DiceManager::getModifier($actual_dmg, $pdvm * 0.75);
		$purely_random_parameter = $localisation === "visage" ? random_int(0, 2) <= 1 : random_int(0, 1) === 0;
		if ($is_significant_wound && !DiceManager::check_is_successfull($san + $effects_modifier, $rolls[6]) && $purely_random_parameter) {

			if ($localisation === "torse") {
				$explosion_gravity = max(floor(-DiceManager::getModifier($actual_dmg * 2, $pdvm) / 2), 1);
				$effects = [
					0 => "colonne vertébrale touchée. Le personnage est paraplégique. Cette lésion peut guérir – la traiter comme une blessure invalidante.",
					1 => "colonne vertébrale touchée. Le personnage est définitivement paraplégique.",
					2 => "organe vital touché. Mort en quelques heures, sauf intervention chirurgicale réussie ou soins magiques",
					3 => "organe vital touché. Mort en quelques minutes, sauf intervention chirurgicale réussie ou soins magiques.",

				];
				$explosion_effects = [
					0 => "blessure invalidante aux tympans. Le personnage souffre d’une <i>Surdité partielle</i> de niveau $explosion_gravity."
				];
				if ($is_penetrating) {
					$result["autres effets"] = TableReader::getWeightedResult($effects, !$is_major_wound ? [1, 0, 10, 5] : [1, 1, 5, 10]);
				} elseif ($is_blunting) {
					$result["autres effets"] = TableReader::getWeightedResult($effects, !$is_major_wound ? [2, 0, 2, 1] : [1, 3, 2, 2]);
				} elseif ($dmg_type === "exp") {
					$result["autres effets"] = TableReader::getWeightedResult($effects, !$is_major_wound ? [1, 0, 5, 0] : [1, 1, 8, 5]);
					$result["autres effets"] .= (" " . ucfirst($explosion_effects[0]));
				}
				//
			} elseif ($localisation === "cou") {
				$effects = [
					0 => "colonne vertébrale touchée. Le personnage est tétraplégique. Cette lésion peut guérir – la traiter comme une blessure invalidante.",
					1 => "colonne vertébrale touchée. Le personnage est définitivement tétraplégique.",
					2 => "le personnage ne peut plus respirer et meurt rapidement.",
					3 => "Le personnage s’étouffe dans son sang. Mort en quelques minutes, sauf intervention chirurgicale réussie ou soins magiques.",
				];
				if ($is_penetrating) {
					$result["autres effets"] = TableReader::getWeightedResult($effects, !$is_major_wound ? [1, 0, 1, 6] : [1, 1, 1, 5]);
				} else {
					$result["autres effets"] = TableReader::getWeightedResult($effects, !$is_major_wound ? [2, 0, 4, 0] : [1, 3, 4, 0]);
				}
			} elseif ($localisation === "crane") {
				$effects = [
					0 => "le personnage souffre de <i>Migraines</i> intenses régulièrement. À traiter comme une blessure invalidante.",
					1 => "lésion cérébrale. Le personnage souffre d’<i>Amnésie partielle</i>. À traiter comme une blessure invalidante.",
					2 => "lésion cérébrale. Le personnage souffre d’<i>Amnésie totale</i>. À traiter comme une blessure invalidante.",
					3 => "lésion cérébrale. Le personnage perd " . ceil($actual_dmg * 2 / $pdvm) . " points d’<i>Intelligence</i>. À traiter comme une blessure invalidante.",
					4 => "lésion cérébrale définitive. Le personnage est un légume (<i>Int</i> de 3)",
					5 => "lésion cérébrale. Le personnage souffre de paralysie complète. À traiter comme une blessure invalidante.",
					6 => "lésion cérébrale. Le personnage tombe dans un coma qui durera 1d mois.",
					7 => "lésion cérébrale. Le personnage tombe dans un coma définitif.",
				];
				$result["autres effets"] = TableReader::getWeightedResult($effects, !$is_major_wound ? [2, 1, 0, 1, 0, 0, 1, 0] : [3, 3, 1, 3, 1, 1, 3, 1]);
			} elseif ($localisation === "visage") {
				$effects = [
					0 => "dents arrachées (" . ceil($actual_dmg) . ")",
					1 => "mâchoire fracturée",
					2 => "mâchoire brisée",
					3 => "cicatrice définitive",
					4 => "oeil handicapé",
					5 => "oeil détruit",
					6 => "nez cassé",
					7 => "nez arraché",
				];
				$result["autres effets"] = TableReader::getWeightedResult($effects, $actual_dmg <= 0.5 * $pdvm ? [1, 1, 0, 3, 1, 0, 1, 0] : [1, 0, 1, 3, 1, 1, 1, 1]);
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
