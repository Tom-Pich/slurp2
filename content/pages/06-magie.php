<?php

use App\Entity\Spell;
?>

<!-- Bases de la magie -->
<article>
	<h2>Bases de la magie</h2>

	<!-- Principes directeurs -->
	<details>
		<summary>
			<h3>Principes directeurs</h3>
		</summary>
		<p>La magie décrite ici est plutôt «&nbsp;mécanique&nbsp;» (un sort entraîne un effet élémentaire, toujours plus ou moins le même), relativement simple et rapide à mettre en œuvre. Elle convient pour des univers de type médiéval-fantastique classiques et consiste à utiliser une énergie appelée fluide pour affecter la réalité.</p>
	</details>

	<!-- Terminologie -->
	<details>
		<summary>
			<h3>Terminologie</h3>
		</summary>
		<p>
			<b>Hex&nbsp;:</b> surface hexagonale de «&nbsp;diamètre&nbsp;» moyen égal à 1 m.<br>
			<b>Sujet&nbsp;:</b> objet, personne ou créature affectée par le sort. Parfois appelé « cible » pour les sorts hostiles.<br>
			<b>Initiateur&nbsp;:</b> le lanceur du sort ou du pouvoir.<br>
			<b>Coût énergétique&nbsp;:</b> quantité de PdM requis pour lancer le sort.<br>
			<b>Score brut</b> d'un sort&nbsp;: score ne tenant compte d'aucun modificateur à l'exception du modificateur dû au niveau de fluide
		</p>
	</details>

	<!-- L’avantage Magerie -->
	<details>
		<summary>
			<h3>L’avantage <i>Magerie</i></h3>
		</summary>
		<p>Nécessaire pour pouvoir apprendre et lancer des sorts. Il comporte 5 niveaux.<br>
			Aucun sort de niveau de puissance supérieur au niveau de <i>Magerie</i> de l’initiateur ne peut être lancé.</p>

		<table class="fs-300">
			<tr>
				<th>Niv.</th>
				<th>Coût</th>
				<th>Int</th>
				<th>Modif.</th>
				<th>Détection</th>
				<th>PdM</th>
				<th>Impro</th>
			</tr>
			<tr>
				<td>1</td>
				<td>20</td>
				<td>-</td>
				<td>-2</td>
				<td>8</td>
				<td>0</td>
				<td>12</td>
			</tr>
			<tr>
				<td>2</td>
				<td>30</td>
				<td>12</td>
				<td>-1</td>
				<td>11</td>
				<td>5</td>
				<td>14</td>
			</tr>
			<tr>
				<td>3</td>
				<td>40</td>
				<td>14</td>
				<td>0</td>
				<td>13</td>
				<td>10</td>
				<td>17</td>
			</tr>
			<tr>
				<td>4</td>
				<td>55</td>
				<td>16</td>
				<td>+1</td>
				<td>15</td>
				<td>15</td>
				<td>20</td>
			</tr>
			<tr>
				<td>5</td>
				<td>75</td>
				<td>18</td>
				<td>+2</td>
				<td>auto.</td>
				<td>&infin;</td>
				<td>25</td>
			</tr>
		</table>

		<p><b>Coût&nbsp;:</b> Coût du niveau en points de personnage.<br>
			<b>Int&nbsp;:</b> Intelligence minimale requise pour acquérir ce niveau.<br>
			<b>Modificateur&nbsp;:</b> bonus aux scores des collèges.<br>
			<b>Détection&nbsp;:</b> score pour savoir si un objet touché est magique ou percevoir une perturbation du fluide. Un seul jet peut être fait pour chaque objet ou chaque perturbation.<br>
			<b>PdM&nbsp;:</b> nombre de PdM supplémentaires maximum que peut acquérir un mage.<br>
			<b>Impro&nbsp;:</b> limite du score de compétence du collège en cas d'improvisation.
		</p>
	</details>

	<!-- Apprendre un collège -->
	<details>
		<summary>
			<h3>Apprendre un Collège de magie</h3>
		</summary>
		<p>Un collège de magie est un ensemble de connaissances sur l’utilisation de la magie appliquée à un domaine particulier. Chaque collège est une <b>compétence I(-8)</b>. Voir la <a href="avdesav-comp-sorts">liste des sorts par collège</a> pour avoir la liste des collèges existants.</p>
	</details>

	<!-- Apprendre un sort -->
	<details>
		<summary>
			<h3>Apprendre un sort</h3>
		</summary>
		<p>Un sort est une <i>spécialisation optionnelle</i> d’un collège. Le score d’un sort est également assorti d’un modificateur qui dépend de son niveau de puissance (voir <i>Lancer un sort</i> plus loin)</p>
		<p class="mt-1 ta-center"><b>score brut (sort) = score (collège) + pts investis – modificateur de puissance</b></p>
		<p>Un sort ayant plusieurs niveaux de puissance possèdera donc des scores différents selon le niveau auquel il est utilisé.</p>
		<p>Il est <b>impossible de lancer un sort sans avoir un score brut &ge; 12</b> dans ce sort, que ce soit en l’improvisant ou en l’ayant appris.</p>

		<h4>Improviser un sort</h4>
		<p>Il est possible d’improviser n’importe quel sort de niveau III ou moins (sauf les sorts de <i>Blocage</i> et d’<i>Enchantement</i>) y compris des sorts qui ne seraient pas décrits dans ces règles.</p>
		<p>Le score est calculé comme un sort dans lequel aucun pt de personnage n’a été investi. Pour ce calcul, le niveau de compétence effectif dans le collège possède une limite qui dépend du niveau de <i>Magerie</i>.</p>
		<p><b>Réussite et échec&nbsp;:</b> lors du lancer d’un sort improvisé, 16 est toujours un échec, 17 et 18 sont toujours des échecs critiques.</p>

		<h4>Sorts appartenant à plusieurs collèges</h4>
		<p>Certains sorts appartiennent à plusieurs collèges à la fois. La connaissance d’un seul de ces collèges est suffisante pour pouvoir apprendre le sort.</p>
	</details>

	<!-- Niveau de puissance -->
	<details>
		<summary>
			<h3>Niveau de puissance des sorts</h3>
		</summary>
		<p>La puissance d’un sort ou d’un pouvoir est quantifiée en niveaux de puissance, de I à V.</p>

		<h4>Niveau I - Faible</h4>
		<p>Apporte l’aide que pourrait apporter un outil adéquat ou une personne compétente. Apporte une petite aide surnaturelle dans certaines conditions.</p>
		<p><b>Exemples&nbsp;:</b> protéger contre le froid ou la chaleur, deviner les émotions de quelqu’un, produire de la lumière.</p>

		<h4>Niveau II - Moyen</h4>
		<p>Apporte une aide appréciable dans certaines conditions, ou une petite aide tout le temps. Effets identiques possibles par moyens non-magiques d’un niveau technologique moderne.</p>
		<p><b>Exemples&nbsp;:</b> protéger une petite zone des aléas climatiques, calmer quelqu’un de furieux ou de terrorisé, produire une lumière puissante et continuelle.</p>

		<h4>Niveau III - Assez puissant</h4>
		<p>Peut permettre à lui seul de franchir une étape importante d’un scénario.</p>
		<p><b>Exemples&nbsp;:</b> protéger une petite zone de toute attaque physique, plonger une victime très rapidement dans un sommeil profond, voir dans les ténèbres</p>

		<h4>Niveau IV - Puissant</h4>
		<p>Sorts pouvant court-circuiter une grande partie d’un scénario.</p>
		<p><b>Exemples&nbsp;:</b> protéger une zone de toutes attaques et intrusions, y compris magiques, exercer une domination mentale complète sur une victime, se rendre invisible.</p>

		<h4>Niveau V - Très puissant</h4>
		<p>Sorts à ne pas mettre entre les mains de PJ sous peine de changer l’orientation de la campagne.</p>
		<p><b>Exemples&nbsp;:</b> ressusciter, se téléporter, passer à travers les murs, tuer instantanément une victime très résistante, etc.</p>
	</details>

	<!-- Classes de sorts -->
	<details>
		<summary>
			<h3>Classes de sorts</h3>
		</summary>
		<p>Les sorts sont divisés en classes, qui régissent leur fonctionnement général (portée, zone affectée, etc.).</p>

		<!-- Régulier -->
		<details>
			<summary><h4>Régulier</h4></summary>
			<p><b>Zone d’effet&nbsp;:</b> un sujet à la fois. Pour un sujet sensiblement plus gros qu’un être humain, le coût énergétique est augmenté sans excéder le double du coût normal. L’augmentation du coût est laissée à l’appréciation du MJ, mais ne s'applique qu'à des sujets très gros (éléphant ou géant, par exemple).</p>
			<p><b>Portée&nbsp;:</b> -1 par mètre entre le sujet et l’initiateur (min. -1 si ce dernier ne touche pas le sujet)&nbsp;; -3 si l’initiateur ne peut ni toucher ni voir le sujet (voir par des substituts magiques fonctionne).</p>
			<p><b>Diriger le sort&nbsp;:</b> 2 manières possibles de diriger ces sorts. L’initiateur peut affecter un hex donné (par exemple, «&nbsp;l’hex derrière cette porte&nbsp;») ou un sujet donné (par exemple «&nbsp;Untel dans la pièce à côté&nbsp;»). Aucune barrière physique ne s’oppose à un sort régulier. Un sort régulier ne frappe jamais une victime par erreur, sauf en cas d’échec critique.</p>
			<p><b>Sorts de type «&nbsp;Jaillissements&nbsp;»&nbsp;:</b> ce sont des sorts réguliers un peu particuliers. Ils nécessitent un jet pour réussir le sort, en tenant compte de la portée voulue, puis un autre en <i>Lancer de sort</i> pour toucher la cible. Considéré comme une attaque à distance. En termes de difficulté, ces sorts ont la même précision qu’une pierre lancée à la main. On peut y opposer une <i>Esquive</i> ou un <i>Blocage</i> (sauf si le <i>Jaillissement</i> n’est pas visible).</p>
		</details>

		<!-- Zone -->
		<details>
			<summary><h4>Zone</h4></summary>
			<p>Ces sorts affectent une zone circulaire et tous ceux qui se trouvent à l’intérieur. Pour le reste, ils fonctionnent comme les sorts <i>Réguliers</i>. Ces sorts peuvent être lancés sur un objet inanimé&nbsp;; la zone sera centrée sur cet objet et suivra ses déplacements.</p>
			<p><b>Portée&nbsp;:</b> comme les sorts réguliers, la distance à prendre en compte est la distance qui sépare l'initiateur de la limite la plus proche de la zone</p>
			<p><b>Taille de la zone&nbsp;:</b> la description des sorts de zone mentionne une <i>Zone de base</i> (qui vaut 3 mètres si elle n’est pas précisée). C’est le <i>diamètre</i> de la zone d’effet, en mètres, pour un coût énergétique standard. Augmenter le diamètre de la zone implique une augmentation proportionnelle du coût énergétique.</p>
			<p><b>Forme de la zone d’effet</b>&nbsp;: il est possible de ne pas affecter l’intégralité de la zone circulaire, mais seulement la partie voulue par l’initiateur. Le MJ pourra accorder une réduction du coût énergétique si la zone affectée est inférieure à la moitié de la zone circulaire correspondante.</p>
			<p><b>Hauteur de la zone&nbsp;:</b> 4 mètres au-dessus du sol. Deux exceptions d’ordre général&nbsp;: les sorts de type <i>Dôme</i> et les sorts climatiques.</p>
			<p><b>Déplacement de la zone&nbsp;:</b> la zone et son point d'attache sont définis au moment du lancer et ne peuvent être modifiés pendant la durée du sort. Le point d’attache peut être éventuellement mobile.</p>
			<p><b>Sorts de type «&nbsp;Mur&nbsp;»&nbsp;:</b> ces sorts de zone créent un mur de 4 m de haut maximum qui doivent pouvoir s'inscrire dans la zone. Ils peuvent l'entourer mais ce n'est pas une obligation. Le signe de leur courbure doit être constant (un mur ne peut pas avoir une forme de "S", mais il peut être droit ou courbé comme une parenthèse, que ce soit selon l'axe horizontal comme l'axe vertical). Ils peuvent donc constituer un dôme si l'initiateur le souhaite. Toutefois, une fois que la forme du mur est définie, elle ne peut plus être changée pendant la durée du sort.</p>
		</details>

		<!-- Projectiles -->
		<details>
			<summary><h4>Projectile</h4></summary>
			<p>L’usage de ces sorts nécessite 2 étapes&nbsp;: créer le projectile (compétence dans le sort), puis le lancer (compétence <i>Lancer de sort</i>). Un projectile se déplace toujours en ligne droite. La précision d’un tel sort (pour déterminer la difficulté du tir) est comparable à celle d’un pistolet moderne. La portée ½D des sorts de <i>Projectiles</i> est de 25 m.</p>
			<p><b>Défenses&nbsp;:</b> un sort de projectile peut être bloqué ou esquivé, mais seul les projectiles solides (tel que <i>Couteau ailé</i>) peuvent être parés. Une armure protège normalement, sauf mention contraire.</p>
			<p><b>Projectile «&nbsp;en main&nbsp;»&nbsp;:</b> l'initiateur peut conserver son projectile en main quand celui-ci est prêt à être lancé. Il peut se déplacer, viser et lancer le projectile au moment voulu. C’est le seul type de sort dont l’effet puisse être retardé.<br>
				En cas de blessure, un jet de <i>Volonté</i> est nécessaire. En cas d’échec, le projectile est perdu. Un projectile solide tombera simplement au sol, mais d’autres (boules de feu, éclairs) se retourneront contre leur initiateur.</p>
		</details>

		<!-- Blocage -->
		<details>
			<summary><h4>Blocage</h4></summary>
			<p>Un sort de <i>Blocage</i> peut être jeté instantanément en guise de défense contre une attaque physique ou un autre sort. Un seul sort de <i>Blocage</i> peut être jeté à la fois. Il interrompt toute concentration en cours. Les sorts de blocage ne peuvent être improvisés. Si l’initiateur a déjà effectué une action au cours de la même seconde (attaque, défense…) le sort est lancé à -5.<br>
				En termes de <i>rituel nécessaire</i>, l'initiateur doit être capable d'accomplir le rituel associé au score qu'il a dans son sort de <i>Blocage</i> (voir <i>Rituel nécessaire</i> plus loin).</p>
		</details>

		<!-- Information -->
		<details>
			<summary><h4>Information</h4></summary>
			<p>Jet de compétence fait secrètement par le MJ. Si le sort réussit, le MJ donne à l’initiateur les informations demandées, leur qualité dépendant de la MR. Si le sort échoue, l’initiateur ne perçoit rien. En cas d’échec critique, le MJ ment au joueur. L’initiateur dépense toujours le coût énergétique intégral, que le sort réussisse ou échoue.<br>
				La plupart ne peuvent être tentés qu’une fois par jour pour chaque initiateur (ou groupe d’initiateurs, en cas de magie rituelle). Les sorts de <i>Recherche</i> font exception à la règle, sauf s'ils portent sur une cible spécifique.<br>
				Avec les sorts de <i>Recherche</i>, tout objet connu peut être exclu si l’initiateur le souhaite (-1 à la compétence par objet ignoré).<br>
				La portée d’un sort d’information est gérée de la même manière que celle d’un sort régulier, sauf mention contraire. Certains sorts d’information sont également des sorts de zone. Ils cumulent alors les règles s’appliquant à ces deux types de sorts.</p>
		</details>

		<!-- Enchantement -->
		<details>
			<summary><h4>Enchantement</h4></summary>
			<p>Ces sorts permettent de créer des objets magiques. Ils fonctionnent un peu différemment des autres sorts (voir <i>Création d’objet magique</i>).</p>
		</details>

		<!-- Sorts spéciaux -->
		<details>
			<summary><h4>Sorts spéciaux</h4></summary>
			<p>Ils n’obéissent à aucune règle énoncée ci-dessus. Tout est indiqué dans la description du sort.</p>
		</details>
	</details>

