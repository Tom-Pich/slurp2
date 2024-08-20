<?php

use App\Repository\CreatureRepository;

$creature_repo = new CreatureRepository;
?>

<!-- Caractéristiques des animaux  -->
<article>
	<h2>Caractéristiques des animaux</h2>

	<details>
		<summary class="h3">Force &amp; Points de vie</summary>

		<p>Le poids est la base de calcul permettant d’estimer les PdV et la For d’une créature. Toutes proportions gardées, le poids d’une créature augmente comme le cube de sa taille.</p>

		<?php include "content/components/widget-strength-pdv.php" ?>

		<p><b>Force&nbsp;:</b> l’encadré ci-dessus donne une fourchette de valeurs. Des animaux ayant beaucoup de graisse ou une carapace, par exemple, ont une proportion de muscles plus faibles, et donc une <i>For</i> dans le bas de la fourchette alors que les animaux sans graisse ou volants sont la fourchette haute.</p>
	</details>

	<details>
		<summary class="h3">Autres caractéristiques</summary>
		<p><b>Dextérité :</b> Les prédateurs et autres animaux très agiles ont 14 en Dex, voire plus. Les animaux assez agiles ont 12, les autres ont 10. Ces valeurs peuvent varier de &plusmn; 1 pt selon les individus.</p>
		<p><b>Intelligence :</b> 2 pour un insecte, 3 pour un reptile, 4 pour un mammifère peu intelligent (cheval), 5 pour un mammifère assez intelligent (chien), 6 pour un mammifère très intelligent (chimpanzé, dauphin, etc). Un écart de &plusmn; 1 pt par rapport à ces valeurs de référence est possible mais rare.</p>
		<p><b>Santé :</b> 14 pour un animal robuste et endurant, 12 pour un animal moyen, 10 pour un animal fragile. Ces valeurs peuvent varier de &plusmn; 1 pt.</p>
		<p><b>Perception :</b> 17 pour les animaux qui ont des sens très affinés, 14 pour ceux ayant une bonne perception, 12 pour ceux ayant une perception moyenne et 10 pour les animaux qui font peu attention à leur environnement. Ces scores peuvent être très différents selon le sens utilisé (ouïe, odorat, ...)</p>
		<p><b>Volonté :</b> Les animaux aussi peuvent tenter de résister à des sorts, ce qui est la seule utilité de cette caractéristique. Leur <i>Volonté</i> correspond à Int×2.</p>
		<p><b>Vitesse :</b> vitesse maximale de l’animal. Si rien n’est précisé, il s’agit d’un mode de déplacement terrestre.</p>
		<h4>Encombrement</h4>
		<table class="alternate-e">
			<tr>
				<th>Poids transporté</th>
				<th>Encombrement</th>
				<th>Déplacement</th>
			</tr>
			<tr>
				<td>&le; For</td>
				<td>Nul</td>
				<td>100%</td>
			</tr>
			<tr>
				<td>&le; For ×2</td>
				<td>Léger</td>
				<td>75%</td>
			</tr>
			<tr>
				<td>&le; For ×3</td>
				<td>Moyen</td>
				<td>50%</td>
			</tr>
			<tr>
				<td>&le; For ×6</td>
				<td>Pesant</td>
				<td>25%</td>
			</tr>
			<tr>
				<td>&le; For ×10</td>
				<td>Maximum</td>
				<td><i>Vit</i> = 1</td>
			</tr>
		</table>
		<p>Aucun animal n’acceptera un encombrement supérieur à <i>Pesant</i> et seuls les plus dociles accepteront de dépasser un encombrement <i>Moyen</i>.</p>
	</details>
</article>

