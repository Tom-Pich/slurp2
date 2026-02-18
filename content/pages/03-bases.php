<?php

use App\Rules\StressController;
use App\Rules\FatigueController;
use App\Rules\EncumbranceController;
use App\Rules\MentalHealthController;
use App\Rules\ReactionController;
use App\Entity\Skill;
use App\Repository\SkillRepository;

?>

<!-- Intro -->
<!-- <article>
	<h2>Généralités sur les jets</h2>
	<details>
		<summary>
			<h3>Types de jets</h3>
		</summary>
		<p>Il y a 3 types de jets à SLURP. Tous se font avec des d6.</p>
		<p>L’abbréviation «&nbsp;d&nbsp;» signifie d6.</p>
		<ul>
			<li>Les <b>jets des réussite</b>, avec 3d6, visant à tester une compétence ou une caractéristique. Le jet est réussi s'il est inférieur ou égal au score, ajusté par certains modificateurs.</li>
			<li>Les <b>jets de dégâts</b>, avec un nombre variable de d6.</li>
			<li>Les jets de réaction, qui se font avec 1d6</li>
		</ul>
	</details>
	<details>
		<summary>
			<h3>Dégâts inférieurs à 1d-1</h3>
		</summary>
		Pour les jets de dégâts inférieurs à 1d-1, utiliser les correspondances suivantes&nbsp;: 1d-2 → 1d5-1, 1d-3 → 1d4-1, 1d-4 → 1d3-1, 1d-5 → 1d2-1
	</details>

	
</article> -->

<!-- Jet de réussite -->
<article>
	<h2>Jet de réussite</h2>

	<!-- Principes de bas -->
	<details>
		<summary>
			<h3>Principes de base</h3>
		</summary>
		<p>Un jet sous une compétence ou une caractéristique est réussi si&nbsp;:</p>
		<p class="ta-center mt-1"><b>Résultat du jet (3d) &le; score ± modificateurs</b></p>
		<p class="mt-1">3 et 4 sont toujours des réussites, 17 et 18 sont toujours des échecs.</p>
		<p>Le <b>score brut</b> est le score sans aucun modificateur. Le <b>score net</b> est le score après application des différents modificateurs de circonstances ci-dessous.</p>
	</details>

	<!-- Difficulté -->
	<details>
		<summary>
			<h3>Difficulté</h3>
		</summary>
		<p>Difficulté intrinsèque de l’action, sans tenir compte de l’état du personnage.</p>
		<table class="left-1">
			<tr>
				<th>Difficulté</th>
				<th>Modificateur</th>
			</tr>
			<tr>
				<td>Héroïque</td>
				<td>-15</td>
			</tr>
			<tr>
				<td>Extrêmement difficile</td>
				<td>-10</td>
			</tr>
			<tr>
				<td>Très difficile</td>
				<td>-5</td>
			</tr>
			<tr>
				<td>Difficile</td>
				<td>-3</td>
			</tr>
			<tr>
				<td>Moyenne (malaisé)</td>
				<td>+0</td>
			</tr>
			<tr>
				<td>Facile</td>
				<td>+3</td>
			</tr>
			<tr>
				<td>Très Facile</td>
				<td>+5</td>
			</tr>
			<tr>
				<td>Enfantin</td>
				<td>+7</td>
			</tr>
		</table>
	</detailS>

	<!-- État du personnage -->
	<details>
		<summary>
			<h3>État du personnage</h3>
		</summary>
		<p>L’état du personnage dépend des facteurs suivants&nbsp;:</p>
		<ol class="bold-bullet">
			<li>Encombrement</li>
			<li>Fatigue</li>
			<li>Stress</li>
			<li>Santé mentale</li>
			<li>Blessures</li>
		</ol>
		<p>
			Ces facteurs influent directement sur les caractéristiques du personnage, et donc sur toutes les compétences qui en dépendent, les avantages et désavantages nécessitant un jet de réussite, ainsi que les sorts et pouvoirs.
		</p>
		<p>
			Les caractéristiques secondaires <i>Dégâts de base</i>, <i>Sang-Froid</i> et <i>Réflexes</i> sont également susceptibles d’être modifiées suite à une variation des caractéristiques principales dont elles dépendent.<br>
			A contrario, ni la <i>Vitesse</i> ni les PdV, PdF, PdM et PdE ne peuvent être modifiés suite à une variation des caractéristiques principales dont ils dépendent.
		</p>
		<p>Voir les sections correspondantes dans ce chapitre et dans le chapitre <a href="/blessures-dangers">Blessures &amp; Dangers</a>.</p>
	</details>

	<!-- Autres modificateurs -->
	<details>
		<summary>
			<h3>Autres modificateurs</h3>
		</summary>
		<ul class="mt-½">
			<li><b>Matériel utilisé</b> pour entreprendre l’action.</li>
			<li><b>Environnement&nbsp;:</b> obscurité, sol instable, etc.</li>
			<li><b>Main dextre / main «&nbsp;faible&nbsp;»&nbsp;:</b> effectuer une action avec sa main «&nbsp;faible&nbsp;» qui nécessiterait l’usage de la main dextre se fait généralement à -3.</li>
		</ul>
	</detailS>

	<!-- Marge de réussite -->
	<details>
		<summary>
			<h3>Marge de réussite</h3>
		</summary>
		<p class="ta-center fw-700">MR = score net – résultat du jet</p>
		<p>Le MJ interprète librement la marge de réussite (MR), ou la marge d’échec (ME).</p>
	</details>

	<!-- Réussite et échec critiques -->
	<details>
		<summary>
			<h3>Réussite et échec critiques</h3>
		</summary>
		<table>
			<tr>
				<th width="10%">Jet</th>
				<th>Réussite critique</th>
				<th width="10%">Jet</th>
				<th>Échec critique</th>
			</tr>
			<tr>
				<td>3</td>
				<td>Toujours</td>
				<td>18</td>
				<td>Toujours</td>
			</tr>
			<tr>
				<td>4</td>
				<td>Score net &ge; 6</td>
				<td>17</td>
				<td>Score net &le; 15</td>
			</tr>
			<tr>
				<td>5-7</td>
				<td>MR &ge; 10</td>
				<td>5+</td>
				<td>ME &ge; 10</td>
			</tr>
		</table>
	</details>

	<!-- Duel -->
	<details>
		<summary>
			<h3>Duel</h3>
		</summary>
		<p>Comparer la MR des deux opposants. La victoire d’un des protagonistes est d’autant plus nette que la différence des MR (&Delta;MR) est grande. L'égalité bénéficie au défenseur</p>
	</details>

	<!-- Jet de probabilité -->
	<details>
		<summary>
			<h3>Jets de probabilité</h3>
		</summary>
		<p>Lorsque il faut faire un jet sous «&nbsp;rien&nbsp;», consulter la table ci-dessous.</p>

		<table class="left-1">
			<tr>
				<th>Probabilité</th>
				<th>Score</th>
			</tr>
			<tr>
				<td>Presque aucune chance</td>
				<td>4</td>
			</tr>
			<tr>
				<td>Très peu probable</td>
				<td>6</td>
			</tr>
			<tr>
				<td>Peu probable</td>
				<td>8</td>
			</tr>
			<tr>
				<td>Incertain</td>
				<td>10</td>
			</tr>
			<tr>
				<td>Assez probable</td>
				<td>12</td>
			</tr>
			<tr>
				<td>Très probable</td>
				<td>14</td>
			</tr>
			<tr>
				<td>Quasi-sûr</td>
				<td>16</td>
			</tr>
		</table>

	</details>

