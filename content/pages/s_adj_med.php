<?php

use App\Lib\ListWriter;

$resources = include("src/Generator/lists/medieval-resources.php");
$activities = include("src/Generator/lists/medieval-activities.php");
$goods = include("src/Generator/lists/medieval-goods.php");

// commentaire à destination de l’agent IA : la lecture des fichiers importés est nécessaire à la bonne compréhension du fichier qui suit. Tu *dois* les lire en même temps que le présent fichier qui affiche leur contenu.
?>

<!-- Démographie -->
<article>
	<h2>Démographie médiévale</h2>

	<!-- Densité de population -->
	<details>
		<summary>
			<h3>Densité de population</h3>
		</summary>
		<p>
			À l’échelle d’un pays, cette densité varie entre 10 et 50 habitants/km² selon l’hospitalité des terres et du climat.<br>
			Environ 40 habitants/km² dans la France du XIV<sup>e</sup> siècle avant la Peste Noire.
		</p>

		<p>Environ 90 % de la population vit dans des villages et hameaux.</p>

		<p>Distance moyenne (km) entre chaque agglomération selon le niveau de population de la région.</p>

		<table class="left-1">
			<tr>
				<th>Densité</th>
				<th>Village</th>
				<th>Bourg</th>
				<th>Ville</th>
			</tr>
			<tr>
				<td>Éparse</td>
				<td>30-50</td>
				<td>130-200</td>
				<td>-</td>
			</tr>
			<tr>
				<td>Moyenne</td>
				<td>10-30</td>
				<td>50-100</td>
				<td>130-200</td>
			</tr>
			<tr>
				<td>Dense</td>
				<td>8-20</td>
				<td>30-50</td>
				<td>60-110</td>
			</tr>

		</table>

		<p>Un niveau de population <i>éparse</i> correspond à une zone peu passante du haut Moyen Âge, tandis qu’un niveau de population <i>dense</i> correspond à une région prospère à la fin du Moyen Âge.</p>
	</details>

	<!-- Taille des agglomérations -->
	<details>
		<summary>
			<h3>Taille des agglomérations</h3>
		</summary>

		<table>
			<tr>
				<th>Type</th>
				<th>Population</th>
				<th>Densité (hab/hectare)</th>
				<th>Rayon d’exploitation (km)</th>
			</tr>
			<tr>
				<td>Hameau</td>
				<td>10-80</td>
				<td>10-20</td>
				<td>0,5-2</td>
			</tr>
			<tr>
				<td>Village</td>
				<td>150-500</td>
				<td>30-50</td>
				<td>1,5-4</td>
			</tr>
			<tr>
				<td>Gros village</td>
				<td>500-900</td>
				<td>40-70</td>
				<td>2-5</td>
			</tr>
			<tr>
				<td>Bourg</td>
				<td>1000-2000</td>
				<td>50-110</td>
				<td>3-6</td>
			</tr>
			<tr>
				<td>Ville</td>
				<td>3000-12000</td>
				<td>150-160</td>
				<td>4-12</td>
			</tr>

		</table>

		<p>
			Les plus grandes villes font entre 25&thinsp;000 et 100&thinsp;000 habitants.<br>
			Paris au XIII<sup>e</sup> siècle (plus grande ville d’Occident) : 200&thinsp;000 habitants.
		</p>

	</details>

</article>

<!-- Économie médiévale -->
<article>
	<h2>Économie médiévale</h2>

	<!-- Besoins -->
	<details>
		<summary>
			<h3>Besoins</h3>
		</summary>

		<ul>
			<li>Eau (boire, cuisiner, irriguer, abreuver)</li>
			<li>Se nourrir</li>
			<li>S’abriter (construire)</li>
			<li>Faire du feu (se chauffer, cuisiner, artisanat)</li>
			<li>Se vêtir</li>
			<li>Se défendre (construire, forger)</li>
			<li>Se déplacer / transporter</li>
			<li>S’éclairer</li>
			<li>Se laver</li>
			<li>Se soigner</li>
			<li>Pratiquer sa foi</li>
			<li>Se divertir</li>
		</ul>
	</details>

	<!-- Ressources -->
	<details>
		<summary>
			<h3>Ressources</h3>
		</summary>

		<!-- Agriculture et élevage -->
		<details>
			<summary>
				<h4>Agriculture et élevage</h4>
			</summary>

			<ul class="flow">
				<?= ListWriter::displayList($resources["agriculture-élevage"]) ?>
			</ul>
		</details>

		<!-- Chasse, pêche et cueillette -->
		<details>
			<summary>
				<h4>Chasse, pêche et cueillette</h4>
			</summary>

			<ul class="flow">
				<?= ListWriter::displayList($resources["chasse-peche-cueillette"]) ?>
			</ul>
		</details>

		<!-- Pierre, minéraux et métaux -->
		<details>
			<summary>
				<h4>Pierre, minéraux et métaux</h4>
			</summary>
			<ul class="flow">
				<?= ListWriter::displayList($resources["minéraux-métaux"]) ?>
			</ul>
		</details>

	</details>

	<!-- Métiers -->
	<details>
		<summary>
			<h3>Métiers</h3>
		</summary>

		<?php foreach ($activities as $domain => $domain_activities): ?>
			<?php $domain = ListWriter::ucf($domain) ?>
			<details>
				<summary>
					<h4><?= $domain ?></h4>
				</summary>
				<ul <?= is_array(array_values($domain_activities)[0]) ? "class=\"flow\"" : "" ?>>
					<?= ListWriter::displayList($domain_activities) ?>
				</ul>
			</details>
		<?php endforeach ?>

	</details>

	<!-- Marchandises -->
	<details>
		<summary>
			<h3>Marchandises</h3>
		</summary>

		<!-- Aliments -->
		<details>
			<summary>
				<h4>Aliments</h4>
			</summary>
			<ul class="flow">
				<?= ListWriter::displayList($goods["commerce-aliments"]) ?>
			</ul>
		</details>

		<!-- Objets domestiques -->
		<details>
			<summary>
				<h4>Objets domestiques</h4>
			</summary>
			<ul class="flow">
				<?= ListWriter::displayList($goods["commerce-objets-domestiques"]) ?>
			</ul>
		</details>

		<!-- Vêtements, textiles et confection -->
		<details>
			<summary>
				<h4>Vêtements, textiles et confection</h4>
			</summary>
			<ul class="flow">
				<?= ListWriter::displayList($goods["commerce-vetements-textiles"]) ?>
			</ul>
		</details>

		<!-- Outils, cordage et harnachement -->
		<details>
			<summary>
				<h4>Outils, cordage et harnachement</h4>
			</summary>
			<ul class="flow">
				<?= ListWriter::displayList($goods["outils-cordage-harnachement"]) ?>
			</ul>
		</details>

		<!-- Autres objets manufacturés -->
		<details>
			<summary>
				<h4>Autres objets manufacturés</h4>
			</summary>
			<ul class="flow">
				<?= ListWriter::displayList($goods["commerce-biens-courants"]) ?>
			</ul>
		</details>

		<!-- Marchandises de longue distance -->
		<details>
			<summary>
				<h4>Marchandises de longue distance</h4>
			</summary>
			<ul class="flow">
				<?= ListWriter::displayList($goods["commerce-longue-distance"]) ?>
			</ul>
		</details>

		<!-- Commerce de livraison intra-urbaine -->
		<details>
			<summary>
				<h4>Marchandises de livraison intra-urbaine</h4>
			</summary>
			<ul class="flow">
				<?= ListWriter::displayList($goods["commerce-livraison-intra-urbaine"]) ?>
			</ul>
		</details>

	</details>

</article>

<!-- Éléments de la vie quotidienne -->
<article>
	<h2>Éléments de la vie quotidienne</h2>

	<!-- Conservation des aliments -->
	<details>
		<summary>
			<h3>Conservation des aliments</h3>
		</summary>
		<ul>
			<li><b>Céréales :</b> greniers hauts ventilés (court terme, 1-2 ans) ou silos enterrés hermétiques (long terme, 5 ans+).</li>
			<li><b>Viandes &amp; poissons :</b> salaison au sel sec (coffres), fumage, ou confit (pots en grès scellés au gras).</li>
			<li><b>Légumes :</b> lacto-fermentation (choucroute en tonneaux) ou immersion acide (vinaigre/saumure pour les petits oignons, racines).</li>
			<li><b>Racines &amp; tubercules :</b> silos de terre ou caves fraîches sombres (navets, panais, carottes dans le sable).</li>
			<li><b>Fruits &amp; champignons :</b> séchage à l’air/au soleil (en colliers suspendus) ou confisage au miel/raisiné.</li>
			<li><b>Produits laitiers :</b> fromages à pâte pressée cuite ou salée (longue garde) et beurre salé en pots.</li>
			<li><b>Œufs :</b> enrobage dans la cire ou conservation dans la cire/cendre.</li>
		</ul>
	</details>

	<!-- Alimentation saisonnière -->
	<details>
		<summary>
			<h3>Alimentation saisonnière</h3>
		</summary>

		<!-- Printemps -->
		<details>
			<summary>
				<h4>Printemps</h4>
			</summary>
			<p><b>Légumes et légumineuses :</b> Épinards (frais), bettes, laitue, arroche (jeunes feuilles). Radis, oignons et poireaux primeurs. Fèves et pois frais (uniquement en fin de printemps).</p>

			<p><b>Fruits :</b> fruits sauvages : premières fraises des bois (fin de printemps). Aucun fruit de verger frais (uniquement les restes de noix et noisettes de l’an passé).</p>

			<p>
				<b>Autres aliments :</b> pain de seigle ou d’orge (peuple), pain de froment blanc (tables aisées), bouillies. Grand retour du lait frais (vache, chèvre, brebis), fromages frais, œufs en abondance.<br>
				Viandes fraîches de printemps : agneau, chevreau, veau (jeunes animaux d’élevage).<br>
				Pêche d’eau douce (période de frai) : brochet, carpe, perche, saumon.<br>
				Pêche en mer : hareng frais, maquereau.
			</p>
		</details>

		<!-- Été -->
		<details>
			<summary>
				<h4>Été</h4>
			</summary>
			<p><b>Légumes et légumineuses :</b> fèves et pois frais (verts). Bettes, arroche, choux d’été. Gourde (jeune), concombre (souvent cuit), aubergine (sud). Ail frais, oignons blancs. Cueillette : premières girolles.</p>

			<p><b>Fruits :</b> Cerises, abricots, pêches, prunes, figues fraîches (sud), amandes vertes. Fruits sauvages (cueillette) : framboises, mûres, fraises des bois, groseilles, cassis, merises.</p>

			<p>
				<b>Autres aliments :</b> pain frais après les moissons (froment, méteil), galettes d’orge. Lait, beurre, fromages affinés, œufs.<br>
				Viandes fraîches optimales (animaux engraissés au pâturage) : bœuf, mouton. Volailles de l’année (poulets, oies).<br>
				Chasse d’honneur (seigneurs) : le grand cerf (pleine saison de graisse).<br>
				Poissons frais de mer (sardine, maquereau) et de rivière.
			</p>
		</details>

		<!-- Automne -->
		<details>
			<summary>
				<h4>Automne</h4>
			</summary>
			<p><b>Légumes et légumineuses :</b> pois, fèves, lentilles et pois chiches (récoltés secs). Navets, carottes, panais, oignons matures et ail (de garde). Poireaux, choux, épinards. Gourde mature. Cueillette majeure de champignons (cèpes, bolets, lactaires).</p>

			<p><b>Fruits :</b> pommes, poires, coings, figues, grenades (sud), olives (sud). Fruits à coque (cultivés et sauvages) : noix, noisettes, châtaignes. Fruits sauvages de cueillette : pommes sauvages, cornouilles, sorbes, fruits de l’aubépine.</p>

			<p><b>Autres aliments :</b> pain frais en abondance (toutes céréales). Récolte du miel frais et de la cire d’abeille.<br>
				Viande fraîche en abondance (période des grands abattages avant l’hiver) : porcs engraissés, bêtes de réforme (vaches, moutons). Volailles grasses (oies, canards), pigeons (privilège seigneurial).<br>
				Chasse d’automne (bourgeois et nobles) : sanglier, lièvre, chevreuil, faisan, perdrix.<br>
				Pêche : grande saison de l’anguille (migration) et du hareng (salé ou fumé en masse).</p>
		</details>

		<!-- Hiver -->
		<details>
			<summary>
				<h4>Hiver</h4>
			</summary>
			<p><b>Légumes et légumineuses :</b> Fèves sèches, pois cassés, lentilles sèches, pois chiches secs (la base des potages quotidiens). Navets, panais, carottes et poireaux d’hiver (laissés en terre). Choux d’hiver (frisés, pommés). Oignons et ail secs (suspendus).</p>

			<p><b>Fruits :</b> Pommes et poires de garde (conservées sur paille). Fruits séchés (figues, pruneaux, raisins). Noix, noisettes et châtaignes sèches. Fruits sauvages d’hiver : nèfles (consommées blettes après les gelées), prunelles, cynorhodons.</p>

			<p>
				<b>Autres aliments :</b> Pain de garde (dur, à tremper), bouillie de millet ou d’orge. Fromages à pâte dure. Suif et graisse animale pour la cuisine.<br>
				Viandes de conserve : lard fumé, porc salé, charcuteries, bœuf et mouton salés ou séchés.<br>
				Viande fraîche : porc (période du "sacrifice du cochon" en décembre/janvier).<br>
				Chasse d’hiver : sanglier (chasse noble), gibier à poil, petits oiseaux au piège.<br>
				Pêche et restrictions du Carême : poissons séchés et salés (morue/stockfish, hareng saur).<br>
				Pour les tables riches : poissons frais issus des viviers et étangs seigneuriaux (carpe, brochet).
			</p>
		</details>
	</details>

	<!-- Calebasse -->
	<details>
		<summary>
			<h3>Usage de la calebasse</h3>
		</summary>

		<p>Le récipient « jetable » du Moyen Âge. Le volume dépend de la variété plantée et de la sélection du paysan. On trouve trois grands ordres de grandeur.</p>

		<ul>
			<li><b>La gourde de ceinture</b> (forme "bouteille" ou "sablier") : c’est la plus courante pour le voyage ou le travail aux champs. De 0,5 à 2 litres. La forme en sablier permet de nouer une cordelette au milieu pour l'attacher à la ceinture.</li>

			<li><b>La jarre de stockage</b> (forme "grosse boule" ou "calebasse") : de 5 à 15 litres (voire 20-30 litres, mais la peau devient plus fragile). Conservées au cellier pour stocker des matières sèches (sel, farine, fèves sèches, graines pour les prochaines semailles).</li>
			
			<li><b>La louche ou jatte </b>(forme "poire" coupée en deux) : de 0,2 à 1 litre. Gourde coupée en deux dans le sens de la longueur.</li>
		</ul>
	</details>

	<!-- Le moulin -->
	<details>
		<summary>
			<h3>Le moulin à eau</h3>
		</summary>

		<p>Le moulin à eau est le premier investissement technologique de masse de l’Europe, véritable centrale énergétique du monde médiéval. L’eau actionne une roue motrice, dont l’axe transmet sa rotation à un système de rouet et de lanterne pour réduire la vitesse et faire tourner la meule supérieure sous la trémie à grain.</p>

		<!-- Les types de roue -->
		<details>
			<summary>
				<h4>Les types de roue</h4>
			</summary>

			<p><b>La roue en dessous</b> (au fil de l’eau) : rendement faible. Les aubes plongent simplement dans le courant naturel. Pour les fleuves larges et lents, ou installé sur les moulins-barges ancrés au milieu des fleuves navigables.</p>

			<p><b>La roue en dessus</b> (par gravitation) : excellent rendement. L’eau est amenée par un canal surélevé (le bief) et tombe au-dessus de la roue, remplissant des godets (les augets). C’est le poids de l’eau, combiné à la chute, qui fait tourner la roue. Nécessite du relief (collines, montagnes) ou un bief de dérivation artificiel important.</p>

			<p><b>La roue de poitrine</b> (ou roue de côté) : rendement moyen. L’eau arrive sur la roue à mi-hauteur. Les augets ou les aubes sont profilés pour retenir l’eau pendant la descente. Ce système utilise à la fois la vitesse du courant et le poids de l’eau qui tombe. Elle est idéale pour les rivières de plaine ou de collines qui ont un débit régulier mais une faible hauteur de chute (entre 1 et 2 mètres), là où une roue en dessus est impossible à installer par manque de relief.</p>
		</details>

		<!-- Caractéristiques -->
		<details>
			<summary>
				<h4>Caractéristiques</h4>
			</summary>
			<p><b>Capacité de mouture :</b> 1,5 à 2 tonnes de grain / 24 heures (capacité standard d’une paire de meules bien alimentée)</p>
			<p><b>Seuil de subsistance :</b> 1 moulin pour 2 000 personnes</p>
			<p><b>Densité territoriale :</b> 1 moulin pour 250 à 300 habitants (ratio du bas Moyen Âge, Angleterre et France)</p>
			<p><b>Maintenance :</b> toutes les 100 à 150 heures (arrêt complet pour le rhabillage : retailler les rainures des pierres)</p>
		</details>

	</details>

	<!-- Halage et transport fluvial -->
	<details>
		<summary>
			<h3>Transport fluvial</h3>
		</summary>

		<p><b>La gabare</b>, grand chaland en bois à fond plat (sans quille), adapté aux hauts-fonds. 20-25 mètres de long, 4-5 mètres de large. 30 tonnes de charge utile pour seulement 60-80 cm d’enfoncement. Une "gourde" (gouvernail géant de 8 m) et un mât basculant sur charnière pour alterner entre voile (si vent favorable) et halage.</p>

		<!-- Remontée du courant -->
		<details>
			<summary>
				<h4>Remontée du courant</h4>
			</summary>
			<p>Le <b>patron</b>, à l’arrière, dirige la gabare et lutte contre le courant avec la gourde. Deux <b>bâtonniers</b>, à l’avant, sondent le fond et repoussent les obstacles avec de longues perches ferrées.</p>

			<p><b>Six bœufs</b> reliés au mât par une corde (la tire) de plus de 100 mètres. Le volant (un jeune) libère la corde de halage si elle se coince dans la végétation. Le bouvier dirige l’attelage sur le chemin de halage.</p>

			<p>3-4 heures de marche dès l’aube. 2-3 heures d’arrêt (dételage, repos et rumination des bœufs couchés). 3-4 heures de marche jusqu’au crépuscule.</p>

			<p>Vitesse terrestre : 2 km/h face à un courant moyen de 3 km/h. <b>14 km par jour.</b> Si les vents sont favorables, la distance parcourue peut augmenter de 50 %.</p>
		</details>

		<!-- Descente du courant -->
		<details>
			<summary>
				<h4>Descente du courant</h4>
			</summary>
			<p>Le bateau doit bouger à une vitesse différente du courant pour rester manœuvrable. L’équipage l’accélère <b>aux avirons</b> (les gâches) ou le freine à l’aide de <b>lourdes chaînes</b> traînant au fond (les dragues).</p>
			<p>Dans les <b>courbes serrées</b>, les deux bâtonniers manœuvrent les gâches ou reprennent leurs perches ferrées pour repousser physiquement la berge.</p>
			<p>Si la gabare est vide, <b>les bœufs se reposent à bord</b> dans un enclos central improvisé sur le pont. Le volant surveille le bétail et manipule les chaînes de freinage à l’arrière. Le bouvier voyage également sur le bateau.</p>
			<p>L’équipage navigue en continu. Les journées de descente peuvent s’allonger jusqu’à <b>10 heures de navigation</b> par jour.</p>
			<p>Vitesse terrestre : 5-6 km/h (3 km/h de courant + 2-3 km/h de propulsion aux gâches). <b>50 à 60 km par jour.</b> Le trajet retour est 3 à 4 fois plus rapide qu’à la remonté.</p>
		</details>

		<!-- Crues et gel -->
		<details>
			<summary>
				<h4>Crues et gel</h4>
			</summary>

			<p><b>Chômage de crue</b> (printemps/automne). Courant doublé ou triplé, chemin de halage submergé. Remonte impossible, descente hautement dangereuse par perte de contrôle. Report forcé sur les chariots : logistique prohibitive. Prix des marchandises triplés à l’arrivée et routes parallèles transformées en fondrières de boue.</p>

			<p><b>Chômage de gel</b> (hiver). Arrêt de la navigation. Obligation de stockage de masse durant l’été : approvisionnement des greniers (grains) et des ports à bois (chauffage urbain). Gestion municipale stricte des réserves sous clé et rationnement pour éviter la spéculation et la famine en ville.</p>

			<p><b>Le fleuve gelé comme autoroute.</b> Glace supérieure à 20 cm d’épaisseur transformée en axe de traînage. Utilisation de traîneaux à chevaux. Friction du bois sur la glace quasi nulle : charge utile par animal multipliée par trois par rapport à un chariot sur route de terre.</p>

			<p><b>Reconversion de la main-d’œuvre.</b> Bateliers et bouviers sans emploi réaffectés d’office aux travaux de la cité. En période de crue : entretien des digues et réfection du chemin de halage. En période de gel : carénage des coques mises au sec, bûcheronnage intensif et conduite des traîneaux de fret.</p>
		</details>
	</details>
