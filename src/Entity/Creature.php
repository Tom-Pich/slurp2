<?php

namespace App\Entity;

use App\Interface\RulesItem;
use App\Lib\DiceManager;
use App\Repository\CreatureRepository;

// id, Nom, Origine, Catégorie, Pds1, Pds2, Options, Taille, Int, RD, Vitesse, Description, Avdesav, Pouvoirs, Combat

class Creature implements RulesItem
{
	public int $id;
	public string $name;
	public string $origin;
	public string $category;
	public ?float $weight_min;
	public ?float $weight_max;
	public array $options;
	public string $size;
	public string $int;
	public string $rd;
	public string $speed;
	public string $description;
	public string $avdesav;
	public string $powers;
	public string $combat;

	// processed values
	public string $readableWeight;
	public float $w_mult_strength;
	public float $w_mult_pdv;
	public float $category_mult_pdv;
	public array $strength;
	public string $readableStrength;
	public array $pdv;
	public string $readablePdV;

	public function __construct(array $data = [])
	{
		$this->id = (int) ($data["id"] ?? 0);
		$this->name = $data["Nom"] ?? "";
		$this->origin = $data["Origine"] ?? "";
		$this->category = $data["Catégorie"] ?? "";
		$this->weight_min = !empty($data["Pds1"]) ? (float) $data["Pds1"] : NULL;
		$this->weight_max =  !empty($data["Pds2"]) ? (float) $data["Pds2"] : NULL;
		$this->options =  json_decode(($data["Options"] ?? "[]"), true);
		$this->size =  $data["Taille"] ?? "";
		$this->int =  $data["Int"] ?? "";
		$this->rd =  $data["RD"] ?? "";
		$this->speed =  $data["Vitesse"] ?? "";
		$this->description =  $data["Description"] ?? "";
		$this->avdesav =  $data["Avdesav"] ?? "";
		$this->powers =  $data["Pouvoirs"] ?? "";
		$this->combat =  $data["Combat"] ?? "";

		$weight_min = $this->weight_min >= 1000 ? (round($this->weight_min/1000, 1) . "&nbsp;t") : ($this->weight_min . "&nbsp;kg");
		$this->readableWeight = $weight_min;
		$weight_max = $this->weight_max >= 1000 ? (round($this->weight_max/1000, 1) . "&nbsp;t") : ($this->weight_max . "&nbsp;kg");
		$this->readableWeight .= $this->weight_max !== $this->weight_min ?  ("-" . $weight_max) : "";

		$this->w_mult_strength = isset($this->options["Mult_pds_for"]) ? (float) $this->options["Mult_pds_for"] : 1;
		$this->w_mult_pdv = isset($this->options["Mult_pds_pdv"]) ? (float) $this->options["Mult_pds_pdv"] : 1;
		$this->category_mult_pdv = $this->category === "Mort-vivant" ?  1.3 : 1;

		$this->strength = $this->id ? [self::getStrengthFromWeight($this->weight_min * $this->w_mult_strength), self::getStrengthFromWeight($this->weight_max * $this->w_mult_strength)] : [];
		$this->readableStrength = $this->id ? ($this->strength[0] !== $this->strength[1] ? join("-", $this->strength) : $this->strength[0]) : "";
		$this->readableStrength = isset($this->options["Sans_for"]) ? "–" : $this->readableStrength;
		
		$this->pdv = $this->id ? [
			floor(self::getPdVFromWeight($this->weight_min * $this->w_mult_pdv * 0.9)*$this->category_mult_pdv),
			floor(self::getPdVFromWeight($this->weight_max * $this->w_mult_pdv * 1.1)*$this->category_mult_pdv)
			] : [];
		$this->readablePdV = join("-", $this->pdv);
	}

