<?php

namespace App\Repository;

use App\Entity\PsiPower;
use App\Repository\AbstractRepository;

class PsiPowerRepository extends AbstractRepository
{
	public function getPower(int $id) : ?PsiPower
	{
		$query = $this->db->prepare("SELECT * FROM psi_pouvoirs WHERE id = ?");
		$query->execute([$id]);
		$item = $query->fetch(\PDO::FETCH_ASSOC);
		$query->closeCursor();

		if (!$item) return null;

		$power = new PsiPower($item);
		return $power;
	}

	public function getAllPowers()
	{
		$query = $this->db->query("SELECT * FROM psi_pouvoirs ORDER BY Nom");
		$items = $query->fetchAll(\PDO::FETCH_ASSOC);
		$query->closeCursor();

		$powers = [];
		foreach ($items as $item) {
			$power = new PsiPower($item);
			$powers[] = $power;
		}

		return $powers;
	}

	public function getPowersByDiscipline(int $id)
	{
		$query = $this->db->prepare("SELECT * FROM psi_pouvoirs WHERE json_contains(Discipline, ?) ORDER BY Nom");
		$query->execute([$id]);
		$items = $query->fetchAll(\PDO::FETCH_ASSOC);
		$query->closeCursor();
		$powers = [];
		foreach ($items as $item) {
			$powers[] = new PsiPower($item);
		}
		return $powers;
	}

	/**
	 * getDistinctOrigins
	 *
	 * @return array like [origine1, origine2, ...]
	 */
	function getDistinctOrigins(): array
	{
		$query = $this->db->query("SELECT DISTINCT Origine FROM psi_pouvoirs");
		$result = $query->fetchAll(\PDO::FETCH_ASSOC);
		$query->closeCursor();
		$origins = [];
		foreach ($result as $item) {
			$origins[] = $item["Origine"];
		}
		return $origins;
	}

		
	public function updatePsiPower(array $data): void{
		// id, Nom, Niv, Discipline, Classe, Durée, Temps, Zone, Résistance, Description, Origine
		
		// correcting accented indexes
		$data["Duree"] = $data["Durée"];
		unset($data["Durée"]);
		$data["Resistance"] = $data["Résistance"];
		unset($data["Résistance"]);
		
		$query = $this->db->prepare("UPDATE psi_pouvoirs SET Nom = :Nom, Niv = :Niv, Discipline = :Discipline, Classe = :Classe, Durée = :Duree, Temps = :Temps, Zone = :Zone, Résistance = :Resistance, Description = :Description, Origine = :Origine WHERE id = :id");
		$query->execute($data);
		$query->closeCursor();
	}
	
	public function createPsiPower(array $data): void{
		// correcting accented indexes
		$data["Duree"] = $data["Durée"];
		unset($data["Durée"]);
		$data["Resistance"] = $data["Résistance"];
		unset($data["Résistance"]);
		unset($data["id"]);
		
		$query = $this->db->prepare("INSERT INTO psi_pouvoirs (Nom, Niv, Discipline, Classe, Durée, Temps, Zone, Résistance, Description, Origine) VALUES (:Nom, :Niv, :Discipline, :Classe, :Duree, :Temps, :Zone, :Resistance, :Description, :Origine)");
		$query->execute($data);
		$query->closeCursor();
	}

	public function deletePsiPower(int $id): void{
		$query = $this->db->prepare("DELETE FROM psi_pouvoirs WHERE id = ?");
		$query->execute([$id]);
		$query->closeCursor();
	}
}
