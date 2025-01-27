<?php

namespace App\Entity;

use App\Interface\RulesItem;
use App\Lib\Sorter;
use App\Repository\AvDesavRepository;

class AvDesav implements RulesItem
{
	public int $id;
	public string $name;
	public string $category;
	public array $cost;
	public bool $hasNiv;
	public bool $isPower;
	public string $description;
	public float $defaultCost;

	/**
	 * __construct
	 *
	 * @param  array $avdesav as from database
	 * @return void
	 */
	public function __construct(array $avdesav = [])
	{
		$this->id = $avdesav["id"] ?? 0;
		$this->name = $avdesav["Nom"] ?? "";
		$this->category = $avdesav["Catégorie"] ?? "";
		$this->cost = json_decode(($avdesav["Coût"] ?? "[0]"), true);
		$this->hasNiv = !empty($avdesav["Niv"]);
		$this->isPower = !empty($avdesav["Pouvoir"]);
		$this->description = $avdesav["Description"] ?? "";

		if (in_array($this->category, ["Mixtes", "Caractéristiques secondaires"])) {
			$this->defaultCost = 0;
		} elseif ((int) $this->cost[0]) {
			$this->defaultCost = $this->cost[0];
		} else {
			$this->defaultCost = 0;
		}
	}

	/**
	 * displayCost – display cost in rules
	 *
	 * @param  float $mult optionnal multiplier applied to character point
	 * @return string cost of av/desav in readable format
	 */
	public function displayCost(float $mult = 1): string
	{
		if (count($this->cost) === 1 && (int)$this->cost[0]) {
			$displayed_cost = (round($this->cost[0] * $mult * 2)) / 2;
		} elseif (count($this->cost) === 1) {
			$displayed_cost = $this->cost[0];
		} elseif (count($this->cost) == 2) {
			$displayed_cost = (round($this->cost[0] * $mult * 2)) / 2 . "/" . (round($this->cost[1] * $mult * 2)) / 2;
		} else {
			$displayed_cost = (round($this->cost[0] * $mult * 2)) / 2 . " à " . (round($this->cost[1] * $mult * 2)) / 2;
		}

		if ($this->hasNiv) {
			$displayed_cost .= " pts/niv";
		} else {
			$displayed_cost .= " pts";
		}

		if (in_array($displayed_cost, ["1 pts", "1 pts/niv", "-1 pts", "-1 pts/niv", "0 pts"])) {
			$displayed_cost = preg_replace("/pts/", "pt", $displayed_cost);
		}
		if ($displayed_cost === "variable pts") {
			$displayed_cost = "variable";
		}
		return $displayed_cost;
	}

	public function displayCostInEditor(): string
	{
		$editor_cost = "";
		foreach ($this->cost as $index => $cost){
			if($index === 2){
				$editor_cost .= $cost ? "true" : "false"; 
			} else {
				$editor_cost .= ($cost . ", ");
			}
		}
		$editor_cost = trim($editor_cost, ", ");
		return $editor_cost;
	}

	/**
	 * displayInRules – generate full HTML for displaying in rules
	 *
	 * @param  bool $show_edit_link  show/hide link for editing
	 * @param  array $data overriding default name, cost multiplier
	 * @param  bool $lazy lazy loading of description
	 * @return void
	 */
	public function displayInRules(bool $show_edit_link = false, string $edit_req = "avdesav", array $data = ["name" => "", "cost-mult" => 1], bool $lazy = false): void
	{
		$edit_link_url = sprintf("gestion-listes?req=%s&id=%d", $edit_req, isset($data["power-id"] ) ? $data["power-id"]: $this->id );
		$edit_link = $show_edit_link ? "<a href='$edit_link_url' class='edit-link ff-far'>&#xf044;</a>" : "";
		$name = $data["name"] ? $data["name"] : $this->name;
		$cost = $this->displayCost($data["cost-mult"]);
		$description_wrapper_attributes = $lazy ? "data-details data-type='avdesav' data-id='{$this->id}'" : "";
		$description = $lazy ? "" : $this->description;
		echo <<<HTML
			<details class="liste">
				<summary title="id {$this->id}">
					<div>
						<div>$edit_link $name</div>
						<div>$cost</div>
					</div>
				</summary>
				<div class="fs-300 flow" $description_wrapper_attributes>
					$description
				</div>
			</details>
		HTML;
	}