</article>

<!-- Paysans - agriculture -->
<article>
	<h2>Paysans &amp; agriculture</h2>

	<!-- Travaux de saisons -->
	<details>
		<summary>
			<h3>Travaux &amp; activités</h3>
		</summary>
		<p>La majorité de la main-d’œuvre est louée selon les travaux et les saisons.</p>

		<!-- hiver -->
		<details>
			<summary>
				<h4>Hiver</h4>
			</summary>
			<p>La terre gelée est au repos et les paysans se font bûcherons ou artisans.</p>
			<ul>
				<li><b>Abattage</b> des bêtes en surnombre (décembre) → salaison, fumage</li>
				<li><b>Ramassage de feuilles mortes et de litière</b> (décembre) dans les sous-bois</li>

				<li><b>Battage du grain</b> à l’intérieur (on ne bat pas tout à l’été)</li>
				<li><b>Réparation</b> des outils, des charrettes, des harnais</li>
				<li><b>Vannerie, corderie</b> (travaux d’intérieur)</li>
				<li><b>Filage et tissage</b> (par les femmes)</li>
				<li><b>Travaux de charpente et de construction</b> (sol gelé donc terrain praticable pour amener les matériaux)</li>

				<li><b>Charbonnage</b> en forêt (fin hiver, début printemps)</li>
				<li><b>Taille</b> des pommiers, poiriers et amandiers (fin de l’hiver hors gel, à la serpe)</li>
				<li><b>Épierrage des champs</b> (fin de l’hiver – le gel fait remonter les pierres).</li>
			</ul>
		</details>

		<!-- printemps -->
		<details>
			<summary>
				<h4>Printemps</h4>
			</summary>
			<p>Le printemps est la période des disettes lorsque la moisson précédente a été maigre et que la nouvelle récolte tarde à venir.</p>
			<ul>
				<li><b>Taille de la vigne</b> (mars)</li>
				<li><b>Épandage du fumier</b> avant les labours (mars)</li>
				<li><b>Labours</b> (dès que la terre est dégelée)</li>
				<li><b>Semailles</b> de printemps (orge, avoine, pois, mars-avril)</li>
				<li><b>Hersage</b> après les labours (émietter les mottes, avril)</li>
				<li><b>Cueillette de crise</b> (orties, poireaux sauvage, herbes pour tromper la disette, mars-avril)</li>
				<li><b>Saison des chevreaux et agneaux</b> → lait, fromages frais (avril-mai)</li>
				<li><b>Plantation au potager</b> (fèves, raves, choux, avril-mai)</li>
				<li><b>Réparation des chaumes</b> avec du roseaux sec (toits endommagés par les tempêtes d’hiver, mai)</li>
				<li><b>Tonte des moutons</b> (dès qu’il fait assez chaud)</li>
				<li><b>Chasse aux essaims</b> (capture de nouvelles reines d’abeilles pour les ruches, juin)</li>
				<li><b>Pêche</b> (dès le dégel des rivières)</li>
				<li><b>Corvées seigneuriales</b> (entretien des fossés et chemins )</li>
			</ul>
		</details>

		<!-- été -->
		<details>
			<summary>
				<h4>Été </h4>
			</summary>
			<ul>
				<li><b>Fauchage</b> des foins (juin, pour les bêtes, à la faux)</li>
				<li><b>Retournement et séchage du foin</b> (plusieurs jours, juin)</li>
				<li><b>Rentrage du foin</b> dans les granges</li>
				<li><b>Soin de la vigne</b> (juin-juillet)</li>
				<li><b>Moisson</b> (juillet-août, à la faucille)</li>
				<li><b>Battage</b> immédiat d’une partie du grain (au fléau ou par un mulet, août)</li>
				<li><b>Vaine pâture</b> (lâcher du bétail sur les champs, août)</li>
				<li><b>Jardinage</b> intensif (récolte des légumes)</li>
				<li><b>Rouissage du lin et du chanvre</b> (trempage dans la rivière,août)</li>
				<li><b>Taille</b> des cerisiers et pruniers (fin de l’été)</li>
			</ul>

			<p><b>Le chaume</b> (les courtes tiges fichées au sol après la coupe) sert de pâture, mais il est aussi parfois brûlé pour fertiliser.</p>

			<p><b>La paille</b> (les longues tiges coupées avec les épis, séparées au battage) sert principalement à la litière des animaux, mais également à la toiture (paille de seigle), comme fourrage d’appoint (en cas de disette fourragère), pour la vannerie et pour l’épandage dans les rues et dans les maisons.</p>
		</details>

		<!-- automne -->
		<details>
			<summary>
				<h4>Automne</h4>
			</summary>
			<ul>
				<li><b>Glanage</b> (les pauvres ramassent ce qui reste après la moisson, septembre)</li>
				<li><b>Cueillette</b> (baies, pommes, noix, châtaignes, champignons, septembre)</li>
				<li><b>Vendanges</b> (septembre-octobre)</li>
				<li><b>Pressage</b> des pommes et des raisins (septembre-octobre)</li>
				<li><b>Dîme et Cens</b> (impôts en nature, fin septembre)</li>
				<li><b>Labours</b> (octobre)</li>
				<li><b>Semailles</b> d’hiver (qui germeront au printemps suivant, octobre)</li>
				<li><b>Glandée</b> (les porcs vont en forêt se gaver de glands – octobre-novembre)</li>
				<li><b>Abattage des porcs</b> engraissés (novembre) → salaison, charcuterie</li>
				<li><b>Rentrée des bêtes</b> à l’étable (fin octobre-novembre)</li>
				<li><b>Préparation des ruches</b> pour l’hiver (fin octobre-novembre)</li>
				<li><b>Curage d’automne</b> (nettoyage des fossés et canaux, novembre)</li>
			</ul>
		</details>

		<!-- toute l’année -->
		<details>
			<summary>
				<h4>Toute l’année</h4>
			</summary>
			<ul>
				<li><b>La corvée d’eau :</b> va-et-vient entre les maisons et le puits, la fontaine ou la rivière.</li>
				<li><b>Le ramassage du bois de chauffe :</b> vieillards ou enfants qui reviennent de la forêt avec de lourds fagots.</li>
				<li><b>Le moulin et le four :</b> des paysans portant de lourds sacs de grain vers le moulin, ou revenant du four avec de grandes miches de pain noir.</li>
				<li><b>La cuisine :</b> une fumée grisâtre qui s’échappe du chaume des toits (pas toujours de cheminée), l’odeur du bouillon de légumes qui mijote toute la journée.</li>

				<li><b>Réparation du chaume des toits</b></li>
				<li><b>Gâchage du torchis :</b> des villageois les pieds dans la boue, mélangeant de la terre, de la paille hachée et de la bouse pour colmater des fissures sur les murs.</li>
				<li><b>Entretien des outils :</b> bruit strident d’une lourde meule à manivelle pour affûter les outils.</li>
				<li><b>Réparation de clôture ou de bâtiment</b></li>
				<li><b>Entretien des chemins d’accès :</b> reboucher une ornière remettre une planche par dessus un petit ruisseau.</li>

				<li><b>Lessive :</b> groupe de femmes au bord du cours d’eau qui battent le linge.</li>
				<li><b>Filage ambulant :</b> des femmes qui marchent, gardent les bêtes ou discutent sur le pas de leur porte, mais dont les mains s’activent à filer la laine au fuseau et à la quenouille.</li>

				<li><b>Curage des étables :</b> un paysan qui sort le fumier à la fourche et l’accumule en un tas fumant devant l’entrée de sa maison.</li>
				<li><b>La traite et le soin :</b> traite des vaches ou des brebis au piquet.</li>

				<li><b>Garde des basses-cours :</b> des gamins avec des bâtons qui guident des oies ou quelques porcs sur les chemins.</li>
				<li><b>Effarouchement :</b> des enfants postés près des potagers qui crient, agitent des chiffons ou lancent des cailloux pour chasser les oiseaux et les lièvres des cultures.</li>
				<li><b>Recherche d’une bête égarée</b></li>
			</ul>
		</details>
	</details>

	<!-- Quelques chiffres -->
	<details>
		<summary>
			<h3>Quelques chiffres</h3>
		</summary>

		<p>Les surfaces mentionnées ci-dessous incluent : la terre cultivée, la terre en jachère, les pâturage, les haies, les chemins d’exploitation…</p>

		<h4>Surface exploitée</h4>

		<p>Une famille de paysans (5 personnes en moyenne) exploite une surface qui dépend de ses moyens (outils, animal de bât) et de la difficulté d’exploitation (type de sol, dénivelé).</p>

		<!-- table exploitation -->
		<table class="left-1">
			<tr>
				<th>Conditions</th>
				<th>Surface (ha)</th>
			</tr>
			<tr>
				<td>Optimale</td>
				<td>15</td>
			</tr>
			<tr>
				<td>Bonne</td>
				<td>12,5</td>
			</tr>
			<tr>
				<td>Moyenne</td>
				<td>10</td>
			</tr>
			<tr>
				<td>Difficile</td>
				<td>7</td>
			</tr>
			<tr>
				<td>Très difficile</td>
				<td>5</td>
			</tr>

		</table>

		<h4>Rendements</h4>

		<p>Surface nécessaire à l’alimentation de 100 personnes selon la fertilité de la terre.</p>

		<!-- table fertilité -->
		<table>
			<tr>
				<th>Fertilité</th>
				<th>ha/100 pers.</th>
			</tr>
			<tr>
				<td>Exceptionnelle</td>
				<td>65</td>
			</tr>
			<tr>
				<td>Bonne</td>
				<td>100</td>
			</tr>
			<tr>
				<td>Moyenne</td>
				<td>150</td>
			</tr>
			<tr>
				<td>Peu fertile</td>
				<td>300</td>
			</tr>
		</table>

		<p>Ces valeurs supposent une année de <b>productivité</b> « moyenne ». Le facteur de productivité est compris entre 0,6 (année catastrophique) et 1,2 (année exceptionnelle).</p>

		<p>Il faut ensuite tenir compte des <b>pertes</b> liées au transport et au stockage (entre 10 et 20 %).</p>

		<p>En moyenne, il faut <b>100 paysans et 200 hectares pour nourrir 20 personnes</b> non impliquée dans des activités agricoles, soit <b>15 citadins</b>.</p>
	</details>

	<!-- Outils et techniques agricoles -->
	<details>
		<summary>
			<h3>Outils et techniques agricoles</h3>
		</summary>
		<p>
			<b>L’araire :</b> charrue de bois dépourvue de roues. Elle creuse des sillons sans retourner la terre. Efficace sur les sols légers mais insuffisante pour les terres humides, argileuses du nord.<br>
			<b>La charrue :</b> la charrue à versoir aère la terre en profondeur. Outil coûteux qui contient du fer et nécessite la force d’un animal de trait (des bœufs plutôt que des chevaux).<br>
			<b>La herse :</b> instrument aratoire formé d’un châssis muni de fortes dents et qui sert, après le labour, à briser les mottes.<br>
			<b>La houe :</b> pioche à large fer courbé servant à remuer la terre.<br>
			<b>Autres instruments :</b> faucille, faux, râteau, fourche, fléau à grains.
		</p>

		<p><b>L’assolement triennal :</b> pratique la plus répandue. 1<sup>e</sup> année : céréales d’hiver, 2<sup>e</sup> année : céréales de printemps, 3<sup>e</sup> année : jachère.</p>
		<p><b>L’irrigation</b></p>
		<p><b>Le fumier</b> est l’un des seuls fertilisants que l’on connaisse à cette époque, mais son utilisation est peu répandue car il faut pour cela avoir un cheptel développé.</p>
	</details>

