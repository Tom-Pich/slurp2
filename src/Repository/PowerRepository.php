<?php

namespace App\Repository;

use App\Entity\Power;
use App\Repository\AbstractRepository;

class PowerRepository extends AbstractRepository
{
	const tables = ["avantage", "sort", "pouvoir"];

	/**
	 * getPower
	 *
	 * @param  string $origin
	 * @param  int $id
	 * @return ?Power
	 */
	function getPower(int $id, string $table = "pouvoir"): ?Power
	{
		if (!in_array($table, ["avantage", "sort"])) {
			$query = $this->db->prepare("SELECT * FROM pouvoirs WHERE id = ?");
			$query->execute([$id]);
			$item = $query->fetch(\PDO::FETCH_ASSOC);
			$query->closeCursor();
			if (!$item) return null;
		} else {
			$item["id"] = $id;
		}

		$item["origin"] = $table;

		return new Power($item);
	}

	public function getAllPowers(string $table = "pouvoir")
	{
		$powers = [];
		if ($table === "avantage") {
			$query = $this->db->query("SELECT id FROM av_desav WHERE Pouvoir IS NOT NULL ORDER BY Nom");
			$items = $query->fetchAll(\PDO::FETCH_ASSOC);
			$query->closeCursor();
			foreach ($items as $item) {
				$item["origin"] = "avantage";
				$powers[] = new Power($item);
			}
		} elseif ($table === "sort") {
			$query = $this->db->query("SELECT id FROM magie_sorts ORDER BY Nom");
			$items = $query->fetchAll(\PDO::FETCH_ASSOC);
			$query->closeCursor();
			foreach ($items as $item) {
				$item["origin"] = "sort";
				$powers[] = new Power($item);
			}
		} else {
			$query = $this->db->query("SELECT * FROM pouvoirs");
			$items = $query->fetchAll(\PDO::FETCH_ASSOC);
			$query->closeCursor();
			foreach ($items as $item) {
				$item["origin"] = "pouvoir";
				$powers[] = new Power($item);
			}
		}

		return $powers;
	}

	public function getDistinctCategories(?string $origin = null): array
	{
		if ($origin) {
			$query = $this->db->prepare("SELECT DISTINCT Catégorie FROM pouvoirs WHERE Origine = ? ORDER BY Catégorie");
			$query->execute([$origin]);
		} else {
			$query = $this->db->query("SELECT DISTINCT Catégorie FROM pouvoirs ORDER BY Catégorie");
		}
		$categories = $query->fetchAll(\PDO::FETCH_COLUMN);
		return array_values(array_filter($categories)); // strip empty values and re-index
	}

	public function getDistinctDomains(string $origin = null): array
	{
		if ($origin) {
			$query = $this->db->prepare("SELECT DISTINCT Domaine FROM pouvoirs WHERE Origine = ? ORDER BY Domaine");
			$query->execute([$origin]);
		} else {
			$query = $this->db->query("SELECT DISTINCT Domaine FROM pouvoirs ORDER BY Domaine");
		}
		$domains = $query->fetchAll(\PDO::FETCH_COLUMN);
		return array_values(array_filter($domains)); // strip empty values and re-index
	}

	public function getDistinctOrigins(): array
	{
		$query = $this->db->query("SELECT DISTINCT Origine FROM pouvoirs ORDER BY Origine");
		$origins = [];
		while ($item = $query->fetch(\PDO::FETCH_ASSOC)) {
			$origins[] = $item["Origine"];
		}
		return $origins;
	}

	public function getPowersByCategories(string $origin, string $category): array
	{
		$query = $this->db->prepare("SELECT * FROM pouvoirs WHERE Catégorie = ? AND Origine = ? ORDER BY Nom");
		$query->execute([$category, $origin]);
		$items = $query->fetchAll(\PDO::FETCH_ASSOC);
		$query->closeCursor();

		$powers = [];
		foreach ($items as $item) {
			$item["origin"] = $origin;
			$power = new power($item);
			$powers[] = $power;
		}
		return $powers;
	}

	public function updatePower(array $data): void{
		// id, id_RdB, Type, Nom, Catégorie, Domaine, Mult, Origine
		
		// correcting accented indexes
		$data["Categorie"] = $data["Catégorie"];
		unset($data["Catégorie"]);
		
		$query = $this->db->prepare("UPDATE pouvoirs SET id_RdB = :id_RdB, Type = :Type, Nom = :Nom, Catégorie = :Categorie, Domaine = :Domaine, Mult = :Mult, Origine = :Origine WHERE id = :id");
		$query->execute($data);
		$query->closeCursor();
	}
	
	public function createPower(array $data): void{
		// correcting accented indexes
		$data["Categorie"] = $data["Catégorie"];
		unset($data["Catégorie"]);
		unset($data["id"]);
		
		$query = $this->db->prepare("INSERT INTO pouvoirs (id_RdB, Type, Nom, Catégorie, Domaine, Mult, Origine) VALUES (:id_RdB, :Type, :Nom, :Categorie, :Domaine, :Mult, :Origine)");
		$query->execute($data);
		$query->closeCursor();
	}

	public function deletePower(int $id): void{
		$query = $this->db->prepare("DELETE FROM pouvoirs WHERE id = ?");
		$query->execute([$id]);
		$query->closeCursor();
	}
}
