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
	 * @param  int $niv
	 * @param  int $difficulty
	 * @return float $points
	 */
	public static function niv2cost(int $niv, int $difficulty, string $base): float|int
	{
		$niv_½ = $difficulty / 2;
		$niv_c = 4 + $difficulty / 2; // high level threshold
		$x = $niv - $niv_½;
		if ($niv <= $difficulty) return 0;
		if ($niv <= $niv_c) return 2 ** ($x - 1); // ½ - 1 - 2 - 4 - 8
		if ($base === "I") return 4 * $x - 8; // intellectual skills - high level
		return ($x ** 2 + $x - 4) / 2; // other skills - high level
	}

	/**
	 * cost2niv – return skill niv based on $points and $difficulty
	 *
	 * @param  float $points
	 * @param  int $difficulty
	 * @return int
	 */
	public static function cost2niv(float $points, int $difficulty, string $base): int|float
	{
		if ($points < .5) return $difficulty; // pts = 0
		if ($points <= 8) return floor(log($points, 2) + 1 + $difficulty / 2); // ½ - 1 - 2 - 4 - 8
		if ($base === "I") return floor(($points + 8) / 4) + $difficulty / 2; // intellectual skills - high level
		return floor((-1 + (17 + 8 * $points) ** 0.5) / 2) + $difficulty / 2; // other skills - high level
	}

	/**
	 * processSkills – process an array of raw skills data as in database persos Compétences \
	 *
	 * @param  array $skills unprocessed array from database
	 * @param array $raw_attr indexed array with unmodified attributes
	 * @param array $attr indexed array with For, Dex, Int, San, Per Vol
	 * @param array $modifiers index array with all character modifiers entries 
	 * @param array $special_traits may contain mémoire infaillible
	 * @return array  [processed skills, skills total points, updated character modifiers]
	 */
	public static function processSkills(array $skills, array $raw_attr, array $attr, array $modifiers, array $special_traits): array
	{
		$points = 0;
		$pool = []; // collecting group points
		$attr_match = ["F" => "For", "D" => "Dex", "I" => "Int", "S" => "San", "P" => "Per", "V" => "Vol",];
		$proc_skills = [];
		$skill_repo = new SkillRepository;
		//echo "<pre>"; var_dump($skills); die();

		// first process loop – group bonus can only be processed after a complete first loop
		foreach ($skills as $skill) {

			$skill_entity = $skill_repo->getSkill($skill["id"]);

			// default label
			if (empty($skill["label"])) $skill["label"] = $skill_entity->name;

			// default niv or impossible niv
			if (!isset($skill["niv"]) || $skill["niv"] < $skill_entity->difficulty / 2) $skill["niv"] = $skill_entity->difficulty;

			// skills with default level different from standard defaults.
			if (isset(self::special_skills[$skill["id"]])) {
				$min_level = self::special_skills[$skill["id"]]["min-level"];
				$skill["niv"] = max($skill["niv"], $min_level);
			}

			// difficulty
			$skill["difficulty"] = $skill_entity->difficulty;
			$skill["type"] = $skill_entity->displayType();

			// description
			$skill["description"] = $skill_entity->description;

			// skill base value
			$attr_number = 0;
			$attr_sum = 0;
			$raw_attr_sum = 0;
			foreach (str_split($skill_entity->base) as $letter) {
				$attr_sum += $attr[$attr_match[$letter]]; // sum of current state attributes
				$raw_attr_sum += $raw_attr[$attr_match[$letter]]; // sum of unmodified attributes
				$attr_number++;
			}
			$skill["entity-base"] = $skill_entity->base;
			$skill["base"] = (int) floor($attr_sum / $attr_number);
			$skill["raw-base"] = (int) floor($raw_attr_sum / $attr_number);

			// modifiers (bonus from label, mémoire infaillible, extra encumbrance penalty)
			$skill["modif"] = TextParser::parseModif($skill["label"]); // from label
			$is_mental_very_hard = $skill_entity->difficulty === -8 && $skill_entity->base === "I"; // affected by mémoire infaillible
			$skill["modif"] += $is_mental_very_hard ? floor($special_traits["mult-memoire-infaillible"] / 2) : 0;
			$is_extra_affected_by_encumbrance = in_array($skill["id"], self::mvt_skills);
			$skill["modif"] += $is_extra_affected_by_encumbrance ? $modifiers["Encombrement"] : 0;

			// score
			if ($skill["niv"] === $skill_entity->difficulty && !$skill_entity->hasDefault) {
				$skill["score"] = "–";
				$skill["virtual-score"] = $skill["base"] + $skill["niv"] + $skill["modif"];
			} else {
				$skill["score"] = $skill["base"] + $skill["niv"] + $skill["modif"];
			}

			// processing skill base cost
			$skill["points"] = self::niv2cost($skill["niv"], $skill_entity->difficulty, $skill_entity->base);
			if ($skill_entity->base === "I" && $skill_entity->difficulty > -8) {
				$skill["points"] /= $special_traits["mult-memoire-infaillible"]; // "Mémoire infaillible" divider (1, 2 or 4)
			}

			// skills with min level different from standard default
			if (isset(self::special_skills[$skill["id"]])) {
				$min_level = self::special_skills[$skill["id"]]["min-level"];
				$skill["points"] = self::niv2cost($skill["niv"], $skill_entity->difficulty, $skill_entity->base) - self::niv2cost($min_level, $skill_entity->difficulty, $skill_entity->base);
			}

			// processing skill speciality bonus (with limits)
			$speciality_regexp = "/\([^\(]+\s\+(\d)\)/"; // ( .... +d )
			preg_match($speciality_regexp, $skill["label"], $matches);
			if (isset($matches[1])) {
				$skill["spe_bonus"] = (int)$matches[1];
			} else {
				$skill["spe_bonus"] = 0;
			}
			if ($skill["spe_bonus"] > $skill["points"] || $skill["spe_bonus"] > 5) {
				$skill["spe_bonus"] = min($skill["points"], 5);
				$skill["label"] = preg_replace("/ \+\d+/", " +" . $skill["spe_bonus"], $skill["label"]);
			}
			$skill["points"] += $skill["spe_bonus"];

			// background skill
			$background_skill_regexp = "/\*/";
			$is_background_skill = preg_match($background_skill_regexp, $skill["label"], $matches);
			if ($is_background_skill) {
				$skill["background"] = !!$is_background_skill;
				$skill["points"] /= 2;
			}

			// adding skill points to relevant group(s)
			foreach (self::skills_groups as $group => $id_list) {
				if (in_array($skill["id"], $id_list)) {
					$skill["groups"][$group] = 0;
					if (empty($pool[$group])) $pool[$group] = 0;
					$pool[$group] += $skill["points"];
				}
			}

			// pushing skill in skills array
			$proc_skills[] = $skill;
			$points += $skill["points"];
		}

		//var_dump($pool);

		// second loop – adding group points and processing retroaction on character
		foreach ($proc_skills as $index => $skill) {

			// if skill belongs to one or more groups
			if (isset($skill["groups"])) {

				// update skill group points
				// $pool like  ["acrobatics-dodging" => 0, "hand-to-hand" => 2,  "melee" => 10]
				// $skill["groups"] like ["hand-to-hand" => 0,  "melee" => 0] – all values are 0
				foreach ($skill["groups"] as $group => $group_points) $skill["groups"][$group] = $pool[$group];

				// get free points due to default non standard skill level
				$free_points = 0;
				if (isset(self::special_skills[$skill["id"]])) {
					$min_level = self::special_skills[$skill["id"]]["min-level"];
					$free_points = self::niv2cost($min_level, $skill["difficulty"], $skill["entity-base"]);
				}

				// calculate total virtual points (base points + group points)
				$virtual_points = $skill["points"] + $free_points;
				foreach ($skill["groups"] as $group => $group_points) $virtual_points += 0.25 * ($group_points - $skill["points"]);
				$skill["total_points"] = $virtual_points;
				$virtual_points *= (!empty($skill["background"]) ? 2 : 1);
				$virtual_niv = self::cost2niv($virtual_points, $skill["difficulty"], $skill["entity-base"]);

				// get the group modif from the difference between this virtual niv and the actual raw niv
				$skill["group_modif"] = $virtual_niv - $skill["niv"];

				// update skill score
				if (is_numeric($skill["score"])) $skill["score"] += $skill["group_modif"];
			}

			// special skills retroaction on character modifiers
			if ($skill["id"] === 58) $modifiers["Vitesse"] += ((int) $skill["score"] ?? 0) / 8; // Courses

			$proc_skills[$index] = $skill;
		}

		$proc_skills = Sorter::sort($proc_skills, "label");

		return [$proc_skills, $points, $modifiers];
	}

	public static function processSubmitSkill($post)
	{
		// id, Nom, Catégorie, Base, Difficulté, Description
		$skill["id"] = (int) $post["id"];
		$skill["Nom"] = $post["Nom"];
		$skill["Catégorie"] = $post["Catégorie"];
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

	/** 
	 * Display skill cost in rules
	 */
	public static function displaySkillCost(int $niv, int $difficulty)
	{
		$cost_std = self::niv2cost($niv, $difficulty, "D");
		$cost_int = self::niv2cost($niv, $difficulty, "I");
		if ($cost_std < 0.5) return "–";
		if ($cost_std === .5) return "½";
		return $cost_std === $cost_int ? $cost_std : $cost_std . "/" . $cost_int;
	}
}
