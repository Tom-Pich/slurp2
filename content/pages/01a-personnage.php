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
?>

<article>
	<h2>Concevoir son personnage</h2>

	<details>
		<summary class="h3">Introduction</summary>
		<p>Un personnage se construit à partir de points de personnage (généralement entre 80 et 120 pts).</p>
		<p>Ces points permettent de définir les <b>Caractéristiques</b>&nbsp;, <b>Avantages, Désavantages &amp; Travers</b> &nbsp;, <b>Compétences</b> et enfin les <b>Sorts &amp; pouvoirs</b> traités dans les parties <i>Magie</i>, <i>Psioniques</i> et/ou <i>Univers</i>.</p>
	</details>

	<details>
		<summary class="h3">Ébauche</summary>
		<p>Avant de se lancer dans l’aspect technique de la création d’un personnage, il faut commencer par l’ébaucher.</p>
		<p><b>Nom&nbsp;:</b> éviter les clichés et respecter l’ambiance de l’univers de jeu.</p>

		<h4>Métier &amp; position social</h4>
		<ul>
			<li>Gagne-pain / métier</li>
			<li>Race, ethnie, nationalité, origine</li>
			<li>Statut social</li>
			<li>Niveau d’étude</li>
			<li>Richesse</li>
		</ul>


		<h4>Description</h4>
		<ul>
			<li>Apparence physique</li>
			<li>Manière de se vêtir</li>
			<li>Attitude physique</li>
		</ul>

		<h4>Caractère &amp; comportement</h4>
		<ul>
			<li>Tempérament, personnalité (voir des exemples de <i>Traits de caractères</i> ci-dessous)</li>
			<li>Moralité</li>
			<li>Goûts et dégoûts</li>
			<li>Comportement, attitude</li>
			<li>Problèmes psychologiques</li>
			<li>Tic et citation</li>
		</ul>

		<h4>Motivations &amp; objectifs</h4>
		<ul>
			<li>Raison pour laquelle il fait son métier ou part à l’aventure</li>
			<li>Objectifs à long terme</li>
			<li>Croyances (religion, idéaux, etc)</li>
		</ul>

		<h4>Background</h4>
		<ul>
			<li>Famille (origine, composition, niveau social)</li>
			<li>Enfance (conditions, éducation)</li>
			<li>Adolescence (conditions, études ou apprentissage)</li>
			<li>Vie amoureuse, vie de famille</li>
			<li>Vie professionnelle</li>
			<li>Déboires, aventures, hauts et bas</li>
			<li>Relations (famille, amis, ennemis...)</li>
			<li>Domicile (localisation, type, vit-il seul...)</li>
		</ul>
	</details>

	<details>
		<summary class="h3">Traits de caractères</summary>

		<p>Une liste de traits de caractères qui peut aider à ébaucher la personnalité de son personnage.</p>

		<details>
			<summary>
				<h4>Attitude face à la vie</h4>
			</summary>

			<ul>
				<li>Acharné, Zélé</li>
				<li>Ambitieux, Battant, Conquérant, Décidé, Volontaire</li>
				<li>Assidu, Besogneux, Combatif</li>
				<li>Audacieux, Aventureux, Courageux</li>
				<li>Créatif, Débrouillard</li>
				<li>Curieux, Enthousiaste, Ouvert</li>
				<li>Énergique</li>
				<li>Jovial, Optimiste</li>
			</ul>

			<ul>
				<li>Anticonformiste, Contestataire, Révolté, Rebelle</li>
				<li>Aucun sens de l’humour</li>
				<li>Bégeule, Bigot, Pudibond, Puritain, Prude</li>
				<li>Blagueur, Clown, Comique, Farceur</li>
				<li>Calme, Flegmatique, Imperturbable</li>
				<li>Candide, Innocent, Naïf</li>
				<li>Cérébral, Raisonneur</li>
				<li>Conservateur</li>
				<li>Crispé, Stressé, Veut garder le contrôle</li>
				<li>Déluré, Fantaisiste, Extravagant, Dévergondé</li>
				<li>Dépensier, Flambeur</li>
				<li>Désinvolte, Nonchalant</li>
				<li>Discret, Humble, Modeste</li>
				<li>Émotif, Sentimental, Romantique</li>
				<li>Enragé, Hystérique</li>
				<li>Entêté, Obstiné, Têtu</li>
				<li>Exalté, Excité, Passionné</li>
				<li>Excessif, Extrémiste, Fanatique</li>
				<li>Frivole, Imprévoyant, Imprudent, Insouciant</li>
				<li>Iconoclaste, Impie</li>
				<li>Idéaliste, Rêveur</li>
				<li>Impatient, Impétueux, Impulsif</li>
				<li>Manichéen</li>
				<li>Minutieux, Perfectionniste, Pointilleux, Tâtillon</li>
				<li>Pieux, Dévôt, Religieux</li>
				<li>Pondéré, Pragmatique, Prudent, Réflechi, Sage</li>
			</ul>

			<ul>
				<li>Acariâtre, Aigri, Frustré, Insatisfait</li>
				<li>Arriviste, Attentiste, Opportuniste</li>
				<li>Avare, Cupide, Radin, Mesquin</li>
				<li>Blasé, Désabusé, Fataliste</li>
				<li>Bon à rien, Fainéant, Fumiste, Paresseux, Velléitaire</li>
				<li>Boudeur, Grognon, Râleur</li>
				<li>Caractériel, Colérique</li>
				<li>Casanier, Faible, Docile, Gâteux</li>
				<li>Catastrophiste, Défaitiste, Pessimiste</li>
				<li>Caustique, Cynique, Critique</li>
				<li>Craintif, Dégonflé, Lâche</li>
				<li>Dépressif, Désespéré, Mélancolique</li>
				<li>Enfant terrible, enfant gâté</li>
			</ul>

		</details>

		<details>
			<summary>
				<h4>Attitude envers les autres</h4>
			</summary>

			<ul>
				<li>Accommodant, Indulgent, Tolérant</li>
				<li>Affable, Cordial</li>
				<li>Altruiste, Bienfaiteur, Charitable, Généreux, Gentil</li>
				<li>Brave, Patient, Placide</li>
				<li>Civilisé, Courtois, Diplomate</li>
				<li>Clément, Indulgent, Miséricordieux</li>
				<li>Confiant</li>
				<li>Démocrate, Juste</li>
				<li>Désintéressé, Philanthrope</li>
				<li>Dévoué, Loyal</li>
				<li>Complice, Extraverti, Mondain, Sociable</li>
				<li>Honnête, Sincère</li>
				<li>Pacifique</li>
				<li>Protecteur</li>
			</ul>

			<ul>
				<li>Aguicheur, Charmeur, Séducteur</li>
				<li>Baratineur, Beau-parleur, Causeur</li>
				<li>Cachottier, Dissimulateur, Secret</li>
				<li>Concupiscent, Coureur, Débauché, Nymphomane</li>
				<li>Demandeur, Assisté, Quémandeur</li>
				<li>Docte, Donneur de leçons, Moralisateur</li>
				<li>Exubérant</li>
				<li>Indiscret</li>
				<li>Introverti, Renfermé, Réservé, Taciturne</li>
				<li>Laxiste</li>
				<li>Meneur</li>
				<li>Paternaliste</li>
			</ul>

			<ul>
				<li>Affabulateur, Bluffeur, Menteur</li>
				<li>Agressif, Belliqueux, Brute, Hargneux, Violent, Sanguinaire</li>
				<li>Arbitraire, Inique</li>
				<li>Arnaqueur, Canaille, Malhonnête</li>
				<li>Arrogant, Dédaigneux</li>
				<li>Asocial</li>
				<li>Autoritaire, Despote, Tyrannique</li>
				<li>Barbare, Vandale</li>
				<li>Chahuteur, Effronté, Provocateur</li>
				<li>Chicaneur, Malicieux, Chipie, Emmerdeur, Gêneur</li>
				<li>Comédien, Hypocrite, Manipulateur</li>
				<li>Complaisant, Démagogue, Obséquieux, Flatteur</li>
				<li>Cruel, Démoniaque, Fourbe, Méchant, Pervers, Sadique,</li>
				<li>Délateur, Calomniateur, Médisant</li>
				<li>Dur, Insensible</li>
				<li>Envieux</li>
				<li>Ingrat</li>
				<li>Injuste, Intolérant</li>
				<li>Jaloux, Possessif</li>
				<li>Machiste, Misogyne, Misanthrope, Raciste, Homophobe</li>
				<li>Méfiant</li>
				<li>Grossier, Mufle, Rustre</li>
				<li>Rancunier</li>
			</ul>

		</details>

		<details>
			<summary>
				<h4>Attitudes liées au «&nbsp;moi&nbsp;»</h4>
			</summary>

			<ul>
				<li>Ascète, Chaste, Sobre</li>
				<li>Autosatisfait, Cabotin, Crâneur, Frimeur, Vantard</li>
				<li>Balourd, Béotien, Empoté, Gaffeur, Maladroit</li>
				<li>Bon vivant, Épicurien, Gourmand, Sensuel</li>
				<li>Capricieux</li>
				<li>Chatouilleux, Ombrageux, Susceptible</li>
				<li>Collectionneur, Fétichiste</li>
				<li>Complexé, Névrosé, Timide</li>
				<li>Coquet, Délicat, Pédant</li>
				<li>Cyclothymique, Inconstant, Indécis, Instable, Lunatique</li>
				<li>Égocentrique, Égoïste, Individualiste</li>
				<li>Hypocondriaque</li>
				<li>Immature</li>
				<li>Masochiste</li>
				<li>Obsédé, Maniaque</li>
				<li>Orgueilleux, Présomptueux, Fier</li>
				<li>Original</li>
			</ul>

		</details>

	</details>

