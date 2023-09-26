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

	public function getEquipmentFromPlace(string $place_code): array
	{
		$query = $this->db->prepare("SELECT * FROM objets WHERE lieu = ? ORDER BY Ordre, id");
		$query->execute([$place_code]);
		$items = $query->fetchAll(\PDO::FETCH_ASSOC);
		$query->closeCursor();

		return $items;
	}

	public function getEquipmentPlace(int $id): string
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
					$group_list[$item["Nom"]." (".$owner_name.")"] = $container_items;
				}
			}
		}


		return $group_list;
	}

	public function getOrphanEquiment(): array
	{
		$items_query = $this->db->query("SELECT id, Lieu FROM objets");
		$full_items_id_place_list = $items_query->fetchAll(\PDO::FETCH_ASSOC);

		$characters_query = $this->db->query("SELECT id FROM persos");
		$full_characters_id_list = [];
		while ($character = $characters_query->fetch(\PDO::FETCH_ASSOC)) {
			$full_characters_id_list[] = $character["id"];
		}

		$container_query = $this->db->query("SELECT id FROM objets WHERE Contenant = 1");
		$full_container_id_list = [];
		while ($container = $container_query->fetch(\PDO::FETCH_ASSOC)) {
			$full_container_id_list[] = $container["id"];
		}

		$orphan_items = [];
		foreach ($full_items_id_place_list as $item) {
			$place = $item["Lieu"];
			$has_inconsistent_place = empty($place) || !in_array(substr($place, 0, 3), ["pi_", "pe_", "ct_"]);
			$has_inexistant_owner = in_array(substr($place, 0, 3), ["pi_", "pe_"]) && !in_array(substr($place, 3), $full_characters_id_list);
			$is_in_inexistant_container = substr($place, 0, 3) === "ct_" && !in_array(substr($place, 3), $full_container_id_list);
			if ($has_inconsistent_place || $has_inexistant_owner || $is_in_inexistant_container) {
				$object = $this->getEquipment($item["id"]);
				$orphan_items[] = $object;
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
		if (isset($data["Secret"]) || is_null($data["Secret"])) {
			$query = $this->db->prepare("UPDATE objets set Nom = :Nom, Contenant = :Contenant , Poids = :Poids, Notes = :Notes, Secret = :Secret, Lieu = :Lieu, Groupe = :Groupe, Ordre = :Ordre WHERE id = :id");
		} else {
			$query = $this->db->prepare("UPDATE objets set Nom = :Nom, Contenant = :Contenant , Poids = :Poids, Notes = :Notes, Lieu = :Lieu, Groupe = :Groupe, Ordre = :Ordre WHERE id = :id");
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
		$query = $this->db->prepare("INSERT into objets (Nom, Contenant, Poids, Notes, Secret, Lieu, Groupe, Ordre) values (:Nom, :Contenant, :Poids, :Notes, :Secret, :Lieu, :Groupe, :Ordre)");
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
