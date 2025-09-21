<!-- Bases du combat -->
<article>
	<h2>Bases du combat</h2>

	<!-- Tour de combat -->
	<details>
		<summary>
			<h3>Tour de combat</h3>
		</summary>
		<p>Chaque <b>tour</b> (ou round) dure trois secondes. Lors d’un tour, un personnage impliqué dans un combat au contact a le droit à <b>deux actions</b> qui sont, dans les cas les plus courants, une attaque et une défense.</p>
	</details>

	<!-- Surprise -->
	<details>
		<summary>
			<h3>Surprise</h3>
		</summary>
		<p>Si l’opposant peut éventuellement être surpris, il doit faire un <b>jet de <i>Réflexes</i></b> pour le déterminer, assorti d’éventuels modificateurs déterminés par le MJ selon la situation.</p>
		<p><b>Réussite&nbsp;:</b> l’opposant n’est pas surpris.</p>
		<p><b>ME &lt; 3&nbsp;:</b> Surprise <i>partielle</i>. Agit en dernier lors du tour.</p>
		<p><b>ME &ge; 3&nbsp;:</b> Surprise <i>totale</i>. N’agit pas lors du premier tour. Au 2<sup>e</sup> tour, -5 au jet d’initiative.</p>
		<p>Un personnage ayant <i>Réflexes de combat</i> ne peut jamais être totalement surpris.</p>
	</details>

	<!-- Initiative -->
	<details>
		<summary>
			<h3>Initiative</h3>
		</summary>

		<p>L’initiative sert à déterminer <i>l’ordre des attaques</i> de chaque protagoniste impliqué dans un combat.</p>

		<p>
			Cet ordre est déterminé par la <b>MR d’un jet de <i>Réflexes</i></b> de chaque protagoniste.<br>
			Il peut être soit redéterminé à chaque round, soit conservé pour les rounds suivants si le MJ le désire, de manière à accélérer le combat.
		</p>

		<p>Certaines situations particulières (une <i>Attaque massive</i> ou une <i>Défense massive</i>, par exemple), peuvent affecter l’initiative.</p>

		<h4>Modificateurs</h4>
		<p>
			À ce jet s’appliquent tous les modificateurs habituels (de fatigue, de blessures, d’encombrement&hellip;) plus un malus dû au poids de l’arme&nbsp;: -1 par kg (arrondir le poids de l’arme à l’entier inférieur).<br>
			Ce malus ne s’applique que si l’arme doit être bougée. Il ne s’applique pas à, par exemple, une arbalète lourde pointant dans la direction de sa cible.
		</p>


		<details>
			<summary>
				<h4>Initiative et sorts</h4>
			</summary>
			<p>Si un lanceur de sort ou un utilisateur de pouvoir est impliqué dans un combat, il doit également faire un jet de <i>Réflexes</i> avec un modificateur qui dépend du <i>Temps nécessaire</i> au lancer du sort.</p>
			<table>
				<tr>
					<th>Temps nécessaire</th>
					<th>Modificateur</th>
				</tr>
				<tr>
					<td>0</td>
					<td>0</td>
				</tr>
				<tr>
					<td>1 s</td>
					<td>-3</td>
				</tr>
				<tr>
					<td>2 s</td>
					<td>-6</td>
				</tr>
				<tr>
					<td>3 s</td>
					<td>tour suivant* +0</td>
				</tr>
				<tr>
					<td>4 s</td>
					<td>tour suivant* -3</td>
				</tr>
				<tr>
					<td>5 s</td>
					<td>tour suivant* -6</td>
				<tr>
					<td>6 s</td>
					<td>2 tours après** +0</td>
				</tr>
			</table>
			<p>
				* Le sort prend un tour complet pour être lancé. Le modificateur s’applique au jet de <i>Réflexes</i> du tour suivant.<br>
				** Le sort prend deux tours à être préparé. Le modificateur s’applique au jet de <i>Réflexes</i> au tour correspondant.
			</p>
		</details>

		<h4>Armes de taille très différentes</h4>
		<p>L’attaquant ayant l’arme la plus courte doit d’abord réussir une défense contre l’arme la plus longue avant de pouvoir s’approcher et attaquer.</p>

		<details class="exemple">
			<summary>Exemple</summary>
			<p>Un combattant C fait face à 2 opposants O1 et O2. Il est associé à un mage M. Le mage lance un sort dont le <i>Temps nécessaire</i> est de 1 seconde. Pour déterminer l’ordre des attaques, chaque protagoniste fait un jet de <i>Réflexes</i> (le mage le fait à -3). Le premier à agir est celui qui a la plus grande MR, puis vient le tour de celui qui a la deuxième meilleure MR, etc.</p>
		</details>

	</details>

	<!-- Déroulement d’un tour de combat -->
	<details>
		<summary>
			<h3>Déroulement d’un tour de combat</h3>
		</summary>
		<p>Les différents protagoniste d’un combat au contact portent leur <b>attaque dans l’ordre de l’initiative</b>.</p>
		<p>Un combattant impliqué dans un combat au contact a le droit à <b>deux actions</b> par tour.</p>
		<ul>
			<li><b>attaque + défense&nbsp;:</b> cas le plus courant.</li>
			<li><b>2 défenses&nbsp;:</b> si ça devient très chaud.</li>
			<li><b>2 attaques&nbsp;:</b> seulement si son adversaire ne peut pas attaquer (s’il est sonné, par exemple).</li>
			<li class="clr-invalid"><b>2 attaques&nbsp;:</b> règles en cours de test. Le combattant peut <i>toujours</i> choisir 2 actions attaques.</li>
		</ul>
		<p>Il a également le droit de faire jusqu’à <b>2 défenses d’urgence</b> par tour. Elles ne comptent pas comme des actions. Voir la section <i>Défense</i>.</p>
		<p>Au cours d’un tour de combat, la <b>vitesse</b> maximale de déplacement est de 1&nbsp;m/s, sauf en cas de <i>Déplacement</i> (voir paragraphe ci-dessous).</p>
		<p>Le joueur <i>peut</i> choisir de faire une <b>attaque massive</b> <i>ou</i> une <b>défense massive</b> lors d’un tour (mais pas les deux au cours du même tour).</p>
	</details>

	<!-- Déplacement -->
	<details>
		<summary>
			<h3>Déplacement</h3>
		</summary>
		<p>Si le personnage choisit de se déplacer à une vitesse supérieure à 1&nbsp;m/s&nbsp;:</p>
		<ul>
			<li>il conserve ses <b>2 actions</b> (+ 2 défenses d’urgences)</li>
			<li><b>malus de -3</b> à toutes ses attaques et défenses</li>
			<li>vitesse limitée à <b>50&nbsp;%</b> de sa <i>Vitesse</i></li>
		</ul>
	</details>