	public static function processAvdesav(array $raw_avdesavs, array $attr_cost_multipliers, array $special_traits, array $attributes, array $points_count): array
	{
		$repo = new AvDesavRepository;
		$points_avdesav = 0;
		$avdesavs = [];

		foreach ($raw_avdesavs as $avdesav) {

			if ($avdesav["id"]) {
				$avdesav_entity = $repo->getAvDesav($avdesav["id"]);
				$avdesav["description"] = $avdesav_entity->description;
				$avdesav["nom"] = $avdesav["nom"] ?? $avdesav_entity->name;
				$avdesav["points"] = $avdesav["points"] ?? $avdesav_entity->defaultCost;
			}

			// default options
			$avdesav["options"] = $avdesav["options"] ?? [];

			// category (for grouping on character sheet)
			if ($avdesav["id"] == 2) {
				$avdesav["catégorie"] = "Réputation";
			} elseif ($avdesav["points"] > 0) {
				$avdesav["catégorie"] = "Avantage";
			} elseif ($avdesav["points"] < -1) {
				$avdesav["catégorie"] = "Désavantage";
			} elseif ($avdesav["points"] === -1) {
				$avdesav["catégorie"] = "Travers";
			} else {
				$avdesav["catégorie"] = "Zéro";
			}

			// special effects on modifiers or special traits
			switch ($avdesav["id"]) {

				case 29: // Réflexes de combat
					$attributes["Réflexes"] += 3;
					$attributes["Sang-Froid"] += 2;
					break;

				case 160: // PdV supp
					$attributes["PdV"] += floor($avdesav['points'] / 5);
					break;

				case 161: // PdF supp
					$attributes["PdF"] += $avdesav['points'] / 2;
					break;

				case 162: // PdM supp
					$attributes["PdM"] += $avdesav['points'] / 2;
					break;

				case 163: // PdE supp
					$attributes["PdE"] += $avdesav['points'] / 2;
					break;

				case 158 : // modif Réflexes
					$attributes["Réflexes"] += $avdesav['points'] / 3;
					break;

				case 159 : // modif Sang-froid
					$attributes["Sang-Froid"] += $avdesav['points'] / 3;
					break;

				case 157: // vitesse
					$attributes["Vitesse"] += $avdesav['points'] / 5;
					break;
				
				case 44: // boiteux
					$attributes["Vitesse"] *= 0.4;
					break;

				case 60: // nanisme
					$attributes["Vitesse"] += -2;
					break;

				case 31: // Résistance à la douleur (pour gérer l’état)
					$special_traits["resistance-douleur"] = 1;
					break;
				
				case 49 : // Douillet (pour gérer l’état)
					$special_traits["resistance-douleur"] = -1;
					break;

				case 25: // Mémoire infaillible
					$special_traits["mult-memoire-infaillible"] = ($avdesav['points'] == 40 ? 4 : 2);
					break;

				case 24: // Magerie
					preg_match('/[Mm]agerie\s*(\d)/', $avdesav["nom"], $matches);
					if (isset($matches[1])) {
						$special_traits["magerie"] = (int) $matches[1];
						if (8 + $special_traits["magerie"] * 2 > $attributes["Int"]) {
							$avdesav["nom"] = "Magerie : intelligence trop basse";
						}
					}
					break;

				case 165: // pack Ange (INS)
					$special_traits["type-perso"] = "ins";
					$attributes["PdV"] += ceil(($attributes["For"] + $attributes["San"]) / 2);
					$attributes["PdF"] += ceil(($attributes["For"] + $attributes["San"]) / 2);
					$attr_cost_multipliers["For"] = 0.5;
					$attr_cost_multipliers["San"] = 0.5;
					$attr_cost_multipliers["Vol"] = 0.5;
					break;

				case 166: // pack Démon (INS)
					$special_traits["type-perso"] = "ins";
					$attributes["PdV"] += ceil(($attributes["For"] + $attributes["San"]) / 2);
					$attributes["PdF"] += ceil(($attributes["For"] + $attributes["San"]) / 2);
					$attr_cost_multipliers["For"] = 0.5;
					$attr_cost_multipliers["San"] = 0.5;
					break;
			}

			// Total points
			$points_avdesav += (float)$avdesav["points"];

			// Formating label for character sheet
			/* $avdesav['label'] = $avdesav['nom'];
			if (in_array("aff_coût", $avdesav['options'])) {
				$avdesav['label'] .= " (" . $avdesav['points'] . ")";
			} */

			$avdesavs[] = $avdesav;
		}

		// updating attributes cost
		foreach ($points_count["attributes"] as $attribute => $points) {
			$points_count["attributes"][$attribute] = $points * $attr_cost_multipliers[$attribute];
		}

		// creating avdesav cost
		$points_count["avdesav"] = $points_avdesav;

		// osrting by name
		$avdesavs = Sorter::sort($avdesavs, "nom");

		return [$avdesavs, $attr_cost_multipliers, $special_traits, $attributes, $points_count];
	}

	/**
	 * processSubmitAvdesav – prepare data for Create/Update/Delete Avdesav
	 *
	 * @param  array $post from avdesav editor
	 * @return void
	 */
	public static function processSubmitAvdesav(array $post): void
	{
		// id Nom Catégorie Coût Niv Pouvoir Description
		$avdesav["id"] = (int) $post["id"];
		$avdesav["Nom"] = $post["Nom"];
		$avdesav["Catégorie"] = $post["Catégorie"];
		$costs = explode(",", $post["Coût"]);
		$avdesav["Coût"][0] = is_numeric($costs[0]) ?  (float) $costs[0] : trim($costs[0]);
		if (isset($costs[1])) {
			$avdesav["Coût"][1] = is_numeric($costs[1]) ?  (float) $costs[1] : $costs[1];
		}
		if (isset($costs[2])) {
			$avdesav["Coût"][2] = !!$costs[2];
		}
		$avdesav["Coût"] = json_encode($avdesav["Coût"], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		$avdesav["Niv"] = isset($post["Niv"]) ? "x" : NULL;
		$avdesav["Pouvoir"] = isset($post["Pouvoir"]) ? "x" : NULL;
		$avdesav["Description"] = $post["Description"];

		$repo = new AvDesavRepository;

		if ($avdesav["Nom"] && $avdesav["id"]) {
			$repo->updateAvdesav($avdesav);
		} elseif (!$avdesav["Nom"] && $avdesav["id"]) {
			$repo->deleteAvdesav($avdesav["id"]);
		} elseif ($avdesav["Nom"] && !$avdesav["id"]) {
			$repo->createAvdesav($avdesav);
		}
	}
}
