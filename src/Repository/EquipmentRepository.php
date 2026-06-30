<?php

namespace App\Repository;

use App\Entity\Equipment;

class EquipmentRepository extends AbstractRepository
{
	// id, Nom, Contenant, Poids, Notes, Secret, Lieu, Groupe, Ordre

	public function getEquipment(int $id): Equipment
	{
		$query = $this->db->prepare("SELECT * FROM objets WHERE id = ?");
		$query->execute([$id]);
		$item = $query->fetch(\PDO::FETCH_ASSOC);
		$object = new Equipment($item);
		return $object;
	}

	public function getEquipmentName(int $id): string{
		$query = $this->db->prepare("SELECT Nom FROM objets WHERE id = ?");
		$query->execute([$id]);
		$item = $query->fetch(\PDO::FETCH_ASSOC);
		return $item["Nom"];
	}

	public function getEquipmentFromPlace(string $place_code): array
	{
		$query = $this->db->prepare("SELECT * FROM objets WHERE lieu = ? ORDER BY Ordre, id");
		$query->execute([$place_code]);
		$items = $query->fetchAll(\PDO::FETCH_ASSOC);
		$query->closeCursor();

		return $items;
	}

	public function getEquipmentPlace(int $id): ?string
	{
		$query = $this->db->prepare("SELECT id, Lieu FROM objets WHERE id = ?");
		$query->execute([$id]);
		$item = $query->fetch(\PDO::FETCH_ASSOC);
		$query->closeCursor();
		return $item["Lieu"] ?? null;
	}

	public function getCharacterEquipment(int $id, bool $only_carried_equipment = false): array
	{
		if ($only_carried_equipment) {
			$query = $this->db->prepare("SELECT * FROM objets WHERE lieu = ? ORDER BY Ordre, id");
			$query->execute(["pi_" . $id]);
		} else {
			$query = $this->db->prepare("SELECT * FROM objets WHERE lieu = ? OR lieu = ? ORDER BY Ordre, id");
			$query->execute(["pi_" . $id, "pe_" . $id]);
		}
		$items = $query->fetchAll(\PDO::FETCH_ASSOC);
		$query->closeCursor();

		$containers_id = [];
		$repeat = true;
		while ($repeat === true) {
			$repeat = false;
			foreach ($items as $item) {
				if ($item["Contenant"] && !in_array($item["id"], $containers_id)) {
					$repeat = true;
					$containers_id[] = $item["id"];
					$container_items = $this->getEquipmentFromPlace("ct_" . $item["id"]);
					$items = array_merge($items, $container_items);
				}
			}
		}

		$objects = [];
		foreach ($items as $item) {
			$object = new Equipment($item);
			$objects[] = $object;
		}

		return $objects;
	}

	public function getCommonGroupEquipment(int $group_id): array
	{
		$query = $this->db->prepare("SELECT * FROM objets WHERE Groupe = ? ORDER BY Ordre, id");
		$query->execute([$group_id]);
		$items = $query->fetchALL(\PDO::FETCH_ASSOC);
		$query->closeCursor();

		$containers_id = [];
		$repeat = true;
		$group_list = [];
		while ($repeat === true) {
			$repeat = false;
			foreach ($items as $item) {
				if ($item["Contenant"] && !in_array($item["id"], $containers_id)) {
					$repeat = true;
					$containers_id[] = $item["id"];
					$owner_id = Equipment::getEquipmentOwnerId($item["id"]);
					$owner_name = ((new CharacterRepository)->getCharacterRef($owner_id))["Nom"];
					$container_items = $this->getEquipmentFromPlace("ct_" . $item["id"]);
					$items = array_merge($items, $container_items);
					$group_list[$item["Nom"] . " (" . $owner_name . ")"] = $container_items;
				}
			}
		}


		return $group_list;
	}

	public static function creates_loop(int $id_object, array $indexed_places, ?array $container_chain = NULL)
	{
		if (is_null($container_chain)) $container_chain = [];

		$place = $indexed_places[$id_object];
		$place_prefix = substr($place, 0, 3);
		if (in_array($place_prefix, ["pi_", "pe_"])) return false;
		$id_container = (int) substr($place, 3);
		if (in_array($id_container, $container_chain)) return true;
		$container_chain[] = $id_container;
		return self::creates_loop($id_container, $indexed_places, $container_chain); // on examine le container parent
	}

