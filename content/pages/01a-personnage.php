<?php

use App\Entity\Skill;
use App\Entity\Attribute;
use App\Repository\SkillRepository;

$attributes = [
	"For" => new Attribute("For"),
	"Dex" => new Attribute("Dex"),
	"Int" => new Attribute("Int"),
	"San" => new Attribute("San"),
	"Per" => new Attribute("Per"),
	"Vol" => new Attribute("Vol"),
];
$repo = new SkillRepository;
?>

<!-- Caractéristiques -->
<article>
	<h2>Caractéristiques</h2>

	<details>
		<summary>
			<h3>Introduction</h3>
		</summary>
		<p>
			Les 6 <b>caractéristiques principales</b> (<i>Force</i>, <i>Dextérité</i>, <i>Intelligence</i>, <i>Santé</i>, <i>Perception</i> et <i>Volonté</i>) constituent la charpente du personnage. Elles ont un impact sur de nombreux aspects de celui-ci.<br>
			Un score de 10 (médiocre) est gratuit et constitue le score par défaut.
		</p>
		<p>Les <b>caractéristiques secondaires</b> sont calculées à partir des caractéristiques principales et peuvent être modifiées par un <i>Avantage</i> ou un <i>Désavantage</i> adéquat, dans une certaine mesure.</p>
	</details>

	<details>
		<summary>
			<h3>Caractéristiques principales</h3>
		</summary>

		<div class="flex-s">
			<h4 class="fl-1">Force (For)</h4>
			<h4><?= Attribute::cost_for ?></h4>
		</div>
		<p>Puissance musculaire et corpulence.</p>

		<div class="flex-s">
			<h4 class="fl-1">Dextérité (Dex)</h4>
			<h4><?= Attribute::cost_dex ?></h4>
		</div>
		<p>Agilité, adresse, souplesse, rapidité, équilibre, coordination et (partiellement) réflexes.</p>

		<div class="flex-s">
			<h4 class="fl-1">Intelligence (Int)</h4>
			<h4><?= Attribute::cost_int ?></h4>
		</div>
		<p>Facultés d’analyse et de raisonnement, imagination, créativité artistique et scientifique, mémoire, intuition, expérience, potentiel d’énergie magique.</p>

		<div class="flex-s">
			<h4 class="fl-1">Santé (San)</h4>
			<h4><?= Attribute::cost_san ?></h4>
		</div>
		<p>Endurance physique, résistance au poison, aux maladies, aux radiations, aux blessures et vitesse de guérison.</p>

		<div class="flex-s">
			<h4 class="fl-1">Perception (Per)</h4>
			<h4><?= Attribute::cost_per ?></h4>
		</div>
		<p>Moyenne des 5 sens et degré d’attention que l’on y porte.</p>

		<div class="flex-s">
			<h4 class="fl-1">Volonté (Vol)</h4>
			<h4><?= Attribute::cost_vol ?></h4>
		</div>
		<p>Capacité à affronter une situation psychologiquement éprouvante, à surmonter un désavantage mental ou à résister à une tentative d’influence.</p>

		<table>

			<caption>Coût des caractéristiques</caption>

			<tr>
				<th>Score</th>
				<th>For</th>
				<th>Dex</th>
				<th>Int</th>
				<th>San</th>
				<th>Per</th>
				<th>Vol</th>
			</tr>
			<?php for ($i = 6; $i <= 18; $i++) { ?>
				<tr>
					<td><?= $i ?></td>
					<td><?= $attributes["For"]->cost($i) ?></td>
					<td><?= $attributes["Dex"]->cost($i) ?></td>
					<td><?= $attributes["Int"]->cost($i) ?></td>
					<td><?= $attributes["San"]->cost($i) ?></td>
					<td><?= $attributes["Per"]->cost($i) ?></td>
					<td><?= $attributes["Vol"]->cost($i) ?></td>
				</tr>
			<?php } ?>
			<tr>
				<td>+1</td>
				<td>+<?= $attributes["For"]->cost(19) - $attributes["For"]->cost(18) ?></td>
				<td>+<?= $attributes["Dex"]->cost(19) - $attributes["Dex"]->cost(18) ?></td>
				<td>+<?= $attributes["Int"]->cost(19) - $attributes["Int"]->cost(18) ?></td>
				<td>+<?= $attributes["San"]->cost(19) - $attributes["San"]->cost(18) ?></td>
				<td>+<?= $attributes["Per"]->cost(19) - $attributes["Per"]->cost(18) ?></td>
				<td>+<?= $attributes["Vol"]->cost(19) - $attributes["Vol"]->cost(18) ?></td>
			</tr>
		</table>


		<table class="left-2">
			<caption>Signification des scores</caption>
			<tr>
				<th>Score</th>
				<th>Signification</th>
			</tr>
			<tr>
				<th>&le; 7</th>
				<td>Handicap</td>
			</tr>
			<tr>
				<th>8</th>
				<td>Très Faible</td>
			</tr>
			<tr>
				<th>9</th>
				<td>Faible</td>
			</tr>
			<tr>
				<th>10</th>
				<td>Médiocre</td>
			</tr>
			<tr>
				<th>11</th>
				<td>Moyen</td>
			</tr>
			<tr>
				<th>12</th>
				<td>Correct</td>
			</tr>
			<tr>
				<th>13</th>
				<td>Assez bon</td>
			</tr>
			<tr>
				<th>14</th>
				<td>Bon</td>
			</tr>
			<tr>
				<th>15</th>
				<td>Très Bon</td>
			</tr>
			<tr>
				<th>16</th>
				<td>Excellent</td>
			</tr>
		</table>

		<p><b>Améliorer ses caractéristiques</b> après la création coûte le double des points de personnage normalement requis, sauf pour la <i>Force</i> (coût×1,5). Modifier une caractéristique a un impact sur toutes les compétences qui en dépendent.</p>
	</details>

	<details>
		<summary>
			<h3>Caractéristiques secondaires</h3>
		</summary>
		<p>Elles sont basées les caractéristiques principales.</p>

		<h4>Dégâts de base</h4>
		<p>Ils sont basés sur la <i>For</i> et servent à déterminer les dégâts des armes dépendant de la puissance musculaire. Le premier score est l’<i>estoc</i> (<i>e</i>), le deuxième et la <i>taille</i> (<i>t</i>).</p>

		<table>
			<tr>
				<th><i>For</i></th>
				<th>estoc</th>
				<th>taille</th>
			</tr>
			<?php for ($i = 8; $i <= 16; $i++) { ?>
				<tr>
					<td><?= $i ?></td>
					<td><?= Attribute::getDamages($i)["estoc"] ?></td>
					<td><?= Attribute::getDamages($i)["taille"] ?></td>
				</tr>
			<?php } ?>
		</table>

		<p>Pour des valeurs de <i>For</i> en dehors de cette table, utiliser le widget <i>Dégâts et localisation</i> de la <a href="/table-jeu">Table de jeu</a> ou consulter la page <a href="/animaux">Animaux</a> (les valeurs sont les mêmes pour toutes les créatures).</p>

		<div class="flex-s">
			<h4 class="fl-1">Réflexes (Réf)</h4>
			<h4><?= Attribute::reflexes ?></h4>
		</div>
		<p>Capacité à réagir vite. Utilisé notamment pour déterminer l’initiative en combat.</p>

		<div class="flex-s">
			<h4 class="fl-1">Sang-froid (S-F)</h4>
			<h4><?= Attribute::sang_froid ?></h4>
		</div>
		<p>Capacité à ne pas céder à la panique et au stress.</p>

		<div class="flex-s">
			<h4 class="fl-1">Vitesse (Vit)</h4>
			<h4><?= Attribute::vitesse ?></h4>
		</div>
		<p>Vitesse de déplacement, en mètres par seconde. Voir le chapitre <i>Bases du système</i>.</p>

		<div class="flex-s">
			<h4 class="fl-1">Points de vie (PdV)</h4>
			<h4><?= Attribute::pdv ?></h4>
		</div>
		<div>Capacité à encaisser des blessures.</div>

		<div class="flex-s">
			<h4 class="fl-1">Points de fatigue (PdF)</h4>
			<h4><?= Attribute::pdf ?></h4>
		</div>
		<div>Capacité à résister à l’effort, à la privation de sommeil, au manque de nourriture, etc. Voir le chapitre <i>Bases du système</i>.</div>

		<div class="flex-s">
			<h4 class="fl-1">Points de magie (PdM)</h4>
			<h4><?= Attribute::pdm ?></h4>
		</div>
		<div>Réserve d’énergie pour l’utilisation de sorts et de pouvoirs magiques.</div>

		<div class="flex-s">
			<h4 class="fl-1">Points d’équilibre psychique (PdE)</h4>
			<h4><?= Attribute::pde ?></h4>
		</div>
		<div>Mesure de la santé mentale du personnage.</div>

		<h4>Modifier ses caractéristiques secondaires</h4>
		<p>Pour modifier les caractéristiques secondaires indépendamment des caractéristiques principales, voir la liste d’<i>Avantage</i> &amp; <i>Désavantages</i>. Ces modifications doivent rester exceptionnelles et justifiées (sauf pour les PdM dont l’augmentation est encadrée par l’avantage <i>Magerie</i>).</p>
	</details>

