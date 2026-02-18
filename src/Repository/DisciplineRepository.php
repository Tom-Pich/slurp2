<?php

namespace App\Repository;

use App\Entity\Discipline;

class DisciplineRepository extends AbstractRepository
{
	/**
	 * getDiscipline
	 *
	 * @param  int $id
	 * @return Discipline
	 */
	public function getDiscipline(int $id): Discipline
	{
		$query = $this->db->prepare("SELECT * FROM psi_disciplines WHERE id = ?");
		$query->execute([$id]);
		$item = $query->fetch(\PDO::FETCH_ASSOC);
		$query->closeCursor();

		if (!$item) {
			return null;
		}
		$discipline = new Discipline($item);
		return $discipline;
	}

	
	public function getAllDisciplines(): array
	{
		$query = $this->db->query("SELECT * FROM psi_disciplines");
		$items = $query->fetchAll(\PDO::FETCH_ASSOC);
		$query->closeCursor();

		$disciplines = [];
		foreach($items as $item){
			$discipline = new Discipline($item);
			$disciplines[] = $discipline;
		}
		return $disciplines;
	}
	
	/**
	 * getDisciplinesName
	 *
	 * @return array like [id => name, ...]
	 */
	public function getDisciplinesName(): array{
		$query = $this->db->query("SELECT id, Nom FROM psi_disciplines");
		$items = $query->fetchAll(\PDO::FETCH_ASSOC);
		$query->closeCursor();

		$disciplines_name = [];
		foreach($items as $item){
			$disciplines_name[$item["id"]] = $item["Nom"];
		}
		return $disciplines_name; 
	}

}
