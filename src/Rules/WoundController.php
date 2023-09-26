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
		"0.75" => ["description" => "<i>Boiteux</i> ou -3 pour utiliser ce membre"],
	];

	public const members_pdv = [
		"bras" => 0.4,
		"main" => 0.25,
		"jambe" => 0.5,
		"pied" => 0.33,
	];

	public const member_abbreviation = [
		"BD" => ["full-name" =>"bras droit", "member" => "bras"],
		"BG" => ["full-name" =>"bras gauche", "member" => "bras"],
		"MD" => ["full-name" =>"main droite", "member" => "main"],
		"MG" => ["full-name" =>"main gauche", "member" => "main"],
		"JD" => ["full-name" =>"jambe droite", "member" => "jambe"],
		"JG" => ["full-name" =>"jambe gauche", "member" => "jambe"],
		"PD" => ["full-name" =>"pied droit", "member" => "pied"],
		"PG" => ["full-name" =>"pied gauche", "member" => "pied"],
	];

	public static function getGeneralEffects(int $pdv, int $pdvm, bool $has_pain_resistance = false)
	{
		$ratio = $pdv / $pdvm;
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
		$member_pdv = self::members_pdv[$member]*$pdvm ?? self::members_pdv["bras"]*$pdvm;
		$ratio =($member_pdv - $dmg)/$member_pdv;
		if ($has_pain_resistance && $ratio > 0) {
			$ratio += 0.25;
		}
		foreach (self::members_levels as $level => $effects) {
			$level = (float) $level;
			if ($ratio <= $level) {
				return $effects;
			}
		}
		return ["description" => ""];
	}
}