<?php

namespace App\Controller;

use App\Lib\TextParser;
use App\Entity\Creature;
use App\Lib\DiceManager;
use App\Entity\Attribute;
use App\Entity\Equipment;

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
		foreach ($dice_codes as $code){
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
