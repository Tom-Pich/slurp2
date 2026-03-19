<?php

namespace App\Rules;

use App\Lib\TextParser;
use App\Lib\DiceManager;
use App\Lib\TableReader;

class WoundController
{

	public const general_levels = [
		"-3.0" => [
			"name" => "mort",
			"description" => "Mort automatique",
			"for-multiplier" => 0,
			"dex-modifier" => -100,
			"int-modifier" => -100,
			"per-modifier" => -100,
			"vol-modifier" => -100,
			"vit-multiplier" => 0,
		],
		"-1.0" => [
			"name" => "état critique",
			"description" => "Perte de conscience automatique. Tant qu’il ne repasse pas au-dessus de ce seuil, le personnage reste inconscient. Il ne peut ni boire, ni se nourrir.<br>
			Toutes les caractéristiques à 0, <i>Vol</i> à -5",
			"for-multiplier" => 0,
			"dex-modifier" => -100,
			"int-modifier" => -100,
			"per-modifier" => -100,
			"vol-modifier" => -5,
			"vit-multiplier" => 0,
		],
		"0.0" => [
			"name" => "très gravement blessé",
			"description" => "Jet de <i>Vol</i> à chaque round pour ne pas perdre conscience. Le personnage ne peut pas se tenir debout. Il peut reprendre conscience ultérieurement, mais ne pourra rien faire et sera semi-conscient jusqu’à ce que ses PdV repassent au-dessus de ce seuil.<br>
			<i>For</i>×0.3, <i>Vitesse</i> = 0, <i>Dex</i> et <i>Int</i> à -7, <i>Per</i> à -5 et <i>Vol</i> à -3",
			"for-multiplier" => 0.3,
			"dex-modifier" => -7,
			"int-modifier" => -7,
			"per-modifier" => -5,
			"vol-modifier" => -3,
			"vit-multiplier" => 0,
		],
		"0.25" => [
			"name" => "gravement blessé",
			"description" => "<i>For</i>×0.5, <i>Vitesse</i>×0.2, <i>Dex</i> et <i>Int</i> à -5, <i>Per</i> à -3 et <i>Vol</i> à -2",
			"for-multiplier" => 0.5,
			"dex-modifier" => -5,
			"int-modifier" => -5,
			"per-modifier" => -3,
			"vol-modifier" => -2,
			"vit-multiplier" => 0.2,
		],
		"0.5" => [
			"name" => "moyennement blessé",
			"description" => "<i>For</i>×0.75, <i>Vitesse</i>×0.5, <i>Dex</i> et <i>Int</i> à -3, <i>Per</i> à -2 et <i>Vol</i> à -1",
			"for-multiplier" => 0.75,
			"dex-modifier" => -3,
			"int-modifier" => -3,
			"per-modifier" => -2,
			"vol-modifier" => -1,
			"vit-multiplier" => 0.5,
		],
		"0.75" => [
			"name" => "légèrement blessé",
			"description" => "<i>For</i>×0.9, <i>Vitesse</i>×0.8, <i>Dex</i>, <i>Int</i> et <i>Per</i> à -1",
			"for-multiplier" => 0.9,
			"dex-modifier" => -1,
			"int-modifier" => -1,
			"per-modifier" => -1,
			"vit-multiplier" => 0.8,
		],
	];