</article>

<!-- Exploits physiques -->
<article>
	<h2>Exploits physiques</h2>

	<details>
		<summary>
			<h3>Déplacement</h3>
		</summary>
		<p>La caractéristique secondaire <i>Vitesse</i> indique la <b>vitesse de marche</b> (en km/h) du personnage lorsque celui-ci adopte une marche rapide pour un temps long (en voyage ou en randonnée, par exemple).</p>
		<p>Lorsque le personnage veut faire un <b>sprint</b>, la <i>Vitesse</i> correspond à sa vitesse en m/s dans des conditions optimales.<br>
			Ajouter 1/8<sup>e</sup> de la compétence <i>Course</i> (arrondi au quart de point).</p>
		<p>La <i>Fatigue</i>, l’<i>Encombrement</i> et le niveau de blessures influent sur la <i>Vitesse</i>. L’<i>Encombrement</i> compte double en cas de sprint.</p>
	</details>

	<details>
		<summary>
			<h3>Saut</h3>
		</summary>
		<p>Pour réussir à sauter suffisamment loin ou haut, jet de <i>Saut</i>. Les malus d’<i>Encombrement</i> sont doublés.</p>
	</details>

	<details>
		<summary>
			<h3>Soulever et déplacer des objets</h3>
		</summary>
		<p>Il est possible de soulever ou déplacer un poids, en kg, allant jusqu’à :</p>
		<ul>
			<li><b>À une main :</b> 3×<i>For</i></li>
			<li><b>À deux mains :</b> 10×<i>For</i></li>
			<li><b>Sur le dos :</b> 12,5×<i>For</i></li>
			<li><b>Traîner sur une surface lisse et nivelée :</b> 30×<i>For</i></li>
		</ul>
		<p>Un jet de <i>For</i> réussi peut permettre de dépasser légèrement ces limites.</p>
	</details>

	<details>
		<summary>
			<h3>Nage</h3>
		</summary>
		<p>En cas d’échec à un jet de <i>Nage</i>, perte de 1 PdF. Refaire un jet toutes les 5 secondes, jusqu’à ce qu’il y ait noyade, sauvetage ou un jet de <i>Nage</i> réussi.</p>
		<p><i>Encombrement</i> : dépend de la densité de l’équipement.</p>
		<p>Vitesse de nage : 1/10<sup>e</sup> de la compétence en <i>Nage</i> en sprint.</p>
		<p><b>Combat dans l’eau :</b> jets de <i>Nage</i> régulièrement si le personnage n’a pas pied. Perte rapide de PdF. Les dégâts sont réduits de moitié en immersion.</p>
	</details>

	<details>
		<summary>
			<h3>Retenir sa respiration</h3>
		</summary>
		<ul class="mt-½">
			<li><b>Au repos :</b> <i>San</i>×6 secondes.</li>
			<li><b>Activité physique modérée :</b> <i>San</i>×2 secondes.</li>
			<li><b>Exercice physique important :</b> <i>San</i> secondes.</li>
		</ul>
		<p><b>Modificateurs :</b> ×2 si hyperoxygénation ; ×½ si surprise et pas de préparation.</p>
		<p><i>Contrôle du souffle</i> peut se substituer à la <i>San</i> pour le calcul de la durée de l’apnée. Une fois à bout de souffle, voir <i>Suffocation</i> (chapitre <i>Blessures &amp; Dangers</i>).</p>
	</details>

