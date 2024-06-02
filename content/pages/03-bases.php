<?php

use App\Rules\StressController;
use App\Rules\FatigueController;
use App\Rules\EncumbranceController;
use App\Rules\MentalHealthController;

?>

<article> <!-- Intro -->
	<p>Il y a principalement 2 types de jets à SLURP. Tous se font avec des d6.</p>
	<ul>
		<li>Les <b>jets des réussite</b>, avec 3d6, visant à tester une compétence ou une caractéristique. Le jet est réussi s'il est inférieur ou égal au score, ajusté par certains modificateurs.</li>
		<li>Les <b>jets de dégâts</b>, avec un nombre variable de d6.</li>
	</ul>
	<p>Pour les jets de dégâts inférieurs à 1d-1, utiliser les correspondances suivantes&nbsp;: 1d-2 → 1d5-1, 1d-3 → 1d4-1, 1d-4 → 1d3-1, 1d-5 → 1d2-1</p>
</article>

<article><!-- Jet de réussite -->
	<h2>Jet de réussite</h2>

	<details>
		<summary class="h3">Principes de base</summary>
		<p class="ta-center mt-1"><b>Jet (3d) &le; score ± modificateurs</b></p>
		<p class="mt-1">3 et 4 sont toujours une réussite, 17 et 18 sont toujours des échecs.</p>
		<p>Le <b>score brut</b> est le score sans aucun modificateur. Le <b>score net</b> est le score après application des différents modificateurs ci-dessous.</p>
	</details>

	<details>
		<summary class="h3">Difficulté</summary>
		<p>Difficulté intrinsèque de l’action, sans tenir compte de l’état du personnage.</p>
		<table class="alternate-e left-1">
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

	<details>
		<summary class="h3">Autres modificateurs</summary>
		<ul>
			<li><b>État du personnage :</b> PdV, PdF, encombrement, etc.</li>
			<li><b>Matériel utilisé</b> pour entreprendre l’action.</li>
			<li><b>Environnement :</b> obscurité, sol instable, etc.</li>
			<li><b>Main dextre / main «&nbsp;faible&nbsp;» :</b> effectuer une action avec sa main «&nbsp;faible&nbsp;» qui nécessiterait l’usage de la main dextre se fait généralement à -3.</li>
		</ul>
	</detailS>

	<details>
		<summary class="h3">Marge de réussite</summary>
		<p>Le MJ interprète librement la marge de réussite (MR), ou la marge d’échec (ME).</p>
	</details>

	<details>
		<summary class="h3">Réussite et échec critiques</summary>
		<table class="alternate-e">
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

	<details>
		<summary class="h3">Duel</summary>
		<p>Comparer la MR des deux opposants. La victoire d’un des protagonistes est d’autant plus nette que la différence des MR (&Delta;MR) est grande. L'égalité bénéficie au défenseur</p>
	</details>

	<details>
		<summary class="h3">Jets de probabilité</summary>
		<p>Lorsque il faut faire un jet sous «&nbsp;rien&nbsp;», consulter la table ci-dessous.</p>

		<table class="alternate-e left-1">
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

