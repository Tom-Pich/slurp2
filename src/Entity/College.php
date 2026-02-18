<?php

namespace App\Entity;

use App\Lib\Sorter;
use App\Repository\CollegeRepository;

//  id Nom Description
class College
{
	public int $id;
	public string $name;
	public string $description;

	public function __construct(array $college = ["id" => 0])
	{
		$this->id = $college["id"];
		if ($this->id) {
			$this->name = $college["Nom"];
			$this->description = $college["Description"];
		}
	}
	
	/**
	 * processColleges – process colleges data from character
	 *
	 * @param  array $spells raw spells and colleges list from database
	 * @param  array $attribute
	 * @param  array $state
	 * @param array $special_traits
	 * @return array of processed colleges
	 */
	public static function processColleges(array $spells, array $attributes, array $modifiers, array $special_traits): array
	{
		$colleges = [];
		$repo = new CollegeRepository;
		$points = 0;

		foreach ($spells as $item) {
			if ($item["catégorie"] === "collège") {
				$id = $item["id"];
				$college_entity = $repo->getCollege($id);
				$item["name"] = $college_entity->name;
				$item["niv"] = max($item["niv"], -3);
				$item["points"] = Skill::niv2cost($item["niv"], -8, "I");
				$item["modif"] = $item["modif"] ?? 0; 
				$item["score"] = $attributes["Int"] + $item["niv"] + $item["modif"] + $modifiers["Magie"] + $special_traits["magerie"] - 3 + floor($special_traits["mult-memoire-infaillible"]/2);
				if ($attributes["Int"] === 0) $item["score"] = 0; // when character is in very bad state

				if ($item["modif"] > 0) {
					$item["name"] .= ' (+' . $item["modif"] . ')';
				} elseif ($item["modif"] < 0) {
					$item["name"] .= ' (' . $item["modif"] . ')';
				}

				$points += $item["points"];
				$colleges[] = $item;
				$colleges = Sorter::sort($colleges, "name");
			}
		}

		return [$colleges, $points];
	}

}
