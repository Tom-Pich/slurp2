<?php

use App\Entity\Power;
use App\Entity\Spell;
use App\Repository\AvDesavRepository;
use App\Repository\SkillRepository;
use App\Rules\WeaponsController;
use App\Rules\ArmorsController;
use App\Rules\EquipmentListController;

$avdesav_repo = new AvDesavRepository;
$skill_repo = new SkillRepository;

$demorthen_power_cost = [];
foreach (Spell::cost_as_power as $cost) {
	$demorthen_power_cost[] = $cost * Power::demorthen_mult;
}
?>

<!-- Personnages -->
<article>
	<h2>Personnage</h2>

	<!-- Rôles et statuts particuliers -->
	<details>
		<summary>
			<h3>Rôles et statuts particuliers</h3>
		</summary>
		<ul>
			<li><b>demorthèn&nbsp;:</b> représentant de la nature, il peut entrer en contact avec les esprits (C’maogh) et leur demander d’accomplir des tâches particulières. Il est le gardien des anciennes traditions péninsulaires et il est souvent considéré avec respect. Les apprentis demorthèn sont appelés <i>ionnthèn</i></li>
			<li><b>dàmàthair&nbsp;:</b> femme ayant la responsabilité, dans une communauté, de l’éducation des enfants et de la protection des plus faibles lors des attaques.</li>
			<li><b>ansailéir&nbsp;:</b> chef de clan</li>
			<li><b>varigal&nbsp;:</b> voyageur, messager, porteur de nouvelles et de colis, le varigal est un lien entre les communautés éparses de tri-Kazel. Passant l’essentiel de sa vie sur les chemins, il est généralement bien accueilli quand il arrive dans un village. Proches de la nature, les varigaux sont souvent les alliés des demorthèn.</li>
		</ul>
	</details>

	<!-- Avantages & désavantages -->
	<details>
		<summary>
			<h3>Avantages &amp; Désavantages</h3>
		</summary>
		<ul>
			<li><b>Alphabétisation&nbsp;:</b> <i>Semi-alphabétisation</i> par défaut. <i>Illettrisme</i>&nbsp;: -5 pts&nbsp;; <i>Alphabétisation</i>&nbsp;: 5 pts.</li>
			<li><b>Richesse&nbsp;:</b> la richesse moyenne de départ est de 250 daols de braise.</li>
			<li><b>Statut – varigal (5 pts)&nbsp;:</b> les varigaux sont généralement bien accueillis où qu’ils aillent.</li>
		</ul>

		<h4>Avantages &amp; désavantages spécifiques</h4>
		<div>
			<?php
			$don_sigil_ran = $avdesav_repo->getAvDesav(187);
			$don_sigil_ran->displayInRules(show_edit_link: $_SESSION["Statut"] === 3);
			?>
		</div>
	</details>

	<!-- Demorthen -->
	<details>
		<summary>
			<h3>Demorthèn</h3>
		</summary>
		<p>Spécificité des personnages demorthèn ou ionnthèn.</p>

		<h4>Avantages &amp; désavantages</h4>
		<ul class="flow">
			<li><b>Statut (5/10 pts)&nbsp;:</b> en Tri-Kazel, les demorthèn sont respectés. La plupart des habitants du royaume les considèrent avec déférence et leur font confiance. Le statut de <i>demorthèn</i> est donc un avantage à 10 pts. Le statut de <i>ionnthèn</i> (apprenti) vaut 5 pts.</li>
			<li><b>Dévotion (-5 pts)&nbsp;:</b> les traditions demorthèn ne sont pas extrêmement contraignantes. Un demorthèn se doit d’assister aux <i>tsioghairs</i> et de rendre un culte aux C’maogh, les esprits de la Nature.</li>
			<li><b>Vœux (-10 pts)&nbsp;:</b> maintenir l’équilibre des cycles naturels, rendre un culte aux C’maogh, ne pas utiliser ses pouvoirs à des fins personnelles, guider et protéger la communauté dont le demorthèn a la charge, transmettre le savoir traditionnel.</li>
			<li><b>Don pour la Sigil Rann&nbsp;:</b> si le demorthèn dispose de pouvoirs, il doit également avoir cet avantage au niveau 1 minimum.</li>
		</ul>

		<h4>Compétences</h4>
		<p>Les demorthèn ont deux compétences spécifiques&nbsp;: <i>Savoirs demorthèn</i> et <i>Sigil Rann</i> (voir ci-dessous).</p>
		<p>En plus de ces compétences spécifiques, les compétences suivantes sont recommandées&nbsp;: <i>Connaissance de la Nature</i>, <i>Premiers secours</i>, <i>Médecine</i>, <i>Herboristerie</i>&hellip;</p>

		<div>
			<?php
			$demorthen_skills = [];
			$demorthen_skills[] = $skill_repo->getSkill(206); // Savoirs demorthèn
			$demorthen_skills[] = $skill_repo->getSkill(207); // Sigill Rann
			foreach ($demorthen_skills as $skill) {
				$skill->displayInRules(show_edit_link: $_SESSION["Statut"] === 3);
			}
			?>
		</div>
	</details>

	<!-- Membre du Temple -->
	<details>
		<summary>
			<h3>Membre du temple</h3>
		</summary>

		<p>Spécificité des personnages appartenant à un ordre du temple.</p>

		<h4>Avantages &amp; désavantages</h4>
		<ul class="flow">
			<li><b>Statut (5 pts/niv)&nbsp;:</b> chacun des 6 ordres du temple et lui-même hiérachisé en 6 niveaux, d’<i>Adepte</i> (1) à <i>Hiérophante</i> (6). Les membres du Temple sont hautement respecté dans le royaume de Gwidre. Mais en dehors, les réactions varient entre méfiance et franche hostilité.</li>
			<li><b>Dévotion (-15 pts)&nbsp;:</b> tous les membres du Temple doivent prier 6 fois par jour (entre 15 et 30 minutes). Un manquement à une règle (sauf cas de force majeure) doit être suivi d’un acte de péintence.</li>
			<li><b>Vœux (-15 pts)&nbsp;:</b> suivre les 6 Ordonnances, ne pas boire d’alcool, rester chaste et manger avec modération, se vêtir de couleurs ternes, être humble et reconnaissant envers le Dieu Unique.</li>
			<li><b>Devoir (variable)&nbsp;:</b> les membres du Temple doivent accomplir leur devoir, qui dépend de l’Ordre auquel ils appartiennent et de leur rang.</li>
			<li><b>Protecteur (15 pts)&nbsp;:</b> le Temple viendra en aide à ses membres en réelles difficultés. Cela peut prendre un certain temps, et donc ne pas toujours être utile.</li>
		</ul>

		<h4>Compétences</h4>
		<p>Théologie</p>
	</details>

