<?php

use App\Entity\Character;

$test = new Character(26);
$test->processCharacter(false);

$keys = ["id", "label", "type", "base", "min-niv", "niv", "modif", "background", "groups", "free-points", "nominal-points", "spe-points", "points", "score"];
?>

<h4><?= $test->name ?></h4>

<p class="mt-1">
	<b>Caractéristiques :</b>
	For <?= $test->attributes["For"] ?> ;
	Dex <?= $test->attributes["Dex"] ?> ;
	Int <?= $test->attributes["Int"] ?> ;
	San <?= $test->attributes["San"] ?> ;
	Per <?= $test->attributes["Per"] ?> ;
	Vol <?= $test->attributes["Vol"] ?>
</p>

<p class="mt-1"><b>Compétences proches</b></p>
<table class="left-1 left-2" style="width: unset;">
	<tr>
		<th>Groupe</th>
		<th>Compétence principale</th>
		<th>Niv.</th>
		<th>Diff.</th>
	</tr>
<?php foreach ($test->skill_groups as $group => $data): ?>
	<tr>
		<td><?= $group ?></td>
		<td><?= $data["label"] ?></td>
		<td><?= $data["niv"] ?></td>
		<td><?= $data["difficulty"] ?></td>
	</tr>
<?php endforeach ?>
</table>

<p class="mt-1"><b>Traits spéciaux :</b> <?= json_encode($test->special_traits, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?></p>

<table class="left-2 mt-1"  style="width: unset;">
	<tr><?php foreach ($keys as $key) echo "<th>$key</th>" ?></tr>
	<?php foreach ($test->skills as $s): ?>
		<?php $s["groups"] = join(", ", $s["groups"] ?? []) ?>
		<tr>
			<?php foreach ($keys as $k): ?>
				<td><?= $s[$k] ?></td>
			<?php endforeach ?>
		</tr>
	<?php endforeach; ?>
</table>