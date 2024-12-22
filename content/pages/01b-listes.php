<?php

use App\Repository\AvDesavRepository;
use App\Repository\CollegeRepository;
use App\Repository\SkillRepository;
use App\Repository\SpellRepository;

$avdesav_repo = new AvDesavRepository;
$skills_repo = new SkillRepository;
$colleges_repo = new CollegeRepository;
$spells_repo = new SpellRepository;

$affichage = $_POST["affichage"] ?? "categorie";
?>

<article class="as-start" data-morhpdom="ignore"><!-- Introduction -->

	<h4>Affichage par catégories</h4>
	<p>L’affichage par catégorie permet l’accès aux règles générales sur certaines catégories d’avantages &amp; désavantages, compétences et sorts.</p>

	<h4>Sorts</h4>
	<p>Valeurs par défaut en l’absence d’indications contraires&nbsp;:</p>
	<ul>
		<li><i>Classe</i>&nbsp;: régulier</li>
		<li><i>Temps nécessaire</i>&nbsp;: rapide</li>
		<li><i>Zone de base</i>&nbsp;: 3 m</li>
	</ul>

	<!-- formulaire de sélection -->
	<fieldset class="mt-1">
		<form action="avdesav-comp-sorts" data-role="filter-form">
			<div class="flex-s">
				<div class="fl-1"><b>Affichage&nbsp;:</b></div>
				<div>
					<label>
						<input type="radio" name="affichage" value="categorie" <?= $affichage == "categorie" ? "checked" : "" ?>>
						catégories
					</label>&nbsp;
					<label>
						<input type="radio" name="affichage" value="alpha" <?= $affichage == "alpha" ? "checked" : "" ?>>
						alphabétique
					</label>
				</div>
			</div>
			<div class="mt-½">
				<div><b>Sorts à afficher&nbsp;:</b></div>
				<div class="flex-s ai-center jc-space-between mt-½" data-role="spell-filter">
					Niveaux
					<input type="text" data-role="range-filter" style="width: 5ch;" class="ta-center p-0" placeholder="1-5" value="1-5">
					<label>
						<input type="checkbox" checked data-role="origin-selector" value="RdB"> RdB
					</label>
					<label>
						<input type="checkbox" checked data-role="origin-selector" value="nouveau"> Nouveaux
					</label>
					<label>
						<input type="checkbox" checked data-role="origin-selector" value="ADD"> AD&amp;D
					</label>
				</div>
			</div>
			<div class="mt-½">
				<div><b>Rechercher</b></div>
				<input type="text" name="keyword" class="fl-1 border-grey-700 px-1 py-½ full-width">
			</div>
		</form>
	</fieldset>
</article>

