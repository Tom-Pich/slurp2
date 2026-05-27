<?php

use App\Entity\Spell;
?>

<table>
	<tr>
		<th>Niv</th>
		<th>Modif</th>
		<th>PdM</th>
		<th>Rapide</th>
		<th>Long</th>
	</tr>
	<?php
	foreach (["I", "II", "III", "IV", "V"] as $i => $niv):
		$cast_time_long = Spell::cast_time[$i][1];
		if ($cast_time_long >= 3600) {
			$cast_time_long = (string) ((int) ($cast_time_long / 3600)) . " h";
		} elseif ($cast_time_long >= 60) {
			$cast_time_long = (string) ((int) ($cast_time_long / 60)) . " min";
		} else {
			$cast_time_long = (string) $cast_time_long . " s";
		}
	?>
		<tr>
			<td><?= $niv ?></td>
			<td><?= Spell::niv_modifier[$i] ?></td>
			<td><?= Spell::pdm_cost[$i] ?></td>
			<td><?= Spell::cast_time[$i][0] ?> s</td>
			<td><?= $cast_time_long ?></td>
		</tr>
	<?php endforeach ?>
</table>