</article>

<!-- Encombrement -->
<article>
	<h2>Encombrement</h2>

	<details>
		<summary>
			<h3>Principes de base</h3>
		</summary>
		<p>L’<i>Encombrement</i> dépend du poids porté par le personnage et de sa <i>For</i>. Il réduit sa <i>Vitesse</i> et sa <i>Dex</i>.</p>
	</details>

	<details>
		<summary>
			<h3>Niveaux d’encombrement</h3>
		</summary>
		<table class="left-2 mt-1">
			<tr>
				<th>Poids (kg)</th>
				<th>Encombrement et malus</th>
			</tr>
			<?php foreach (EncumbranceController::levels as $index => $level) { ?>
				<tr>
					<td>&le; For ×<?= $index ?></td>
					<td><?= ucfirst($level["name"]) ?> (<?= $level["description"] ?>)</td>
				</tr>
			<?php } ?>
		</table>
		<?php
		$mvt_skills_id = Skill::mvt_skills;
		$skill_repo = new SkillRepository;
		$mvt_skills_names = [];
		foreach ($mvt_skills_id as $id) {
			$mvt_skills_names[] = $skill_repo->getSkill($id)->name;
		}

		?>
		<p>Le malus de <i>Dex</i> est doublé pour les compétences pour lesquelles il est <b>indispensable</b> d’être léger&nbsp;: <i><?= join(", ", $mvt_skills_names) ?></i></p>
	</details>
</article>

<!-- Fatigue -->
<article>
	<h2>Fatigue</h2>

	<!-- Perte de PdF -->
	<details>
		<summary>
			<h3>Perte de points de Fatigue</h3>
		</summary>
		<p>Des points de fatigue (PdF) peuvent être perdus suite à des efforts physiques, à un manque de sommeil, de nourriture, d’eau, à des températures extrêmes ou à un manque d’air.</p>

		<h4>Efforts physiques</h4>
		<p>Les PdF perdus sont estimés par le MJ. Un jet de <i>San</i> réussi (ou d’une compétence appropriée&nbsp;: <i>Course</i>, <i>Randonnée</i>, <i>Nage</i>, etc.) réduit le coût de fatigue d’un tiers.</p>
		<ul class="mt-½">
			<li>Effort peu intense, de longue durée (marche sur terrain plat) : 1 PdF / heure</li>
			<li>Activité physique soutenu : 2-4 PdF / heure</li>
		</ul>
		<p>L’<i>Encombrement</i> multiplie ce coût&nbsp;: ×1,5 pour <i>Léger</i>, ×2 pour <i>Moyen</i>, ×3 pour <i>Pesant</i>.</p>

		<h4>Sommeil écourté</h4>
		<p>Une nuit blanche coûte 60&nbsp;% des PdF et une mauvaise nuit 40&nbsp;% des PdF (réduit d’un tiers en cas de réussite d’un jet de <i>San</i>).</p>

	</details>

	<!-- État de fatigue -->
	<details>
		<summary>
			<h3>État de fatigue et malus</h3>
		</summary>

		<p>La fatigue est susceptible d’affecter <i>toutes</i> les caractéristiques du personnage, ainsi que sa <i>Vitesse</i>.</p>

		<table class="left-2 mt-1">
			<tr>
				<th>État</th>
				<th>Effets</th>
			</tr>
			<?php foreach (array_reverse(FatigueController::levels) as $index => $level) { ?>
				<tr>
					<td>
						<?= $level["name"] ?> (PdF&nbsp;<?= $index !== 0 ? ("&le;&nbsp;" . ((float) $index) * 100 . "&nbsp;%") : "=&nbsp;0" ?>)
					</td>
					<td><?= ucfirst($level["description"]) ?></td>
				</tr>
			<?php } ?>
		</table>

		<p>Pour le cumul des blessures et de la fatigue, voir le chapitre <a href="/blessures-dangers">Blessures &amp; Dangers</a> </p>

	</details>

	<!-- Récupération -->
	<details>
		<summary>
			<h3>Récupération</h3>
		</summary>
		<p>Le MJ décide du rythme de récupération en fonction des conditions de repos et du type d’effort fourni. La seule règle est que l’on est «&nbsp;frais et dispo&nbsp;» qu’après une nuit de sommeil.</p>
		<p><b>Règle de coin de table&nbsp;:</b> en se reposant après un effort, on peut récupérer au maximum un quart des PdF dépensés.</p>
		<p>Des PdF perdus par un manque de nourriture ou d’eau ne peuvent être regagnés qu’en mangeant ou en s’hydratant.</p>
		<p>Ne tenir compte des PdF que si cela est important dans le jeu. Dans la plupart des situations, les PdF n’ont aucune importance.</p>
	</details>

