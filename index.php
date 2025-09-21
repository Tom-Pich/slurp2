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
LogController::checkSessionValidity();

// ––– $pages_data ––––––––––––––––––––––––––––––––––––––––––––––––––––––
$pages_data = include "content/pages/_pages-data.php";


// Front router –––––––––––––––––––––––––––––––––––––––––––––––––––––––––
$path = parse_url($_SERVER["REQUEST_URI"])["path"];
$path_segments = array_filter(explode("/", $path)); // empty for home page, first level = $path_segments[1] (not [0] – array_filter)
$path_segments[1] = $path_segments[1] ?? null;

// Header CSP
header("Content-Security-Policy: frame-ancestors 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.tiny.cloud");
header("X-Content-Type-Options: nosniff");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains");

// API
if ($path_segments[1] === "api") {

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
			Firewall::check(!empty($_POST["category"]) && !empty($_POST["roll-3d"]) && !empty($_POST["roll-1d"]));
			$table = $_POST["category"];
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
			Firewall::check(isset($_POST["pdvm"]) && isset($_POST["pdv"]) && isset($_POST["pain-resistance"]) && isset($_POST["members"]));
			$pdvm = (int) $_POST["pdvm"] > 0 ? (int) $_POST["pdvm"] : 10;
			$pdv = $_POST["pdv"] !== "" ? (int) $_POST["pdv"] : $pdvm;
			$pain_resistance = (int) $_POST["pain-resistance"];
			$members = strtoupper(htmlspecialchars(trim($_POST["members"])));
			$controller->getGeneralState($pdvm, $pdv, $pain_resistance, $members);
			break;

		case "/api/wound-effects":
			Firewall::check(isset($_POST["category"]) && isset($_POST["dex"]) && isset($_POST["san"]) && isset($_POST["pdvm"]) && isset($_POST["pdv"]) && isset($_POST["pain-resistance"]) && isset($_POST["raw-dmg"]) && isset($_POST["rd"]) && isset($_POST["dmg-type"]) && isset($_POST["localisation"]) && isset($_POST["rolls"]));
			$category = htmlspecialchars($_POST["category"]);
			$dex = (int) $_POST["dex"];
			$san = (int) $_POST["san"];
			$pdvm = (int) $_POST["pdvm"];
			$pdv = $_POST["pdv"] !== "" ? (int) $_POST["pdv"] : $pdvm;
			$pain_resistance = (int) $_POST["pain-resistance"];
			$raw_dmg = (int) $_POST["raw-dmg"];
			$rd = (int) $_POST["rd"];
			$dmg_type = htmlspecialchars($_POST["dmg-type"]);
			$bullet_type = !isset($_POST["bullet-type"]) ? "std" : htmlspecialchars($_POST["bullet-type"]);
			$localisation = htmlspecialchars($_POST["localisation"]);
			$rolls = explode(",", $_POST["rolls"]);
			$rolls = array_map(fn($x) => (int) $x, $rolls);
			$controller->getWoundEffects($category, $dex, $san, $pdvm, $pdv, $pain_resistance, $raw_dmg, $rd, $dmg_type, $bullet_type, $localisation, $rolls);
			break;

		case "/api/bleeding-effects":
			Firewall::check(isset($_POST["san-test"]) && isset($_POST["pdvm"]) && isset($_POST["severity"]) );
			$san_test = json_decode($_POST["san-test"], true);
			$san_test_mr = (int) $san_test["MR"];
			$san_test_critical = (int) $san_test["critical"];
			$pdvm = (int) $_POST["pdvm"];
			$severity = (int) $_POST["severity"];
			$controller->getBleedingEffects($san_test_mr, $san_test_critical, $pdvm, $severity);
			break;

		case "/api/explosion-damages":
			Firewall::check(isset($_POST["damages"]) && isset($_POST["distance"]) && isset($_POST["fragmentation-surface"]));
			$damages = (float) $_POST["damages"];
			$distance = 1;
			if (is_numeric($_POST["distance"]) || in_array($_POST["distance"], ["i", "r", "c"])) {
				$distance = $_POST["distance"];
			}
			$fragSurface = (float) $_POST["fragmentation-surface"];
			$isFragmentationDevice = isset($_POST["is-fragmentation-device"]);
			$controller->getExplosionDamages($damages, $distance, $fragSurface, $isFragmentationDevice);
			break;

		case "/api/object-localisation-options":
			Firewall::check(isset($_POST["object-type"]));
			$objectType = htmlspecialchars(strtolower($_POST["object-type"]));
			$controller->getObjectLocalisationOptions($objectType);
			break;

		case "/api/object-damages-effects":
			Firewall::check(isset($_POST["pdsm"]) && isset($_POST["pds"]) && isset($_POST["integrite"]) && isset($_POST["rd"]) && isset($_POST["dmg-value"]) && isset($_POST["dmg-type"]) && isset($_POST["object-type"]) && isset($_POST["localisation"]) && isset($_POST["rolls"]));
			$pdsm = (int) $_POST["pdsm"];
			$pds = is_numeric($_POST["pds"]) ? (int) $_POST["pds"] : $pdsm;
			$integrite = (int) $_POST["integrite"];
			$rd = (int) $_POST["rd"];
			$rawDamages = (int) $_POST["dmg-value"];
			$dmgType = htmlspecialchars($_POST["dmg-type"]);
			$objectType = htmlspecialchars(strtolower($_POST["object-type"]));
			$localisation = htmlspecialchars(strtolower($_POST["localisation"]));
			$rolls = explode(",", $_POST["rolls"]);
			$rolls = array_map(fn($x) => (int) $x, $rolls);
			$controller->getObjectDamageEffects($pdsm, $pds, $integrite, $rd, $rawDamages, $dmgType, $objectType, $localisation, $rolls);
			break;

		case "/api/reaction-test":
			Firewall::check(isset($_POST["reaction-test"]));
			$reactionTest = (int) $_POST["reaction-test"];
			$controller->getReaction($reactionTest);
			break;

		case "/api/npc-generator":
			$post = [];
			foreach ($_POST as $parameter => $value) $post[$parameter] = htmlspecialchars($_POST[$parameter]);
			$controller->getNPC($post);
			break;

		case "/api/wild-generator":
			$post = [];
			foreach ($_POST as $parameter => $value) $post[$parameter] = htmlspecialchars($_POST[$parameter]);
			$controller->getWildGeneratorResult($post);
			break;

		case "/api/fright-check":
			Firewall::check(isset($_POST["fright-level"]));
			$frightLevel = (int) $_POST["fright-level"];
			$sfScore = (int) $_POST["sf-score"];
			$sanScore = (int) $_POST["san-score"];
			$frightcheckMR = (int) $_POST["frightcheck-MR"];
			$frighcheckCriticalStatus = (int) $_POST["frightcheck-critical"];
			$frighcheckSymbol = htmlspecialchars($_POST["frightcheck-symbol"]);
			$rolls = explode(",", $_POST["rolls"]);
			$rolls = array_map(fn($x) => (int) $x, $rolls);
			$controller->getFrightcheckResult($frightLevel, $sfScore, $sanScore, $frightcheckMR, $frighcheckCriticalStatus, $frighcheckSymbol, $rolls);
			break;

		case "/api/get-character":
			Firewall::check(isset($_POST["id"]));
			$id = (int) $_POST["id"];
			$character = new Character($id);
			Firewall::check(isset($character->id) && $character->checkClearance());
			$controller->getCharacter($character);
			break;
		case "/api/get-avdesav":
			Firewall::check(isset($_GET["id"]));
			$id = (int) $_GET["id"];
			$controller->getAvdesav($id);
			break;
		case "/api/get-spell":
			Firewall::check(isset($_GET["id"]));
			$id = (int) $_GET["id"];
			$controller->getSpell($id);
			break;
		case "/api/get-creature":
			Firewall::check(isset($_GET["id"]));
			$id = (int) $_GET["id"];
			$controller->getCreature($id);
			break;
		default:
			Firewall::redirect_to_404();
	}
}