</article>

<!-- Lancer un sort -->
<article>
	<h2>Lancer un sort</h2>
	<details>
		<summary>
			<h3>Modificateurs</h3>
		</summary>
		<p><b>État de l’initiateur&nbsp;:</b> la fatigue, les blessures et l’encombrement imposent les mêmes malus pour le lancer d’un sort que pour des actions physiques.</p>
		<p><b>Distance de la cible&nbsp;:</b> voir la description de la classe ou du sort.</p>
		<p><b>Jeter des sorts en en prolongeant d’autres&nbsp;:</b> si le sort actif nécessite une concentration, un autre sort peut être jeté à -3. Les sorts nécessitant une concentration le mentionnent dans leur description. Sinon (y compris dans le cas d’un sort projectile gardé « &nbsp;en main&nbsp;»), il peut être jeté à -1. Les sorts permanents ne sont pas considérés comme des sorts en cours. Ces pénalités sont cumulatives.</p>
	</details>

	<details>
		<summary>
			<h3>Caractéristiques générales des sorts</h3>
		</summary>
		<table>
			<tr>
				<th rowspan="2">Niv.</th>
				<th rowspan="2">Modif. de<br> puissance</th>
				<th rowspan="2">Coût en PdM</th>
				<th colspan="2">Tps nécessaire*</th>
			</tr>
			<tr>
				<th>rapide</th>
				<th>long</th>
			</tr>
			<tr>
				<td>I</td>
				<td>0</td>
				<td>2</td>
				<td><?= Spell::cast_time[0][0] ?>&nbsp;s</td>
				<td><?= Spell::cast_time[0][1] ?>&nbsp;s</td>
			</tr>
			<tr>
				<td>II</td>
				<td>-2</td>
				<td>4</td>
				<td><?= Spell::cast_time[1][0] ?>&nbsp;s</td>
				<td><?= Spell::cast_time[1][1] ?>&nbsp;s</td>
			</tr>
			<tr>
				<td>III</td>
				<td>-5</td>
				<td>6</td>
				<td><?= Spell::cast_time[2][0] ?>&nbsp;s</td>
				<td><?= Spell::cast_time[2][1] / 60 ?>&nbsp;min</td>
			</tr>
			<tr>
				<td>IV</td>
				<td>-8</td>
				<td>8</td>
				<td><?= Spell::cast_time[3][0] ?>&nbsp;s</td>
				<td><?= Spell::cast_time[3][1] / 60 ?>&nbsp;min</td>
			</tr>
			<tr>
				<td>V</td>
				<td>-13</td>
				<td>15+</td>
				<td><?= Spell::cast_time[4][0] ?>&nbsp;s</td>
				<td><?= Spell::cast_time[4][1] / 3600 ?>&nbsp;h</td>
			</tr>
		</table>
		<p>* Sauf indication contraire dans la description du sort.</p>
	</details>

	<details>
		<summary>
			<h3>Réduction du coût énergétique</h3>
		</summary>
		<p>Le coût énergétique d’un sort diminue pour une compétence élevée&nbsp;:</p>
		<p>• -1 PdM à un niveau &ge; 15<br>
			• -2 PdM à un niveau &ge; 17<br>
			• -3 PdM à un niveau &ge; 19, et ainsi de suite.</p>
		<p>Cette réduction s’applique au coût de lancer du sort et au coût de maintien. Le score à prendre en compte est le score brut. Un sort suffisamment maîtrisé peut donc devenir gratuit à prolonger voire à lancer.</p>
	</details>

	<details>
		<summary>
			<h3>Temps et rituel nécessaire</h3>
		</summary>
		<p>Un temps d’incantation est nécessaire avant de pouvoir lancer un sort. Ce <i>Temps nécessaire</i> peut être <i>rapide</i> ou <i>long</i> (voir description du sort). La valeur exacte de ce temps nécessaire dépend de son niveau de puissance.</p>
		<p>Ce temps peut être raccourci grâce à un score de compétence élevé (sauf si le sort nécessite toujours un rituel ou un objet spécifique).</p>
		<p>Dans tous les cas, <b>un seul sort peut être lancé chaque seconde</b>, même s'il peut être lancé de manière instantanée.</p>

		<table class="left-2">
			<tr>
				<th width="10%">Score brut</th>
				<th>Rituel nécessaire</th>
			</tr>
			<tr>
				<td>&le; 11</td>
				<td>Mains et pieds libres pour accomplir des mouvements rituels élaborés. Énoncer certains mots de puissance d’une voix ferme. Double du temps nécessaire pour être jeté. Il n’est pas possible d’avoir un score aussi bas, sauf en zone à fluide faible.</td>
			</tr>
			<tr>
				<td>12-14</td>
				<td>Énoncer quelques mots calmement et faire un geste spécifique (un seul bras est nécessaire) pour activer le sort. Les sorts demandent un laps de temps normal pour être lancés. Aucun déplacement lors de l’incantation.</td>
			</tr>
			<tr>
				<td>15-17</td>
				<td>Énoncer un mot ou deux et faire quelques gestes - bouger quelques doigts suffit. Déplacement possible d’un mètre par seconde lors de la concentration.</td>
			</tr>
			<tr>
				<td>18-20</td>
				<td>Prononcer un mot ou deux, ou bien faire de petits gestes, mais pas forcément les deux à la fois.</td>
			</tr>
			<tr>
				<td>21-24</td>
				<td>Aucun rituel nécessaire. Le magicien semble seulement fixer l’horizon lorsqu’il se concentre. <i>Temps nécessaire</i> réduit de 50 %, arrondi à la seconde inférieure. Un sort qui aurait pris normalement 1 seconde pour être jeté instantanément, même si l’initiateur effectue en même temps une autre action - combattre, parler, courir, etc. Mais il n’est pas permis de jeter deux sorts en même temps.</td>
			</tr>
			<tr>
				<td>25-29</td>
				<td>Comme ci-dessus, mais le temps nécessaire pour jeter un sort est divisé par 4.</td>
			</tr>
			<tr>
				<td>30-34</td>
				<td>1/8<sup>e</sup> du temps normal pour jeter un sort.</td>
			</tr>
			<tr>
				<td>Au-delà</td>
				<td>Divisez par 2 le temps d’incantation par 5 pts supplémentaires.</td>
			</tr>
		</table>
	</details>

	<details>
		<summary>
			<h3>Durée et prolongation</h3>
		</summary>
		<p>Certains sorts ont une durée de base mentionnée dans leur description. Si l'initiateur ne précise rien, son sort aura cette durée. Il peut préciser que son sort durera moins longtemps que la normale (aucun surcoût, aucun malus). S'il veut interrompre un sort avant la fin de sa durée, il doit payer 1 PdM sauf si le sort ne lui en a coûté aucun.</p>
		<p><b>Prolonger un sort&nbsp;:</b> aucun jet n’est nécessaire, l’initiateur paye la moitié du coût de base du sort pour le prolonger de sa durée de base (ou moins s'il le spécifie). L’initiateur doit être conscient et éveillé, même si la prolongation ne lui coûte aucun PdM.</p>
	</details>

	<details>
		<summary>
			<h3>Modificateurs de longue distance</h3>
		</summary>
		<p>Lorsqu’un sort agit à longue distance, utiliser le tableau ci-dessous pour déterminer le malus associé à la distance entre l’initiateur et le sujet.</p>
		<table class="left-1">
			<tr>
				<th>Distance</th>
				<th>Modif.</th>
			</tr>
			<tr>
				<td>&le; 100 m</td>
				<td>0</td>
			</tr>
			<tr>
				<td>&le; 300 m</td>
				<td>-1</td>
			</tr>
			<tr>
				<td>&le; 1 km</td>
				<td>-2</td>
			</tr>
			<tr>
				<td>&le; 3 km</td>
				<td>-3</td>
			</tr>
			<tr>
				<td>&le; 10 km</td>
				<td>-4</td>
			</tr>
			<tr>
				<td>&le; 30 km</td>
				<td>-5</td>
			</tr>
			<tr>
				<td>&le; 100 km</td>
				<td>-6</td>
			</tr>
			<tr>
				<td>&le; 300 km</td>
				<td>-7</td>
			</tr>
			<tr>
				<td>&le; 1000 km</td>
				<td>-8</td>
			</tr>
			<tr>
				<td>chaque ×3</td>
				<td>-1 sup.</td>
			</tr>
		</table>
	</details>

	<details>
		<summary>
			<h3>Réussite, échec et échec critique</h3>
		</summary>
		<p><b>Réussite&nbsp;:</b> le sort a été lancé et son coût énergétique doit être payé (même si la cible a résisté au sort).</p>
		<p><b>Réussite critique&nbsp;:</b> le sort a fonctionné mieux que prévu (discrétion du MJ). Pas de dépense de PdM.</p>
		<p><b>Échec&nbsp;:</b> le sort n’a pas agi. L’initiateur perd la moitié des PdM qu’aurait dû lui coûter le sort (sauf pour les sorts d’<i>Information</i> qui gardent leur coût énergétique normal).</p>
		<p><b>Échec critique&nbsp;:</b> l’énergie nécessaire a été dépensée, mais le sort a échoué de manière spectaculaire. Le résultat est géré sur la <a href="table-jeu">Table de jeu</a>.</p>
	</details>

</article>

<!-- Effets génériques des sorts -->
<article>
	<h2>Effets génériques des sorts</h2>

	<details>
		<summary>
			<h3>Table des effets génériques</h3>
		</summary>
		<p>Afin de simplifier la description des sorts, des effets «&nbsp;génériques&nbsp;» sont définis en fonction du niveau du sort.</p>
		<table class="left-1 fs-300">
			<tr>
				<th>Type d’effets</th>
				<th>I</th>
				<th>II</th>
				<th>III</th>
				<th>IV</th>
				<th>V<sup>(5)</sup></th>
			</tr>
			<tr>
				<td>Modif. standards</td>
				<td>&plusmn;1</td>
				<td>&plusmn;2</td>
				<td>&plusmn;3</td>
				<td>&plusmn;5</td>
				<td>&infin;</td>
			</tr>
			<tr>
				<td>Modif. de <i>Force</i></td>
				<td>&plusmn;20&nbsp;%</td>
				<td>&plusmn;40&nbsp;%</td>
				<td>&plusmn;60&nbsp;%</td>
				<td>&plusmn;100&nbsp;%</td>
				<td>&infin;</td>
			</tr>
			<tr>
				<td>Résistance aux dégâts<sup>(1)</sup></td>
				<td>+2</td>
				<td>+4</td>
				<td>+6</td>
				<td>+10</td>
				<td>&infin;</td>
			</tr>
			<tr>
				<td>Dégâts standard<sup>(2)</sup></td>
				<td>1d</td>
				<td>2d</td>
				<td>4d</td>
				<td>7d</td>
				<td>(18d)</td>
			</tr>
			<tr>
				<td>Dégâts P-Ex-sRD<sup>(3)</sup></td>
				<td>1d-1</td>
				<td>1d+2</td>
				<td>3d</td>
				<td>5d</td>
				<td>(12d)</td>
			</tr>
			<tr>
				<td>Dégâts répétés<sup>(4)</sup></td>
				<td>1d-2</td>
				<td>1d</td>
				<td>2d</td>
				<td>3d+2</td>
				<td>(9d)</td>
			</tr>
			<tr>
				<td>Bonus de dégâts standards (BDS)</td>
				<td>+2</td>
				<td>+1d+1</td>
				<td>+2d</td>
				<td>+3d</td>
				<td>(+7d+2)</td>
			</tr>
		</table>

		<p><b>(1)</b> Pour rester compétitifs avec les progrès technologiques, ces bonus sont plus importants pour de NT élevés&nbsp;: ×1,5 à NT6, ×2 à NT7 et ×3 à NT8.<br>
			<b>(2)</b> Attaque physique classique. La RD est prise en compte. ×1,5 à NT 7+<br>
			<b>(3)</b> Dégâts perforants, explosifs ou sans prise en compte de la RD. ×1,5 à NT 7+<br>
			<b>(4)</b> Les dégâts sont soit répétés dans le temps (jusqu'à 10 fois), soit dans l’espace (jusqu'à 10 projectiles par sort, comme une arme automatique). ×1,5 à NT 7+<br>
			<b>(5)</b> Quand des effets sont mentionnés pour un niveau de puissance V, il s’agit des effets obtenus lorsque le sort coûte 15 PdM, sauf mention contraire. Les effets peuvent être plus puissants encore si le coût énergétique est augmenté. Ceci n’est valable que pour les sorts de niveau V.
		</p>
	</details>

	<details>
		<summary>
			<h3>Modificateurs spécifiques</h3>
		</summary>
		<p><b>Dex (bonus)&nbsp;:</b> standard ; <b>(malus)</b>&nbsp;: standard ×2<br>
			<b>Int (bonus)&nbsp;:</b> standard ; <b>(malus)&nbsp;:</b> standard ×2<br>
			<b>San&nbsp;:</b> standard ×2<br>
			<b>Per&nbsp;:</b> standard ×2<br>
			<b>Jet de réaction&nbsp;:</b> standard ×2<br>
			<b>Jet de défenses ou de résistance&nbsp;:</b> standard ×2
		</p>
	</details>

	<details>
		<summary>
			<h3>Détruire un objet inanimé</h3>
		</summary>
		<p>Certains sorts ne peuvent provoquer des dégâts qu’à des objets inanimés.</p>
		<p><b>Niv. I&nbsp;:</b> Objet facile à briser à mains nues (verre, panier d’osier...)<br>
			<b>Niv. II&nbsp;:</b> Objet pouvant être détruit avec une hache ou une masse par un homme normal, en une minute max.<br>
			<b>Niv. III&nbsp;:</b> Comme ci-dessus mais pendant un temps beaucoup plus long.<br>
			<b>Niv. IV&nbsp;:</b> Effets similaires à ceux d’une grenade<br>
			<b>Niv. V&nbsp;:</b> Comme un engin de chantier de type bulldozer.
		</p>
	</details>

	<details>
		<summary>
			<h3>Invocation de créatures</h3>
		</summary>
		<p><b>Niv. I&nbsp;:</b> créature faible (chien de guerre, gobelin).<br>
			<b>Niv. II&nbsp;:</b> créature moyenne (humain moyen avec une arme simple, très petit démon).<br>
			<b>Niv. III&nbsp;:</b> créature assez puissante (humain bien entraîné avec du matériel de qualité, démon mineur).<br>
			<b>Niv. IV&nbsp;:</b> créature puissante.<br>
			<b>Niv. V&nbsp;:</b> créature très puissante (démon majeur).
		</p>
		<p><i>Remarque</i>&nbsp;: une créature ayant des pouvoirs et avantages significativement plus élevés que son niveau de puissance «&nbsp;apparent&nbsp;» pourra être considérée comme appartenant à une catégorie de puissance supérieure. De même si la créature souffre d’une limitation importante ou si elle représente un danger pour son invocateur elle peut passer dans la catégorie de puissance inférieure. Ainsi, un démon majeur pourra être invoquer par un sort de niveau IV seulement car son invocation est réellement dangereuse pour son initiateur.</p>
	</details>

</article>

<!-- Résister à un sort -->
<article>
	<h2>Résister à un sort</h2>
	<details>
		<summary>
			<h3>Jet de résistance</h3>
		</summary>
		<p>Duel entre une caractéristique de la cible (mentionnée dans la description du sort) et le score modifié de l’initiateur. Pour la calcul de la MR de l'initiateur&nbsp;:</p>
		<p><b>Cible = créature&nbsp;:</b> score limité à 16 et MR limitée à 8.<br>
			<b>Cible = autre sort&nbsp;:</b> aucune limite
		</p>
		<p>Résister à un sort de niveau V se fait toujours à -3, en plus de la MR du sort.</p>
	</details>

	<details>
		<summary>
			<h3>Effets d’une résistance réussie</h3>
		</summary>
		<p>Si la résistance est réussie, le sort n’agit pas mais les PdM nécessaires sont dépensés. Si le sujet est vivant et conscient, il ressentira une légère torsion mentale ou physique (selon la nature du sort) mais rien d’autre. L’initiateur saura que son sort a rencontré une résistance.</p>
	</details>

	<details>
		<summary>
			<h3>Résistance et tentatives répétées</h3>
		</summary>
		<p>L’initiateur peut tenter de relancer le sort, avec un malus de -1 cumulatif pour chaque résistance réussie, si la cible est un être vivant. Après trois échecs, l’initiateur ne peut plus faire de tentatives pour une journée. Si la résistance est due à celle d’un autre sort, l’initiateur n’a la droit qu’à une unique tentative.</p>
	</details>

</article>

<!-- PdM -->
<article>
	<h2>Points de magie</h2>

	<details>
		<summary>
			<h3>PdM et lancer de sorts</h3>
		</summary>
		<p>Lorsque les PdM arrivent à 0, le mage ne peut plus lancer de sort. Il n’est pas possible d’avoir un nombre de PdM négatifs.</p>
	</details>


	<details>
		<summary>
			<h3>Récupération</h3>
		</summary>
		<p>1 PdM par 15 minutes de repos (conversation banale autorisée) dans un environnement calme. Toute cause de stress et de tension (bruits, agitation, inconfort) empêche la récupération. Le maintien d'un sort qui ne demande aucune concentration n'empêche pas la récupération de PdM.</p>
	</details>

	<details>
		<summary>
			<h3>Dépenser des PdF</h3>
		</summary>
		<p>Un initiateur peut appliquer une partie ou la totalité du coût énergétique du sort à ses PdF au lieu de l’appliquer à ses PdM. La fatigue causée de cette manière est considérée comme une fatigue normale. -1 au jet de compétence pour chaque PdF utilisé.</p>
	</details>
</article>

<!-- Fluide -->
<article>
	<h2>Fluide</h2>

	<details>
		<summary>
			<h3>Définition</h3>
		</summary>
		<p>Le «&nbsp;fluide&nbsp;» est l'énergie subtile manipulée par la magie. Il n'est pas nécessairement le même partout. Sa densité et son orientation peuvent varier.</p>
	</details>


	<details>
		<summary>
			<h3>Niveaux de fluide</h3>
		</summary>
		<p>La magie n’agit que si le fluide de la zone le permet. Il existe plusieurs niveaux de fluide.</p>
		<p><b>Fluide élevé&nbsp;:</b> récupération 2 fois plus rapide des PdM. Coût énergétique des sorts divisé par 2. Échecs critiques spectaculaires.</p>
		<p><b>Fluide normal&nbsp;:</b> les sorts agissent selon les règles normales.</p>
		<p><b>Fluide faible&nbsp;:</b> -5 aux sorts et aux pouvoirs. Ce malus s’applique à la compétence brute. Il a donc une influence sur l’incantation et la réduction de coût énergétique d’un sort. Ce malus <i>n’empêche pas</i> le mage de lancer un sort même si son score est inférieur à 12 à cause de cela.<br>
			Le score de pouvoir des objets magiques est aussi à -5, ce qui empêche les objets magiques ayant un score de pouvoir inférieur à 20 d’agir. Les échecs critiques n’ont que peu d’effet. Le rythme de récupération des PdM est divisé par 2.</p>
		<p><b>Fluide nul&nbsp;:</b> personne ne peut utiliser la magie. Les objets magiques n’agissent pas. Aucune récupération de PdM.</p>
		<p>Des niveaux de fluide intermédiaires sont possibles.</p>
	</details>

	<details>
		<summary>
			<h3>Perception du fluide</h3>
		</summary>
		<p>Un mage ne sait pas automatiquement quel est le niveau de fluide d’une région, mais, à chaque fois qu’il traverse une frontière entre deux niveaux de fluide, il doit faire un jet pour détecter le changement et savoir si le niveau de fluide a augmenté ou diminué.</p>
	</details>

	<details>
		<summary>
			<h3>Fluide orienté</h3>
		</summary>
		<p>Dans certaines régions, le fluide est orienté, ce qui le rend favorable à certains types de magie et hostile à d’autres.<br>
			Au MJ de définir les effets exacts, mais typiquement, il s’agira de bonus s’appliquant à un, ou éventuellement plusieurs, collèges et/ou des malus s’appliquant à d’autres collèges. Mais ce ne sont pas les seuls effets possibles&nbsp;: augmentation du <i>Temps nécessaire</i>, augmentation du coût énergétique, etc. sont autant d’autres effets possibles.</p>
	</details>
</article>

<!-- Créer/modifier un sort -->
<article>
	<h2>Créer ou modifier un sort</h2>
	<!-- <p>Un mage peut inventer des sorts ou modifier les caractéristiques de sorts qu’il connaît.</p> -->

	<details>
		<summary>
			<h3>Modifier un sort existant</h3>
		</summary>
		<p>Au moment de lancer un sort, qu’il soit improvisé ou connu, un mage peut en changer certaines caractéristiques.</p>
		<h4>Sort <i>Régulier</i> en sort de <i>Zone</i></h4>
		<p>La zone de base est de 3 m. Le niveau du sort est augmenté de 1.</p>
		<h4>Durée de base augmentée</h4>
		<p>La durée de base change de catégorie&nbsp;: 1 minute devient 10 minutes, 10 minutes deviennent 1h, 1h devient une journée, etc. Le niveau du sort est augmenté de 1. Ne fonctionne pas avec des sorts très brefs.</p>
		<h4>Portée augmentée</h4>
		<p>Doubler la portée d’un sort → coût énergétique ×2<br>
			Appliquer les modificateurs de longue distance → augmente le niveau de puissance de 1.</p>
	</details>

	<details>
		<summary>
			<h3>Inventer un nouveau sort</h3>
		</summary>
		<p>Un mage peut inventer un nouveau sort, soit en l’improvisant, soit pour l’apprendre.</p>
		<p>Il faut d’abord déterminer son niveau de puissance, sa classe et son collège.</p>
		<p>Un sort d'<b>Invocation</b> appartient soit au collège <i>Animalier</i>, soit au collège d'<i>Emprise mentale</i>, soit au collège de <i>Seuils</i> selon la nature de la créature invoquée</p>
		<h4>Temps nécessaire</h4>
		<p>Si un sort a un intérêt au combat, il est doit être rapide à lancer, sinon il est long.</p>
		<h4>Durée</h4>
		<p>La durée (choisie par le MJ) doit être la durée minimale pour que le sort ait un intérêt.<br>
			- instantané / 1s<br>
			- un combat (1 minute)<br>
			- une séquence (10 minutes)<br>
			- longue durée (1h / 10h / un jour / une semaine)<br>
			- permanent</p>
		<h4>Sort dérivé d’un autre collège</h4>
		<p>Il est possible d’adapter à un collège certains sorts dont l’effet principal ne relève pas de ce collège. Cela a pour conséquences d’introduire des limitations légères au sort.</p>
		<h4>Effet spécialisé</h4>
		<p>Il est possible de créer des variantes d’un sort standard ayant des effets spécialisés ou restreints. Leurs effets sont d’autant plus efficaces qu’ils sont spécialisés.</p>
		<h4>Effets multiples</h4>
		<p>De manière générale, si un sort possède des effets multiples, son niveau de puissance est augmenté de 1 par rapport au sort «&nbsp;standard&nbsp;» le plus puissant ayant le même effet. Ces effets multiples ne peuvent pas relever de différents collèges. Pour cela, il est nécessaire de lancer plusieurs sorts à la suite.</p>
		<h4>Sorts à contraintes augmentées</h4>
		<p>Il est possible d’inventer (mais pas d’improviser) un sort qui demande plus de temps pour être lancé que la version normale, ou qui demande certaines conditions particulières (composantes matérielles, par exemple). La puissance de tels sorts est alors baissée d’un niveau (ou de deux dans les cas extrêmes).</p>
	</details>

</article>

<!-- Magie collective -->
<article>
	<h2>Magie collective</h2>

	<details>
		<summary>
			<h3>Définition</h3>
		</summary>
		<p>La magie collective désigne le lancer collectif d’un sort. Elle permet de disposer d’une grande réserve de PdM. La magie rituelle est plus lente (10 fois le temps normal) car elle implique une cérémonie complexe.</p>
	</details>


	<details>
		<summary>
			<h3>Rituel</h3>
		</summary>
		<p>Les mages doivent être reliés physiquement d’une certaine manière (peu importe laquelle) pour former un <i>Cercle</i>. L’un d’eux sera l’initiateur et effectuera tous les jets. Le coût en PdM est partagé entre les mages unis comme souhaité, bien que ceux qui ne connaissent pas le sort à 15+ ne puissent apporter que 3 PdM de contribution (mais ils doivent connaître le sort). Si le lien physique est brisé pendant l’incantation, l’initiateur doit tout reprendre depuis le début. Si l’un des mages est blessé, cela entraîne les mêmes effets que si c’était l’initiateur. Si l’un des mages unis est assommé ou tué, tous les autres sont sonnés mentalement.</p>
		<p>Du fait que la cérémonie inhérente aux sorts rituels ne peut être accélérée, ni la compétence de l’initiateur ni celle d’un autre ne peuvent réduire le temps ou le coût nécessaire à son exécution. L’avantage <i>Chance</i> ne peut être utilisé pour la magie collective.</p>
	</details>

	<details>
		<summary>
			<h3>Réussites &amp; échecs</h3>
		</summary>
		<p>Un sort jeté par rituel est plus difficile à coordonner qu’un sort régulier. 16 est toujours un échec, 17 et 18 sont toujours des échecs critiques. Toute l’énergie nécessaire est dépensée à la fin de l’incantation, que le sort réussisse ou échoue.</p>
	</details>

	<details>
		<summary>
			<h3>Maintenir un sort de magie rituelle</h3>
		</summary>
		<p>Un <i>Cercle</i> peut être maintenu malgré les arrivées et départs de participants. Ceci n’est pas possible pendant qu’un sort est jeté, mais si le <i>Cercle</i> ne fait que prolonger des sorts, sa composition peut varier.</p>
	</details>

	<details>
		<summary>
			<h3>Échange d’énergie contre compétence</h3>
		</summary>
		<p>En fournissant plus de PdM que nécessaires, l’initiateur obtient un bonus à son jet de compétence&nbsp;: + 1 pour 20 %, +2 pour 40 %, +3 pour 60 %, +4 pour 100%, et +1 pour chaque 100% supplémentaire. Cette méthode peut être utilisée, entre autres, pour fabriquer des objets magiques avec un score de pouvoir important.</p>
	</details>


</article>

<!-- Pouvoirs magiques -->
<article>
	<h2>Pouvoirs magiques</h2>

	<details>
		<summary>
			<h3>Définition</h3>
		</summary>
		<p>Un pouvoir est la capacité instinctive à lancer un sort. Il est lancé de façon innée et ne peut être appris. À l’exception des points détaillés ci-dessous, un pouvoir fonctionne exactement comme le sort équivalent.<br>
			Il existe également des pouvoirs de type <i>Avantage</i>, qui sont toujours actifs et fonctionnent alors comme un avantage classique.</p>
	</details>

	<details>
		<summary>
			<h3>Coût en points de personnage</h3>
		</summary>
		<table class="left-1">
			<tr>
				<th>Puissance</th>
				<td>I</td>
				<td>II</td>
				<td>III</td>
				<td>IV</td>
				<td>V</td>
			</tr>
			<tr>
				<th>Pts de perso</th>
				<td><?= Spell::cost_as_power[0] ?></td>
				<td><?= Spell::cost_as_power[1] ?></td>
				<td><?= Spell::cost_as_power[2] ?></td>
				<td><?= Spell::cost_as_power[3] ?></td>
				<td><?= Spell::cost_as_power[4] ?></td>
			</tr>
		</table>
		<p>Posséder un pouvoir à un certain niveau implique automatiquement la possibilité de le lancer à un niveau moindre lorsque cela est possible. Cela n’a pas d’influence sur le score du pouvoir.</p>
		<p>Si le personnage dispose de l’avantage <i>Magerie</i> à un niveau supérieur ou égal à celui du pouvoir, le pouvoir lui coûte la moitié de son prix normal.</p>
	</details>


	<details>
		<summary>
			<h3>Jet de réussite</h3>
		</summary>
		<p>Le score de base est l’<i>Int</i> (la règle du 12 s’applique, c’est-à-dire que quelque soit l’<i>Int</i> du personnage, son score minimum vaut 12).</p>
		<h4>Amélioration du score</h4>
		<p>Le score de compétence d’un pouvoir peut être amélioré à raison de 2 pts de personnage pour chaque +1 souhaité.</p>
		<h4>Réussite et échec critiques</h4>
		<p>Une réussite critique à l’utilisation d’un pouvoir surnaturel permet de lancer le pouvoir sans dépense de PdM. Il peut y avoir une légère amélioration de son efficacité.</p>
		<p>Un échec critique entraîne une dépense normale de PdM et le personnage perd l’usage de son pouvoir pendant (lancer 1d)&nbsp;: 1&nbsp;: 1d heure(s) ; 2-3&nbsp;: 2d heures ; 4-5&nbsp;: 1d jour(s) ; 6&nbsp;: 2d jours.</p>
	</details>

	<details>
		<summary>
			<h3>Coût énergétique, Temps nécessaire &amp; rituels</h3>
		</summary>
		<p>Ces trois paramètres n'évoluent pas avec le score de compétence.</p>
		<p>Le déclenchement d’un pouvoir ne nécessite aucun geste ni aucune parole mais demande tout de même un temps de concentration durant lequel il n’est possible de se déplacer que d’un mètre par seconde.</p>
	</details>

	<details>
		<summary>
			<h3>Améliorations et limitations</h3>
		</summary>
		<p>Il est possible d'améliorer ou de limiter l'utilisation d'un pouvoir.</p>
		<p>En fonction de l’étendue des limitations et/ou des améliorations, le MJ attribue un multiplicateur de coût en pts de personnage à l’achat du pouvoir. Ce multiplicateur n'a pas d'influence sur le coût de l'amélioration du score de ce pouvoir.</p>

		<table class="left-1">
			<tr>
				<th>Limitation ou amélioration</th>
				<th>Mult.</th>
				</td>
			<tr>
				<td>Limitation drastique</td>
				<td>×0,50</td>
			</tr>
			<tr>
				<td>Limitation forte</td>
				<td>×0,67</td>
			</tr>
			<tr>
				<td>Limitation moyenne</td>
				<td>×0,75</td>
			</tr>
			<tr>
				<td>Limitation légère</td>
				<td>×0,90</td>
			</tr>
			<tr>
				<td>Amélioration mineure</td>
				<td>×1,1</td>
			</tr>
			<tr>
				<td>Amélioration moyenne</td>
				<td>×1,25</td>
			</tr>
			<tr>
				<td>Amélioration assez importante</td>
				<td>×1,5</td>
			</tr>
			<tr>
				<td>Amélioration très importante</td>
				<td>×2</td>
			</tr>
		</table>

		<p>L'importance d’une amélioration donnée ou d’une limitation donnée peut dépendre de la nature du pouvoir et de l’univers de jeu. Elle doit être évaluée au cas par cas par le MJ en se basant sur le tableau ci-dessus.</p>

		<h4>Exemples d’améliorations</h4>
		<p>Déclenchement accéléré<br>
			Réduction du coût énergétique. Pour les sorts de Zone, préciser la taille maximale de la zone gratuite.<br>
			Réussite automatique (le pouvoir fonctionne comme un <i>Avantage</i>).</p>

		<h4>Exemples de limitations</h4>
		<p>Aucun entraînement possible&nbsp;: le score ne peut être amélioré.<br>
			Augmentation du coût énergétique<br>
			Condition d’utilisation spécifique portant sur le sujet ou les circonstances de l’utilisation du pouvoir.<br>
			Contact physique uniquement<br>
			Déclenchement involontaire<br>
			Déclenchement long<br>
			Délai&nbsp;: délai minimum entre deux utilisations consécutives.<br>
			Effets limités à l’initiateur<br>
			Effets secondaires<br>
			En cas de stress uniquement<br>
			Peu fiable&nbsp;: le pouvoir ne se déclenche pas toujours, indépendamment du niveau de compétence.</p>
	</details>
</article>

<!-- Objets magiques -->
<article>
	<h2>Objets magiques</h2>

	<details>
		<summary>
			<h3>Utilisation</h3>
		</summary>
		<p>Il existe 2 types d’objets magiques&nbsp;: ceux en veille perpétuelle et ceux à usage ponctuel.</p>

		<p><b>Score de pouvoir&nbsp;:</b> tous les objets possèdent un score de pouvoir. Pour qu’un objet magique fonctionne, il faut que ce score soit ≥ 15, en tenant compte d’un éventuel modificateur dû à un fluide faible.</p>

		<p><b>Objet en veille perpétuelle&nbsp;:</b> fonctionne en permanence.</p>

		<h4>Objet à usage ponctuel</h4>
		<ul>
			<li>Déclenche un pouvoir à la demande de son possesseur.</li>
			<li>Nécessite un jet sous son score de pouvoir <i>seulement</i> si le pouvoir peut rencontrer une résistance. Sinon, la réussite est automatique.</li>
			<li>Peut être utilisé <i>x</i> fois par jour (entre deux levers de soleil).</li>
			<li>Maintien et zone&nbsp;: compte pour la même fraction d’utilisation que le sort correspondant au pouvoir</li>
			<li>Temps nécessaire&nbsp;: toujours «&nbsp;standard&nbsp;».</li>
			<li>Les objets magiques ne marchent généralement que sur leur possesseur, sauf si cela rend le pouvoir inutile.</li>
			<li>Objet à charges&nbsp;: dispose d’un certain nombre de charges. Peuvent être rechargés (voir <i>Création d’un objet</i>).</li>
		</ul>

		<h4>Objet mal connu</h4>
		<p>Si l’utilisateur d’un objet ne connaît pas ses pouvoirs, seuls ceux en veille perpétuelle fonctionneront. Pour les autres, il est nécessaire de connaître leur existence et leur nature.</p>
	</details>

	<details>
		<summary>
			<h3>Création</h3>
		</summary>

		<p>À chaque objet magique est associé un sort d’enchantement spécifique pour le créer.<br>
			Un sort d’enchantement est au minimum niveau III, appartient au collège d’<i>Enchantement</i> et ne peut jamais être improvisé.</p>

		<h4>Prérequis</h4>
		<p>
			Le score du sort d’enchantement doit être ≥ 15 pour pouvoir créer un objet.<br>
			Beaucoup de sorts d’enchantement ont un ou plusieurs collège(s) et/ou sort(s) prérequis.<br>
			Le mage doit posséder un grimoire décrivant le processus d’enchantement, sauf s’il connaît le sort à 20+.
		</p>

		<h4>Coût et temps nécessaire</h4>
		<p>Le coût énergétique de tels sorts est beaucoup plus élevé que celui des sorts classiques, de même que le temps nécessaire. Voir leur description.</p>

		<h4>Matériaux nécessaires</h4>
		<p>En plus de l’objet à enchanter, des composants matériels spécifiques peuvent être nécessaires ou permettre de faciliter l’enchantement.</p>

		<h4>Déroulement de l’enchantement</h4>
		<p>
			Pour les sorts d'enchantement nécessitant une journée ou plus, le mage doit y consacrer 8 h par jour. Le reste du temps il se repose et peut mener des activités non stressantes.<br>
			S’il est interrompu pendant son travail, il sera un peu fatigué (-1d PdF, -2d PdM) et devra rester concentré sur son enchantement. Toute utilisation d’un autre sort sera à -3. S’il cesse sa concentration, il perd une journée de travail.<br>
			Un magicien qui est importuné alors qu’il ne travaille pas activement sur son enchantement ne subit aucune pénalité pour lancer un autre sort.<br>
			Un mage ne peut travailler que sur un seul enchantement à la fois.
		</p>

		<h4>Réussite et échec</h4>
		<p>
			À la fin du dernier jour de l’enchantement, faire un jet de compétence. Le mage doit dépenser l’intégralité des PdM nécessaires. S’il n’a pas utilisé d’autres sorts que son sort d’enchantement au cours de la journée, le mage dispose de tous ses PdM.<br>
			16 est toujours un échec, et 17 ou 18 est un échec critique.<br>
			Un échec entraîne la dépense de tous les PdM nécessaires et les matériaux nécessaires ne sont plus utilisables (hormis l’objet lui-même).<br>
			Un échec critique a toujours des conséquences dramatiques, à commencer par la destruction de l’objet (à moins qu’il ne deviennent un objet maudit).
		</p>

		<h4>Score de pouvoir d’un objet magique</h4>
		<p>
			Le score de pouvoir de l’objet correspond au score du sort d’enchantement du mage. (+2 si MR ≥ 5, +5 en cas de réussite critique).<br>
			Ce score de pouvoir peut être supérieur à la compétence de l’enchanteur s’il fournit plus de PdM que nécessaire (comme pour la <i>Magie collective</i>).<br>
			Il est également possible de réduire le coût énergétique si l’enchanteur diminue son niveau de compétence dans le sort d’enchantement (et donc le score de pouvoir de l’objet, qui doit cependant toujours être au moins égal à 15)&nbsp;: 10 % par -1. La réduction maximale est de 50 %, pour un malus de -5.
		</p>

		<h4>Enchantement collectif</h4>
		<p>Plusieurs mages peuvent collaborer à un même enchantement. Les règles sont les mêmes que pour la magie collective, sauf que le temps nécessaire est divisé par le nombre de participants, qui doivent tous impérativement connaître le sort d’enchantement à 15+.</p>

		<h4>Recharger un objet magique</h4>
		<p>
			Pour pouvoir recharger un objet magique à charges, un mage doit maîtriser le sort que l’objet est capable de lancer (ou être capable de l’imporviser) avec un score ≥ 15 au même niveau de puissance.<br>
			Aucun jet de compétence n’est à faire&nbsp;; il suffit simplement de dépenser les PdM nécessaires (aucune réduction de coût associée au score).
		</p>

		<details class="exemple">
			<summary>Exemple</summary>
			<p>Un mage souhaite recharger une <i>Baguette de boules de feu</i> III. Il doit donc être capable de lancer <i>Boule de feu</i> au niveau III avec un score ≥ 15. Chaque charge lui coûtera 6 PdM (coût normal d’un sort de niveau III).</p>
		</details>
	</details>

</article>

<!-- Alchimie -->
<article>
	<h2>Alchimie</h2>

	<details>
		<summary>
			<h3>Définition</h3>
		</summary>
		<p>L’alchimie est la science de fabrication de potions magiques et autres « produits » alchimiques. Seule la compétence <i>Alchimie</i> est nécessaire.</p>
	</details>

	<details>
		<summary>
			<h3>Utilisation d’objets alchimiques</h3>
		</summary>

		<h4>Forme des objets alchimiques</h4>
		<p><b>Potions&nbsp;:</b> une dose correspond à environ 25 mL (une petite gorgée) de liquide et affecte une créature de taille humaine instantanément. Les potions perdent leur pouvoir après une journée si elles sont exposées à l’air libre ou mélangées à d’autres substances.</p>
		<p><b>Onguents&nbsp;:</b> pénètrent instantanément dans la peau et agissent immédiatement. Ils gardent leurs pouvoirs une semaine s’ils sont exposés à l’air libre. Neutralisés par l’eau. -1 au jet de compétence pour les préparer, durée de préparation +4 h.</p>
		<p><b>Poudres&nbsp;:</b> doit être mélangée à de la nourriture ou dissoute dans une boisson. Elle agit en 2d minutes. Les poudres alchimiques peuvent durer très longtemps&nbsp;: 50% de chance qu’elles perdent leur pouvoir après une année exposée à l’air. -1 au jet de compétence pour les préparer, durée de préparation +4 h ou +10% (le plus long des deux).</p>
		<p><b>Pastilles&nbsp;:</b> cachet de la taille d’un ongle de pouce ; doit être conservé dans une fiole scellée. Il fonctionne par combustion et s’enflamme immédiatement après avoir été allumé. La fumée émanant d’une pastille remplira une zone de 3 m de diamètre à une hauteur de 2,50 mètres et s’attardera pendant 10 secondes à l’intérieur (beaucoup moins longtemps à l’extérieur). Toute personne se trouvant dans cette zone subira ces effets en 2d secondes. Pour éviter de ressentir ses effets, il faut retenir sa respiration. Une pastille n’ayant pas été consumée dure un mois si elle est exposée à l’air, mais sera détruite instantanément si elle est exposée à l’humidité. -2 au jet de compétence, durée de préparation ×2.</p>


		<h4>Efficacité des objets alchimiques</h4>
		<p>L’efficacité de certaines potions est variable. Le MJ peut soit décider de la déterminer aux dés, conformément à la description de la potion, soit prendre note de la MR du jet d’<i>Alchimie</i> au moment de sa fabrication, auquel cas le résultat de chaque dé concernant l’efficacité de la potion sera de [MR+1].</p>

		<h4>Résistance aux potions</h4>
		<p>Il est possible de résister aux potions hostiles comme à des sorts. Le malus au jet de résistance est égale à la MR de l’alchimiste qui a préparé la potion. Si cette MR n’est pas connue, elle vaut 1d-1.</p>

		<h4>Boire plusieurs potions en même temps</h4>
		<p>Deux potions identiques ayant des effets à durée limitée (telles que des potions de Force ou de Dextérité) ne peuvent se cumuler. Si deux potions identiques sont bues, seule la dernière absorbée prendra effet. Des potions différentes ou de soins peuvent se cumuler. Des potions à effet inverse s’annuleront.</p>

		<h4>Potions et fluide</h4>
		<p>L’alchimie fonctionne normalement dans les régions à fluide normal ou élevé. Dans les régions à fluide faible, les élixirs demandent deux fois le laps de temps normal pour être fabriqués, et n’agissent que pendant une durée réduite de moitié, bien que ceux qui possèdent des effets permanents fonctionnent normalement.</p>
	</details>

	<details>
		<summary>
			<h3>Détection et analyse</h3>
		</summary>
		<p>Un élixir est un objet magique et peut être détecté comme tel. Un alchimiste peut également savoir qu’il s’agit d’un élixir (sans connaître sa nature) en l’examinant rapidement et en réussissant un jet d’<i>Alchimie</i>.</p>
		<p>Pour analyser un élixir, un alchimiste doit disposer de son laboratoire et réussir un jet d’<i>Alchimie</i>. L’analyse prend 10 minutes. Sans laboratoire, le jet est à -5.</p>
	</details>

	<details>
		<summary>
			<h3>Fabrication</h3>
		</summary>
		<p>Chaque alchimiste est un expert dans la création d’un certain nombre d’élixirs égal au quart de son score en <i>Alchimie</i> ; tous les autres élixirs nécessitent le recours à des manuels et sont créés à -1.</p>

		<h4>Temps et coût de fabrication</h4>
		<p>La création de chaque élixir nécessite des matériaux et un certain laps de temps. Le laps de temps indiqué correspond au travail effectif de l’alchimiste. Après chaque tranche de 4 heures, l’élixir doit reposer, macérer, refroidir ou être filtré, ce qui demande le reste de la journée. Un alchimiste pourra donc s’occuper de deux élixirs différents chaque jour, pour une journée de 8h de travail.</p>

		<h4>Quantités élaborées</h4>
		<p>Les coûts indiqués correspondent à une dose d’élixir. Un alchimiste peut concocter une fournée de plusieurs doses en même temps, en utilisant plus de matériaux en proportion, mais son jet de compétence final sera à -1 pour chaque dose supplémentaire après la première.</p>

		<h4>Jet de réussite</h4>
		<p><b>Échec&nbsp;:</b> les matériaux sont perdus.</p>
		<p><b>Échec critique&nbsp;:</b> refaire un jet d'<i>Alchimie</i>, à -1 pour chaque dose d’élixir de la fournée, au-delà de la première. En cas de réussite, le désastre est évité ; s’il échoue, faire un jet sur la table ci-dessous.</p>

		<table class="left-2">
			<tr>
				<th width="15%">3d</th>
				<th>Effets</th>
			</tr>
			<tr>
				<td>3-5</td>
				<td>Les potions paraissent réussies, mais elles auront un effet inverse (50%) ou auront les effets d’une dose de poison mortel (50%) lorsqu’elles sont bues.</td>
			</tr>
			<tr>
				<td>6-9</td>
				<td>Tous ceux qui se trouvent dans un rayon de 10 m subiront les effets de l’élixir (50 %), ou ses effets inverses (50 %).</td>
			</tr>
			<tr>
				<td>10-12</td>
				<td>Une explosion détruit le labo ; l’alchimiste a le temps d’évacuer.</td>
			</tr>
			<tr>
				<td>13-15</td>
				<td>Une explosion détruit le labo ; l’alchimiste subit 3d de dégâts.</td>
			</tr>
			<tr>
				<td>16-18</td>
				<td>Une explosion détruit le labo ; l’alchimiste subit 6d de dégâts.</td>
			</tr>
		</table>

		<h4>Laboratoires alchimiques</h4>
		<p><b>Équipement improvisé</b> qui doit inclure au minimum un moyen de faire du feu et un nombre suffisant de récipients propres. -2 à la compétence.</p>
		<p><b>Équipement portable&nbsp;:</b> 8 kg de matériel fragile (à transporter dans un coffre ou autre contenant rigide). -1 à la compétence. </p>
		<p><b>Atelier domestique&nbsp;:</b> table, un équipement simple mais complet. Pas de modificateur s’appliquant à la compétence.</p>
		<p><b>Labo professionnel&nbsp;:</b> pièce de 10 m², un équipement sophistiqué (dont une grande partie volumineuse et fragile). +1 à la compétence.</p>
		<p><b>Labo high tech&nbsp;:</b> pièce de 20 m², un équipement ultrasophistiqué de NT6 au moins, comprenant des chronomètres, des réfrigérateurs, des récipients de chimiste en verre et des instruments de mesure précis. +2 à la compétence.</p>
	</details>
</article>

<!-- Familier -->
<article>
	<h2>Familier</h2>

	<details>
		<summary>
			<h3>Définition</h3>
		</summary>
		<p>Les <i>Familiers</i> sont de petits animaux ou esprits qui veillent au bien-être de leur maître et le servent. Sauf indications contraires, un familier a les caractéristiques normales d’un membre de son espèce. Un personnage ne gagnera pas de points d’expérience pour une session où son familier est mort. Si on lui vole son familier, il doit immédiatement tenter de le retrouver.</p>
	</details>

	<details>
		<summary>
			<h3>Acquérir un familier</h3>
		</summary>
		<p>Pour pouvoir prétendre à un familier, un personnage doit connaître le collège <i>Animalier</i> (les pouvoirs raciaux ne sont pas pris en compte) ou avoir l’avantage <i>Magerie</i> au niveau 3. Il n’est pas possible d’avoir plus d’un familier à la fois.</p>
		<p>Un personnage peut commencer le jeu avec un familier, ou en invoquer un au cours d’une partie&nbsp;: pas de sort particulier, dure une semaine entière pendant laquelle rien d’autre ne pourra être entrepris. Jet d’Int-6. Un jet réussi fait immédiatement apparaître le familier désiré.</p>
		<p>Un familier magique coûte le même nombre de points qu’un animal familier normal (voir <i>Avantages &amp; Désavantages</i> &ndash; PNJ), plus le coût éventuel de ses aptitudes spéciales ci-dessous.</p>
		<h4>Aptitudes spéciales du familier</h4>
		<p><b>• Intelligent (5 à 35 pts)&nbsp;:</b> plus intelligent qu’un animal naturel, comprend le langage humain. 5 pts pour une Int de 7 ; +5 pts par point d’Int supérieur à 7.</p>
		<p><b>• Communication (10 à 15 pts)&nbsp;:</b> Il peut s’agir soit d’une communication mentale (<i>Télépathie</i> permanente) (10 pts), soit d’un discours réel (10 pts et le familier doit également être doté d’une Int &ge; 7), soit les deux (15 pts).</p>
	</details>

	<details>
		<summary>
			<h3>Pouvoirs conférés</h3>
		</summary>
		<p>Si un familier confère un ou des pouvoirs à son maître, ces pouvoirs fonctionnent comme des pouvoirs «&nbsp;normaux&nbsp;» et ne coûtent que la moitié du coût normal en point de personnage. Ils ne peuvent plus être utilisés si le familier est inconscient, et le mage a -1 à son jet de compétence par mètre de distance entre lui et le familier au moment du déclenchement du pouvoir.</p>
		<p>Si le pouvoir conféré est de type <i>Avantage surnaturel</i> (<i>Régénération</i>, <i>Immunité</i>), ses effets sont diminués si le familier est à plus de 30 m ou inconscient, et annulés si celui-ci est à plus de 100 m ou mort.</p>

		<h4>Quelques exemples de pouvoirs</h4>
		<p><b>Réserve de PdM (1 pt par PdM)&nbsp;:</b> Le mage peut tirer des PdM de son familier. Il doit être en contact physique avec ce dernier. Il sera toujours conscient des PdM actuels de son familier lorsqu’il le touchera.</p>
		<p><b>Perception interne (5 pts)&nbsp;:</b> comme le sort.</p>
		<p><b>Métamorphose (8-15 pts)&nbsp;:</b> comme le sort.</p>
	</details>

	<details>
		<summary>
			<h3>Limitations des familiers</h3>
		</summary>
		<p><b>Le mage souffre des blessures de son familier (-15 pts)&nbsp;:</b> Si le familier est blessé, le mage subira le même nombre de points de dégâts. Si le familier est sonné ou assommé, le mage devra faire un jet de San ou il subira les mêmes effets que son compagnon. Si le familier meurt, le mage se retrouve immédiatement à -PdV<sub>max</sub>, avec toutes les conséquences que cela suppose.</p>
		<p><b>Le familier est un démon&nbsp;:</b> cette limitation suppose que le familier n’a pas été invoqué comme tel. Le fait que ce soit un démon est le résultat d’un événement inattendu.<br>
			Il s'agit de l’esprit d’un démon mineur dans le corps d’un animal. Ce démon n’a aucun pouvoir particulier. Il œuvre à ses propres fins, et non pas à celles du mage. Lorsqu’une tâche lui est imposée, un jet réussi d’<i>Int</i> lui permettra de trouver un moyen de pervertir l’ordre du mage. Le familier ne peut causer directement d’ennuis à son maître. Son but est de semer la zizanie et de cultiver le mal. Le coût dépend de l’<i>Int</i> du démon qui vaut au minimum 8&nbsp;: 5×(Int–6).<br>
			Tous les coûts liés à autre chose que l'intelligence s'appliquent normalement. Ainsi, un démon dans le corps d'un corbeau (5 pts pour un familier volant) avec une <i>Int</i> de 8 (-10 pts) permettant une communication mentale (10 pts) revient à 5 pts.</p>
	</details>

</article>