</article>

<!-- Équilibre psychique -->
<article>
	<h2>Équilibre psychique</h2>

	<!-- Points d’Équilibre Psychique -->
	<details>
		<summary>
			<h3>Points d’Équilibre Psychique</h3>
		</summary>
		<p>L’équilibre psychique d’un personnage (sa santé mentale) est quantifié par ses <i>Points d’Équilibre Psychique</i> (PdE).</p>
	</details>

	<!-- Jet de Sang-Froid et PdE -->
	<details>
		<summary>
			<h3>Jet de Sang-Froid et PdE</h3>
		</summary>
		<p>Des PdE peuvent être perdus au cours de trois types de situations&nbsp;: un traumatisme, une peur extrême ou un stress intense.</p>
		<p>Lorsque plusieurs effets peuvent advenir (traumatisant et stressant, par exemple), un seul jet de <i>Sang-Froid</i> est à faire. Les conséquences sont déterminées à partir de cet unique jet.</p>
	</details>

	<!-- Traumatisme -->
	<details>
		<summary>
			<h3>Traumatisme</h3>
		</summary>
		<p>Un événement traumatisant provoque un choc psychologique. Il n’est pas nécessairement effrayant ni directement menaçant (perte d’un être cher, être témoin d’actes de barbarie, etc.).</p>
		<p>Il peut entraîner la perte de PdE&nbsp;: faire un jet de <i>Sang-froid</i> pour résister au traumatisme. En cas de réussite, la perte de PdE est divisée par 2. Ce jet de <i>Sang-froid</i> peut être assorti d’un modificateur, mais ce modificateur ne dépendra, en général, pas de l’ampleur du traumatisme, qui est quantifié par la perte de PdE, mais de l’état ou du vécu du personnage.</p>

		<table class="left-1">
			<tr>
				<th>Ampleur du traumatisme</th>
				<th>Perte PdE</th>
			</tr>
			<tr>
				<td>Écœurement fort</td>
				<td>1</td>
			</tr>
			<tr>
				<td>Choc, traumatisme mineur</td>
				<td>2</td>
			</tr>
			<tr>
				<td>Choc important</td>
				<td>3</td>
			</tr>
			<tr>
				<td>Horreur forte, traumatisme majeur</td>
				<td>4</td>
			</tr>
			<tr>
				<td>Horreur extrême</td>
				<td>5</td>
			</tr>
			<tr>
				<td>Abomination absolue</td>
				<td>6</td>
			</tr>
			<tr>
				<td>Mal cosmique incarné</td>
				<td>8 à 15</td>
			</tr>
		</table>
	</details>

	<!-- Peur & terreur -->
	<details>
		<summary>
			<h3>Peur &amp; Terreur</h3>
		</summary>
		<p>Lorsqu’un événement terrifie le personnage, un jet de <i>Sang-froid</i> (appelé dans ce cas <i>Test de Frayeur</i>) doit être fait pour savoir comment le personnage réagit.</p>
		<p>L’intensité de la peur potentiellement provoquée est quantifiée de I (un peu effrayant) à V (terreur surnaturelle absolue).</p>
		<p>Un modificateur peut s’appliquer à ce jet, mais il ne dépend par de l’intensité de la peur. Il peut dépendre de l’état du personnage et des conditions extérieures à l’événement terrifiant, et devrait être dans compris entre -3 et +3.</p>
		<p>Les conséquences du <i>Test de frayeur</i> dépendent de sa MR et de l’intensité de la peur provoquée.</p>

		<h4>MR et gravité</h4>
		<table class="left-2">
			<tr>
				<th>MR</th>
				<th>Conséquences</th>
			</tr>
			<tr>
				<td>R.C.</td>
				<td>Gravité réduite de trois crans</td>
			</tr>
			<tr>
				<td>&ge; 3</td>
				<td>Gravité réduite de deux crans</td>
			</tr>
			<tr>
				<td>0 à 2</td>
				<td>Gravité réduite de un cran</td>
			</tr>
			<tr>
				<td>-1 à -3</td>
				<td>Gravité nominale</td>
			</tr>
			<tr>
				<td>&le; -4</td>
				<td>Gravité agravée d’un cran</td>
			</tr>
			<tr>
				<td>E.C</td>
				<td>Gravité agravée de deux crans</td>
			</tr>
		</table>

		<h4>Conséquences</h4>
		<p>Ci-dessous la table résumée des conséquences – utiliser le widget de la <a href="/table-jeu"><i>Table de jeu</i></a> pour avoir les résultats détaillés et chiffrés. Les éléments marqués d’une astérisque sont expliqués après la table.</p>

		<table class="left-2">
			<tr>
				<th width="10">Niv.</th>
				<th>Conséquences</th>
			</tr>
			<tr>
				<td>–</td>
				<td><b>Sonné*</b> 1 pour une action</td>
			</tr>
			<tr>
				<td>I</td>
				<td><b>Sonné*</b> 1, cri éventuel. <!-- Jet de <i>S-F</i> pour reprendre ses esprits. Jet de <i>Vol</i> pour retenir un cri. --></td>
			</tr>
			<tr>
				<td>II</td>
				<td><b>Sonné*</b> 2, cri éventuel, perte PdF et PdE. <!-- Jet de <i>S-F</i> à -5 pour reprendre ses esprits. Jet de <i>Vol</i> -3 pour retenir un cri. <b>Perte de 1d-2 PdF + 1 PdE. --></b></td>
			</tr>
			<tr>
				<td>III</td>
				<td>
					<b>Choc ou panique.</b> Éventuellement réaction inconvenante* et nouveau <i>Travers</i>*. Perte PdF et PdE.
					<!-- Jet de <i>SF</i>&nbsp;: ✅ <b>choc</b><sup>(1)</sup> ou ❌ <b>panique</b><sup>(2)</sup><br>
					Jet de <i>SF</i> pour éviter une réaction inconvenante<sup>(3)</sup>.<br>
					Jet de <i>SF</i> pour éviter un nouveau <i>Travers</i><sup>(4)</sup>.<br>
					<b>Perte de 2 PdE + 1d PdF</b> -->
				</td>
			</tr>
			<tr>
				<td>IV</td>
				<td>
					<b>Choc grave, panique totale ou évanouis&shy;sement.</b> Éventuellement réaction inconvenante* et nouveau <i>Travers</i>*. Perte PdF, PdE et PdV.
					<!-- Jet de <i>SF</i>&nbsp;: ✅ <b>choc</b> grave<sup>(1)</sup> ou ❌ voir ligne suivante.<br>
					Jet de <i>SF</i> si le 1<sup>er</sup> est raté&nbsp;: <b>panique</b> totale<sup>(2)</sup> / <b>évanouissement</b><sup>(5)</sup>.<br>
					Jet de <i>SF</i> -3 pour éviter une réaction inconvenante<sup>(3)</sup>.<br>
					Jet de <i>SF</i> -3 pour éviter un nouveau <i>Travers</i><sup>(4)</sup>.<br>
					<b>Perte de 3 PdE + 1d PdF + 1 PdV</b> -->
				</td>
			</tr>
			<tr>
				<td>V</td>
				<td>
					<b>Catatonie ou évanouissement long.</b> Éventuellement attaque cardiaque légère, nouveau <i>Travers</i>* et séquelles physiques*. Perte PdF, PdE et PdV.
					<!-- Jet de <i>SF</i>&nbsp;: ✅ <b>catatonie</b><sup>(6)</sup> ou ❌ <b>évanouissement</b> long<sup>(5)</sup>.<br>
					Jet de <i>San</i> pour éviter une attaque cardiaque légère<sup>(7)</sup>.<br>
					Jet de <i>SF</i> -3 pour éviter un nouveau <i>Travers</i><sup>(4)</sup>.<br>
					Jet de <i>SF</i> pour éviter des séquelles physiques<sup>(8)</sup>.<br>
					<b>4 PdE + 1d PdF + 2 PdV</b> -->
				</td>
			</tr>
			<tr>
				<td>–</td>
				<td>
					<b>Catatonie longue ou coma.</b> Éventuellement attaque cardiaque, nouveau <i>Travers</i>* et séquelles physiques*. Perte PdF, PdE et PdV.
					<!-- Jet de <i>SF</i>&nbsp;: ✅ <b>catatonie</b> longue<sup>(6)</sup> ou ❌ <b>coma</b><sup>(9)</sup>.<br>
					Jet de <i>San</i> pour éviter une attaque cardiaque<sup>(7)</sup>.<br>
					Jet de <i>SF</i> -3 pour éviter un nouveau <i>Travers</i><sup>(4)</sup>.<br>
					Jet de <i>SF</i> -1 pour éviter des séquelles physiques<sup>(8)</sup>.<br>
					<b>5 PdE + 2d PdF + 1d PdV</b> -->
				</td>
			</tr>
			<tr>
				<td>–</td>
				<td>
					<b>Catatonie très longue ou coma long.</b> Éventuellement attaque cardiaque, nouveau <i>Travers</i>*, séquelles physiques* et perte d’<i>Int</i> définitive. Perte PdF, PdE et PdV.
					<!-- Jet de <i>SF</i>&nbsp;: ✅ <b>catatonie</b> très longue<sup>(6)</sup> ou ❌ <b>coma</b> long<sup>(9)</sup>.<br>
					Jet de <i>San</i> -3 pour éviter une attaque cardiaque<sup>(7)</sup>.<br>
					Jet de <i>SF</i> -3 pour éviter un nouveau <i>Travers</i><sup>(4)</sup>.<br>
					Jet de <i>SF</i> -3 pour éviter des séquelles physiques<sup>(8)</sup>.<br>
					Jet de <i>SF</i> pour éviter la perte définitive d’un pt d’<i>Int</i>.<br>
					<b>6 PdE + 2d PdF + 2d PdV</b> -->
				</td>
			</tr>
		</table>

		<h4>Précision sur certains éléments</h4>
		<ul class="flow">
			<li><b>Sonné&nbsp;:</b> une claque peut permettre au personnage de reprendre ses esprits (nouveau jet de <i>Sang-Froid</i>)</li>
			<li><b>Réaction inconvenante&nbsp;:</b> lacher ce qu’on a en main (et qu’il ne fallait pas lacher&nbsp;!), vomir, se faire pipi dessus (voir pire&hellip;).</li>
			<li><b>Nouveau <i>Travers</i></b>&nbsp;: si le personnage passe sous en seuil de PdE provoquant un <i>Désavantage mental</i> temporaire, alors le personnage n’hérite pas d’un nouveau travers, mais le <i>Désavantage mental</i> sera permanent.</li>
			<li><b>Séquelles physique&nbsp;:</b> vieillissement, blanchiment des cheveux, mutisme, bégaiement&hellip; au choix du MJ.</li>
		</ul>

		<h4>Peur causée par des sorts</h4>
		<p>Si un sort oblige sa cible à réaliser un <i>Test de Frayeur</i> (par exemple <i>Terreur</i> ou <i>Vision de mort</i>), les éventuels PdE perdus par la victime à cause du sort sont récupérés quelques minutes après la fin du sort. De tels sorts ne peuvent jamais entraîner de perte définitive de PdE, de <i>Sang-Froid</i> ou de <i>Volonté</i>. L’intensité de la peur est égale au niveau du sort.</p>
		<p>Le <i>Test de Frayeur</i> se fait avec un malus correspondant à la MR du sort.</p>


	</details>

	<!-- Stress -->
	<details>
		<summary>
			<h3>Stress</h3>
		</summary>
		<p>Une situation de stress se présente lorsque le personnage craint pour sa vie (à tort ou à raison).</p>
		<p>Dans une telle situation, faire un jet de <i>Sang-froid</i> pour déterminer comment le personnage réagit au stress, assorti d’un éventuel malus.</p>
		<p>
			Si ce jet est raté, le personnage gagne un niveau de stress.<br>
			Si ME &ge; 3, le personnage gagne deux niveaux de stress.<br>
			Si ME &ge; 5, le personnage gagne trois niveaux de stress. Les conséquences du stress sont décrites ci-dessous.
		</p>

		<h4>Niveaux de stress</h4>
		<p>
			<?php foreach (array_slice(StressController::levels, 1) as $index => $level) { ?>
				<b><?= $index + 1 ?>. <?= $level["name"] ?>&nbsp;:</b> <?= $level["description"] ?><br>
			<?php } ?>
		</p>

		<h4>Stress et fatigue</h4>
		<p>Les malus de fatigue sont ignorés si le personnage est en état de stress (quel que soit le niveau de stress).</p>

		<h4>Récupérer du stress</h4>
		<p>• Après disparition de la cause du stress&nbsp;: si la cause du stress a disparu, le personnage récupère d’un niveau de stress toutes les 10 minutes, jusqu’à revenir à son état normal.</p>
		<p>• En situation de stress&nbsp;: si le personnage fait des efforts pour contrôler son stress, il peut refaire un jet de <i>Sang-Froid</i> avec les mêmes malus, à intervalles réguliers, pour perdre un niveau de stress.</p>
	</details>

	<!-- Santé mentale -->
	<details>
		<summary>
			<h3>Santé mentale</h3>
		</summary>

		<table class="left-2 mt-1">
			<tr>
				<th style="width: 20%">PdE</th>
				<th>Effets</th>
			</tr>
			<?php foreach (array_reverse(MentalHealthController::levels) as $index => $level) { ?>
				<tr>
					<td><?= $index !== 0 ? ("&le; " . ((float) $index) * 100 . "&nbsp;%") : "0" ?></td>
					<td class="ta-justify">
						<?= ucfirst($level["description"]) ?><br>
						<?= ucfirst($level["attributes-effects"]) ?>
					</td>
				</tr>
			<?php } ?>
		</table>

		<h4>Perte définitive de PdE et de Sang-Froid</h4>
		<p>Lorsqu’un PdE est perdu définitivement, il faut retirer un pt aux PdEm <i>et</i> aux PdE actuels.</p>
		<p>Cette perte est cumulative. Autrement dit, un personnage passant de 60&nbsp;% à 20&nbsp;% de ses PdEm perdra définitivement 2 PdE et un pt de <i>Sang-froid</i>.</p>

	</details>

	<!-- Récupération des PdE -->
	<details>
		<summary>
			<h3>Récupération des PdE</h3>
		</summary>
		<p>Les PdE se récupèrent à raison de 1 par semaine, dans un endroit calme, et rassurant, en compagnie de gens mentalement sains et amicaux, à mener des activités ordinaires. Il est également possible de récupérer 1 ou 2 PdE si le personnage obtient une victoire sur ce qui a été la cause de sa perte de PdE (décision du MJ).</p>
		<p>Un personnage peut racheter des PdE perdus définitivement en prenant un nouveau désavantage mental, en lien avec ce qui a causé la perte de PdE.</p>
	</details>

