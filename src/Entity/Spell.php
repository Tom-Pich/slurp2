<?php

namespace App\Entity;

use App\Interface\RulesItem;
use App\Lib\Define;
use App\Lib\Sorter;
use App\Lib\TextParser;
use App\Repository\SpellRepository;
use App\Repository\CollegeRepository;

class Spell implements RulesItem
{
	public int $id;
	public string $name;
	public int $niv_min;
	public int $niv_max;
	public string $readableNiv;
	public array $colleges;
	public array $collegesName;
	public ?string $class;
	public ?string $duration;
	public ?string $time;
	public ?string $zone;
	public ?string $resistance;
	public string $description;
	public string $origin;
	const cast_time = [[1, 15], [2, 30], [3, 60], [4, 600], [6, 3600]];
	const improvisation = [12, 14, 17, 20, 25];
	const niv_modifier = [0, -2, -5, -8, -13];
	const pdm_cost = [2, 4, 6, 8, 15];
	const cost_as_power = [5, 10, 15, 25, 40];

	// id Nom Niv Collège Classe Durée Temps Zone Résistance Description Origine

	public function __construct(array $spell = [])
	{
		$this->id = $spell["id"] ?? 0;
		$this->name = $spell["Nom"] ?? "";
		$niv_array = json_decode($spell["Niv"] ?? "[]");
		$this->niv_min = $niv_array[0] ?? 0;
		$this->niv_max = $niv_array[1] ?? $this->niv_min;
		$this->readableNiv = $this->niv_min ? TextParser::parseNumbers2Latin($this->niv_min, $this->niv_max) : "";
		$this->colleges = json_decode($spell["Collège"] ?? "[]");
		$this->class = $spell["Classe"] ?? NULL;
		$this->duration = $spell["Durée"] ?? NULL;
		$this->time = $spell["Temps"] ?? NULL;
		$this->zone = $spell["Zone"] ?? NULL;
		$this->resistance = $spell["Résistance"] ?? NULL;
		$this->description = $spell["Description"] ?? "";
		$this->origin = $spell["Origine"] ?? "";
	}

	/**
	 * getComplementaryData – initializes collegesName and readableTime \
	 * Time consuming for big list, better to be used only when needed
	 *
	 * @return void
	 */
	public function getComplementaryData()
	{
		$this->collegesName = $this->collegesName();
	}

	/**
	 * displayTime – return a string with necessary time to cast spell
	 * @param $divider array of divider to apply foreach power level
	 *
	 * @return string
	 */
	public function readableTime($dividers = [1, 1, 1, 1, 1]): string
	{
		$time = [];

		if (empty($this->time)) {
			for ($i = 1; $i <= 5; $i++) {
				$time[] =  $i < $this->niv_min || $i > $this->niv_max ? null : self::cast_time[$i - 1][0] / $dividers[$i - 1];
			}
		} elseif ($this->time === "long") {
			for ($i = 1; $i <= 5; $i++) {
				$time[] =  $i < $this->niv_min || $i > $this->niv_max ? null : self::cast_time[$i - 1][1] / $dividers[$i - 1];
			}
		}

		$time = array_filter($time, fn ($x) => !is_null($x));
		foreach ($time as $index => $value) {
			if ($value < 1) {
				$time[$index] = "inst.";
			} elseif (fmod($value, 60) == 0) {
				$time[$index] = ($value / 60) . "min";
			} else {
				$time[$index] = $value . "s";
			}
		}
		if (!empty($time)) {
			$time = join(" / ", $time);
		} else {
			$time = $this->time;
		}

		return $time;
	}

	/**
	 * collegesName – return array of colleges name of the spell
	 *
	 * @return array
	 */
	private function collegesName(): array
	{
		$college_repo = new CollegeRepository;
		$all_colleges_name = $college_repo->getCollegesName();
		$colleges_name = [];
		foreach ($this->colleges as $id) {
			$colleges_name[] = $all_colleges_name[$id];
		}
		return $colleges_name;
	}

	/**
	 * displayCost – return a string with cost of the spell as power
	 *
	 * @param  float $mult optional
	 * @return string
	 */
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

	/**
	 * displayInRules – generate full HTML for displaying in rules
	 *
	 * @param  int $session_status if 3, display link for editing
	 * @param array $colleges_name [id => name] – faster way to get college name than using $this->collegesName for long list
	 * @param float $costMultiplier for spells as powers. If 0 : cost will not be displayed.
	 * @param string $name overriding spell default name
	 * @param string $edit_link link formation to access edit page
	 * @return void
	 */
	public function displayInRules(bool $show_edit_link = false, string $edit_link = null, array $data = ["name" => "", "cost-mult" => 0, "colleges-list" => []])
	{
		$edit_link = $edit_link ?? "gestion-listes?req=sort&id=" . $this->id ?>
		<details class="liste" data-niv-min="<?= $this->niv_min ?>" data-niv-max="<?= $this->niv_max ?>" data-origin="<?= $this->origin ?>">
			<summary title="id <?= $this->id ?>">
				<div>
					<?php if ($show_edit_link) { ?>
						<a href="<?= $edit_link ?>" class="edit-link ff-far">&#xf044;</a>
					<?php } ?>
					<?= $data["name"] ? $data["name"] : $this->name ?> (<?= $this->readableNiv ?>) <?= !empty($this->class) ? " – <i>$this->class</i>" : "" ?>
				</div>
				<div>
					<?= $data["cost-mult"] ? $this->displayCost($data["cost-mult"]) : "" ?>
				</div>
			</summary>

			<div class="mt-½">
				<?php if (!empty($data["colleges-list"])) {
					$spell_colleges_names = [];
					foreach ($this->colleges as $id_college) {
						$spell_colleges_names[] = $data["colleges-list"][$id_college];
					}
					$spell_colleges_names = join(", ", $spell_colleges_names); ?>
					<i>Collège(s)&nbsp;: </i><?= $spell_colleges_names ?>
				<?php } ?>
			</div>

			<?php $this->displayFullDescription() ?>

		</details>
	<?php }

	/**
	 * displayFullDescription – generate HTML for full description of spell \
	 * (class, description, duration...)
	 *
	 * @param  string $custom_time optional. Replace spell default time.
	 * @return void
	 */
	public function displayFullDescription($custom_time = "")
	{ ?>
		<div class="mt-½">
			<?= $this->class ? "<b>" . $this->class . " – </b>" : "" ?>
			<?= Define::implementDefinitions($this->description, Define::magic_dictionnary) ?>
		</div>
		<div class="mt-½">
			<?php if ($this->duration) { ?> <i>Durée</i>&nbsp;: <?= $this->duration ?><br>
			<?php }
			if (empty($custom_time) && $this->time) { ?>
				<i>Temps nécessaire</i>&nbsp;: <?= $this->time ?><br>
			<?php } elseif (!empty($custom_time)) { ?>
				<i>Temps&nbsp;:</i> <?= $custom_time ?><br>
			<?php }
			if ($this->class==="Zone") { ?> <i>Zone de base</i>&nbsp;: <?= $this->zone ? $this->zone : "3&nbsp;m" ?><br>
			<?php }
			if ($this->resistance) { ?><i>Résistance</i>&nbsp;: <?= $this->resistance ?>
			<?php } ?>
		</div>
<?php }

	/**
	 * processSpells
	 *
	 * @param  array $spells raw known spells from database (may includes colleges)
	 * @param  array $colleges processed colleges known by character
	 * @param  array $special_traits contains magery level
	 * @return array list of all spells (known or improvised) available to the character, with all processed data
	 */
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
