<?php

namespace App\Entity;

use App\Interface\RulesItem;
use App\Lib\Sorter;
use App\Lib\TextParser;
use App\Repository\SpellRepository;
use App\Repository\AvDesavRepository;
use App\Repository\PowerRepository;

class Power implements RulesItem
{
	public int $id;
	public string $origin; // advantage, spell or specific table
	public array $specific = []; // data from specific table
	public mixed $data; // data from spell or avdesav table
	const priest_mult = 0.6;
	const priest_mult_low = 0.4;

	public function __construct(array $power = [])
	{
		$this->id = $power["id"] ?? 0;
		$this->origin = $power["origin"] ?? "";
		foreach ($power as $key => $value) {
			if (!in_array($key, ["id", "origin"])) {
				$this->specific[$key] = $value;
			}
		}
		$type = $this->specific["Type"] ?? $this->origin;
		$id_rdb = $this->specific["id_RdB"] ?? $this->id;
		if ($type &&  $id_rdb) {
			if ($type === "sort") {
				$repo = new SpellRepository;
				$this->data = $repo->getSpell($id_rdb);
			} elseif ($type === "avantage") {
				$repo = new AvDesavRepository;
				$this->data = $repo->getAvdesav($id_rdb);
			}
		}
	}

	public function displayInRules(bool $show_edit_link = false, string $edit_link = null, array $data = [])
	{
		$cost_mult = $this->specific["Mult"] ?? 1;

		if ($this->origin === "sort") {
			$this->data->displayInRules(show_edit_link: $show_edit_link, data: ["name" => "", "cost-mult" => 1, "colleges-list" => []]);
			//
		} elseif ($this->origin === "avantage") {
			$name = $this->data->name . "*";
			$this->data->displayInRules(show_edit_link: $show_edit_link, data: ["name" => "", "cost-mult" => 1]);
		} else {
			$name = $this->specific["Nom"] ? $this->specific["Nom"] : $this->data->name;
			$name .= $this->specific["Type"] === "avantage" ? "*" : "";
			$this->data->displayInRules(show_edit_link: $show_edit_link, edit_link: "gestion-listes?req=pouvoir&id=" . $this->id, data: ["name" => $name, "cost-mult" => $cost_mult]);
		}
	}

	// process power data from character
	public static function processPowers(array $raw_powers, array $raw_attributes, array $modifiers): array
	{
		$points = 0;
		$processed_powers = [];
		$power_repo = new PowerRepository;

		foreach ($raw_powers as $power) {

			$power["data"] = $power_repo->getPower($power["id"], $power["origine"]);

			// score
			if ($power["niv"]) {
				$power["score"] = max($raw_attributes["Int"], 12) + floor($power["points"] / 2) + $modifiers["Int"] + ($power["modif"] ?? 0);
			} else {
				$power["score"] = null;
			}

			// cost
			if ($power["niv"]) {
				$power["cost"] = Spell::cost_as_power[$power["niv"] - 1] * ($power["mult"] ?? 1) * ($power["data"]->specific["Mult"] ?? 1) + $power["points"];
				$points += $power["cost"];
			} else {
				$power["cost"] = $power["points"] * ($power["mult"] ?? 1);
				$points += $power["cost"];
			}

			// label
			$power["label"] = $power["data"]->specific["Nom"] ?? $power["data"]->data->name;

			if ($power["niv"]) {
				$niv_min = $power["data"]->data->niv_min;
				in_array($power["id"], [7, 8]) && $power["origine"] === "ins" ? $niv_min = $power["niv"] : ""; // arme bénite / arme maudite
				$niv_max = $power["niv"];
				$niv_range = TextParser::parseNumbers2Latin($niv_min, $niv_max);

				$power["label"] .= " (" . $niv_range . ")";

				isset($power["modif"]) ? $power["label"] .= " (" . TextParser::parseInt2Modif($power["modif"]) . ")" : "";
			} else {
				$power["label"] .= "*";
			}
			isset($power["notes"]) ? $power["label"] .= " – <span class = \"clr-grey-500\">" . $power["notes"] . "</span>" : "";


			$processed_powers[] = $power;
		}

		$processed_powers = Sorter::sort($processed_powers, "label");

		return [$processed_powers, $points];
	}

	public static function processSubmitPower(array $post)
	{
		// id, id_RdB, Type, Nom, Catégorie, Domaine, Mult, Origine

		$power = [];
		$power["id"] = (int) $post["id"];
		$power["id_RdB"] = (int) $post["id_RdB"];
		$power["Type"] = $post["Type"];
		$power["Nom"] = $post["Nom"] ? $post["Nom"] : NULL;
		$power["Catégorie"] = $post["Catégorie"] ? $post["Catégorie"] : NULL;
		$power["Domaine"] = $post["Domaine"] ? $post["Domaine"] : NULL;
		$power["Mult"] = $post["Mult"] ? (float) $post["Mult"] : NULL;
		$power["Origine"] = $post["Origine"];

		$repo = new PowerRepository;

		if ($power["id_RdB"] && $power["id"]) {
			$repo->updatePower($power);
		} elseif (!$power["id_RdB"] && $power["id"]) {
			$repo->deletePower($power["id"]);
		} elseif ($power["id_RdB"] && !$power["id"]) {
			$repo->createPower($power);
		}
	}
}
