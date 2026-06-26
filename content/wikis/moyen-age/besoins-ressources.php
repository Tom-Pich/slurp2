<?php

use App\Lib\ListWriter;

$resources = include("src/Generator/lists/medieval-resources.php");
?>

<!-- Besoins -->
<section>
	<h2>Besoins</h2>
	<p>Liste des besoins humains « universels » (à réorganiser).</p>
	<ul>
		<li>Boire et se nourrir</li>
		<li>Se protéger du froid et des intempéries</li>
		<li>Se défendre</li>
		<li>Se laver et se soigner</li>
		<li>S’éclairer</li>
		<li>Se déplacer</li>
		<li>Stocker et transporter</li>
		<li>Communiquer</li>
		<li>Apprendre, découvrir</li>
		<li>Pratiquer sa foi et sa spiritualité</li>
		<li>Se divertir</li>
	</ul>
</section>

<!-- Ressources -->
<section>
	<h2>Ressources</h2>

	<p>Les ressources matérielles peuvent avoir trois origines : végétale, animale et minérale. L’<b>eau</b> est une ressource vitale, sans laquelle il n’y a pas d’installation humaine.</p>

	<!-- Agriculture et élevage -->
	<details>
		<summary>
			<h3>Agriculture et élevage</h3>
		</summary>

		<ul class="flow">
			<?= ListWriter::displayList($resources["agriculture-élevage"]) ?>
		</ul>
	</details>

	<!-- Chasse, pêche et cueillette -->
	<details>
		<summary>
			<h3>Chasse, pêche et cueillette</h3>
		</summary>

		<ul class="flow">
			<?= ListWriter::displayList($resources["chasse-peche-cueillette"]) ?>
		</ul>
	</details>

	<!-- Pierre, minéraux et métaux -->
	<details>
		<summary>
			<h3>Pierre, minéraux et métaux</h3>
		</summary>
		<ul class="flow">
			<?= ListWriter::displayList($resources["minéraux-métaux"]) ?>
		</ul>
	</details>

</section>