<?php

use App\Rules\ArmorsController;
use App\Rules\WeaponsController;
?>

<!-- Caractéristiques -->
<article>
	<h2>Caractéristiques</h2>

	<!-- Dégâts -->
	<details>
		<summary>
			<h3>Dégâts</h3>
		</summary>
		<p>Les dégâts d’une arme sont caractérisés par un <i>Type</i> et une <i>Étendue</i>.</p>

		<p>
			Pour les armes blanche, il existe trois <b>types de dégâts</b>&nbsp;: broyage (B), perforant (P) et tranchant (T). Sur une créature vivante, à valeurs égales, les dégâts perforants sont plus efficaces que les dégâts tranchants, eux-mêmes plus efficaces que les dégâts de broyage. Ces différences sont gérées sur la <a href="/table-jeu">table de jeu</a>. Voir aussi <i>Effets d’une blessure</i> sur la page <a href="/blessures-dangers">Blessures et dangers</a>.<br>
			Les dégâts causés par les armes à feu sont traités plus loin dans cette section.
		</p>

		<p><b>L’étendue des dégâts</b> d’une arme blanche dépend de la <i>For</i> de son utilisateur – plus précisemment de ses <i>dégâts de base</i> – et de l’arme elle-même (voir les caractéristiques des armes, plus loin).</p>

		<details class="exemple">
			<summary>Exemple de calcul de dégâts</summary>
			<p>Soit un personnage avec <i>For</i> 12. Ses dégâts de base sont 1d-1 pour l’estoc (e) et 1d+2 pour la taille (t).</p>
			<p>
				S’il manie une épée longue (dont les caractéristiques de dégâts sont P.e+2, T.t+1), il fera, en estoc, des dégâts perforants (P) dont l’étendue est de <i>estoc</i>+2 soit (1d-1)+2 ce qui donne 1d+1.<br>
				En taille, il causera des dégâts tranchants (T) d’une étendue de <i>taille</i>+1 soit (1d+2)+1 = 1d+3, que l’on transforme en 2d (voir ci-dessous <i>Cumul des modificateurs</i>).
			</p>
		</details>

		<!-- cumul modificateurs -->
		<details>
			<summary>
				<h4>Cumul de modificateurs</h4>
			</summary>
			<p>Si, après addition calcul des dégâts d’une arme, il apparaît un terme fixe &ge; +3 (par exemple 2d+4), ce terme fixe se transforme en terme variable.</p>
			<table>
				<tr>
					<th>Terme fixe</th>
					<th>Terme variable</th>
				</tr>
				<tr>
					<td>+3</td>
					<td>+1d</td>
				</tr>
				<tr>
					<td>+4</td>
					<td>+1d+1</td>
				</tr>
				<tr>
					<td>+5</td>
					<td>+1d+2</td>
				</tr>
				<tr>
					<td>+6</td>
					<td>+2d-1</td>
				</tr>
				<tr>
					<td>+7</td>
					<td>+2d</td>
				</tr>
			</table>

			<p>L’idée est que la valeur du terme fixe soit toujours la plus petite possible.</p>

			<p>De même, s’il apparaît un terme fixe &le; -2, ce terme fixe se transforme en terme variable.</p>
			<table>
				<tr>
					<th>Terme fixe</th>
					<th>Terme variable</th>
				</tr>
				<tr>
					<td>-2</td>
					<td>-1d+2</td>
				</tr>
				<tr>
					<td>-3</td>
					<td>-1d+1</td>
				</tr>
				<tr>
					<td>-4</td>
					<td>-1d</td>
				</tr>
				<tr>
					<td>-5</td>
					<td>-1d-1</td>
				</tr>
				<tr>
					<td>-6</td>
					<td>-2d+1</td>
				</tr>
				<tr>
					<td>-7</td>
					<td>-2d</td>
				</tr>
			</table>

			<p>Là encore, l’idée reste la même&nbsp;: le terme fixe doit être le plus petit possible. Toutefois, on ne permettra pas d’arriver à 0d. Par exemple, 2d-6 ne devient pas 0d+1. Dans ces cas limites, on calcule l’espérance mathématique du jet et on consulte la table ci-dessous pour obtenir la valeur corrigée. <i>Rappel&nbsp;: l’espérance sur 1d vaut 3,5</i>.</p>

			<table>
				<tr>
					<th>Espérance</th>
					<th>Avec 1d</th>
					<th>Valeur corrigée</th>
				</tr>
				<tr>
					<td>1,5</td>
					<td>1d-2</td>
					<td>1d5-1</td>
				</tr>
				<tr>
					<td>0,5 à 1</td>
					<td>1d-3</td>
					<td>1d4-1</td>
				</tr>
				<tr>
					<td>-0,5 à 0</td>
					<td>1d-4</td>
					<td>1d3-1</td>
				</tr>
				<tr>
					<td>-1 ou pire</td>
					<td>1d-5</td>
					<td>1d2-1</td>
				</tr>
			</table>

			<p><b>Exemples</b></p>
			<ul>
				<li>2d+4 → 2d+1d+1 → 3d+1</li>
				<li>3d+10 → 3d+7+3 → 3d+2d+1d → 6d</li>
				<li>5d-3 → 5d-1d+1 → 4d+1</li>
				<li>2d-6 → espérance 1 → 1d4-1</li>
				<li>2d-7 → espérance 0 → 1d3-1</li>
			</ul>
		</details>

		<p>Le widget de la <a href="table-jeu">Table de jeu</a> vous permet de déterminer les dégâts d’une arme en entrant la <i>For</i> d’un personnage et le code dégâts de l’arme qu’il utilise.</p>

		<h4>Armes à deux mains</h4>
		<p>
			Une arme pouvant être maniée aussi bien à une main qu’à deux mains (par exemple une épée bâtarde, ou une hache) reçoit, lorsqu’elle est maniée à deux mains, un bonus aux dégâts égal au nombre de dés de dégâts que l’utilisateur a en <i>taille</i> (sur le widget, choisir 2M opt.).<br>
			Une arme conçue spécifiquement pour être maniée à deux mains – son nom l’indique, reçoit le même bonus, -1 (sur le widget, choisir 2M).
		</p>

		<h4>Dégâts minimums</h4>
		<p>Contre une RD 0, une arme perforante ou tranchante inflige toujours un minimum de 1 pt de dégât.</p>
	</details>

	<!-- Force minimale -->
	<details>
		<summary>
			<h3>Force minimale</h3>
		</summary>
		<p>La plupart des armes nécessitent une force minimale (<i>Fmin</i> ou <i>Fm</i>) pour être maniées sans malus. -1 à la compétence pour chaque point de <i>For</i> &lt; <i>Fmin</i>.</p>
		<p>Pour les armes à feu, en plus de la pénalité ci-dessus, le <i>Rcl</i> est augmenté de 1 par point de For &lt; Fmin (sans être plus que doublé).</p>
		<p>La <b>Fmin</b> d’une arme pouvant être maniée aussi bien à une main qu’à deux mains est réduite de 1 si elle est maniée à deux mains.</p>
	</details>

	<!-- Armes devant être apprêtées -->
	<details>
		<summary>
			<h3>Armes devant être apprêtées</h3>
		</summary>
		<p>Certaines armes lourdes, longues ou mal équilibrées doivent être apprêtées après chaque utilisation (attaque et/ou parade). Cet apprêt dure le temps d’une action, pendant laquelle l’arme ne pourra pas être utilisée (voir <i>Déroulement d’un tour de combat</i> sur la page <a href="/combat">Combat</a>).</p>
		<p>Si la <i>For</i> du porteur est supérieure de 5 pts à la <i>Fmin</i> de l’arme, il peut l’apprêter instantanément.</p>
	</details>

	<!-- Armes à distance -->
	<details>
		<summary>
			<h3>Armes à distance</h3>
		</summary>

		<h4>Dégâts</h4>
		<p>Les dégâts d’une arme pouvant être utilisée aussi bien au contact qu’à distance (couteau, lance, hache, caillou) sont réduits de 1 lorsqu’elle est lancée.</p>

		<h4>Portée (Prt)</h4>
		<p>La première portée indiquée est la <b>portée utile</b>. Elle correspond à un tir de difficulté <i>Moyenne</i> sur cible immobile de la taille d’un torse humain, dans des conditions <i>idéales de visée</i>.</p>
		<p>La deuxième portée est la portée au-delà de laquelle les dégâts sont divisés par deux (notée ½D).</p>

		<h4>Malfonction (Mlf)</h4>
		<p>
			Pour les armes à projectiles seulement. Tout jet de compétence &ge; <i>Mlf</i> (par défaut 17 pour la plupart des armes) signifie que l’arme a 50% de chance de dysfonctionner.<br>
			La corde d’un arc se brise, une arbalète projettera son carreau de travers, et une arme à feu automatique ou semi-automatique s’enrayera.<br>
			Les armes à feu particulièrement fiables (revolver, fusil de chasse, fusil à coup unique) ne peuvent pas s’enrayer. Leur score de <i>Mlf</i> est de 18 et un dysfonctionnement ne peut être dû qu’à une cartouche défectueuse.<br>
			Une arme enrayée a 50% de chance d’être réparée en 1 tour (éjection de la cartouche coincée) sur un jet d’<i>Arme à feu</i> réussi. Sinon, il faut la compétence <i>Armurerie</i>.
		</p>

		<h4>Temps de rechargement</h4>
		<p>Ce temps ne tient pas compte d’un temps de visée après rechargement.</p>
		<ul>
			<li><b>Arbalète légère / moyenne / lourde</b> : 4/8/20 secondes (manivelle nécessaire pour l’arbalète lourde)</li>
			<li><b>Arc :</b> 3 secondes</li>
			<li><b>Arquebuse :</b> 15 à 60 secondes (dépend du type d’arme)</li>
			<li><b>Chargeur :</b> 3 secondes</li>
			<li><b>Fronde :</b> 3 secondes</li>
			<li><b>Revolver :</b> 2 secondes +1 seconde par balle</li>
		</ul>
		<p>Un jet de compétence à -3 (ou -2 avec <i>Réflexes de combat</i>) réduit ce temps de 1 seconde, sauf avec les armes à poudre noire (temps de rechargement diminué de 10%).</p>
	</details>

	<!-- Armes à feu -->
	<details>
		<summary>
			<h3>Armes à feu</h3>
		</summary>
		<h4>Dégâts des armes à feu</h4>
		<p>Selon le calibre et la géométrie de la balle, son pouvoir de pénétration (pour passer la RD) peut être différent de sa capacité à causer des dégâts à un être vivant. Pour simuler cela, à côté des dégâts d’une arme à feu il peut y avoir une des indications suivantes&nbsp;:</p>
		<ul>
			<li><b>(–)&nbsp;:</b> dégâts nets ÷2&nbsp;;</li>
			<li><b>(+)&nbsp;:</b> dégâts nets ×1,5&nbsp;;</li>
			<li><b>(++)&nbsp;:</b> dégâts nets ×2.</li>
		</ul>

		<p><b>Munition perce-armure&nbsp;:</b> RD et dégâts nets ÷2<br>
			<b>Munition à pointe creuse&nbsp;:</b> RD ×2 et dégâts nets ×1,5. Face à ce type de munition, une RD 0 devient RD 1.
		</p>

		<p><b>Dégâts nets&nbsp;:</b> dégâts passant la RD.</p>

		<h4>Vitesse de tir (VdT)</h4>
		<p>Nombre maximum de tirs par seconde.<br>
			Si <i>VdT</i> &gt; 3, il s’agit d’une arme automatique.<br>
			Si <i>VdT</i> &lt; 3, il s’agit d’une arme à rechargement manuel (verrou, pompe, levier).<br>
			Une <i>VdT</i> de 3 indique une arme semi-automatique.</p>

		<h4>Coups (Cps)</h4>
		<p>Réserve de munitions dans le chargeur.</p>

		<h4>Recul (Rcl)</h4>
		<p>
			Correspond à la pénalité minimale en cas de tirs successifs, pour les armes à feu à répétition. Si le tireur a visé avant son tir, la pénalité de recul est multipliée par deux.<br>
			Si la <i>For</i> de l’utilisateur est supérieure d’au moins 5 à la <i>Fmin</i> de l’arme, le <i>Rcl</i> est diminué de 1, sans toutefois pouvoir être annulé.
		</p>
	</details>

	<!-- Accessoires armes à feu -->
	<details>
		<summary>
			<h3>Accessoires pour armes à feu</h3>
		</summary>
		<p><b>Visée laser :</b> de +1 (pour des conditions des visées idéales) à +3 (pour des tirs à courte portée et avec un temps de visée très court) à la compétence du tireur, si le spot laser est visible (typiquement jusqu’à une portée ½D).</p>
		<p><b>Lunette de visée :</b> +1 à +3 si le tireur peut prendre le temps de viser (minimum 3 secondes + 1 seconde par +1). Pour certaines cibles très lointaines, une lunette de visée est obligatoire pour tirer. Seules les lunettes pour fusil de sniper de très grande précision peuvent apporter un bonus de +3.</p>
		<p><b>Silencieux :</b> décroit la portée de 1/3, et les dégâts de 1/4.</p>
	</details>

	<!-- Qualité des armes -->
	<details>
		<summary>
			<h3>Qualités des armes</h3>
		</summary>

		<p>La qualité d’une arme influe sur les chances qu’elle a de se briser en cas d’échec critique (voir chapitre <i>Combat</i>) et sur ses dégâts de base.</p>
		<table class="left-1">
			<tr>
				<th>Armes blanches</th>
				<th>Se briser*</th>
				<th>Dégâts**</th>
			</tr>
			<tr>
				<td>Bon marché (MQ)</td>
				<td>×2</td>
				<td>+0</td>
			</tr>
			<tr>
				<td>Bonne qualité (BQ)</td>
				<td>×½</td>
				<td>+1</td>
			</tr>
			<tr>
				<td>Très bonne qualité (TBQ)</td>
				<td>×⅙</td>
				<td>+2</td>
			</tr>
			<tr>
				<th>Arcs et arbalètes</th>
				<th>Mlf</th>
				<th>Portée</th>
			</tr>
			<tr>
				<td>Bon marché</td>
				<td>-1</td>
				<td>-20%</td>
			</tr>
			<tr>
				<td>Bonne qualité</td>
				<td>+1</td>
				<td>+20%</td>
			</tr>
		</table>
		<p>
			* multiplicateur de probabilité de se briser.<br>
			** sauf arme de broyage
		</p>
	</details>

	<!-- Armures -->
	<details>
		<summary>
			<h3>Armures</h3>
		</summary>
		<p>Une armure (ou toute autre protection) possède une <i>Résistance aux dégâts</i> (RD) à soustraire aux dégâts occasionnés par une attaque.</p>

		<h4>Qualité de l’acier</h4>
		<p>Excellent acier : poids -10% ; coût +25%.</p>
		<p>Armure en bronze : poids +10% ; RD-1.</p>

		<h4>Superposition d’armures</h4>
		<p>Superposer des armures autres qu’un coutil et une armure métallique impose une pénalité de -1 à tous les jets basés sur la <i>Dex</i>, en plus d’un éventuel malus d’encombrement.</p>

		<h4>Casques et couvre-chefs</h4>
		<p>
			Protection souple couvrant les oreilles (coutil, cuir, cuir lourd) : -1 aux jets d’<i>Écouter</i>.<br>
			Casque et autres protections métalliques couvrant les oreilles : -2 aux jets d’<i>Écouter</i>.<br>
			Heaume : tous les jets à -1, <i>Voir</i> et <i>Écouter</i> à -2.
		</p>
		<p>Il est possible de cumuler une coiffe de maille et un casque : le coutil est alors compté qu’une seule fois (RD11). -3 au jet d’<i>Écouter</i>.</p>
	</details>

	<!-- Boucliers -->
	<details>
		<summary>
			<h3>Boucliers</h3>
		</summary>
		<p>La <i>Défense passive</i> (DP) d’un bouclier s’ajoute au score de <i>Blocage</i> de base (<i>Bouclier</i>-3).</p>
		<p>Pour frapper avec un bouclier, faire un jet de <i>Bouclier</i>. L’ennemi peut esquiver, bloquer ou parer à -2. Dégâts&nbsp;: B.e.</p>
	</details>