</article>

<!-- Le village médiéval -->
<article>
	<h2>Le village médiéval</h2>

	<!-- Les bâtiments -->
	<details>
		<summary>
			<h3>Les bâtiments</h3>
		</summary>

		<p>Quelques édifices typiques d’un village médiéval.</p>

		<!-- La maison de paysan libre -->
		<details>
			<summary>
				<h4>La maison de paysan libre</h4>
			</summary>

			<p>Ces chaumières sont réservées aux paysans auxquels le seigneur a concédé une tenure et qui ne sont pas soumis au servage.</p>

			<p>Elle est constitué d’une grande pièce ou comprenant une cheminée, des couches, une table et des bancs avec parfois une petite pièce attenante contenant quelques provisions et du bois. En guise de dépendances, elles possèdent souvent une porcherie ou une étable.</p>

			<figure>
				<img src="/assets/img/village-maison-paysan-libre.webp" alt="Plan d’une maison de paysan">
			</figure>
		</details>

		<!-- La maison riche -->
		<details>
			<summary>
				<h4>La maison « riche »</h4>
			</summary>

			<p>Ce type de demeure est habité par des hommes libres tels que le boulanger ou certains paysans possédant leurs propres terres et leurs propres bêtes.</p>

			<p>Une grande salle commune où siège une imposante cheminée sert de pièce à vivre. On y trouve une grande table, bancs et fauteuils. Il peut également y avoir une ou deux chambre à coucher. Il y a également un entrepôt pour les vivres, le vin, l’huile et le bois, ainsi qu’un grenier où l’on fait sécher la viande</p>

			<figure>
				<img src="/assets/img/village-maison-riche.webp" alt="Plan d’une maison riche">
			</figure>
		</details>

		<!-- La maison de serf -->
		<details>
			<summary>
				<h4>La maison de serf</h4>
			</summary>

			<p>Ces cahuttes rudimentaires servent de logis aux serfs dont la tenure est si petite qu’il leur faut à l’occasion se louer aux autres villageois pour assurer leur subsistance. Elles sont toujours très sales et d’une grande pauvreté.</p>

			<p>Elle est constitué d’une unique pièce où l’on trouve une cheminée, des couches, une table et des bancs, quelques provisions et du bois.</p>

			<figure>
				<img src="/assets/img/village-maison-serf.webp" alt="Plan d’une maison de serf">
			</figure>
		</details>

		<!-- Le manoir du régisseur -->
		<details>
			<summary>
				<h4>Le manoir du régisseur</h4>
			</summary>

			<p>Le régisseur est un fonctionnaire du seigneur chargé de veiller à ce que les taxes de son maître soient bien perçues. Il supervise aussi toutes les activités du village et a la charge de la police. Le manoir ne lui appartient pas, mais il est autorisé à y habiter. En cas de visite du seigneur, il se retire dans l’étable avec ses proches.</p>

			<p>Le manoir comporte une cave à demi enterrée, où sont stockés vivres, tonneaux et bois de chauffage, l’étage principal, où une grande salle à vivre et deux chambres, et un grenier.</p>

			<p>Le manoir lui-même est entouré d’une palissade. À l’intérieur de cette cour, il y a parfois un puits, un potager, quelques animaux (poules, cochons, chèvres et/ou moutons, chevaux), une grange à foin et éventuellement une fromagerie.</p>

			<figure>
				<img src="/assets/img/village-manoir-regisseur.webp" alt="Plan d’un manoir de régisseur">
			</figure>
		</details>

		<!-- Le moulin -->
		<details>
			<summary>
				<h4>Le moulin</h4>
			</summary>

			<p>C’est ici qu’est moulu tout le grain (blé, orge, seigle, mais, avoine) des récoltes du village. Le moulin appartient au seigneur et le meunier prélève 20 % sur tout ce qu’il moud. Une partie de ce prélèvement constitue son salaire, l’autre étant reversée au seigneur.</p>

			<p>On y trouve : une réserve de grains, la pièce centrale, où vit le meunier et qui contient la mécanique du moulin ainsi que la meule, la chambre du meunier.</p>

			<figure>
				<img src="/assets/img/village-moulin.webp" alt="Plan d’un moulin">
			</figure>
		</details>

		<!-- La forge -->
		<details>
			<summary>
				<h4>La forge</h4>
			</summary>

			<p>On vient y ferrer les chevaux et les bœufs, mais elle est aussi utilisée pour la fabrication des outils (socs de charrues, haches, faux, etc.) et de quelques armes qui sont revendues aux voyageurs de passage. Le seigneur perçoit également une taxe sur tout ce qui est produit par la forge.</p>

			<p>On y trouve : la forge, l’enclos pour ferrer les bêtes, une ou deux chambres.</p>

			<figure>
				<img src="/assets/img/village-forge.webp" alt="Plan d’une forge">
			</figure>
		</details>

		<!-- La chapelle -->
		<details>
			<summary>
				<h4>La chapelle</h4>
			</summary>

			<p>Petit église, dont le grenier sert souvent de silo. Les offices ont lieu deux fois par semaine et tous les habitants sont conviés à y assister sous peine d’être accusés d’avoir le « mauvais œil ». En cas d’attaque de pillards, les villageois viennent s’abriter dans la chapelle dont les murs percés de meurtrières se prêtent parfaitement à une défense acharnée. Dans ce cas, les pigeons voyageurs qui sont élevés ici, sont envoyés pour prévenir le seigneur.</p>

			<p>À l’étage ou attenant à la chapelle, on peut trouver l’habitation du prêtre, un pigeonnier et éventuellement un abris pour les pèlerins de passage. Il y a également, dans les environs immédiat du temple, le cimetière du village.</p>

			<figure>
				<img src="/assets/img/village-chapelle.webp" alt="Plan d’une chapelle">
			</figure>
		</details>

		<!-- L’abattoir-saloir -->
		<details>
			<summary>
				<h4>L’abattoir-saloir</h4>
			</summary>

			<p>Il est interdit aux villageois d’abattre une bête sans l’accord exprès du seigneur ou du régisseur. Chaque animal tué ici fait l’objet du versement d’une taxe. Personne ne vit dans ce bâtiment. On y trouve un entrepôt à sel, la salle d’abattage proprement dite et le saloir. Ces petits bâtiments donnant tous sur une même cours où patientent les animaux envoyé à l’abattage.</p>

			<figure>
				<img src="/assets/img/village-abattoir-saloir.webp" alt="Plan d’un petit abattoir-saloir">
			</figure>
		</details>

		<!-- L’auberge -->
		<details>
			<summary>
				<h4>L’auberge</h4>
			</summary>

			<p><b>Une salle principale</b> où voyageurs, bourgeois affairés, fermiers et ivrognes échangent nouvelles, rumeurs et défis, noyés dans la fumée de l’énorme cheminée.</p>

			<p><b>Un étage</b> comprenant les appartements de l’aubergiste ainsi que quelques chambres au confort sommaire : une housse de lin bourrée de paille fraîche, de la lumière, une table et un siège en bois.</p>

			<p><b>Un grenier</b> pour entreposer le mobilier inutilisé.</p>

			<p><b>Une cave</b> bien remplie.</p>

			<p><b>Une petite écurie</b> où la mule du propriétaire côtoie les montures de voyageurs.</p>

			<p><b>Un aubergiste</b>, petite célébrité locale, aidé de son équipe.</p>

			<figure>
				<img src="/assets/img/village-auberge.webp" alt="Plan d’une auberge classique">
			</figure>
		</details>

	</details>

	<!-- Gérance -->
	<details>
		<summary>
			<h3>Gérance</h3>
		</summary>

		<!-- Les deux type de maires -->
		<details>
			<summary>
				<h4>Les deux types de maires</h4>
			</summary>
			<p><b>Le maire seigneurial (régisseur) :</b> c’est un paysan un peu plus riche que les autres, choisi par le seigneur pour être son contremaître dans le village. Il surveille les travaux et collecte les taxes.</p>
			<p><b>Le maire de commune :</b> si le village est assez gros pour acheter une charte de franchise (accordant des libertés), ce maire-là est choisi par les villageois pour défendre leurs intérêts face au seigneur.</p>
		</details>

		<!-- Les trois scénarios possibles -->
		<details>
			<summary>
				<h4>Les trois scénarios possibles</h4>
			</summary>
			<p><b>1. Le village est sur le fief d’un chevalier</b> qui vit sur place (manoir) : le chevalier commande, son régisseur applique au quotidien. Il n’y a pas de maire autonome.</p>
			<p><b>2. Le village est le siège d’une prévôté</b> : Le prévôt s’installe sur place et absorbe le rôle de régisseur pour ce village. Ce n’est possible que si le village est choisi comme chef-lieu de la prévôté – il doit donc y avoir une bonne raison à cela</p>
			<ul>
				<li>Sans charte : le prévôt dirige seul.</li>
				<li>Avec charte : le prévôt cohabite avec un maire élu par les habitants.</li>
			</ul>
			<p><b>3. Le seigneur vit loin</b> du village :</p>
			<ul>
				<li><b>Sans charte :</b> un régisseur unique gouverne seul au nom du seigneur lointain.</li>
				<li><b>Avec charte :</b> le régisseur (qui protège les intérêt du seigneur) et le maire (qui protège la communauté des paysans) cohabitent et partagent le pouvoir.</li>
			</ul>
		</details>
	</details>

	<!-- Personnalités et ressources -->
	<details>
		<summary>
			<h3>Personnalités &amp; ressources</h3>
		</summary>

		<p>Dans un village de 200-300 habitants.</p>

		<!-- Personnalités -->
		<details>
			<summary>
				<h4>Personnalités</h4>
			</summary>

			<p><b>L’intendant / régisseur :</b> l’homme de confiance et l’œil du seigneur. Il gère les comptes, le terrier (cadastre) et collecte les impôts. Il a un statut social supérieur, sait lire et ne se salit jamais les mains.</p>

			<p><b>Le maire (si village franchisé) :</b> un riche paysan (laboureur) élu par ses pairs pour représenter la communauté et négocier avec le seigneur. Il a une forte autorité morale.</p>

			<p><b>L’aubergiste / tavernier :</b> pas de comptoir formel ici. C’est souvant un paysan aisé qui ouvre la pièce principale de sa maison pour vendre la bière ou le cidre local.</p>

			<p><b>Le curé :</b> souvent d’origine paysanne et presque aussi pauvre que ses ouailles. Il assure les sacrements et sert de scribe de secours car il est souvent le seul lettré du village.</p>

			<p><b>Le meunier :</b> gérant du moulin banal du seigneur. Souvent impopulaire (on l’accuse toujours de tricher sur les taxes de mouture), il vit un peu à l’écart du village, près de l’eau.</p>

			<p><b>Le forgeron / maréchal-ferrant :</b> l’artisan le plus important. Maître du feu et du fer, il répare les outils et soigne les sabots des bêtes de trait. La forge est permanente, mais le forgeron a également des activités agricoles.</p>

			<p><b>Le fournier / boulanger :</b> un paysan-laboureur qui loue le four banal au seigneur. Il gère les stocks de bois, la cuisson collective et prélève la taxe en nature (le fournage). Note : Ce n’est jamais le meunier (interdiction seigneuriale pour éviter les fraudes).</p>

			<p><b>La rebouteuse :</b> souvent une femme âgée. Elle connaît les simples (plantes médicinales), remet les os en place et accouche les femmes.</p>

			<p class="mt-1">Le fournil banal (pendant la cuisson) et la taverne sont les meilleurs endroits pour interroger les locaux et capter les tensions de la région.</p>
		</details>

		<!-- Artisans paysans -->
		<details>
			<summary>
				<h4>Les artisans paysans à temps partiels</h4>
			</summary>
			<p>Ils ont leurs propres champs et n’exercent ces métiers que sur commande ou pendant la morte-saison (automne/hiver).</p>
			<p><b>Charpentier / charron / menuisier :</b> c’est le même homme qui façonne le bois. Il répare le toit d’une chaumière, taille une poutre, fabrique un coffre ou change l’essieu d’une charrette.</p>
			<p><b>Cordonnier / bourrelier :</b> il travaille le cuir lourd. Il passe son temps à rapiécer les chaussures épaisses des paysans et à entretenir les harnais et selles des bêtes.</p>
			<p><b>Tisserand :</b> il récupère la laine ou le lin filé à la maison par les femmes du village pour en faire des pièces de tissu brut et solide.</p>
			<p><b>Vannier :</b> souvent un ancien ou un manouvrier qui tresse l’osier en hiver pour fournir les paniers indispensables aux récoltes et au transport.</p>
		</details>

		<!-- Marchandises et services -->
		<details>
			<summary>
				<h4>Marchandises &amp; services</h4>
			</summary>
			<p><b>Alimentation rustique :</b> du pain de seigle ou d’orge « de garde » (très dur, à tremper), du lard salé, du fromage de chèvre sec, des œufs, du cidre ou de la bière locale.</p>

			<p><b>Matériel de base :</b> Une corde de chanvre grossière, des torches de résine, des chevilles de bois, des sacs en toile.</p>

			<p><b>Rien de luxe :</b> Impossible de trouver des armes ou armures neuves, des vêtements coupés, des épices, du vin fin, du savon, du papier, du parchemin ou des bougies de cire. Pour cela, il faut attendre le colporteur ambulant ou aller au bourg voisin.</p>

			<p><b>Forgerie &amp; réparation :</b> faire ferrer un cheval, réparer un maillon d’armure, une boucle de ceinture, ou faire affûter une lame (Forgeron).</p>

			<p><b>Logement rudimentaire :</b> une place dans la paille de la grange d’un laboureur contre une pièce ou un service. Pas de chambre privée disponible.</p>

			<p><b>Soins d’urgence :</b> un cataplasme d’herbes pour stabiliser une plaie ou faire réduire une fracture (rebouteuse).</p>
		</details>

		<p class="mt-1">Dans un gros village de 700-800 habitants, c’est-à-dire un bourg agricole.</p>

		<!-- Personnalités -->
		<details>
			<summary>
				<h4>Personnalités (ajouts et évolutions)</h4>
			</summary>

			<p><b>L’intendant</b> peut évoluer vers le statut de <b>prévôt</b> si le village est un chef lieu de prévôté.</p>

			<p><b>L’aubergiste (évolution) :</b> ce n’est plus une simple pièce chez un paysan. On trouve désormais une vraie auberge sur l’axe principal, dotée d’une salle commune dédiée, de quelques lits et d’une écurie gérée par un palefrenier à plein temps.</p>

			<p><b>Le garde-chasse / forestier seigneurial :</b> un homme en armes (sergent) dédié à la protection des forêts et des terres du seigneur. Il traque impitoyablement les braconniers et les paysans qui volent du bois.</p>

			<p><b>Le vicaire ou sacristain :</b> avec près de 800 âmes à gérer, le curé ne peut plus tout faire seul. Il est secondé par un vicaire (jeune prêtre) ou un sacristain lettré qui gère l’entretien de l’église et l’école paroissiale s’il y en a une.</p>

			<p><b>Le boucher :</b> la demande est assez forte pour qu’un artisan se consacre à l’abattage et à la vente de viande fraîche plusieurs fois par semaine (et non plus seulement lors des grandes fêtes ou des abattages d’automne).</p>
		</details>

		<!-- Artisans -->
		<details>
			<summary>
				<h4>Les artisans (évolutions et nouveaux venus)</h4>
			</summary>
			<p>Le <b>forgeron</b>, <b>charpentier</b> et le <b>cordonnier</b> passent désormais à plein temps. Ils ont leur propre échoppe fixe et forment un ou deux apprentis (des jeunes du village).</p>
			<p><b>Le potier :</b> le village génère assez de casse pour faire vivre un potier. Il possède son propre four de cuisson et fournit le village et les hameaux voisins en jattes, cruches et pots en terre cuite.</p>
			<p><b>Le maçon / couvreur :</b> avec 150 maisons, l’entretien des toits (chaume ou tuile) et des murs en pierre (souvent ceux de l’église ou du manoir seigneurial) justifie la présence d’un ouvrier du bâtiment permanent.</p>
			<p><b>Le tailleur / couturier :</b> il ne fait pas de la haute couture, mais il assemble les vêtements de dessus (tuniques, manteaux) à partir des tissus bruts fournis par les tisserands locaux.</p>
		</details>

		<!-- Ressources et services -->
		<details>
			<summary>
				<h4>Ressources &amp; services (évolutions)</h4>
			</summary>
			<p><b>Viande fraîche </b>de manière régulière (bœuf, mouton, porc selon les jours d’abattage chez le boucher).</p>
			<p><b>Vaisselle de terre</b> neuve (cruches, gourdes en terre cuite chez le potier).</p>
			<p><b>Chandelles de suif</b> basiques (fabriquées par le boucher ou l’aubergiste avec les graisses animales).</p>
			<p><b>Tissu</b> de laine ou de lin au mètre (directement aux ateliers des tisserands).</p>
			<p><b>Vrai logement :</b> un lit (généralement à partager avec d’autres voyageurs) à l’auberge, et un repas chaud payant (le "plat du jour" mijoté dans le chaudron commun).</p>
			<p><b>Soin des montures :</b> une place d’écurie couverte pour les chevaux, avec du foin frais et de l’avoine (service payant géré par le palefrenier).</p>
			<p><b>Logistique lourde :</b> possibilité de louer les services d’un charretier avec ses bœufs et sa charrette pour transporter du matériel ou du butin volumineux vers la ville la plus proche.</p>
		</details>
	</details>
