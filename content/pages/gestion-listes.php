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

$skill_repo = new SkillRepository;
$spell_repo = new SpellRepository;
$college_repo = new CollegeRepository;
$power_repo = new PowerRepository;
$discipline_repo = new DisciplineRepository;
$psi_repo = new PsiPowerRepository;
$creature_repo = new CreatureRepository;

$id = (int) ($_GET["id"] ?? 0);
$file = NULL;
$title = [
	"avdesav" => "Avantage ou Désavantage",
	"competence" => "Compétence",
	"sort" => "Sort",
	"pouvoir" => "Pouvoir",
	"psi" => "Pouvoir psionique",
	"creature" => "Créature",
]
?>
<?php if ($_GET["req"] !== "pouvoir"): ?>
	<script src="https://cdn.tiny.cloud/1/yz5330dqgj93ymq1h7crpikarybmhr23o91ctzmkemy8ew3t/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<?php endif ?>

<div class="flex gap-1 ai-center">
	<h2 class="fl-1"><?= $title[$_GET["req"]] ?? "Erreur" ?></h2>
	<?php if (isset($_SERVER["HTTP_REFERER"])): ?>
		<a href="<?= $_SERVER["HTTP_REFERER"] ?>" data-role="referer-link" class="btn mt-½"><span class="ff-fas">&#xf0a8</span> Retour</a>
	<?php endif ?>
</div>

<?php
// Avantages & Désavantages
if ($_GET["req"] === "avdesav") {
	$avdesav_repo = new AvDesavRepository;
	$avdesav = $id ? $avdesav_repo->getAvDesav($id) : new AvDesav();
	$liste_categories = $avdesav_repo->getDistinctCategories();
	if ($avdesav) $file = "editor-avdesav.php";
}

// Compétences
elseif ($_GET["req"] === "competence") {
	$comp = $id ? $skill_repo->getSkill($id) : new Skill();
	$liste_categories = $skill_repo->getDistinctCategories();
	if ($comp) $file = "editor-skill.php";
}

// Sorts
elseif ($_GET["req"] === "sort") {
	$sort = $id ? $spell_repo->getSpell($id) : new Spell();
	$liste_colleges = $college_repo->getCollegesName();
	$liste_origines = $spell_repo->getDistinctOrigins();
	$liste_classes = $spell_repo->getDistinctClasses();
	if ($sort) $file = "editor-spell.php";
}

// Pouvoirs
elseif ($_GET["req"] === "pouvoir") {
	$pouvoir = $id ? $power_repo->getPower($id) : new Power(["id_RdB" => "", "Type" => null, "Nom" => "", "Catégorie" => null, "Domaine" => null, "Mult" => null, "Origine" => ""]);
	$liste_categories = $power_repo->getDistinctCategories();
	$liste_domaines = $power_repo->getDistinctDomains();
	$liste_origines = $power_repo->getDistinctOrigins();
	if ($pouvoir) $file = "editor-power.php";
}

// Psi
elseif ($_GET["req"] === "psi") {
	$psi = $id ? $psi_repo->getPower($id) : new PsiPower();
	$liste_disciplines = $discipline_repo->getDisciplinesName();
	$liste_origines = $psi_repo->getDistinctOrigins();
	$liste_classes = $spell_repo->getDistinctClasses();
	if ($psi) $file = "editor-psi.php";
}

// Créatures
elseif ($_GET["req"] === "creature") {
	$creature = $id ? $creature_repo->getCreature($id) : new Creature();
	$liste_categories = $creature_repo->getDistinctCategories();
	$liste_origines = $creature_repo->getDistinctOrigins();
	if ($creature) $file = "editor-creature.php";
}

if (!$file) echo "<div class='mt-5 fs-500 ta-center'>La ressource demandée n’existe pas&nbsp;!</div>";
else include "content/components/" . $file;
?>

<?php if ($_GET["req"] !== "pouvoir"): ?>
	<script>
		tinymce.init({
			selector: 'textarea[tinyMCE]',
			menubar: false,
			plugins: ['lists', 'code', 'link'],
			toolbar: 'bold italic bullist numlist link code removeformat',
			entity_encoding: "raw",
			extended_valid_elements: "b,i",
			formats: {
				bold: {
					inline: "b"
				},
				italic: {
					inline: "i"
				}
			},
			content_css: "/styles.min.css",
			content_style: "#tinymce { outline: none } #tinymce.p-1::before { left: 1em}",
			body_class: "flow p-1",
			branding: false
		});
	</script>
<?php endif ?>

<script type="module">
	/* import {
		showAlert
	} from "/scripts/lib/alert" */
	const form = document.querySelector("main form");
	form.addEventListener("submit", (e) => {
		e.preventDefault();
		const editors = tinymce.get();
		console.log(editors)
		editors.forEach(editor => editor.targetElm.value = editor.getContent())
		const data = new FormData(form);
		console.log(data)
		fetch(form.action, {
				method: "post",
				body: data
			})
			//.then(response => response.text())
			//.then(response => console.log(response))
			//.then(() => showAlert("Modifications enregistrées", "valid"))
			.then(() => {
				const refererLink = document.querySelector("[data-role=referer-link]")
				if (refererLink) window.location.href = refererLink.href;
				else window.location.href = "/avdesav-comp-sorts";
			})
	})
</script>