</article>

<article>
	<h2>Caractéristiques</h2>

	<details>
		<summary class="h3">Introduction</summary>
		<p>Les 6 <b>caractéristiques principales</b> constituent la charpente du personnage. Elles ont un impact sur de nombreux aspects de celui-ci, dont notamment le coût à payer pour obtenir un score donné dans une compétence.<br>
			Un score de 10 (médiocre) est gratuit et constitue le score par défaut.</p>
		<p>Les <b>caractéristiques secondaires</b> sont calculées à partir des caractéristiques principales et peuvent être modifiées par un <i>Avantage</i> ou un <i>Désavantage</i> adéquat, dans une certaine mesure.</p>
	</details>

	<details>
		<summary class="h3">Caractéristiques principales</summary>

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

		<table class="mx-auto alternate-e">

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


		<table class="alternate-e left-2 mt-1">
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
		<summary class="h3">Caractéristiques secondaires</summary>
		<p>Elles sont basées les caractéristiques principales.</p>

		<h4>Dégâts de base</h4>
		<p>Ils sont basés sur la <i>For</i> et servent à déterminer les dégâts des armes dépendant de la puissance musculaire. Le premier score est l’<i>estoc</i> (<i>e</i>), le deuxième et la <i>taille</i> (<i>t</i>).</p>

		<table class="alternate-e">
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

		<h4>Points de vie et autres&hellip;</h4>

		<div class="flex-s mt-½ fw-600">
			<div class="fl-1">Points de vie (PdV)</div>
			<div><?= Attribute::pdv ?></div>
		</div>
		<div>Capacité à encaisser des blessures.</div>

		<div class="flex-s mt-½ fw-600">
			<div class="fl-1">Points de fatigue (PdF)</div>
			<div><?= Attribute::pdf ?></div>
		</div>
		<div>Capacité à résister à l’effort, à la privation de sommeil, au manque de nourriture, etc. Voir le chapitre <i>Bases du système</i>.</div>

		<div class="flex-s mt-½ fw-600">
			<div class="fl-1">Points de magie (PdM)</div>
			<div><?= Attribute::pdm ?></div>
		</div>
		<div>Réserve d’énergie pour l’utilisation de sorts et de pouvoirs magiques.</div>

		<div class="flex-s mt-½ fw-600">
			<div class="fl-1">Points d’équilibre psychique (PdE)</div>
			<div><?= Attribute::pde ?></div>
		</div>
		<div>Mesure de la santé mentale du personnage.</div>

		<h4>Modifier ses caractéristiques secondaires</h4>
		<p>Pour modifier les caractéristiques secondaires indépendamment des caractéristiques principales, voir la liste d’<i>Avantage</i> &amp; <i>Désavantages</i>. Ces modifications doivent rester exceptionnelles et justifiées (sauf pour les PdM dont l’augmentation est encadrée par l’avantage <i>Magerie</i>).</p>
	</details>

