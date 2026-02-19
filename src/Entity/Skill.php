<?php

namespace App\Entity;

use App\Interface\RulesItem;
use App\Lib\Sorter;
use App\Lib\TextParser;
use App\Repository\SkillRepository;

class Skill implements RulesItem
{
	public int $id;
	public string $name;
	public string $category;
	public string $base;
	public string $readableDifficulty;
	public int $difficulty;
	public bool $hasDefault;
	public string $description;

	const skills_groups = [
		"melee" => [18, 22, 24, 25, 28, 31, 40],
		"hand-to-hand" => [21, 22, 32, 33],
		"bow" => [14, 15],
		"throwing" => [34, 36, 37, 38, 47],
		"seduction" => [148, 192, 157],
		"acrobatics-dodging" => [169, 26],
		"survival" => [71, 56],
	];

	const special_skills = [
		// these skills have special default value
		26 => ["min-level" => -3], // Esquive
		200 => ["min-level" => 5], // Langue maternelle
	];

	const mvt_skills = [
		// these skills suffer a double encumbrancy penalty;
		26, // esquive
		58, // course
		59, // escalade
		62, // nage
		68, // saut
		69, // ski
		72, // vol
		169, // acrobatie
		181, // furtivité
		185, // pickpocket
	];

	public function __construct(array $skill = [])
	{
		$this->id = $skill["id"] ?? 0;
		$this->name = $skill["Nom"] ?? "";
		$this->category = $skill["Catégorie"] ?? "";
		$this->base = $skill["Base"] ?? "";
		$this->readableDifficulty = $skill["Difficulté"] ?? "";
		$this->difficulty = $this->parse_difficulty($skill["Difficulté"] ?? "")[0];
		$this->hasDefault = $this->parse_difficulty($skill["Difficulté"] ?? "")[1];
		$this->description = $skill["Description"] ?? "";
	}

	/**
	 * parse_difficulty
	 *
	 * @param  string $expression like -6, (-2) etc
	 * @return array first element: difficulty as negative integer, second element: has default (boolean)
	 */
	private function parse_difficulty(string $expression)
	{
		if (substr($expression, 0, 1) === "-") {
			return [(int) $expression, true];
		}
		return [(int) trim($expression, "()"), false];
	}

	/**
	 * displayType – used in rules display
	 *
	 * @return string readable base/difficulty (e.g. FD(-2))
	 */
	public function displayType()
	{
		return $this->base . $this->readableDifficulty;
	}

	/**
	 * displayInRules – generate full HTML for displaying in rules
	 *
	 * @param  bool $show_edit_link  show/hide link for editing
	 * @param  array $data not used for skills
	 * @param  bool $lazy lazy loading of description
	 * @return void
	 */
	public function displayInRules(bool $show_edit_link = false, string $edit_req = "competence", array $data = [], $lazy = false): void
	{
		$edit_link_url = "gestion-listes?req=$edit_req&id={$this->id}";
		$edit_link = $show_edit_link ? "<a href='$edit_link_url' class='edit-link ff-far'>&#xf044;</a>" : "";
		$type = $this->displayType();
		echo <<<HTML
			<details class="liste">
				<summary>
					<div>
						<div>$edit_link $this->name</div>
						<div>$type</div>
					</div>
				</summary>
				<div class="fs-300 flow">
					$this->description
				</div>
			</details>
		HTML;
	}

	/**
	 * niv2cost – return skill cost according to niv (score - base) and difficulty (-2, -4, -6, -8)
	 *
	 * @param  int $niv – niv of the skill
	 * @param  int $difficulty (-2/-4/-6/-8)
	 * @param  string $base – one or two attributes letters like D, I, SV...
	 * @return float $points
	 */
	public static function niv2cost(int $niv, int $difficulty, string $base): float|int
	{
		$niv_½ = $difficulty / 2; // cheapest level after default
		$niv_c = 4 + $difficulty / 2; // high level threshold
		$x = $niv - $niv_½;
		if ($niv <= $difficulty) return 0;
		if ($niv <= $niv_c) return 2 ** ($x - 1); // ½ - 1 - 2 - 4 - 8
		if ("SKILL_V2") {
			if ($niv > 7) return INF;
			return 8 * ($x - 3);
		}
		if ($base === "I") return 4 * $x - 8; // intellectual skills - high level
		return ($x ** 2 + $x - 4) / 2; // other skills - high level
	}