</article>

<!-- Jet de réaction -->
<article>
	<h2>Jet de réaction</h2>

	<details>
		<summary>
			<h3>Introduction</h3>
		</summary>
		<p>La réaction d’un PNJ <i>peut</i> être déterminée aléatoirement par un <i>Jet de Réaction</i> (JR) avec 1d.</p>
	</details>

	<details>
		<summary>
			<h3>Modificateurs aux jets de réaction</h3>
		</summary>
		<p><b>Modificateurs liés au PJ :</b> avantages et désavantages ayant un impact sur les JR, ainsi que son comportement.</p>
		<p><b>A priori, caractère, culture et humeur du PNJ</b>, qui peuvent impliquer un modificateur de -2 à +2 aux JR, ou qui peuvent annuler des modificateurs aux JR du PJ, si le PNJ n’est pas sensible à une <i>Disgrâce sociale</i>, par exemple.</p>
	</details>

	<details>
		<summary>
			<h3>Résultat du jet de réaction</h3>
		</summary>
		<table class="left-2">
			<?php foreach (ReactionController::reactions as $index => $reaction) { ?>
				<tr>
					<td width="15%"><?= $index >= 11 ? "&ge;" : "&le;" ?>&nbsp;<?= $index ?></td>
					<td><?= $reaction ?></td>
				</tr>
			<?php } ?>
		</table>
	</details>

	<details>
		<summary>
			<h3>Utilisation d’une compétence sociale</h3>
		</summary>
		<p>L’utilisation d’une compétence sociale appropriée, lorsque cela est possible (discrétion du MJ) peut modifier le résultat du jet de réaction&nbsp;:</p>
		<ul>
			<li>Une réussite améliorera la réaction d’un niveau.</li>
			<li>Un échec dégradera la réaction d’un niveau.</li>
		</ul>
	</details>