	public function getOrphanEquiment($id_mj = NULL): array
	{
		if ($id_mj === NULL) {
			$items_query = $this->db->query("SELECT id, Lieu FROM objets");
		} else {
			$items_query = $this->db->prepare("SELECT id, Lieu FROM objets WHERE MJ IN (0, ?)");
			$items_query->execute([$id_mj]);
		}
		$items_id_place_list = $items_query->fetchAll(\PDO::FETCH_ASSOC);
		$indexed_place_list = [];
		foreach ($items_id_place_list as $item) {
			$indexed_place_list[$item["id"]] = $item["Lieu"]; // id_objet => lieu
		}

		$characters_query = $this->db->query("SELECT id FROM persos");
		$character_ids = $characters_query->fetchAll(\PDO::FETCH_COLUMN);

		$container_query = $this->db->query("SELECT id FROM objets WHERE Contenant = 1");
		$container_ids = $container_query->fetchAll(\PDO::FETCH_COLUMN);

		$orphan_items = [];
		foreach ($indexed_place_list as $item_id => $place) {
			$place_prefix = substr($place, 0, 3);
			$place_id = (int) substr($place, 3);
			$has_inconsistent_place = empty($place) || !in_array($place_prefix, ["pi_", "pe_", "ct_"]);
			$has_inexistant_owner = in_array($place_prefix, ["pi_", "pe_"]) && !in_array($place_id, $character_ids);
			$is_in_inexistant_container = $place_prefix === "ct_" && !in_array($place_id, $container_ids);
			$is_container = in_array($item_id, $container_ids);
			$creates_loop = $is_container && self::creates_loop($item_id, $indexed_place_list);
			if($creates_loop){
				// grosse prise de tête avec boucles infinies dans plein de méthodes → makeItemOphan règle tout
				$has_inconsistent_place = true;
				$this->makeItemOrphan($item_id);
			}
			if ($has_inconsistent_place || $has_inexistant_owner || $is_in_inexistant_container) {
				$object = $this->getEquipment($item_id);
				$orphan_items[] = $object;
			}
		}

		// fetch content of orphan containers (recursive)
		$search_items_in_orphan_container = true;
		$inspected_orphan_containers_id = [];
		while ($search_items_in_orphan_container) {
			$search_items_in_orphan_container = false;
			$insertion_index_modifier = 0; // adjust contained object in the right position
			foreach ($orphan_items as $index => $item) {
				if ($item->isContainer && !in_array($item->id, $inspected_orphan_containers_id)) {
					$inspected_orphan_containers_id[] = $item->id;
					$search_items_in_orphan_container = true;
					$item_content = $this->getEquipmentFromPlace("ct_" . $item->id);
					$orphan_container_content = [];
					foreach ($item_content as $item_in_orphan_container) {
						$orphan_container_content[] = new Equipment($item_in_orphan_container);
					}
					array_splice($orphan_items, $index + 1 + $insertion_index_modifier, 0, $orphan_container_content);
					$insertion_index_modifier += count($orphan_container_content);
				}
			}
		}

		return $orphan_items;
	}

	/**
	 * setEquipment
	 *
	 * @param  mixed $data indexed array with id, Nom, Contenant, Poids, Notes, (Secret,) Lieu, Groupe, Ordre
	 * @return void
	 */
	public function setEquipment($data): void
	{
		if (isset($data["Secret"])) {
			$query = $this->db->prepare("UPDATE objets set Nom = :Nom, Contenant = :Contenant , Poids = :Poids, Notes = :Notes, Secret = :Secret, Lieu = :Lieu, Groupe = :Groupe, Ordre = :Ordre, MJ = :MJ WHERE id = :id");
		} else {
			$query = $this->db->prepare("UPDATE objets set Nom = :Nom, Contenant = :Contenant , Poids = :Poids, Notes = :Notes, Lieu = :Lieu, Groupe = :Groupe, Ordre = :Ordre, MJ = :MJ WHERE id = :id");
		}

		$query->execute($data);
		$query->closeCursor();
	}

	public function deleteEquipment($id): void
	{
		$query = $this->db->prepare("DELETE from objets WHERE id = ?");
		$query->execute([$id]);
		$query->closeCursor();
	}

	public function createEquipment($data): void
	{
		$query = $this->db->prepare("INSERT into objets (Nom, Contenant, Poids, Notes, Secret, Lieu, Groupe, Ordre, MJ) values (:Nom, :Contenant, :Poids, :Notes, :Secret, :Lieu, :Groupe, :Ordre, :MJ)");
		$query->execute($data);
		$query->closeCursor();
	}

	public function makeItemOrphan(int $id): void
	{
		$query = $this->db->prepare("UPDATE objets set Lieu = :Lieu, Groupe = :Groupe, Ordre = :Ordre WHERE id = :id");
		$query->execute(["id" => $id, "Lieu" => "pi_0", "Groupe" => null, "Ordre" => 1000]);
		$query->closeCursor();
	}
}