	/**
	 * processSkills – process an array of raw skills data as in database persos Compétences \
	 *
	 * @param array $skills unprocessed array from database
	 * @param array $raw_attr indexed array with row attributes
	 * @param array $attr indexed array with For, Dex, Int, San, Per Vol
	 * @param array $modifiers index array with all character modifiers entries
	 * @param array $special_traits may contain mémoire infaillible
	 * @return array  [processed skills, skill groups, skills total points, updated character modifiers]
	 */
	public static function processSkills(array $skills, array $raw_attr, array $attr, array $modifiers, array $special_traits): array
	{
		$points = 0;
		$pool = []; // collecting group points
		$attr_match = ["F" => "For", "D" => "Dex", "I" => "Int", "S" => "San", "P" => "Per", "V" => "Vol",];
		$proc_skills = [];
		$skill_repo = new SkillRepository;

		// first loop – get skill properties and base niv
		foreach ($skills as $skill) {

			$skill_entity = $skill_repo->getSkill($skill["id"]);

			// completing direct properties
			$skill["label"] = $skill["label"] ?? $skill_entity->name;
			$skill["entity-base"] = $skill_entity->base;
			$skill["difficulty"] = $skill_entity->difficulty;
			$skill["type"] = $skill_entity->displayType();
			$skill["has-default"] = $skill_entity->hasDefault;
			$skill["description"] = $skill_entity->description;
			$skill["min-niv"] = $skill["difficulty"];

			// min niv exception
			if (isset(self::special_skills[$skill["id"]])) $skill["min-niv"] = self::special_skills[$skill["id"]]["min-level"];

			// default niv
			$skill["niv"] = $skill["niv"] ?? $skill["min-niv"];

			// impossible niv → less then diff/2 or less then min-niv
			if ($skill["niv"] < $skill["difficulty"] / 2 || $skill["niv"] < $skill["min-niv"]) $skill["niv"] = $skill["min-niv"];

			// selecting main skill for each skill groups
			foreach (self::skills_groups as $group => $id_list) {
				// if skill in group
				if (in_array($skill["id"], $id_list) && $skill["niv"] > $skill["min-niv"]) {
					// check if pool needs to be updated – pool like [group => [label, niv, difficulty], ...]
					$update_pool = empty($pool[$group]) // nothing yet
						|| $pool[$group]["niv"] < $skill["niv"] // higher "niv"
						|| $pool[$group]["niv"] === $skill["niv"] && $pool[$group]["difficulty"] > $skill["difficulty"]; // same niv but higher diff
					if ($update_pool) {
						$pool[$group]["label"] = $skill["label"];
						$pool[$group]["niv"] = $skill["niv"];
						$pool[$group]["difficulty"] = $skill["difficulty"];
					}
				}
			}

			// attributes for base value
			$attr_sum = 0;
			$raw_attr_sum = 0;
			$attr_number = 0;
			foreach (str_split($skill["entity-base"]) as $letter) {
				$attr_name = $attr_match[$letter]; // For, Dex, Int...
				$attr_sum += $attr[$attr_name]; // sum of current state attributes
				$raw_attr_sum += $raw_attr[$attr_name]; // sum of unmodified attributes
				$attr_number++;
				// if one attribute is at 0 (very bad condition), then the whole sum must be 0
				if ($attr[$attr_name] === 0) {
					$attr_sum = 0;
					break;
				}
			}

			// skill base
			$skill["base"] = (int) floor($attr_sum / $attr_number);
			$skill["raw-base"] = (int) floor($raw_attr_sum / $attr_number);

			// modifiers (bonus from label, mémoire infaillible, extra encumbrance penalty)
			$skill["modif"] = TextParser::parseModif($skill["label"]); // from label
			$is_mental_very_hard = $skill["difficulty"] === -8 && $skill["entity-base"] === "I"; // mémoire infaillible
			$skill["modif"] += $is_mental_very_hard ? floor($special_traits["mult-memoire-infaillible"] / 2) : 0;
			$is_extra_affected_by_encumbrance = in_array($skill["id"], self::mvt_skills); // extra encumbrance
			$skill["modif"] += $is_extra_affected_by_encumbrance ? $modifiers["Encombrement"] : 0;

			// Background skill
			$is_background_skill = preg_match("/\*/", $skill["label"], $matches);
			$skill["background"] = !!$is_background_skill;

			$proc_skills[] = $skill;
		}

		// second loop – calculate niv with skill group, score and points
		foreach ($proc_skills as $index => $skill) {

			foreach (self::skills_groups as $group => $id_list) {

				if (in_array($skill["id"], $id_list)) {
					if (empty($skill["groups"])) $skill["groups"] = [];
					array_push($skill["groups"], $group);

					if (!empty($pool[$group])) {
						// ignore main skill
						if ($skill["label"] === $pool[$group]["label"]) break;

						// re-evaluate skill min-niv and niv
						$min_modifier = $skill["difficulty"] >= $pool[$group]["difficulty"] ? -2 : -3;
						$skill["min-niv"] = max($pool[$group]["niv"] + $min_modifier, $skill["min-niv"]);
						$skill["min-niv"] = min(5, $skill["min-niv"]);
						$skill["niv"] = max($skill["niv"], $skill["min-niv"]);
					}
				}
			}

			//skill base cost
			$skill["free-points"] = self::niv2cost($skill["min-niv"], $skill["difficulty"], $skill["entity-base"]);
			$skill["nominal-points"] = self::niv2cost($skill["niv"], $skill["difficulty"], $skill["entity-base"]);
			$skill["points"] = $skill["nominal-points"] - $skill["free-points"];

			// skill optionnal speciality
			$speciality_regexp = "/\([^\(]+\s\+(\d)\)/"; // ( .... +d )
			preg_match($speciality_regexp, $skill["label"], $matches);
			$skill["spe-points"] = isset($matches[1]) ? (int)$matches[1] : 0;
			if ($skill["spe-points"] > $skill["points"] || $skill["spe-points"] > 5) {
				$skill["spe-points"] = min($skill["points"], 5);
				$skill["label"] = preg_replace("/ \+\d+/", " +" . $skill["spe-points"], $skill["label"]);
			}
			$skill["points"] += $skill["spe-points"];

			// background skill
			if ($skill["background"]) $skill["points"] /= 2;

			// mémoire infaillible
			if ($skill["entity-base"] === "I" && $skill["difficulty"] > -8) $skill["points"] /= $special_traits["mult-memoire-infaillible"]; // (1, 2 or 4)

			// round point to nearest half up
			$skill["points"] = ceil($skill["points"] * 2) / 2;

			// score
			$skill["score"] = $skill["base"] + $skill["niv"] + $skill["modif"];
			if ($skill["niv"] === $skill["difficulty"] && !$skill["has-default"]) {
				$skill["virtual-score"] = $skill["score"];
				$skill["score"] = "–";
			}
			if ($skill["base"] === 0) $skill["score"] = 0; // if character condition is very bad

			$proc_skills[$index] = $skill;
			$points += $skill["points"];
		}

		$proc_skills = Sorter::sort($proc_skills, "label");

		return [$proc_skills, $pool, $points, $modifiers];
	}