</article>

<!-- Règles de diverses -->
<article>
	<h2>Règles diverses</h2>

	<details>
		<summary>
			<h3>Vieillissement</h3>
		</summary>
		<p>À partir de 50 ans, faire un jet de <i>San</i> + NT médical–3 tous les ans. À partir de 70 ans, jetez les dés tous les 6 mois et à 90 ans, tous les 3 mois.<br>
			Un échec entraîne la perte d’un pt de San et des conséquences (maladies ou autres) dépendant de la ME et du MJ.</p>
	</details>

	<details>
		<summary>
			<h3>Statuts sociaux</h3>
		</summary>
		<p>Exemples d’échelles de statuts sociaux.</p>
		<table>
			<tr>
				<th></th>
				<th>Univers médiéval</th>
				<th>Univers contemporain</th>
			</tr>
			<tr>
				<td>8</td>
				<td>Souverain divin</td>
				<td>Pas d’équivalent</td>
			</tr>
			<tr>
				<td>7</td>
				<td>Roi, pape</td>
				<td>Président</td>
			</tr>
			<tr>
				<td>6</td>
				<td>Prince, duc, archevêque</td>
				<td>Gouverneur, sénateur</td>
			</tr>
			<tr>
				<td>5</td>
				<td>Comte, évêque</td>
				<td>Grand PDG</td>
			</tr>
			<tr>
				<td>4</td>
				<td>Baron, aristocrate terrien</td>
				<td>Mondain</td>
			</tr>
			<tr>
				<td>3</td>
				<td>Petit aristocrate</td>
				<td>Maire d’une grande ville</td>
			</tr>
			<tr>
				<td>2</td>
				<td>Chevalier, bourgeois</td>
				<td>Maire</td>
			</tr>
			<tr>
				<td>1</td>
				<td>Petit bourgeois</td>
				<td>Médecin, membre du conseil municipal</td>
			</tr>
			<tr>
				<td>0</td>
				<td>Homme libre</td>
				<td>Citoyen ordinaire</td>
			</tr>
			<tr>
				<td>-1</td>
				<td>Valet ou domestique</td>
				<td>Pauvre</td>
			</tr>
			<tr>
				<td>-2</td>
				<td>Pauvre</td>
				<td>Mendiant</td>
			</tr>
			<tr>
				<td>-3</td>
				<td>Serf ou Mendiant</td>
				<td>Pas d’équivalent</td>
			</tr>
			<tr>
				<td>-4</td>
				<td>Esclave</td>
				<td>Pas d’équivalent</td>
			</tr>
		</table>
	</details>

	<details>
		<summary>
			<h3>Niveaux technologiques</h3>
		</summary>
		<table class="left-2">
			<tr>
				<th colspan="2">Niveaux technologiques et époque correspondante</th>
			</tr>
			<tr>
				<td>0</td>
				<td>Âge de la pierre (feu, levier, langage)</td>
			</tr>
			<tr>
				<td>1</td>
				<td>Âge du bronze</td>
			</tr>
			<tr>
				<td>2</td>
				<td>Âge du fer (-1200 – 600)</td>
			</tr>
			<tr>
				<td>3</td>
				<td>Moyen âge (600 – 1450)</td>
			</tr>
			<tr>
				<td>4</td>
				<td>Renaissance (1450 – 1730)</td>
			</tr>
			<tr>
				<td>5</td>
				<td>Révolution industrielle (1730 – 1880)</td>
			</tr>
			<tr>
				<td>6</td>
				<td>Ère mécanique (1880 – 1950)</td>
			</tr>
			<tr>
				<td>7</td>
				<td>Ère nucléaire (1950 – 2000)</td>
			</tr>
			<tr>
				<td>8</td>
				<td>Ère numérique (2000 – ?)</td>
			</tr>
			<tr>
				<td>9</td>
				<td>Futur proche (prothèses cybernétiques)</td>
			</tr>
			<tr>
				<td>10</td>
				<td>Futur moyen (voyages interplanétaires)</td>
			</tr>
		</table>
	</details>

	<details>
		<summary>
			<h3>Probabilité avec 3d</h3>
		</summary>
		<table>
			<tr>
				<th width="10%">3d</th>
				<th>cumulée</th>
				<th>exacte</th>
				<th width="10%">3d</th>
				<th>cumulée</th>
				<th>exacte</th>
			</tr>
			<tr>
				<td>3</td>
				<td>0,5%</td>
				<td>0,5%</td>
				<td>11</td>
				<td>62,5%</td>
				<td>12,5%</td>
			</tr>
			<tr>
				<td>4</td>
				<td>1,9%</td>
				<td>1,4%</td>
				<td>12</td>
				<td>74,1%</td>
				<td>11,6%</td>
			</tr>
			<tr>
				<td>5</td>
				<td>4,6%</td>
				<td>2,7%</td>
				<td>13</td>
				<td>83,8%</td>
				<td>9,7%</td>
			</tr>
			<tr>
				<td>6</td>
				<td>9,3%</td>
				<td>4,7%</td>
				<td>14</td>
				<td>90,7%</td>
				<td>6,9%</td>
			</tr>
			<tr>
				<td>7</td>
				<td>16,2%</td>
				<td>6,9%</td>
				<td>15</td>
				<td>95,4%</td>
				<td>4,7%</td>
			</tr>
			<tr>
				<td>8</td>
				<td>25,9%</td>
				<td>9,7%</td>
				<td>16</td>
				<td>98,1%</td>
				<td>2,7%</td>
			</tr>
			<tr>
				<td>9</td>
				<td>37,5%</td>
				<td>11,6%</td>
				<td>17</td>
				<td>99,5%</td>
				<td>1,4%</td>
			</tr>
			<tr>
				<td>10</td>
				<td>50%</td>
				<td>12,5%</td>
				<td>18</td>
				<td>100%</td>
				<td>0,5%</td>
			</tr>
		</table>
	</details>

</article>