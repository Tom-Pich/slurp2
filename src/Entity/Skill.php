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
	 * @return array first element: difficulty as integer, second element: has default (boolean)
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
	 * @param  string $edit_link to access edit page
	 * @param  array $data optionnal data not used for skills
	 * @return void
	 */
	public function displayInRules(bool $show_edit_link = false, string $edit_link = null, array $data = [])
	{
		$edit_link = $edit_link ?? "gestion-listes?req=competence&id=" . $this->id; ?>

		<details class="liste">
			<summary>
				<div>
					<?php if ($show_edit_link) { ?>
						<a href="<?= $edit_link ?>" class="nude ff-far">&#xf044;</a>
					<?php } ?>
					<?= $this->name ?>
				</div>
				<div><?= $this->displayType() ?></div>
			</summary>
			<?= $this->description ?>
		</details>
<?php
	}

	/**
	 * niv2cost – return skill cost according to niv (score - base) and difficulty (-2, -4, -6, -8)
	 *
	 * @param  int $niv
	 * @param  int $difficulty
	 * @return float $points
	 */
	public static function niv2cost(int $niv, int $difficulty): float
	{
		$x = $niv - 1 - $difficulty / 2;
		if ($niv <= $difficulty) {
			$points = 0;
		} elseif ($niv <= 0) {
			$points = 2 ** $x;
		} else {
			//$points = (int)round(0.499 * $x ** 1.98 + 0.786 * $x + .857);
			$points = (int)round(.5 * ($x + 1) ** 2);
		}

		return (float) $points;
	}

	/**
	 * cost2niv – return skill niv based on $points and $difficulty
	 *
	 * @param  float $points
	 * @param  int $difficulty
	 * @return int
	 */
	public static function cost2niv(float $points, int $difficulty): int
	{
		if ($points < 0.5) {
			$niv = $difficulty;
		} elseif ($points < -$difficulty) {
			$niv = floor(log($points, 2) + 1 + $difficulty / 2);
		} else {
			$niv = floor((2 * floor($points)) ** .5 + $difficulty / 2);
		}
		return (int) $niv;
	}

	/**
	 * processSkills – process an array of raw skills data as in database persos Compétences \
	 *
	 * @param  array $skills unprocessed array from database
	 * @param array $raw_attr indexed array with unmodified attributes
	 * @param array $attr indexed array with For, Dex, Int, San, Per Vol
	 * @param array $modifiers index array with all character modifiers entries 
	 * @return array  [processed skills, skills total points, updated character modifiers]
	 */
	public static function processSkills(array $skills, array $raw_attr, array $attr, array $modifiers, array $special_traits): array
	{
		$points = 0;
		$pool = [];
		$attr_match = ["F" => "For", "D" => "Dex", "I" => "Int", "S" => "San", "P" => "Per", "V" => "Vol",];
		$proc_skills = [];
		$skill_repo = new SkillRepository;

		// first process loop – group bonus can only be processed after a complete first loop
		foreach ($skills as $skill) {

			$skill_entity = $skill_repo->getSkill($skill["id"]);

			// default label
			if (empty($skill["label"])) {
				$skill["label"] = $skill_entity->name;
			}

			// default niv or impossible niv
			if (!isset($skill["niv"]) || $skill["niv"] < $skill_entity->difficulty / 2) {
				$skill["niv"] = $skill_entity->difficulty;
			}
			if ($skill["id"] === 200) { // langue maternelle
				$skill["niv"] = max($skill["niv"], 5);
			}

			// difficulty
			$skill["difficulty"] = $skill_entity->difficulty;

			// skill base value
			$attr_number = 0;
			$attr_sum = 0;
			$raw_attr_sum = 0;
			foreach (str_split($skill_entity->base) as $letter) {
				$attr_sum += $attr[$attr_match[$letter]]; // sum of current state attributes
				$raw_attr_sum += $raw_attr[$attr_match[$letter]]; // sum of un modified attributes
				$attr_number++;
			}
			$skill["base"] = (int) floor($attr_sum / $attr_number);
			$skill["raw-base"] = (int) floor($raw_attr_sum / $attr_number);

			// modifier from label
			$skill["modif"] = TextParser::parseModif($skill["label"]);

			// modifier from "Mémoire infaillible for I-8 skills
			$bonus_memoire_infaillible = $skill_entity->difficulty === -8 && $skill_entity->base === "I" ? floor($special_traits["mult-memoire-infaillible"] / 2) : 0;

			// score
			if ($skill["niv"] === $skill_entity->difficulty && !$skill_entity->hasDefault) {
				$skill["score"] = "–";
				$skill["virtual-score"] = $skill["base"] + $skill["niv"] + $skill["modif"] + $bonus_memoire_infaillible;
			} else {
				$skill["score"] = $skill["base"] + $skill["niv"] + $skill["modif"] + $bonus_memoire_infaillible;
			}

			// processing skill base cost
			$skill["points"] = self::niv2cost($skill["niv"], $skill_entity->difficulty);
			if ($skill_entity->base === "I" && $skill_entity->difficulty > -8) {
				$skill["points"] /= $special_traits["mult-memoire-infaillible"]; // "Mémoire infaillible" divider (1, 2 or 4)
			}
			if ($skill["id"] === 200) { // langue maternelle
				$skill["points"] = self::niv2cost($skill["niv"], $skill_entity->difficulty) - self::niv2cost(5, $skill_entity->difficulty);
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
					$skill["groups"][] = $group;
					if (empty($pool[$group])) {
						$pool[$group] = 0;
					}
					$pool[$group] += $skill["points"];
				}
			}

			// pushing skill in skills array
			$proc_skills[] = $skill;
			$points += $skill["points"];
		}

		// second loop – adding group points and processing retroaction on character
		foreach ($proc_skills as $index => $skill) {

			// if skill belongs to one or more groups
			if (isset($skill["groups"])) {
				$proc_skills[$index]["groups_points"] = 0;
				foreach ($skill["groups"] as $skill_group) {
					$proc_skills[$index]["groups_points"] += $pool[$skill_group]; //min($pool[$skill_group], 8);
				}
				$proc_skills[$index]["total_points"] = $skill["points"] + 0.25 * ($proc_skills[$index]["groups_points"] - $skill["points"]); // min($skill["points"], 8)
				$virtual_niv = self::cost2niv($proc_skills[$index]["total_points"] * (!empty($skill["background"]) ? 2 : 1), $skill["difficulty"]);
				$proc_skills[$index]["group_modif"] = $virtual_niv - $skill["niv"];
				if(is_numeric($proc_skills[$index]["score"])){
					$proc_skills[$index]["score"] += $proc_skills[$index]["group_modif"];
				}
			}

			// special skills retroaction on character modifiers
			if ($skill["id"] === 58) {
				$modifiers["Vitesse"] += ((int) $skill["score"] ?? 0) / 8;
			}
		}

		$proc_skills = Sorter::sort($proc_skills, "label");

		return [$proc_skills, $points, $modifiers];
	}

	public static function processSubmitSkill($post){
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
}
