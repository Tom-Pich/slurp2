<?php

namespace App\Entity;

use App\Lib\Sorter;
use App\Repository\DisciplineRepository;

class Discipline
{
	public int $id;
	public string $name;
	public string $description;

	const costs = [10, 15, 20, 35, 60];

	public function __construct(array $discipline)
	{
		$this->id = $discipline["id"] ?? 0;
		if ($this->id) {
			$this->name = $discipline["Nom"];
			$this->description = $discipline["Description"];
		}
	}

	public static function processDisciplines($raw_psi)
	{
		if (empty($raw_psi)) {
			return [[], 0];
		}
		$raw_disciplines = array_filter($raw_psi, fn ($x) => $x["catégorie"] === "discipline");
		$repo = new DisciplineRepository;
		$disciplines = [];
		$detailled_points = [];
		$points = 0;

		foreach ($raw_disciplines as $item) {
			$item_entity = $repo->getDiscipline($item["id"]);
			$item["nom"] = $item_entity->name;
			unset($item["catégorie"]);
			$disciplines[] = $item;
			$detailled_points[] = self::costs[$item["niv"] - 1] * ($item["mult"] ?? 1);
		}

		$disciplines = Sorter::sort($disciplines, "nom");

		if(!empty($detailled_points)){$points = 0.5 * max($detailled_points) + 0.5 * (array_sum($detailled_points));}
		
		$points = ceil($points * 2) / 2;

		return [$disciplines, $points];
	}
}
