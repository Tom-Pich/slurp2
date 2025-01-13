<?php

use App\Rules\WoundController;
?>

<!-- Blessures -->
<article class="as-start">
	<h2>Blessures</h2>

	<details>
		<summary><h3>Définitions</h3></summary>
		<p><b>Dégâts bruts&nbsp;:</b> dégâts de l’attaque avant prise en compte de la RD.<br>
			<b>Dégâts effectifs&nbsp;:</b> dégâts nets après application du multiplicateur de type de dégâts et d’une éventuelle limite. Ce sont eux qui sont à soustraire des PdV du personnage.<br>
			<b>PdVm&nbsp;:</b> PdV maximum du personnage (lorsqu’il n’est pas blessé).
		</p>
	</details>

	<details>
		<summary><h3>Effets d’une blessure</h3></summary>

		<p>
			Les effets des blessures sont très complexes à établir. Ils dépendent de nombreux facteurs (étendue des dégâts infligés, type de dégâts, localisation, état du personnage, RD, <i>San</i>, <i>Dex</i> et présence ou absence de <i>Résistance à la douleur</i>) et peuvent être partiellement aléatoires.<br>
			Utiliser le <b>widget</b> <i>Effets d’une blessure</i> de la <a href="table-jeu">Table de jeu</a> pour déterminer ces effets.
		</p>

		<p>Si vous voulez voir l’algorithme de détermination de ces effets, voir <a href="https://github.com/Tom-Pich/slurp2/blob/main/src/Rules/WoundController.php" target="_blank">ce fichier sur Github</a> – plus précisemment la méthode <code>getWoundEffect</code>.</p>

		<h4>Dégâts effectifs</h4>
		<p>Dégâts à soustraire des PdV. Ces dégâts ne sont pas décomptés du total si la localisation est un membre (jambe, bras, pied, main). Un décompte séparé doit être tenu pour chaque membre pour savoir s’il finit par subir une blessure invalidante ou par être détruit – voir <i>Effets des blessures aux membres</i>.</p>

		<h4>Effets spéciaux</h4>
		<p>Suivre les indications du widget.</p>
		<p>Une blessure peut entraîner une chute, une perte de conscience, voire une mort immédiate.</p>
		<p>
			<b>Sonné 1&nbsp;:</b> pour les prochaines opportunités d’actions à venir (il y en a deux par rounds), le personnage ne peut rien faire, si ce n’est des actions «&nbsp;réflexes&nbsp;», type <i>Défense</i>, qui se font alors à -4. Le nombre d’actions perdues est déterminé par le widget de la <i>Table de jeu</i> ou, si ce n’est pas le cas, par la ME d’un jet de <i>San</i> (minimum 1).<br>
			<b>Sonné 2&nbsp;:</b> comme <i>sonné 1</i>, sauf que le personnage perd totalement sa première prochaine action (y compris une action «&nbsp;réflexes&nbsp;»). Le jet de <i>San</i> pour déterminer le nombre d’actions perdues se fait à -5 (minimum 1), sauf si le widget de la table de jeu vous donne cette information.<br>
			<b>Sonné 3&nbsp;:</b> le personnage est hors combat (aucune action) pendant une durée de l’ordre de 1 minute (20 rounds). Il tombe automatiquement. Si le MJ est généreux, il peut un peu moduler cette durée en fonction de la MR d’un jet de <i>San</i>.
		</p>
		<p><b>Un personnage ayant <i>Résistance à la douleur</i> réduit son niveau de «&nbsp;sonnage&nbsp;» de 1.</b> Le widget tient compte de ce facteur si vous le lui précisez.</p>

	</details>

	<details>
		<summary><h3>État général</h3></summary>

		<h4>Seuils de PdV généraux</h4>
		<p>Lorsque les PdV d’une créature sont inférieurs à certains seuils, elle subit les conséquences indiquées. Des PdV négatifs ne signifient pas nécessairement une mort immédiate. Consulter la table ci-dessous ou utiliser le widget <i>Seuils de blessures</i> sur la <a href="table-jeu">Table de jeu</a>.<br>
			Les seuils sont donnés en pourcentage des PdV maximum.<br>
			Un malus s’appliquant à la <i>For</i> n’affecte pas ses PdVm et ses PdFm.</p>

		<table class="left-2">
			<tr>
				<th style="width: 20%">PdV</th>
				<th>Effets</th>
			</tr>
			<?php foreach (array_reverse(WoundController::general_levels) as $index => $level) { ?>
				<tr>
					<td><?= $index !== 0 ? ("&le; " . ((float) $index) * 100 . "&nbsp;%") : "0" ?></td>
					<td>
						<b><?= mb_convert_case($level["name"], MB_CASE_TITLE, "UTF-8") ?></b> –
						<?= ucfirst($level["description"]) ?>
					</td>
				</tr>
			<?php } ?>
		</table>

		<p>Si le personnage dispose de l’avantage <i>Résistance à la douleur</i>, ajouter 25&nbsp;% à son ratio PdV/PdVm, sauf si ses PdV sont &le; -100&nbsp;% PdVm.</p>
		<p>Les PdV et PdF ne sont pas affectés par le multiplicateur de <i>For</i> associé au niveau de blessure.</p>

		<h4>Blessures &amp; fatigue</h4>
		<p>Si le personnage est fatigué <i>et</i> blessé, les malus se cumulent. Si le personnage tombe en-dessous de la moitié de sa <i>For</i> normale, il ne peut pas tenir debout. Si sa vitesse tombe à 0, il peut à peine se déplacer en titubant.</p>

	</details>

	<details>
		<summary><h3>Effets des blessures aux membres</h3></summary>
		<p>
			Chaque membre (bras, mains, jambes, pieds) a ses propres PdV qui sont calculés à partir des PdVm, ainsi que ses propres seuils de blessures. Les dégâts infligés à un membre ne sont pas décomptés du total des PdV du personnage.<br>
			Utiliser le widget <i>Seuils de blessures</i> sur la <a href="table-jeu">Table de jeu</a> pour déterminer l’état d’un membre en fonction des dégâts qu’il a reçu.
		</p>

		<table>
			<tr>
				<th>Membre</th>
				<th>PdVm</th>
			</tr>
			<?php foreach (WoundController::members_pdv as $member => $pdvm) { ?>
				<tr>
					<td><?= ucfirst($member) ?></td>
					<td><?= $pdvm * 100 ?>&nbsp;%</td>
				</tr>
			<?php } ?>
			<caption>PdV des membres en fonction des PdVm totaux</caption>
		</table>

		<p>Voici les seuils d’états des membres</p>
		<table class="left-2">
			<tr>
				<th>% PdVm</th>
				<th>État</th>
			</tr>
			<?php foreach (array_reverse(WoundController::members_levels) as $level => $state) { ?>
				<tr>
					<td>&le; <?= ((float) $level)*100 ?>&nbsp;%</td>
					<td><?= $state["description"] ?></td>
				</tr>
			<?php } ?>
			<caption>État des membres en fonction de leur PdVm propre</caption>
		</table>

	</details>

	<!-- Hémorragie -->
	<details>
		<summary><h3>Hémorragie</h3></summary>
		<p class="clr-invalid italic ta-center">Règle à revoir et à passer en gestion automatique.</p>
		<p><i>Attention</i>&nbsp;: cette règle est optionnelle car elle augmente <i>drastiquement</i> la mortalité en l’absence de soins magiques.</p>
		<p>Une blessure peut provoquer une hémorragie. Jet de <i>San</i> à -1 pour chaque tranche complète de 25&nbsp;% des PdVm perdus, une fois par minute&nbsp;:</p>
		<p>Pour une <b>blessure à un membre</b>, le jet de <i>San</i> se fait sans malus si le membre n’a pas de blessure invalidante, à -1 s’il a reçu une blessure invalidante et à -2 s’il est détruit.</p>
		<p>
			<b>Échec, ME &le; 3&nbsp;:</b> perte de 10&nbsp;% des PdVm (5&nbsp;% des PdVm s’il s’agit de la main ou du pied).<br>
			<b>Échec, ME &ge; 4&nbsp;:</b> perte de 20&nbsp;% des PdVm (10&nbsp;% des PdVm s’il s’agit de la main ou du pied).<br>
			<b>Échec critique&nbsp;:</b> perte de 20&nbsp;% des PdVm et les prochains jets de <i>San</i> se font à -3 supplémentaire jusqu’à ce qu’une réussite soit obtenue.<br>
			<b>Réussite, MR &le; 3&nbsp;:</b> pas de perte pour cette minute.<br>
			<b>Réussite, MR &ge; 4&nbsp;:</b> pas de perte pour cette minute, les prochains jets de <i>San</i> se font à +3 jusqu’à ce qu’un échec soit obtenu.<br>
			<b>Réussite critique</b> ou <b>3 réussites consécutives&nbsp;:</b> l’hémorragie s’arrête.
		</p>
		<p>Ne pas arrondir les PdV perdus par hémorragie avant la fin de cette dernière.</p>
		<p>Si l’hémorragie est externe, un jet de <i>Premiers secours</i> peut être tenté chaque minute pour arrêter l’hémorragie.<br>
			Si l’hémorragie est interne, seule la chirurgie (ou la magie) peut l’arrêter.</p>
	</details>