</article>

<!-- Équipement -->
<article>
	<h2>Équipement</h2>

	<!-- Système monétaire -->
	<details>
		<summary>
			<h3>Système monétaire</h3>
		</summary>
		<h4>Pièces</h4>
		<p>daols de braise (dB); daols d’azur (dA); daols de givre (dG)</p>
		<p>1 dG = 10 dA = 100 dB</p>
		<p>Pièces triangulaires, faites d’alliage</p>
		<p>À détailler plus tard</p>

		<h4>Salaires moyens à la journée</h4>
		<p>
			<b>Professions manuelles peu qualifiées&nbsp;: 6 dB</b><br>
			(porteur, ratier, manœuvre, serveuse, garçon d’écurie, ouvrier agricole, jardinier)
		</p>
		<p>
			<b>Professions manuelles qualifiées&nbsp;: 8 dB</b><br>
			(compagnons artisans – maçons, charpentiers, tisserands, tenturiers&hellip; – cuisinier, conducteur d’attelage, marin)
		</p>
		<p>
			<b>Professions lettrées ou artistiques&nbsp;: 10 dB</b><br>
			(musicien, peintre, précepteur, scribe, archiviste, médecin, alchimiste)
		</p>
		<p>
			<b>Professions à risques&nbsp;: 10 dB</b><br>
			(varigal, mercenaire, garde du corps, messager)
		</p>
	</details>

	<!-- Armes -->
	<details>
		<summary>
			<h3>Armes</h3>
		</summary>

		<?php
		$weapons = array_filter(WeaponsController::weapons, fn($weapon) => isset($weapon["prix"][1]));
		//$weapons = Sorter::sort($weapons, "nom");
		WeaponsController::displayWeaponsList($weapons, false, true, 1, "dB");
		?>
	</details>

	<!-- Armures & boucliers -->
	<details>
		<?php
		// paramètres des armures
		$price_index = 1;
		$with_magic_modifiers = false;
		$excluded_sizes = ["xs"];
		$armors = array_filter(ArmorsController::armors, fn($armor) => isset($armor["prix"][$price_index]))
		?>
		<summary>
			<h3>Armures &amp; boucliers</h3>
		</summary>

		<p>Armures «&nbsp;hypothétiques&nbsp;» complètes, données pour infos (voir la page <a href="/armes-armures">Armes &amp; armures</a> pour plus de détails). Vous <i>devez</i> construire votre armure composite.</p>

		<table class="left-1 alternate-e">
			<tr>
				<th>Armure</th>
				<th>RD</th>
				<th>Poids</th>
				<th>dB</th>
			</tr>
			<?php foreach ($armors as $armor) { ?>
				<tr>
					<td><?= $armor["nom"] . ($armor["notes"] ? "<sup>" . $armor["notes"] . "</sup>" : "") ?></td>
					<td><?= $armor["RD"] ?></td>
					<td><?= $armor["pds"] ?> kg</td>
					<td><?= $armor["prix"][$price_index] ?></td>
				</tr>
			<?php } ?>
		</table>

		<?php foreach (ArmorsController::armors_notes as $index => $note) { ?>
			<p class="fs-300"><?= $index ?>&nbsp;: <?= $note ?></p>
		<?php } ?>

		<?php include "content/components/widget-armor-composer.php"; ?>

		<table class="mt-2 left-1 alternate-e">
			<tr>
				<th>Bouclier</th>
				<th>DP</th>
				<th>Poids</th>
				<th>dB</th>
			</tr>
			<?php foreach (ArmorsController::shields as $shield) {
				if (isset($shield["prix"][1])) { ?>
					<tr>
						<td><?= $shield["nom"] ?></td>
						<td><?= $shield["DP"] ?></td>
						<td><?= $shield["pds"] ?> kg</td>
						<td><?= $shield["prix"][1] ?></td>
					</tr>
			<?php }
			} ?>
		</table>

	</details>

	<!-- Prix en vrac -->
	<details>
		<summary>
			<h3>Prix en vrac</h3>
		</summary>
		<?php
		$items = array_filter(EquipmentListController::equipment_list, fn($item) => in_array($item[3], ["auberge", "nourriture"]));
		EquipmentListController::displayEquipmentList($items, 1);
		?>
	</details>

	<details>
		<summary>
			<h3>Cartouches de flux</h3>
		</summary>
		<p>
			Le Flux est souvent conditionné sous forme de cartouches à l’enveloppe métallique très fine. Une cartouche standard contient une unique charge (environ 100 mL). C’est un cylindre de 3,6 cm de diamètre et 10 cm de haut. Elle pèse 130 g lorsqu’elle est pleine, et 45 g vide.<br>
			Il existe aussi des cartouches «&nbsp;medium&nbsp;» renfermant trois charges, ainsi que des bobonnes blindées renfermant 30 charges (3 L).
		</p>
		<h4>Prix, Taol-Kaer</h4>
		<?php
		$items = array_filter(EquipmentListController::esteren_flux, fn($item) => in_array($item[3], ["flux-taol-kaer"]));
		EquipmentListController::displayEquipmentList($items, 1);
		?>
	</details>