</article>

<!-- Voyage et rencontres sur la route -->
<article>
	<h2>Voyage et rencontres sur la route</h2>

	<!-- Distances quotidiennes -->
	<details>
		<summary>
			<h3>Distances quotidiennes</h3>
		</summary>

		<h4>À pied</h4>
		<ul>
			<li>En moyenne, un marcheur peut parcourir <b>25 à 30 km par jour</b>. Cette distance prend en compte les arrêts nécessaires, les repas, et le repos.</li>
			<li>Sur de bonnes routes et sans bagages encombrants, cette distance pouvait s’étendre <b>jusqu’à 40 km par jour</b>. C’est un rythme soutenu, souvent pour des raisons impératives.</li>
			<li>Sur un <b>terrain difficile</b> (montagne, forêt, chemins boueux), ou avec un <b>groupe plus important</b> (famille, pèlerins), la distance pouvait tomber à <b>15-20 km par jour</b>.</li>
		</ul>

		<p>Ces chiffres dépendent grandement de l’état des chemins (une voie pavée est un atout majeur), du poids des bagages, des conditions météorologiques et de la santé du voyageur.</p>

		<h4>À cheval</h4>
		<p>La distance que pouvait parcourir un cavalier au Moyen Âge sur de longues distances variait considérablement en fonction de plusieurs facteurs (état des routes, terrain, météo, etc.).</p>

		<ul>
			<li>Une distance moyenne de <b>30 à 50 km par jour</b> est réaliste. Cette estimation correspond à un rythme modéré (pas et trot), permettant de ne pas épuiser le cheval sur le long terme.</li>
			<li>Des <b>pointes à 60 km par jour</b> étaient possibles sur de bonnes routes, mais ne pouvaient pas être maintenues sur plusieurs jours d’affilée.</li>
			<li>Les messagers, qui utilisaient des chevaux de relais, pouvaient atteindre des vitesses bien plus élevées, allant parfois jusqu’à 100 km par jour, voire plus dans des cas exceptionnels. Cependant, ils changeaient de monture régulièrement.</li>
		</ul>

		<h4>Avec des chariots</h4>
		<p>La distance parcourue par un chariot chargé de marchandises au Moyen Âge dépendait largement de l’animal de trait utilisé et de l’état des chemins. Le rythme était considérablement plus lent que celui d’un cavalier ou d’un voyageur à pied.</p>

		<ul>
			<li><b>Tiré par des bœufs :</b> les bœufs sont lents mais très endurants. Un chariot tiré par des bœufs pouvait parcourir <b>15 à 20 km par jour</b>. Leur allure est très faible, mais ils sont capables de tirer de lourdes charges sur de longues distances. C’était une méthode de transport courante pour les marchandises lourdes et volumineuses.</li>
			<li><b>Tiré par des chevaux :</b> Les chevaux de trait sont plus rapides et plus vifs que les bœufs. Un chariot tiré par des chevaux pouvait parcourir <b>25 à 30 km par jour</b>, soit une vitesse comparable à celle d’un marcheur. Cependant, le coût d’entretien des chevaux était plus élevé que celui des bœufs, et ils nécessitaient plus d’attention.</li>
		</ul>

		<p>Ces chiffres sont des moyennes. Les conditions réelles sur les routes médiévales, souvent en mauvais état, boueuses ou encombrées, pouvaient réduire considérablement ces distances. Les convois de marchands voyageaient souvent en groupe pour des raisons de sécurité, ce qui pouvait également ralentir le rythme. De plus, les arrêts pour le repos des animaux et le chargement/déchargement de la marchandise étaient fréquents.</p>

	</details>

	<!-- En région habitée -->
	<details>
		<summary>
			<h3>En région habitée</h3>
		</summary>
		<p>Dans les régions habitées, la plupart des rencontres seront des gens du communs vaquant à leurs occupations quotidiennes.</p>

		<ul class="flow">
			<li><b>Villageois au travail :</b> activités agricoles de saison, garde de bêtes, recherche de bêtes égarées, réparation de clôture, entretien des chemins et fossé. Liés aux corvées et au calendrier agricole du jour.</li>

			<li><b>Convoi de ravitaillement local :</b> charrettes (éventuellement à bras) ou animaux de bât transportant des marchandises locales, animaux menés vers leur lieu d’abattage. Trajet de routine entre le champ, le moulin ou le marché.</li>

			<li><b>Artisans et journaliers itinérants :</b> se déplacent de bourg en bourg à la recherche d’un chantier.</li>

			<li><b>Corvéables de la route :</b> groupe de paysans locaux bouchant des ornières sous la surveillance d’un sergent seigneurial.</li>

			<li><b>Chasseurs, pêcheurs et cueilleurs locaux :</b> cueilleurs de champignons, de baies ou de plantes, braconniers discrets, pêcheurs, bûcherons, charbonniers.</li>

			<li><b>Le chasse-marée (zone de pêche importante) :</b> cavalier menant au galop un convoi de chevaux chargés de paniers de poisson de mer frais. Course contre la montre vers les halles avant que la marchandise ne tourne.</li>

		</ul>

		<!-- <h4>Villageois</h4>
		<p>Près de leur village, ces personnes sont impliquées dans une tâche agricole (garde de troupeau, entretien des cultures, récoltes, recherches de noix ou de baies sauvages, recherche d’un animal égaré, etc) ou autre tâche quotidienne.</p>
		<p>S’ils sont rencontrés sur la route, ils peuvent être en train d’amener leurs produits sur un marché voisin, de revenir du marché, d’aller visiter de la famille (ou d’en revenir), etc.</p>

		<h4>Charretier</h4>
		<p>Les charretiers transportent des marchandises diverses. Dans les zones rurales, il s’agira de produits agricoles ou d’outils (du fumier aux céréales, en passant par des socs de charrues ou de meule de pierre), que ce soit pour le compte de leur seigneur ou pour le leur.</p>
		<p>Sinon, ils peuvent avoir un lien avec « industrie » locale (mine, carrière, argilière) et transporter du matériel approprié.</p>
		<p>Dans des zones peu sûres, ils peuvent être accompagnés d’hommes d’armes.</p>

		<h4>Travailleurs itinérants</h4>
		<p>Les travailleurs itinérants peuvent être des citadins très pauvres cherchant à compléter leur maigres revenus par des travaux agricoles saisonniers (particulièrement à la période des récoltes) ou des paysans qui ont déserté leur tenure ou fui la famine, la guerre, des inondations, la maladie, les incursions de brigands, etc.</p>

		<h4>Mendiants &amp; religieux</h4>
		<p>Les mendiants peuvent être des travailleurs itinérants qui n’ont pas trouvé de travail ou des mendiants « professionnels » (la plupart d’entre eux ayant alors un handicap feint ou réel).</p>
		<p>Les ermites solitaires demandant l’aumône aux voyageurs étaient courants au Moyen Âge. Ils vivaient souvent près de ponts ou de chapelles et demandaient l’aumône en échange de leur entretien.</p>
		<p>Enfin, on peut rencontrer des religieux itinérants prêchant sur la route.</p>

		<h4>Chasseurs communs</h4>
		<p>Ces personnes chassent pour subvenir à leur besoin. Dans les zones habitées, ils chassent le petit gibier si le gibier plus prestigieux est réservés aux noble.</p>
		<p>Dans les zones plus sauvages, les chasseurs recherchent un gibier plus « exotique », généralement pour leur capture et leur revente. Dans ce cas, ils sont généralement assez compétents et relativement bien équipés.</p>

		<h4>Hors-la-loi</h4>
		<p>Il peut s’agir de serfs en fuite, de chasseurs communs qui se sont fait prendre avec du gibier interdit ou de malfaiteurs fuyant la justice locale. Ils peuvent éventuellement être considérés par la population locale comme des justiciers.</p> -->

	</details>

	<!-- Rencontres spécifiques -->
	<details>
		<summary>
			<h3>Rencontres plus rares</h3>
		</summary>

		<ul class="flow">
			<li><b>Marchands au long cours :</b> convoi de lourds chariots bâchés, escortés par des mercenaires.</li>

			<li><b>Chevalier en mission :</b> un homme d’armes en armure, seul ou avec son écuyer. Mission diplomatique ou ralliement à un ban militaire, accomplissement d’une quête pour leur suzerain.</li>

			<li><b>Messager :</b> cavalier épuisé crevant sa monture pour livrer un pli scellé</li>

			<li><b>Nobles en chasse :</b> le seigneur local et sa suite de cavaliers, de chiens et de fauconniers. Exigent que les voyageurs du peuple s’écartent et s’agenouillent sur leur passage.</li>

			<li><b>Apothicaire ambulant :</b> colporteur avec une charrette ou un bât rempli de fioles, d’herbes séchées et de reliques médicales. Vend des remèdes contre la peste, des poisons discrets ou des philtres d’amour douteux aux passants.</li>

			<li><b>Officiels seigneuriaux ou royaux :</b> bailli, prévôt, intendant ou collecteur de taxes avec ses scribes et une troupe de sergents. Déplacement officiel pour tenir les assises de justice, lever l’impôt ou contrôler un domaine.</li>

			<li><b>Haut dignitaire ecclésiastique :</b> évêque ou abbé sur une mule richement harnachée, escorté d’une suite de clercs et de gardes. En tournée d’inspection des paroisses et des monastères.</li>

			<li><b>Patrouille :</b> 4 ou 5 gardes du seigneur inspectant les voyageurs. Cherchent un criminel en fuite, lèvent une taxe exceptionnelle ou annoncent le début d’une guerre.</li>

			<li><b>Troupe de saltimbanques :</b> jongleurs, musiciens itinérants et montreurs d’ours voyageant de fête en fête. Colportent les chansons de geste, les satires politiques et les nouvelles du monde.</li>

			<li><b>Brigands et fugitifs :</b> bandits de forêt embusqués ou criminels en cavale cachés dans les fourrés. Cherchent une cible isolée facile ou un otage à rançonner.</li>

			<li><b>Écorcheurs et mercenaires licenciés :</b> groupe de soldats désœuvrés et cyniques entre deux contrats de guerre. Frontière floue entre le statut de soldat et celui de brigand de grand chemin.</li>

			<li><b>Moine mendiant ou ermite :</b> frère mendiant marchant pieds nus, vivant d’aumônes. Prêche la pauvreté et demande le gîte en échange de bénédictions.</li>

			<li><b>Pèlerins en groupe :</b> marcheurs armés de bourdons (bâtons) et de besaces, voyageant en bande pour la sécurité. Vont ou reviennent d’un sanctuaire lointain avec des rumeurs.</li>

			<li><b>Nobles en grand déplacement :</b> une caravane imposante de chariots, de chevaliers et de valets.</li>
		</ul>

	</details>

	<!-- Rencontres passives -->
	<details>
		<summary>
			<h3>Rencontres passives</h3>
		</summary>

		<ul class="flow">

			<li><b>Gibet seigneurial :</b> fourches en bois où se balancent les restes de brigands pendus à la limite du fief. Avertissement du seigneur pour marquer son droit de haute justice.</li>

			<li><b>Maladrerie (Léproserie) :</b> bâtiment isolé entouré de palissades en bord de route. Zone d’exclusion sanitaire absolue.</li>

			<li><b>Croix de carrefour :</b> monument ou oratoire en pierre situé aux intersections dangereuses. Lieu de halte et de prière pour les voyageurs avant de s’enfoncer dans les bois.</li>

			<li><b>Borne frontière :</b> pierre gravée marquant la limite d’un domaine.</li>

			<li><b>Arbre à loques :</b> les branches sont couvertes de morceaux de tissus noués. Croyance populaire superstitieuse où l’on laisse un vêtement pour transférer une maladie à l’arbre.</li>

			<li><b>Obstacle d’infrastructure :</b> pont de bois effondré, coulée de boue bloquant la voie ou ornières géantes.</li>

		</ul>

	</details>

	<!-- Équipement du voyageur -->
	<details>
		<summary>
			<h3>Équipement du voyageur</h3>
		</summary>
		<h4>La base</h4>
		<p>
			Vêtements et protection contre les intempéries<br>
			Bâton de marche<br>
			Bourse<br>
			Provisions, eau et boissons<br>
			Sac ou besace<br>
			De quoi s’éclairer<br>
			Vaisselle personnelle (couteau, bol en bois, corne creuse, cuillère)<br>
			Affaires liées à la raison du voyage
		</p>

		<h4>Monture et voyage au long cours</h4>
		<p>
			Monture ou bête de somme<br>
			Charrette + pièces de rechange<br>
			Tente<br>
			Cartes (routes commerciales, régions alentour), enroulée dans un sac de cuir<br>
			Pièges (pour la chasse et les intrus)<br>
			Ballot ou fagot (bois pour le feu)<br>
			Affaires pour hygiène (rasoir, peigne, miroir, savon)
		</p>

		<h4>Outils</h4>
		<p>
			Selon la profession
		</p>

		<h4>Richesses</h4>
		<p>
			Bijoux<br>
			Potions<br>
			Objet magique<br>
			Or, argent, pierres précieuses<br>
			Statuettes religieuse, icônes, encensoir, bols, candélabre, symbole béni<br>
			Fourrure et peaux rares et exotiques<br>
			Épices rares, parfum ou autres substances rares
		</p>

		<h4>Objets divers</h4>
		<p>
			Intrument de musique<br>
			Pipe, tabatière et tabac<br>
			Dés, carte à jouer<br>
			Babioles type souvenir personnel<br>
			Animal de compagnie<br>
			Livre ou registre<br>
			Acte juridique, proclamation ou laisser-passer<br>
			Clés
		</p>

	</details>

