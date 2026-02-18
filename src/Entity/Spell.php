<?php

namespace App\Entity;

use App\Entity\AbstractSpell;
use App\Lib\Sorter;
use App\Lib\TextParser;
use App\Repository\SpellRepository;
use App\Repository\CollegeRepository;

class Spell extends AbstractSpell
{
	public array $colleges;
	public array $collegesName;
	const improvisation = [12, 13, 14, 17, 20]; // [12, 14, 17, 20, 25];
	const niv_modifier = [0, -1, -2, -5, -8]; // [0, -2, -5, -8, -13];
	const pdm_cost = [2, 4, 6, 8, 15];
	const cost_as_power = [5, 10, 15, 25, 40];

	public function __construct(array $spell = [])
	{
		parent::__construct($spell);
		$this->colleges = json_decode($spell["Collège"] ?? "[]");
	}

	// return array of colleges name of the spell
	public function collegeNames(): array
	{
		$college_repo = new CollegeRepository;
		$all_colleges_name = $college_repo->getCollegesName();
		$colleges_name = [];
		foreach ($this->colleges as $id) {
			$colleges_name[] = $all_colleges_name[$id];
		}
		return $colleges_name;
	}

	// return a string with character points cost of the spell as power
	public function displayCost(float $mult = 1): string
	{
		$cost_array = [];
		$cost_string = "";
		for ($i = 1; $i <= 5; $i++) {
			if ($i < $this->niv_min || $i > $this->niv_max) {
				$cost_array[] = null;
			} else {
				$cost = (round(self::cost_as_power[$i - 1] * $mult * 2)) / 2;
				$cost_array[] = $cost;
			}
		}
		foreach ($cost_array as $cost) {
			$cost_string .= is_null($cost) ? "" : ($cost . "/");
		}
		$cost_string = trim($cost_string, "/");
		$cost_string .= " pts";
		return $cost_string;
	}

	// process spells in character
	public static function processSpells(array $spells, array $colleges, array $special_traits): array
	{
		$points = 0;
		$magery = $special_traits["magerie"];
		$repo = new SpellRepository;

		$all_spells = [];
		$known_spells = array_filter($spells, fn ($x) => $x["catégorie"] === "sort");
		foreach ($known_spells as $known_spell) {
			$points += $known_spell["points"];
		}

		$spells_score_by_id = [];

		$colleges_pts_by_id = [];
		foreach ($colleges as $college) {
			$colleges_pts_by_id[$college["id"]] = $college["points"];
		}

		foreach ($colleges as $college) {

			$college_spells = $repo->getSpellsByCollege($college["id"]);
			$college_spells = array_filter($college_spells, fn ($spell) => $spell->niv_min <= $magery);

			// creating pseudo spell "Improvisation" for each college
			$impro_spell = new Spell([
				"id" => -$college["id"],
				"Nom" => "<i>Improvisation</i>",
				"Niv" => "[1, 3]",
				"Collège" =>  "[". $college["id"] . "]",
				"Description" => "Tous les sorts de niveau I à III peuvent être improvisés (y compris des sorts ne se trouvant pas dans les règles) sauf les sorts de classe <i>Blocage</i> et les sorts du collège <i>Enchantement</i>.<br> Le temps indiqué suppose un temps «&nbsp;<i>court</i>&nbsp;». Si le temps nécessaire est «&nbsp;<i>long</i>&nbsp;» (". self::cast_time[0][1] . "&nbsp;s, ". self::cast_time[1][1] ."&nbsp;s, ". self::cast_time[2][1]/60 ."&nbsp;min), n’oubliez pas qu’un score supérieur ou égal à 21 réduit le temps nécessaire (voir les règles de magie)."
			]);
			
			if($college["id"] !== 23) $college_spells[] = $impro_spell;

			foreach ($college_spells as $spell_entity) {
				$spell = [];
				$spell_data = array_values(array_filter($known_spells, fn ($x) => $x["id"] === $spell_entity->id))[0] ?? [];
				$spell["id"] = $spell_entity->id;
				$spell["label"] = $spell_entity->name . " (" . $spell_entity->readableNiv . ")";
				$spell["points"] = $spell_data["points"] ?? 0;
				$spell["modif"] = $spell_data["modif"] ?? 0;

				// spell points limitation
				foreach ($colleges_pts_by_id as $id => $pts) {
					if (in_array($id, $spell_entity->colleges)) {
						$spell["colleges-points"][] = $pts;
					}
				}
				$spell["points"] = min(5, max($spell["colleges-points"]), $spell["points"]);

				// process score
				$spell["base_score"] = $college["score"] + $spell["points"] + $spell["modif"];
				if (!$spell["points"]) {
					$spell["base_score"] = min($college["score"], self::improvisation[$magery - 1]) + $spell["modif"];
				}
				$spell["scores"] = [];
				for ($i = 1; $i <= 5; $i++) {
					$spell["scores"][$i] = $spell_entity->niv_min <= $i && $spell_entity->niv_max >= $i && $magery >= $i ?
						$spell["base_score"] + self::niv_modifier[$i - 1] : null;
				}
				$spell["readable_scores"] = array_values(array_filter($spell["scores"], fn ($score) => !empty($score) && $score >= 12));
				$spell["is_castable"] = isset($spell["readable_scores"][0]) && $spell["readable_scores"][0] >= 12 ? true : false;
				$spell["readable_scores"] = implode("/", $spell["readable_scores"]);

				// process cost in PdM
				$spell["costs"] = [];
				for ($i = 1; $i <= 5; $i++) {
					$cost_modifier = (int) max(0, floor(($spell["scores"][$i] - 13) / 2));
					$spell["costs"][$i] = $spell["scores"][$i] >= 12 ? max(0, self::pdm_cost[$i - 1] - $cost_modifier) : null;
					//if ($spell["scores"][$i] < 12)
				}
				$spell["readable_costs"] = array_filter($spell["costs"], fn ($cost) => !is_null($cost));
				$spell["readable_costs"] = implode("/", $spell["readable_costs"]);

				// process time
				$time_dividers = [];
				foreach ($spell["scores"] as $score) {
					if ($score <= 20) {
						$time_dividers[] = 1;
					} else {
						$time_dividers[] = 2 ** (floor(($score - 15) / 5));
					}
				}
				$spell["readable_time"] = $spell_entity->readableTime($time_dividers);

				// add modif to name
				if ($spell["modif"] > 0) {
					$spell["label"] .= ' (+' . $spell["modif"] . ')';
				} elseif ($spell["modif"] < 0) {
					$spell["label"] .= ' (' . $spell["modif"] . ')';
				}

				// rules data
				$spell["data"] = $spell_entity;

				$all_spells[] = $spell;

				// building best score array
				if (!isset($spells_score_by_id[$spell["id"]]) || $spell["base_score"] > $spells_score_by_id[$spell["id"]]) {
					$spells_score_by_id[$spell["id"]] = $spell["base_score"];
				}
			}
		}

		// filtering duplicate spells based on best score
		$all_spells_filtered = [];
		foreach ($all_spells as $spell) {
			if (!in_array($spell, $all_spells_filtered) && $spell["base_score"] === $spells_score_by_id[$spell["id"]]) {
				$all_spells_filtered[] = $spell;
			}
		}

		// separating pseudo-spell "Improvisation" and standard spell for sorting
		$improvised_spells = array_filter($all_spells_filtered, fn($spell) => $spell["id"] < 0);
		$standard_spells = array_filter($all_spells_filtered, fn($spell) => $spell["id"] > 0);
		$standard_spells = Sorter::sort($standard_spells, "label");
		$all_spells_filtered = array_values(array_merge($improvised_spells, $standard_spells));
		// $all_spells_filtered = Sorter::sort($all_spells_filtered, "label");

		return [$all_spells_filtered, $points];
	}