</article>

<!-- Armes antiques & médiévales -->
<article>
	<h2>Armes antiques &amp; médiévales</h2>

	<details>
		<summary>
			<h3>Arc &amp; Arbalète</h3>
		</summary>
		<?php
		$weapons = array_filter(WeaponsController::weapons, fn($weapon) => $weapon["cat"] === "arc");
		WeaponsController::displayWeaponsList($weapons);
		?>
		<p class="fs-300">Poids des flèches et carreaux&nbsp;: 50 g</p>
	</details>

	<details>
		<summary>
			<h3>Épées, couteaux &amp; sabres</h3>
		</summary>
		<?php
		$weapons = array_filter(WeaponsController::weapons, fn($weapon) => $weapon["cat"] === "épée");
		WeaponsController::displayWeaponsList($weapons);
		?>
	</details>

	<details>
		<summary>
			<h3>Haches, masses &amp; fléaux</h3>
		</summary>
		<?php
		$weapons = array_filter(WeaponsController::weapons, fn($weapon) => $weapon["cat"] === "h-m");
		WeaponsController::displayWeaponsList($weapons);
		?>
	</details>

	<details>
		<summary>
			<h3>Lances &amp; armes d’hast</h3>
		</summary>
		<?php
		$weapons = array_filter(WeaponsController::weapons, fn($weapon) => $weapon["cat"] === "lance");
		WeaponsController::displayWeaponsList($weapons);
		?>
	</details>

	<details>
		<summary>
			<h3>Bâtons, gourdins et cailloux</h3>
		</summary>
		<?php
		$weapons = array_filter(WeaponsController::weapons, fn($weapon) => $weapon["cat"] === "g-c");
		WeaponsController::displayWeaponsList($weapons);
		?>
	</details>

	<details>
		<summary>
			<h3>Armes diverses</h3>
		</summary>
		<?php
		$weapons = array_filter(WeaponsController::weapons, fn($weapon) => $weapon["cat"] === "divers");
		WeaponsController::displayWeaponsList($weapons);
		?>
	</details>

	<details>
		<summary>
			<h3>Armes spéciales</h3>
		</summary>
		<?php
		$weapons = array_filter(WeaponsController::weapons, fn($weapon) => $weapon["cat"] === "spéciale");
		WeaponsController::displaySpecialWeapons($weapons);
		?>
	</details>

	<details>
		<summary>
			<h4>Notes</h4>
		</summary>
		<div class="fs-300">
			<?php foreach (WeaponsController::weapons_notes as $index => $note) { ?>
				<p><b><?= $index ?>&nbsp;:</b> <?= $note ?></p>
			<?php } ?>
		</div>
	</details>