</article>

<!-- Organisation du pouvoir -->
<article>
	<h2>Organisation du pouvoir</h2>

	<!-- Structure hiérarchique -->
	<details>
		<summary>
			<h3>Structure hiérarchique</h3>
		</summary>

		<!-- La direction politique -->
		<details>
			<summary>
				<h4>La direction politique</h4>
			</summary>

			<p><b>Le seigneur :</b> autorité suprême du fief. Il détient le pouvoir de justice, de guerre et de ban (ordonner et punir). Toutes les décisions se prennent en son nom, mais sa liberté réelle dépend souvent de son armée et de ses finances.</p>

			<p><b>Le sénéchal :</b> le principal serviteur du seigneur. Il coordonne les grands officiers (<i>connétable</i>, <i>chancelier</i>, <i>trésorier</i> et <i>grand intendant</i>) sans être leur supérieur hiérarchique, surveille l’exécution des décisions et peut gouverner au nom du seigneur en son absence. Rôle parfois fusionné avec celui de <i>chancelier</i> ou celui de <i>grand chambellan</i>.</p>
		</details>

		<!-- Organes de contrôle -->
		<details>
			<summary>
				<h4>Les organes de contrôle, d’expertise et de décision</h4>
			</summary>

			<p><b>Le conseil seigneurial :</b> assemblée restreinte des proches du seigneur, des hauts fonctionnaires (dont au moins un légiste) et des vassaux les plus influents. Il débat des affaires stratégiques (guerre, traités, impôts exceptionnels) et conseille le seigneur dans sa prise de décision.</p>

			<p><b>La chambre ou le bureau des comptes :</b> contrôle les comptes, épluche les registres des receveurs, valide les dépenses de la cour et traque les détournements de fonds. Travaille parallèlement avec le trésorier (pas de rapport hiérarchique).</p>
		</details>

		<!-- Les grands chefs de service -->
		<details>
			<summary>
				<h4>Les grands chefs de service et leurs assistants</h4>
			</summary>

			<p><b>Connétable :</b> commandant suprême des armées. L’équivalent pour la marine est <b>l’Amiral</b>.</p>
			<ul>
				<li><b>Maréchal :</b> commande en second, discipline, logistique.</li>
				<li><b>Maître d’artillerie :</b> machines de siège et artillerie.</li>
				<li><b>Châtelain :</b> commandant d’une forteresse et de sa garnison (nommé directement par le connétable, rend compte à lui en temps de guerre).</li>
				<li><b>Capitaines</b> nommés pour mener une campagne ou diriger une garnison spécifique</li>
			</ul>

			<p><b>Grand Juge :</b> chef de l’appareil judiciaire central. Il préside la haute cour au nom du seigneur, tranche les conflits de compétence entre prévôts et baillis, et examine les appels.</p>
			<ul>
				<li><b>Lieutenant civil :</b> adjoint spécialisé dans les litiges de biens, d’héritages et de contrats.</li>
				<li><b>Lieutenant criminel :</b> adjoint spécialisé dans les crimes de sang, de haute trahison et la haute justice (peine de mort).</li>
				<li><b>Procureur seigneurial :</b> l’accusateur public. Défend les intérêts et les droits du seigneur face aux accusés.</li>
			</ul>

			<p><b>Chancelier :</b> chef de la chancellerie (actes, sceau, archives, diplomatie écrite).</p>
			<ul>
				<li><b>Garde-sceau :</b> détient et appose le sceau du seigneur.</li>
				<li><b>Secrétaire principal :</b> rédige la correspondance importante du seigneur.</li>
			</ul>

			<p><b>Trésorier :</b> gestion financière (gardien du trésor physique, liquidités courantes, salaires de la cour, travaille en lien direct avec la chambre des comptes).</p>
			<ul>
				<li><b>Garde du trésor :</b> clés et inventaire physique.</li>
				<li><b>Contrôleur des comptes :</b> vérifie les comptes des receveurs avant transmission à la chambre.</li>
				<li><b>Receveur général :</b> centralise les revenus des prévôts et régisseurs (interface avec le trésorier).</li>
				<li><b>Maître de la monnaie :</b> atelier monétaire (si pertinent).</li>
			</ul>

			<p><b>Grand Chambellan :</b> chef des opérations civiles et économiques (administration des territoires, ressources naturelles, infrastructures, rentabilité des terres).</p>
			<ul>
				<li><b>Maître des eaux et forêts :</b> gestion forestière et droits de chasse/pêche.</li>
				<li><b>Voyer général :</b> supervise l’état des routes, ponts, bâtiments publics</li>
				<li><b>Maître des corvées :</b> planification des corvées sur la réserve</li>
			</ul>
		</details>

		<!-- Relais d’autorité dans les territoires -->
		<details>
			<summary>
				<h4>Relais d’autorité dans les territoires</h4>
			</summary>

			<p>Le <b>bailli</b> est représentant direct du seigneur et du conseil sur un grand district territorial (le bailliage). Il exerce localement les pouvoirs délégués du seigneur (justice, levée des troupes, collecte des taxes) et supervise les <b>prévôts</b> (affectés à des sous-district). C’est le visage de l’autorité centrale en province, un officier de carrière, instruit (légiste), souvent étranger à la région, payé par la cour centrale pour surveiller et brider les abus des prévôts. Il s’appuie sur une petite équipe : lieutenant, clerc, sergent, receveur local.</p>

			<p>Beaucoup de prévôts, receveurs et sergents <b>achètent leur charge</b> et se remboursent sur les administrés. Ce système de privatisation peut générer des abus, de la corruption et des conflits d’intérêt avec les motivations des officiers.</p>

			<p>Les <b>messagers et courriers</b> jouent un rôle essentiel dans la communication entre l’administration centrale et les territoires éloignés.</p>
		</details>

		<!-- Notes & remarques -->
		<details>
			<summary>
				<h4>Notes &amp; remarques</h4>
			</summary>

			<p>Dans les faits, un même homme peut <b>cumuler plusieurs offices</b>, ce qui brouille la hiérarchie théorique et ouvre la porte aux abus.</p>

			<p>Le pouvoir médiéval <b>repose beaucoup sur les vassaux.</b> Ces derniers (chevaliers et barons), doivent le service militaire (ost) est peuvent siéger au Conseil par devoir féodal. Ils entrent souvent en conflit avec les « légistes » (les roturiers instruits qui prennent le pouvoir administratif).</p>

			<p>Pour un <b>seigneur local</b> (baron, châtelain), la quasi-totalité des rôles de grands chefs de service fusionne. Le sénéchal ou un unique régisseur gère les finances et le civil, tandis que le seigneur gère le militaire en direct.</p>
		</details>

	</details>

	<!-- Défense -->
	<details>
		<summary>
			<h3>1. Défense</h3>
		</summary>

		<h4>Organisation</h4>
		<p>Dirigée par le <b>connétable</b>.</p>

		<h4>Branches</h4>
		<ul>
			<li>Armée permanente (chevaliers, garnison)</li>
			<li>Levée (service militaire des vassaux, milice locale)</li>
			<li>Fortifications (construction et entretien)</li>
			<li>Ravitaillement militaire</li>
			<li>Marine (à l’échelle d’un royaume côtier)</li>
			<li>Renseignement (surveillance des frontières et espionnage militaire)</li>
		</ul>

		<h4>Acteurs du quotidien</h4>
		<ul>
			<li><b>Sergent d’armes :</b> commande une escouade de soldats professionnels sur le terrain.</li>
			<li><b>Capitaine de la porte :</b> contrôle les entrées et sorties d’une place forte ou d’un château.</li>
			<li><b>Guetteur :</b> surveille les approches depuis les tours et sonne l’alerte.</li>
			<li><b>Capitaine de milice :</b> rassemble, arme et dirige les paysans en cas d’attaque locale.</li>
			<li><b>Fourrier / Pourvoyeur :</b> réquisitionne ou achète les vivres et les logements pour la troupe.</li>
			<li><b>Armurier seigneurial :</b> gère l’arsenal et entretient le matériel militaire de la garnison.</li>
			<li><b>Éclaireur :</b> patrouille aux frontières et repère les mouvements ennemis à l’extérieur.</li>
			<li><b>Maître d’armes :</b> entraîne les recrues, la garde et les proches du seigneur au combat.</li>
		</ul>

		<p>Le <b>titre de sergent</b> est particulièrement polyvalent au Moyen Âge. Il désigne un combattant non-chevalier mais aussi un officier subalterne chargé de faire exécuter les ordres.</p>
	</details>

	<!-- Maintien de l’ordre -->
	<details>
		<summary>
			<h3>2. Maintien de l’ordre</h3>
		</summary>

		<h4>Organisation</h4>
		<p>Géré par le <b>prévôt de la cité</b> (officier urbain, distinct du prévôt rural) sous la direction du seigneur et de son conseil.</p>
		<p>Dans les territoires éloignés, supervisé par le <b>bailli</b>, appliqué localement par les <b>prévôts ruraux</b> et les châtelains.</p>

		<h4>Branches</h4>
		<ul>
			<li>Guet et patrouilles (sécurité intérieure)</li>
			<li>Contrôle des routes et des frontières</li>
			<li>Contrôle des marchés (poids, mesures, fraudes)</li>
			<li>Répression du banditisme</li>
			<li>Gestion des prisons</li>
			<li>Renseignement (surveillance des routes, recherche des criminels, détection des troubles)</li>
		</ul>

		<h4>Acteurs du quotidien</h4>
		<ul>
			<li><b>Sergent du prévôt :</b> patrouille en ville de jour, maintient le calme et exécute les ordres d’arrestation du prévôt.</li>
			<li><b>Sergent du guet :</b> dirige les patrouilles nocturnes en ville et arrête les perturbateurs.</li>
			<li><b>Garde des foires :</b> surveille les marchés, règle les disputes de marchands et arrête les voleurs à la tire.</li>
			<li><b>Mesureur juré :</b> contrôle la conformité des poids, des balances et la qualité des marchandises.</li>
			<li><b>Garde des prisons :</b> gère les registres de l’établissement et surveille les cellules de rétention.</li>
			<li><b>Sergent des routes :</b> patrouille à cheval sur les grands chemins pour chasser les brigands.</li>
			<li><b>Chasse-gueux :</b> expulse les vagabonds, les mendiants et les étrangers suspects hors des murs.</li>
			<li><b>Informateur :</b> espion payé par le prévôt pour surveiller les tavernes et dénoncer les suspects.</li>
		</ul>
	</details>

	<!-- Justice -->
	<details>
		<summary>
			<h3>3. Justice</h3>
		</summary>

		<h4>Organisation</h4>
		<p>Rendue directement par le <b>seigneur</b>, son conseil, le <b>prévôt de la cité</b>, ou le <b>Grand Juge</b> si cette fonction existe.</p>
		<p>Dans les territoires éloignés, supervisé par le <b>bailli</b>, appliqué localement par les <b>prévôts ruraux</b>.</p>

		<h4>Branches</h4>
		<ul>
			<li>Organisation des juridictions et des recours</li>
			<li>Enquête judiciaire et instruction</li>
			<li>Jugement (tribunal seigneurial, cour royale…)</li>
			<li>Exécution des peines</li>
			<li>Gestion des amendes et confiscations</li>
		</ul>

		<h4>Acteurs du quotidien</h4>
		<ul>
			<li><b>Sergent de justice :</b> exécute les décisions du tribunal, procède aux saisies de biens et expulse les condamnés.</li>
			<li><b>Enquêteur :</b> officier envoyé sur le terrain pour interroger les témoins, chercher les indices et rassembler les preuves.</li>
			<li><b>Greffier :</b> rédige les dépositions, consigne les aveux sous la dictée et tient le registre des sentences.</li>
			<li><b>Geôlier :</b> garde les accusés en attente de leur procès et gère le quotidien des cachots du tribunal.</li>
			<li><b>Bourreau :</b> exécute les sentences de mort, applique les châtiments corporels et pratique la torture légale lors des interrogatoires.</li>
			<li><b>Priseur-estimateur :</b> évalue la valeur des objets et des terres saisis pour s’assurer qu’ils couvrent le montant des amendes judiciaire</li>
		</ul>
	</details>

	<!-- Législation & chancellerie -->
	<details>
		<summary>
			<h3>4. Législation &amp; chancellerie</h3>
		</summary>

		<h4>Organisation</h4>
		<p>Préparée et mise en forme par le <b>chancelier</b> et les <b>légistes</b> du conseil, puis validée par le seigneur.</p>
		<p>Dans les territoires éloignés, proclamée par le <b>bailli</b> et adaptée localement sous forme de bans par les <b>prévôts</b>.</p>

		<h4>Branches</h4>
		<ul>
			<li>Édits, ordonnances, décrets (décisions importantes)</li>
			<li>Bans locaux (réglementation pratique de la vie quotidienne – agriculture, ressources, infrastructures, sécurité et obligations collectives). </li>
			<li>Réglementation du commerce et des métiers (guildes, prix…) </li>
			<li>Conservation et interprétation du droit coutumier (règles héritées du passé)</li>
			<li>Gestion des archives, des chartes (accord de privilèges) et du terrier</li>
			<li>Rédaction, authentification et diffusion des actes officiels</li>
		</ul>

		<h4>Acteurs du quotidien</h4>
		<ul>
			<li><b>Crieur public :</b> diffuse verbalement les nouvelles lois, bans et décrets seigneuriaux sur les places publiques.</li>
			<li><b>Clerc de chancellerie :</b> rédige les actes officiels, copie les chartes et met en forme la correspondance administrative.</li>
			<li><b>Gardien des archives :</b> gère, classe et protège les registres du terrier, les cartes et les titres de propriété du fief.</li>
			<li><b>Clerc des requêtes :</b> accueille le public, recueille les plaintes ou pétitions et les trie avant leur présentation au conseil.</li>
		</ul>
	</details>

	<!-- Diplomatie -->
	<details>
		<summary>
			<h3>5. Diplomatie</h3>
		</summary>

		<h4>Organisation</h4>
		<p>Dirigée directement par le <b>seigneur</b>, assisté par le <b>chancelier</b> et les membres les plus influents de son conseil.</p>
		<p>Dans les territoires éloignés, assurée par des <b>émissaires</b> envoyés en mission ponctuelle auprès des seigneurs voisins ou des vassaux frontaliers.</p>

		<h4>Branches</h4>
		<ul>
			<li>Relations avec le suzerain (hommage, obligations féodales, arbitrages)</li>
			<li>Relations avec les vassaux (contrôle des fiefs, gestion des crises internes)</li>
			<li>Négociations avec les voisins (frontières, traités, litiges et accords commerciaux)</li>
			<li>Relations avec l’Église (gestion des conflits de pouvoir avec les évêques et abbayes)</li>
			<li>Alliances matrimoniales et politique familiale</li>
			<li>Ambassades et négociations</li>
			<li>Gestion des crises diplomatiques (trêves, rançons, captifs, arbitrages)</li>
		</ul>

		<h4>Acteurs du quotidien</h4>
		<ul>
			<li><b>Héraut d’armes :</b> délivre les messages solennels, annonce les trêves ou les déclarations de guerre, et bénéficie d’un statut d’immunité inviolable.</li>
			<li><b>Chevaucheur :</b> courrier à cheval rapide chargé de transporter la correspondance diplomatique urgente et secrète à travers les territoires.</li>
			<li><b>Truchement :</b> interprète officiel chargé de traduire les discussions avec les émissaires étrangers ou les marchands de passage.</li>
			<li><b>Poursuivant d’armes :</b> assistant du héraut d’armes, souvent utilisé pour les missions diplomatiques de moindre importance ou de repérage.</li>
			<li><b>Hôte des émissaires :</b> officier subalterne chargé de loger, nourrir et surveiller discrètement les délégations étrangères invitées.</li>
		</ul>
	</details>

	<!-- Finance & fiscalité -->
	<details>
		<summary>
			<h3>6. Finance &amp; fiscalité</h3>
		</summary>

		<h4>Organisation</h4>
		<p>Co-dirigé par la <b>chambre des comptes</b> (qui contrôle) et le <b>trésorier</b> ou argentier du seigneur (qui gère).</p>
		<p>Dans les territoires éloignés, supervisé par un <b>receveur général</b>, collecté localement par les <b>prévôts</b>.</p>

		<h4>Branches</h4>
		<ul>
			<li>Revenus directs (taille, capitation, impôts)</li>
			<li>Revenus indirects (péages, tonlieux, droits de marché)</li>
			<li>Droits banaux (redevance d’usage du moulin, four, pressoir)</li>
			<li>Droits régaliens et concessions (exploitation des mines, salines, grandes forêts…)</li>
			<li>Droits féodaux (reliefs, aides, rachat des corvées)</li>
			<li>Dépenses (armée, bâtiments, cour, personnel)</li>
			<li>Monnaie et change *(à l’échelle royale)*</li>
			<li>Comptabilité et trésorerie</li>
			<li>Contrôle et audit des officiers comptables</li>
		</ul>

		<h4>Acteurs</h4>
		<ul>
			<li><b>Receveur local :</b> centralise les impôts d’une circonscription et organise leur transport sécurisé vers le trésor central.</li>
			<li><b>Péager :</b> perçoit les taxes sur les marchandises aux portes des villes, sur les ponts et les cours d’eau.</li>
			<li><b>Collecteur villageois :</b> habitant désigné par sa communauté pour lever l’impôt direct de porte en porte.</li>
			<li><b>Essayeur des monnaies : </b>vérifie le poids, l’aloi et l’authenticité des pièces circulant sur les marchés seigneuriaux.</li>
			<li><b>Clerc de la recette :</b> tient les registres des entrées d’argent et délivre les quittances officielles de paiement.</li>
		</ul>
	</details>

	<!-- Administration des territoires -->
	<details>
		<summary>
			<h3>7. Administration des territoires</h3>
		</summary>
		<h4>Organisation</h4>
		<p>Dirigée par le <b>Grand Chambellan</b>. Le <b>bailli central</b> gère la région autour du siège du pouvoir, et le <b>prévôt de ville</b> s’occupe de la ville où vit le noble.</p>
		<p>Dans les territoires éloignés, supervisée par le<b> bailli</b>, administrée concrètement par les <b>prévôts ruraux</b>, les <b>maires</b> de village et les <b>régisseurs</b>.</p>

		<h4>Branches</h4>
		<ul>
			<li>Gestion de la réserve seigneuriale et planification agricole (travaux de la réserve, corvées, réglementation des récoltes et des communs).</li>
			<li>Entretien des infrastructures, châteaux et bâtiments banaux (routes, ponts, édifices publics, moulins, fours, pressoirs).</li>
			<li>Gestion des ressources naturelles sous autorité souveraine (coupe de bois, droits de chasse, pacage en forêt, exploitation des carrières et mines).</li>
			<li>Relations avec les communautés d’habitants (chartes de franchises, examen des doléances, représentation locale via les prévôts).</li>
			<li>Protection et surveillance des institutions charitables (hôpitaux, léproseries, aumônes).</li>
			<li>Recensement de la population et gestion des archives, des chartes et du terrier.</li>
		</ul>

		<h4>Acteurs</h4>
		<ul>
			<li><b>Régisseur :</b> dirige les travaux agricoles sur la réserve du seigneur et planifie les corvées des paysans.</li>
			<li><b>Garde-forestier :</b> surveille les bois seigneuriaux, réglemente la coupe de bois et traque le braconnage.</li>
			<li><b>Voyer :</b> inspecte l’état des routes, des ponts et ordonne les réparations des infrastructures et bâtiments banaux.</li>
			<li><b>Arpenteur :</b> mesure les parcelles de terre, tranche les litiges de limites de propriété et met à jour le terrier.</li>
			<li><b>Maire de village :</b> notable local choisi pour représenter la communauté paysanne et faire l’interface avec les officiers seigneuriaux.</li>
		</ul>
	</details>

