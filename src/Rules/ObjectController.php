<?php

namespace App\Rules;
use App\Lib\TableReader;
use App\Lib\DiceManager;

class ObjectController
{
	public const object_types = [
		"voiture" => [
			"localisations" => [
				"avant" => [2 => "Moteur", 4 => "Occupant", 5 => "Équipement divers", 6 => "Roue"],
				"latéral" => [1 => "Moteur", 2 => "Occupant", 3 => "Porte", 4 => "Roue", 5 => "Équipement divers", 6 => "Réservoir"],
				"arrière" => [2 => "Occupant", 3 => "Équipement divers", 4 => "Roue", 6 => "Réservoir"],
			],
		],
		"moto" => [
			"localisations" => [
				"avant" => [2 => "Roue", 4 => "Fourche", 6 => "Conducteur"],
				"latéral" => [1 => "Roue", 2 => "Fourche", 3 => "Réservoir", 4 => "Moteur", 5 => "Équipement divers", 6 => "Conducteur"],
				"arrière" => [2 => "Roue", 5 => "Conducteur", 6 => "Équipement divers"],
			],
		],
		"robot" => [
			"localisations" => [
				"générale" => [1 => "Membre manipulateur", 2 => "Dispositif de locomotion", 3 => "Système informatique central", 4 => "Système sensoriel", 5 => "Batterie", 6 => "Armement/outillage"],
			],
		],
		"quadricoptère" => [
			"localisations" => [
				"générale" => [2 => "Hélice", 4 => "Pilote", 5 => "Batterie", 6 => "Équipement divers"],
			],
		]
	];

	static public function getObjectDamageEffects(int $pdsm, int $pds, int $integrite, int $rd, int $rawDamages, string $dmgType, string $objectType, string $localisation, array $rolls)
	{
		// net damages passing RD
		$netDamages = max($rawDamages - $rd, 0);

		// evaluating damage level
		$damageLevels = [0 => "aucun", 1 => "très légers", 2 => "légers", 3 => "moyens", 4 => "graves", 5 => "très graves", 6 => "extrême"];
		if ($netDamages === 0) {
			$damageIndex = 0;
		} elseif ($netDamages <= 0.1 * $pdsm) {
			$damageIndex = 1;
		} elseif ($netDamages <= 0.25 * $pdsm) {
			$damageIndex = 2;
		} elseif ($netDamages <= 0.5 * $pdsm) {
			$damageIndex = 3;
		} elseif ($netDamages <= $pdsm) {
			$damageIndex = 4;
		} elseif ($netDamages <= 2 * $pdsm) {
			$damageIndex = 5;
		} else {
			$damageIndex = 6;
		}

		// very located damages don’t affect the object $pds
		if ($dmgType !== "tres-localises") {
			$pds -= $netDamages;
		}

		// evaluating state level
		$stateLevels = [0 => "état OK", 1 => "légèrement endommagé", 2 => "moyennement endommagé", 3 => "gravement endommagé", 4 => "hors-service", 5 => "détruit"];
		if ($pds <= -$pdsm) {
			$stateLevelIndex = 5;
		} elseif ($pds <= 0){
			$stateLevelIndex = 4;
		} elseif ($pds <= 0.5*$pdsm){
			$stateLevelIndex = 3;
		} elseif ($pds <= 0.75*$pdsm){
			$stateLevelIndex = 2;
		} elseif ($pds <= 0.9*$pdsm){
			$stateLevelIndex = 1;
		} else {
			$stateLevelIndex = 0;
		}

		// assessing side effects number
		$sideEffectNumber = 0;
		if($dmgType === "tres-localises"){
			$sideEffectNumber = random_int(0, 1); // 0 or 1 if "très localisé"
		} elseif ($stateLevelIndex <= 3){
			$sideEffectNumber = random_int(0, $damageIndex); // 0 to $damageIndex (0-4) if state is not "hors-service"
		}

		// specifying each side effect
		$is_valid_object = isset(self::object_types[$objectType]);
		$is_valid_localisation = isset(self::object_types[$objectType]["localisations"][$localisation]);
		$sideEffects = [];
		if($is_valid_object && $is_valid_localisation && $sideEffectNumber){
			for ($i = 0; $i < $sideEffectNumber; $i++){
				$effectDetail = TableReader::getResult(self::object_types[$objectType]["localisations"][$localisation], random_int(1, 6)); // read effect from table
				$effectLevel = DiceManager::isSuccess($integrite, $rolls[$i]) ? $damageIndex -1 : $damageIndex; // severity depends on $damageIndex and Integrity check
				$sideEffects[] = [$effectDetail, $effectLevel];
			}
		}

		return [
			"objectType" => $objectType,
			"pdsm" => $pdsm,
			"pds" => $pds,
			"integrité" => $integrite,
			"rd" => $rd,
			"netDamages" => $netDamages,
			"damagesLevel" => $damageLevels[$damageIndex],
			"stateLevel" => $stateLevels[$stateLevelIndex],
			"sideEffects" => $sideEffects,
		];
	}
}