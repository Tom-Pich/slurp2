<?php

namespace App\Rules;

class EquipmentListController
{
	const equipment_list = [
		// label, poids, [ AD&D, Ombres d’Esteren ], catégorie
		["Couchage dans un dortoir", NULL, ["2 pc", "2 dB"], "auberge"],
		["Chambre, auberge moyenne", NULL, ["4-10 pc", "5 dB"], "auberge"],
		["Écurie et avoine, 1 cheval", NULL, ["2 pc"], "auberge"],
		["Repas (taverne)",	NULL, ["2-4 pc", "3-7 dB"], "auberge"],
		["Chope de bière", NULL, ["½ pc"], "auberge"],

		["Ration de voyageur (un repas)", 0.25,	["2 pc", "3 dB"], "nourriture"],
		["Formage (1 kg)", NULL, ["2-5 pc"], "nourriture"],
		["Lard (1 kg)", NULL, ["3 pc"], "nourriture"],
		["Viande de porc (1 kg)", NULL, ["3 pc"], "nourriture"],
		["Œufs, la douzaine", NULL, ["1 pc"], "nourriture"],
		["Pain (1 kg)", NULL, ["1 pc"], "nourriture"],
		["Bière (1 L)", NULL, ["1 pc"], "nourriture"],
		["Vin (1 L)", NULL, ["1-3 pc"], "nourriture"],
		["Liqueur (1 L)", NULL, ["3-6 pc"], "nourriture"],
	];

	public static function displayEquipmentList(array $list, int $price_index)
	{
?>
		<table class="left-1 right-2 fs-300 alternate-o mt-1">
			<?php foreach ($list as $item) {
				if (isset($item[2][$price_index])) {
			?>
					<tr>
						<td><?= $item[0] ?></td>
						<td><?= $item[2][$price_index] ?><?= $item[1] ? "&nbsp;; " . $item[1] . "&nbsp;kg" : "" ?></td>
					</tr>
			<?php }
			} ?>
		</table>
<?php
	}
}
?>