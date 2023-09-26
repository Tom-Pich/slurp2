<?php

use App\Entity\Power;
use App\Entity\Skill;
use App\Entity\Spell;
use App\Entity\AvDesav;
use App\Entity\Creature;
use App\Entity\PsiPower;
use App\Repository\PowerRepository;
use App\Repository\SkillRepository;
use App\Repository\SpellRepository;
use App\Repository\AvDesavRepository;
use App\Repository\CollegeRepository;
use App\Repository\CreatureRepository;
use App\Repository\PsiPowerRepository;
use App\Repository\DisciplineRepository;

$avdesav_repo = new AvDesavRepository;
$skill_repo = new SkillRepository;
$spell_repo = new SpellRepository;
$college_repo = new CollegeRepository;
$power_repo = new PowerRepository;
$discipline_repo = new DisciplineRepository;
$psi_repo = new PsiPowerRepository;
$creature_repo = new CreatureRepository;


// Avantages & Désavantages
if ($_GET["req"] === "avdesav") {
	$id = (int) ($_GET["id"] ?? 0);
	$avdesav = $id ? $avdesav_repo->getAvDesav($id) : new AvDesav();
	$liste_categories = $avdesav_repo->getDistinctCategories();
	include is_null($avdesav) ? "content/components/editor-error.php" : "content/components/editor-avdesav.php";
}

// Compétences
if ($_GET["req"] === "competence") {
	$id = (int) ($_GET["id"] ?? 0);
	$comp = $id ? $skill_repo->getSkill($id) : new Skill();
	$liste_categories = $skill_repo->getDistinctCategories();
	include is_null($comp) ? "content/components/editor-error.php" : "content/components/editor-skill.php";
}

// Sorts
if ($_GET["req"] === "sort") {
	$id = (int) ($_GET["id"] ?? 0);
	$sort = $id ? $spell_repo->getSpell($id) : new Spell();
	$liste_colleges = $college_repo->getCollegesName();
	$liste_origines = $spell_repo->getDistinctOrigins();
	$liste_classes = $spell_repo->getDistinctClasses();
	include is_null($sort) ? "content/components/editor-error.php" : "content/components/editor-spell.php";
}

// Pouvoirs
if ($_GET["req"] === "pouvoir") {
	$id = (int) ($_GET["id"] ?? 0);
	$pouvoir = $id ? $power_repo->getPower($id) : new Power(["id_RdB" => "", "Type" => null, "Nom" => "", "Catégorie" => null, "Domaine" => null, "Mult" => null, "Origine" => ""]);
	$liste_categories = $power_repo->getDistinctCategories();
	$liste_domaines = $power_repo->getDistinctDomains();
	$liste_origines = $power_repo->getDistinctOrigins();
	include is_null($pouvoir) ? "content/components/editor-error.php" : "content/components/editor-power.php";
}

// Psi
if ($_GET["req"] === "psi") {
	$id = (int) $_GET["id"] ?? 0;
	$psi = $id ? $psi_repo->getPower($id) : new PsiPower();
	$liste_disciplines = $discipline_repo->getDisciplinesName();
	$liste_origines = $psi_repo->getDistinctOrigins();
	$liste_classes = $spell_repo->getDistinctClasses();
	include is_null($psi) ? "content/components/editor-error.php" : "content/components/editor-psi.php";
}

// Créatures
if ($_GET["req"] === "creature") {
	$id = (int) $_GET["id"] ?? 0;
	$creature = $id ? $creature_repo->getCreature($id) : new Creature();
	$liste_categories = $creature_repo->getDistinctCategories();
	$liste_origines = $creature_repo->getDistinctOrigins();
	include is_null($creature) ? "content/components/editor-error.php" : "content/components/editor-creature.php";
}