</article>

<article>
	<h2>Avantages, Désavantages &amp; Travers</h2>

	<details>
		<summary class="h3">Introduction</summary>
		<p>Les <i>Avantages</i> et les <i>Désavantages</i> recouvrent tout ce qui ne relève pas d’une caractéristique ou d’une compétence. Vous trouverez ci-dessous les règles les concernant. La liste complète avec la description de chaque avantage et désavantage est visible sur la page <a href="avdesav-comp-sorts">Liste pour le personnage</a>.</p>
	</details>

	<details>
		<summary class="h3">Règle du 12</summary>
		<p>• <b>Avantage&nbsp;:</b> si un jet sous une caractéristique est nécessaire pour le faire fonctionner, le score de base <i>minimum</i> de cette caractéristique et considéré comme valant 12 (en dehors de modificateurs d’état ou de circonstances).</p>
		<p>• <b>Désavantage&nbsp;:</b> si un jet est nécessaire pour y échapper, le score <i>maximum</i> de ce jet est de 12.</p>
		<div class="exemple">L’avantage <i>Intuition</i> nécessite un jet d’<i>Int</i> pour fonctionner. Si l’<i>Int</i> du personnage est inférieure à 12, elle est considérée comme valant 12 pour ce jet. Mais si le personnage est blessé ou fatigué, les modificateurs normaux s’appliquent à cette base de 12.</div>
	</details>

	<details>
		<summary class="h3">Limites de désavantages</summary>
		<p>Un maximum de –40 pts de désavantages est suggéré à la création d’un personnage, sans quoi le personnage peut devenir très contraignant à jouer, ou incohérent.</p>
		<p>Une même contrainte peut parfois être décrite par différents désavantages. En choisir un et un seul pour rendre compte d’une contrainte donnée.</p>
	</details>

	<details>
		<summary class="h3">Traits de caractère</summary>
		<p>Les <i>Traits de caractères</i> sont des <i>Désavantages</i> influençant le comportement du personnage, sans effet direct en terme de règles. Le joueur peut d’ailleurs les définir lui-même.</p>
		<p>Pour être plus qu’un simple <i>Travers</i>, un <i>Trait de caractère</i> doit respecter l’une au moins des conditions suivantes&nbsp;:</p>
		<ul>
			<li>Mettre parfois en danger le personnage&nbsp;;</li>
			<li>Impliquer des dépenses régulières et importantes&nbsp;;</li>
			<li>Limiter sa liberté d’action&nbsp;;</li>
			<li>Imposer un malus aux JR au moins dans certaines circonstances.</li>
		</ul>
		<p>Certains <i>Traits de caractère</i> ne peuvent donc, par essence, qu’être des <i>Travers</i> (Modeste, Discret...).</p>

		<h4>Traits de caractère vertueux</h4>
		<p>Les traits de caractères vertueux (<i>Charitable</i>, <i>Honnête</i>, <i>Sens du devoir</i>, <i>Pacifique</i>, <i>Respect de la vérité</i>) constituent un moyen «&nbsp;facile&nbsp;» de gagner des points de personnage si le personnage n’est pas une crapule sans foi ni loi. Pensez-y au moment de sa création.</p>

		<h4>Coût des traits de caractères</h4>
		<p><b>Travers (-1 pt)&nbsp;:</b> tendance légère, qui ne gêne pas le personnage. Compté comme un <i>Travers</i> (voir plus loin) et non comme un <i>Désavantage</i>.</p>

		<p><b>Marqué (-5 pts)&nbsp;:</b> rapidement remarqué par l’entourage du personnage. -1 aux JR, et/ou coûte jusqu’à 10% d’un salaire de base par mois, et/ou limite relativement la liberté d’action et/ou fait parfois prendre des risques.</p>

		<p><b>Fort (-10 pts)&nbsp;:</b> <i>Trait de caractère</i> central du personnage. -2 aux JR, et/ou coûte jusqu’à un salaire moyen par mois, et/ou limite beaucoup la liberté d’action, et/ou fait parfois courir des risques sérieux. -2 pour y résister.</p>

		<p><b>Extrême (-15 pts ou +)&nbsp;:</b> stade pathologique. Mène à terme à la banqueroute et/ou en prison, limite drastiquement la liberté d’action ou fait souvent risquer sa vie. -5 pour y résister. Tous les traits de caractères n’ont pas forcément une version à –15 pts.</p>

		<h4>Limites de Traits de caractères</h4>
		<p>3 <i>Traits de caractère</i> maximum dont un seul allant jusqu’à -10 pts.</p>
	</details>

	<details>
		<summary class="h3">Vivre ses désavantages</summary>
		<p>Il y a plusieurs manières possibles de «&nbsp;vivre&nbsp;» ses désavantages mentaux et traits de caractère. Certaines de ces manières permettent d’obtenir des points de personnages supplémentaires.</p>
		<p>• <b>Par défaut (0 pt)&nbsp;:</b> le personnage les assume pleinement (sans pour autant en être fier).</p>
		<p>• <b>C’est normal (0 pt)&nbsp;:</b> les personnes n’en souffrant pas sont considérés comme «&nbsp;anormaux&nbsp;» et traités selon le caractère du personnage.</p>
		<p>• <b>S’efforcer de s’y plier (-5 pts)&nbsp;:</b> s’applique principalement aux désavantages vertueux. Jet de Vol pour s’y conformer. -1 PdE si échec.<br>
			Si, par ce biais, PdE &lt; 50% PdE max, le personnage perd le désavantage et doit le racheter au plus vite (il hérite de <i>Malchance</i> en attendant).</p>
		<p>• <b>Lutter contre eux (-5 pts)&nbsp;:</b> jet de Vol pour ne pas y céder. -1 PdE en cas d’échec.<br>
			Si, par ce biais, PdE &lt; 50% PdE max, le personnage ne cherchera plus à y résister. Le désavantage pourra même s’aggraver.</p>
		<p>• <b>Ne pas en avoir conscience ou les nier (-5 pts)&nbsp;: </b> variante automatique pour certains désavantages mentaux (<i>Chimère</i> par exemple)
			et dans ce cas, elle n’apporte pas de points supplémentaires. </p>
		<p>• <b>Tabou (-5 pts)&nbsp;:</b> interdiction/obligation «&nbsp;sacrée&nbsp;» absolue. Le personnage obéit toujours à ce désavantage. Si c’est impossible (sous la contrainte, par exemple), le personnage perd 1 PdE à chaque fois (max 1 PdE tout les 2 jours).</p>
	</details>

	<details>
		<summary class="h3">Après la création du personnage</summary>
		<p>Un personnage peut gagner un <i>Avantage</i> ou hériter d’un <i>Désavantage</i> (ou encore racheter un <i>Désavantage</i>) au cours du jeu par la logique des événements (<i>Richesse</i>, <i>Réputation</i>, mais aussi <i>Borgne</i>, <i>Ennemi</i>, etc.) Dans ce cas, cela ne coûte ni ne rapporte aucun point de personnage.</p>
		<p>Il est également possible d’acquérir un <i>Avantage</i> ou un <i>Désavantage</i> ou de racheter un <i>Désavantage</i> si cela n’est pas incompatible avec la logique de l’<i>Avantage</i>/<i>Désavantage</i> (on ne rachète pas le désavantage <i>Borgne</i>, par exemple, mais on peut racheter une <i>Malchance</i> ou un <i>Trait de caractère</i>).</p>
	</details>

	<details>
		<summary class="h3">Travers</summary>
		<p><i>Trait de caractère</i> mineur (-1 pt) ne constituant pas un désavantage. À la création, il est possible de prendre jusqu’à 5 travers.<br>
			Un <i>Travers</i> peut être racheté ou changé, si un événement justifie un léger changement de personnalité.</p>
		<p><b>Quelques catégories de travers&nbsp;:</b> croyance, objectif mineur, goût ou dégoût, habitude, expression, manière particulière de se vêtir, un amour non partagé, des loisirs particuliers, un divertissement préféré, etc.</p>
	</details>