<!-- Combat -->
<article>
	<h2>Combat</h2>

	<details>
		<summary class="h3">Dégâts des animaux</summary>
		<p>Les dégâts sont basés sur la <i>For</i> de l’animal, sauf les dégâts de piétinement qui sont basés sur son poids.</p>

		<?php include "content/components/widget-creature-dmg.php" ?>

		<h4>Morsure</h4>
		<p>
			Les dégâts de morsure des carnivores sont <i>Tranchants</i> (ou <i>Perforants</i> si les dents sont très grandes).<br>
		</p>

		<h4>Cornes</h4>
		<p>Les cornes font des dégâts de <i>Broyage</i> (elles ne sont généralement pas assez pointues et tranchantes pour causer des dégâts perforants). Le score indiqué ne tient pas compte d'un éventuel élan de l'animal, qui peut multiplier les dégâts par jusqu'à 1,5.</p>

	</details>

	<details>
		<summary class="h3">Autres caractéristiques de combat</summary>
		<p><b>RD :</b> Une fourrure ou une peau épaisse apporte une RD de 1, de même qu'une couche de graisse épaisse. Certains animaux au cuir épais ont une RD naturelle de 3 ou 4 (éléphant, crocodile, etc).</p>
		<p><b>Attaque(s) :</b> le jet d’attaque est basé sur la <i>Dex</i>.</p>
		<p><b>Esquive :</b> <i>Dex</i> à <i>Dex</i>-3 selon que l’animal soit, ou pas, habitué à se battre.</p>
	</details>

</article>

<!-- Quelques annimaux -->
<article>
	<h2>
		<?php if ($_SESSION["Statut"] == 3) { ?>
			<a href="gestion-listes?req=creature&id=0" class="edit-link ff-far">&#xf044;&nbsp;</a>
		<?php } ?>
		Quelques animaux
	</h2>

	<?php
	$categories = $creature_repo->getDistinctCategories("RdB");
	foreach ($categories as $categorie) { ?>
		<details>
			<summary class="h3"><?= $categorie ?></summary>
			<div class="mt-½">
				<?php
				$creatures = $creature_repo->getCreaturesByCategory($categorie);
				foreach ($creatures as $creature) {
					$creature->displayInRules($_SESSION["Statut"] === 3);
				}
				?>
			</div>
		</details>
	<?php } ?>

</article>

<!-- Considérations diverses -->
<article>
	<h2>Considérations diverses</h2>

	<details>
		<summary class="h3">Voyager à cheval</summary>

		<h4>Distance en 1 heure</h4>

		<p><b>Marche&nbsp;</b>: environ 7 km. C'est une allure tranquille qui permet au cheval de conserver son énergie.</p>
		<p><b>Trot&nbsp;:</b> environ 14 km en une heure. Cette allure est idéale pour les longues distances car elle est rapide tout en étant moins fatigante que le galop.</p>
		<p><b>Galop&nbsp;:</b> sur une courte distance, un cheval peut galoper environ 20 kilomètres en une heure, selon sa condition physique. Le galop est très exigeant et ne peut être maintenu longtemps sans pauses.</p>

		<h4>Distance par jour</h4>
		<p>
			En moyenne, un cheval peut parcourir 30 km en une journée, principalement au trot ou au pas. Les chevaux bien hydratés, entraînés, en bonne santé et reposés sont capable de marcher pendant environ 8 heures, couvrant une distance d'environ 50 km.<br>
			Cependant, peu de cavaliers peuvent rester en selle pendant aussi longtemps.
		</p>
		<div class="bg-grey-900 p-½ flow">
			<h5>Rythme normal</h5>
			<p>Avec un cheval moyen en bonne santé et norma&shy;lement chargé (un cavalier portant une armure légère + équipement de voyage), pour estimer la distance parcourue en une journée faire un jet d’<i>Équitation</i>&nbsp;:</p>
			<p class="ta-center">distance parcourue = 30&nbsp;km + (MR+1)×5&nbsp;km</p>
			<p>En cas d’échec, la distance parcourue est de 30 km.</p>
		</div>
		<p>Ce rythme est maintenable quasi-indéfiniment dans le temps. Il est adapté pour de longs voyages</p>

		<h4>Course d'endurance</h4>
		<p>Un excellent cavalier associé à un excellent cheval très bien entraîné peut parcourir 160 kilomètres en 14 à 15 heures.</p>
		<div class="bg-grey-900 p-½ flow">
			<h5>Rythme soutenu</h5>
			<p>À creuser</p>
			<ul>
				<li>fatigue du cheval</li>
				<li>degré d’intensité imposé par le cavalier</li>
			</ul>
		</div>
		
		<p class="mt-1 ta-right">Source&nbsp;: <a href="https://www.hudada.fr/blog/combien-de-temps-peut-courir-un-cheval/36/">hudada.com</a></p>
	</details>
</article>

<script type="module" src="/scripts/creatures.js"></script>