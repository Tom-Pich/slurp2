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
		$category = !in_array($category, ["std", "nbh", "nbx", "ins"]) ? "std" : $category;
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
		if (in_array($category, ["nbh", "nbx"])) {
			//non biological creature – humanoid (h) or not (x)
			$dmg_multipliers = ["br" => 1, "tr" => 1, "pe" => 1, "mn" => 1, "b0" => .5, "b1" => 1, "b2" => 1.5, "b3" => 2, "exp" => 1];
			$is_vital = false;
			$is_sensitive = false;
			$skull_dmg_factor = $category === "nbh" ? 2 : 1;
			$no_minimal_penetrating_dmg = true;
			$cannot_be_stunned = true;
			$cannot_be_knocked_out = true;
			$automatic_death = 0; // pdvm mult threshold for automatic death (default -3) → automatic death at 0 pdv
		}

		if ($category === "ins") {
			$pdvm_multiplier_for_rcl = .5; // double pdv don't count for recoil
		}

		// ––– recoil ––––––––––––
		$limited_raw_dmg = $is_perforating ? min($raw_dmg, ($pdvm + $rd) * ($limits[$localisation] ?? 1)) : $raw_dmg;
		$rcl_dmg = $limited_raw_dmg * $rcl[$dmg_type];
		$rcl_pdvm = $pdvm * ($pdvm_multiplier_for_rcl ?? 1);
		$rcl_distance = $rcl_dmg / $rcl_pdvm * 3;
		$rcl_modif = DiceManager::getModifier($rcl_dmg * ($is_head ? 3 : 1), 0.8 * $rcl_pdvm);
		$result["recul"] = floor($rcl_distance * 2) / 2;
		if ($rcl_modif <= 3)  $result["chute"] = !DiceManager::check_is_successfull($dex + $rcl_modif, $rolls[0]);

		// ––– armor and special bullet types
		$rd = $is_armor_piercing_bullet ? floor($rd / 2) : $rd;
		$rd = $is_hollow_point_bullet ? max($rd * 2, 1) : $rd;

		// ––– effective damages
		$net_dmg = max($raw_dmg - $rd, 0);
		$net_dmg_limit_factor = !$is_vital && $is_perforating ? ($limits[$localisation] ?? 1) : INF;
		$net_dmg = min($net_dmg, $pdvm * $net_dmg_limit_factor);

		$dmg_multiplier = $dmg_multipliers[$dmg_type];
		if ($is_member) $dmg_multiplier = 1;
		if ($is_vital && !$is_bullet) $dmg_multiplier = max($dmg_multiplier * 1.5, 2);
		if ($is_vital && $is_bullet) $dmg_multiplier = max($dmg_multiplier * 2.25, 3);
		if ($is_skull) $dmg_multiplier = $skull_dmg_factor ?? 4;
		if ($is_armor_piercing_bullet) $dmg_multiplier *= .5;
		if ($is_hollow_point_bullet) $dmg_multiplier *= 2;

		$actual_dmg = $net_dmg * $dmg_multiplier;
		if ($localisation === "crane") {
			$cranial_rd = .2 * $pdvm;
			if ($is_armor_piercing_bullet) $cranial_rd *= 0.5;
			if ($is_hollow_point_bullet) $cranial_rd *= 1.5;
			if ($net_dmg <= $cranial_rd) {
				$actual_dmg = $net_dmg;
			} else {
				$actual_dmg = $cranial_rd + ($net_dmg - $cranial_rd) * $dmg_multiplier;
			}
		}
		if ($rd === 0 && $is_penetrating && !$actual_dmg && empty($no_minimal_penetrating_dmg) ) $actual_dmg = 1;

		$result["dégâts effectifs"] = floor($actual_dmg);
		$pdv -= !$is_member ? $result["dégâts effectifs"] : 0;
		$result["pdv"] = $pdv;
		$is_significant_wound = $actual_dmg >= 0.25 * $pdvm;
		$is_major_wound = $actual_dmg >= 0.5 * $pdvm;

		// ––– fall due to high damages
		$fall_modifier = DiceManager::getModifier($actual_dmg, .5*$pdvm);
		$result["chute"] = $result["chute"] || $fall_modifier <= 3 && !DiceManager::check_is_successfull($san + $fall_modifier, $rolls[1]);

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
			$stun_level -= DiceManager::check_is_successfull($san - 2 * ($stun_level-1), $rolls[2]) ? 1 : 0;
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
					0 => "Colonne vertébrale touchée. Le personnage est paraplégique. Cette lésion peut guérir – la traiter comme une blessure invalidante.",
					1 => "Colonne vertébrale touchée. Le personnage est définitivement paraplégique.",
					2 => "Organe vital touché. Mort en quelques heures, sauf intervention chirurgicale réussie ou soins magiques.",
					3 => "Organe vital touché. Mort en quelques minutes, sauf intervention chirurgicale réussie ou soins magiques.",

				];
				$explosion_effects = [
					0 => "Blessure invalidante aux tympans. Le personnage souffre d’une <i>Surdité partielle</i> de niveau $explosion_gravity."
				];
				if ($is_penetrating) {
					$result["autres effets"] = TableReader::getWeightedResult($effects, !$is_major_wound ? [1, 0, 10, 5] : [1, 1, 5, 10]);
				} elseif ($is_blunting) {
					$result["autres effets"] = TableReader::getWeightedResult($effects, !$is_major_wound ? [2, 0, 2, 1] : [1, 3, 2, 2]);
				} elseif ($dmg_type === "exp") {
					$result["autres effets"] = TableReader::getWeightedResult($effects, !$is_major_wound ? [1, 0, 5, 0] : [1, 1, 8, 5]);
					$result["autres effets"] .= (" " . $explosion_effects[0]);
				}
				//
			} elseif ($localisation === "cou") {
				$effects = [
					0 => "Colonne vertébrale touchée. Le personnage est tétraplégique. Cette lésion peut guérir – la traiter comme une blessure invalidante.",
					1 => "Colonne vertébrale touchée. Le personnage est définitivement tétraplégique.",
					2 => "Le personnage ne peut plus respirer et meurt rapidement.",
					3 => "Le personnage s’étouffe dans son sang. Mort en quelques minutes, sauf intervention chirurgicale réussie ou soins magiques.",
				];
				if ($is_penetrating) {
					$result["autres effets"] = TableReader::getWeightedResult($effects, !$is_major_wound ? [1, 0, 1, 6] : [1, 1, 1, 5]);
				} else {
					$result["autres effets"] = TableReader::getWeightedResult($effects, !$is_major_wound ? [2, 0, 4, 0] : [1, 3, 4, 0]);
				}
			} elseif ($localisation === "crane") {
				$effects = [
					0 => "Le personnage souffre de <i>Migraines</i> intenses régulièrement. À traiter comme une blessure invalidante.",
					1 => "Lésion cérébrale. Le personnage souffre d’<i>Amnésie partielle</i>. À traiter comme une blessure invalidante.",
					2 => "Lésion cérébrale. Le personnage souffre d’<i>Amnésie totale</i>. À traiter comme une blessure invalidante.",
					3 => "Lésion cérébrale. Le personnage perd " . ceil($actual_dmg * 2 / $pdvm) . " points d’<i>Intelligence</i>. À traiter comme une blessure invalidante.",
					4 => "Lésion cérébrale définitive. Le personnage est un légume (<i>Int</i> de 3)",
					5 => "Lésion cérébrale. Le personnage souffre de paralysie complète. À traiter comme une blessure invalidante.",
					6 => "Lésion cérébrale. Le personnage tombe dans un coma qui durera 1d mois.",
					7 => "Lésion cérébrale. Le personnage tombe dans un coma définitif.",
				];
				$result["autres effets"] = TableReader::getWeightedResult($effects, !$is_major_wound ? [2, 1, 0, 1, 0, 0, 1, 0] : [3, 3, 1, 3, 1, 1, 3, 1]);
			} elseif ($localisation === "visage") {
				$effects = [
					0 => "Dents arrachées (" . ceil($actual_dmg) . ")",
					1 => "Mâchoire fracturée",
					2 => "Mâchoire brisée",
					3 => "Cicatrice définitive",
					4 => "Œil handicapé",
					5 => "Œil détruit",
					6 => "Nez cassé",
					7 => "Nez arraché",
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
