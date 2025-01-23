<?php

namespace App\Entity;

use App\Lib\TextParser;
use App\Repository\DisciplineRepository;
use App\Repository\PsiPowerRepository;

class PsiPower extends AbstractSpell
{
	public array $disciplines;
	public array $disciplinesName;
	const niv_modifier = [0, -1, -2, -3, -4];
	const pdf_cost = [1, 2, 3, 4, 8];
	const pdf_cost_modifier = [0, 0, -1, -2, -3];

	public function __construct($item = [])
	{
		parent::__construct($item);
		$this->disciplines = json_decode($item["Discipline"] ?? "[]");
	}

	// return array of discipline names of the power
	public function disciplineNames(): array
	{
		$discipline_repo = new DisciplineRepository;
		$all_disciplines_name = $discipline_repo->getDisciplinesName();
		$disciplines_name = [];
		foreach ($this->disciplines as $id) {
			$disciplines_name[] = $all_disciplines_name[$id];
		}
		return $disciplines_name;
	}

	public static function processPowers(array $raw_psi, array $disciplines, array $attributes)
	{
		$raw_powers = array_filter($raw_psi, fn($x) => $x["catégorie"] === "pouvoir");
		$repo = new PsiPowerRepository;
		$disciplines_id_niv = [];
		$powers_data = [];
		$powers = [];
		$points = 0;

		foreach ($disciplines as $discipline) {
			$powers_data = array_merge($powers_data, $repo->getPowersByDiscipline($discipline["id"]));
			$disciplines_id_niv[$discipline["id"]] = $discipline["niv"];
		}

		foreach ($powers_data as $power_entity) {
			$f_power = [];
			$known_power_data = array_filter($raw_powers, fn($x) => $x["id"] === $power_entity->id);
			$known_power_data = array_values($known_power_data)[0] ?? [];
			$f_power["id"] = $power_entity->id;
			$f_power["niv"] = $known_power_data["niv"] ?? Skill::cost2niv(0, -6, "I");
			$f_power["modif"] = $known_power_data["modif"] ?? 0;
			$f_power["points"] = Skill::niv2cost($f_power["niv"], -6, "I");

			// best discipline niv of power
			$discipline_niv = 0;
			foreach ($power_entity->disciplines as $discipline_id) {
				$discipline_niv = $disciplines_id_niv[$discipline_id] > $discipline_niv ? $disciplines_id_niv[$discipline_id] : $discipline_niv;
			}
			$f_power["discipline-niv"] = $discipline_niv;

			// power score
			$f_power["base-score"] = $attributes["Int"] + $f_power["niv"] + $f_power["modif"];
			if ($f_power["points"] == 0) {
				$f_power["readable-score"] = null;
			} else {
				for ($i = 1; $i <= 5; $i++) {
					$f_power["scores"][$i] = $power_entity->niv_min <= $i && $power_entity->niv_max >= $i && $discipline_niv >= $i  ?
						$f_power["base-score"] + self::niv_modifier[$i - 1] : null;
				}
				$f_power["readable-score"] = implode("/", $f_power["scores"]);
				$f_power["readable-score"] = trim($f_power["readable-score"], "/");
			}

			// power cost in PdF
			$f_power["cost-modifier"] = self::pdf_cost_modifier[$f_power["discipline-niv"] - 1];
			for ($i = 1; $i <= 5; $i++) {
				$f_power["costs"][$i] = $power_entity->niv_min <= $i && $power_entity->niv_max >= $i && $discipline_niv >= $i  ?
					max(self::pdf_cost[$i - 1] + $f_power["cost-modifier"], 0) : null;
			}
			$f_power["readable-cost"] = implode("/", $f_power["costs"]);
			$f_power["readable-cost"] = trim($f_power["readable-cost"], "/");

			$f_power["data"] = $power_entity;
			$powers[] = $f_power;
			$points += $f_power["points"];
		}

		return [$powers, $points];
	}

	public static function processSubmitPower(array $post): void
	{
		// id, Nom, Niv, Discipline, Classe, Durée, Temps, Zone, Résistance, Description, Origine
		var_dump($post);
		$psi = [];
		$psi["id"] = (int) $post["id"];
		$psi["Nom"] = $post["Nom"];

		$niv = "(" . $post["Niv"] . ")";
		$niv = str_replace(" ", "", $niv);
		$psi["Niv"] = TextParser::parseLatin2Numbers($niv);
		if (!isset($psi["Niv"][0]) || $psi["Niv"][0] < 1 || $psi["Niv"][0] > ($psi["Niv"][1] ?? 5)) {
			$psi["Niv"][0] = 1;
		}
		if (isset($psi["Niv"][1]) && ($psi["Niv"][1] > 5 || $psi["Niv"][1] < $psi["Niv"][0])) {
			$psi["Niv"][1] = 5;
		}
		if (isset($psi["Niv"][1]) && $psi["Niv"][1] === $psi["Niv"][0]) {
			unset($psi["Niv"][1]);
		}
		$psi["Niv"] = json_encode($psi["Niv"], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

		$disciplines = explode(",", $post["Discipline"]);
		foreach ($disciplines as $id) {
			$psi["Discipline"][] = (int) $id;
		}
		if (!array_sum($psi["Discipline"])) {
			$psi["Discipline"] = [1];
		}
		$psi["Discipline"] = json_encode($psi["Discipline"], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

		foreach (["Classe", "Durée", "Temps", "Zone", "Résistance"] as $entry) {
			$psi[$entry] = $post[$entry] ? $post[$entry] : NULL;
		}

		$psi["Description"] = $post["Description"] ? $post["Description"] : NULL;
		$psi["Origine"] = $post["Origine"] ? $post["Origine"] : NULL;

		$repo = new PsiPowerRepository;

		if ($psi["Nom"] && $psi["id"]) {
			$repo->updatePsiPower($psi);
		} elseif (!$psi["Nom"] && $psi["id"]) {
			$repo->deletePsiPower($psi["id"]);
		} elseif ($psi["Nom"] && !$psi["id"]) {
			$repo->createPsiPower($psi);
		}
	}
}
