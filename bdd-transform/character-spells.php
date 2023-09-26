<?php

use App\Entity\Skill;

global $bdd;
$query = $bdd->query("Select id, Sorts from persos");
$characters = $query->fetchAll(\PDO::FETCH_ASSOC);
foreach ($characters as $character) {

	$new_format_list = [];

	if (!empty($character["Sorts"])) {
		$character["Sorts"] = json_decode($character["Sorts"] ?? "[]", true);
		foreach ($character["Sorts"] as $item) {

			$f_item = [];

			$f_item["id"] = $item["id_RdB"];

			if (!empty($item["Modif"])) {
				$f_item["modif"] = (int) $item["Modif"];
			}
			
			if($item["Catégorie"] === "Collège"){
				$f_item["catégorie"] = "collège";
				$f_item["niv"] = Skill::cost2niv((int) $item["Pts"], -8);
				//
			} elseif($item["Catégorie"] === "Sort"){
				$f_item["catégorie"] = "sort";
				$f_item["points"] = (int) $item["Pts"];
			}

			$new_format_list[] = $f_item;
		}
	}

	$character["Sorts"] = json_encode($new_format_list, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); 

	$query = $bdd->prepare("UPDATE persos set Sorts = ? WHERE id = ? ");
	$query->execute([$character["Sorts"], $character["id"]]);

}