</article>

<!-- Attaque au contact -->
<article>
	<h2>Attaque au contact</h2>

	<!-- Modificateurs d’attaque -->
	<details>
		<summary>
			<h3>Modificateurs d’attaque</h3>
		</summary>
		<p>Un jet d’attaque est soumis aux modificateurs suivants&nbsp;:</p>
		<ol class="bold-bullet">
			<li><b>État du personnage&nbsp;:</b> paramètres de base + heaume, armures superposées, usage de la main «&nbsp;faible&nbsp;».</li>
			<li><b>Fmin de l’arme&nbsp;:</b> voir <a href="/armes-armures">Armes &amp; armures</a>.</li>
			<li><b><i>Attaque Massive</i></b> (voir ci-dessous).</li>
			<li><b>Difficulté de l’attaque&nbsp;:</b> position de l’attaquant, taille de la cible, localisation, etc, au jugé du MJ.</li>
		</ol>
		<p>À moins d’une bonne raison, en situation de combat «&nbsp;classique&nbsp;», une attaque se fera sans malus de difficulté.</p>
	</details>

	<!-- Attaque massive -->
	<details>
		<summary>
			<h3>Attaque massive</h3>
		</summary>
		<p>Un attaquant peut choisir de porter une attaque <i>massive</i> plutôt qu’une attaque normale. Ce choix peut se faire <i>en cours</i> de tour.</p>
		<p>Cela a pour effet de rendre son attaque plus efficace, mais son action suivante (qui ne pourra être ni une attaque massive, ni une défense massive) sera pénalisée.</p>

		<table class="left-1 fs-300 mt-½">
			<tr>
				<th></th>
				<th>Bénéfices</th>
				<th width="35%">Conséquences</th>
			</tr>
			<tr>
				<th>Précise</th>
				<td>+4 au jet d’attaque</td>
				<td rowspan="4">-3 à la prochaine action <b>et</b> attaque en dernier lors du prochain tour.</td>
			</tr>
			<tr>
				<th>Puissante</th>
				<td>+1 aux dégâts par dé (min. +2)</td>
			</tr>
			<tr>
				<th>Multiple</th>
				<td>2 attaques au lieu d’une seule<sup>(1)</sup></td>
			</tr>
			<tr>
				<th>Feintée</th>
				<td>Pas de limite de MR à l’attaque</td>
			</tr>
		</table>
		<p class="fs-300">(1) avec une arme de taille à apprêter (hache, hallebarde), il n’est pas possible de faire deux attaques, mais il est possible d’affecter plusieurs cibles proches en un seul mouvement (que l’on traite avec deux jets d’attaque séparés). Un combattant humain est limité à 2 cibles, mais une créature plus grande peut en affecter plus (décision du MJ).</p>
	</details>

	<!-- Coups spéciaux -->
	<details>
		<summary>
			<h3>Coups spéciaux</h3>
		</summary>
		<p><b>Désarmer l’adversaire&nbsp;:</b> -3 au jet d’attaque ou de parade</p>
		<p><b>Bloquer l’arme d’un adversaire&nbsp;:</b> maintenir une pression sur l’arme de l’adversaire, l’obligeant à garder le contact ou à reculer. -3 au jet d’attaque ou de parade</p>
		<p><b>Attaque non conventionnelle&nbsp;:</b> utiliser son arme de manière inhabituelle (la garde, le manche, etc.). Les dégâts sont à évaluer en fonction du type de coup. -2 au jet d’attaque. L’adversaire doit réussir un jet de <i>Réflexes</i> pour avoir le droit à une défense.</p>
		<p><b>Amortir ses coups&nbsp;:</b> pour causer des dégâts inférieurs aux dégâts normaux. Le joueur annonce ses dégâts sous forme de «&nbsp;dés + bonus&nbsp;». Frapper avec le plat d’une épée, le bout arrondi d’une lance, etc.&nbsp;: le type de dégâts qui change (<i>Broyage</i>).</p>
	</details>

	<!-- Attaque avec deux armes -->
	<details>
		<summary>
			<h3>Attaque avec 2 armes</h3>
		</summary>
		<p>Attaquer avec une 2<sup>e</sup> arme après une parade est considéré comme une <i>Attaque non conventionnelle</i>.</p>
		<p>Parade à deux armes simultanées&nbsp;: si les deux scores de parade sont différents de 3 ou moins, le défenseur obtient +1 sur le meilleur score de parade. Si les deux scores de parade sont égaux, il obtient un +2.</p>
	</details>

	<!-- Attaque à mains nues -->
	<details>
		<summary>
			<h3>Attaques à mains nues</h3>
		</summary>

		<h4>Manœuvres d’attaque</h4>
		<p>Une attaque à mains nues peut avoir plusieurs objectifs différents&nbsp;: causer des dégâts, saisir son adversaire, le faire tomber&hellip; Lorsque vous porter une attaque à mains nues, vous devez choisir une des manœuvres ci-dessous.</p>

		<!-- Porter un coup -->
		<details>
			<summary>
				<h5>Porter un coup</h5>
			</summary>
			<p>Dans le but d’infliger des dégâts. Jet de <i>Combat à mains nues</i> ou de <i>Karaté</i>. Ce type d’attaque est traitée comme une attaque avec une arme.</p>
		</details>

		<!-- Bousculer -->
		<details>
			<summary>
				<h5>Bousculer</h5>
			</summary>
			<p>Dans le but de faire tomber l’adversaire par la force. Ce type d’attaque se traite en deux étapes, qui comptent comme une seule action.</p>
			<ol>
				<li><b>Attaque</b> basée sur <i>Combat à mains nues</i> ou <i>Judo/lutte</i>. L’adversaire peut y opposer une défense normale.</li>
				<li>Manœuvre <b><i>Faire tomber</i></b> (voir ci-après).</li>
			</ol>
		</details>

		<!-- Saisir -->
		<details>
			<summary>
				<h5>Saisir</h5>
			</summary>
			<p>Saisir son adversaire, dans le but de le gêner dans sa défense et ses attaques, de faciliter ses propres attaques, ou pour ensuite lui faire une prise. La saisie se fait avec la compétence <i>Combat à mains nues</i> ou <i>Judo/lutte</i>. Le défenseur peut y opposer une défense classique.</p>
		</details>

		<!-- Faire tomber -->
		<details>
			<summary>
				<h5>Faire tomber (prérequis)</h5>
			</summary>
			<p>Faire tomber son adversaire. Cette action nécessite d’avoir d’abord réussit une <i>bousculade</i> ou une <i>saisie</i>. On peut provoquer la chute soit par l’adresse, soit par la force. Les combo {bousculer + faire tomber} et {saisir + faire tomber} ne comptent que comme une seule action.</p>
			<table class="mt-½">
				<tr>
					<th></th>
					<th>Adresse</th>
					<th>Force</th>
				</tr>
				<tr>
					<th>Attaque</th>
					<td><i>Combat à mains nues</i>, <i>Judo/lutte</i></td>
					<td><i>For</i></td>
				</tr>
				<tr>
					<th>Défense*</th>
					<td><i>Dex</i>-3 (+1 si <i>Réflexes de combat</i>), <i>Judo/lutte</i></td>
					<td><i>For</i>, <i>Judo/lutte</i></td>
				</tr>
			</table>
			<p>* Comme dans le cas d’une attaque classique, la MR de l’attaque se transforme en malus au jet de défense, avec une limite de 5.</p>
			<p>Cette manœuvre compte comme une action, si elle fait suite à une <i>Saisie</i>. Si elle fait suite à une <i>Bousculade</i>, elle en est la continuité et n’est pas considérée comme une action supplémentaire.</p>
		</details>

		<!-- Immobiliser -->
		<details>
			<summary>
				<h5>Immobiliser (prérequis)</h5>
			</summary>
			<p>Cette manœuvre nécessite l’utilisation des deux mains. Elle doit nécessairement faire suite à une <i>Saisie</i> ou avoir lieu après avoir fait tombé l’adversaire (manœuvre <i>Faire tomber</i>).</p>
			<p>Elle compte comme une action.</p>
			<p>Elle peut s’appuyer sur l’adresse ou sur la force.</p>
			<table class="mt-½">
				<tr>
					<th></th>
					<th>Adresse</th>
					<th>Force</th>
				</tr>
				<tr>
					<th>Attaque</th>
					<td><i>Judo/lutte</i></td>
					<td><i>For</i></td>
				</tr>
				<tr>
					<th>Défense*</th>
					<td><i>Dex</i>, <i>Judo/lutte</i></td>
					<td><i>For</i>, <i>Judo/lutte</i></td>
				</tr>
			</table>
			<p>* Comme dans le cas d’une attaque classique, la MR de l’attaque se transforme en malus au jet de défense, avec une limite de 5.</p>
			<p>Après un premier échec à une tentative de <i>Défense</i>, l’attaquant n’a plus besoin de faire de jet d’attaque et la défense se fait automatiquement à -5.</p>
		</details>


		<h4>Attaque massive</h4>
		<p>Il est possible de choisir une des options d’<i>Attaque massive</i> décrites plus haut</p>

		<h4>Attaque d’un adversaire armé</h4>
		<p>Si l’adversaire réussit sa parade, il inflige demi-dégâts à l’attaquant (prendre en compte la RD). Pour éviter d’être blessé, l’attaquant doit réussir une <i>Parade</i> ou une <i>Esquive</i>. Ce jet fait partie de l’action d’attaque. Il ne compte pas comme une action, et n’est pas non plus une <i>défense d’urgence</i> (voir ce terme dans la section <i>Défense</i>).</p>
	</details>

	<!-- Dégâts à mains nues -->
	<details>
		<summary>
			<h3>Dégâts à mains nues</h3>
		</summary>
		<p>Pour les humains&nbsp;:</p>
		<ul>
			<li>Coup de poing&nbsp;: B.e-2</li>
			<li>Coup de pied&nbsp;: B.e, +1 avec des bottes pesantes.</li>
			<li>Coup de genou&nbsp;: B.e-1.</li>
			<li>Coup de tête&nbsp;: B.e-1. Si l’attaque est ratée de plus de 3, l’attaquant subit la moitié des dégâts qu’il aurait dû infliger.</li>
		</ul>
		<p>Avec la compétence <i>Karaté</i>&nbsp;: +1/5<sup>e</sup> du score de la compétence aux dégâts (sauf pour le coup de tête).
	</details>