<article><!-- Exploits physiques -->
	<h2>Exploits physiques</h2>

	<details>
		<summary class="h3">Déplacement</summary>
		<p>La caractéristique secondaire <i>Vitesse</i> indique la <b>vitesse de marche</b> (en km/h) du personnage lorsque celui-ci adopte une marche rapide pour un temps long (en voyage ou en randonnée, par exemple).</p>
		<p>Lorsque le personnage veut faire un <b>sprint</b>, la <i>Vitesse</i> correspond à sa vitesse en m/s dans des conditions optimales.<br />
			Ajouter 1/8<sup>e</sup> de la compétence <i>Course</i> (arrondi au quart de point).</p>
		<p>La <i>Fatigue</i>, l’<i>Encombrement</i> et le niveau de blessures influent sur la <i>Vitesse</i>. L’<i>Encombrement</i> compte double en cas de sprint.</p>
	</details>

	<details>
		<summary class="h3">Saut</summary>
		<p>Pour réussir à sauter suffisamment loin ou haut, jet de <i>Saut</i>. Les malus d’<i>Encombrement</i> sont doublés.</p>
	</details>

	<details>
		<summary class="h3">Soulever et déplacer des objets</summary>
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
		<summary class="h3">Nage</summary>
		<p>En cas d’échec à un jet de <i>Nage</i>, perte de 1 PdF. Refaire un jet toutes les 5 secondes, jusqu’à ce qu’il y ait noyade, sauvetage ou un jet de <i>Nage</i> réussi.</p>
		<p><i>Encombrement</i> : dépend de la densité de l’équipement.</p>
		<p>Vitesse de nage : 1/10<sup>e</sup> de la compétence en <i>Nage</i> en sprint.</p>
		<p><b>Combat dans l’eau :</b> jets de <i>Nage</i> régulièrement si le personnage n’a pas pied. Perte rapide de PdF. Les dégâts sont réduits de moitié en immersion.</p>
	</details>

	<details>
		<summary class="h3">Retenir sa respiration</summary>
		<ul>
			<li><b>Au repos :</b> <i>San</i>×6 secondes.</li>
			<li><b>Activité physique modérée :</b> <i>San</i>×2 secondes.</li>
			<li><b>Exercice physique important :</b> <i>San</i> secondes.</li>
		</ul>
		<p><b>Modificateurs :</b> ×2 si hyperoxygénation ; ×½ si surprise et pas de préparation.</p>
		<p><i>Contrôle du souffle</i> peut se substituer à la <i>San</i> pour le calcul de la durée de l’apnée. Une fois à bout de souffle, voir <i>Suffocation</i> (chapitre <i>Blessures &amp; Dangers</i>).</p>
	</details>

</article>

<article><!-- Encombrement -->
	<h2>Encombrement</h2>

	<details>
		<summary class="h3">Principes de base</summary>
		<p>L’<i>Encombrement</i> dépend du poids porté par le personnage et de sa <i>For</i>. Il réduit la <i>Vitesse</i> et affecte également toutes les compétences nécessitant une certaine liberté de mouvement.</p>
	</details>

	<details>
		<summary class="h3">Niveaux d’encombrement</summary>
		<table class="alternate-e left-2 mt-1">
			<tr>
				<th>Poids (kg)</th>
				<th>Encombrement et malus</th>
			</tr>
			<?php foreach (EncumbranceController::levels as $index => $level) { ?>
				<tr>
					<td>&le; For ×<?= $index ?></td>
					<td><?= ucfirst($level["description"]) ?></td>
				</tr>
			<?php } ?>
		</table>
		<p>Le malus est doublé pour les compétences pour lesquelles il est indispensable d’être léger (<i>Course</i>, <i>Saut</i>, <i>Acrobatie</i>, <i>Esquive</i>&hellip;)</p>
	</details>
</article>

<article><!-- Fatigue -->
	<h2>Fatigue</h2>

	<details>
		<summary class="h3">Perte de points de Fatigue</summary>
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

	<details>
		<summary class="h3">État de fatigue et malus</summary>

		<p>
			La fatigue affecte toutes les caractéristiques du personnage.<br />
			Cela a un impact sur les caractéristiques secondaires (sauf les PdV et les PdF) et tous les jets de réussite.
		</p>

		<table class="alternate-e left-2 mt-1">
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

	<details>
		<summary class="h3">Récupération</summary>
		<p>Le MJ décide du rythme de récupération en fonction des conditions de repos et du type d’effort fourni (peu intense et de longue durée, ou l’invers). La seule règle est que l’on est « frais et dispo » qu’après une nuit de sommeil.</p>
		<p><b>Règle de coin de table&nbsp;:</b> en se reposant après un effort, on peut récupérer au maximum un quart des PdF dépensés.</p>
		<p>Des PdF perdus par un manque de nourriture ou d’eau ne peuvent être regagnés qu’en mangeant ou en s’hydratant.</p>
		<p>Ne tenir compte des PdF que si cela est important dans le jeu. Dans la plupart des situations, les PdF n’ont aucune importance.</p>
	</details>

</article>

