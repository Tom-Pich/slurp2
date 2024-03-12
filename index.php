<?php

require_once "vendor/autoload.php";

use App\Lib\DotEnv;
use App\Entity\Group;
use App\Entity\Power;
use App\Entity\Skill;
use App\Entity\Spell;
use App\Lib\Firewall;
use App\Entity\AvDesav;
use App\Entity\Creature;
use App\Entity\PsiPower;
use App\Entity\Character;
use App\Entity\Equipment;
use App\Controller\ApiController;
use App\Controller\LogController;
use App\Controller\PageController;
use App\Repository\UserRepository;
use App\Controller\Error404Controller;
use App\Controller\CharacterExportController;

(new DotEnv(__DIR__ . '/.env'))->load();
require_once "config.php";

$bdd = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME . "; charset=utf8", DB_USER, DB_PASSWORD);

// ––– Sessions –––––––––––––––––––––––––––––––––––––––––––––––––––––––––
session_start();
if (!isset($_SESSION["Statut"]) or !DB_ACTIVE) {
	$_SESSION["Statut"] = 0;
	$_SESSION["id"] = 0;
	$_SESSION["login"] = "Invité";
	$_SESSION["attempt"] = 0;
	$_SESSION["token"] = Firewall::generateToken(16);
	$_SESSION["time"] = time();
} else {
	$_SESSION["time"] >= (time() - 3600) ? $_SESSION["time"] = time() : LogController::logout();
}

// ––– $pages_data ––––––––––––––––––––––––––––––––––––––––––––––––––––––
include "content/pages.php";

// Front router –––––––––––––––––––––––––––––––––––––––––––––––––––––––––
$path = parse_url($_SERVER["REQUEST_URI"])["path"];