</article>

<!-- Attaque à distance -->
<article>
	<h2>Attaque à distance</h2>

	<!-- Modificateurs d’attaques -->
	<details>
		<summary>
			<h3>Modificateurs d’attaque</h3>
		</summary>
		<ol class="bold-bullet">
			<li><b>État du personnage&nbsp;:</b> comme attaque au contact.</li>
			<li><b>Fmin de l’arme&nbsp;:</b> voir <a href="/armes-armures">Armes &amp; armures</a>.</li>
			<li><b>Difficulté&nbsp;:</b> taille et mouvement de la cible, distance, condition de visée, etc. au jugé du MJ.</li>
			<li><b>Recul&nbsp;:</b> en cas de tir multiple avec une arme à feu.</li>
		</ol>

		<h4>Estimer la difficulté</h4>
		<p>La <i>Portée utile</i> d’une arme à distance est la distance à laquelle une cible de la taille d’un torse humain est atteint sur un jet de difficulté <i>Moyenne</i> et dans des conditions idéales de visée (minimum 3 secondes, davantage si l’arme a une lunette de visée, l’arme doit être tenue dans les conditions idéales).</p>
		<p>Dans les mêmes conditions de visée, un changement de portée entraîne un modificateur selon la progression logarithmique suivante, à un facteur 10<sup><i>n</i></sup> près&nbsp;: 1&nbsp;; 1,5&nbsp;; 2&nbsp;; 3&nbsp;; 5&nbsp;; 7.</p>

		<details class="exemple">
			<summary>Exemple de changement de portée</summary>
			<p>Un pistolet a une portée utile de 15 m. Dans des condition idéales de visée, une distance différentes apportera les modificateurs suivants&nbsp;:</p>
			<table>
				<tr>
					<th>Distance</th>
					<th>Modif.</th>
					<th>Distance</th>
					<th>Modif.</th>
				</tr>
				<tr>
					<td>15÷1,5 = 10</td>
					<td>+1</td>
					<td>15×1,5 = 22,5</td>
					<td>-1</td>
				</tr>
				<tr>
					<td>15÷2 = 7,5</td>
					<td>+2</td>
					<td>15×2 = 30</td>
					<td>-2</td>
				</tr>
				<tr>
					<td>15÷3 = 5</td>
					<td>+3</td>
					<td>15×3 = 45</td>
					<td>-3</td>
				</tr>
				<tr>
					<td>15÷5 = 3</td>
					<td>+4</td>
					<td>15×5 = 75</td>
					<td>-4</td>
				</tr>
				<tr>
					<td>15÷7 = 2</td>
					<td>+5</td>
					<td>15×7 = 105</td>
					<td>-5</td>
				</tr>
			</table>
		</details>

		<p>Si le tireur n’est pas dans des conditions idéales de visée (cible plus petite qu’un torse humain, en mouvement, temps de visée raccourci, pistolet tenu à une main, &hellip;), il revient au MJ d’estimer la difficulté du tir.</p>

	</details>

	<!-- Tirer avec une arme à feu -->
	<details>
		<summary>
			<h3>Tirer avec une arme à feu</h3>
		</summary>
		<p>Il faut une seconde pour avoir une visée minimale. Sans cette visée, la difficulté du tir est sérieusement augmentée.</p>
		<p>Une arme peut tirer VdT balles par seconde. Le 2<sup>e</sup> tir subit une pénalité de Rcl, le 3<sup>e</sup> de 2×Rcl et les tirs suivants de 3×Rcl.</p>
		<p>Il faut arrêter de tirer pendant une seconde pour annuler cette pénalité.</p>
	</details>

	<!-- Tirer en rafale -->
	<details>
		<summary>
			<h3>Tirer en rafale</h3>
		</summary>
		<p>Lors d’un tir en rafale, le nombre de balles qui atteignent la cible dépend du <i>Rcl</i> de l’arme, du nombre de balles que compte la rafale et de la MR du tir. Utiliser le widget de la <a href="table-jeu">Table de jeu</a>.</p>
		<p>Si le tireur n’a pas visé avant son tir et que le décor permet de voir où il tire, appliquer un bonus de +2 si plus de 3 balles sont tirées lors de la rafale.</p>

		<h4>Tir d’arrosage</h4>
		<p><b>Cible unique&nbsp;:</b> +3 au tir, mais le nombre de balles qui touchent la cible est divisée par deux.</p>
		<p><b>Plusieurs cibles proches&nbsp;:</b> pas de bonus au tir. Le nombre de balles qui atteignent leur cible est également divisée par deux, mais elles sont réparties entre les différentes cibles visées.</p>

		<h4>Recul en cas de tir en rafale</h4>
		<p>Si la compétence du tireur est inférieure à 12, la pénalité de Rcl est augmentée de 1.</p>

		<!-- <h4>Malfonction en rafale</h4>
		<p>Lors de rafales longues, l’arme chauffe, augmentant ainsi la probabilité d’un enrayement. Pour les armes d’infanterie, le score de <i>Mlf</i> est diminué de 1 pour chaque tranche complète de 10 balles tirées au-delà des 10 premières balles. Cette dégradation est plus lente pour les armes lourdes.</p> -->

	</details>