	// process spell edit
	public static function processSubmitSpell($post)
	{
		// id, Nom, Niv, Collège, Classe, Durée, Temps, Zone, Résistance, Description, Origine

		$spell = [];
		$spell["id"] = (int) $post["id"];
		$spell["Nom"] = $post["Nom"];

		$niv = "(" . $post["Niv"] . ")";
		$niv = str_replace(" ", "", $niv);
		$spell["Niv"] = TextParser::parseLatin2Numbers($niv);
		if (!isset($spell["Niv"][0]) || $spell["Niv"][0] < 1 || $spell["Niv"][0] > ($spell["Niv"][1] ?? 5)) {
			$spell["Niv"][0] = 1;
		}
		if (isset($spell["Niv"][1]) && ($spell["Niv"][1] > 5 || $spell["Niv"][1] < $spell["Niv"][0])) {
			$spell["Niv"][1] = 5;
		}
		if (isset($spell["Niv"][1]) && $spell["Niv"][1] === $spell["Niv"][0]) {
			unset($spell["Niv"][1]);
		}
		$spell["Niv"] = json_encode($spell["Niv"], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

		$colleges = explode(",", $post["Collège"]);
		foreach ($colleges as $id) {
			$spell["Collège"][] = (int) $id;
		}
		if (!array_sum($spell["Collège"])) {
			$spell["Collège"] = [22];
		}
		$spell["Collège"] = json_encode($spell["Collège"], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

		foreach (["Classe", "Durée", "Temps", "Zone", "Résistance"] as $entry) {
			$spell[$entry] = $post[$entry] ? $post[$entry] : NULL;
		}

		$spell["Description"] = $post["Description"] ? $post["Description"] : NULL;
		$spell["Origine"] = $post["Origine"] ? $post["Origine"] : NULL;

		$repo = new SpellRepository;

		if ($spell["Nom"] && $spell["id"]) {
			$repo->updateSpell($spell);
		} elseif (!$spell["Nom"] && $spell["id"]) {
			$repo->deleteSpell($spell["id"]);
		} elseif ($spell["Nom"] && !$spell["id"]) {
			$repo->createSpell($spell);
		}
	}
}
