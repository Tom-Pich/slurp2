<?php

namespace App\Repository;

use App\Entity\Creature;

class CreatureRepository extends AbstractRepository
{

	public const db_columns = ["Nom", "Origine", "Catégorie", "Pds1", "Pds2", "Options", "Taille", "Int", "RD", "Vitesse", "Description", "Avdesav", "Pouvoirs", "Combat", "Image" ];

	public function getCreature(int $id): ?Creature
	{
		$query = $this->db->prepare("SELECT * FROM creatures WHERE id = ?");
		$query->execute([$id]);
		$item = $query->fetch(\PDO::FETCH_ASSOC);

		if(!$item)return NULL;
		
		$creature = new Creature($item);
		return $creature;
	}

	public function getDistinctCategories(?string $origin = null): array
	{
		if ($origin) {
			$query = $this->db->prepare("SELECT DISTINCT Catégorie FROM creatures WHERE Origine = ? ORDER BY Catégorie");
			$query->execute([$origin]);
		} else {
			$query = $this->db->query("SELECT DISTINCT Catégorie FROM creatures ORDER BY Catégorie");
		}
		$categories = [];
		while ($item = $query->fetch(\PDO::FETCH_ASSOC)) {
			$categories[] = $item["Catégorie"];
		}
		return $categories;
	}

	public function getDistinctOrigins(): array
	{
		$query = $this->db->query("SELECT DISTINCT Origine FROM creatures");
		$origins = [];
		while ($item = $query->fetch(\PDO::FETCH_ASSOC)) {
			$origins[] = $item["Origine"];
		}
		return $origins;
	}

	public function getCreaturesByCategory(string $category, ?string $origin = null)
	{
		if ($origin) {
			$query = $this->db->prepare("SELECT * FROM creatures WHERE Catégorie = ? AND Origine = ? ORDER BY Nom");
			$query->execute([$category, $origin]);
		} else {
			$query = $this->db->prepare("SELECT * FROM creatures WHERE Catégorie = ? ORDER BY Nom");
			$query->execute([$category]);
		}
		$items = $query->fetchAll(\PDO::FETCH_ASSOC);
		$creatures = [];
		foreach ($items as $item) {
			$creatures[] = new Creature($item);
		}
		return $creatures;
	}

	public function updateCreature(array $data): void{
		
		// correcting accented indexes
		$data["Categorie"] = $data["Catégorie"];
		unset($data["Catégorie"]);
		
		$query = $this->db->prepare("UPDATE creatures SET Nom = :Nom, Origine = :Origine, Catégorie = :Categorie, Pds1 = :Pds1, Pds2 = :Pds2, Options = :Options, Taille = :Taille, `Int` = :Int, RD = :RD, Vitesse = :Vitesse, Description = :Description, Avdesav = :Avdesav, Pouvoirs = :Pouvoirs, Combat = :Combat, Image = :Image WHERE id = :id");
		$query->execute($data);
		$query->closeCursor();
	}
	
	public function createCreature(array $data): void{
		// correcting accented indexes and Int entry
		$data["Categorie"] = $data["Catégorie"];
		unset($data["Catégorie"]);
		$data["Intelligence"] = $data["Int"];
		unset($data["Int"]);
		unset($data["id"]);
		
		$query = $this->db->prepare("INSERT INTO creatures (Nom, Origine, Catégorie, Pds1, Pds2, Options, Taille, `Int`, RD, Vitesse, Description, Avdesav, Pouvoirs, Combat, Image) VALUES (:Nom, :Origine, :Categorie, :Pds1, :Pds2, :Options, :Taille, :Intelligence, :RD, :Vitesse, :Description, :Avdesav, :Pouvoirs, :Combat, :Image)");
		$query->execute($data);
		$query->closeCursor();
	}

	public function deleteCreature(int $id): void{
		$query = $this->db->prepare("DELETE FROM creatures WHERE id = ?");
		$query->execute([$id]);
		$query->closeCursor();
	}

}
