<?php

use App\Repository\CharacterRepository;

ini_set('xdebug.var_display_max_depth', 10);
ini_set("xdebug.var_display_max_data", -1);

$repo = new CharacterRepository;
$characters = $repo->getAllCharacters();
?>

<h4>Personnages avec niveaux élevés</h4>
<table class="left-1 left-2">
<?php
foreach ($characters as $id){
	$char = $repo->getCharacterRawData($id);
	echo "<tr>";
	echo "<td>{$char['Nom']}</td>";
	$skills = json_decode($char["Compétences"]);
	echo "<td>";
	foreach ($skills as $s){
		if ( isset($s->niv) && $s->niv > 5 && $s->id !== 200) {
			print_r($s);
			echo " – ";
		}
	}
	echo "</td>";
	echo "<td>";
	$spells = json_decode($char["Sorts"]);
	foreach ($spells as $s){
		if ($s->catégorie === "collège" && $s->niv >= 3){
			print_r($s);
			echo " – ";
		}
	}
	echo "</td>";
	echo "</tr>";
}
?>
</table>