<!-- Avantages & Désavantages -->
<article class="as-start" data-role="avdesavs-wrapper">
	<h2>
		<?php if ($_SESSION["Statut"] === 3) { ?><a href="gestion-listes?req=avdesav&id=0" class="edit-link ff-far">&#xf044;&nbsp;</a><?php } ?>
		Avantages &amp; Désavantages
	</h2>

	<?php if ($affichage == "alpha") {
		$avdesav_list = $avdesav_repo->getAllAvDesav();
		foreach ($avdesav_list as $avdesav) {
			$avdesav->displayInRules(show_edit_link: $_SESSION["Statut"] === 3);
		}
	} else {
		$avdesav_categories = $avdesav_repo->getDistinctCategories();
		foreach ($avdesav_categories as $category) {
			$avdesav_list = $avdesav_repo->getAvDesavByCategory($category);
	?>
			<details class="<?= $category === "Psi" ? "mb-1" : "" ?>">
				<summary><h3><?= $category ?></h3></summary>
				<?php if ($category === "PNJ") { ?>
					<p class="mt-1">Certains PNJ peuvent vous fournir aide et assis&shy;tance. Le coût de ces PNJ, en tant qu’<i>Avantage</i>, dépend de l’ampleur de l’aide qu’ils peuvent offrir. Cette aide est sincère et sans autre contrepartie qu’une aide équivalente et/ou une loyauté de la part du PJ lorsque nécessaire.<br>
						Deux valeurs en points sont données&nbsp;: la 1<sup>ère</sup> correspond à une aide occasionnelle, la deuxième à une aide possible en toutes circonstances (sauf cas de force majeure).
					</p>
					<ul class="flow mt-1">
						<li><b>Aide minime (1 ou 2 pts)&nbsp;:</b> fournir un toit, un coup de main sans risque, prêter une petite somme d’argent.</li>
						<li><b>Aide non négligeable (10 ou 15 pts) :</b> prêter main forte au PJ, prendre des risques raisonnés. Permet en gros de doubler les capacités du PJ.<br></li>
						<li><b>Aide importante (15 ou 30 pts) :</b> fournir une aide substantielle au PJ, sans laquelle ce dernier pourrait avoir des problèmes sérieux ou échouer dans un objectif important, tirer le PJ d’un problème sérieux.<br></li>
						<li><b>Aide très importante (30 ou 60 pts) :</b> résout à peu près tous les problèmes du PJ, dans la mesure du possible.</li>
					</ul>

					<p>D’autres PNJ peuvent être des <i>Désavantages</i>&nbsp;: les <i>Ennemis</i> et les <i>Subordonnés</i>.</p>

				<?php } elseif ($category === "Caractéristiques secondaires") { ?>
					<p>Modifier les caractéristiques secondaires compte comme un <i>Avantage</i> ou un <i>Désavantage</i>. Ces modifications doivent rester exceptionnelles et justifiées, sauf pour les PdM supplémentaires.</p>
				<?php }

				foreach ($avdesav_list as $avdesav) {
					$avdesav->displayInRules(show_edit_link: $_SESSION["Statut"] === 3);
				} ?>
			</details>
	<?php }
	} ?>
</article>

<!-- Compétences -->
<article class="as-start" data-role="skills-wrapper">
	<h2>
		<?php if ($_SESSION["Statut"] === 3) { ?><a href="gestion-listes?req=competence&id=0" class="edit-link ff-far">&#xf044;&nbsp;</a><?php } ?>
		Compétences
	</h2>

	<?php if ($affichage == "alpha") {
		$skills_list = $skills_repo->getAllSkills();
		foreach ($skills_list as $skill) {
			$skill->displayInRules(show_edit_link: $_SESSION["Statut"] === 3);
		}
	} else {
		$skills_categories = $skills_repo->getDistinctCategories();
		foreach ($skills_categories as $category) {
			$skills_list = $skills_repo->getSkillsByCategory($category) ?>

			<details class="<?= $category === "Voleur - espion" ? "mb-1" : "" ?>">
				<summary><h3><?= $category ?></h3></summary>
				<?php if ($category == "Professionnelle") { ?>
					<p>Les compétences ci-dessous sont des exemples non limitatifs de compétences professionnelles. En cas de besoin d’une nouvelle compétence, parlez-en à votre MJ webmaster qui ajoutera la compétence nécessaire.</p>

				<?php } elseif ($category == "Sciences &amp; connaissances") { ?>
					<p>Il existe de très nombreuses compétences de type <i>Sciences &amp; connaissance</i>. Une compétence de ce type faisant appel à un nombre relativement restreint de savoirs, sans concept complexe est de type [I-2]. Une compétence dont le champ est très vaste et/ou faisant appel à des concepts complexes est de type [I-6]. La liste ci-dessous n’est pas limitative. En cas de besoin, parlez-en à votre MJ web-master qui ajoutera la compétence nécessaire.</p>

				<?php } elseif ($category == "Langue") { ?>
					<p>La plupart des langues sont de difficulté moyenne [I(-4)] mais un sabir/créole sera facile [I(-2)] et une langue à la structure grammaticale très complexe sera ardue [I(-6)]. La difficulté dépend également de la proximité entre la langue maternelle du personnage et la langue apprise.<br>
						Niveau par défaut de la langue maternelle&nbsp;: <i>Int</i> + 5 ± <i>Statut social</i>.</p>

					<h4>Signification du score de compétence</h4>
					<p>
						<b>&le; 9 :</b> Reconnaît quelques mots importants.<br>
						<b>10 :</b> Questions simples, environnement proche et familier.<br>
						<b>11 :</b> Descriptions, conversations simples.<br>
						<b>12-13 :</b> Début d’autonomie ; se débrouiller, exprimer son opinion.<br>
						<b>14-15 :</b> Compréhension courante et capacité à converser ; émettre un avis, soutenir une argumentation.<br>
						<b>16-17 :</b> S’exprimer spontanément et couramment. Bonne maîtrise.<br>
						<b>18-19 :</b> Comprend sans effort, s’exprime spontanément, de manière fine et nuancée. Très bonne maîtrise.<br>
						<b>&ge; 20 :</b> Excellente maîtrise de la langue, de toutes ses finesses et des registres peu usités (ancien, littéraire, etc.)
					</p>

					<h4>Niveau, accents et prononciation</h4>
					<p>L’accent d’un personnage dépend la différence entre sa compétence en langue (incluant les bonus de l’avantage <i>Don pour les langues</i>) et son <i>Int</i>. Pour ce qui est des accents, le score en <i>Langue</i> effectif est diminué de 1 pour <i>Mémoire infaillible</i> au niveau 1 et de 2 pour <i>Mémoire infaillible</i> au niveau 2.</p>

					<p>
						<b>≤ -2 :</b> Accent pouvant gêner la compréhension.<br>
						<b>≥ -1 :</b> Accent n’empêchant pas la compréhension.<br>
						<b>≥ +2 :</b> Léger accent.<br>
						<b>≥ +4 :</b> Accent difficilement perceptible.<br>
						<b>≥ +6 :</b> Aucun accent.
					</p>

				<?php } elseif ($category == "Sociale") { ?>
					<p>Les modificateurs aux JR peuvent s’appliquer aux jets de compétences sociales. Il faut reporter sur la fiche de personnage ceux qui s’appliquent en permanence (<i>Charisme</i>, <i>Apparence</i>) et garder les autres en tête. Le MJ décidera si tel ou tel autre modificateur aux JR (<i>Trait de caractère</i>, <i>Attitude odieuse</i>, <i>Réputation</i>, <i>Statut</i>) peut s’appliquer dans une situation donnée.</p>

				<?php } elseif ($category == "Plein air") { ?>
					<p>Les sports ne sont pas tous explicités. Une compétence sportive est basée sur F ou FD et sa difficulté est généralement de -2 ou -4. En cas de besoin, parlez-en à votre MJ web-master qui ajoutera la compétence nécessaire.</p>
				<?php }

				foreach ($skills_list as $skill) {
					$skill->displayInRules(show_edit_link: $_SESSION["Statut"] === 3);
				} ?>
			</details>
	<?php }
	} ?>

</article>

<!-- Sorts -->
<article class="as-start" data-role="spells-wrapper">
	<h2>
		<?php if ($_SESSION["Statut"] == 3) { ?><a href="gestion-listes?req=sort&id=0" class="edit-link ff-far">&#xf044;&nbsp;</a><?php } ?>
		Sorts
	</h2>
	<?php
	$all_colleges_names = $colleges_repo->getCollegesName();
	?>
	<?php if ($affichage == 'alpha') {
		$spells = $spells_repo->getAllSpells();
		foreach ($spells as $spell) {
			$spell->displayInRules(show_edit_link: $_SESSION["Statut"] === 3, data: ["name" => "", "cost-mult" => 0, "colleges-list" => $all_colleges_names]);
		}
	} else {
		$colleges = $colleges_repo->getAllColleges();
		foreach ($colleges as $college) {
			$spells = $spells_repo->getSpellsByCollege($college->id);
	?>
			<details class="<?= $college->id === 21 ? "mb-1" : "" ?>">
				<summary><h3><?= $college->name ?></h3></summary>
				<p><?= $college->description ?></p>
				<?php foreach ($spells as $spell) {
					$spell->displayInRules(show_edit_link: $_SESSION["Statut"] === 3, data: ["name" => "", "cost-mult" => 0, "colleges-list" => $all_colleges_names]);
				} ?>
			</details>

	<?php }
	} ?>

</article>

<script type="module" src="/scripts/items-filter.js?v=<?= VERSION ?>" defer></script>