</article>

<!-- Défense -->
<article>
	<h2>Défense</h2>

	<!-- Types de défenses -->
	<details>
		<summary>
			<h3>Types de défense</h3>
		</summary>
		<ul class="mt-1">
			<li><b>Esquive&nbsp;:</b> compétence <i>Esquive</i></li>
			<li><b>Blocage&nbsp;:</b> compétence <i>Bouclier</i> -3 + DP</li>
			<li><b>Parade&nbsp;:</b> compétence <i>Arme</i> -3*</li>
		</ul>
		<p>*généralement, ce malus vaut -3, mais il y a des exceptions, mentionnées dans la <a href="/armes-armures">table des armes</a>. Une parade est possible seulement si l’arme est apprêtée.</p>
	</details>

	<!-- Nombre de défenses -->
	<!-- <details>
		<summary>
			<h3>Nombre de défenses par tour</h3>
		</summary>
		<p>Un combattant a droit à <b>une défense par tour</b>. S’il renonce à attaquer, il a droit à une <b>deuxième défense</b>.</p>
		<p>Pour avoir le droit à un jet de défense, le personnage ne doit <b>pas être surpris</b> par l’attaque.</p>
		<p>Un défenseur ne peut opposer qu’<b>une seule défense par attaque</b> (sauf en cas de <i>Défense massive</i> – voir ci-dessous).</p>
	</details> -->

	<!-- Défense d’urgence -->
	<details>
		<summary>
			<h3>Défense d’urgence</h3>
		</summary>

		<p>Il est permis d’avoir jusqu’à <i>deux</i> défenses supplémentaires par tour, en plus des deux actions «&nbsp;de droit&nbsp;». Elles sont qualifiées de <i>défenses d’urgence</i> et suivent les règles ci-dessous. Ces défenses ne sont pas comptées comme des actions.</p>
		<ul class="ta-justify">
			<li>Ces défenses subissent un<b> malus supplémentaire</b>&nbsp;: -2 pour la première et -4 pour la seconde.</li>
			<li>L’action précédant la défense d’urgence, ainsi que l’action suivante ne peuvent pas être des <b>attaques massives</b>.</li>
			<li>L’arme ou le bouclier utilisé pour cette défense ne doit <b>pas avoir été utilisé</b> lors de l’action précédente et ne pourront pas être utilisé pour l’action suivante.</li>
		</ul>

		<h4>Attaque et défense simultanées</h4>
		<p>Il peut arriver que, après détermination de l’initiative, deux combattants s’attaquent mutuellement au même moment, ou bien qu’un combattant attaque son ennemi au moment où un deuxième opposant l’attaque lui-même. Dans ce cas, puisque la défense se fait au même moment que l’attaque, cette défense <i>devra</i> être une <i>défense d’urgence</i>, même si le combattant n’a, à ce stade, pas encore effectué ses deux actions.</p>
		<p>Cette défense d’urgence sera comptabilisée comme telle et entrera donc dans la limite des deux défenses d’urgence par round. Le combattant aura par la suite le droit d’effectuer une action de défense normalement s’il le doit.</p>

		<details class="exemple mt-1">
			<summary>Exemple</summary>

			<p>Un combattant C fait face à 2 opposants (O1 et O2). Il arrive en 2<sup>e</sup> dans l’ordre d’initiative. Voici un déroulement possible du tour.</p>
			<p>On note <i>défense+</i> la première défense d’urgence, et <i>défense++</i> la deuxième défense d’urgence.</p>

			<ul>
				<li><b>O1 – attaque C</b></li>
				<li>C – défense</li>
				<li><b>C – attaque O1</b></li>
				<li><b>O2 – attaque</b></li>
				<li>C – défense+</li>
			</ul>

			<p class="mt-1">Un combattant C fait face à 3 opposants (O1, O2 et O3). Il arrive en 3<sup>e</sup> dans l’ordre d’initiative. Voici un déroulement possible du tour si C choisit d’attaquer.</p>

			<ul>
				<li><b>O1 – attaque</b></li>
				<li>C – défense</li>
				<li><b>O2 – attaque</b></li>
				<li>C – défense+</li>
				<li><b>C – attaque O1</b></li>
				<li>O1 – défense</li>
				<li><b>O3 – attaque</b></li>
				<li>C – défense++</li>
			</ul>

			<p>La même configuration, mais C choisit de se défendre plutôt que d’attaquer.</p>
			<ul>
				<li><b>O1 – attaque</b></li>
				<li>C – défense</li>
				<li><b>O2 – attaque</b></li>
				<li>C – défense (pas d’attaque)</li>
				<li><b>O3 – attaque</b></li>
				<li>C – défense+</li>
			</ul>
			<p>On remarque que cette stratégie permet à C de remplacer la défense d’urgence n°2 par une défense normale.</p>
		</details>

	</details>

	<!-- Modificateurs de défenses -->
	<details>
		<summary>
			<h3>Modificateurs de défense</h3>
		</summary>
		<p><b>1. État du personnage&nbsp;:</b> comme pour <i>Attaque au contact</i>. -4 s’il est <i>sonné</i>.</p>
		<p><b>2. <i>Défense massive</i>&nbsp;:</b> voir ci-dessous.</p>
		<p><b>3. MR de l’attaquant&nbsp;:</b> se transforme en malus au jet de défense. Limité à -5.</p>
		<p><b>4. Conditions de défense&nbsp;:</b> déséquilibre, obscurité, position du défenseur, au jugé du MJ.</p>
	</details>

	<!-- Défense massive -->
	<details>
		<summary>
			<h3>Défense massive</h3>
		</summary>
		<p>Un défenseur peut choisir d’effectuer une défense massive plutôt qu’une défense normale. Ce choix peut se faire en cours de tour pour les défenses <i>reculée</i> ou <i>multiple</i>.</p>

		<p>Cela a pour effet de rendre sa défense plus efficace, mais nécessite certaines exigences et/ou a certaines conséquences pour l’action suivante.</p>

		<table class="left-1 fs-300 mt-½">
			<tr>
				<th></th>
				<th>Bénéfices</th>
				<th>Exigences / conséquences</th>
			</tr>
			<tr>
				<th>Préparée</th>
				<td>+2 au jet de défense</td>
				<td rowspan="2">avoir <i>volontairement</i> laissé son adversaire attaquer en premier.</td>
			</tr>
			<tr>
				<th>Feintée</th>
				<td>+2 à l’attaque suivante (initiative automatique)</td>
				<!-- cellule fusionnée -->
			</tr>
			<tr>
				<th>Rupture</th>
				<td><i>Esquive</i> +3 pour quitter le combat. Cette esquive s’oppose à toutes les attaques du tour.</td>
				<td>aucune attaque possible pour le reste du tour. Agit en dernier au prochain tour.</td>
			</tr>
			<tr>
				<th>Reculée</th>
				<td>+2 au jet de défense</td>
				<td>reculer de 1 m, -3 au jet d’attaque suivant, agit en dernier au prochain tour.</td>
			</tr>
			<tr>
				<th>Multiple</th>
				<td>2 défenses différentes pour une même attaque, comptant comme une seule action</td>
				<td>-3 au jet d’attaque suivant, agit en dernier au prochain tour.</td>
			</tr>
		</table>
	</details>

	<!-- Contre une attaque à distance -->
	<details>
		<summary>
			<h3>Contre une attaque à distance</h3>
		</summary>
		<p>Il est possible d’opposer une défense à une attaque à distance, si le défenseur n’est pas surpris.</p>
		<p><b>Armes lancées (couteau, lance, sorts projectile, etc.)&nbsp;:</b> il faut d’abord réussir un jet de <i>Réflexes</i>, puis une <i>Esquive</i> ou un <i>Blocage</i> à -2. Il est possible de <i>parer</i> de grosses armes de jets (lance ou hache) à -2.</p>
		<p><b>Armes à projectiles&nbsp;:</b> dans le cas d’un style de jeu «&nbsp;cinématographique&nbsp;», si le projectile est visible, que la cible n’est pas surprise et que la distance de tir est «&nbsp;raisonnable&nbsp;», le personnage peut tenter d’esquiver le projectile à -5, après avoir réussi un jet de <i>Réflexes</i>.</p>
	</details>

	<!-- Défenses à mains nues -->
	<details>
		<summary>
			<h3>Défenses à mains nues</h3>
		</summary>
		<ul>
			<li><b>Éviter un coup, une bousculade ou une saisie&nbsp;:</b> <i>Défense</i> classique.</li>
			<li><b>Parer une arme&nbsp;:</b> possible seulement avec les compétences <i>Karaté</i> et <i>Judo/lutte</i>.</li>
			<li>Se libérer d’une <b>saisie</b> ou d’une <b>immobilisation</b>, ou s’opposer à une manœuvre «&nbsp;<b><i>Faire tomber</i></b>&nbsp;»&nbsp;: voir le paragraphe <i>Attaques à mains nues</i>.</li>
		</ul>

		<p>Il est possible de choisir de faire une <i>Défense massive</i>.</p>
	</details>

	<!-- Parer ou bloquer un coup puissant -->
	<!-- <details>
		<summary>
			<h3>Parer ou bloquer un coup puissant</h3>
		</summary>
		<p>Si l’arme pare une arme 3 fois plus lourde, elle a 33% de chance de se briser</p>
		<p class="clr-invalid">À developper</p>
	</details> -->