</article>

<!-- Organisation du territoire -->
<article>
	<h2>Organisation des territoires</h2>

	<!-- Rangs de noblesse -->
	<details>
		<summary>
			<h3>Rangs de noblesse</h3>
		</summary>

		<p>La noblesse représentait environ 2 % de la population totale. Environ 80 % à 90 % de ces nobles étaient de simples chevaliers de village ou des écuyers sans terre, dont le niveau de vie matériel était parfois très proche de celui des riches laboureurs (les paysans aisés).</p>

		<!-- Écuyer -->
		<details>
			<summary>
				<h4>1. L’écuyer (noble de sang, sans terre)</h4>
			</summary>
			<p><b>Demeure :</b> pièce louée en ville, partage une chambrée dans la caserne d’un seigneur, ou squatte le manoir de son frère aîné.</p>
			<p><b>Domaine :</b> aucun</p>
			<p><b>Sources de revenus :</b> solde militaire, gains en tournois, gages d’un office public (souvent sergent de prévôt ou enquêteur) ou pension familiale (rente en argent versée par l’aîné de la famille).</p>
			<p><b>Gouverne son domaine via :</b> aucun domaine à gouverner.</p>
			<p><b>Autorité supérieure de contrôle :</b> le prévôt ou le bailli.</p>
			<p><b>Rôle vis-à-vis du suzerain :</b> entièrement disponible pour son employeur (un baron, le prévôt ou le bailli). Il sert souvent de bras droit, de messager de confiance ou de lieutenant sur le terrain. Aucun pouvoir politique propre.</p>
			<p><b>Justice &amp; Puissance militaire :</b> aucun droit de justice sur autrui, mais il possède le privilège juridique de la noblesse (exempté des taxes ordinaires, il ne peut être jugé que par ses pairs ou par un bailli, jamais par un tribunal roturier). Puissance militaire purement individuelle (destrier, armure, armes).</p>
		</details>

		<!-- Chevalier -->
		<details>
			<summary>
				<h4>2. Le simple chevalier (seigneur de fief)</h4>
			</summary>
			<p><b>Demeure :</b> manoir fortifié ou maison forte (en bois ou en pierre).</p>
			<p><b>Domaine :</b> un petit fief (1 village ou quelques hameaux, soit environ 20 à 50 foyers de paysans), qui est imbriqué territorialement dans une châtellenie ou une prévôté</p>
			<p><b>Sources de revenus :</b> cens (loyers sur les terres), corvées (jours de travail gratuits des paysans), banalités (taxes obligatoires sur le moulin, le pressoir ou le four seigneurial) et revente des surplus agricoles.</p>
			<p><b>Gouverne son domaine via :</b> lui-même en direct, parfois aidé par un régisseur agricole roturier pour les comptes ou d’un maire villageois pour relayer ses ordres.</p>
			<p><b>Autorité supérieure de contrôle :</b> le prévôt de la circonscription locale ou son suzerain direct s’il gère son arrière-fief sans intermédiaire.</p>
			<p><b>Rôle vis-à-vis du suzerain :</b> vassal direct (il lui a prêté hommage). Il lui doit l’aide militaire (servir à l’Ost à ses frais, généralement 40 jours par an) et le conseil (assister aux plaids et jugements du suzerain).</p>
			<p><b>Justice &amp; Puissance militaire :</b> basse justice (conflits de voisinage, petits vols, dégâts des bêtes). Puissance militaire individuelle (le chevalier en armure lourde sur son destrier, accompagné de 1 ou 2 valets d’armes à pied).</p>
		</details>

		<!-- Châtelain -->
		<details>
			<summary>
				<h4>3. Le châtelain (seigneur de châtellenie)</h4>
			</summary>
			<p><b>Demeure :</b> un véritable château fort en pierre (avec donjon, remparts et basse-cour).</p>
			<p><b>Échelle du domaine :</b> une châtellenie (un bourg marchand fortifié au pied du château et une dizaine à une vingtaine de villages aux alentours) – territoire militaire et fiscal, qui correspond généralement à l’échelle d’une prévôté.</p>
			<p><b>Sources de revenus :</b> droits de marché et de foire du bourg, tonlieu (taxe sur la vente des marchandises), péages stratégiques (ponts, rivières, cols), banalités élargies et revenus agricoles de ses terres propres.</p>
			<p><b>Gouverne son domaine via :</b> un prévôt (fonctionnaire seigneurial qui installe son tribunal au château), des sergents pour la police des campagnes et un receveur pour la collecte des taxes.</p>
			<p><b>Autorité supérieure de contrôle :</b> le bailli (royal, princier, ducal ou comtal) de la circonscription régionale supérieure ou le grand seigneur direct (baron, comte ou duc) s’il gère son territoire sans intermédiaire.</p>
			<p><b>Rôle vis-à-vis du suzerain :</b> gardien d’un point stratégique du territoire. Il lui doit la garde de sa propre forteresse, l’aide militaire (mener le contingent de sa châtellenie à l’Ost) et le droit de gîte (obligation d’héberger le suzerain et sa suite).</p>
			<p><b>Justice &amp; Puissance militaire :</b> moyenne justice et très souvent haute justice (droit de condamner à mort, gibet). Puissance militaire collective locale : il entretient une garnison permanente professionnelle (archers, sergents à pied) et peut convoquer tous les simples chevaliers de sa châtellenie (ses vassaux) pour former une troupe d’une cinquantaine de cavaliers.</p>
		</details>

		<!-- Le baron -->
		<details>
			<summary>
				<h4>4. Le baron (seigneur de baronnie)</h4>
			</summary>
			<p><b>Demeure :</b> une forteresse majeure ou un château fort d’envergure, conçu pour résister à de véritables sièges.</p>
			<p><b>Domaine :</b> la baronnie. C’est un territoire d’échelle intermédiaire qui englobe plusieurs châtellenies et jusqu’à une centaine de villages ou de bourgs marchands.</p>
			<p><b>Sources de revenus :</b> les taxes sur les foires régionales, les impôts ou rachats de services versés par ses propres vassaux (les châtelains), les droits d’exploitation des ressources stratégiques (grandes forêts, carrières, mines) et les péages sur les axes commerciaux majeurs.</p>
			<p><b>Gouverne son domaine via :</b> un appareil d’exécution complet. Le baron s’appuie sur son conseil seigneurial, son propre réseau de prévôts pour ses terres directes, un receveur général pour centraliser les finances et un capitaine de garnison pour l’aspect militaire.</p>
			<p><b>Autorité supérieure de contrôle :</b> le bailli régional de son suzerain direct (le prince, le duc ou le comte).</p>
			<p><b>Rôle vis-à-vis du suzerain :</b> il est un vassal de haut rang. Il siège à la cour pour conseiller le prince ou le duc sur la politique de la province. En cas de guerre, il doit mener personnellement le contingent militaire de sa baronnie, composé de ses châtelains et chevaliers.</p>
			<p><b>Justice &amp; Puissance militaire :</b> haute justice complète sur ses terres (gibet, condamnations à mort). Puissance militaire d’envergure : il entretient une garde d’élite permanente et peut lever le ban de ses vassaux pour aligner une véritable petite armée de plusieurs centaines d’hommes d’armes.</p>
		</details>

		<!-- Le comte -->
		<details>
			<summary>
				<h4>5. Le comte (seigneur de comté)</h4>
			</summary>
			<p><b>Demeure :</b> un grand château fort et un palais urbain dans la principale cité de son comté.</p>
			<p><b>Domaine :</b> le comté. C’est un territoire d’échelle provinciale qui regroupe plusieurs baronnies et des dizaines de châtellenies.</p>
			<p><b>Sources de revenus :</b> les taxes sur le commerce provincial, les impôts des villes de son domaine, les droits de mutation quand un fief change de mains, et le rachat du service militaire par ses barons.</p>
			<p><b>Gouverne son domaine via :</b> son propre réseau de baillis, une petite chambre des comptes pour centraliser les impôts, et un conseil de juristes qui fixe les coutumes locales.</p>
			<p><b>Autorité supérieure de contrôle :</b> le bailli royal (qui surveille toute la région) ou le roi en personne.</p>
			<p><b>Rôle vis-à-vis du suzerain :</b> grand vassal direct du roi. Il lui doit le conseil à la cour royale et la levée de l’ost (l’armée) de son comté.</p>
			<p><b>Justice &amp; Puissance militaire :</b> haute justice complète. Il peut lever une armée de plusieurs centaines de gens d’armes en convoquant ses barons.</p>
		</details>

		<!-- Duc -->
		<details>
			<summary>
				<h4>6. Le duc (seigneur de duché)</h4>
			</summary>
			<p><b>Demeure :</b> un palais fortifié monumental, rivalisant parfois avec celui du roi.</p>
			<p><b>Domaine :</b> le duché. C’est une principauté immense qui peut englober plusieurs comtés et baronnies. C’est le plus grand découpage territorial avant le royaume.</p>
			<p><b>Sources de revenus :</b> les douanes aux frontières de son duché, les taxes sur les axes fluviaux ou maritimes majeurs, l’exploitation des mines d’or ou d’argent, et le prélèvement d’une part des taxes de ses vassaux (les comtes et barons).</p>
			<p><b>Gouverne son domaine via :</b> un véritable appareil d’état miniature. Il a son propre sénéchal (chef des armées), des baillis ducaux, et un parlement ou une cour de justice souveraine.</p>
			<p><b>Autorité supérieure de contrôle :</b> le roi uniquement (généralement via le grand chambellan ou le chancelier royal pour les affaires diplomatiques). Le duc est trop puissant pour être contrôlé par un simple fonctionnaire.</p>
			<p><b>Rôle vis-à-vis du suzerain :</b> pair du royaume. Sa loyauté est le pilier de la stabilité du pays. Il traite presque d’égal à égal avec le roi.</p>
			<p><b>Justice &amp; Puissance militaire :</b> justice souveraine (le roi ne peut casser ses jugements que dans des cas très rares). Puissance militaire stratégique : il dispose d’une armée permanente de métier et peut mobiliser des milliers de combattants en cas de guerre.</p>
		</details>

	</details>

	<!-- Découpage administratif -->
	<details>
		<summary>
			<h3>Découpage administratif</h3>
		</summary>

		<p>Un territoire assez grand est divisé en <b>bailliages</b> (dirigés par des baillis), eux-même subdivisés en <b>prévôtés</b> (dirigées par des prévôt).</p>

		<!-- Prévoté -->
		<details>
			<summary>
				<h4>La prévôté (circonscription locale)</h4>
			</summary>
			<p><b>Centre d’action :</b> un bourg fortifié ou le château du seigneur local (le châtelain).</p>

			<p><b>Échelle territoriale :</b> locale. Elle englobe<b> un chef-lieu et une dizaine à une vingtaine de villages ou hameaux</b> alentour (environ la même taille qu’une châtellenie – domaine d’un petit seigneur local).</p>

			<p><b>Administré par :</b> le prévôt. C’est un roturier instruit (un juriste ou un riche marchand) ou un noble de rang inférieur (comme un écuyer). Il est salarié ou achète sa charge.</p>

			<p><b>Compétences principales :</b> c’est le premier niveau de l’administration. Le prévôt gère le quotidien : il publie les édits du seigneur, surveille l’entretien des routes, arbitre les conflits de voisinage et gère les marchés locaux.</p>

			<p><b>Finances &amp; Revenus :</b> il collecte directement les taxes de base (cens, péages, taxes de marché) et perçoit les amendes judiciaires. Il garde une part pour ses gages et reverse le reste au bailliage ou au seigneur.</p>

			<p><b>Autorité supérieure :</b> le bailli ou le seigneur si son territoire est trop petit pour un réseau de bailliage.</p>

			<p><b>Force publique &amp; Justice :</b> basse et moyenne justice (vols simples, bagarres, litiges fonciers). Pour faire appliquer ses décisions, le prévôt dispose d’une poignée de sergents à pied (la police locale).</p>
		</details>

		<!-- baillage -->
		<details>
			<summary>
				<h4>Le bailliage (circonscription régionale)</h4>
			</summary>

			<p><b>Centre d’action :</b> une ville, dotée d’un château et d’un tribunal (l’auditoire).</p>

			<p><b>Échelle territoriale :</b> régionale. Un bailliage est un grand territoire provincial (taille d’une baronnie) qui regroupe et chapeaute <b>plusieurs prévôtés (souvent entre 5 et 15)</b>.</p>

			<p><b>Administré par :</b> le bailli. C’est un noble de robe (un grand juriste) ou un noble d’épée de confiance, nommé directement par le seigneur de la région. Sa charge est révocable.</p>

			<p><b>Compétences principales :</b> c’est le représentant du seigneur en province. Le bailli supervise le travail de tous les prévôts, contrôle les comptes, inspecte les garnisons des châteaux, et gère les relations politiques avec la noblesse locale (les barons et comtes de la région).</p>

			<p><b>Finances &amp; Revenus :</b> il ne collecte rien en directement. Sa chambre des comptes locale centralise les recettes envoyées par tous les prévôts, audite leur gestion, et prépare le convoi d’argent qui part vers le trésor du seigneur ou du roi.</p>

			<p><b>Autorité supérieure :</b> le seigneur de la région ou son grand chambellan.</p>

			<p><b>Force publique &amp; Justice :</b> haute justice en première instance (crimes de sang, trahison, fausse monnaie) et tribunal d’appel pour toutes les décisions des prévôts. Pour la force publique, le bailli commande à un capitaine qui dirige une compagnie de gens d’armes professionnels et de sergents à cheval capables d’intervenir dans toute la région.</p>
		</details>

	</details>