</article>

<!-- Armes à feu -->
<article>
	<h2>Armes à feu</h2>

	<!-- Armes de poing -->
	<details>
		<summary>
			<h3>Armes de poing</h3>
		</summary>

		<?php
		$weapons = array_filter(WeaponsController::firearms, fn($weapon) => $weapon["cat"] === "arme-de-poing-nt6");
		WeaponsController::displayWeaponsList($weapons, true, table_title: "Générique NT6");

		$weapons = array_filter(WeaponsController::firearms, fn($weapon) => $weapon["cat"] === "arme-de-poing-nt7");
		WeaponsController::displayWeaponsList($weapons, true, table_title: "Générique NT7");

		$weapons = array_filter(WeaponsController::firearms, fn($weapon) => $weapon["cat"] === "arme-de-poing-nt8");
		WeaponsController::displayWeaponsList($weapons, true, table_title: "Générique NT8");
		?>

		<h4>IMI Desert Eagle</h4>
		<p>Conçu au début des années 1980. Premier pistolet semi-automatique pouvant tirer du .357 magnum, .44 magnum et .50AE (plus puissante munition à ce jour pour un pistolet semi-auto). En plus de présenter une capacité limitée (7 à 9 coups selon les modèles), sa masse et son encombrement le rendent difficile à porter en permanence. Il n’est pas employé par les forces militaires ou de police à cause de sa taille et de son coût.</p>
		<img src="assets/img_equipement/desert-eagle-50ae.png" height="70" class="mx-auto">
		<?php
		$weapons = array_filter(WeaponsController::firearms, fn($weapon) => $weapon["cat"] === "desert-eagle");
		WeaponsController::displayWeaponsList($weapons, true);
		?>

	</details>

	<!-- Fusils -->
	<details>
		<summary>
			<h3>Fusils</h3>
		</summary>

		<?php
		$weapons = array_filter(WeaponsController::firearms, fn($weapon) => $weapon["cat"] === "fusil-nt6");
		WeaponsController::displayWeaponsList($weapons, true, table_title: "Génériques NT6");

		$weapons = array_filter(WeaponsController::firearms, fn($weapon) => $weapon["cat"] === "fusil-nt7");
		WeaponsController::displayWeaponsList($weapons, true, table_title: "Génériques NT7");

		$weapons = array_filter(WeaponsController::firearms, fn($weapon) => $weapon["cat"] === "fusil-nt8");
		WeaponsController::displayWeaponsList($weapons, true, table_title: "Génériques NT8");
		?>
		<p class="fs-300">* lunette de visée +3 intégrée</p>

		<h4>Winchester Classic Hunter</h4>
		<p>
			Carabine de chasse apparue en 1936 et toujours fabriquée à ce jour.<br>
			Utilisée par de nombreux SWAT Teams. Les modèles les plus courants utilisent les calibres .30-06 US ou .308 Win (identique au 7,62N) et mesurent 113 cm pour 3,5&nbsp;kg.<br>
			Avec une lunette +2, la portée utile passe à 100&nbsp;m.
		</p>
		<img src="assets/img_equipement/winchester-model70.png" height="70" class="mx-auto">
		<?php
		$weapons = array_filter(WeaponsController::firearms, fn($weapon) => $weapon["cat"] === "winchester-classic-hunter");
		WeaponsController::displayWeaponsList($weapons, true);
		?>

		<h4>Fusil d’assaut HK 416</h4>
		<p>Le HK416 est un fusil d’assaut de calibre 5,56N. Fabriqué depuis 2005, il est devenu le fusil standard de l’armée française en 2017. C’est une arme très fiable (<i>Malf</i> 18).</p>
		<img src="assets/img_equipement/hk-416.png" height="80" class="mx-auto">
		<?php
		$weapons = array_filter(WeaponsController::firearms, fn($weapon) => $weapon["cat"] === "hk-416");
		WeaponsController::displayWeaponsList($weapons, true);
		?>

	</details>

	<!-- Shotguns -->
	<details>
		<summary>
			<h3>Shotguns</h3>
		</summary>
		<?php
		$weapons = array_filter(WeaponsController::firearms, fn($weapon) => $weapon["cat"] === "shotgun");
		WeaponsController::displayWeaponsList($weapons, true);
		?>
		<p class="fs-300">Si la crosse est sciée, +1 à la Fmin, +1 au Rcl et le poids de l’arme est diminué de 0,5 kg.<br>
			Ces dégâts supposent que l’arme tire du 00. Si le shotgun est chargé avec des munitions pour petit gibier, les dégâts sont divisés par deux.<br>
			La RD est doublée contre ce type de munitions.</p>
	</details>

	<!-- Pistolets-mitrailleurs -->
	<details>
		<summary>
			<h3>Pistolets-mitrailleurs</h3>
		</summary>

		<?php
		$weapons = array_filter(WeaponsController::firearms, fn($weapon) => $weapon["cat"] === "mitraillette-nt6");
		WeaponsController::displayWeaponsList($weapons, true, table_title: "Génériques NT6");

		$weapons = array_filter(WeaponsController::firearms, fn($weapon) => $weapon["cat"] === "mitraillette-nt7");
		WeaponsController::displayWeaponsList($weapons, true, table_title: "Génériques NT7");

		$weapons = array_filter(WeaponsController::firearms, fn($weapon) => $weapon["cat"] === "mitraillette-nt8");
		WeaponsController::displayWeaponsList($weapons, true, table_title: "Génériques NT8");
		?>

		<h4>Igram MAC-10</h4>
		<p>
			Pistolet-mitrailleur compact développé en 1964. Chambré en .45 ACP ou en 9 mm Parabellum. Un silencieux spécialement conçu diminue le bruit et facilite le contrôle de l’arme en tir automatique (Rcl réduit de 1), mais rend l’arme moins compacte et discrète.<br>
			Tir automatique ou au coup par coup. Équipée d'une crosse d'épaule de petite taille, insuffisante pour permettre un tir stable, et d’une sangle à l’avant qui remplit médiocrement le rôle de poignée frontale. Très difficilement contrôlable en l’absence d'un entrainement adapté.
		</p>
		<img src="assets/img_equipement/ingram-mac-10.png" height="85" class="mx-auto">
		<?php
		$weapons = array_filter(WeaponsController::firearms, fn($weapon) => $weapon["cat"] === "ingram-mac-10");
		WeaponsController::displayWeaponsList($weapons, true);
		?>

	</details>

	<!-- Grenades -->
	<details>
		<summary>
			<h3>Grenades</h3>
		</summary>
		<p><b>Défensive&nbsp;:</b> grenade à fragmentation. Concussion : 2d+2 à 5d, Fragmentation : 1d+2 à 3d.</p>
		<p><b>Offensive&nbsp;:</b> peu de fragmentation, charge explosive plus importante. Concussion : 5d à 6d, Fragmentation : dépend de la nature du sol.</p>
	</details>

	<!-- Explosifs -->
	<details>
		<summary>
			<h3>Explosifs</h3>
		</summary>
		<p>Pour obtenir une explosion faisant 6d×<i>n</i> pts de dégâts, il faut n²×0,1 kg de TNT</p>
		<p>Puissance relative d’autres explosifs&nbsp;:</p>
		<ul>
			<li>Poudre&nbsp;: avant 1600 ×0,3&nbsp;; avant 1850 ×0,4&nbsp;; après 1850 ×0,5</li>
			<li>Carburant + nitrates&nbsp;: ×0,5</li>
			<li>Dynamite&nbsp;: ×0,8</li>
			<li>C4&nbsp;: ×1,4</li>
		</ul>

	</details>

	<!-- Notes -->
	<details>
		<summary>
			<h4>Notes</h4>
		</summary>
		<div class="fs-300">
			<p>Toutes les caractéristiques sont identiques à celles de GURPS 4</p>
			<p><b>Portée utile&nbsp;:</b> basée sur l’<i>Accuracy</i> (Acc 2 = 15 m).</p>
			<p>Même progression de portées que GURPS (15, 20, 30, 70, 100, 150&hellip;)</p>
			<p><a href="https://en.wikipedia.org/wiki/Table_of_handgun_and_rifle_cartridges">Liste des calibres</a> existants sur <i>Wikipédia</i>.</p>
			<p><a href="http://www.sjgames.com/pyramid/sample.html?id=2794">Ballistic for GURPS</a> par Douglas Hampton Cole</p>
		</div>

	</details>