// submit
elseif ($path_segments[1] === "submit") {

	switch ($path) {

		case "/submit/log-out":
			LogController::logout();
			break;

		case "/submit/log-in":
			Firewall::checkToken();
			Firewall::check(DB_ACTIVE);
			foreach (["login", "password", "redirect-url"] as $item) Firewall::check(isset($_POST[$item]));
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
			break;

		case "/submit/set-skill":
			Firewall::filter(3);
			Firewall::check(!empty($_POST));
			Skill::processSubmitSkill($_POST);
			break;

		case "/submit/set-spell":
			Firewall::filter(3);
			Firewall::check(!empty($_POST));
			Spell::processSubmitSpell($_POST);
			break;

		case "/submit/set-power":
			Firewall::filter(3);
			Firewall::check(!empty($_POST));
			Power::processSubmitPower($_POST);
			break;

		case "/submit/set-psi":
			Firewall::filter(3);
			Firewall::check(!empty($_POST));
			PsiPower::processSubmitPower($_POST);
			break;

		case "/submit/set-creature":
			Firewall::filter(3);
			Firewall::check(!empty($_POST));
			Creature::processSubmitCreature($_POST, $_FILES);
			break;

		case "/submit/set-user-option":
			Firewall::filter(1);
			Firewall::check(!empty($_POST["option"]), !empty($_POST["value"]));
			$id = $_SESSION["id"];
			$option = htmlspecialchars($_POST["option"]);
			$value = htmlspecialchars($_POST["value"]);
			$user_repo = new UserRepository;
			$user_repo->setUserOption($id, $option, $value);
			$_SESSION["user-options"][$option] = $value;
			break;

		default:
			Firewall::redirect_to_404();
	}
}