</article>

<!-- Avantages & Désavantages -->
<article>
	<h2>Avantages, Désavantages &amp; Travers</h2>

	<details>
		<summary>
			<h3>Introduction</h3>
		</summary>

		<p>Les <i>Avantages</i> et les <i>Désavantages</i> recouvrent tout ce qui ne relève pas d’une caractéristique ou d’une compétence.</p>
		<p>La liste complète avec la description de chaque avantage et désavantage est visible sur la page <a href="avdesav-comp-sorts">Listes pour le personnage</a>.</p>

	</details>

	<details>
		<summary>
			<h3>Règle du 12</h3>
		</summary>

		<h4>Avantage</h4>
		<p>Si un jet sous une caractéristique est nécessaire pour le faire fonctionner, le score de base <i>minimum</i> de cette caractéristique et considéré comme valant 12 (en dehors de modificateurs d’état ou de circonstances).</p>

		<h4>Désavantage</h4>
		<p>Si un jet est nécessaire pour y échapper, le score <i>maximum</i> de ce jet est de 12.</p>

		<details class="exemple">
			<summary>Exemple</summary>
			<p>L’avantage <i>Intuition</i> nécessite un jet d’<i>Int</i> pour fonctionner. Si l’<i>Int</i> du personnage est inférieure à 12, elle est considérée comme valant 12 pour ce jet. Mais si le personnage est blessé ou fatigué, les modificateurs normaux s’appliquent à cette base de 12.</p>
		</details>
	</details>

	<details>
		<summary>
			<h3>Limites de désavantages</h3>
		</summary>
		<p>Un maximum de –40 pts de désavantages est suggéré à la création d’un personnage, sans quoi le personnage peut devenir très contraignant à jouer, ou incohérent.</p>
		<p>Une même contrainte peut parfois être décrite par différents désavantages. En choisir un et un seul pour rendre compte d’une contrainte donnée.</p>
	</details>

	<details>
		<summary>
			<h3>Traits de caractère</h3>
		</summary>
		<p>Les <i>Traits de caractères</i> sont des <i>Désavantages</i> influençant le comportement du personnage, sans effet direct en terme de règles. Le joueur peut d’ailleurs les définir lui-même.</p>
		<p>Pour être plus qu’un simple <i>Travers</i>, un <i>Trait de caractère</i> doit respecter l’une au moins des conditions suivantes :</p>
		<ul>
			<li>Mettre parfois en danger le personnage ;</li>
			<li>Impliquer des dépenses régulières et importantes ;</li>
			<li>Limiter sa liberté d’action ;</li>
			<li>Imposer un malus aux JR au moins dans certaines circonstances.</li>
		</ul>
		<p>Certains <i>Traits de caractère</i> ne peuvent donc, par essence, qu’être des <i>Travers</i> (Modeste, Discret...).</p>

		<h4>Traits de caractère vertueux</h4>
		<p>Les traits de caractères vertueux (<i>Charitable</i>, <i>Honnête</i>, <i>Sens du devoir</i>, <i>Pacifique</i>, <i>Respect de la vérité</i>) constituent un moyen « facile » de gagner des points de personnage si le personnage n’est pas une crapule sans foi ni loi. Pensez-y au moment de sa création.</p>

		<h4>Coût des traits de caractères</h4>
		<p><b>Travers (-1 pt) :</b> tendance légère, qui ne gêne pas le personnage. Compté comme un <i>Travers</i> (voir plus loin) et non comme un <i>Désavantage</i>.</p>

		<p><b>Marqué (-5 pts) :</b> rapidement remarqué par l’entourage du personnage. -1 aux JR, et/ou coûte jusqu’à 10% d’un salaire de base par mois, et/ou limite relativement la liberté d’action et/ou fait parfois prendre des risques.</p>

		<p><b>Fort (-10 pts) :</b> <i>Trait de caractère</i> central du personnage. -2 aux JR, et/ou coûte jusqu’à un salaire moyen par mois, et/ou limite beaucoup la liberté d’action, et/ou fait parfois courir des risques sérieux. -2 pour y résister.</p>

		<p><b>Extrême (-15 pts ou +) :</b> stade pathologique. Mène à terme à la banqueroute et/ou en prison, limite drastiquement la liberté d’action ou fait souvent risquer sa vie. -5 pour y résister. Tous les traits de caractères n’ont pas forcément une version à –15 pts.</p>

		<h4>Limites de Traits de caractères</h4>
		<p>3 <i>Traits de caractère</i> maximum dont un seul allant jusqu’à -10 pts.</p>
	</details>

	<details>
		<summary>
			<h3>Vivre ses désavantages</h3>
		</summary>
		<p>Il y a plusieurs manières possibles de « vivre » ses désavantages mentaux et traits de caractère. Certaines de ces manières permettent d’obtenir des points de personnages supplémentaires.</p>
		<p>• <b>Par défaut (0 pt) :</b> le personnage les assume pleinement (sans pour autant en être fier).</p>
		<p>• <b>C’est normal (0 pt) :</b> les personnes n’en souffrant pas sont considérés comme « anormaux » et traités selon le caractère du personnage.</p>
		<p>• <b>S’efforcer de s’y plier (-5 pts) :</b> s’applique principalement aux désavantages vertueux. Jet de Vol pour s’y conformer. -1 PdE si échec.<br>
			Si, par ce biais, PdE &lt; 50% PdE max, le personnage perd le désavantage et doit le racheter au plus vite (il hérite de <i>Malchance</i> en attendant).</p>
		<p>• <b>Lutter contre eux (-5 pts) :</b> jet de Vol pour ne pas y céder. -1 PdE en cas d’échec.<br>
			Si, par ce biais, PdE &lt; 50% PdE max, le personnage ne cherchera plus à y résister. Le désavantage pourra même s’aggraver.</p>
		<p>• <b>Ne pas en avoir conscience ou les nier (-5 pts) : </b> variante automatique pour certains désavantages mentaux (<i>Chimère</i> par exemple)
			et dans ce cas, elle n’apporte pas de points supplémentaires. </p>
		<p>• <b>Tabou (-5 pts) :</b> interdiction/obligation « sacrée » absolue. Le personnage obéit toujours à ce désavantage. Si c’est impossible (sous la contrainte, par exemple), le personnage perd 1 PdE à chaque fois (max 1 PdE tout les 2 jours).</p>
	</details>

	<details>
		<summary>
			<h3>Après la création du personnage</h3>
		</summary>
		<p>Un personnage peut gagner un <i>Avantage</i> ou hériter d’un <i>Désavantage</i> (ou encore racheter un <i>Désavantage</i>) au cours du jeu par la logique des événements (<i>Richesse</i>, <i>Réputation</i>, mais aussi <i>Borgne</i>, <i>Ennemi</i>, etc.) Dans ce cas, cela ne coûte ni ne rapporte aucun point de personnage.</p>
		<p>Il est également possible d’acquérir un <i>Avantage</i> ou un <i>Désavantage</i> ou de racheter un <i>Désavantage</i> si cela n’est pas incompatible avec la logique de l’<i>Avantage</i>/<i>Désavantage</i> (on ne rachète pas le désavantage <i>Borgne</i>, par exemple, mais on peut racheter une <i>Malchance</i> ou un <i>Trait de caractère</i>).</p>
	</details>

	<details>
		<summary>
			<h3>Travers</h3>
		</summary>
		<p><i>Trait de caractère</i> mineur (-1 pt) ne constituant pas un désavantage. À la création, il est possible de prendre jusqu’à 5 travers.<br>
			Un <i>Travers</i> peut être racheté ou changé, si un événement justifie un léger changement de personnalité.</p>
		<p><b>Quelques catégories de travers :</b> croyance, objectif mineur, goût ou dégoût, habitude, expression, manière particulière de se vêtir, un amour non partagé, des loisirs particuliers, un divertissement préféré, etc.</p>
	</details>

