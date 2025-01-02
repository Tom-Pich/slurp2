<?php

use App\Rules\ArmorsController;
use App\Rules\WeaponsController;
?>

<!-- Caractéristiques -->
<article class="as-start">
	<h2>Caractéristiques</h2>

	<!-- Dégâts -->
	<details>
		<summary>
			<h3>Dégâts</h3>
		</summary>
		<p>Les dégâts d’une arme sont caractérisés par un <i>Type</i> et une <i>Étendue</i>.</p>
		<p><b>Types de dégâts&nbsp;:</b> broyage (B), perforant (P) et tranchant (T).</p>
		<p><b>L’étendue des dégâts</b> d’une arme blanche dépend de la <i>For</i> de son utilisateur et de l’arme (voir les caractéristiques des armes, plus loin).</p>

		<details class="exemple">
			<summary>Exemple de calcul de dégâts</summary>
			Soit un personnage avec <i>For</i> 12. Ses dégâts de base sont 1d-1 pour l’estoc et 1d+2 pour la taille.<br>
			S’il manie une épée longue (dégâts P.e+2, T.t+1), il fera, en estoc, des dégâts perforants (P) dont l’étendue est (1d-1)+2 soit 1d+2.<br>
			En taille, il causera des dégâts tranchants (T) d’une étendue de (1d+2)+1 = 1d+3, que l’on transforme en 2d (voir ci-dessous).
		</details>

		<details class="mt-1 border p-¼">
			<summary class="fw-600">Cumul de modificateurs</summary>
			<p>Si, après addition du modificateur de dégâts <i>de l’arme</i> aux dégâts de base, il apparaît un bonus &ge; +3, ce bonus se transforme&nbsp;: +3 = +1d&nbsp;; +6 = +2d-1&nbsp;; +7 = +2d.</p>
			<p>De même, s’il apparaît un malus &le; -2, ce bonus se transforme&nbsp;: -2 = -1d+2&nbsp;; -3 = -1d+1&nbsp;; -4 = -1d&nbsp;; -5 = -2d+2&nbsp;; -6 = -2d+1&nbsp;; -7 = -2d.</p>
		</details>

		<p>Le widget de la <a href="table-jeu">Table de jeu</a> vous permet de déterminer les dégâts d’une arme en entrant la <i>For</i> d’un personnage et le code dégâts d’une arme.</p>

		<h4>Armes à deux mains</h4>
		<p>Une arme pouvant être maniée aussi bien à une main qu’à deux mains reçoit, lorsqu’elle est maniée à deux mains (widget&nbsp;: 2M opt.), un bonus aux dégâts égal au nombre de dés de dégâts que l’utilisateur a en <i>taille</i>.<br>
			Une arme conçue spécifiquement pour être maniée à deux mains – son nom l’indique (widget&nbsp;: 2M), reçoit le même bonus, -1.</p>

		<h4>Dégâts minimums</h4>
		<p>Contre une RD 0, une arme perforante ou tranchante inflige toujours un minimum de 1 pt de dégât.</p>
	</details>

	<details>
		<summary>
			<h3>Force minimale</h3>
		</summary>
		<p>Certaines armes nécessite une force minimale (Fmin ou Fm) pour être maniée sans malus. -1 à la compétence pour chaque point de For &lt; Fmin.</p>
		<p>Pour les armes à feu, en plus de la pénalité ci-dessus, le Rcl est augmenté de 1 par point de For &lt; Fmin (sans être plus que doublé).</p>
		<p>La <b>Fmin</b> d’une arme pouvant être maniée aussi bien à une main qu’à deux mains est réduite de 1 si elle est maniée à deux mains.</p>
	</details>

	<details>
		<summary>
			<h3>Armes devant être apprêtées</h3>
		</summary>
		<p>Certaines armes lourdes, longues ou mal équilibrées doivent être apprêtées après chaque utilisation (attaque et/ou parade). Si l’utilisateur s’en sert en début de round, il ne peut plus l’utiliser jusqu’au round suivant. S’il l’utilise en fin de round, il perd l’initiative au round suivant et ne peut pas se servir de cette arme pour parer en début de round.</p>
		<p>Si la <i>For</i> du porteur est supérieure de 5 pts à la Fmin de l’arme, il peut l’apprêter instantanément.</p>
	</details>

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
		<p>Pour les armes à projectiles seulement. Tout jet de compétence &ge; <i>Mlf</i> (par défaut 17 pour la plupart des armes) signifie que l’arme a 50% de chance de dysfonctionner.<br>
			La corde d’un arc se brise, une arbalète projettera son carreau de travers, et une arme à feu automatique ou semi-automatique s’enrayera.<br>
			Les armes à feu particulièrement fiables (revolver, fusil de chasse, fusil à coup unique) ne peuvent pas s’enrayer. Leur score de <i>Mlf</i> est de 18 et un dysfonctionnement ne peut être dû qu’à une cartouche défectueuse.<br>
			Une arme enrayée a 50% de chance d’être réparée en 1 tour (éjection de la cartouche coincée) sur un jet d’<i>Arme à feu</i> réussi. Sinon, il faut la compétence <i>Armurerie</i>.</p>

		<h4>Temps de rechargement</h4>
		<p>Ce temps ne tient pas compte d’un temps de visée après rechargement.</p>
		<ul>
			<li><b>Arbalète légère / moyenne / lourde</b> : 4/8/20 secondes (manivelle nécessaire pour l’arbalète lourde)</li>
			<li><b>Arc :</b> 3 secondes</li>
			<li><b>Arquebuse :</b> 15 à 60 secondes (dépend du type d’arme)</li>
			<li><b>Chargeur :</b> 3 secondes</li>
			<li><b>Fronde :</b> 3 secondes</li>
			<li><b>Revolver :</b> 2 secondes +1 seconde par balle</li>
		</ul>
		<p>Un jet de compétence à -3 (ou -2 avec <i>Réflexes de combat</i>) réduit ce temps de 1 seconde, sauf avec les armes à poudre noire (temps de rechargement diminué de 10%).</p>
	</details>

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
		<p>Correspond à la pénalité minimale en cas de tirs successifs, pour les armes à feu à répétition. Si le tireur a visé avant sont tir, la pénalité de recul est multipliée par deux.<br>
			Si la <i>For</i> de l’utilisateur est supérieure d’au moins 5 à la <i>Fmin</i> de l’arme, le <i>Rcl</i> est diminué de 1, sans toutefois pouvoir être annulé.</p>
	</details>

	<details>
		<summary>
			<h3>Accessoires pour armes à feu</h3>
		</summary>
		<p><b>Visée laser :</b> de +1 (pour des conditions des visées idéales) à +3 (pour des tirs à courte portée et avec un temps de visée très court) à la compétence du tireur, si le spot laser est visible (typiquement jusqu’à une portée ½D).</p>
		<p><b>Lunette de visée :</b> +1 à +3 si le tireur peut prendre le temps de viser (minimum 3 secondes + 1 seconde par +1). Pour certaines cibles très lointaines, une lunette de visée est obligatoire pour tirer. Seules les lunettes pour fusil de sniper de très grande précision peuvent apporter un bonus de +3.</p>
		<p><b>Silencieux :</b> décroit la portée de 1/3, et les dégâts de 1/4.</p>
	</details>

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

	<details>
		<summary>
			<h3>Armures</h3>
		</summary>
		<p>Une armure (ou toute autre protection) possède une <i>Résistance aux dégâts</i> (RD) à soustraire aux dégâts occasionnés par une attaque.</p>

		<h4>Qualité de l’acier</h4>
		<p>Excellent acier : poids -10% ; coût +25%.</p>
		<p>Armure en bronze : poids +10% ; RD-1.</p>

		<h4>Superposition d’armures</h4>
		<p>Superposer des armures autres qu’un coutil et une armure métallique impose une pénalité de -1 à tous les jets basés sur la <i>Dex</i>, en plus d’un éventuel malus d’encombrement.</p>

		<h4>Casques et couvre-chefs</h4>
		<p>Protection souple couvrant les oreilles (coutil, cuir, cuir lourd)&nbsp;: -1 aux jets d’<i>Écouter</i>.</p>
		<p>Casque et autres protections métalliques couvrant les oreilles&nbsp;: -2 aux jets d’<i>Écouter</i>.<br>
			Heaume : tous les jets à -1, <i>Voir</i> et <i>Écouter</i> à -2.</p>
		<p>Il est possible de cumuler une coiffe de maille et un casque&nbsp;: le coutil est alors compté qu’une seule fois (RD11). -3 au jet d’<i>Écouter</i>.</p>
	</details>

	<details>
		<summary>
			<h3>Boucliers</h3>
		</summary>
		<p>La <i>Défense passive</i> (DP) d’un bouclier s’ajoute au score de <i>Blocage</i> de base (<i>Bouclier</i>-3).</p>
		<p>Pour frapper avec un bouclier, faire un jet de <i>Bouclier</i>. L’ennemi peut esquiver, bloquer ou parer à -2. Dégâts&nbsp;: B.e.</p>
	</details>

