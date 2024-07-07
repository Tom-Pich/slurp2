<?php

namespace App\Repository;

use App\Entity\College;
use App\Repository\AbstractRepository;

class CollegeRepository extends AbstractRepository
{

	// For now, only read functionalities.
	// modify description directly in DB

	/**
	 * getCollege
	 *
	 * @param  int $id
	 * @return College
	 */
	public function getCollege(int $id): ?College
	{
		$query = $this->db->prepare("SELECT * FROM magie_colleges WHERE id = ?");
		$query->execute([$id]);
		$item = $query->fetch(\PDO::FETCH_ASSOC);
		$query->closeCursor();

		if (!$item) {
			return null;
		}
		$college = new College($item);
		return $college;
	}

	/**
	 * getAllColleges
	 *
	 * @return array of all colleges
	 */
	public function getAllColleges(): array
	{
		$query = $this->db->query("SELECT * FROM magie_colleges");
		$items = $query->fetchAll(\PDO::FETCH_ASSOC);
		$query->closeCursor();
		foreach ($items as $item) {
			$colleges[] = new College($item);
		}
		return $colleges;
	}
	
	/**
	 * getCollegesName – return indexed colleges array id=>name
	 *
	 * @return array
	 */
	public function getCollegesName(): array
	{
		$query = $this->db->query("SELECT id, Nom FROM magie_colleges");
		$items = $query->fetchAll(\PDO::FETCH_ASSOC);
		$query->closeCursor();
		foreach ($items as $item) {
			$colleges[$item["id"]] = $item["Nom"];
		}
		return $colleges;
	}
}