</article>

<!-- Localisation -->
<article>
	<h2>Localisation</h2>
	<details>
		<summary>
			<h3>Localisation aléatoire</h3>
		</summary>
		<p class="ta-center italic">Utiliser la <a href="/table-jeu">table de jeu</a></p>
	</details>
	<details>
		<summary>
			<h3>Choisir une localisation</h3>
		</summary>
		<p>Si l’attaquant vise, le malus de difficulté est estimé par le MJ. Si l’attaque est ratée de 1, une autre localisation, déterminée aléa&shy;toirement, est atteinte.</p>
		<p><b>Malus typiques&nbsp;:</b> en combat à l’arme blanche, viser une jambe ou un bras se fait à -3&nbsp;; la tête à -4&nbsp;; le visage, un organe vitale ou une main à -5, le torse à 0.</p>
		<p>Le cœur ne peut être atteint que par une attaque <i>perforante</i> ou par balle.</p>
	</details>
</article>

<!-- Critiques -->
<article>
	<h2>Coups critiques &amp; Maladresses</h2>

	<details>
		<summary>
			<h3>Réussite critique en attaque</h3>
		</summary>
		<p>Une <b>attaque avec une réussite critique</b> impose de faire un jet de défense sans malus, mais qui doit être lui aussi une réussite critique.</p>
		<p>Les effets de la réussite critique sont gérés par la <a href="/table-jeu">Table de jeu</a>.</p>
	</details>
	<details>
		<summary>
			<h3>Échec critique en attaque</h3>
		</summary>
		<p>Voir le widget correspondant sur la <a href="/table-jeu">Table de jeu</a>.</p>
	</details>
	<details>
		<summary>
			<h3>Réussite critique en défense</h3>
		</summary>
		<p>La défense est automatiquement réussie et impose à l’attaquant un jet sur la table des <i>Échecs critiques</i>.</p>
	</details>
	<details>
		<summary>
			<h3>Échec critique en défense</h3>
		</summary>
		<p>Voir le widget correspondant sur la <a href="/table-jeu">Table de jeu</a>.</p>
		<p>Si la défense était une esquive, utiliser l’option <i>Échec critique en déplacement</i>.</p>
	</details>