</article>

<!-- Demorthén -->
<article>
	<h2>Les démorthèn</h2>

	<!-- Généralités -->
	<details>
		<summary>
			<h3>Généralités</h3>
		</summary>
		<p>Les demorthèn sont à la fois les guides spirituels des Tri-Kazéliens et les détenteurs des secrets qui permettent d’influencer les esprits de la Nature, les C’maogh. Ils se consacrent surtout à maintenir l’équilibre entre les besoins des communautés humaines et la préservation de la nature environnante.</p>
	</details>

	<!-- Acquérir un pouvoir -->
	<details>
		<summary>
			<h3>Acquérir un pouvoir</h3>
		</summary>

		<h4>Domaines</h4>
		<p>Les demorthèn peuvent acquérir des pouvoirs choisis dans les 7 collèges suivants&nbsp;: Animal, Élémentaire (les 4 éléments), Soin et Végétal.</p>
		<p><b>Remarque importante&nbsp;:</b> les pouvoirs des dermothèn doivent s’inspirer de faits naturels. Ainsi, un demorthèn ne peut avoir le pouvoir <i>Foudre</i> (qui jaillit par ses mains), mais le pouvoir <i>Appel de la foudre</i> est possible.</p>

		<h4>Préalables</h4>
		<p>En préalable, ils doivent avoir la compétence <i>Sigil Rann</i> et l’avantage <i>Don pour la Sigil Rann</i> au niveau 1 minimum.</p>

		<h4>Pierres oghamiques</h4>
		<p>Un pouvoir est étroitement associé à une pierre gravée d’une rune oghamique permettant de canaliser l’énergie nécessaire pour le lancer. Sans cette pierre (s’il la perd), le demorthèn ne peut utiliser son pouvoir.</p>

		<h4>Coût des pouvoirs</h4>
		<p>
			Les pouvoirs de demorthèn s’acquiert pour un coût de <?= Power::demorthen_mult*100 ?>&nbsp;% du coût normal (soit <?= join(" / ", $demorthen_power_cost) ?> pts).<br>
			Ceci est dû au fait que pour pouvoir être utilisé, le demorthèn doit être (1) en possession de la pierre oghamique associée au pouvoir et (2) entrer en contact avec un esprit de la Nature, ce qui est un processus assez long et incertain (voir ci-dessous).
		</p>
	</details>

	<!-- Utiliser un pouvoir -->
	<details>
		<summary>
			<h3>Utiliser un pouvoir</h3>
		</summary>

		<h4>Invoquer un esprit de la Nature</h4>
		<p>Avant de lancer un pouvoir, le demorthèn doit entrer en contact avec un esprit de la nature associé au domaine (collège) du pouvoir.</p>
		<p>
			Pour ce faire, il doit passer un certain temps au calme à suivre un cérémoniel silencieux.<br>
			Faire un <b>jet de <i>Sigil Rann</i></b> pour déterminer si le demorthèn arrive à entrer en contact avec un esprit. Ce jet est assorti du <b>malus de puissance</b> associé au niveau de puissance du (ou des) pouvoir(s) que le demorthèn souhaite lancer (<?= join(" / ", Spell::niv_modifier) ?>).
		</p>
		<p><b>En cas de réussite</b>, le demorthèn arrive à entrer en contact avec un esprit en [5 – MR] minutes (au minimum 6 secondes).</p>
		<p><b>En cas d’échec</b>, le demorthèn a le droit à deux autres tentatives successives. Le demorthèn ne se rend compte de son échec qu’au bout de 5 minutes.</p>
		<p><b>S’il échoue trois fois</b> consécutivement, il ne peut tenter de contacter un esprit du même domaine qu’après une heure.</p>

		<h4>Maintenir le contact avec un esprit</h4>
		<p>Une fois le contact établi, l’esprit reste à la disposition du demorthèn pendant 3d minutes (et toujours, au minimum, le temps nécessaire pour lancer au moins un sort), lui permettant de lancer n’importe quel pouvoir pendant cet intervale de temps, du moment que son domaine corresponde à celui de l’esprit invoqué.</p>
		<p>Si, au bout de cette durée, le demorthèn souhaite maintenir le contact avec cet esprit, il doit refaire un jet de <i>Sigil Rann</i>, avec le même malus que celui qui s’est appliqué sur le jet initial. En cas de réussite, cette durée est prolongée de 3d minutes, de manière instantanée.</p>
		<p>Si le demorthèn perd conscience alors qu’il est lié avec un esprit, le lien se défait instantanément.</p>

		<h4>Contact multiple</h4>
		<p>En aucun cas un demorthèn ne peut maintenir de contact avec plusieurs esprits en même temps.</p>
	</details>

	<!-- Récupération PdM -->
	<details>
		<summary>
			<h3>Récupération du Rindath</h3>
		</summary>
		<p>Les points de <i>Rindath</i> (PdM), se récupèrent en méditant ou en dormant.</p>
		<h4>Par la méditation</h4>
		<p>La table ci-dessous donne le nombre de PdM récupérés par heure de méditation</p>
		<table class="left-1 alternate-e">
			<tr>
				<th>Environnement</th>
				<th>PdM</th>
			</tr>
			<tr>
				<td>Lieu sacré demorthèn</td>
				<td>4</td>
			</tr>
			<tr>
				<td>Dans la nature</td>
				<td>2</td>
			</tr>
			<tr>
				<td>Dans un village</td>
				<td>1</td>
			</tr>
			<tr>
				<td>Dans une cité ou une usine magientiste</td>
				<td>¼</td>
			</tr>
		</table>
		<p>Le demorthèn peut récupérer au maximum 5 PdM par jour par ce biais</p>

		<h4>Par le sommeil</h4>
		<p>Chaque nuit de sommeil permet de récupérer 2 PdM</p>

	</details>

	<h4>À creuser</h4>
	<ul>
		<li>Pts de Rindath supplémentaires</li>
	</ul>