	public const members_levels = [
		"-1.0" => ["description" => "Membre détruit"],
		"0" => ["description" => "Blessure invalidante"],
		"0.5" => ["description" => "Inutilisable"],
		"0.75" => ["description" => "-3 pour utiliser ce membre"],
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

		$member_pdv = self::members_pdv[$member] * $pdvm;
		$ratio = ($member_pdv - $dmg) / $member_pdv; // between 1 and negative value
		if ($pain_resistance >= 1 && $ratio > 0) {
			$ratio += 0.25;
		} else if ($pain_resistance <= -1 && $ratio > -1) {
			$ratio -= 0.25;
		}
		foreach (self::members_levels as $level => $effects) {
			$level = (float) $level;
			if ($ratio <= $level) {
				if ($effects["description"] === "-3 pour utiliser ce membre") {
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

	public static function getMembersState(int $pdvm, string $members, int $pain_resistance = 0)
	{
		$members_parsed = TextParser::parsePseudoArray2Array($members);
		$effects = [
			"members" => [],
			"error" => false,
		];
		foreach ($members_parsed as $member => $damage) {
			$member_full_name = self::member_abbreviation[$member]["full-name"] ?? false;
			$member_name = self::member_abbreviation[$member]["member"] ?? false;
			if ($member_full_name && is_numeric($damage)) {
				$effects["members"][ucfirst($member_full_name)] = [
					"damage" => (int) $damage,
					"description" => self::getMemberEffects($damage, $pdvm, $member_name, $pain_resistance)["description"],
					"max-damage" => round(self::members_pdv[$member_name] * 2 * $pdvm, 1),
				];
			} else {
				$effects["error"] = true;
			}
		}
		return $effects;
	}

	/**
	 * return an array with all wound effects
	 * @param string $category : catégorie de créature (std, nbh, nbx, ins, ci)
	 * @param int $dex : dextérité de la victime
	 * @param int $san : santé de la victime
	 * @param int $pdvm : pdv max de la victime
	 * @param int $pdv : pdv actuel de la victime
	 * @param int $pain_resistance : -1, 0 or 1;
	 * @param int $raw_dmg : dégâts bruts;
	 * @param int $rd : RD de la victime;
	 * @param string $dmg_type : br, tr, pe, mn, b0, b1, b2, b3, exp
	 * @param string $bullet_type : std, bpa, bpc
	 * @param string $localisation : torse,  coeur, crane, visage, cou, jambe, bras, pied, main, oeil, org_gen
	 * @param array $rolls : array with at least 7 int corresponding to rolls of 3d6
	 */
	public static function getWoundEffects(string $category, int $dex, int $san, int $pdvm, int $pdv, int $pain_resistance, int $raw_dmg, int $rd, string $dmg_type, string $bullet_type, string $localisation, array $rolls): array
	{
		// validation des entrées
		$valid_localisations = ["torse",  "coeur", "crane", "visage", "cou", "jambe", "bras", "pied", "main", "oeil", "org_gen"];
		$category = !in_array($category, ["std", "nbh", "nbx", "ins", "ci"]) ? "std" : $category;
		$pain_resistance = !in_array($pain_resistance, [-1, 0, 1]) ? 0 : $pain_resistance;
		$dmg_type = !in_array($dmg_type, ["br", "tr", "pe", "mn", "b0", "b1", "b2", "b3", "exp"]) ? "br" : $dmg_type;
		$bullet_type = !in_array($bullet_type, ["std", "bpa", "bpc"]) ? "std" : $bullet_type;
		$localisation = !in_array($localisation, $valid_localisations) ? "torse" : $localisation;
		$rolls = array_filter($rolls, fn($roll) => $roll >= 3 && $roll <= 18);

		// default result array
		$result = [
			"erreur" => false,
			"pdvm" => $pdvm,
			"dégâts bruts" => $raw_dmg,
			"RD" => $rd,
			"type dégâts" => $dmg_type,
			"type balle" => null,
			"localisation" => $localisation,
			"dégâts effectifs" => "",
			"dégâts membre" => "",
			"état membre" => "",
			"recul" => 0,
			"chute" => false,
			"mort" => false,
			"perte de conscience" => false,
			"sonné" => 0,
			"autres effets" => "",
			"pdv" => $pdv,
			/* "entries" => [
				"category" => $category,
				"dex" => $dex,
				"san" => $san,
				"pdv_init" => $pdv,
				"res-douleur" => $pain_resistance,
				"jets" => $rolls,
			], */
			"internal-values" => [], // for test purpose
		];

		// missing vital data
		if ($pdvm <= 0 || $dex <= 0 || $san <= 0 || count($rolls) < 7) {
			$result["erreur"] = true;
			return $result;
		}

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
		if ($is_bullet) $result["type balle"] = $bullet_type;

		$is_perforating = $is_bullet || $dmg_type === "pe"; // b0, b1, b2, b3, pe
		$is_penetrating = $is_perforating || $dmg_type === "tr"; // b0, b1, b2, b3, pe, tr
		$is_blunting = in_array($dmg_type, ["br", "mn"]); // br, mn

		$localisation = $localisation === "coeur" && !$is_perforating ? "torse" : $localisation;
		$localisation = $dmg_type === "exp" ? "torse" : $localisation;
		$localisation = $localisation === "oeil" && !$is_perforating ? "visage" : $localisation;
		$result["localisation"] = $localisation;

		$is_member = in_array($localisation, ["bras", "main", "pied", "jambe"]);
		$is_leg = in_array($localisation, ["pied", "jambe"]);
		$is_vital = in_array($localisation, ["coeur", "cou", "crane", "oeil"]);
		$is_head = in_array($localisation, ["crane", "visage", "oeil"]);
		$is_skull = in_array($localisation, ["crane", "oeil"]);
		$is_sensitive = in_array($localisation, ["visage", "org_gen", "crane", "oeil"]);

		// default "std" specific creature category parameters
		$skull_dmg_factor = 4;
		$no_minimal_penetrating_dmg = false;
		$cannot_be_stunned = false;
		$is_hard_to_stun = false;
		$cannot_be_knocked_out = false;
		$can_hardly_fall = false;
		$automatic_death_threshold = -3; // pdvm mult threshold for automatic death
		$pdvm_multiplier_for_rcl = 1;
		$extra_cranial_rd = true;

		// changes for special categories
		if (in_array($category, ["nbh", "nbx"])) {
			//non biological creature – with head reduced sensibility (h) or no head sensibility at all (x)
			$dmg_multipliers = ["br" => 1, "tr" => 1, "pe" => 1, "mn" => 1, "b0" => .5, "b1" => 1, "b2" => 1.5, "b3" => 2, "exp" => 1];
			$is_vital = false;
			$is_sensitive = false;
			$skull_dmg_factor = $category === "nbh" ? 2 : 1;
			$no_minimal_penetrating_dmg = true;
			$cannot_be_stunned = true;
			$cannot_be_knocked_out = true;
			$automatic_death_threshold = 0;
		} elseif ($category === "ins") {
			// Pour les ange ou démon INS, les PdV doubles ne comptent par pour le recul
			$pdvm_multiplier_for_rcl = .5;
		} elseif ($category === "ci") {
			// créature insectoïde
			$is_sensitive = false;
			$skull_dmg_factor = 2;
			$pain_resistance = 1;
			$is_hard_to_stun = true;
			$extra_cranial_rd = false;
			$can_hardly_fall = true;
			$limits = ["bras" => .33, "jambe" => .33, "pied" => .33, "main" => .33];
		}

		// ––– Recul ––––––––––––
		$limited_rcl_raw_dmg = $is_perforating ? min($raw_dmg, ($pdvm + $rd) * ($limits[$localisation] ?? 1)) : $raw_dmg;
		$rcl_dmg = $limited_rcl_raw_dmg * $rcl[$dmg_type];
		if ($is_head) $rcl_dmg *= 1.5;
		$rcl_pdvm = $pdvm * $pdvm_multiplier_for_rcl;
		$rcl_distance = $rcl_dmg / $rcl_pdvm * 3;
		if ($rcl_distance <= 1) $rcl_distance = 0;
		if ($rcl_distance > 2) $rcl_distance = 2 + ($rcl_distance - 2) ** 0.5; // distance > 2 → use square root of distance
		$rcl_fall_modif = DiceManager::getModifier($rcl_dmg * ($is_head ? 3 : 1), 0.8 * $rcl_pdvm);
		if ($can_hardly_fall) $rcl_fall_modif += 5;
		$result["recul"] = floor($rcl_distance * 2) / 2;
		if ($rcl_fall_modif <= 3)  $result["chute"] = !DiceManager::isSuccess($dex + $rcl_fall_modif, $rolls[0]);

		// ––– armor and special bullet types
		$rd = $is_armor_piercing_bullet ? floor($rd / 2) : $rd;
		$rd = $is_hollow_point_bullet ? max($rd * 2, 1) : $rd;

		// ––– effective damages
		$net_dmg = max($raw_dmg - $rd, 0);
		$net_dmg_limit_factor = !($is_vital || $is_head) && $is_perforating ? ($limits[$localisation] ?? 1) : INF;
		$net_dmg = min($net_dmg, $pdvm * $net_dmg_limit_factor);

		$dmg_multiplier = $dmg_multipliers[$dmg_type];
		if ($is_member) $dmg_multiplier = 1;
		if ($is_vital && !$is_bullet) $dmg_multiplier = max($dmg_multiplier * 1.5, 2);
		if ($is_vital && $is_bullet) $dmg_multiplier = max($dmg_multiplier * 2.25, 3);
		if ($is_skull) $dmg_multiplier = $skull_dmg_factor;
		if ($is_armor_piercing_bullet) $dmg_multiplier *= .5;
		if ($is_hollow_point_bullet) $dmg_multiplier *= 2;

		$actual_dmg = $net_dmg * $dmg_multiplier;
		if ($localisation === "crane") {
			$cranial_rd = $extra_cranial_rd ? .2 * $pdvm : 0;
			if ($is_armor_piercing_bullet) $cranial_rd *= 0.5;
			if ($is_hollow_point_bullet) $cranial_rd *= 1.5;
			if ($net_dmg <= $cranial_rd) {
				$actual_dmg = $net_dmg;
			} else {
				$actual_dmg = $cranial_rd + ($net_dmg - $cranial_rd) * $dmg_multiplier;
			}
		}
		if ($rd === 0 && $is_penetrating && !$actual_dmg && !$no_minimal_penetrating_dmg) $actual_dmg = 1;

		$result["dégâts effectifs"] = (int) floor($actual_dmg);
		$pdv -= !$is_member ? $result["dégâts effectifs"] : 0;
		$result["pdv"] = $pdv;

		$is_significant_wound = $actual_dmg >= 0.25 * $pdvm;
		$is_major_wound = $actual_dmg >= 0.5 * $pdvm;
		$is_critical_wound = $actual_dmg >= $pdvm;

		$is_significant_wound_to_member = false;
		$is_incapacitating_wound_to_member = false;
		if ($is_member) {
			$is_significant_wound_to_member = $actual_dmg >= self::members_pdv[$localisation] * $pdvm * .5;
			$is_incapacitating_wound_to_member = $actual_dmg >= self::members_pdv[$localisation] * $pdvm;
		}

		// ––– fall due to high damages
		$severe_hit_to_leg = $is_leg && $is_significant_wound_to_member;
		$incapacitated_leg = $is_leg && $is_incapacitating_wound_to_member;
		$fall_modifier = DiceManager::getModifier($actual_dmg * ($severe_hit_to_leg ? 1.5 : 1), .5 * $pdvm);
		if ($can_hardly_fall) $fall_modifier += 5;
		$general_fall_check = $fall_modifier <= 3 && !DiceManager::isSuccess($san + $fall_modifier, $rolls[1]);
		$result["chute"] = $result["chute"] || $general_fall_check || $incapacitated_leg;

		// ––– stunning
		$stun_level = 0;
		$might_be_stunned = $is_significant_wound || $is_significant_wound_to_member || $is_sensitive || $pain_resistance <= -1 && $actual_dmg > 0;

		if ($might_be_stunned && !$cannot_be_stunned) {

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
			$stun_level += ($is_significant_wound_to_member) ? 1 : 0;
			$stun_level += ($is_incapacitating_wound_to_member) ? 1 : 0; // if this is true, then line before is also true
			$stun_level -= DiceManager::isSuccess($san - 2 * ($stun_level - 1), $rolls[2]) ? 1 : 0;
			$stun_level -= $pain_resistance;
			$stun_level = min($stun_level, 3);
			if ($is_hard_to_stun) $stun_level = min($stun_level, 2);

			switch ($stun_level) {
				case 3:
					$result["sonné"] = "Sonné niv.3.";
					$result["chute"] = true;
					break;

				case 2:
					$duration = max($rolls[2] - $san + 5, 0);
					if ($is_hard_to_stun) $duration = floor($duration / 2);
					$result["sonné"] = "Sonné niv.2 pendant " . $duration + 1 . " action" . ($duration ? "s" : "");
					break;

				case 1:
					$duration = max($rolls[2] - $san, 0);
					if ($is_hard_to_stun) $duration = floor($duration / 2);
					$result["sonné"] = "Sonné niv.1 pendant " . $duration + 1 . " action" . ($duration ? "s" : "");
					break;
			}
		}

		// ––– knock out
		if ($is_head && !$cannot_be_knocked_out) {
			$knock_out_modifier = round(-2 * ($actual_dmg - 1) + ($is_penetrating ? 5 : 0));
			$result["perte de conscience"] = !DiceManager::isSuccess($san + $knock_out_modifier, $rolls[3]);
		}

		// ––– Mort –––––––––––––––––––––––
		// sévèrement blessé : pdv ≤ -100% et dégâts net ≥ 50% | pdv ≤ -150% et dégâts net ≥ 25% | pdv ≤ -200% et dégâts effectis > 0
		$is_severly_wounded = $pdv <= -$pdvm && $is_major_wound || $pdv <= -1.5 * $pdvm && $is_significant_wound || $pdv <= -2 * $pdvm && $actual_dmg;
		$is_automatically_dead = $pdv <= $automatic_death_threshold * $pdvm;

		if ($is_automatically_dead) {
			$result["mort"] = "Le personnage est mort ! 😵";
		} elseif ($localisation === "torse" && $is_severly_wounded) {
			$pdv_death_modifier = 5 * ($pdv / $pdvm + 1); // ex si pdv = -100% : (-1 + 1)*5 = 0
			$dmg_death_modifier = - ($actual_dmg / $pdvm - 0.5) * 5; // ex si dégâts = 50% : -(0.5 - 0.5)*5 = 0
			$death_modifier = (int) round(($pdv_death_modifier + $dmg_death_modifier) / 2);
			$result["mort"] = !DiceManager::isSuccess($san + $death_modifier, $rolls[4]) ? "Mort en " . round($rolls[5] / 2.5) * 5 . " secondes" : false;
		} elseif (($is_vital || $is_head) && $is_significant_wound) {
			$death_modifier = DiceManager::getModifier($actual_dmg, 0.75 * $pdvm);
			$result["mort"] = !DiceManager::isSuccess($san + $death_modifier, $rolls[4]) ? "Mort immédiate ! 😵" : false;
		}

		// ––– special random effects
		$effects_modifier = DiceManager::getModifier($actual_dmg, $pdvm * 0.75);
		if ($is_skull) $effects_modifier -= 3;
		$purely_random_parameter = random_int(0, 1) === 0;
		if ($is_major_wound) $purely_random_parameter = random_int(1, 3) <= 2;
		if ($is_critical_wound) $purely_random_parameter = true;
		if ($localisation === "visage") $purely_random_parameter = random_int(1, 4) <= 3;
		if ($localisation === "visage" && $is_major_wound) $purely_random_parameter = true;

		$has_random_effect = $is_significant_wound && !DiceManager::isSuccess($san + $effects_modifier, $rolls[6]) && $purely_random_parameter && !in_array($category, ["nbh", "nbx"]);

		if ($has_random_effect) {

			if ($localisation === "torse") {
				$effects = [
					0 => "Colonne vertébrale touchée. Le personnage est paraplégique. Cette lésion peut guérir – la traiter comme une blessure invalidante.",
					1 => "Colonne vertébrale touchée. Le personnage est définitivement paraplégique.",
					2 => "Organe vital touché. Mort en quelques heures, sauf intervention chirurgicale réussie ou soins magiques.",
					3 => "Organe vital touché. Mort en quelques minutes, sauf intervention chirurgicale réussie ou soins magiques.",
				];

				if ($is_penetrating) $result["autres effets"] = TableReader::pickResult($effects, !$is_major_wound ? [1, 0, 10, 5] : [1, 1, 5, 10]);
				if ($is_blunting) $result["autres effets"] = TableReader::pickResult($effects, !$is_major_wound ? [2, 0, 2, 1] : [1, 3, 2, 2]);
				if ($dmg_type === "exp") {
					$explosion_gravity = max(floor(-DiceManager::getModifier($actual_dmg * 2, $pdvm) / 2), 1);
					$explosion_effects = "Blessure invalidante aux tympans. Le personnage souffre d’une <i>Surdité partielle</i> de niveau $explosion_gravity.";
					$result["autres effets"] = TableReader::pickResult($effects, !$is_major_wound ? [1, 0, 5, 0] : [1, 1, 8, 5]);
					$result["autres effets"] .= (" " . $explosion_effects);
				}
			}

			if ($localisation === "cou") {
				$effects = [
					0 => "Colonne vertébrale touchée. Le personnage est tétraplégique. Cette lésion peut guérir – la traiter comme une blessure invalidante.",
					1 => "Colonne vertébrale touchée. Le personnage est définitivement tétraplégique.",
					2 => "Le personnage ne peut plus respirer et meurt rapidement.",
					3 => "Le personnage s’étouffe dans son sang. Mort en quelques minutes, sauf intervention chirurgicale réussie ou soins magiques.",
				];

				if ($is_penetrating) $result["autres effets"] = TableReader::pickResult($effects, !$is_major_wound ? [1, 0, 1, 6] : [1, 1, 1, 5]);
				else $result["autres effets"] = TableReader::pickResult($effects, !$is_major_wound ? [2, 0, 4, 0] : [1, 3, 4, 0]);
			}

			if ($is_skull) {
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
				$result["autres effets"] = TableReader::pickResult($effects, !$is_major_wound ? [2, 1, 0, 1, 0, 0, 1, 0] : [3, 3, 1, 3, 1, 1, 3, 1]);
			}

			if ($localisation === "visage") {
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
				$result["autres effets"] = TableReader::pickResult($effects, !$is_major_wound ? [1, 1, 0, 3, 1, 0, 1, 0] : [1, 0, 1, 3, 1, 1, 1, 1]);
			}
		}

		// ––– member damages
		if ($is_member) {
			$result["dégâts membre"] = ucfirst($localisation) . " " . $result["dégâts effectifs"];
			$result["dégâts effectifs"] = 0;
			if ($is_significant_wound_to_member) $result["état membre"] = "membre inutilisable";
			if ($is_incapacitating_wound_to_member) $result["état membre"] = "membre handicapé";
		}

		return $result;
	}

	public static function getBleedingEffects(int $san_test_mr, int $san_test_critical, int $pdvm, int $severity)
	{
		$result = [
			"error" => false,
			"san-test-mr" => $san_test_mr,
			"san-test-critical" => $san_test_critical,
			"pdvm" => $pdvm,
			"pdv-loss" => 0,
			"comment" => ""
		];
		$pdv_loss = [
			[ 0, 0.1, 0.2 ],
			[ 0.1, 0.2, 0.3 ],
			[ 0.2, 0.3, 0.4 ]
		];

		if ($san_test_critical === -1) {
			$result["pdv-loss"] = (int) round($pdv_loss[$severity][2] * $pdvm);
			$result["comment"] = "Échec critique 😖 – Prochains jets de <i>San</i> à -3 supplémentaire jusqu’à réussite.";
		} elseif ($san_test_critical === 1) {
			$result["pdv-loss"] = (int) round($pdv_loss[$severity][0] * $pdvm);
			$result["comment"] = "Succès critique 😎 – L’hémorragie baisse d’un niveau de gravité.";
		} elseif ($san_test_mr < -3) {
			$result["pdv-loss"] = (int) round($pdv_loss[$severity][2] * $pdvm);
		} elseif ($san_test_mr < 0){
			$result["pdv-loss"] = (int) round($pdv_loss[$severity][1] * $pdvm);
		} elseif ($san_test_mr < 2){
			$result["pdv-loss"] = (int) round($pdv_loss[$severity][0] * $pdvm);
		} else {
			$result["pdv-loss"] = (int) round($pdv_loss[$severity][0] * $pdvm);
			$result["comment"] = "+3 aux prochains jets de <i>San</i> jusqu’à échec";
		}

		return $result;
	}
}