</article>

<!-- Explosions -->
<article>
	<h2>Explosions</h2>

	<!-- Onde de choc -->
	<details>
		<summary>
			<h3>Onde de choc</h3>
		</summary>

		<p>La puissance de l’onde de choc provoquée par l’explosion décroit avec la distance. Les calculs sont gérés par la <a href="table-jeu">Table de jeu</a>.</p>
		<p>Un être humain debout et de face présente une surface de 0,75 m² aux fragments projetés.</p>
		<p>La décroissance de l’onde de choc dépend du milieu dans lequel a lieu l’explosion. Par défaut, il s’agit de l’air à pression atmosphérique. Dans l’eau, diviser la distance réelle par 3. Dans le vide, la multiplier par 3.</p>

		<h4>Résistance aux dégâts</h4>
		<p>Prendre en compte la RD du torse seulement, pour les dégâts de concussions. Les dégâts dus à d’éventuels fragments doivent être localisés.</p>

		<h4>Effets des dégâts</h4>
		<p>La <a href="table-jeu">Table de jeu</a> gère les effets spéciaux des dégâts d’explosion.</p>

	</details>

	<!-- Éclats et fragmentation -->
	<details>
		<summary>
			<h3>Éclats et fragmentation</h3>
		</summary>
		<p>Ces dégâts sont dus à la projection d’éclats.</p>

		<h4>Dégâts infligés</h4>
		<p>Pour des explosifs n’ayant pas d’effets de fragmentation propre, les dégâts varient selon le type de terrain sur lequel a lieu l’explosion.</p>
		<ul>
			<li>des petits cailloux, des éclats de bois ou de verre causeront de 1d-3 à 1d pts de dégâts</li>
			<li>des éclats d’acier, des boulons, etc. causeront de 1d+2 à 2d pts de dégâts.</li>
			<li>pour des explosifs à fragmentation, les dégâts sont spécifiés (typiquement 2d pour une grenade à fragmentation).</li>
		</ul>
		<p>Les dégâts de fragmentation sont de type <i>Tranchant</i>, l’armure protège normalement.</p>

	</details>

	<!-- Souffle et projection -->
	<details>
		<summary>
			<h3>Souffle et projection</h3>
		</summary>
		<p>Une explosion suffisamment forte peut également causer des dégâts en projetant les victimes dans les airs.</p>
		<p>Ces dégâts sont à traiter comme une chute. La <a href="/table-jeu">Table de jeu</a> vous indiquera quelle est la hauteur de chute.</p>
	</details>

	<!-- Explosion en espace confiné -->
	<details>
		<summary>
			<h3>Explosion en espace confiné</h3>
		</summary>
		<p>Il faut dans un premier temps estimer la fraction de l’énergie retenue par le volume confiné. Ce n’est pas la même si le volume est entièrement scellé par des parois rigide et solide, ou s’il est en partie fermé par des fenêtres qui exploseront et laisseront passer une partie du souffle.</p>
		<p>Il faut ensuite estimer la distance moyenne entre le centre du volume et les parois. Par exemple, pour une explosion qui a lieu dans un container fermé de 2&nbsp;m × 3&nbsp;m × 6&nbsp;m, cette distance moyenne est de (2÷2 + 3÷2 + 6÷2)/3 = 1,8&nbsp;m.</p>
		<p>Enfin, les dégâts <i>supplémentaires</i> dus au caractère confiné de l’explosion sont obtenus en considérant une deuxième explosion qui a lieu à cette distance de la cible.</p>
	</details>

