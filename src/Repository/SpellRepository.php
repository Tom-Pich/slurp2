<?php

namespace App\Repository;

use App\Entity\Spell;
use App\Repository\AbstractRepository;

class SpellRepository extends AbstractRepository
{
	/**
	 * getSpell
	 *
	 * @param  int $id
	 * @return Spell
	 */
	function getSpell(int $id): ?Spell
	{
		$query = $this->db->prepare("SELECT * FROM magie_sorts WHERE id = ?");
		$query->execute([$id]);
		$item = $query->fetch(\PDO::FETCH_ASSOC);
		$query->closeCursor();

		if (!$item) return null;
		
		$spell = new Spell($item);
		return $spell;
	}

	/**
	 * getAllSpells
	 *
	 * @return array Array of all spells
	 */
	function getAllSpells(): array
	{
		$query = $this->db->query("SELECT * FROM magie_sorts ORDER BY Nom");
		$items = $query->fetchAll(\PDO::FETCH_ASSOC);
		$query->closeCursor();
		$spells = [];
		foreach ($items as $item) {
			$spells[] = new Spell($item);
		}
		return $spells;
	}

	/**
	 * getSpellsByCollege
	 *
	 * @param int id id of the college
	 * @return array spells from given college
	 */
	function getSpellsByCollege(int $id): array
	{
		$query = $this->db->prepare("SELECT * FROM magie_sorts WHERE json_contains(Collège, ?) ORDER BY Nom");
		$query->execute([$id]);
		$items = $query->fetchAll(\PDO::FETCH_ASSOC);
		$query->closeCursor();
		$spells = [];
		foreach ($items as $item) {
			$spells[] = new Spell($item);
		}
		return $spells;
	}

	/**
	 * getSpellsByOrigin
	 *
	 * @param string origin
	 * @return array spells from given origin
	 */
	function getSpellsByOrigin(string $origin): array
	{
		$query = $this->db->prepare("SELECT * FROM magie_sorts WHERE Origine = ? ORDER BY Nom");
		$query->execute([$origin]);
		$items = $query->fetchAll(\PDO::FETCH_ASSOC);
		$query->closeCursor();
		$spells = [];
		foreach ($items as $item) {
			$spells[] = new Spell($item);
		}
		return $spells;
	}

	function getDistinctClasses():array
	{
		$query = $this->db->query("SELECT DISTINCT Classe FROM magie_sorts");
		$result = $query->fetchAll(\PDO::FETCH_ASSOC);
		$query->closeCursor();
		$classes = [];
		foreach ($result as $item){
			!is_null($item["Classe"]) ? $classes[] = $item["Classe"] : "";
		}
		return $classes;
	}
		
	/**
	 * getDistinctOrigins
	 *
	 * @return array like [origine1, origine2, ...]
	 */
	function getDistinctOrigins():array
	{
		$query = $this->db->query("SELECT DISTINCT Origine FROM magie_sorts");
		$result = $query->fetchAll(\PDO::FETCH_ASSOC);
		$query->closeCursor();
		$origins = [];
		foreach ($result as $item){
			$origins[] = $item["Origine"];
		}
		return $origins;
	}

	
	public function updateSpell(array $data): void{
		// id, Nom, Niv, Collège, Classe, Durée, Temps, Zone, Résistance, Description, Origine
		
		// correcting accented indexes
		$data["College"] = $data["Collège"];
		unset($data["Collège"]);
		$data["Duree"] = $data["Durée"];
		unset($data["Durée"]);
		$data["Resistance"] = $data["Résistance"];
		unset($data["Résistance"]);
		
		$query = $this->db->prepare("UPDATE magie_sorts SET Nom = :Nom, Niv = :Niv, Collège = :College, Classe = :Classe, Durée = :Duree, Temps = :Temps, Zone = :Zone, Résistance = :Resistance, Description = :Description, Origine = :Origine WHERE id = :id");
		$query->execute($data);
		$query->closeCursor();
	}
	
	public function createSpell(array $data): void{
		// correcting accented indexes
		$data["College"] = $data["Collège"];
		unset($data["Collège"]);
		$data["Duree"] = $data["Durée"];
		unset($data["Durée"]);
		$data["Resistance"] = $data["Résistance"];
		unset($data["Résistance"]);
		unset($data["id"]);
		
		$query = $this->db->prepare("INSERT INTO magie_sorts (Nom, Niv, Collège, Classe, Durée, Temps, Zone, Résistance, Description, Origine) VALUES (:Nom, :Niv, :College, :Classe, :Duree, :Temps, :Zone, :Resistance, :Description, :Origine)");
		$query->execute($data);
		$query->closeCursor();
	}

	public function deleteSpell(int $id): void{
		$query = $this->db->prepare("DELETE FROM magie_sorts WHERE id = ?");
		$query->execute([$id]);
		$query->closeCursor();
	}
}