// API
if (substr($path, 0, 4) === "/api") {

	$controller = new ApiController;

	switch ($path) {

		case "/api/strength-damages":
			Firewall::check(isset($_GET["strength"]) && (int) $_GET["strength"] !== 0);
			$controller->getStrengthDamages($_GET["strength"]);
			break;

		case "/api/weapon-damages":
			Firewall::check(!empty($_POST["for"]) && !empty($_POST["notes"]));
			$for = (int) $_POST["for"];
			$notes = $_POST["notes"];
			$hands = $_POST["mains"] ?? "1M";
			$controller->getWeaponDamages($for, $notes, $hands);
			break;

		case "/api/trampling-damages":
			Firewall::check(!empty($_GET["weight"]));
			$weight = (float) $_GET["weight"];
			$controller->getTramplingDamages($weight);
			break;

		case "/api/weight-strength":
			Firewall::check(!empty($_GET["weight"]));
			$weight = (float) $_GET["weight"];
			$interval = !!($_GET["interval"] ?? false);
			$controller->getStrengthFromWeight($weight, $interval);
			break;

		case "/api/weight-pdv":
			Firewall::check(!empty($_GET["weight"]));
			$weight = (float) $_GET["weight"];
			$interval = !!($_GET["interval"] ?? false);
			$controller->getPdVFromWeight($weight, $interval);
			break;

		case "/api/localisation-table":
			Firewall::check(!empty($_POST["roll"]));
			$roll = (int) $_POST["roll"];
			$controller->getLocalisation($roll);
			break;

		case "/api/critical-tables":
			Firewall::check(!empty($_POST["table"]) && !empty($_POST["roll-3d"]) && !empty($_POST["roll-1d"]));
			$table = $_POST["table"];
			$roll_3d = (int) $_POST["roll-3d"];
			$roll_1d = (int) $_POST["roll-1d"];
			$controller->getCriticalResult($table, $roll_3d, $roll_1d);
			break;

		case "/api/burst-hits":
			Firewall::check(!empty($_POST["rcl"]) && !empty($_POST["bullets"]) && !empty($_POST["mr"]));
			$rcl = (int) $_POST["rcl"];
			$bullets = (int) $_POST["bullets"];
			$mr = (int) $_POST["mr"];
			$controller->getBurstHits($rcl, $bullets, $mr);
			break;

		case "/api/general-state":
			Firewall::check(isset($_POST["san"]) && isset($_POST["pdvm"]) && isset($_POST["pdv"]) && isset($_POST["pain-resistance"]) && isset($_POST["members"]));
			$san = (int) $_POST["san"];
			$pdvm = (int) $_POST["pdvm"];
			$pdv = (int) $_POST["pdv"];
			$pain_resistance = (int) $_POST["pain-resistance"];
			$members = trim($_POST["members"]);
			$controller->getGeneralState($san, $pdvm, $pdv, $pain_resistance, $members);
			break;

		case "/api/wound-effects":
			Firewall::check(isset($_POST["dex"]) && isset($_POST["san"]) && isset($_POST["pdvm"]) && isset($_POST["pdv"]) && isset($_POST["pain-resistance"]) && isset($_POST["raw-dmg"]) && isset($_POST["rd"]) && isset($_POST["dmg-type"]) && isset($_POST["bullet-type"]) && isset($_POST["localisation"]) && isset($_POST["rolls"]));
			$dex = (int) $_POST["dex"];
			$san = (int) $_POST["san"];
			$pdvm = (int) $_POST["pdvm"];
			$pdv = (int) $_POST["pdv"];
			$pain_resistance = (int) $_POST["pain-resistance"];
			$raw_dmg = (int) $_POST["raw-dmg"];
			$rd = (int) $_POST["rd"];
			$dmg_type = htmlspecialchars($_POST["dmg-type"]);
			$bullet_type = htmlspecialchars($_POST["bullet-type"]);
			$localisation = htmlspecialchars($_POST["localisation"]);
			$rolls = explode(",", $_POST["rolls"]);
			$rolls = array_map(fn ($x) => (int) $x, $rolls);
			$controller->getWoundEffects($dex, $san, $pdvm, $pdv, $pain_resistance, $raw_dmg, $rd, $dmg_type, $bullet_type, $localisation, $rolls);
			break;

		case "/api/explosion-damages":
			Firewall::check(isset($_POST["damages"]) && isset($_POST["distance"]) && isset($_POST["fragmentation-surface"]) && isset($_POST["is-fragmentation-device"]));
			$damages = (float) $_POST["damages"];
			$distance = 1;
			if(is_numeric($_POST["distance"]) || in_array($_POST["distance"], ["i", "r", "c"])){
				$distance = $_POST["distance"];
			}
			$fragSurface = (float) $_POST["fragmentation-surface"];
			$isFragmentationDevice = $_POST["is-fragmentation-device"] === "true";
			$controller->getExplosionDamages($damages, $distance, $fragSurface, $isFragmentationDevice);
			break;
		
		case "/api/object-localisation-options" :
			Firewall::check(isset($_POST["object-type"]));
			$objectType = htmlspecialchars(strtolower($_POST["object-type"]));
			$controller->getObjectLocalisationOptions($objectType);
			break;

		default:
			Firewall::redirect_to_404();
	}
}

