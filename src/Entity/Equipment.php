<?php

namespace App\Entity;

use App\Lib\Sorter;
use App\Lib\TextParser;
use App\Lib\DiceManager;
use App\Repository\EquipmentRepository;

class Equipment
{
	// id, Nom, Contenant, Poids, Notes, Secret, Lieu, Groupe, Ordre

	public ?int $id;
	public string $name;
	public bool $isContainer;
	public ?float $weight;
	public ?string $notes;
	public ?string $secret;
	public string $place;
	public ?int $visibleByGroupId;
	public int $order;
	public ?string $containerName = null;

	public function __construct($data = [])
	{
		$repo = new EquipmentRepository;
		$this->id = $data["id"] ?? null;
		$this->name = $data["Nom"] ?? "";
		$this->isContainer = $data["Contenant"] ?? false;
		$this->weight = $data["Poids"] ?? null;
		$this->notes = $data["Notes"] ?? null;
		$this->secret = $data["Secret"] ?? null;
		$this->place = $data["Lieu"] ?? "pi_0";
		$this->visibleByGroupId = $data["Groupe"] ?? null;
		$this->order = $data["Ordre"] ?? 1;
		if (substr($this->place, 0, 3) === "ct_") {
			$this->containerName = $repo->getEquipment((int)substr($this->place, 3))->name;
		}
	}

	public static function isCarried(int $id): bool
	{
		$repo = new EquipmentRepository;
		$location = $repo->getEquipmentPlace($id);
		if (substr($location, 0, 3) === "pi_") {
			return true;
		} elseif (substr($location, 0, 3) === "pe_") {
			return false;
		} else {
			$parent_id = substr($location, 3);
			return self::isCarried($parent_id);
		}
	}

	public static function getEquipmentOwnerId(int $id): int
	{
		$repo = new EquipmentRepository;
		$location = $repo->getEquipmentPlace($id);
		if (in_array(substr($location, 0, 3), ["pi_", "pe_"])) {
			return (int) substr($location, 3);
		} else {
			$parent_id = substr($location, 3);
			return self::getEquipmentOwnerId($parent_id);
		}
	}

	public static function getCarriedWeight(int $character_id)
	{
		$repo = new EquipmentRepository;
		$carried_items = $repo->getCharacterEquipment($character_id, true);
		$carried_weight = 0;
		foreach ($carried_items as $item) {
			$carried_weight += $item->weight;
		}
		return $carried_weight;
	}

	public static function processEquipmentList(array $raw_equipment, array $state = []): array
	{
		$equipment = [
			"pi" => ["id" => 0, "nom" => "Possessions sur soi", "liste" => [], "poids" => 0, "ordre" => null, "ordre-par-defaut" => 1, "sur-soi" => true, "lieu" => "pi"],
		];

		foreach ($raw_equipment as $item) {
			if ($item->isContainer) {
				$equipment["ct_" . $item->id] = [
					"id" => $item->id,
					"nom" => $item->name . ($item->containerName ? (" (" . $item->containerName . ")") : ""),
					"liste" => [],
					"poids" => $item->weight,
					"ordre" => null,
					"ordre-par-defaut" => $item->order,
					"groupe" => $item->visibleByGroupId,
					"non-vide" => false,
					"sur-soi" => self::isCarried($item->id),
					"dans-contenant" => !!$item->containerName,
					"lieu" => "ct_" . $item->id
				];
			}
		}

		$equipment["pe"] = ["id" => 0, "nom" => "Divers", "liste" => [], "poids" => 0,  "ordre" => null, "ordre-par-defaut" => 1000, "sur-soi" => false, "lieu" => "pe"];

		foreach ($raw_equipment as $item) {
			// filling equipment sublists
			if (substr($item->place, 0, 3) === "pi_") {
				$equipment["pi"]["liste"][] = $item;
				$equipment["pi"]["poids"] += $item->isContainer ? 0 : $item->weight;
				$equipment["pi"]["ordre"] = $equipment["pi"]["ordre"] ?? $item->order;
			} elseif (substr($item->place, 0, 3) === "pe_") {
				$equipment["pe"]["liste"][] = $item;
				$equipment["pe"]["poids"] += $item->isContainer ? 0 : $item->weight;
				$equipment["pe"]["ordre"] = $equipment["pe"]["ordre"] ?? $item->order;
			} elseif (substr($item->place, 0, 3) === "ct_") {
				$equipment[$item->place]["liste"][] = $item;
				$equipment[$item->place]["poids"] += $item->isContainer ? 0 : $item->weight;
				$equipment[$item->place]["non-vide"] = true;
				$equipment[$item->place]["ordre"] = $equipment[$item->place]["ordre"] ?? $item->order;
			}

			// processing state counters to be displayed as meter in state section of character
			if (!empty($state)) {
				$counter = TextParser::parseObjectCounter($item->name);
				if (!empty($counter)) {
					!isset($state["Compteurs-equipement"]) ? $state["Compteurs-equipement"] = [] : "";
					$state["Compteurs-equipement"][] = $counter;
				}
			}
		}

		foreach ($equipment as $index => $sub_list) {
			$equipment[$index]["ordre"] = $sub_list["ordre"] ?? $sub_list["ordre-par-defaut"];
		}

		$equipment = Sorter::sort($equipment, "ordre");
		return [$equipment, $state];
	}

