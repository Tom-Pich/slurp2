<?php

namespace App\Controller;

use App\Entity\Creature;
use App\Entity\Attribute;
use App\Entity\Equipment;
use App\Lib\TextParser;
use App\Rules\CriticalController;
use App\Rules\WeaponsController;
use App\Rules\WoundController;
use App\Rules\ExplosionController;
use App\Rules\ObjectController;

class ApiController
{
	private array $response;

	/**
	 * getStrengthDamages – Route: api/strength-damages?strength=int
	 *
	 * @return void
	 */
	public function getStrengthDamages($val)
	{
		$data = Attribute::getDamages($val);
		$this->response["data"] = $data;
		$this->sendResponse();
	}

	public function getWeaponDamages($for, $notes, $hands = null)
	{
		preg_match_all('/[TBP]\.[te]([\+-][0-9]+){0,}/', $notes, $matches);
		$dice_codes = $matches[0];
		if (str_contains($notes, "†")) {
			$hands = "2M-opt";
		} elseif (str_contains($notes, "‡")) {
			$hands = "2M";
		}
		$damages = [];
		foreach ($dice_codes as $code) {
			$damage = Equipment::evaluateDamages($for, $code, $hands);
			$damages[] = $damage;
		}
		$stringified_damages = join("/", $damages);
		$stringified_damages = $stringified_damages === "" ? "Aucun code dégâts valide" : $stringified_damages;

		$this->response["data"] = ["damages" => $stringified_damages];
		$this->sendResponse();
	}

	public function getTramplingDamages(float $weight)
	{
		$data = Creature::getTramplingDamages($weight);
		$this->response["data"] = $data;
		$this->sendResponse();
	}

	public function getStrengthFromWeight(float $weight,  bool $interval = false)
	{
		if ($interval) {
			$strength = Creature::getStrengthFromWeight($weight * 0.85) . "-" . Creature::getStrengthFromWeight($weight * 1.15);
		} else {
			$strength = Creature::getStrengthFromWeight($weight);
		}
		$this->response["data"] = $strength;
		$this->sendResponse();
	}

	public function getPdVFromWeight(float $weight,  bool $interval = false)
	{
		if ($interval) {
			$pdv = Creature::getPdVFromWeight($weight * 0.9) . "-" . Creature::getPdVFromWeight($weight * 1.1);
		} else {
			$pdv = Creature::getPdVFromWeight($weight);
		}
		$this->response["data"] = $pdv;
		$this->sendResponse();
	}

	public function getLocalisation(int $roll)
	{
		$this->response["data"] = WoundController::localisation[$roll];
		$this->sendResponse();
	}

	public function getCriticalResult(string $table, int $roll_3d, int $roll_1d)
	{
		$this->response["data"] = CriticalController::CriticalResult($table, $roll_3d, $roll_1d);
		$this->sendResponse();
	}

	public function getBurstHits(int $rcl, int $bullets, int $mr)
	{
		$this->response["data"] = WeaponsController::burstHits($rcl, $bullets, $mr);
		$this->sendResponse();
	}

	public function getGeneralState(int $san, int $pdvm, int $pdv, int $pain_resistance, string $members)
	{
		$this->response["data"]["general"] = WoundController::getGeneralEffects($pdv, $pdvm, $pain_resistance)["description"];

		$members = TextParser::parsePseudoArray2Array($members);
		foreach ($members as $member => $damage) {
			$member_full_name = WoundController::member_abbreviation[$member]["full-name"] ?? false;
			$member_name = WoundController::member_abbreviation[$member]["member"] ?? false;
			if ($member_full_name) {
				$this->response["data"]["members"][ucfirst($member_full_name)] = WoundController::getMemberEffects($damage, $pdvm, $member_name, $pain_resistance)["description"];
			}
		}

		$this->sendResponse();
	}

	public function getWoundEffects(int $dex, int $san, int $pdvm, int $pdv, int $pain_resistance, int $raw_dmg, int $rd, string $dmg_type, string $bullet_type, string $localisation, array $rolls)
	{
		$this->response["data"] = WoundController::getWoundEffects($dex, $san, $pdvm, $pdv, $pain_resistance, $raw_dmg, $rd, $dmg_type, $bullet_type, $localisation, $rolls);
		$this->sendResponse();
	}

	public function getExplosionDamages(float $damages, string $distance, float $fragSurface, bool $isFragmentationDevice)
	{
		$this->response["data"] = ExplosionController::getExplosionDamages($damages, $distance, $fragSurface, $isFragmentationDevice);
		$this->sendResponse();
	}

	public function getObjectLocalisationOptions(string $objectType)
	{
		$object = ObjectController::object_types[$objectType] ?? null;
		$localisations = [];
		if ($object) {
			foreach ($object["localisations"] as $name => $options) {
				$localisations[] = $name;
			}
		} else {
			$localisations[] = "–––";
		}
		$this->response["data"] = $localisations;
		$this->sendResponse();
	}

	public function getObjectDamageEffects(int $pdsm, int $pds, int $integrite, int $rd, int $rawDamages, string $dmgType, string $objectType, string $localisation, array $rolls)
	{
		$this->response["data"] = ObjectController::getObjectDamageEffects($pdsm, $pds, $integrite, $rd, $rawDamages, $dmgType, $objectType, $localisation, $rolls);
		$this->sendResponse();
	}

	/**
	 * sendResponse \
	 * send JSON response, with all data under "data" key
	 *
	 * @return void
	 */
	private function sendResponse()
	{
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($this->response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	}
}