</article>

<!-- Rétablissement -->
<article class="as-start">
	<h2>Rétablissement</h2>

	<!-- Premiers secours -->
	<details>
		<summary><h3>Premiers secours</h3></summary>
		<p>Les soins durent une minute et permettent d’arrêter une hémorragie externe et de récupérer 1 PdV si la blessure est ouverte. Des premiers soins peuvent s’appliquer indépendamment aux PdV généraux (tronc et tête) et aux membres.</p>
	</details>

	<!-- Rétablissement naturel -->
	<details>
		<summary><h3>Rétablissement naturel</h3></summary>
		<p>
			Chaque jour, un blessé a droit à un jet de <i>San</i> appelé <i>jet de guérison</i>.<br>
			Ce jet est modifié par l’état du personnage et par les conditions de guérison.
		</p>

		<h4>Rétablissement des membres</h4>
		<p>Le cas échéant, faire également un jet pour chaque membre blessé.</p>
		<p>
			Un membre détruit ne peut pas avoir moins que -100&nbsp;% de ses PdVm propres. S’il a été sectionné, on considère qu’il est à 0 PdV.<br>
			Ainsi, un personnage ayant 12 PdV et dont la main a été broyée aura perdu 6 PdV à sa main (une main a 25&nbsp;% des PdV max d’un humain). Après guérison, celle-ci sera toujours inutilisable, mais le personnage ne risquera pas l’infection.<br>
			Si ce même personnage a eu la main sectionnée, on considère qu’il a perdu 3 PdV à sa main.<br>
			Un bras ou une jambe guérit à un rythme réduit de moitié par rapport aux PdV généraux. Une main ou un pied guérit au quart de ce rythme.
		</p>

		<h4>État et jet de guérison</h4>
		<table>
			<tr>
				<th>% PdVm</th>
				<th>Modificateur au jet de guérison</th>
			</tr>
			<tr>
				<td>&gt; 50 %</td>
				<td>+2</td>
			</tr>
			<tr>
				<td>&gt; 25%</td>
				<td>+1</td>
			</tr>
			<tr>
				<td>&gt; 0</td>
				<td>+0</td>
			</tr>
			<tr>
				<td>&gt; -100&nbsp;%</td>
				<td>-1</td>
			</tr>
			<tr>
				<td>&gt; -150 %</td>
				<td>-2</td>
			</tr>
			<tr>
				<td>&gt; -200 %</td>
				<td>-3</td>
			</tr>
			<tr>
				<td>&le; -200 %</td>
				<td>-4</td>
			</tr>
		</table>

		<h4>Conditions de guérison</h4>
		<table class="alternate-o left-1">
			<tr>
				<th colspan="2">Modificateur d’environnement</th>
			</tr>
			<tr>
				<td>Soins élémentaires, milieu «&nbsp;sale&nbsp;»</td>
				<td>-5</td>
			</tr>
			<tr>
				<td>Soins élémentaires, milieu «&nbsp;propre&nbsp;»</td>
				<td>-3</td>
			</tr>
			<tr>
				<td>Soins courants NT 6-7 (désinfectants, antibiotiques)</td>
				<td>+0</td>
			</tr>
			<tr>
				<th colspan="2">Autres modificateurs</th>
			</tr>
			<tr>
				<td>Suivi par médecin NT 6-7</td>
				<td>+1</td>
			</tr>
			<tr>
				<td>Pas de repos</td>
				<td>-2</td>
			</tr>
			<tr>
				<td>Efforts continus (marche forcée)</td>
				<td>-3</td>
			</tr>
			<tr>
				<td>Nourriture insuffisante</td>
				<td>-1</td>
			</tr>
			<tr>
				<td>Pas de nourriture</td>
				<td>-2</td>
			</tr>
		</table>
		<p>S’il n’y a pas de blessure ouverte, le modificateur d’environnement vaut 0.</p>
		<p>Le malus aux jets de guérison dû à des échecs antérieurs est limité à -5.</p>
		<p>Si le jet de guérison passe en-dessous de 3, le personnage sombre dans l’inconscience et meurt au bout de 2d heures. S’il s’agit d’un jet de guérison pour un membre, le membre est perdu et l’infection nécessite une amputation pour sauver le personnage.</p>

		<h4>Conséquences du jet de guérison</h4>
		<ul>
			<li><b>Réussite critique&nbsp;:</b> +2 PdV et +3 aux prochains jets de <i>San</i> jusqu’à guérison complète.</li>
			<li><b>Réussite&nbsp;:</b> annule tous les malus dus à des échecs antérieurs aux jets de <i>San</i>. +1 PdV.</li>
			<li><b>Échec (ME &le; 3)&nbsp;:</b> pas de récupération de PdV</li>
			<li><b>Échec grave (ME &gt; 3)&nbsp;:</b> -1 PdV. -1 aux prochains jets de guérison.</li>
			<li><b>Échec critique</b> (ou de 5+ si la blessure a trois jours ou moins)&nbsp;: -1d PdV et -5 aux jets de <i>San</i> suivants.</li>
		</ul>

		<p>Pour des créatures plus grosses ou plus petites que des humains, la récupération de PdV se fait en proportion de ses PdVm.</p>

	</details>

	<!-- Rétablissement après inconscience -->
	<details>
		<summary><h3>Rétablissement après inconscience</h3></summary>

		<p>La durée de l’inconscience dépend de la fraction des PdV restant et d’un ou plusieurs jet de <i>San</i>. Consultez la table ci-dessous.</p>

		<table class="left-2 mt-1">
			<colgroup>
				<col style="width: 8ch">
			</colgroup>
			<tr>
				<th>PdV</th>
				<th>Durée de l’inconsciences</th>
			</tr>
			<tr>
				<td>&gt; 50 %</td>
				<td>1d min puis jet de <i>San</i> chaque minute.</td>
			</tr>
			<tr>
				<td>&le; 50 %</td>
				<td>1d×5 min puis jet de <i>San</i> toutes les 5 min.</td>
			</tr>
			<tr>
				<td>&le; 0</td>
				<td>
					15 minutes d’inconscience + 15 min par PdV négatif. Après ce délai, jet de <i>San</i> toutes les 15 minutes.<br>
					Si ME &ge; 5&nbsp;: perte de 1d PdV et coma* de 1d jours.
				</td>
			</tr>
			<tr>
				<td>&le; -100 %</td>
				<td>
					Au bout de 2d-2 h, jet de <i>San</i> avec un modificateur qui dépend de ses PdV.<br>
					De 0 pour -100&nbsp;% à -10 pour -300&nbsp;% (variation linéaire).<br>
					• <b>ME &gt; 3&nbsp;:</b> mort<br>
					• <b>ME &le; 3&nbsp;:</b> perte de 1d PdV et coma* de 1d×5 jours.<br>
					• <b>Réussite&nbsp;:</b> le personnage reste inconscient jusqu’à ce que ses PdV dépassent le seuil de -100&nbsp;%.
				</td>
			</tr>
		</table>

		<p><b>* Coma&nbsp;:</b> si le personnage tombe dans le coma, à la fin de celui-ci, faire un jet de <i>San</i> dont les conséquences sont listées ci-dessous.</p>

		<ul>
			<li><b>ME &gt; 3&nbsp;:</b> le personnage meurt en 2d-2 heures.</li>
			<li><b>ME &le; 3&nbsp;:</b> le coma se prolonge (redéterminer la durée aléatoirement sur la même base que le jet inital).</li>
			<li><b>Réussite&nbsp;:</b> le personnage reprend conscience si son état général le lui permet. Il n’a plus de jet à faire pour éviter la mort due au coma en cours.</li>
		</ul>

		<h4>Intervention chirurgicale</h4>
		<p>Une intervention chirurgicale permet d’obtenir un bonus de +1 à +5 aux jets permettant d’éviter le coma ou la mort.</p>

	</details>

	<!-- Rétablissement de blessures invalidantes -->
	<details>
		<summary><h3>Rétablissement de blessures invalidantes</h3></summary>
		<p>Après une blessure <i>invalidante</i>, la victime doit faire un jet de <i>San</i> pour déterminer comment se rétablira l’invalidité (si elle se rétablit&hellip;).</p>
		<table class="left-2">
			<colgroup>
				<col style="width: 5em">
			</colgroup>
			<tr>
				<th>MR</th>
				<th>Conséquences</th>
			</tr>
			<tr>
				<td>&le; -4</td>
				<td>Invalidité définitive</td>
			</tr>
			<tr>
				<td>-1 à -3</td>
				<td>Après 2d semaines d’amélioration, l’invalidité diminue de 50&nbsp;% et ne s’améliorera plus après ce délai.</td>
			</tr>
			<tr>
				<td>0 à 2</td>
				<td>l’invalidité disparaît complètement après 2d semaines.</td>
			</tr>
			<tr>
				<td>&ge; 3</td>
				<td>l’invalidité disparaît au rythme d’une guérison normale.</td>
			</tr>

		</table>
	</details>

	<!-- Soins magiques & blessures aux membres -->
	<details>
		<summary><h3>Soins magiques &amp; blessures aux membres</h3></summary>
		<p>
			Lorsque le membre revient à 100&nbsp;% de ses PdVm propres, il est considéré comme guéri (même s’il reste handicapé ou détruit).<br>
			Si le membre a été sectionné, récupérer la moitié de ses PdVm propres suffit à cicatriser le moignon.
		</p>
		<h4>Sorts de soin</h4>
		<p>Le lanceur peur répartir comme il veut les PdV soignés entre les PdV généraux et les PdV des membres.</p>
		<h4>Potion de soin</h4>
		<p>Les PdV récupérés se répartissent de manière équitable entre les bras, les jambes et les PdV généraux. Les pieds et les mains reçoivent la moitié de PdV généraux.</p>
		<p>On ne perd pas de PdV récupérés lors de cette répartition. De même, si cela représente plus de PdV récupérés que nécessaire, les autres PdV récupérés sont affectés à d’autres blessures.</p>
	</details>