<article><!-- Équilibre psychique -->
	<h2>Équilibre psychique</h2>

	<details>
		<summary class="h3">Points d’Équilibre Psychique</summary>
		<p>L’équilibre psychique d’un personnage est quantifié par les <i>Points d’Équilibre Psychique</i> (PdE).</p>
	</details>

	<details>
		<summary class="h3">Jet de Sang-Froid et PdE</summary>
		<p>Des PdE peuvent être perdus au cours de trois types de situations&nbsp;: un traumatisme, une peur extrême ou un stress intense.</p>
		<p>Lorsque plusieurs effets peuvent advenir (traumatisant et stressant, par exemple), un seul jet de <i>Sang-Froid</i> est à faire. Les conséquences sont déterminées à partir de cet unique jet.</p>
	</details>

	<details>
		<summary class="h3">Traumatisme</summary>
		<p>Un événement traumatisant provoque un choc psychologique. Il n’est pas nécessairement effrayant ni directement menaçant (perte d’un être cher, être témoin d’actes de barbarie, etc.).</p>
		<p>Il peut entraîner la perte de PdE : faire un jet de <i>Sang-froid</i> pour résister au traumatisme. En cas de réussite, la perte de PdE est divisée par 2. Ce jet de <i>Sang-froid</i> peut être assorti d’un modificateur, mais ce modificateur ne dépendra, en général, pas de l’ampleur du traumatisme, qui est quantifié par la perte de PdE, mais de l’état ou du vécu du personnage.</p>

		<table class="alternate-e left-1">
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

	<details>
		<summary class="h3">Terreur</summary>
		<p>Lorsqu’un événement terrifie le personnage, un jet de <i>Sang-froid</i> (appelé dans ce cas <i>Test de Frayeur</i>) doit être fait pour savoir comment le personnage réagit. Cette terreur doit être surnaturelle ou réveiller une phobie, et ponctuelle, sans quoi il s’agit d’un stress ou d’une <i>Surprise</i>.</p>
		<p>Un malus peut s’appliquer en fonction de la nature de l’événement terrorisant.</p>
		<p>Si le jet de <i>Sang-froid</i> est réussi, le personnage surmonte sa peur et peut agir immédiatement. Sinon, il subit les conséquences décrites dans le tableau ci-dessous.
			La ME d’un jet de <i>Sang-froid</i> pour résister à la terreur ne peut être supérieure à [malus du test +3], sauf en cas d’échec critique (exemple : rater un jet de Sang-froid à -2 ne peut entraîner une ME de plus de 2+3 = 5).</p>
		<table class="alternate-e left-2">
			<tr>
				<th width="10">ME</th>
				<th>Conséquences</th>
			</tr>
			<tr>
				<td>1</td>
				<td>Surprise partielle.</td>
			</tr>
			<tr>
				<td>2</td>
				<td>Surprise totale. Jet de Vol pour retenir un cri.</td>
			</tr>
			<tr>
				<td>3</td>
				<td>Surprise totale. Vol -3 pour retenir un cri. <b>(1 PdE)</b></td>
			</tr>
			<tr>
				<td>4</td>
				<td>Panique. Le personnage s’enfuit en hurlant pendant 1d×10 secondes. S’il ne peut pas s’enfuir, faire un jet de San pour éviter une réaction physique inconvenante (vomir, uriner, pleurer, etc.). <b>(2 PdE)</b></td>
			</tr>
			<tr>
				<td>5</td>
				<td>Panique totale. Le personnage est capable de faire n’importe quoi (jeter 3d, plus le résultat est élevé, plus l’action entreprise est inutile, voire dangereuse). <b>(3 PdE)</b>.</td>
			</tr>
			<tr>
				<td>6</td>
				<td>Le personnage est en état de choc. Il ne fait rien durant 1d×5 secondes, puis entre en panique totale (résultat précédent). <b>(4 PdE)</b>.</td>
			</tr>
			<tr>
				<td>7</td>
				<td>Jet de San pour ne pas s’évanouir pendant 1d minutes. Voir résultat précédent si le jet de San est réussi. <b>(5 PdE)</b>.</td>
			</tr>
		</table>
	</details>

	<details>
		<summary class="h3">Stress</summary>
		<p>Une situation de stress se présente lorsque le personnage craint pour sa vie (à tort ou à raison).</p>
		<p>Dans une telle situation, faire un jet de <i>Sang-froid</i> pour déterminer comment le personnage réagit au stress, assorti d’un éventuel malus.</p>
		<p>Si ce jet est raté, le personnage gagne un niveau de stress.<br />
			Si ME &ge; 3, le personnage gagne deux niveaux de stress.<br />
			Si ME &ge; 5, le personnage gagne trois niveaux de stress. Les conséquences du stress sont décrites ci-dessous.</p>

		<h4>Niveaux de stress</h4>
		<p>
			<?php foreach (array_slice(StressController::levels, 1) as $index => $level) { ?>
				<b><?= $index + 1 ?>. <?= $level["name"] ?>&nbsp;:</b> <?= $level["description"] ?><br>
			<?php } ?>
		</p>

		<p>Les PdV et PdF ne sont pas affectés par le niveau de stress.</p>

		<h4>Stress et fatigue</h4>
		Les malus de fatigue sont ignorés si le personnage est en état de stress (quel que soit le niveau de stress).
		</p>

		<h4>Récupérer du stress</h4>
		<p>• Après disparition de la cause du stress&nbsp;: si la cause du stress a disparu, le personnage récupère d’un niveau de stress toutes les 10 minutes, jusqu’à revenir à son état normal.</p>
		<p>• En situation de stress&nbsp;: si le personnage fait des efforts pour contrôler son stress, il peut refaire un jet de <i>Sang-Froid</i> avec les mêmes malus, à intervalles réguliers, pour perdre un niveau de stress.</p>
	</details>

	<details>
		<summary class="h3">État psychologique général</summary>

		<!-- <p class="mt-1">Les seuils d’état psychologique sont basés sur des valeurs absolues de PdE, et non des valeurs en pourcentage des PdE max. Si les PdE max d’un personnage sont en dessous d’un des seuils, il n’est pas concerné par les effets de ce seuil (sauf pour le déavantage mental qui reste acquis)</p> -->

		<table class="alternate-e left-2 mt-1">
			<tr>
				<th style="width: 20%">PdE</th>
				<th>Effets</th>
			</tr>
			<?php foreach (array_reverse(MentalHealthController::levels) as $index => $level) { ?>
				<tr>
					<!-- <td></td> $index !== 0 ? ("&le; " . (int) $index) : "0" -->
					<td><?= $index !== 0 ? ("&le; " . ((float) $index) * 100 . "&nbsp;%") : "0" ?></td>
					<td><?= ucfirst($level["description"]) ?></td>
				</tr>
			<?php } ?>
		</table>

		<h4>Perte définitive de PdE et de Sang-Froid</h4>
		<!-- <p>
			Cette perte s’applique la première fois que le personnage passe sous le seuil provoquant cette perte. Il ne perdra plus de points en franchissant ce seuil avant d’être remonté deux seuils au-dessus ou à son maximum (premier événement à arriver).
		</p>
		<div class="exemple">
			Soit un personnage avec 10 PdE au maximum. Il descend à 5 PdE, il perd définitivement 1 PdE. Il continue à descendre et arrive à 2 PdE. Il perd alors un autre PdE et un pt de <i>Sang-froid</i>. Puis il remonte à 4 PdE et redescend à 2 PdE. Aucune perte définitive dans ce cas, car le personnage n’est remonté que d’un seuil et pas de deux.<br>
			Il remonte ensuite de 2 PdE à 6 PdE. Puis redescend à 2 PdE. Il ne subit aucune perte pour le passage par 5 PdE, mais il subira la perte du passage à 2 PdE.
		</div> -->
		<p>Lorsqu’un PdE est perdu définitivement, il faut retirer un pt aux PdEm <i>et</i> aux PdE actuels.</p>
		<p>Cette perte est cumulative. Autrement dit, un personnage passant de 6 PdE à 2 PdE perdra définitivement 2 PdE et un pt de <i>Sang-froid</i>.</p>

	</details>

	<details>
		<summary class="h3">Récupération des PdE</summary>
		<p>Les PdE se récupèrent à raison de 1 par semaine, dans un endroit calme, et rassurant, en compagnie de gens mentalement sains et amicaux, à mener des activités ordinaires. Il est également possible de récupérer 1 ou 2 PdE si le personnage obtient une victoire sur ce qui a été la cause de sa perte de PdE (décision du MJ).</p>
		<p>Un personnage peut racheter des PdE perdus définitivement en prenant un nouveau désavantage mental, en lien avec ce qui a causé la perte de PdE.</p>
	</details>