	public function displayInRules(bool $show_edit_link = false, ?string $edit_link = null, array $data = [])
	{
		$edit_link = $edit_link ?? "gestion-listes?req=creature&id=" . $this->id ?>
		<details class="liste">
			<summary>
				<div>
					<div>
						<?php if ($show_edit_link) { ?><a href="<?= $edit_link ?>" class="ff-fas edit-link">&#xf044;</a><?php } ?>
						<?= $this->name ?>
					</div>
				</div>
			</summary>

			<div class="mt-½"><?= $this->description ?></div>

			<div class="mt-½">
				<b>For&nbsp;:</b> <?= $this->readableStrength ?>&emsp;<b>Int&nbsp;:</b> <?= $this->int ?><br>
				<b>PdV&nbsp;:</b> <?= $this->readablePdV ?>&emsp;<b>RD&nbsp;:</b> <?= $this->rd ?>&emsp;<b>Vit&nbsp;:</b> <?= $this->speed ?><br>
				<?php if (!isset($this->options["Sans_pds"])) { ?>
					<b>Poids&nbsp;:</b> <?= $this->readableWeight ?>&emsp;
				<?php } ?>
				<?php if ($this->size) { ?>
					<b>Taille&nbsp;:</b> <?= $this->size ?>
				<?php } ?>
			</div>

			<?php if ($this->avdesav) { ?>
				<p><b>Avantages &amp; Désavantages&nbsp;:</b> <?= $this->avdesav ?></p>
			<?php } ?>
			<?php if ($this->powers) { ?>
				<p><b>Pouvoirs&nbsp;:</b> <?= $this->powers ?></p>
			<?php } ?>

			<p><b>Combat&nbsp;:</b> <?= $this->combat ?></p>

		</details>
<?php }

	/**
	 * getTramplingDamages
	 *
	 * @param  float $weight (kg)
	 * @return string dice expression of trampling damages
	 */
	public static function getTramplingDamages(float $weight): string
	{
		$ip = 5 * log($weight + 300) - 28;
		$damages = DiceManager::ip2dice($ip);
		return $damages;
	}

	public static function getStrengthFromWeight(float $weight): int
	{
		if ($weight < 0.5) {
			$strength = 0;
		} elseif ($weight <= 30) {
			$strength = 1.2 * pow($weight, 0.5);
		} else {
			$strength = 0.5 * pow($weight, 0.75);
		}
		if ($strength >= 150) {
			$strength = round($strength / 10) * 10;
		} elseif ($strength >= 30) {
			$strength = round($strength / 5) * 5;
		} else {
			$strength = round($strength);
		}
		return $strength;
	}

	public static function getPdVFromWeight(float $weight): int
	{
		$pdv = 1.2 * pow($weight, 0.5);
		if ($pdv > 80) {
			$pdv = round($pdv / 10) * 10;
		} elseif ($pdv > 20) {
			$pdv = round($pdv / 5) * 5;
		} else {
			$pdv = round($pdv);
		}
		return $pdv;
	}

	public static function processSubmitCreature(array $post): void
	{
		// id, Nom, Origine, Catégorie, Pds1, Pds2, Options, Taille, Int, RD, Vitesse, Description, Avdesav, Pouvoirs, Combat
		//var_dump($post);
		$creature = [];

		$creature["id"] = (int) $post["id"];
		$creature["Nom"] = strip_tags($post["Nom"]);
		$creature["Origine"] = strip_tags($post["Origine"]);
		$creature["Catégorie"] = strip_tags($post["Catégorie"]);
		$creature["Pds1"] = (float) $post["Pds1"];
		$creature["Pds2"] = (float) $post["Pds2"];

		$post["Options"]["Mult_pds_for"] ? $creature["Options"]["Mult_pds_for"] = (float) $post["Options"]["Mult_pds_for"] : "";
		$post["Options"]["Mult_pds_pdv"] ? $creature["Options"]["Mult_pds_pdv"] = (float) $post["Options"]["Mult_pds_pdv"] : "";
		isset($post["Options"]["Sans_pds"]) ? $creature["Options"]["Sans_pds"] = 1 : "";
		isset($post["Options"]["Sans_for"]) ? $creature["Options"]["Sans_for"] = 1 : "";
		$creature["Options"] = isset($creature["Options"]) ? json_encode($creature["Options"], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : NULL;

		$creature["Taille"] = $post["Taille"] ? strip_tags($post["Taille"]) : NULL;
		$creature["Int"] = strip_tags($post["Int"]);
		$creature["RD"] = strip_tags($post["RD"]);
		$creature["Vitesse"] = strip_tags($post["Vitesse"]);
		$creature["Description"] = $post["Description"] ? $post["Description"] : NULL;
		$creature["Avdesav"] = $post["Avdesav"] ? $post["Avdesav"] : NULL;
		$creature["Pouvoirs"] = $post["Pouvoirs"] ? $post["Pouvoirs"] : NULL;
		$creature["Combat"] = $post["Combat"];
		
		//var_dump($creature);

		$repo = new CreatureRepository;

		if ($creature["Nom"] && $creature["id"]) {
			$repo->updateCreature($creature);
		} elseif (!$creature["Nom"] && $creature["id"]) {
			$repo->deleteCreature($creature["id"]);
		} elseif ($creature["Nom"] && !$creature["id"]) {
			$repo->createCreature($creature);
		}
		 
	}

	
}
