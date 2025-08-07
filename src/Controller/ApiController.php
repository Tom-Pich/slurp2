<?php

namespace App\Controller;

use App\Entity\Creature;
use App\Entity\Attribute;
use App\Entity\Character;
use App\Entity\Equipment;
use App\Rules\WoundController;
use App\Generator\NPCGenerator;
use App\Rules\ObjectController;
use App\Generator\WildGenerator;
use App\Rules\WeaponsController;
use App\Rules\CriticalController;
use App\Rules\ReactionController;
use App\Rules\ExplosionController;
use App\Repository\SpellRepository;
use App\Repository\AvDesavRepository;
use App\Repository\CreatureRepository;
use App\Rules\MentalHealthController;

class ApiController
{
	private array $response;

	public function getStrengthDamages($val)
	{
		$data = Attribute::getDamages($val);
		$this->response["data"] = $data;
		$this->sendResponse();
	}

	public function getWeaponDamages($for, $notes, $hands = null)
	{
		$display_also_1M = false;
		preg_match_all('/[TBP]\.[te]([\+-][0-9]+){0,}/', $notes, $matches);
		$dice_codes = $matches[0];
		if (str_contains($notes, "†")) {
			$display_also_1M = true; // display 1M and 2M-opt damages on character sheet
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
		$stringified_damages = $stringified_damages === "" ? "Code dégâts non valide" : $stringified_damages;

		if ($display_also_1M) {
			$damages_1M = [];
			foreach ($dice_codes as $code) {
				$damage = Equipment::evaluateDamages($for, $code, "1M");
				$damages_1M[] = $damage;
			}
			$stringified_1M_damages = join("/", $damages_1M);
			if (!empty($stringified_1M_damages)) {
				$stringified_damages = $stringified_1M_damages . " (1M) – " . $stringified_damages . " (2M)";
			}
		}

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

	public function getGeneralState(int $pdvm, int $pdv, int $pain_resistance, string $members)
	{
		$this->response["data"]["general"] = WoundController::getGeneralEffects($pdv, $pdvm, $pain_resistance)["description"];
		$members_state = WoundController::getMembersState($pdvm, $members, $pain_resistance);
		$this->response["data"]["members"] = $members_state["members"];
		$this->response["data"]["members-error"] = $members_state["error"];
		$this->sendResponse();
	}

	public function getWoundEffects(string $category,  int $dex, int $san, int $pdvm, int $pdv, int $pain_resistance, int $raw_dmg, int $rd, string $dmg_type, string $bullet_type, string $localisation, array $rolls)
	{
		$this->response["data"] = WoundController::getWoundEffects($category, $dex, $san, $pdvm, $pdv, $pain_resistance, $raw_dmg, $rd, $dmg_type, $bullet_type, $localisation, $rolls);
		$this->sendResponse();
	}

	public function getBleedingEffects(int $san_test_mr, int $san_test_critical, int $pdvm, int $severity){
		$this->response["data"] = WoundController::getBleedingEffects($san_test_mr, $san_test_critical, $pdvm, $severity);
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
			$localisations[] = "–";
		}
		$this->response["data"] = $localisations;
		$this->sendResponse();
	}

	public function getObjectDamageEffects(int $pdsm, int $pds, int $integrite, int $rd, int $rawDamages, string $dmgType, string $objectType, string $localisation, array $rolls)
	{
		$this->response["data"] = ObjectController::getObjectDamageEffects($pdsm, $pds, $integrite, $rd, $rawDamages, $dmgType, $objectType, $localisation, $rolls);
		$this->sendResponse();
	}

	public function getReaction(int $reaction)
	{
		$this->response["data"] = ReactionController::getReaction($reaction);
		$this->sendResponse();
	}

	public function getNPC(array $parameters)
	{
		$this->response["data"] = NPCGenerator::generateNPC($parameters);
		$this->sendResponse();
	}

	public function getWildGeneratorResult(array $parameters)
	{
		$this->response["data"] = WildGenerator::generateResult($parameters);
		$this->sendResponse();
	}

	public function getFrightcheckResult(int $frightLevel, int $sfScore, int $sanScore, int $frightcheckMR, int $frighcheckCriticalStatus, string $frighcheckSymbol, array $rolls)
	{
		$this->response["data"] = MentalHealthController::getFrighcheckEffects($frightLevel, $sfScore, $sanScore, $frightcheckMR, $frighcheckCriticalStatus, $frighcheckSymbol, $rolls);
		$this->sendResponse();
	}

	public function getCharacter(Character $character)
	{
		$character->processCharacter();
		$character_array = get_object_vars($character);
		$this->response["data"] = $character_array;
		$this->sendResponse();
	}

	public function getAvdesav(int $id)
	{
		$avdesav_repo = new AvDesavRepository;
		$avdesav = $avdesav_repo->getAvDesav($id);
		$avdesav_array = get_object_vars($avdesav);
		$this->response["data"] = $avdesav_array;
		$this->response["data"]["displayCost"] = $avdesav->displayCost();
		$this->sendResponse();
	}

	public function getSpell(int $id)
	{
		$spell_repo = new SpellRepository;
		$spell = $spell_repo->getSpell($id);
		$spell_array = get_object_vars($spell);
		$this->response["data"] = $spell_array;
		$this->response["data"]["fullDescription"] = $spell->getFullDescription();
		$this->sendResponse();
	}

	public function getCreature(int $id)
	{
		$creature_repo = new CreatureRepository;
		$creature = $creature_repo->getCreature($id);
		$creature_array = get_object_vars($creature);
		$this->response["data"] = $creature_array;
		$this->response["data"]["fullDescription"] = $creature->getFullDescription();
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