</article>

<!-- Armes antiques & médiévales -->
<article class="as-start">
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
		WeaponsController::displaySpecialWeapon($weapons);
		?>
	</details>

	<details  class="border py-½ px-1">
		<summary class="h4">Notes</summary>

		<div class="mt-½ fs-300">
			<?php foreach (WeaponsController::weapons_notes as $index => $note) { ?>
				<p><b><?= $index ?>&nbsp;:</b> <?= $note ?></p>
			<?php } ?>
		</div>
	</details>

</article>

<!-- Armes à feu -->
<article class="as-start">
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
	<details class="border py-½ px-1">
		<summary class="h4">Notes</summary>
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
<article class="as-start">
	<h2>Armures &amp; boucliers</h2>

	<!-- Armures antiques & médiévales -->
	<details>
		<summary>
			<h3>Armures antiques &amp; médiévales</h3>
		</summary>
		<p>Les poids des armures incluent des vêtements légers. Ils sont donnés pour une armure «&nbsp;hypo&shy;thétique&nbsp;» complète couvrant tout sauf le visage. De telles armures n’existent généralement pas. Il est donc préférable, pour être plus réaliste, de confectionner une armure composite, c’est-à-dire formée de plusieurs pièces d’armures différentes. Voir paragraphe suivant.</p>

		<table class="left-1 alternate-e">
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
		<table class="left-1 alternate-e">
			<tr>
				<th>Localisation</th>
				<th>% poids</th>
				<th>% prix</th>
			</tr>
			<?php foreach (ArmorsController::armor_parts as $part) { ?>
				<tr>
					<td><?= $part["nom"] ?><?= $part["notes"] ? ("<sup>" . $part["notes"] . "</sup>") : "" ?></td>
					<td><?= $part["mult_pds"] ?></td>
					<td><?= $part["mult_prix"] ?></td>
				</tr>
			<?php } ?>
		</table>

		<div class="mt-½">
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
		<table class="left-1 alternate-e">
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
		<p><b>Casque de fantassin (NT6/7)&nbsp;:</b> RD5/6 ; 2/1,5 kg.</p>
		<p><b>Casque anti-émeute (NT7)&nbsp;:</b> Visière couvrant le visage (RD3). RD5 contre le broyage et RD3 contre les autres types de dégâts ; 1 kg.</p>
		<p>
			<b>Gilet Pare-balle (NT6)&nbsp;:</b> RD7 (2 contre du perforant) ; 5 kg.<br>
			25% des dégâts arrêtés par l’armure sont infligés sous forme de broyage, à cause du choc, en plus des dommages qui passent la RD.
		</p>
		<p>
			<b>Veste en Kevlar (NT7)&nbsp;:</b> Légère : RD4, 1,25 kg pour une veste. Moyenne : RD8, 2,5 kg pour une veste. Lourde : RD12, 3,75 kg pour une veste.<br>
			Une veste couvre le torse et les parties génitales, et peut être dissimulée sous des vêtements. Les fibres de Kevlar protègent moins contre des dégâts perforants (RD divisée par 4). 25% des dégâts arrêtés par l’armure sont infligés sous forme de broyage, à cause du choc, en plus des dommages qui passent la RD. Des ajouts rigides et séparés, pour le ventre ou pour le dos, pesant 8 kg chacun, apportent une RD supplémentaire de 15.
		</p>
	</details>

</article>