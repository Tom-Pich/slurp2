<?php

namespace App\Entity;

use App\Lib\Define;
use App\Lib\TextParser;
use App\Interface\RulesItem;

abstract class AbstractSpell implements RulesItem
{
	public int $id;
	public string $name;
	public int $niv_min;
	public int $niv_max;
	public string $readableNiv;
	public ?string $class;
	public ?string $duration;
	public ?string $time;
	public ?string $zone;
	public ?string $resistance;
	public string $description;
	public string $origin;
	const cast_time = [[1, 15], [2, 30], [3, 60], [4, 600], [6, 3600]];

	// id Nom Niv Collège Classe Durée Temps Zone Résistance Description Origine

	public function __construct(array $item = [])
	{
		$this->id = $item["id"] ?? 0;
		$this->name = $item["Nom"] ?? "";
		$niv_array = json_decode($item["Niv"] ?? "[]");
		$this->niv_min = $niv_array[0] ?? 0;
		$this->niv_max = $niv_array[1] ?? $this->niv_min;
		$this->readableNiv = $this->niv_min ? TextParser::parseNumbers2Latin($this->niv_min, $this->niv_max) : "";
		$this->class = $item["Classe"] ?? NULL;
		$this->duration = $item["Durée"] ?? NULL;
		$this->time = $item["Temps"] ?? NULL;
		$this->zone = $item["Zone"] ?? NULL;
		$this->resistance = $item["Résistance"] ?? NULL;
		$this->description = $item["Description"] ?? "";
		$this->origin = $item["Origine"] ?? "";
	}

	// generate full HTML for displaying in rules
	// $data contains optionnal display parameters
	//   name: override item name, cost-mult: multiplier for default character point cost
	//   colleges-list or disciplines-list: array with college/discipline names
	public function displayInRules(bool $show_edit_link, string $edit_req, array $data = [], bool $lazy = false): void
	{
		$edit_link_url = sprintf("gestion-listes?req=%s&id=%d", $edit_req, isset($data["power-id"]) ? $data["power-id"] : $this->id);
		$edit_link = $show_edit_link ? "<a href='$edit_link_url' class='edit-link ff-far'>&#xf044;</a>" : "";
		$label = (!empty($data["name"]) ? $data["name"] : $this->name) . " ({$this->readableNiv})";
		$cost_as_power = !empty($data["cost-mult"]) ? $this->displayCost($data["cost-mult"]) : "";
		$colleges_disciplines_list = "";
		if (!empty($data["colleges-list"])){
			$category_name = "Collège" . (count($data["colleges-list"]) > 1 ? "s" : "");
			$colleges_disciplines_list = "<i>{$category_name} :</i> " . join(", ", $data["colleges-list"]);
		}
		elseif (!empty($data["disciplines-list"])){
			$category_name = "Discipline" . (count($data["colleges-list"]) > 1 ? "s" : "");
			$colleges_disciplines_list = "<i>{$category_name} :</i> " . join(", ", $data["disciplines-list"]);
		}
		$description_wrapper_attributes = $lazy ? "data-details data-type='spell' data-id={$this->id}" : "";
		$description = $lazy ? "" : $this->getFullDescription();

		echo <<<HTML
			<details class="liste" data-niv-min="{$this->niv_min}" data-niv-max="{$this->niv_max}" data-origin="{$this->origin}">
				<summary title="id {$this->id}">
					<div>
						<div>$edit_link $label</div>
						<div>$cost_as_power</div>
					</div>
				</summary>
				<div class="mt-½ fs-300">
					$colleges_disciplines_list
				</div>
				<div class="mt-½ fs-300" $description_wrapper_attributes>
					$description
				</div>
			</details>
		HTML;
	}

	public function getFullDescription($custom_time = "")
	{
		$class = $this->class ? "<p class='fw-700'>{$this->class}</p>" : "";
		$description = Define::implementDefinitions($this->description, Define::magic_dictionnary);
		$duration = $this->duration ? "<i>Durée</i> : {$this->duration}<br>" : "";
		$time = "";
		if (empty($custom_time) && $this->time) $time = "<i>Temps nécessaire :</i> {$this->time}<br>";
		elseif (!empty($custom_time)) $time = "<i>Temps :</i> $custom_time<br>";
		$zone = $this->class === "Zone" ? "<i>Zone de base</i> : " . ($this->zone ? $this->zone : "3 m") . "<br>" : "";
		$resistance = $this->resistance ? "<i>Résistance</i> : {$this->resistance}" : "";

		return <<<HTML
			<div class="flow">
			$class
			$description
			</div>
			<div class="mt-½">
				$duration
				$time
				$zone
				$resistance
			</div>
			HTML;
	}

	 // in child class
	public function displayCost() {}

	// return a string with necessary time to cast spell
	// $divider: array of divider to apply foreach power level
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
			if ($value < 1) $time[$index] = "inst.";
			elseif (fmod($value, 60) == 0) $time[$index] = ($value / 60) . " min";
			else $time[$index] = $value . " s";
		}

		if (!empty($time)) $time = join(" / ", $time);
		else $time = $this->time;

		return $time;
	}
}