</article>

<!-- Danger divers -->
<article class="as-start">
	<h2>Dangers divers</h2>

	<details>
		<summary><h3>Affaiblissement et PdF</h3></summary>
		<p>L’affaiblissement du personnage sans blessure physique est simulé par des pertes de PdF. Ces PdF ne peuvent être récupérés que par la fin de l’exposition au danger.</p>
	</details>

	<details>
		<summary><h3>Chute</h3></summary>
		<p>Les dégâts dus à une chute, pour un humain, sont les suivants&nbsp;:<br>
			• 1 ou 2 mètres&nbsp;: 1d-3 par mètre,<br>
			• 3 ou 4 mètres&nbsp;: 1d-2 par mètre,<br>
			• 5 mètres ou plus&nbsp;: 1d-1 par mètre.</p>
		<p>-1 point par mètre si l’arrivée se fait sur une surface molle (sable, boue). Les dégâts dus à une chute sont de type <i>Broyage</i>.</p>
		<p>Un jet d’<i>Acrobatie</i> réussi réduira la distance de chute de 3 m.</p>
		<p>La vélocité maximale en atmosphère terrestre, pour un être humain, est atteinte après 50 m de chute.</p>
		<p><b>Localisation des dégâts&nbsp;:</b> faire un jet de localisation tous les 5 mètres de chute et répartir les dégâts entre les différentes parties affectées.</p>

		<table>
			<tr>
				<th>3d</th>
				<th>Pieds en premier</th>
				<th>Tête la première</th>
			</tr>
			<tr>
				<td>3-8</td>
				<td>Une jambe</td>
				<td>Un bras</td>
			</tr>
			<tr>
				<td>9-10</td>
				<td>Deux jambes</td>
				<td>Deux bras</td>
			</tr>
			<tr>
				<td>11-12</td>
				<td>Torse</td>
				<td>Tête</td>
			</tr>
			<tr>
				<td>13-15</td>
				<td>Un bras</td>
				<td>Torse</td>
			</tr>
			<tr>
				<td>16-18</td>
				<td>Tête</td>
				<td>Une jambe</td>
			</tr>
		</table>
	</details>

	<details>
		<summary><h3>Drogues</h3></summary>
		<p>Chaque drogue est décrite en terme de jeu par les caractéristiques ci-dessous. Si la drogue est imaginaire, il faut préciser son ou ses modes d’administration, son origine, etc.</p>
		<p><b>Effets&nbsp;:</b> modulés par un jet de <i>San</i>, par la quantité prise, la qualité, etc. Une personne dépendante aura des bonus à ce jet, ce qui diminuera les effets qu’elle pourra ressentir et la poussera à consommer plus que la dose standard.</p>
		<p><b>Addictivité</b></p>
		<p><b>Surdosage&nbsp;:</b> lorsque la dose prise est importante, d’autres effets, potentiellement mortels, s’ajoutent aux effets «&nbsp;normaux&nbsp;».</p>
		<p><b>Crise de manque&nbsp;:</b> ces effets sont modulés par un jet de <i>San</i>.</p>
		<p>Le processus de sevrage dépend de chaque personnage et est géré au cas par cas par le MJ, en fonction de l’addictivité de la drogue, des effets des crises de manque, de la <i>Vol</i> et de la <i>San</i> du personnage.</p>
		<p>Les effets à long terme peuvent également être décrit si c’est utile au jeu.</p>

		<h4>Cannabis</h4>
		<p>Le cannabis entraîne une diminution de -2 de la <i>Per</i>, de la <i>Vol</i> et des <i>Réflexes</i>, pour un joint.<br>
			C’est une drogue peu addictive.<br>
			Un surdosage rendra le personnage somnolent, voire le fera s’endormir.<br>
			Une crise de manque se traduit par de la nervosité voire de l’aggressivité.</p>
	</details>

	<details>
		<summary><h3>Poisons</h3></summary>
		<p>La description doit indiquer, selon le mode d’action (ingestion, injection, cutané, inhalation), le temps nécessaire à l’action du poison, sa virulence (le malus au jet de résistance) ainsi que ses effets, en cas de réussite ou d’échec du jet de résistance.</p>
		<p><b>Doses multiples&nbsp;:</b> par dose supplémentaire, la virulence est augmentée de 2 et les effets augmentés de 50 %.</p>
	</details>

	<details>
		<summary><h3>Suffocation</h3></summary>
		<p>Une fois à bout de souffle (voir <i>Retenir sa respiration</i>), le personnage perd de 1PdF par tour.<br>
			Lorsque les PdF atteignent 0, il s’évanouit. La mort survient au bout de 3 minutes.<br>
			Si la victime est en fait en train de se noyer (c’est-à-dire que l’eau a pénétré à l’intérieur de ses poumons) le sauveteur devra réussir un jet de <i>Premiers secours</i> pour la sauver. Sinon, le seul fait de respirer de l’air frais ramènera la victime à elle, et elle pourra ainsi récupérer 1 PdF immédiatement mais devra reprendre le reste de ses forces normalement.<br>
			Il existe un risque d’endommagement du cerveau (-1 permanent en <i>Int</i>) si la victime est sauvée après être restée plus de deux minutes sans air. Jet de <i>San</i> pour éviter une telle conséquence.</p>
	</details>

	<details>
		<summary><h3>Climat extrême</h3></summary>
		<p>En cas de forte chaleur ou de froid glacial, faire des jets de <i>San</i> (ou de <i>Survie</i> appropriée) régulièrement. Ces jets des <i>San</i> et leur fréquence sont modifiés par les conditions de cette exposition.</p>
		<p>Un échec fait perdre 1 PdF, un échec critique fait perdre 3 PdF. Une MR &ge; 5 permet de récupérer 1 PdF perdu par la chaleur ou le froid.</p>
		<p>Une fois arrivé à 3 PdF, le personnage perd des PdV en plus des PdF.</p>
	</details>

	<details>
		<summary><h3>Flammes</h3></summary>
		<p>Chaque seconde passée dans les flammes infligent 1d-1 points de dégâts.</p>
		<p>Les armures de NT7 ou moins protègent entièrement contre des flammes ordinaires pendant RD tours. Les armures de NT8 ou plus peuvent être étanches. En ce cas, une armure de RD4 ou plus vous protègera une minute.</p>
		<p>Un bouclier pourra s’interposer entre un jet de flamme, ou une source de chaleur, et son porteur. La DP du bouclier comptera comme une RD.</p>

		<h4>Vêtements enflammés</h4>
		<p>4 pts de dégâts par le feu d’un seul coup&nbsp;: les vêtements prennent feu, 1d-3 pts de dégâts par tour<br>
			10 pts de dégâts par le feu d’un seul coup&nbsp;: torche humaine, 1d-1 pts de dégâts par tour.</p>
		<p>Ces indications supposent le port de vêtements ordinaires.</p>
	</details>

	<details>
		<summary><h3>Inanition et déshydratation</h3></summary>
		<p><b>Nourriture&nbsp;:</b> 1 PdF par repas raté (on compte deux repas par jour). Lorsque les PdF atteignent 3 pour cause de sous-alimentation, perte de PdV à la même vitesse.</p>
		<p><b>Eau&nbsp;:</b> 1 PdF et 1 PdV par jour si 2/3 des besoins sont couverts. 2 PdF et 2 PdV par jour pour 1/3 des besoins. Sans eau&nbsp;: 3 PdF et 3 PdV par jour. Si les PdV ou les PdF atteignent 0 par manque d’eau, délire et mort au bout d’une journée.</p>
		<p>Des jets de <i>San</i> réussis peuvent diminuer (légèrement) ces conséquences.</p>
	</details>

</article>