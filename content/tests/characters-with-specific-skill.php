<?php

use App\Repository\CharacterRepository;

ini_set('xdebug.var_display_max_depth', 10);
ini_set("xdebug.var_display_max_data", -1);

$repo = new CharacterRepository;
$characters = $repo->getAllCharacters();
$skill_id = 26; // Esquive
?>

<h4>Personnages avec une compétence spécifique</h4>
<table class="left-1 left-2" style="width: fit-content;">
	<?php
	foreach ($characters as $id) {
		$char = $repo->getCharacterRawData($id);
		$skills = json_decode($char["Compétences"]);
		$skills = array_values(array_filter($skills, function ($s) {
			return $s->id === 26;
		}));
		//var_dump($skills);
		if (count($skills) === 1 && isset($skills[0])) {
			$s = $skills[0];
			echo "<tr>";
			echo "<td>{$char['id']}</td>";
			echo "<td>{$char['Nom']}</td>";

			echo "<td>";
			echo ($s->label ?? "Esquive") . " – niv. " . ($s->niv ?? "default");
			echo "</td>";
		}
	}
	?>
</table>