</article>

<!-- Temple -->
<article>
	<h2>Le Temple</h2>

	<!-- Préceptes du Temple -->
	<details>
		<summary>
			<h3>Les préceptes du Temple</h3>
		</summary>

		<p>Pour les Tri-Kazeliens en général, les préceptes du Temple semblent bien plus durs et plus stricts que les traditions enseignées par les demorthèn. En effet, afin d'obtenir les faveurs du Dieu Unique, les hommes et les femmes doivent vivre une vie calme et ascétique, loin des excès qui corrompent le corps comme l'esprit. Les couleurs vives distraient le regard, l'alcool détourne l'esprit de la pensée du Créateur et les débauches poussent à la propagation de maladies qui ravagent les populations. II existe ainsi toute une série d'Ordonnances donnés par le Dieu Unique à Soustraine, que ses héritiers, les Hiérophantes du Temple, continuent à transmettre aux fidèles.</p>

		<p>Toutes ces restrictions servent à garder les gens proches du Créateur et à les guider sur le seul chemin de la foi. Elles protègent l'humanité de la menace des abysses et des démons qui s'y terrent. À sa mort, l'homme ou la femme qui a su rester pur rejoindra le Royaume Divin et jouira d'une sérénité éternelle. Les autres seront engloutis dans les Limbes et souffriront pour toujours. Ainsi, pour s'assurer la félicité après la mort, chacun se doit de suivre les commandements du Dieu Unique.</p>
	</details>

	<!-- les Écrits et les Ordonnances -->
	<details>
		<summary>
			<h3>Les Écrits et les Ordonnances</h3>
		</summary>

		<p>
			Le prophète Soustraine passa beaucoup de temps à retranscrire sa révélation. Il a ainsi écrit un ouvrage de quelque six cents pages dont le contenu est très varié&nbsp;: poèmes, psaumes, histoires, paraboles, dessins, le tout formant un ensemble complexe et parfois cryptique.<br>
			Tous les adeptes passent un grand nombre d'heures à apprendre <i>les Écrits</i>.<br>
			Les six Ordonnances en forment le pivot central, six commandements que le Créateur a dictés à Soustraine et qui constituent le cœur de la religion du Dieu Unique&nbsp;:
		</p>

		<ol>
			<li>Tu suivras la seule voie du Dieu Unique.</li>
			<li>Tu écouteras les paroles sacrées du Créateur.</li>
			<li>Tu transmettras la Vérité à toute personne croisant ton chemin.</li>
			<li>Tu maîtriseras tes passions et seras modéré en toute chose.</li>
			<li>Tu seras humble et remercieras le Créateur pour les dons qui te sont conférés.</li>
			<li>Tu feras acte de prière et de recueillement pour la gloire du Dieu Unique.</li>
		</ol>

	</details>

	<!-- Les six ordres -->
	<details>
		<summary>
			<h3>Les six ordres</h3>
		</summary>
		<p>Tous ces ordres sont mixtes</p>
		<ul>
			<li>Les prêtres</li>
			<li>Les moines</li>
			<li>Les clercs</li>
			<li>Les chevaliers lame</li>
			<li>Les vecteurs</li>
			<li>Les sigires</li>
		</ul>
	</details>

</article>

<!-- Magience -->
<article>
	<h2>La Magience</h2>

	<details>
		<summary>
			<h3>Types de Flux</h3>
		</summary>
		<p>Animal, végétal, minéral et fossile.</p>
	</details>

	<details>
		<summary>
			<h3>Flux fossile</h3>
		</summary>
		<p>Aussi rare que pécieux, le Flux fosssile possèdent trois qualités essentielles&nbsp;:</p>
		<ul>
			<li>Il n’a pas besoin d’être extrait et peut être directement raffiné.</li>
			<li>Il est trois fois plus riche en énergie que les autres Flux.</li>
			<li>À de rares exceptions près, il fonctionne avec tous les artefacts, quel que soit le type de Flux qu’ils emploient normalement.</li>
		</ul>
	</details>


</article>