	public static function processEquipmentSubmit($post)
	{
		$order = 0;
		$repo = new EquipmentRepository;

		$post["objet"] = $post["objet"] ?? [];

		foreach ($post["objet"] as $id => $item) {
			$order++;
			if ($id && empty($item["Nom"])) {
				$repo->makeItemOrphan($id);
			} else {
				$formatted_item = [];
				$formatted_item["id"] = (int) $id;
				$formatted_item["Nom"] = trim(strip_tags($item["Nom"]), "* ");

				$formatted_item["Contenant"] = (bool) $item["Contenant"];
				if ($item["Contenant-off"] === "on" && empty($repo->getEquipmentFromPlace("ct_" . $id))) {
					$formatted_item["Contenant"] = false;
				}
				if (substr($item["Nom"], 0, 1) === "*") {
					$formatted_item["Contenant"] = true;
				}
				$formatted_item["Poids"] = $item["Poids"] !== "" ? (float) $item["Poids"] : null;
				$formatted_item["Notes"] = strip_tags($item["Notes"]);
				isset($item["Secret"]) ? $formatted_item["Secret"] = strip_tags($item["Secret"]) : "";
				$formatted_item["Lieu"] = strip_tags($item["Lieu"]);
				$formatted_item["Groupe"] = !empty($post["sub-list"][$id]["Groupe"]) ? (int) $post["sub-list"][$id]["Groupe"] : null;  //$item["Groupe"] ?? null;
				$formatted_item["Ordre"] = $order;

				// prevent putting container in itself
				$container_is_in_itself = $formatted_item["id"] == substr($formatted_item["Lieu"], 3);

				if (!$container_is_in_itself) {
					$repo->setEquipment($formatted_item);
				}
			}
		}

		$post["nouvel-objet"] = $post["nouvel-objet"] ?? [];
		foreach ($post["nouvel-objet"] as $item) {
			$formatted_item = [];
			$formatted_item["Nom"] = trim(strip_tags($item["Nom"]), "* ");
			$formatted_item["Contenant"] = substr($item["Nom"], 0, 1) === "*" ? true : false;
			$formatted_item["Poids"] = $item["Poids"] !== "" ? (float) $item["Poids"] : null;
			$formatted_item["Notes"] = "";
			$formatted_item["Secret"] = "";
			$formatted_item["Lieu"] = strip_tags($item["Lieu"]);
			$formatted_item["Groupe"] = null;
			$formatted_item["Ordre"] = 99;
			if (!empty($formatted_item["Nom"])) {
				$repo->createEquipment($formatted_item);
			}
		}

		$post["objet-gestionnaire"] = $post["objet-gestionnaire"] ?? [];
		foreach ($post["objet-gestionnaire"] as $item) {
			$formatted_item = [];
			$formatted_item["id"] = (int) $item["id"];
			$formatted_item["Nom"] = trim(strip_tags($item["Nom"]), "* ");
			$formatted_item["Contenant"] = isset($item["Contenant"]) ? true : false;
			$formatted_item["Poids"] = $item["Poids"] !== "" ? (float) $item["Poids"] : null;
			$formatted_item["Notes"] = strip_tags($item["Notes"]);
			$formatted_item["Secret"] = strip_tags($item["Secret"]);
			$formatted_item["Lieu"] = strip_tags($item["Lieu"]);
			$formatted_item["Groupe"] = null;
			$formatted_item["Ordre"] = 99;
			if ($formatted_item["id"] && $formatted_item["Nom"]) {
				$repo->setEquipment($formatted_item);
			} elseif ($formatted_item["id"] && !$formatted_item["Nom"]) {
				$repo->deleteEquipment($formatted_item["id"]);
			} elseif (!$formatted_item["id"] && $formatted_item["Nom"]) {
				unset($formatted_item["id"]);
				var_dump($formatted_item);
				$repo->createEquipment($formatted_item);
			}
		}

		//$redirect_url = isset($post["id_perso"]) ? ("/personnage-fiche?perso=" . $post["id_perso"]) : "/gestionnaire-mj";
		//header("Location: " . $redirect_url); // redirect inutile dès que le submit sur la fiche de perso se fera via JS
	}

	public static function evaluateDamages(int $for, string $code, string $hands = "1M")
	{
		preg_match('/^[TBP]\.[te]([\+-][0-9]+){0,}$/', $code, $matches);
		$code = $matches[0] ?? null;
		if (empty($code)) {
			return "invalid code";
		}

		$base = Attribute::getDamages($for);

		switch ($hands) {
			case "2M-opt":
				$hands_modifier = (int) $base['taille'];
				break;

			case "2M":
				$hands_modifier = (int) $base['taille'] - 1;
				break;

			default:
				$hands_modifier = 0;
		}

		$type = substr($code, 0, 1); // P, T ou B
		$matching_base = (substr($code, 2, 1) === 'e') ? $base['estoc'] : $base['taille'];
		$weapon_modifier = TextParser::parseModifiersChain(substr($code, 3));
		$global_modifier = TextParser::parseInt2Modif($weapon_modifier + $hands_modifier);
		$processed_damages = DiceManager::diceParser($matching_base . $global_modifier);
		$display_damages = $type . "." . $processed_damages;

		return $display_damages;
	}
}
