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
	$_SESSION["time"] >= (time() - 30*60) ? $_SESSION["time"] = time() : LogController::logout();
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
			$interval = !! ($_GET["interval"] ?? false);
			$controller->getStrengthFromWeight($weight, $interval);
			break;

		case "/api/weight-pdv":
			Firewall::check(!empty($_GET["weight"]));
			$weight = (float) $_GET["weight"];
			$interval = !! ($_GET["interval"] ?? false);
			$controller->getPdVFromWeight($weight, $interval);
			break;

		case "/api/test":
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
