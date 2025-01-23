<?php

namespace App\Entity;

use App\Lib\Define;
use App\Lib\TextParser;
use App\Interface\RulesItem;

abstract class AbstractSpell implements RulesItem
{
	public int $id;
	public string $name;
	public int $niv_min;
	public int $niv_max;
	public string $readableNiv;
	public ?string $class;
	public ?string $duration;
	public ?string $time;
	public ?string $zone;
	public ?string $resistance;
	public string $description;
	public string $origin;
	const cast_time = [[1, 15], [2, 30], [3, 60], [4, 600], [6, 3600]];

	// id Nom Niv Collège Classe Durée Temps Zone Résistance Description Origine

	public function __construct(array $item = [])
	{
		$this->id = $item["id"] ?? 0;
		$this->name = $item["Nom"] ?? "";
		$niv_array = json_decode($item["Niv"] ?? "[]");
		$this->niv_min = $niv_array[0] ?? 0;
		$this->niv_max = $niv_array[1] ?? $this->niv_min;
		$this->readableNiv = $this->niv_min ? TextParser::parseNumbers2Latin($this->niv_min, $this->niv_max) : "";
		$this->class = $item["Classe"] ?? NULL;
		$this->duration = $item["Durée"] ?? NULL;
		$this->time = $item["Temps"] ?? NULL;
		$this->zone = $item["Zone"] ?? NULL;
		$this->resistance = $item["Résistance"] ?? NULL;
		$this->description = $item["Description"] ?? "";
		$this->origin = $item["Origine"] ?? "";
	}

	// generate full HTML for displaying in rules
	// $data contains optionnal display parameters
	// name: override item nam
	// cost-mult: multiplier for default character point cost
	// colleges-list: array with college names
	// disciplines-list: array with discipline names
	public function displayInRules(bool $show_edit_link, string $edit_req, array $data = [], bool $lazy = false): void
	{
		$edit_link = sprintf("gestion-listes?req=%s&id=%d", $edit_req, isset($data["power-id"]) ? $data["power-id"] : $this->id); ?>

		<details class="liste" data-niv-min="<?= $this->niv_min ?>" data-niv-max="<?= $this->niv_max ?>" data-origin="<?= $this->origin ?>">
			<summary title="id <?= $this->id ?>">
				<div>
					<div>
						<?php if ($show_edit_link) { ?>
							<a href="<?= $edit_link ?>" class="edit-link ff-far">&#xf044;</a>
						<?php } ?>
						<?= !empty($data["name"]) ? $data["name"] : $this->name ?> (<?= $this->readableNiv ?>)
					</div>
					<div>
						<?= !empty($data["cost-mult"]) ? $this->displayCost($data["cost-mult"]) : "" ?>
					</div>
				</div>
			</summary>

			<div class="mt-½ fs-300">
				<?php if (!empty($data["colleges-list"])): ?>
					<i>Collège<?= count($data["colleges-list"]) > 1 ? "s" : "" ?>&nbsp;: </i><?= join(", ", $data["colleges-list"]) ?>
				<?php elseif (!empty($data["disciplines-list"])): ?>
					<i>Discipline<?= count($data["disciplines-list"]) > 1 ? "s" : "" ?>&nbsp;: </i><?= join(", ", $data["disciplines-list"]) ?>
				<?php endif ?>
			</div>

			<div class="mt-½ fs-300" <?= $lazy ? "data-details data-type='spell' data-id=" . $this->id : "" ?>>
				<?php if (!$lazy) $this->displayFullDescription() ?>
			</div>

		</details>
	<?php }

	// generate HTML for full description of spell
	public function displayFullDescription($custom_time = "")
	{ ?>
		<div class="flow">
			<?= $this->class ? "<p class='fw-700'>" . $this->class . "</p>" : "" ?>
			<?= Define::implementDefinitions($this->description, Define::magic_dictionnary) ?>
		</div>
		<div class="mt-½">
			<?php if ($this->duration) { ?> <i>Durée</i>&nbsp;: <?= $this->duration ?><br>
			<?php }
			if (empty($custom_time) && $this->time) { ?>
				<i>Temps nécessaire</i>&nbsp;: <?= $this->time ?><br>
			<?php } elseif (!empty($custom_time)) { ?>
				<i>Temps&nbsp;:</i> <?= $custom_time ?><br>
			<?php }
			if ($this->class === "Zone") { ?> <i>Zone de base</i>&nbsp;: <?= $this->zone ? $this->zone : "3&nbsp;m" ?><br>
			<?php }
			if ($this->resistance) { ?><i>Résistance</i>&nbsp;: <?= $this->resistance ?>
			<?php } ?>
		</div>
<?php }

	public function displayCost() {} // in child class
}