</article>

<!-- Dégâts aux objets -->
<article>
	<h2>Dégâts aux objets</h2>

	<!-- Caractéristiques -->
	<details>
		<summary>
			<h3>Caractéristiques des objets</h3>
		</summary>
		<p>Les caractéristiques régissant la manière dont un objet supporte des dégâts sont&nbsp;:</p>
		<ul>
			<li><b>Résistance aux dégâts (RD)&nbsp;:</b> même principe qu’une armure.</li>
			<li><b>Points de Structure (PdS)&nbsp;:</b> ce sont les «&nbsp;PdV&nbsp;» de l’objet.</li>
			<li><b>Intégrité&nbsp;:</b> c’est la «&nbsp;Santé&nbsp;» de l’objet. Plus elle est élevée, mieux l’objet continue à fonctionner malgré les dégâts reçus.</li>
		</ul>
		<details class="exemple">
			<summary>Exemple</summary>
			<p>
				Un robot type R2D2 pourrait avoir 8 PdS et une <i>Intégrité</i> de 10 (il n’est pas particulièrement résistant).<br>
				Il aurait une RD de 4, sauf sur certains capteurs en verre qui auraient une RD de 1 ou 2.
			</p>
		</details>
	</details>

	<!-- Types de dégâts -->
	<details>
		<summary>
			<h3>Types de dégâts</h3>
		</summary>
		<p>Il existe 2 types de dégâts affectant les objets.</p>
		<ul>
			<li><b>Dégâts localisés&nbsp;:</b> ils n’affectent qu’une zone très petite par rapport à la taille d’un objet. Ils n’affectent pas l’état général de l’objet mais sont capables de causer des effets secondaires (voir <i>Effets des dégâts</i>). Le MJ décide en fonction du type d’attaque et de la taille de l’objet si les dégâts infligés sont «&nbsp;localisés&nbsp;» ou pas.</li>
			<li><b>Dégâts normaux&nbsp;:</b> tous les autres types de dégâts.</li>
		</ul>
	</details>

	<!-- Effets des dégâts -->
	<details>
		<summary>
			<h3>Effets des dégâts</h3>
		</summary>
		<p>Les dégâts reçus par un objet ont des <b>effets généraux</b> (sauf s’ils sont «&nbsp;<i>localisés</i>&nbsp;») et peuvent entraîner des <b>effets secondaires</b>.</p>
		<p>Tous les calculs sont gérés par la <a href="table-jeu"><i>Table de jeu</i></a>.</p>

		<h4>Dégâts reçus</h4>
		<p>Les dégâts infligés sont retirés des PdS de l’objet (sauf s’il s’agit de dégâts <i>localisés</i>) en tenant compte de sa RD «&nbsp;générale&nbsp;».</p>

		<h4>État général de l’objet</h4>

		<ul>
			<li><b>Légèrement endommagé&nbsp;:</b> l’objet est légèrement abîmé (déformation, fissure) mais continue de remplir sa fonction normalement (sauf en cas d’effets secondaires).</li>
			<li><b>Moyennement endommagé&nbsp;:</b> l’objet est abîmé mais est encore globalement fonctionnel, au moins pendant un certain temps. Si c’est un objet étanche, il présente quelques petites brèches ne mettant pas en péril sa survie immédiate.</li>
			<li><b>Gravement endommagé&nbsp;:</b> l’objet est très abîmé. Il ne fonctionne plus qu’en partie (au tiers de son potentiel). Beaucoup de systèmes ne fonctionnent plus. Si c’est un objet étanche, il présente une ou plusieurs brèches ne pouvant pas être réparée(s) de manière improvisée.</li>
			<li><b>Hors service&nbsp;:</b> l’objet est inutilisable, mais, avec le matériel, le temps et les compétences nécessaires, il est réparable.</li>
			<li><b>Détruit&nbsp;:</b> l’objet est endommagé au point d’être irréparable. Ce n’est plus qu’une carcasse broyée ou éventrée.</li>
		</ul>

		<h4>Effets secondaires</h4>
		<p>Les éventuels effets secondaires sont définis par leur <b>localisation</b> et leur <b>niveau de gravité</b>. Ce dernier dépend des dégâts reçus et d’un jet d’<i>Intégrité</i>. Ils sont gérés par la <a href="table-jeu"><i>Table de jeu</i></a>.</p>

		<h5>Niveaux de gravité</h5>
		<table class="alternate-o left-2">
			<tr>
				<th style="width: 5ch">1</th>
				<td>Dommages mineurs.</td>
			</tr>
			<tr>
				<th>2</th>
				<td>Fonctionne encore, mais mal et/ou provisoirement.</td>
			</tr>
			<tr>
				<th>3</th>
				<td>Cesse de fonctionner immédiatement.</td>
			</tr>
			<tr>
				<th>&ge; 4</th>
				<td>Localisation détruite.</td>
			</tr>
		</table>

		<p>Il se peut que les 4 niveaux n’aient pas nécessairement de sens pour une localisation donnée. Par exemple, un pneu est crevé dès que le niveau 1 est atteint.</p>

		<h5>Cumul des niveaux de gravité</h5>
		<p>Les niveaux de gravité sont cumulables&nbsp;: une localisation ayant déjà été endommagée avec un niveau de gravité de 1 et recevant des dommages d’un niveau de gravité de 2 passe au niveau 3 (et cesse immédiatement de fonctionner).</p>

	</details>

	<!-- Percer paroi -->
	<details>
		<summary>
			<h3>Percer la paroi d’un objet</h3>
		</summary>
		<p>Pour traverser la paroi d’un objet, il faut passer 125&nbsp;% de sa RD. Si ce seuil n’est pas atteint, l’objet prend tout de même les dégâts passant la RD mais sa paroi n’est pas percée.</p>
	</details>

	
</article>