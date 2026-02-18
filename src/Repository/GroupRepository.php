<?php

namespace App\Repository;

use App\Entity\Group;

class GroupRepository extends AbstractRepository
{
	public function getGroup(int $id): ?Group
	{
		$query = $this->db->prepare("SELECT * FROM groupes WHERE id = ?");
		$query->execute([$id]);
		$item = $query->fetch(\PDO::FETCH_ASSOC);
		$query->closeCursor();
		if (!$item) {
			return null;
		}
		$group = new Group($item);
		return $group;
	}

	public function getGMGroups(int $id): array
	{
		$query = $this->db->prepare("SELECT * FROM groupes WHERE MJ = ?");
		$query->execute([$id]);
		$items = $query->fetchAll(\PDO::FETCH_ASSOC);
		$query->closeCursor();
		//$items[] = ["id" => 100, "Nom" => "Persos test", "MJ" => 0];
		//$items[] = ["id" => 100 + $id, "Nom" => "Mes PNJ", "MJ" => 0];
		$groups = [];
		foreach ($items as $item){
			$groups[] = new Group($item);
		}
		$groups[] = new Group(["id" => NULL, "Nom" => "Personnages test", "MJ" => 0]);
		return $groups;
	}

	public function getAllGroups(): array
	{
		$query = $this->db->query("SELECT * FROM groupes");
		$items = $query->fetchAll(\PDO::FETCH_ASSOC);
		$query->closeCursor();
		$groups = [];
		foreach($items as $item){
			$groups[] = new Group($item);
		}

		$groups[] = new Group(["id" => NULL, "Nom" => "Personnages test", "MJ" => 0]);

		/* $users_repo = new UserRepository;
		$gm_users = $users_repo->getGMUsers();
		foreach ($gm_users as $gm){
			$groups[] = new Group(["id" => 100 + $gm->id, "Nom" => "PNJ de " . $gm->login, "MJ" => $gm->id]);
		} */
		return $groups;
	}

	public function updateGroup(array $data){
		$query = $this->db->prepare("UPDATE groupes SET Nom = :Nom, MJ = :MJ WHERE id = :id");
		$query->execute($data);
		$query->closeCursor();
	}

	public function createGroup(array $data){
		$query = $this->db->prepare("INSERT INTO groupes (Nom, MJ) VALUES (:Nom, :MJ)");
		$query->execute($data);
		$query->closeCursor();
	}

	public function getExistingGroups(): array
	{
		$query = $this->db->query("SELECT id FROM groupes");
		$items = $query->fetchAll(\PDO::FETCH_COLUMN);
		return $items;
	}
}