</article>

<!-- Château fort -->
<article>
	<h2>Chateau fort</h2>

	<!-- Plan général -->
	<details>
		<summary>
			<h3>Plan général</h3>
		</summary>
		<a href="/assets/img/chateau-01.jpg" target="_blank"><img src="/assets/img/chateau-01-400.webp" alt="plan château fort"></a>
	</details>

	<!-- L’enceinte extérieure -->
	<details>
		<summary>
			<h3>L’enceinte extérieure</h3>
		</summary>

		<!-- La barbacane -->
		<details>
			<summary>
				<h4>La barbacane</h4>
			</summary>
			<p>Petit fortin de bois édifié devant le pont-­levis. La barbacane avait pour but de retarder les assaillants, le temps de relever le pont-levis. Elle était traditionnellement bâtie avant le fossé qui entourait habituellement les ouvrages fortifiés. II arrivait qu’elle soit remplacée par un avant‑poste en pierre.</p>
		</details>

		<!-- La barbacane -->
		<details>
			<summary>
				<h4>Les défenses extérieures</h4>
			</summary>
			<p>Tout autour du fossé se trouvent des haies vives et chevaux de frise (pieux fichés dans le sol) censés briser les charges à cheval.</p>
		</details>

		<!-- Le fossé -->
		<details>
			<summary>
				<h4>Le fossé</h4>
			</summary>
			<p>Le fossé avait pour objectif d’empêcher les agresseurs de s’attaquer directement aux murailles. Les sapeurs devaient d’abord le combler avec des pierres ou des fascines (fagots) avant de commencer à essayer de desceller les moellons des remparts. Les douves étaient en fait rarement remplies d’eau pendant la période médiévale. En plus de leur rôle défensif, elles tenaient lieu de dépotoir et de déversoir pour les latrines.</p>
		</details>

		<!-- Les poternes secondaires -->
		<details>
			<summary>
				<h4>Les poternes secondaires</h4>
			</summary>
			<p>Les remparts sont percés, de loin en loin, de discrètes petites portes en fer, très étroites, réservées aux piétons. Certaines étaient habilement dissimulées derrière des buissons et des arbres. Les défenseurs pouvaient les emprunter afin d’opérer des sorties nocturnes discrètes, sans avoir à ouvrir la grande porte.</p>
		</details>

		<!-- Le pont-levis -->
		<details>
			<summary>
				<h4>Le pont-levis</h4>
			</summary>
			<p>Cet énorme panneau de bois est maintenu en place par d’épaisses chaînes. Parfois, le pont-levis était remplacé par des ouvrages de bois que les défenseurs pouvaient détruire rapidement en cas d’attaque, le but étant toujours de gêner le travail des sapeurs.</p>
		</details>

		<!-- La porte principale -->
		<details>
			<summary>
				<h4>La porte principale</h4>
			</summary>
			<p>Flanquée des deux grosses tours rondes du châtelet d’entrée. Les arrivants sont obligés de passer sous un assommoir. La herse, actionnée par un treuil installé dans la partie supérieure de l’entrée où se trouve le poste de garde, était généralement faite en bois dur, renforcé par des clous et des plaques de métal. L’entrée principale constituant toujours le point faible par lequel les ennemis pouvaient pénétrer dans les lieux, elle était protégée par le pont-levis, la herse et la porte elle‑même (que l’on condamnait, en cas de besoin, à l’aide d’épaisses poutres).</p>
		</details>

		<!-- Le châtelet d’entrée -->
		<details>
			<summary>
				<h4>Le châtelet d’entrée</h4>
			</summary>
			<p>Bâties en saillie, deux énormes tours à mâchicoulis surmontées de toits en poivrière couverts d’ardoises défendent l’entrée du château. Une guette (tourelle de guet) crénelée se dresse dessus de la tour de gauche. Les tours dites « en poivrière » ne font leur apparition qu’aux alentours du XII<sup>e</sup> siècle. Leurs toits étaient recouverts de plaques d’ardoises ou de tuiles capables de résister aux flèches enflammées. Les mâchicoulis, sortes de surplombs en pierre, permettaient aux défenseurs de laisser tomber des projectiles divers (pierres, poix enflammée, eau bouillante, plus rarement huile bouillante) sur les attaquants quand ceux‑ci arrivaient près des murs.</p>
		</details>

		<!-- Les remparts -->
		<details>
			<summary>
				<h4>Les remparts</h4>
			</summary>
			<p>Les courtines hautes de dix mètres sont surmontées par endroits de hourds en bois et leurs parois sont percées d’archères (meurtrières étroites vers l’extérieur et larges à l’intérieur). Des hommes d’armes parcourent l’aléoir (chemin de ronde).</p>
			<p>Les murs faisaient parfois plus de trois mètres d’épaisseur. Quand ils n’abritaient pas des couloirs exigus, ils étaient construits en sandwichs, un blocage de moellons et de cailloux liés par du mortier étant monté entre deux parements externes de pierre de taille. Comme les tours, leurs parois comportaient des trous de boulin dans lesquels on glissait des poutrelles pour édifier des échafaudages temporaires. Parmi ces derniers, il convient de citer les hourds, sortes de galeries en bois que l’on mettait en place en temps de guerre et qui remplissaient le même rôle que les mâchicoulis.</p>
		</details>

		<!-- Les talus -->
		<details>
			<summary>
				<h4>Les talus</h4>
			</summary>
			<p>Des talus inclinés, recouverts de briques, sont visibles au pied des courtines. Ces remblais avaient deux fonctions : leur inclinaison permettait de faire ricocher les projectiles lancés depuis les hourds et les mâchicoulis, et ils compliquaient la tâche des sapeurs et mineurs chargés de percer les murailles.</p>
		</details>

	</details>

	<!-- Basse cour -->
	<details>
		<summary>
			<h3>La basse cour (baille)</h3>
		</summary>
		<p>Les grands châteaux possédaient au moins deux enceintes, concentriques ou cloisonnées. Les étendues assez vastes – ou cours – qui séparaient ces remparts étaient occupées par diverses maisonnettes et échoppes, organisées à la manière de petits villages. C’est dans cet espace que venaient se réfugier les paysans des alentours lorsque la guerre menaçait.</p>

		<p>Dans ces petites habitations vivent les paysans travaillant sur les réserves du seigneur. Elles sont bâties en torchis blanchi à la chaux. Présence d’une forge, d’une échoppe de tailleur et de divers autres ateliers (menuiserie, poterie, etc). Forgerons, charpentiers et tailleurs jouaient un rôle important dans la vie des châteaux.</p>

		<p>En cas de siège, les défenseurs doivent pouvoir disposer de viande fraîche et de lait, d’où l’utilité d’aménager des étables dans l’enceinte même du château. Les bovidés étaient coûteux, on préférait généralement élever des moutons, bien moins exigeants sur le plan de la nourriture.</p>

		<h4>Moulin</h4>
		<p>Les seigneurs s’arrogeaient souvent le privilège de moudre le grain de leurs sujets&hellip; contre espèces sonnantes et trébuchantes !</p>

		<h4>Fontaine</h4>
		<p>Une belle fontaine ouvragée trône au milieu du désordre. Hommes et bêtes viennent s’y abreuver, au milieu des servantes occupées à laver leur linge.</p>

	</details>

	<!-- L’enceinte intérieure -->
	<details>
		<summary>
			<h3>L’enceinte intérieure</h3>
		</summary>

		<p>Un peu plus haute que les remparts extérieurs, la chemise (autre nom de l’enceinte qui entoure le donjon) est de forme carrée et ses tours sont crénelées. Son entrée – défendue, elle aussi, par une herse et une lourde porte de chêne – est dépourvue de pont‑levis. Il n’y a pas de talus à la base des courtines.</p>

		<p>En pénétrant dans l’enceinte intérieure, la première chose que l’on voit, c’est un immense donjon rectangulaire, dressé contre le rempart du fond. Mais, on y voit aussi d’autres bâtiments</p>

		<!-- Les écuries -->
		<details>
			<summary>
				<h4>Les écuries</h4>
			</summary>
			<p>Construites contre le mur est, elles abritent les chevaux du seigneur et de ses soldats.</p>
		</details>

		<!-- Le chenil -->
		<details>
			<summary>
				<h4>Le chenil</h4>
			</summary>
			<p>Une meute de chiens hurlants est hébergée dans une maison basse en bois dont émane une odeur suffocante. La chasse était l’un des rares plaisirs que pouvaient s’offrir les seigneurs et c’est pourquoi ils entretenaient des meutes.</p>
		</details>

		<!-- La chapelle -->
		<details>
			<summary>
				<h4>La chapelle</h4>
			</summary>
			<p>Un château se devait d’avoir un lieu de culte. Celui‑ci pouvait aussi bien être aménagé dans la cour, que dans le donjon même.</p>
		</details>

		<!-- Le grenier -->
		<details>
			<summary>
				<h4>Le grenier</h4>
			</summary>
			<p>Une petite bâtisse carrée et sans fenêtres est accolée au donjon. C’est le grenier, dans lequel sont entassées les réserves de céréales.</p>
		</details>

		<!-- Les puits -->
		<details>
			<summary>
				<h4>Les puits</h4>
			</summary>
			<p>Il ne suffisait pas de choisir un lieu élevé pour édifier un château, encore fallait‑il s’assurer que le sous‑sol abritait des sources ou nappes souterraines. En plus de fournir de l’eau aux habitants du fort, les puits offraient la possibilité de lutter contre les éventuels incendies. En général, chaque castel disposait de plusieurs puits, aménagés aussi bien à l’extérieur des bâtiments, que dans le donjon ou les tours d’enceinte.</p>
		</details>

		<!-- Baraque des domestiques -->
		<details>
			<summary>
				<h4>Baraque des domestiques</h4>
			</summary>
			<p>Les domestiques ne logent pas dans le donjon, mais dans des bâtiments à part.</p>
		</details>

		<!-- La caserne -->
		<details>
			<summary>
				<h4>La caserne</h4>
			</summary>
			<p>Si la garnison du château est importante, les soldats logent dans un bâtiment dédié.</p>
		</details>

		<!-- La maison de l’alchimiste -->
		<details>
			<summary>
				<h4>La maison de l’alchimiste</h4>
			</summary>
			<p>Parfois, les alchimistes bénéficiaient de la protection d’un seigneur, ce qui leur évitait les tracas généralement associés à la sorcellerie.</p>
		</details>
	</details>

	<!-- Le donjon -->
	<details>
		<summary>
			<h3>Le donjon</h3>
		</summary>

		<p>Ce grand édifice rectangulaire et crénelé est le cœur de la forteresse. Pour des raisons de sécurité, ses murs ne sont percés que d’étroites meurtrières. On accède à sa porte en empruntant un escalier de bois qui conduit directement au premier étage. Le rez‑de‑chaussée, quant à lui, ne possède aucune ouverture apparente. Les escaliers extérieurs des donjons étaient en bois de manière à pouvoir être aisément détruits au cas où des ennemis parviendraient jusqu’à la cour intérieure.</p>

		<!-- Rez-de-chaussée -->
		<details>
			<summary>
				<h4>Rez‑de‑chaussée</h4>
			</summary>

			<p><b>Cave.</b> C’est là que les nobles remisent leurs vins et leurs réserves les plus précieuses (viandes séchées ou salées, etc). Un petit coffre encastré dans le mur est équipé d’une serrure complexe. On y range les épices, presque aussi coûteuses que la poudre d’or.</p>

			<p><b>Salle des archives.</b> Une pièce dont les murs sont couverts d’étagères sur lesquelles sont rangés de nombreux parchemins et livres. En cas de différend juridique, on se reporte souvent aux chartes, listes et registres de comptes du château.</p>

			<p><b>Chambre des gardes.</b> C’est dans cette pièce mal éclairée que dorment les dix gardes chargés de la protection rapprochée du seigneur. Deux d’entre eux sont en permanence postés à l’entrée du premier étage.</p>
		</details>

		<!-- Premier étage -->
		<details>
			<summary>
				<h4>Premier étage</h4>
			</summary>

			<p><b>Entrée.</b> Un perron de bois donne sur ce petit vestibule qui peut être isolé du reste du bâtiment par une petite herse de fer. La porte extérieure est également en fer. Un judas caché derrière une tenture de la grande salle permet d’observer à la dérobée les arrivants.</p>

			<p><b>Cuisine.</b> Une grande salle possédant son propre puits et une immense cheminée où l’on peut faire cuire un bœuf entier. Les plats sont préparés sur de grandes tables de chêne. Les ustensiles de cuisine (couteaux, louches, etc) sont accrochés au mur. Saucissons et jambons pendent du plafond.</p>

			<p><b>Grande salle.</b> Une pièce immense et très haute de plafond avec deux cheminées. Sur une estrade, un fauteuil de bois ouvragé sur lequel s’assoit le seigneur lorsqu’il tient audience. Quelques grandes tables et bancs, repoussés sur les côtés sont employés lors des réunions et banquets. Les murs sont couverts de somptueuses tapisseries cousues de fil d’or représentant des scènes de chasse. Des tentures accrochées à des anneaux du plafond permettent de diviser la grande salle en petits cabinets. Pendant la journée, le chapelain donne ici des cours aux enfants du seigneur et de ses officiers.</p>
		</details>

		<!-- Deuxième étage -->
		<details>
			<summary>
				<h4>Deuxième étage</h4>
			</summary>

			<p><b>Chambre du chapelain.</b> Une cellule aux murs nus contenant une paillasse, un petit autel et le trésor du prêtre : une petite bible enluminée. Seul un brasero permet de chauffer cette pièce.</p>

			<p><b>Chambre du chambellan.</b> Chargé de l’organisation administrative du château, le chambellan a droit à sa chambre personnelle. Il dort sur une paillasse et travaille souvent très tard le soir sur des registres de comptes qu’il amène ici.</p>

			<p><b>Chambre des invités.</b></p>

			<p><b>Chambre du seigneur.</b> Un grand lit à baldaquin dans lequel le seigneur son épouse et ses enfants dorment ensemble. Les murs sont couverts de fresques guerrières aux couleurs vives. Dans un coin, un rouet sur lequel la châtelaine travaille le plus clair de son temps. Derrière une tenture, une porte secrète dissimule un étroit escalier qui descend jusqu’au souterrain du sous‑sol.</p>

			<p><b>Salle du treuil.</b> Ce réduit abrite le treuil permettant de remonter la herse du premier.</p>
		</details>

		<!-- Toit -->
		<details>
			<summary>
				<h4>Toit</h4>
			</summary>

			<p><b>Colombier.</b> Quelques pigeons voyageurs sont gardés là, au cas où le seigneur aurait besoin d’appeler rapidement ses alliés.</p>

			<p><b>Cheminées.</b> De petits cônes de briques ouverts du côté opposé au vent dominant.</p>

			<p><b>Chemin de ronde.</b> Le donjon est une sorte de petit château en lui‑même, on l’a donc doté de créneaux et d’un petit chemin de ronde.</p>

			<p><b>Réservoir d’eau.</b> Il permet de collecter l’eau de pluie acheminée jusqu’à lui par tout un système de canalisations et de chéneaux.</p>

		</details>

		<!-- Sous-sol -->
		<details>
			<summary>
				<h4>Sous‑sol</h4>
			</summary>

			<p><b>Chambre de torture.</b> Un seul brasero est installé dans un coin, tandis que les murs sont couverts de tenailles, scies et autres instruments à l’aspect peu engageant. Partout, des anneaux permettent d’attacher les suppliciés dans des positions aussi inconfortables que possible. Contrairement à une idée reçue, les tribunaux médiévaux ne reconnaissaient pas, en théorie les aveux faits sous la torture. Celle‑ci était toutefois largement employée ( "question préalable"), et la simple menace de nouveaux sévices suffisait à faire dire n’importe quoi au premier innocent venu.</p>

			<p><b>Cachots.</b></p>

			<p><b>Chambre forte.</b> Une petite pièce fermée par une porte de bronze à l’énorme serrure. Elle contient le trésor seigneurial : objets en or, impôts, parchemins secrets&hellip;</p>

			<p><b>Souterrain.</b> Un long couloir sinueux s’enfonce dans les profondeurs de la terre et conduit jusqu’au pied du ravin, en contrebas. Ce type d’issue secrète n’était pas fréquent au Moyen Âge. Dans la réalité, les souterrains faisaient souvent office de réfrigérateurs où l’on entreposait les denrées périssables.</p>
		</details>
	</details>

	<!-- Personnel du château -->
	<details>
		<summary>
			<h3>Personnel du château</h3>
		</summary>

		<!-- Encadrement et offices -->
		<details>
			<summary>
				<h4>Encadrement et offices</h4>
			</summary>
			<ul>
				<li><b>Chambellan :</b> chef de l’administration intérieure et de la chambre du seigneur.</li>
				<li><b>Panetier :</b> responsable du pain, du couvert et des stocks de nourriture sèche.</li>
				<li><b>Échanson :</b> responsable de la cave et des boissons.</li>
				<li><b>Maître queux :</b> chef des cuisines, planifie les repas ordinaires et les banquets.</li>
				<li><b>Maître d’hôtel :</b> supervise le protocole, le service et le dressage dans la grande salle (Aula).</li>
				<li><b>Chapelain :</b> prêtre du château, secrétaire et précepteur des enfants.</li>
				<li><b>Barbier-chirurgien :</b> assure l’hygiène (barbe, cheveux) et les soins de santé courants (saignées, extractions dentaires, pansements).</li>
				<li><b>Maréchal des écuries :</b> gère les chevaux, l’équipement équestre et les palefreniers.</li>
				<li><b>Fauconnier / veneur :</b> gèrent les animaux de chasse (rapaces et chiens de meute).</li>
			</ul>
		</details>

		<!-- Domesticité noble -->
		<details>
			<summary>
				<h4>Domesticité noble</h4>
			</summary>
			<ul>
				<li><b>Pages (7 à 14 ans) :</b> fils de nobles en formation. Portent les messages, servent à table et accompagnent la châtelaine.</li>
				<li><b>Écuyers (14 à 21 ans) :</b> futurs chevaliers. Gardent le matériel militaire du seigneur, gèrent son destrier et découpent les viandes d’honneur.</li>
			</ul>
		</details>

		<!-- Domesticité roturière -->
		<details>
			<summary>
				<h4>Domesticité roturière</h4>
			</summary>
			<ul>
				<li><b>Valets et serviteurs :</b> gèrent le gros œuvre quotidien (allumage des feux, transport de l’eau, nettoyage des dalles, entretien courant).</li>
				<li><b>Commis :</b> main-d’œuvre des cuisines sous les ordres du maître queux (épluchage, plonge, tourne-broches).</li>
				<li><b>Servantes et lingères :</b> cantonnées au gynécée (appartements privés) pour la couture, l’entretien des draps et les soins des enfants (nourrices).</li>
			</ul>
		</details>

		<!-- Pôle militaire -->
		<details>
			<summary>
				<h4>Pôle militaire</h4>
			</summary>
			<ul>
				<li><b>Capitaine de la garde :</b> commandant de la garnison et de la défense du château.</li>
				<li><b>Sergent d’armes :</b> sous-officier chargé de l’entraînement, des patrouilles et de la discipline des soldats.</li>
				<li><b>Guetteurs :</b> surveillance permanente depuis les tours et les chemins de ronde.</li>
				<li><b>Maître armurier &amp; forgeron :</b> entretien et réparation du métal (armes, armures, fers des chevaux, ferronnerie du château).</li>
				<li><b>Geôlier :</b> gardien des prisons, des cachots et de la poterne (porte secrète).</li>
			</ul>
		</details>
	</details>

</article>