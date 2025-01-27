<?php

use App\Entity\Character;

$test = new Character(31);
$test->processCharacter();
$keys = ["id", "label",	"type", "raw-base", "points", "background", "niv", /* "difficulty", "description", "entity-base", "base", "spe_bonus", */ "modif", "score",  "groups", "total_points", "group_modif"];

if (false) {
	echo "<pre>";
	foreach ($test->skills as $skill) {
		$skill["description"] = "&hellip;";
		if ($skill["label"] === "Couteau") print_r($skill);
	}
	die();
}

?>
<h4>Character: <?= $test->name ?></h4>
<table class="left-2 mt-1">
	<tr>
		<?php foreach ($keys as $key) echo "<th>$key</th>" ?>
	</tr>
	<?php foreach ($test->skills as $s):
		$groups = [];
		foreach ($s["groups"] ?? [] as $group => $pts) $groups[] = "$group: $pts";
	?>
		<tr>
			<td><?= $s["id"] ?></td>
			<td><?= $s["label"] ?></td>
			<td><?= $s["type"] ?></td>
			<td><?= $s["raw-base"] ?></td>
			<td><?= $s["points"] === 0 ? "–" : $s["points"] ?></td>
			<td><?= !empty($s["background"]) ? "true" : "–" ?></td>
			<td><?= $s["niv"] ?></td>
			<!-- <td><?= $s["difficulty"] ?></td> -->
			<!-- <td>&hellip;</td> -->
			<!-- <td><?= $s["entity-base"] ?></td> -->
			<!-- <td><?= $s["base"] ?></td> -->
			<td><?= $s["modif"] === 0 ? "–" : $s["modif"] ?></td>
			<td><?= $s["score"] ?></td>
			<!-- <td><?= $s["spe_bonus"] ?></td> -->
			<td><?= count($groups) ? join(" – ", $groups) : "–" ?></td>
			<td><?= $s["total_points"] ?? "–" ?></td>
			<td><?= $s["group_modif"] ?? "–" ?></td>
		</tr>
	<?php endforeach; ?>
</table>