	/** Add + modify skill in rules */
	public static function processSubmitSkill($post)
	{
		// id, Nom, Catégorie, Base, Difficulté, Description
		$skill["id"] = (int) $post["id"];
		$skill["Nom"] = $post["Nom"];
		$skill["Catégorie"] = htmlspecialchars($post["Catégorie"]);
		$skill["Base"] = $post["Base"];
		$skill["Difficulté"] = $post["Difficulté"];
		$skill["Description"] = $post["Description"];

		$repo = new SkillRepository;

		if ($skill["Nom"] && $skill["id"]) {
			$repo->updateSkill($skill);
		} elseif (!$skill["Nom"] && $skill["id"]) {
			$repo->deleteSkill($skill["id"]);
		} elseif ($skill["Nom"] && !$skill["id"]) {
			$repo->createSkill($skill);
		}
	}

	/** Display skill cost in rules */
	public static function displaySkillCost(int $niv, int $difficulty)
	{
		$cost_std = self::niv2cost($niv, $difficulty, "D");
		$cost_int = self::niv2cost($niv, $difficulty, "I");
		if ($cost_std < 0.5) return "–";
		if ($cost_std === .5) return "½";
		if ($cost_std === 1.5) return "1½";
		return $cost_std === $cost_int ? $cost_std : $cost_std . "/" . $cost_int;
	}
}
