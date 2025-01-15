<?php

namespace App\Repository;

use App\Entity\Skill;
use App\Lib\Sorter;
use App\Repository\AbstractRepository;

class SkillRepository extends AbstractRepository
{
	/**
	 * getSkill
	 *
	 * @param  int $id
	 * @return Skill
	 */
	public function getSkill(int $id): ?Skill
	{
		$query = $this->db->prepare("SELECT * FROM competences WHERE id = ?");
		$query->execute([$id]);
		$item = $query->fetch(\PDO::FETCH_ASSOC);
		$query->closeCursor();

		if (!$item) return null;

		$skill = new Skill($item);
		return $skill;
	}

	/**
	 * getAllSkills
	 *
	 * @return array Array of all skills
	 */
	function getAllSkills(): array
	{
		$query = $this->db->query("SELECT * FROM competences ORDER BY Nom");
		$items = $query->fetchAll(\PDO::FETCH_ASSOC);
		$query->closeCursor();
		$items = Sorter::sort($items, "Nom");
		$skills = [];
		foreach ($items as $item) {
			$skills[] = new Skill($item);
		}
		return $skills;
	}

	/**
	 * getSkillByCategorie
	 *
	 * @param string name of category as in database
	 * @return array skills from given category
	 */
	function getSkillsByCategory(string $category): array
	{
		$query = $this->db->prepare("SELECT * FROM competences WHERE Catégorie = ? ORDER BY Nom");
		$query->execute([$category]);
		$items = $query->fetchAll(\PDO::FETCH_ASSOC);
		$query->closeCursor();
		$items = Sorter::sort($items, "Nom");
		$skills = [];
		foreach ($items as $item) {
			$skills[] = new Skill($item);
		}
		return  $skills;
	}

	/**
	 * getDistinctCategories
	 *
	 * @return array of all distinct categories
	 */
	function getDistinctCategories(): array
	{
		$query = $this->db->query("SELECT DISTINCT Catégorie FROM competences");
		$items = $query->fetchAll(\PDO::FETCH_ASSOC);
		$query->closeCursor();
		$categories = [];
		foreach ($items as $item) {
			$categories[] = $item["Catégorie"];
		}
		return $categories;
	}

	public function updateSkill(array $data): void
	{
		// id, Nom, Catégorie, Base, Difficulté, Description

		// correcting accented indexes
		$data["Categorie"] = $data["Catégorie"];
		unset($data["Catégorie"]);
		$data["Difficulte"] = $data["Difficulté"];
		unset($data["Difficulté"]);

		$query = $this->db->prepare("UPDATE competences SET Nom = :Nom, Catégorie = :Categorie, Base = :Base, Difficulté = :Difficulte, Description = :Description WHERE id = :id");
		$query->execute($data);
		$query->closeCursor();
	}

	public function createSkill(array $data): void
	{
		// correcting accented indexes
		$data["Categorie"] = $data["Catégorie"];
		unset($data["Catégorie"]);
		$data["Difficulte"] = $data["Difficulté"];
		unset($data["Difficulté"]);
		unset($data["id"]);

		$query = $this->db->prepare("INSERT INTO competences (Nom, Catégorie, Base, Difficulté, Description) VALUES (:Nom, :Categorie, :Base, :Difficulte, :Description)");
		$query->execute($data);
		$query->closeCursor();
	}

	public function deleteSkill(int $id): void
	{
		$query = $this->db->prepare("DELETE FROM competences WHERE id = ?");
		$query->execute([$id]);
		$query->closeCursor();
	}
}
