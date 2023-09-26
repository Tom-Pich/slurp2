<?php

global $bdd;
$query = $bdd->query("Select id, Pouvoirs from persos");
$characters = $query->fetchAll(\PDO::FETCH_ASSOC);

foreach ($characters as $character) {

	$new_format_list = [];
	$character["Pouvoirs"] = json_decode($character["Pouvoirs"], true);

	if (!empty($character["Pouvoirs"])) {

		//var_dump($character["Pouvoirs"]);
		
		foreach ($character["Pouvoirs"] as $item) {

			$f_item = [];

			$f_item["id"] = (int) $item["id_RdB"];
			$f_item["niv"] = (int) $item["Niv_p"];
			$f_item["points"] = (int) $item["Pts"];
			$f_item["origine"] = strtolower($item["Origine"]);

			if (!empty($item["Modif"])) {
				$f_item["modif"] = (int) $item["Modif"];
			}
			if (!empty($item["Mult"])) {
				$f_item["mult"] = (float) $item["Mult"];
			}
			if (!empty($item["Notes"])) {
				$f_item["notes"] = $item["Notes"];
			}

			$new_format_list[] = $f_item;
		}
	}

	$character["Pouvoirs"] = json_encode($new_format_list, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); 
	

	$query = $bdd->prepare("UPDATE persos set Pouvoirs = ? WHERE id = ? ");
	$query->execute([$character["Pouvoirs"], $character["id"]]);

}