</article>

<article>
	<h2>Compétences</h2>

	<details>
		<summary class="h3">Introduction</summary>
		<p>Les <i>Compétences</i> sont des connaissances ou des savoir-faire qui peuvent être appris et développés. La plupart d’entre elles possèdent un score <i>par défaut</i>, qui ne coûte rien et qui se calcule d’après les caractéristiques.</p>
	</details>

	<details>
		<summary class="h3">Scores</summary>
		<p>Le score d’une compétence dépend&nbsp;:</p>
		<ul>
			<li>de la ou des <b>caractéristique(s)</b> sur laquelle ou lesquelles elle est basée,</li>
			<li>du nombre de <b>points</b> de personnage investis dedans,</li>
			<li>de sa <b>difficulté&nbsp;:</b> <i>facile</i> (-2), <i>moyenne</i> (-4), <i>ardue</i> (-6) ou <i>très ardue</i> (-8)</li>
		</ul>
		<p> La <i>base</i> de la compétence est la moyenne des caractéristiques sur lesquelles elle est basée (ou la valeur de la caractéristique si elle n’est basée que sur une seule caractéristique).</p>
		<p>La table ci-dessous indique le coût en points de personnage pour obtenir un <i>niveau</i> donné dans une compétence en fonction de sa difficulté.</p>
		<p>Ce niveau s’ajoute à la base pour calculer le score.</p>

		<table class="alternate-e">
			<tr>
				<th>Niveau</th>
				<th>-2</th>
				<th>-4</th>
				<th>-6</th>
				<th>-8</th>
			</tr>
			<?php
			for ($niv = -4; $niv <= 12; $niv++) { ?>

				<tr>
					<td><?= $niv > 0 ? "+" . $niv : $niv ?></td>
					<td><?= Skill::niv2cost($niv, -2) >= .5 ? Skill::niv2cost($niv, -2) : "–"  ?></td>
					<td><?= Skill::niv2cost($niv, -4) >= .5 ? Skill::niv2cost($niv, -4) : "–"  ?></td>
					<td><?= Skill::niv2cost($niv, -6) >= .5 ? Skill::niv2cost($niv, -6) : "–"  ?></td>
					<td><?= Skill::niv2cost($niv, -8) >= .5 ? Skill::niv2cost($niv, -8) : "–"  ?></td>
				</tr>

			<?php
			}
			?>
		</table>

		<p><b>Score par défaut&nbsp;:</b> score en l’absence de points investis dans la compétence. La plupart des compétences ont un score par défaut&nbsp;; celles qui n’en ont pas ont une difficulté notée entre parenthèse.</p>

		<div class="exemple">
			<p>
				Soit un personnage ayant <i>For</i> 12, <i>Dex 13</i> et <i>Int</i> 11.<br>
				Soit les compétences <i>Nage</i> [FD(-2)] et <i>Baratin</i> [I-4].
			</p>
			<p>Voici quelques exemples de scores obtenus en fonction des points de personnage investi dans chacune des compétences</p>
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
		</div>

	</details>

	<details>
		<summary class="h3">Spécialisations</summary>
		<p><b>Spécialisation obligatoire&nbsp;:</b> compétences repérées par «&nbsp;(type)&nbsp;». Chaque spécialité est une compétence distincte.</p>
		<p><b>Spécialisation optionnelle&nbsp;:</b> 1 pt par +1. Max 5 pts. Pas plus de pts dans la spécialité que dans la compétence de base.</p>
	</details>

	<details>
		<summary class="h3">Compétence de background</summary>
		<p>Compétence très peu utile dans le jeu mais nécessaire d’après l’historique du personnage (décision du MJ).<br>
			Coût divisé par deux (y compris pour une spécialité optionnelle).</p>
	</details>

	<details>
		<summary class="h3">Compétences proches</summary>
		<p>Certaines compétences sont proches les unes des autres. En maîtriser une facilite la maîtrise des autres.</p>

		<p>Toutes les compétences appartenant à un même groupe reçoivent un bonus de points de personnage égal au quart des points investis dans toutes les autres compétences du même groupe.</p>

		<p>Une compétence peut appartenir à deux groupes différents. Dans ce cas, elle reçoit des points de bonus de chacun des groupes (jusqu’à 2 pts de bonus par groupe).</p>

		<h4>Groupes de compétences proches</h4>
		<?php
		$skills_groups = Skill::skills_groups;
		$repo = new SkillRepository;

		foreach ($skills_groups as $group => $id_list) {
			switch ($group) {
				case "melee":
					$group_name = "Armes de contact";
					break;
				case "hand-to-hand":
					$group_name = "Corps-à-corps";
					break;
				case "bow":
					$group_name = "Arc &amp; arblètes";
					break;
				case "throwing":
					$group_name = "Armes de jet";
					break;
				default:
					$group_name = $group;
			}
			$skills_name_list = [];
			foreach ($id_list as $id) {
				$skill = $repo->getSkill($id);
				$skills_name_list[] = $skill->name;
			}
		?>
			<p><b><?= $group_name ?>&nbsp;:</b> <?= join(", ", $skills_name_list) ?></p>
		<?php
		}
		?>
		<p>Et autres, selon la décision du MJ.</p>

		<div class="exemple">
			<p>Investir 13 pts dans la compétence <i>Épée</i> permet aux autres compétences proches d’obtenir un bonus en points de 13÷4 = 3,25 pts limité à 2 pts.</p>
			<p>Si le personnage souhaite ajouter 2 pts dans la compétence <i>Hache/Masse</i>, cela lui fera un total de 4 pts dans cette compétence. En retour, la compétence <i>Épée</i> bénéficiera d’un bonus de 0,5 pt.</p>
		</div>
	</details>

</article>