</article>

<article><!-- Jet de réaction -->
	<h2>Jet de réaction</h2>

	<details>
		<summary class="h3">Introduction</summary>
		<p>La réaction d’un PNJ <i>peut</i> être déterminée aléatoirement par un <i>Jet de Réaction</i> (JR) avec 1d.</p>
	</details>

	<details>
		<summary class="h3">Modificateurs aux jets de réaction</summary>
		<p><b>Modificateurs liés au PJ :</b> avantages et désavantages ayant un impact sur les JR, ainsi que son comportement.</p>
		<p><b>A priori, caractère, culture et humeur du PNJ</b>, qui peuvent impliquer un modificateur de -2 à +2 aux JR, ou qui peuvent annuler des modificateurs aux JR du PJ, si le PNJ n’est pas sensible à une <i>Disgrâce sociale</i>, par exemple.</p>
	</details>

	<details>
		<summary class="h3">Résultat du jet de réaction</summary>
		<table class="alternate-e left-2">
			<tr>
				<td width="15%">&le;-4</td>
				<td><b>Désastreuse.</b> Le PNJ déteste le personnage et fera tout ce qui est en son pouvoir pour lui nuire.</td>
			</tr>
			<tr>
				<td>-3 à -2</td>
				<td><b>Très mauvaise.</b> Le PNJ n’apprécie pas le personnage et le desservira si c’est possible et profitable.</td>
			</tr>
			<tr>
				<td>-1 à 0</td>
				<td><b>Mauvaise.</b> Le PNJ se fiche éperdument des joueurs et leur mettra des bâtons dans les roues si cela peut lui être profitable.</td>
			</tr>
			<tr>
				<td>1 à 2</td>
				<td><b>Médiocre.</b> Le PNJ n’est pas impressionné le moins du monde. Il ne sera ni agréable ni serviable.</td>
			</tr>
			<tr>
				<td>3 à 4</td>
				<td><b>Neutre.</b> Le PNJ se comportera selon les normes sociales en vigueur.</td>
			</tr>
			<tr>
				<td>5 à 6</td>
				<td><b>Assez bonne.</b> Le PNJ sera plutôt agréable et relativement serviable si cela ne lui coûte rien.</td>
			</tr>
			<tr>
				<td>7 à 8</td>
				<td><b>Bonne.</b> Le PNJ se montre accueillant avec le personnage et s’efforcera de lui être utile dans les limites du raisonnable.</td>
			</tr>
			<tr>
				<td>9 à 10</td>
				<td><b>Très bonne.</b> Le PNJ ne pense que du bien du personnage, il sera très amical et peu avare de ses services.</td>
			</tr>
			<tr>
				<td>11+</td>
				<td><b>Excellente.</b> Le PNJ est impressionné par le personnage et agira dans son intérêt à tous les instants dans les limites de ses propres capacités.</td>
			</tr>
		</table>
	</details>

	<details>
		<summary class="h3">Utilisation d’une compétence sociale</summary>
		<p>L’utilisation d’une compétence sociale appropriée, lorsque cela est possible (discrétion du MJ) peut modifier le résultat du jet de réaction&nbsp;:</p>
		<ul>
			<li>Une réussite améliorera la réaction d’un niveau.</li>
			<li>Un échec dégradera la réaction d’un niveau.</li>
		</ul>
	</details>

</article>

<article><!-- Règles de diverses -->
	<h2>Règles diverses</h2>

	<details>
		<summary class="h3">Vieillissement</summary>
		<p>À partir de 50 ans, faire un jet de <i>San</i> + NT médical–3 tous les ans. À partir de 70 ans, jetez les dés tous les 6 mois et à 90 ans, tous les 3 mois.<br />
			Un échec entraîne la perte d’un pt de San et des conséquences (maladies ou autres) dépendant de la ME et du MJ.</p>
	</details>

	<details>
		<summary class="h3">Statuts sociaux</summary>
		<p>Exemples d’échelles de statuts sociaux.</p>
		<table class="alternate-e">
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
		<summary class="h3">Niveaux technologiques</summary>
		<table class="alternate-e left-2">
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
		<summary class="h3">Probabilité avec 3d</summary>
		<table class="alternate-e">
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