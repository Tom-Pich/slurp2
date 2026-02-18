<?php

namespace App\Controller;

use App\Entity\Character;
use App\Lib\Sorter;

class CharacterExportController
{
	public static function exportCharacter(int $id)
	{
		date_default_timezone_set('Europe/Paris');
		$date = date('ymd-His', time());

		$character = new Character($id);
		$process_state_data = false;
		$character->processCharacter($process_state_data);

		$myfile = fopen("./characters-backup/" . str_pad($id, 4, '0', STR_PAD_LEFT) . "-" . $date . " " . $character->name . ".txt", "w");

		// Nom, points, points éco
		$base = sprintf("%s – %u pts (%s pts éco)", $character->name, $character->points, $character->points - $character->points_count["total"]);
		fwrite($myfile, $base . "\n");

		// Caractéristiques principales
		$attributes = sprintf("For %s ; Dex %s ; Int %s ; San %s ; Per %s ; Vol %s", $character->attributes["For"], $character->attributes["Dex"], $character->attributes["Int"], $character->attributes["San"], $character->attributes["Per"], $character->attributes["Vol"]);
		fwrite($myfile, $attributes . "\n\n");

		// Avantages & désavantages
		$avdesavs = "";
		$character->avdesav = Sorter::sort($character->avdesav, "nom");
		$character->avdesav = Sorter::sort($character->avdesav, "catégorie");
		foreach ($character->avdesav as $avdesav) {
			$avdesavs .= sprintf("%s (%s) ; ", $avdesav["nom"], $avdesav["points"]);
		}
		$avdesavs = rtrim($avdesavs, "; ");
		fwrite($myfile, $avdesavs . "\n\n");

		// Compétences
		$skills = "## Compétences\n";
		foreach ($character->skills as $skill) {
			$skills .= sprintf("%s – %s ; ", $skill["label"], $skill["score"]);
		}
		$skills = rtrim($skills, "; ");
		fwrite($myfile, $skills . "\n\n");

		// Magie
		if ($character->special_traits["magerie"]) {

			fwrite($myfile, "## Collèges & Sorts" . "\n");

			foreach ($character->colleges as $college) {
				$colleges_block = sprintf("%s [%s] – %s\n", htmlspecialchars_decode($college["name"]), $college["points"], $college["score"]);
				foreach ($character->spells as $sort) {
					if (in_array($college["id"], $sort["data"]->colleges) && $sort["points"] > 0) {
						$colleges_block .= sprintf("- %s [%s] – %s\n", $sort["label"], $sort["points"], $sort["readable_scores"]);
					}
				}
				fwrite($myfile, $colleges_block . "\n");
			}
		}

		// Pouvoirs
		if ($character->special_traits["pouvoirs"]) {

			fwrite($myfile, "## Pouvoirs" . "\n");

			$powers_block = "";
			foreach ($character->powers as $pouvoir) {
				$powers_block .= sprintf("%s – %s\n", $pouvoir["label"], $pouvoir["score"]);
			}
			fwrite($myfile, $powers_block . "\n");
		}

		// Psi
		if ($character->special_traits["psi"]) {

			fwrite($myfile, "## Aptitudes psioniques" . "\n");

			foreach ($character->disciplines as $discipline) {
				$psi_block = sprintf("%s Niv. %s", $discipline["nom"], $discipline["niv"]);
				if (!empty($discipline["mult"])) {
					$psi_block = $psi_block . " (×" . $discipline["mult"] . ")";
				}
				if (!empty($discipline["notes"])) {
					$psi_block = $psi_block . " – " . $discipline["notes"];
				}
				$psi_block .= "\n";

				foreach ($character->psi as $pouvoir) {
					if (in_array($discipline["id"], $pouvoir["data"]->data->colleges) and $pouvoir["points"]) {
						$psi_block .= sprintf("- %s [%s] – %s\n", $pouvoir["data"]->name, $pouvoir["points"], $pouvoir["readable-score"]);
					}
				}

				fwrite($myfile, $psi_block . "\n");
			}
		}

		// Possessions
		fwrite($myfile, "## Possessions" . "\n");
		foreach ($character->equipment as $place) {
			if (!empty($place["liste"])) {
				$sublist_block = $place["nom"] . "\n";
				foreach ($place["liste"] as $item) {
					$sublist_block .= sprintf("- %s (%s kg)", $item->name, $item->weight);
					if ($item->notes) {
						$sublist_block .= (" – " . $item->notes);
					}
					if ($item->secret) {
						$sublist_block .= (" – " . $item->secret);
					}
					$sublist_block .= "\n";
				}

				fwrite($myfile, $sublist_block . "\n");
			}
		}

		// Fin de l’export
		fclose($myfile);
		echo "✅";
	}
}
