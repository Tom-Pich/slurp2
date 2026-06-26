<?php

use App\Lib\ListWriter;

$goods = include("src/Generator/lists/medieval-goods.php");

?>

<!-- Aliments -->
<details>
	<summary>
		<h3>Aliments</h3>
	</summary>
	<ul class="flow">
		<?= ListWriter::displayList($goods["commerce-aliments"]) ?>
	</ul>
</details>

<!-- Objets domestiques -->
<details>
	<summary>
		<h3>Objets domestiques</h3>
	</summary>
	<ul class="flow">
		<?= ListWriter::displayList($goods["commerce-objets-domestiques"]) ?>
	</ul>
</details>

<!-- Vêtements, textiles et confection -->
<details>
	<summary>
		<h3>Vêtements, textiles et confection</h3>
	</summary>
	<ul class="flow">
		<?= ListWriter::displayList($goods["commerce-vetements-textiles"]) ?>
	</ul>
</details>

<!-- Outils, cordage et harnachement -->
<details>
	<summary>
		<h3>Outils, cordage et harnachement</h3>
	</summary>
	<ul class="flow">
		<?= ListWriter::displayList($goods["outils-cordage-harnachement"]) ?>
	</ul>
</details>

<!-- Autres objets manufacturés -->
<details>
	<summary>
		<h3>Autres objets manufacturés</h3>
	</summary>
	<ul class="flow">
		<?= ListWriter::displayList($goods["commerce-biens-courants"]) ?>
	</ul>
</details>

<!-- Marchandises de longue distance -->
<details>
	<summary>
		<h3>Marchandises de longue distance</h3>
	</summary>
	<ul class="flow">
		<?= ListWriter::displayList($goods["commerce-longue-distance"]) ?>
	</ul>
</details>

<!-- Commerce de livraison intra-urbaine -->
<details>
	<summary>
		<h3>Marchandises de livraison intra-urbaine</h3>
	</summary>
	<ul class="flow">
		<?= ListWriter::displayList($goods["commerce-livraison-intra-urbaine"]) ?>
	</ul>
</details>