</article>

<!-- Compétences -->
<article>
	<h2>Compétences</h2>

	<!-- Introduction -->
	<details>
		<summary>
			<h3>Introduction</h3>
		</summary>
		<p>Les <i>Compétences</i> sont des connaissances ou des savoir-faire qui peuvent être appris et développés. La plupart d’entre elles possèdent un score <i>par défaut</i>, qui ne coûte rien et qui se calcule d’après les caractéristiques.</p>
		<p>La liste complète avec la description de chaque compétence est visible sur la page <a href="avdesav-comp-sorts">Listes pour le personnage</a>.</p>
	</details>

	<!-- Scores -->
	<details>
		<summary>
			<h3>Scores</h3>
		</summary>

		<p>Chaque compétence est associée à un <i>type</i>, par exemple D-4, DI-2, I(-8)…</p>
		<p>Ce type permet de connaître la <b>base</b> de la compétence (D, DI, I…) et sa <b>difficulté</b> (-2, -4, -6 ou -8).</p>

		<p>La <i>base</i> de la compétence est la moyenne des caractéristiques sur lesquelles elle est basée (ou la valeur de la caractéristique si elle n’est basée que sur une seule caractéristique). Ces caractéristiques sont représentées par leur première lettre : D pour <i>Dex</i>, I pour <i>Int</i>, etc.</p>

		<details class="exemple">
			<summary>Exemple</summary>
			<p>La compétence <i>Bricolage</i> est de type DI-2. Sa base est donc la moyenne de la <i>Dex</i> et de l’<i>Int</i>. Si le personnage a 12 en <i>Dex</i> et 11 en <i>Int</i>, sa base vaudra donc (12+11)÷2 = 11,5, arrondi à 11.</p>
			<p>Sa difficulté est de -2.</p>
		</details>

		<p>Le score d’une compétence dépend :</p>
		<ul>
			<li>de sa base</li>
			<li>de sa difficulté : <i>facile</i> (-2), <i>moyenne</i> (-4), <i>ardue</i> (-6) ou <i>très ardue</i> (-8)</li>
			<li>du nombre de points de personnage investis dedans</li>
		</ul>

		<h4>Score par défaut</h4>
		<p>En l’absence de points investis dans la compétence, son score correspond à la base + la difficulté (qui est un nombre négatif !). Si la difficulté de la compétence est notée entre parenthèses, aucun score par défaut n’est autorisé.</p>

		<details class="exemple">
			<summary>Exemple</summary>
			<p>La compétence <i>Bricolage</i> est de type DI-2. Si le personnage a 12 en <i>Dex</i> et 11 en <i>Int</i>, sa base vaudra donc (12+11)÷2 = 11,5, arrondi à 11.</p>
			<p>Sa difficulté est de -2, donc son score par défaut vaut 11-2 = 9.</p>
		</details>

		<h4>Score et points de personnage</h4>
		<p>La table ci-dessous indique le coût en points de personnage pour obtenir un <i>niveau</i> donné dans une compétence en fonction de sa difficulté. Ce niveau s’ajoute à la base pour calculer le score de la compétence.</p>
		<p>Lorsque <b>deux valeurs</b> sont données, la deuxième ne s’applique qu’aux compétences exclusivement basées sur l’<i>Int</i>.</p>

		<table>
			<tr>
				<th>Niveau</th>
				<th>-2</th>
				<th>-4</th>
				<th>-6</th>
				<th>-8</th>
			</tr>
			<?php for ($niv = -4; $niv <= (SKILL_V2 ? 7 : 10); $niv++): ?>
				<tr>
					<td <?= $niv === 0 ? "class=\"fw-700\"" : "" ?>><?= $niv > 0 ? "+" . $niv : $niv ?></td>
					<td <?= $niv === 0 ? "class=\"fw-700\"" : "" ?>><?= Skill::displaySkillCost($niv, -2) ?></td>
					<td <?= $niv === 0 ? "class=\"fw-700\"" : "" ?>><?= Skill::displaySkillCost($niv, -4) ?></td>
					<td <?= $niv === 0 ? "class=\"fw-700\"" : "" ?>><?= Skill::displaySkillCost($niv, -6) ?></td>
					<td <?= $niv === 0 ? "class=\"fw-700\"" : "" ?>><?= Skill::displaySkillCost($niv, -8) ?></td>
				</tr>
			<?php endfor; ?>
		</table>

		<?php if (SKILL_V2): ?>
			<p>Il n’est pas possible d’avoir un niveau de compétence supérieur à +7.</p>
		<?php endif ?>

		<details class="exemple">
			<summary>Exemple de calculs de score</summary>
			<p>
				Soit un personnage ayant <i>For</i> 12, <i>Dex 13</i> et <i>Int</i> 11.<br>
				Soit les compétences <i>Nage</i> [FD(-2)] et <i>Baratin</i> [I-4].
			</p>
			<p>Voici quelques exemples de scores obtenus en fonction des points de personnage investis dans chacune des compétences</p>
			<table>
				<tr>
					<th>Points</th>
					<th>Nage</th>
					<th>Baratin</th>
				</tr>
				<tr>
					<th>0</th>
					<td>–</td>
					<td>11-4 = 7</td>
				</tr>
				<tr>
					<th>0.5</th>
					<td>12-1 = 11</td>
					<td>11-2 = 9</td>
				</tr>
				<tr>
					<th>1</th>
					<td>12+0 = 12</td>
					<td>11-1 = 10</td>
				</tr>
				<tr>
					<th>2</th>
					<td>12+1 = 13</td>
					<td>11+0 = 11</td>
				</tr>
			</table>
		</details>

		<h4>Compétences irrégulières</h4>
		<p>Certaines compétences ont un niveau minimum. Ça signifie que leur niveau par défaut n’est pas celui donné par leur type, mais celui indiqué dans leur description.</p>
		<p>Ce niveau par défaut est gratuit, et le coût de progression correspond à celui associé à leur type. Par exemple, la compétence <i>Esquive</i> et de type D-8. Son niveau minimum est -3. Ce niveau coûte normalement 1 pt de personnage, qui est offert. Pour faire passer cette compétence au niveau 0, qui coûte normalement 8 pts, il faudra payer la différence, c’est-à-dire 7 pts.</p>

		<?php
		$special_skills_name_list = [];
		foreach (Skill::special_skills as $id => $value) {
			$skill = $repo->getSkill($id);
			$special_skills_name_list[] = "<i>{$skill->name}</i> (niv. min {$value["min-level"]})";
		}
		?>
		<p><b>Liste des compétences irrégulières :</b> <?= join(", ", $special_skills_name_list) ?></p>

	</details>

	<!-- Spécialisations -->
	<details>
		<summary>
			<h3>Spécialisations</h3>
		</summary>
		<p><b>Spécialisation obligatoire :</b> compétences repérées par « (type) ». Chaque spécialité est une compétence distincte.</p>
		<p><b>Spécialisation optionnelle :</b> 1 pt par +1. Max 5 pts. Pas plus de pts dans la spécialité que dans la compétence de base.</p>
	</details>

	<!-- Compétence de background -->
	<details>
		<summary>
			<h3>Compétence de background</h3>
		</summary>
		<p>
			Compétence très peu utile dans le jeu mais nécessaire d’après l’historique du personnage (décision du MJ).<br>
			Coût divisé par deux (y compris pour une spécialité optionnelle).
		</p>
	</details>

	<!-- Compétences proches -->
	<details>
		<summary>
			<h3>Compétences proches</h3>
		</summary>
		<p>Certaines compétences sont proches les unes des autres. En maîtriser une facilite la maîtrise des autres.</p>

		<p>Lorsque plusieurs compétences appartiennent à un même groupe (voir la liste en fin de pararaphe), il faut déterminer quelle est la compétence <i>principale</i> du groupe (celle que le personnage maîtrise le mieux). Les autres sont appelées compétences <i>secondaires</i>.</p>

		<h4>Compétence principale</h4>
		<p>Il s’agit de la compétence maîtrisée au <i>niveau</i> le plus élevé (hors bonus). En cas d’égalité, sélectionner la compétence dont la plus complexe, c’est-à-dire celle dont le malus de difficulté est le plus élevé.</p>

		<h4>Compétences secondaires</h4>
		<p>Les autres compétences du groupe auront un niveau par défaut égal au niveau de la compétence principale, -2 si leur complexité est égale ou moindre, -3 dans le cas contraire.</p>
		<p>Il est possible d’améliorer une compétence secondaire en payant la différence de coût entre son niveau par défaut et son niveau souhaité. Cela peut avoir comme effet de permuter son rôle avec la compétence principale.</p>
		<p>La fiche de personnage gère cet aspect automatiquement.</p>

		<h4>Groupes de compétences proches</h4>

		<?php
		$readable_group_names = [
			"melee" => "Armes de contact",
			"hand-to-hand" => "Corps-à-corps",
			"bow" => "Arc &amp; arblètes",
			"throwing" => "Armes de jet",
			"seduction" => "Séduction",
			"acrobatics-dodging" => "Esquive",
			"survival" => "Survie",
		];

		foreach (Skill::skills_groups as $group => $id_list) {
			$skills_name_list = [];
			foreach ($id_list as $id) {
				$skill = $repo->getSkill($id);
				$skills_name_list[] = $skill->name;
			}
		?>
			<p><b><?= $readable_group_names[$group] ?? $group ?> :</b> <?= join(", ", $skills_name_list) ?></p>

		<?php } ?>

		<p>Et autres, selon la décision du MJ.</p>

		<details class="exemple">
			<summary>Exemple</summary>
			<p>Un personnage possède la compétence <i>Épée</i> à +3. Il aura ainsi gratuitement <i>Couteau</i> à +1, <i>Hache/Masse</i> à +1 et <i>Fléau</i> à +0 – car cette dernière compétence a une difficulté de -6.</p>
		</details>
	</details>

</article>