</article>

<!-- Armures & boucliers -->
<article>
	<h2>Armures &amp; boucliers</h2>

	<!-- Armures antiques & médiévales -->
	<details>
		<summary>
			<h3>Armures antiques &amp; médiévales</h3>
		</summary>
		<p>Les poids des armures incluent des vêtements légers. Ils sont donnés pour une armure «&nbsp;hypo&shy;thétique&nbsp;» complète couvrant tout sauf le visage. De telles armures n’existent généralement pas. Il est donc préférable, pour être plus réaliste, de confectionner une armure composite, c’est-à-dire formée de plusieurs pièces d’armures différentes. Voir paragraphe suivant.</p>

		<table class="left-1">
			<tr>
				<th></th>
				<th>RD</th>
				<th>Poids</th>
			</tr>
			<?php foreach (ArmorsController::armors as $armor) { ?>
				<tr>
					<td><?= $armor["nom"] . ($armor["notes"] ? "<sup>" . $armor["notes"] . "</sup>" : "") ?></td>
					<td><?= $armor["RD"] ?></td>
					<td><?= $armor["pds"] ?> kg</td>
				</tr>
			<?php } ?>
		</table>

		<h4>Notes</h4>
		<?php foreach (ArmorsController::armors_notes as $index => $note) { ?>
			<p><b><?= $index ?>&nbsp;:</b> <?= $note ?></p>
		<?php } ?>

		<h4>Taille des armures</h4>
		<p>La taille d’une armure a un impact sur son prix et son poids. En terme de jeu, on distingue les tailles suivantes&nbsp;:</p>
		<ul>
			<?php foreach (ArmorsController::armor_sizes as $size) { ?>
				<li><b><?= $size["nom"] ?></b> (<?= $size["notes"] ?>)&nbsp;: coût ×<?= $size["mult_prix"] ?>, poids ×<?= $size["mult_pds"] ?></li>
			<?php } ?>
		</ul>

		<h4>Qualité des armures</h4>
		<p>
			<b>Bonne qualité&nbsp;:</b> poids ×<?= ArmorsController::armor_qualities["bq"]["mult_pds"] ?>, prix ×<?= ArmorsController::armor_qualities["bq"]["mult_prix"] ?><br>
			<b>Très bonne qualité&nbsp;:</b> +1 en RD, poids ×<?= ArmorsController::armor_qualities["tbq"]["mult_pds"] ?>, prix ×<?= ArmorsController::armor_qualities["tbq"]["mult_prix"] ?>
		</p>
		<p>Une armure de <i>Très bonne qualité</i> n’existe pas dans un contexte médiéval réaliste. Elle doit être réalisée avec des alliages modernes, ou exotiques.</p>

		<h4>Pièces d’armure</h4>
		<p>Le prix et le poids des différentes pièces d’une armure se calculent à partir de ceux d’une armure complète.</p>
		<table class="left-1">
			<tr>
				<th>Localisation</th>
				<th>% poids</th>
				<th>% prix</th>
			</tr>
			<?php foreach (ArmorsController::armor_parts as $part) { ?>
				<tr>
					<td><?= $part["nom"] ?><?= $part["notes"] ? ("<sup>" . $part["notes"] . "</sup>") : "" ?></td>
					<td><?= $part["mult_pds"]*100 ?></td>
					<td><?= $part["mult_prix"]*100 ?></td>
				</tr>
			<?php } ?>
		</table>

		<div class="mt-½ fs-300">
			<?php foreach (ArmorsController::armor_parts_notes as $index => $note) { ?>
				<p><b><?= $index ?></b> <?= $note ?></p>
			<?php } ?>
		</div>
	</details>

	<!-- Boucliers -->
	<details>
		<summary>
			<h3>Boucliers antiques</h3>
		</summary>
		<p>Boucliers de bois et mince couche d’acier</p>
		<table class="left-1">
			<tr>
				<th>Bouclier</th>
				<th>DP</th>
				<th>Poids</th>
			</tr>
			<?php foreach (ArmorsController::shields as $shield) { ?>
				<tr>
					<td><?= $shield["nom"] ?></td>
					<td><?= $shield["DP"] ?></td>
					<td><?= $shield["pds"] ?> kg</td>
				</tr>
			<?php } ?>
		</table>
	</details>

	<!-- Armures modernes -->
	<details>
		<summary>
			<h3>Armures modernes</h3>
		</summary>
		<!-- <p><b>Casque de fantassin (NT6/7)&nbsp;:</b> RD5/6 ; 2/1,5 kg.</p>
		<p><b>Casque anti-émeute (NT7)&nbsp;:</b> Visière couvrant le visage (RD3). RD5 contre le broyage et RD3 contre les autres types de dégâts ; 1 kg.</p>
		<p>
			<b>Gilet Pare-balle (NT6)&nbsp;:</b> RD7 (2 contre du perforant) ; 5 kg.<br>
			25% des dégâts arrêtés par l’armure sont infligés sous forme de broyage, à cause du choc, en plus des dommages qui passent la RD.
		</p>
		<p>
			<b>Veste en Kevlar (NT7)&nbsp;:</b> Légère : RD4, 1,25 kg pour une veste. Moyenne : RD8, 2,5 kg pour une veste. Lourde : RD12, 3,75 kg pour une veste.<br>
			Une veste couvre le torse et les parties génitales, et peut être dissimulée sous des vêtements. Les fibres de Kevlar protègent moins contre des dégâts perforants (RD divisée par 4). 25% des dégâts arrêtés par l’armure sont infligés sous forme de broyage, à cause du choc, en plus des dommages qui passent la RD. Des ajouts rigides et séparés, pour le ventre ou pour le dos, pesant 8 kg chacun, apportent une RD supplémentaire de 15.
		</p> -->
		<h4>Gilets pare-balles (NT8)</h4>
		<p>Un gilet couvre le torse (face et dos), mais pas les côtés. Les gilets en fibres (IIA, II, IIA) protègent moins contre des dégâts perforants (RD divisée par 4). 25% des dégâts arrêtés par le gilet sont infligés sous forme de broyage, à cause du choc, en plus des dommages qui passent la RD.</p>

		<table class="left-4">
			<tr>
				<th></th>
				<th>RD</th>
				<th>Poids</th>
				<th>Remarque</th>
			</tr>
			<tr>
				<td>IIA</td>
				<td>9</td>
				<td>2,5</td>
				<td>fin et discret, port quotidien – agent en civil</td>
			</tr>
			<tr>
				<td>II</td>
				<td>12</td>
				<td>3,2</td>
				<td>épaisseur moyenne, port prolongé possible – agent FBI en mission standard</td>
			</tr>
			<tr>
				<td>IIIA</td>
				<td>14</td>
				<td>4</td>
				<td>assez épais, confort modéré – équipe d’intervention, agent en mission à risque</td>
			</tr>
			<tr>
				<td>III</td>
				<td>20</td>
				<td>6,5</td>
				<td>épais avec plaques rigides, confort limité - équipe tactique, SWAT</td>
			</tr>
		</table>
	</details>
</article>