<?php

global $bdd;
$query = $bdd->query("Select id, Avdesav from persos");
$characters = $query->fetchAll(\PDO::FETCH_ASSOC);

foreach ($characters as $character) {

	$new_format_list = [];
	$character["Avdesav"] = json_decode($character["Avdesav"], true);

	if (!empty($character["Avdesav"])) {

		//var_dump($character["Pouvoirs"]);
		
		foreach ($character["Avdesav"] as $item) {

			$f_item = [];

			$f_item["id"] = (int) $item["id_RdB"];
			$f_item["nom"] = $item["Nom"];
			$f_item["points"] = (float) $item["Coût"];

			if (!empty($item["Options"])) {
				$f_item["options"] = $item["Options"] ;
			}

			$new_format_list[] = $f_item;
		}
	}

	//var_dump($new_format_list);

	$character["Avdesav"] = json_encode($new_format_list, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); 
	

	$query = $bdd->prepare("UPDATE persos set Avdesav = ? WHERE id = ? ");
	$query->execute([$character["Avdesav"], $character["id"]]);

}