<?php

use App\Entity\Skill;

global $bdd;
$query = $bdd->query("Select id, Psi from persos");
$characters = $query->fetchAll(\PDO::FETCH_ASSOC);
foreach ($characters as $character) {

	$new_format_list = [];

	if (!empty($character["Psi"])) {
		$character["Psi"] = json_decode($character["Psi"], true);
		foreach ($character["Psi"] as $item) {

			$f_item = [];

			$f_item["id"] = $item["id_RdB"];

			if (!empty($item["Modif"])) {
				$f_item["modif"] = (int) $item["Modif"];
			}

			if (!empty($item["Notes"])) {
				$f_item["notes"] = $item["Notes"];
			}

			if (!empty($item["Mul"])) {
				$f_item["mult"] = $item["Mult"];
			}
			
			if($item["Catégorie"] === "Discipline"){
				$f_item["catégorie"] = "discipline";
				$f_item["niv"] = (int) $item["Niv"];
				$f_item["niv"] = (int) $item["Niv"];
				//
			} elseif($item["Catégorie"] === "Pouvoir"){
				$f_item["catégorie"] = "pouvoir";
				$f_item["niv"] = Skill::cost2niv((int) $item["Pts"], -6);
			}

			$new_format_list[] = $f_item;
		}
	}

	//var_dump($new_format_list);
	$character["Psi"] = json_encode($new_format_list, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); 

	$query = $bdd->prepare("UPDATE persos set Psi = ? WHERE id = ? ");
	$query->execute([$character["Psi"], $character["id"]]);

}