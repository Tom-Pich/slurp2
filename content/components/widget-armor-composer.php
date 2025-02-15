<?php

use App\Rules\ArmorsController;

$price_index = $price_index ?? 0; // default price is AD&D
$with_magic_modifiers = $with_magic_modifiers ?? false; // default is without magic modifier
$excluded_sizes = $excluded_sizes ?? [];
$armor_sizes = [];
foreach (ArmorsController::armor_sizes as $index => $size) {
	if (!in_array($index, $excluded_sizes)) $armor_sizes[$index] = $size;
}
$armors = array_filter(ArmorsController::armors, fn($armor) => isset($armor["prix"][$price_index]))
?>

<fieldset class="widget fs-300" id="widget-armor-composer">

	<legend>Constructeur d’armure composite</legend>

	<p>Sélectionner des paramètres globaux si vous le souhaitez. Vous pourrez ensuite affiner éléments par élément.</p>

	<div class="grid col-2-s ai-center">
		<div>Taille de l’armure</div>
		<select name="armor-size">
			<?php foreach ($armor_sizes as $index => $size) { ?>
				<option data-weight="<?= $size["mult_pds"] ?>" <?= $index === "m" ? "selected" : "" ?> data-price="<?= $size["mult_prix"] ?>" value="<?= $index ?>">
					<?= ucfirst($size["nom"]) ?>
				</option>
			<?php } ?>
		</select>
	</div>

	<div class="grid col-2-s ai-center mt-½">
		<div>Type global</div>
		<select name="armor-type">
			<option value="0" data-weight="0" data-price="0">–</option>
			<?php foreach ($armors as $index => $armor) { ?>
				<option value="<?= $index ?>"><?= ucfirst($armor["nom"]) ?></option>
			<?php } ?>
		</select>
	</div>

	<div class="grid col-2-s ai-center mt-½">
		<div>Qualité globale</div>
		<select name="armor-quality">
			<?php foreach (ArmorsController::armor_qualities as $index => $data) { ?>
				<option value="<?= $index ?>"><?= ucfirst($data["nom"]) ?></option>
			<?php } ?>
		</select>
	</div>

	<div class="grid col-2-s ai-center mt-½ <?= $with_magic_modifiers ? "" : "hidden" ?>">
		<div>Enchantement global</div>
		<select name="armor-enchantment">
			<option value="0">Non magique</option>
			<option value="1">+1 à +2</option>
			<option value="2">+3 à +5</option>
		</select>
	</div>

	<table class="alternate-e mt-2 left-1">
		<tr>
			<th></th>
			<th style="width: 9ch">Poids</th>
			<th style="width: 9ch">Prix</th>
		</tr>

		<!-- Parties d’armure -->
		<?php foreach (ArmorsController::armor_parts as $index => $part) { ?>
			<tr data-type="armor-row" data-weight="<?= $part["mult_pds"] ?>" data-price="<?= $part["mult_prix"] ?>" <?= in_array($index, ["visage", "bottes"]) ? "never-global" : "" ?>>
				<td class="grid gap-¼ py-½">

					<div class="flex-s gap-½">
						<b class="fl-1"><?= $part["nom"] ?></b>
						<label class="<?= $part["notes"] === "(2)" ? "" : "hidden" ?>">(½) <input type="checkbox"></label>
					</div>

					<select data-type="armor-type">
						<option value="0" data-weight="0" data-price="0">–</option>
						<?php foreach ($armors as $index => $armor) { ?>
							<option value="<?= $index ?>" data-weight="<?= $armor["pds"] ?>" data-price="<?= $armor["prix"][$price_index] ?>"><?= ucfirst($armor["nom"]) ?></option>
						<?php } ?>
					</select>

					<select data-type="armor-quality">
						<?php foreach (ArmorsController::armor_qualities as $index => $data) { ?>
							<option value="<?= $index ?>" data-weight="<?= $data["mult_pds"] ?>" data-price="<?= $data["mult_prix"] ?>"><?= ucfirst($data["nom"]) ?></option>
						<?php } ?>
					</select>

					<select <?= $with_magic_modifiers ? "" : "class='hidden'" ?> data-type="armor-enchantment">
						<option value="0" data-weight="1">Non magique</option>
						<option value="1" data-weight="0.67">+1 à +2</option>
						<option value="2" data-weight="0.5">+3 à +5</option>
					</select>

				</td>
				<td><!-- poids --></td>
				<td><!-- prix --></td>
			</tr>
		<?php } ?>
		<tr id="armor-total">
			<th>Total</th>
			<th></th>
			<th></th>
		</tr>
	</table>

</fieldset>

<script type="module" src="/scripts/widget-armor<?= PRODUCTION ? ".min" : "" ?>.js?v=<?= VERSION ?>" defer></script>