// submit
elseif (substr($path, 0, 7) === "/submit") {
	switch ($path) {

		case "/submit/log-out":
			LogController::logout();
			break;

		case "/submit/log-in":
			Firewall::checkToken();
			Firewall::check(DB_ACTIVE);
			foreach (["login", "password", "redirect-url"] as $item) {
				Firewall::check(isset($_POST[$item]));
			}
			LogController::login($_POST);
			break;

		case "/submit/change-password":
			Firewall::filter(1);
			Firewall::checkToken();
			foreach (["pwd0", "pwd1", "pwd2", "token"] as $item) {
				Firewall::check(isset($_POST[$item]));
			}
			$user = (new UserRepository)->getUser($_SESSION["id"]);
			$user->changePassword($_POST);
			break;

		case "/submit/equipment-list":
			Firewall::filter(1);
			Equipment::processEquipmentSubmit($_POST);
			break;

		case "/submit/export-character":
			Firewall::filter(2);
			Firewall::check(!empty($_POST["id"]));
			CharacterExportController::exportCharacter($_POST["id"]);
			break;

		case "/submit/create-character":
			Firewall::filter(2);
			Firewall::check(!empty($_POST));
			Character::createCharacter($_POST);
			header('Location: /gestionnaire-mj');
			break;

		case "/submit/update-character":
			Firewall::filter(1);
			Firewall::check(!empty($_POST));
			$character_id = (int) $_POST["id"];
			$character = new Character($character_id);
			if (!$character->checkClearance()) {
				(new Error404Controller)->show();
			}
			Character::updateCharacter($_POST, $_FILES);
			header('Location: /personnage-gestion?perso=' . $character_id);
			break;

		case "/submit/update-character-state":
			Firewall::filter(2);
			Firewall::check(!empty($_POST));
			Character::updateCharacterState($_POST);
			break;

		case "/submit/update-character-pdm":
			Firewall::filter(1);
			Firewall::check(!empty($_POST));
			$character_id = (int) $_POST["id"];
			$character = new Character($character_id);
			if (!$character->checkClearance()) {
				(new Error404Controller)->show();
			}
			//echo "coucou from update-character-pdm";
			Character::updateCharacterPdM($_POST);
			break;

		case "/submit/groups":
			Firewall::filter(3);
			Firewall::check(!empty($_POST));
			Group::processGroupsSubmit($_POST);
			header('Location: /gestionnaire-mj#gestionnaire-groupes');
			break;

		case "/submit/set-avdesav":
			Firewall::filter(3);
			Firewall::check(!empty($_POST));
			AvDesav::processSubmitAvdesav($_POST);
			header("Location: /avdesav-comp-sorts");
			break;

		case "/submit/set-skill":
			Firewall::filter(3);
			Firewall::check(!empty($_POST));
			Skill::processSubmitSkill($_POST);
			header("Location: /avdesav-comp-sorts");
			break;

		case "/submit/set-spell":
			Firewall::filter(3);
			Firewall::check(!empty($_POST));
			Spell::processSubmitSpell($_POST);
			header("Location: /avdesav-comp-sorts");
			break;

		case "/submit/set-power":
			Firewall::filter(3);
			Firewall::check(!empty($_POST));
			Power::processSubmitPower($_POST);
			header("Location: /in-nomine");
			break;

		case "/submit/set-psi":
			Firewall::filter(3);
			Firewall::check(!empty($_POST));
			PsiPower::processSubmitPower($_POST);
			header("Location: /psioniques");
			break;

		case "/submit/set-creature":
			Firewall::filter(3);
			Firewall::check(!empty($_POST));
			Creature::processSubmitCreature($_POST);
			header("Location: /animaux");
			break;

		default:
			Firewall::redirect_to_404();
	}
}

// character pages
elseif (in_array($path, ["/personnage-fiche", "/personnage-gestion"])) {
	Firewall::filter(1);
	Firewall::check(!empty($_GET["perso"]));
	$character = new Character($_GET["perso"]);
	if (!$character->checkClearance()) {
		(new Error404Controller)->show();
	}
	$page_name = ltrim($path, "/");
	$page_data = [
		"title" => $character->name,
		"description" => "",
		"body-class" => $page_name,
		"file" => $page_name,
		"character" => $character,
	];
	$page = new PageController($page_data);
	$page->show();


// scenarii pages
} elseif (substr($path, 0, 9) === "/scenario") {
	Firewall::filter(3);
	require_once "content/scenarii/_scenarii-data.php";
	$scenario_url = substr($path, 9);
	$scenario_name = ltrim($scenario_url, "/");
	$scenarii_url_list = array_keys($scenarii_data);
	if (in_array($scenario_name, $scenarii_url_list)) {
		$page_data = [
			"title" => $scenarii_data[$scenario_name]["title"],
			"description" => $scenarii_data[$scenario_name]["excerpt"],
			"body-class" => "scenario",
			"file" => $scenario_name,
		];
		$page = new PageController($page_data);
		$page->show("scenario");
	} else {
		$page = new Error404Controller;
		$page->show();
	}
}

// standard pages
else {
	$page_name = $path === "/" ? "home" : ltrim($path, "/");
	$page_data = $pages_data[$page_name] ?? null;

	if ($page_data) {
		$page_data["canonical"] = ltrim($path, "/");
		$access_restriction = $page_data["access-restriction"] ?? 0;
		if ($access_restriction) {
			Firewall::filter($access_restriction);
		}
		$page = new PageController($page_data);
	} else {
		$page = new Error404Controller;
	}
	$page->show();
}
