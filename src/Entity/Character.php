<?php

namespace App\Entity;

use App\Lib\TextParser;
use App\Rules\WoundController;
use App\Rules\StressController;
use App\Rules\FatigueController;
use App\Repository\GroupRepository;
use App\Repository\PowerRepository;
use App\Rules\EncumbranceController;
use App\Rules\MentalHealthController;
use App\Controller\Error404Controller;
use App\Repository\CharacterRepository;
use App\Repository\EquipmentRepository;

ini_set('xdebug.var_display_max_depth', 10);
ini_set("xdebug.var_display_max_data", -1);

class Character
{
	public int $id;
	public int $id_player;
	public int $id_group;
	public int $id_gm;
	public string $name;
	public string $status;
	public int $points;
	public ?array $state;
	public array $pdxm;
	public ?string $description;
	public string $portrait;

	// only available after processing character data
	public array $raw_attributes;
	public array $attributes;
	public array $points_count;
	public array $modifiers;
	public array $attr_cost_multipliers;
	public array $special_traits;
	public array $avdesav;
	public array $skills;
	public array $colleges;
	public array $spells;
	public array $powers;
	public array $disciplines;
	public array $psi;
	public array $group_members;
	public array $equipment;
	public float $carried_weight;
	public ?string $notes;
	public ?string $background;


	public function __construct(int $id)
	{
		$repo = new CharacterRepository;

		$bd_data = $repo->getCharacterRef($id); // id, id_joueur, id_groupe, Nom, Statut, Pts, État, Calculs, Description, Portrait

		if (!empty($bd_data)) {
			$this->id = $bd_data["id"];
			$this->id_player = $bd_data["id_joueur"];
			$this->id_group = $bd_data["id_groupe"];
			$this->name = $bd_data["Nom"];
			$this->status = $bd_data["Statut"];
			$this->points = $bd_data["Pts"];
			$this->description = $bd_data["Description"];
			$this->portrait = "assets/character-portraits/" . (empty($bd_data["Portrait"]) ? "_default.png" : $bd_data["Portrait"]);
			$this->state = json_decode($bd_data["État"], true);
			$this->pdxm = json_decode($bd_data["Calculs"], true);

			if ($this->id_group === 100) {
				$this->id_gm = 0;
			} elseif ($this->id_group > 100) {
				$this->id_gm = $this->id_group - 100;
			} else {
				$this->id_gm = (new GroupRepository)->getGroup($this->id_group)->id_gm ?? 0;
			}
		}
	}

	/**
	 * checkClearance \
	 * return True if \
	 * (1) character exists, \
	 * (2) request made by character owner or admin
	 * (3) request made by group owner
	 * @return bool
	 */
	public function checkClearance(): bool
	{
		if (empty($this->id)) {
			(new Error404Controller)->show();
			die();
		}

		$is_admin = $_SESSION["Statut"] === 3;
		$is_character_owner = $this->id_player === $_SESSION["id"];
		$is_group_owner = $_SESSION["Statut"] === 2 && $_SESSION["id"] === $this->id_gm;
		$is_test_character = $_SESSION["Statut"] === 2 && $this->id_gm === 100;

		$has_clearance = $is_admin || $is_character_owner || $is_group_owner || $is_test_character;
		return $has_clearance;
	}

