<?php

use App\Entity\Character;


$test = new Character(31);
$test->processCharacter(false);

$keys = ["id", "label", "type", "base", "min-niv", "niv", "modif", "background", "groups", "free-points", "nominal-points", "spe-points", "points", "score"];
//var_dump($test->skills[2]);
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
<?php foreach ($test->skill_groups as $group => $data): ?>
	<p><?= $group ?> : <?= $data["label"] ?> – niv : <?= $data["niv"] ?>, difficulté : <?= $data["difficulty"] ?></p>
<?php endforeach ?>

<p class="mt-1"><b>Traits spéciaux :</b> <?php print_r($test->special_traits) ?></p>

<table class="left-2 mt-1">
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