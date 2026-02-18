<?php

namespace App\Repository;

use App\Entity\AvDesav;
use App\Repository\AbstractRepository;

class AvDesavRepository extends AbstractRepository
{
	/**
	 * getAvDesav
	 *
	 * @param  int $id
	 * @return AvDesav
	 */
	public function getAvDesav(int $id): ?AvDesav
	{
		$query = $this->db->prepare("SELECT * FROM av_desav WHERE id = ?");
		$query->execute([$id]);
		$item = $query->fetch(\PDO::FETCH_ASSOC);
		$query->closeCursor();
		
		if (!$item) return null;
		
		$avdesav = new AvDesav($item);
		return $avdesav;
	}

	/**
	 * getAvDesavByCategorie
	 *
	 * @param string name of category as in database
	 * @return array Array Av-Désav from given category
	 */
	public function getAvDesavByCategory(string $category): array
	{
		$query = $this->db->prepare("SELECT * FROM av_desav WHERE Catégorie = ? ORDER BY Nom");
		$query->execute([$category]);
		$items = $query->fetchAll(\PDO::FETCH_ASSOC);
		$query->closeCursor();
		$avdesavs = [];
		foreach ($items as $item) {
			$avdesavs[] = new AvDesav($item);
		}
		return $avdesavs;
	}

	/**
	 * getAllAvDesav
	 *
	 * @return array Array of all Av-Désav
	 */
	public function getAllAvDesav(): array
	{
		$query = $this->db->query("SELECT * FROM av_desav ORDER BY Nom");
		$items = $query->fetchAll(\PDO::FETCH_ASSOC);
		$query->closeCursor();
		$avdesavs = [];
		foreach ($items as $item) {
			$avdesavs[] = new AvDesav($item);
		}
		return $avdesavs;
	}

	/**
	 * getDistinctCategories
	 *
	 * @return array of all distinct categories
	 */
	public function getDistinctCategories(): array
	{
		$query = $this->db->query("SELECT DISTINCT Catégorie FROM av_desav");
		$items = $query->fetchAll(\PDO::FETCH_ASSOC);
		$query->closeCursor();
		$categories = ["Mixtes", "Avantages", "Désavantages physiques", "Désavantages sociaux", "Désavantages mentaux", "Désavantages vertueux", "Traits de caractère", "Caractéristiques secondaires", "PNJ", "Avantages surnaturels", "Psi"]; // default order
		foreach ($items as $item) {
			if (!in_array($item["Catégorie"], $categories)) $categories[] = $item["Catégorie"];
		}
		return $categories;
	}

	public function updateAvdesav(array $data): void{
		//id Nom Catégorie Coût Niv Pouvoir Description
		
		// correcting accented indexes
		$data["Categorie"] = htmlspecialchars($data["Catégorie"]);
		unset($data["Catégorie"]);
		$data["Cout"] = $data["Coût"];
		unset($data["Coût"]);
		
		$query = $this->db->prepare("UPDATE av_desav SET Nom = :Nom, Catégorie = :Categorie, Coût = :Cout, Niv = :Niv, Pouvoir = :Pouvoir, Description = :Description WHERE id = :id");
		$query->execute($data);
		$query->closeCursor();
	}
	
	public function createAvdesav(array $data): void{
		//id Nom Catégorie Coût Niv Pouvoir Description
		
		// correcting accented indexes
		$data["Categorie"] = htmlspecialchars($data["Catégorie"]);
		unset($data["Catégorie"]);
		$data["Cout"] = $data["Coût"];
		unset($data["Coût"]);
		unset($data["id"]);
		
		$query = $this->db->prepare("INSERT INTO av_desav (Nom, Catégorie, Coût, Niv, Pouvoir, Description) VALUES (:Nom, :Categorie, :Cout, :Niv, :Pouvoir, :Description)");
		$query->execute($data);
		$query->closeCursor();
	}

	public function deleteAvdesav(int $id): void{
		$query = $this->db->prepare("DELETE FROM av_desav WHERE id = ?");
		$query->execute([$id]);
		$query->closeCursor();
	}
}