	public function processCharacter(bool $with_state_modifiers = true)
	{
		// raw_data : id*, id_joueur*, id_groupe*, Nom*, Statut*, Pts*,
		// Caractéristiques**, État, Calculs, MPP**, Avdesav**, Compétences**, Sorts, Pouvoirs, Psi,
		// Description*, Background, Notes, Portrait*

		$repo = new CharacterRepository;

		// ––– Default modifiers and cost multipliers
		$this->modifiers = [
			"For" => 0, "Dex" => 0, "Int" => 0, "San" => 0, "Per" => 0, "Vol" => 0,
			"Dégâts" => 0, "Réflexes" => 0, "Sang-Froid" => 0, "Vitesse" => 0,
			"PdV" => 0, "PdF" => 0, "PdM" => 0, "PdE" => 0,
			"Magie" => 0,
			"For-mult" => 1, "Vitesse-mult" => 1,
			"Encombrement" => 0,
		];
		$this->attr_cost_multipliers = [
			"For" => 1, "Dex" => 1, "Int" => 1, "San" => 1, "Per" => 1, "Vol" => 1,
		];
		$this->special_traits = [
			"type-perso" => "",
			"magerie" => null,
			"pouvoirs" => false,
			"psi" => false,
			"resistance-douleur" => 0,
			"mult-memoire-infaillible" => 1,
		];

		// ––– raw data from database
		$raw_data = $repo->getCharacterRawData($this->id);

		// ––– attributes
		$this->raw_attributes = json_decode($raw_data["Caractéristiques"], true);
		[$this->attributes, $this->points_count["attributes"]] = Attribute::processAttributes($this->raw_attributes);

		// ––– MPP
		$raw_mpp = json_decode($raw_data["MPP"], true);
		$this->special_traits["pouvoirs"] = in_array("pouvoirs", $raw_mpp);
		$this->special_traits["psi"] = in_array("psi", $raw_mpp);

		// –––– avdesav
		$raw_avdesav = json_decode($raw_data["Avdesav"], true);
		[$this->avdesav, $this->attr_cost_multipliers, $this->special_traits, $this->attributes, $this->points_count] = AvDesav::processAvdesav($raw_avdesav, $this->attr_cost_multipliers, $this->special_traits, $this->attributes, $this->points_count);
		$this->raw_attributes = $this->attributes;

		// --- PdXm with modifiers
		$this->attributes["PdV"] += $this->modifiers["PdV"];
		$this->attributes["PdF"] += $this->modifiers["PdF"];
		$this->attributes["PdM"] += $this->modifiers["PdM"];
		$this->attributes["PdE"] += $this->modifiers["PdE"];

		// updating Calculs in DB
		$stored_calculs = json_decode($raw_data["Calculs"], true);
		$calculs = ["PdVm" => $this->attributes["PdV"], "PdFm" => $this->attributes["PdF"], "PdMm" => $this->attributes["PdM"], "PdEm" => $this->attributes["PdE"]];
		$PdXm_has_changed = $stored_calculs != $calculs;
		if ($PdXm_has_changed) {
			$calculs_data = [
				"id" => $this->id,
				"Calculs" => json_encode($calculs, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
			];
			$repo->updateCharacterPdX($calculs_data);
		}

		// ––– state : For_global, For_deg, Dex, Int, Magie, PdV, PdF, (PdM), PdE, Stress, Membres, Autres + [ San, Per, Vol, Réflexes, Sang-Froid ]

		// default value for state
		$this->state["PdV"] = $this->state["PdV"] ?? $this->attributes["PdV"];
		$this->state["PdF"] = $this->state["PdF"] ?? $this->attributes["PdF"];
		$this->state["PdM"] = $this->state["PdM"] ?? $this->attributes["PdM"];
		$this->state["PdE"] = $this->state["PdE"] ?? $this->attributes["PdE"];
		$this->state["Membres"] = $this->state["Membres"] ?? [];
		$this->state["Autres"] = $this->state["Autres"] ?? [];

		$this->carried_weight = round(Equipment::getCarriedWeight($this->id), 1);

		if ($with_state_modifiers) {
			$this->state["Blessures"] = WoundController::getGeneralEffects($this->state["PdV"], $this->attributes["PdV"], $this->special_traits["resistance-douleur"]);
			$this->state["Stress"] = StressController::getEffects($this->state["Stress"] ?? 0);
			if ($this->state["Stress"]["sf-modifier"] !== 0) {
				$this->state["PdF"] = $this->attributes["PdF"];
			}
			$this->state["Fatigue"] = FatigueController::getEffects($this->state["PdF"], $this->attributes["PdF"]);
			$this->state["Santé-mentale"] = MentalHealthController::getEffects($this->state["PdE"], $this->attributes["PdE"]);

			if (!empty($this->state["Membres"])) {
				$this->state["Membres"] = TextParser::parsePseudoArray2Array($this->state["Membres"]);
				$explicit_damages = [];
				foreach ($this->state["Membres"] as $member => $damage) {
					$explicit_damages[] = "<b>Blessures " . WoundController::member_abbreviation[$member]["full-name"] . " ($damage)</b>&nbsp;: " . WoundController::getMemberEffects($damage, $this->attributes["PdV"], WoundController::member_abbreviation[$member]["member"], $this->special_traits["resistance-douleur"])["description"];
				}
				$this->state["Membres"] = $explicit_damages;
			}
			if (!empty($this->state["Autres"])) {
				//$this->state["Autres"] = explode("\r\n", TextParser::pseudoMDParser($this->state["Autres"]));
				$this->state["Autres"] = explode(PHP_EOL, $this->state["Autres"]);
				$this->state["Autres"] = array_map(fn($x) => TextParser::pseudoMDParser($x), $this->state["Autres"] );
			}

			foreach ([$this->state["Blessures"], $this->state["Fatigue"], $this->state["Stress"], $this->state["Santé-mentale"]] as $state) {
				$this->modifiers["For-mult"] *= $state["for-multiplier"] ?? 1;
				$this->modifiers["Dex"] += $state["dex-modifier"] ?? 0;
				$this->modifiers["Int"] += $state["int-modifier"] ?? 0;
				$this->modifiers["San"] += $state["san-modifier"] ?? 0;
				$this->modifiers["Per"] += $state["per-modifier"] ?? 0;
				$this->modifiers["Vol"] += $state["vol-modifier"] ?? 0;
				$this->modifiers["Réflexes"] += $state["ref-modifier"] ?? 0;
				$this->modifiers["Sang-Froid"] += $state["sf-modifier"] ?? 0;
				$this->modifiers["Vitesse-mult"] *= $state["vit-multiplier"] ?? 1;
			}

			// direct state modifiers
			$this->modifiers["For"] += $this->state["For_global"] ?? 0;
			$this->modifiers["Dex"] += $this->state["Dex"] ?? 0;
			$this->modifiers["Int"] += $this->state["Int"] ?? 0;
			$this->modifiers["San"] += $this->state["San"] ?? 0;
			$this->modifiers["Per"] += $this->state["Per"] ?? 0;
			$this->modifiers["Vol"] += $this->state["Vol"] ?? 0;
			$this->modifiers["Dégâts"] += $this->state["For_deg"] ?? 0;
			$this->modifiers["Réflexes"] += $this->state["Réflexes"] ?? 0;
			$this->modifiers["Sang-Froid"] += $this->state["Sang-Froid"] ?? 0;
			$this->modifiers["Magie"] += $this->state["Magie"] ?? 0;

			// evaluating strength to get encumbrance effect
			$this->attributes["For"] *= $this->modifiers["For-mult"]; // first multiplier, than modifier (magic)
			$this->attributes["For"] += $this->modifiers["For"];
			$this->attributes["For"] = (int) $this->attributes["For"];

			// encumbrance level with actual Strength
			$this->state["Encombrement"] = EncumbranceController::getEffects($this->carried_weight, $this->attributes["For"]);
			$this->modifiers["Dex"] += $this->state["Encombrement"]["dex-modifier"];
			$this->modifiers["Vitesse-mult"] *= $this->state["Encombrement"]["vit-multiplier"];
			$this->modifiers["Vitesse-mult"] = $this->modifiers["Vitesse-mult"];
			$this->modifiers["Encombrement"] = $this->state["Encombrement"]["dex-modifier"];

			// reflexes and sf modifers based on primary attributes (vitesse is independant)
			$this->modifiers["Réflexes"] += (int) floor($this->modifiers["Dex"] / 2 + $this->modifiers["Per"] / 2);
			$this->modifiers["Sang-Froid"] += (int) floor($this->modifiers["San"] / 2 + $this->modifiers["Vol"] / 2);

			// updating attributes values
			$this->attributes["Dex"] += $this->modifiers["Dex"];
			$this->attributes["Int"] += $this->modifiers["Int"];
			$this->attributes["San"] += $this->modifiers["San"];
			$this->attributes["Per"] += $this->modifiers["Per"];
			$this->attributes["Vol"] += $this->modifiers["Vol"];
			$this->attributes["Dégâts"] = Attribute::getDamages( max($this->attributes["For"] + $this->modifiers["Dégâts"], 0) );
			$this->attributes["Réflexes"] += $this->modifiers["Réflexes"];
			$this->attributes["Sang-Froid"] += $this->modifiers["Sang-Froid"];
			$this->attributes["Vitesse"] += $this->modifiers["Vitesse"]; // first modifier (avdesav, skills), than multiplier
			$this->attributes["Vitesse"] *= $this->modifiers["Vitesse-mult"];

			// preventing negative attributes value
			foreach(["For", "Dex", "Int", "San", "Per", "Vol", "Réflexes", "Sang-Froid", "Vitesse"] as $attr_name){
				$this->attributes[$attr_name] = max($this->attributes[$attr_name], 0);
			}
		}

		// ––– skills
		$raw_skills = json_decode($raw_data["Compétences"], true);
		[$this->skills, $this->points_count["skills"], $this->modifiers] = Skill::processSkills($raw_skills, $this->raw_attributes, $this->attributes, $this->modifiers, $this->special_traits);

		// ––– colleges & spells
		$raw_colleges_spells = json_decode($raw_data["Sorts"], true);
		[$this->colleges, $this->points_count["colleges"]] = College::processColleges($raw_colleges_spells, $this->attributes, $this->modifiers, $this->special_traits);
		[$this->spells, $this->points_count["spells"]] = Spell::processSpells($raw_colleges_spells, $this->colleges, $this->special_traits);

		// --- powers
		$raw_powers = json_decode($raw_data["Pouvoirs"], true);
		[$this->powers, $this->points_count["powers"]] = Power::processPowers($raw_powers, $this->raw_attributes, $this->modifiers);

		// ––– psi
		$raw_psis = json_decode($raw_data["Psi"], true);
		[$this->disciplines, $this->points_count["disciplines"]] = Discipline::processDisciplines($raw_psis);
		[$this->psi, $this->points_count["psi"]] = PsiPower::processPowers($raw_psis, $this->disciplines, $this->attributes);

		// ––– pquipment
		$equipment_repo = new EquipmentRepository;
		$raw_equipment = $equipment_repo->getCharacterEquipment($this->id);
		[$this->equipment, $this->state] = Equipment::processEquipmentList($raw_equipment, $this->state);

		// ––– notes & background
		$this->notes = $raw_data["Notes"];
		$this->background = $raw_data["Background"];

		// ––– Points count
		$this->points_count["attributes"]["total"] = 0;
		foreach ($this->points_count["attributes"] as $points) {
			$this->points_count["attributes"]["total"] += $points;
		}
		$this->points_count["total"] = $this->points_count["attributes"]["total"] + $this->points_count["avdesav"] + $this->points_count["skills"] + ($this->points_count["colleges"] ?? 0) + ($this->points_count["spells"] ?? 0) + ($this->points_count["powers"] ?? 0) + ($this->points_count["disciplines"] ?? 0) + ($this->points_count["psi"] ?? 0);

		// ––– Group members
		$this->group_members = [];
		if ($this->id_group < 100) {
			$ids = $repo->getCharactersFromGroup($this->id_group);
			foreach ($ids as $id) {
				if ($id !== $this->id) {
					$this->group_members[] = new Character($id);
				}
			}
		}
	}

	public static function createCharacter(array $post): void
	{
		$kit_base = isset($post["kit_base"]);
		$kit_combattant = isset($post["kit_combattant"]);
		$kit_magicien = isset($post["kit_magicien"]);
		$kit_ange = isset($post["kit_ange"]);
		$kit_demon = isset($post["kit_demon"]);

		// Valeurs par défaut
		$character = [
			"id_joueur" => (int) $post["createur"],
			"id_groupe" => 100,
			"Nom" => "Nouveau perso",
			"Statut" => "Création",
			"Pts" => 120,
			"Caractéristiques" => ["For" => 10, "Dex" => 10, "Int" => 10, "San" => 10, "Per" => 10, "Vol" => 10],
			"État" => "{}", // if "État" => [], will create a JSON array and not a JSON object, which can be problematic
			"Calculs" => [],
			"MPP" => [],
			"Avdesav" => [],
			"Compétences" => [],
			"Sorts" => [],
			"Pouvoirs" => [],
			"Psi" => [],
			"Description" => "",
			"Background" => "",
			"Notes" => "",
			"Portrait" => "_default.png"
		];

		// Kits
		if ($kit_base) {
			!$kit_combattant ? $character["Compétences"][] = ["id" => 26] : null; // Esquive
			$character["Compétences"][] = ["id" => 181]; // Furtivité
			$character["Compétences"][] = ["id" => 127]; // Culture générale
			!($kit_ange || $kit_demon) ? $character["Compétences"][] = ["id" => 200] : null; // Langue maternelle
			$character["Compétences"][] = ["id" => 148]; // Baratin
			$character["Compétences"][] = ["id" => 147]; // Acteur
		}
		if ($kit_combattant) {
			$character["Avdesav"][] = ["id" => 29]; // Réflexes de combat
			$character["Avdesav"][] = ["id" => 31]; // Résistance à la douleur
			$character["Compétences"][] = ["id" => 21, "niv" => 0]; // Combat à mains nues
			$character["Compétences"][] = ["id" => 26, "label" => "Esquive (+1)", "niv" => 0]; // Esquive
		}
		if ($kit_magicien) {
			$caracs["Int"] = 13;
			$character["Avdesav"][] = ["id" => 24, "nom" => "Magerie 1", "points" => 15]; // Magerie
			$character["Avdesav"][] = ["id" => 6, "nom" => "Alphabétisation", "points" => 5]; // Alphabétisation
			$character["Compétences"][] = ["id" => 144, "label" => "Sciences occultes", "niv" => -1]; // Sciences occultes
		}
		if ($kit_ange) {
			$character["Pts"] = 230;
			$character["Caractéristiques"] = ["For" => 14, "Dex" => 10, "Int" => 10, "San" => 12, "Per" => 10, "Vol" => 12];
			$character["MPP"] = ["pouvoirs"];
			$character["Avdesav"][] = ["id" => 165]; // Pack Ange
		}
		if ($kit_demon) {
			$character["Pts"] = 220;
			$character["Caractéristiques"] = ["For" => 14, "Dex" => 10, "Int" => 10, "San" => 12, "Per" => 10, "Vol" => 10];
			$character["MPP"] = ["pouvoirs"];
			$character["Avdesav"][] = ["id" => 166]; // Pack Démon
		}

		$character["Caractéristiques"] = json_encode($character["Caractéristiques"], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		$character["MPP"] = json_encode($character["MPP"], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		$character["Avdesav"] = json_encode($character["Avdesav"], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		$character["Compétences"] = json_encode($character["Compétences"], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

		$character["Calculs"] = json_encode($character["Calculs"], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		//$character["État"] = json_encode($character["État"], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		$character["Sorts"] = json_encode($character["Sorts"], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		$character["Pouvoirs"] = json_encode($character["Pouvoirs"], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		$character["Psi"] = json_encode($character["Psi"], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

		$character_repo = new CharacterRepository;
		$character_repo->createCharacter($character);
	}

	public static function updateCharacter(array $post, $file): void
	{
		// id id_joueur id_groupe Nom Statut Pts Caractéristiques État Calculs MPP Avdesav Compétences Sorts Pouvoirs Psi Description Background Notes Portrait

		$attributes_names = ["For", "Dex", "Int", "San", "Per", "Vol"];

		$character = [
			// commented values are not be updated by player
			"id" => (int) $post["id"],
			//"id_joueur",
			//"id_groupe",
			"Nom" => strip_tags($post["Nom"]),
			//"Statut",
			"Pts" => (float) $post["Pts"],
			"Caractéristiques" => [],
			//"État",
			//"Calculs",
			"MPP" => [],
			"Avdesav" => [],
			"Compétences" => [],
			"Sorts" => [],
			"Pouvoirs" => [],
			"Psi" => [],
			"Description" => TextParser::cleanPunctuation(strip_tags($post["Description"])),
			"Background" => strip_tags($post["Background"]),
			"Notes" => strip_tags($post["Notes"]),
			"Portrait" => str_replace("assets/character-portraits/", "", strip_tags($post["Portrait"]))
		];

		// Caractéristiques
		foreach ($attributes_names as $attribute) {
			$value = (int) $post["Caractéristiques"][$attribute];
			$character["Caractéristiques"][$attribute] = $value > 0 ? $value : 10;

			// Coût supp. pour changement après création
			if ($post["for-processing"]["status"] !== "Création") {
				$former_value = (int) $post["for-processing"]["init-attributes"][$attribute];
				$delta = $value - $former_value;
				if ($delta) {
					$modified_attribute = new Attribute($attribute);
					$cost_difference = $modified_attribute->cost($value) - $modified_attribute->cost($former_value);
					$additionnal_attribute_cost = $cost_difference * ($attribute === "For" ? 0.5 : 1) * (float) $post["for-processing"]["cost-mult"][$attribute];
					$character["Pts"] -= $additionnal_attribute_cost;
				}
			}
		}

		// MPP
		isset($post["MPP"]["pouvoirs"]) ? $character["MPP"][] = "pouvoirs" : "";
		isset($post["MPP"]["psi"]) ? $character["MPP"][] = "psi" : "";

		// Avdesav
		if (isset($post["Avdesav"])) {
			foreach ($post["Avdesav"] as $avdesav) {
				$avdesav["id"] = (int) $avdesav["id"];
				isset($avdesav["nom"]) ? $avdesav["nom"] = strip_tags($avdesav["nom"]) : "";
				isset($avdesav["points"]) ? $avdesav["points"] = $avdesav["points"] = (float) $avdesav["points"] : "";
				if (!isset($avdesav["points"]) && $avdesav["id"] === 0) {
					$avdesav["points"] = -1;
				}

				if (isset($avdesav["options"]["aff_coût"])) {
					$avdesav["options"][] = "aff_coût";
					unset($avdesav["options"]["aff_coût"]);
				}
				if (isset($avdesav["options"]["caché"])) {
					$avdesav["options"][] = "caché";
					unset($avdesav["options"]["caché"]);
				}

				$deleted_avdesav = isset($avdesav["nom"]) && $avdesav["nom"] === "";
				if (!$deleted_avdesav) {
					$character["Avdesav"][] = $avdesav;
				}
			}
		}

		// Compétences
		if (isset($post["Compétences"])) {
			foreach ($post["Compétences"] as $skill) {
				$f_skill["id"] = (int) $skill["id"];
				isset($skill["former-niv"]) ? $f_skill["niv"] = (int) $skill["former-niv"] + (int) $skill["score"] - (int) $skill["former-score"] : "";
				isset($skill["label"]) ? $f_skill["label"] = strip_tags($skill["label"]) : "";
				$is_deleted_skill = empty($f_skill["label"]) && isset($f_skill["niv"]);
				if (!$is_deleted_skill) {
					$character["Compétences"][] = $f_skill;
				}
				unset($f_skill); // reset loop variable
			}
		}

		// Collèges
		if (isset($post["Collèges"])) {
			foreach ($post["Collèges"] as $college) {
				$f_college["id"] = (int) $college["id"];
				if (isset($college["former-niv"])) {
					$f_college["niv"] = (int) $college["former-niv"] + (int) $college["score"] - (int) $college["former-score"];
					$f_college["modif"] = TextParser::parseModif($college["name"]);
				} else {
					$f_college["niv"] = Skill::cost2niv(1, -8);
					$f_college["modif"] = 0;
				}
				if (!$f_college["modif"]) {
					unset($f_college["modif"]);
				}
				$f_college["catégorie"] = "collège";
				!empty($college["name"]) || !isset($college["former-niv"]) ? $character["Sorts"][] = $f_college : "";
			}
		}

		// Sorts
		if (isset($post["Sorts"])) {
			$pre_liste_sorts = [];
			foreach ($post["Sorts"] as $spell) {
				$id = (int) $spell["id"];
				$new_modif = TextParser::parseModif($spell["name"]);
				$former_modif = (int) $spell["former-modif"];
				$new_points = (int) $spell["points"];
				$former_points = (int) $spell["former-points"];
				$spell_has_changed = $new_modif !== $former_modif || $new_points !== $former_points;
				if (!isset($pre_liste_sorts[$id]) && ($new_points || $new_modif) || $spell_has_changed) {
					$f_spell["id"] = $id;
					$f_spell["points"] = $new_points;
					$f_spell["modif"] = $new_modif;
					if (!$f_spell["modif"]) {
						unset($f_spell["modif"]);
					}
					$f_spell["catégorie"] = "sort";
					$pre_liste_sorts[$id] = $f_spell;
				}
			}
			$character["Sorts"] = array_merge($character["Sorts"], array_values($pre_liste_sorts));
		}

		// Pouvoirs
		if (isset($post["Pouvoirs"])) {
			foreach ($post["Pouvoirs"] as $pouvoir) {
				$pouvoir["id"] = (int) $pouvoir["id"];
				$pouvoir["points"] = (float) $pouvoir["points"];
				if (empty($pouvoir["notes"])) {
					unset($pouvoir["notes"]);
				} else {
					$pouvoir["notes"] = strip_tags($pouvoir["notes"]);
				}
				if (empty($pouvoir["mult"])) {
					unset($pouvoir["mult"]);
				} else {
					$pouvoir["mult"] = (float) $pouvoir["mult"];
				}
				$pouvoir["modif"] = TextParser::parseModif($pouvoir["nom"]);
				if (!$pouvoir["modif"]) {
					unset($pouvoir["modif"]);
				}

				$pouvoir["niv"] = (int) ($pouvoir["niv"] ?? 0);

				if (!empty($pouvoir["nom"])) {
					$character["Pouvoirs"][] = $pouvoir;
				}
			}
		}

		// Nouveaux pouvoirs
		if (isset($post["Nouveaux-pouvoirs"])) {
			$powers_repo = new PowerRepository;
			foreach ($post["Nouveaux-pouvoirs"] as $origine => $pouvoirs) {

				if ($origine === "sort") {
					$pouvoirs = str_replace([",", ";", "-", "/"], " ", $pouvoirs);
					$pouvoirs = preg_replace("/\s{2,}/", " ", $pouvoirs);
					$pouvoirs = explode(" ", $pouvoirs);
					$f_pouvoirs = [];
					foreach ($pouvoirs as $id) {
						$f_pouvoirs[] = ["id" => (int) $id];
					}
					$pouvoirs = $f_pouvoirs;
					$pouvoirs = array_filter($pouvoirs, fn ($x) => $x["id"] > 0);
				}

				foreach ($pouvoirs as $pouvoir) {
					$pouvoir["id"] = (int) $pouvoir["id"];
					$pouvoir["origine"] = $origine;
					$data = $powers_repo->getPower($pouvoir["id"], $origine);
					if ($data->data) {
						$type = $data->specific["Type"] ?? $origine;
						if ($type === "avantage") {
							$pouvoir["niv"] = 0;
							$pouvoir["points"] = $data->data->defaultCost * ($data->specific["Mult"] ?? 1);
							$pouvoir["points"] = (round($pouvoir["points"] * 2)) / 2;
						} else {
							$pouvoir["niv"] = $data->data->niv_min;
							$pouvoir["points"] = 0;
						}

						$character["Pouvoirs"][] = $pouvoir;
					}
				}
			}
		}

		// Disciplines psi
		if (isset($post["Psi-disciplines"])) {
			foreach ($post["Psi-disciplines"] as $discipline) {
				$f_discipline = [];
				$f_discipline["id"] = (int) $discipline["id"];
				!isset($discipline["niv"]) ? $discipline["niv"] = 1 : "";
				$f_discipline["niv"] = min((int) $discipline["niv"], 5);
				!empty($discipline["mult"]) ? $f_discipline["mult"] = (float) $discipline["mult"] : "";
				!empty($discipline["notes"]) ? $f_discipline["notes"] = strip_tags($discipline["notes"]) : "";
				$f_discipline["catégorie"] = "discipline";
				$discipline["niv"] ? $character["Psi"][] = $f_discipline : ""; // push discipline if niv > 0
			}
		}

		// Pouvoirs psi
		if (isset($post["Psi-pouvoirs"])) {
			foreach ($post["Psi-pouvoirs"] as $pouvoir) {
				$f_pouvoir = [];
				$f_pouvoir["id"] = (int) $pouvoir["id"];
				$f_pouvoir["niv"] = (int) $pouvoir["former-niv"] + (int) $pouvoir["score"] - (int) $pouvoir["former-score"];
				$f_pouvoir["modif"] = TextParser::parseModif($pouvoir["nom"]);
				if (!$f_pouvoir["modif"]) {
					unset($f_pouvoir["modif"]);
				}
				$f_pouvoir["catégorie"] = "pouvoir";
				$f_pouvoir["niv"] > Skill::cost2niv(0, -6) ? $character["Psi"][] = $f_pouvoir : "";
			}
		}

		// Portrait
		if (isset($file['image']) && $file['image']['error'] == 0) {
			if ($file['image']['size'] <= 520000) {
				$infosfichier = pathinfo($_FILES['image']['name']);
				$extension_upload = strtolower($infosfichier['extension']);
				$extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png', 'webp');
				if (in_array($extension_upload, $extensions_autorisees)) {
					$nom_fichier = "Perso_" . str_pad($character["id"], 4, '0', STR_PAD_LEFT);
					$url_dossier = $_SERVER['DOCUMENT_ROOT'] . '/assets/character-portraits/';
					$dossier = opendir($url_dossier);
					while (false !== ($fichier_i = readdir($dossier))) {
						foreach ($extensions_autorisees as $ext) {
							if ($fichier_i == $nom_fichier . '.' . $ext) {
								unlink($url_dossier . $fichier_i);
							}
						}
					}
					closedir($dossier);

					$nom_fichier .= '.' . $extension_upload;
					setlocale(LC_CTYPE, 'fr_FR');
					move_uploaded_file($_FILES['image']['tmp_name'], $url_dossier . basename($nom_fichier));
					$character["Portrait"] = basename($nom_fichier);
				}
			}
		}
		
		foreach (["Caractéristiques", "MPP", "Avdesav", "Compétences", "Sorts", "Pouvoirs", "Psi"] as $array_data) {
			$character[$array_data] = json_encode($character[$array_data], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		}

		// Update database
		$repo = new CharacterRepository;
		$repo->updateCharacterPlayer($character);
	}

	public static function updateCharacterState(array $post): void
	{
		// id id_joueur id_groupe Nom Statut Pts Caractéristiques État Calculs MPP Avdesav Compétences Sorts Pouvoirs Psi Description Background Notes Portrait
		// État : For_global, For_deg, Dex, Int, Magie, PdV, PdF, (PdM), PdE, Stress, Membres, Autres
		// État – ajouts récents : San,

		$character = [
			// commented values are not be updated by manager
			"id" => (int) $post["id"],
			"id_joueur" => (int) $post["id_joueur"],
			"id_groupe" => (int) $post["id_groupe"],
			//"Nom" => strip_tags($post["Nom"]),
			"Statut" => "",
			"Pts" => (float) $post["Pts"],
			//"Caractéristiques"
			"État" => [],
			//"Calculs",
			//"MPP"
			//"Avdesav"
			//"Compétences"
			//"Sorts"
			//"Pouvoirs"
			//"Psi"
			//"Description"
			//"Background"
			//"Notes"
			//"Portrait"
		];

		$character["Statut"] = !in_array($post["Statut"], ["Création", "Actif", "Archivé", "Mort"]) ? "Création" : $post["Statut"];

		// fetching PdM value (this value is now managed from character sheet)
		$repo = new CharacterRepository;
		$state = $repo->getCharacterState($character["id"]);
		$pdm = $state["PdM"] ?? "";

		$character["État"] = [
			"PdV" => $post["État"]["PdV"] === "" ? "" : min((int) $post["Calculs"]["PdVm"], (int) $post["État"]["PdV"]),
			"PdF" => $post["État"]["PdF"] === "" ? "" : min((int) $post["Calculs"]["PdFm"], (int) $post["État"]["PdF"]),
			"PdM" => $pdm,
			"PdE" => $post["État"]["PdE"] === "" ? "" : min((int) $post["Calculs"]["PdEm"], (int) $post["État"]["PdE"]),

			"Stress" => min(3, max(0, (int) $post["État"]["Stress"])),

			"For_global" => (int) $post["État"]["For_global"],
			"Dex" => (int) $post["État"]["Dex"],
			"Int" => (int) $post["État"]["Int"],
			"San" => (int) $post["État"]["San"],
			"Per" => (int) $post["État"]["Per"],
			"Vol" => (int) $post["État"]["Vol"],
			"For_deg" => (int) $post["État"]["For_deg"],
			"Réflexes" => (int) $post["État"]["Réflexes"],
			"Sang-Froid" => (int) $post["État"]["Sang-Froid"],
			"Magie" => (int) $post["État"]["Magie"],

			"Membres" => strip_tags(trim($post["État"]["Membres"])),
			"Autres" => strip_tags(trim($post["État"]["Autres"])),
		];

		// Supression des entrées vierges
		foreach ($character["État"] as $key => $value) {
			if (in_array($key, ["PdV", "PdF", "PdM", "PdE"])) {
				if ($value === "") {
					unset($character["État"][$key]);
				}
			} elseif (empty($value)) {
				unset($character["État"][$key]);
			}
		}

		$character["État"] = json_encode($character["État"], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		if ($character["État"] === "[]") $character["État"] = "{}";

		// Update database
		$repo = new CharacterRepository;
		$repo->updateCharactermanager($character);
	}

	public static function updateCharacterPdM(array $post): void
	{
		$character_id = (int) $post["id"];
		$max = (int) $post["max"];
		$pdm = $post["pdm"];
		if ($pdm !== ""){
			$pdm = (int) $post["pdm"];
			$pdm = max(0, $pdm);
			$pdm = min($max, $pdm);
		}
		echo $pdm;

		// Update database
		$repo = new CharacterRepository;
		$repo->updateCharacterPdm($character_id, $pdm);
	}
}