// character pages
elseif (in_array($path_segments[1], ["personnage-fiche", "personnage-gestion"]) && empty($path_segments[2])) {
	Firewall::filter(1);
	Firewall::check(!empty($_GET["perso"] && (int) $_GET["perso"]));
	$character = new Character((int) $_GET["perso"]);
	if (!$character->checkClearance()) {
		(new Error404Controller)->show();
	}
	$page_name = $path_segments[1];
	$page_data = $pages_data[$page_name];
	$page_data["title"] = $character->name;
	$page_data["character"] = $character;
	$page = new PageController($page_data);
	$page->show();
}

// wiki pages
else if ($path_segments[1] === "wiki" && !empty($path_segments[2]) && count($path_segments) <= 3) {
	$wiki = $path_segments[2]; // for now only "paorn"
	$articles_data_file = "content/wikis/" . $wiki . "/_data.php";
	if (file_exists($articles_data_file)) include $articles_data_file; // provides $articles
	else {
		$page = new Error404Controller;
		$page->show();
	}

	$article_name = empty($path_segments[3]) ? "home" : $path_segments[3];
	if (!empty($articles[$article_name])) {
		$article = $articles[$article_name];
		$page_data = $pages_data["wiki"]; // loads template data
		$page_data["title"] = ($article_name !== "home" ? "Wiki " . ucfirst($wiki) . " – " : "") . $article["title"];
		$page_data["description"] = $article["description"] ?? null;
		$page_data["wiki"] = $wiki;
		$page_data["articles"] = $articles;
		$page_data["current-article-name"] = empty($path_segments[3]) ? "home" : $path_segments[3];
		$page_data["current-article"] = $article;
		$page = new PageController($page_data);
	} else {
		$page = new Error404Controller;
	}
	$page->show();
}

// standard pages
else {
	$page_name = $path_segments[1] ?? "home";
	$page_data = $pages_data[$page_name] ?? null;
	if (!empty($path_segments[2])) $page_data = null;

	if ($page_data) {
		$page_data["canonical"] = $path;
		$access_restriction = $page_data["access-restriction"] ?? 0;
		if ($access_restriction) Firewall::filter($access_restriction);
		$page = new PageController($page_data);
	} else {
		$page = new Error404Controller;
	}
	$page->show();
}
