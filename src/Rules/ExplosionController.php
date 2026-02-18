<?php

namespace App\Rules;

class ExplosionController
{
	static function getExplosionDamages(float $damages, string $distance, float $fragSurface, bool $isFragmentationDevice)
	{

		// damage multiplier according to distance
		$dmgMultiplier = 1;
		$distanceValue = !is_numeric($distance) ? 1 : (float) $distance;

		if (strtolower($distance) === "i") {
			$dmgMultiplier = 6; // internal explosion
		} else if (strtolower($distance) === "r") {
			$dmgMultiplier = 4; // covered explosion
		} else if (strtolower($distance) === "c" || $distanceValue < 0.5) {
			$dmgMultiplier = 2; // contact explosion
		} else if ($distanceValue <= 1) {
			$dmgMultiplier = 2 - $distanceValue; // explosion at 0.5 – 1 m
		}

		// damages in contact or distance <= 1;
		$effectiveBlastDmg = $damages * $dmgMultiplier;

		// damage decrease for distance > 1 : half dice per meter
		if ($distanceValue > 1) {
			$effectiveBlastDmg -= (2.5 * ($distanceValue - 1));
		}

		// evaluate fragment hits
		$totalFragmentNumber = 3 * $damages * ($isFragmentationDevice ? 2 : 1); // 30 or 15 total fragments per dice

		$fragmentFrac = 0; // default fraction of fragments that hit the target
		if (strtolower($distance) === "i") {
			$fragmentFrac = 1;
		} else if (strtolower($distance) === "r") {
			$fragmentFrac = 0.6;
		} else if (strtolower($distance) === "c") {
			$fragmentFrac = 0.45;
		} else if (is_numeric($fragSurface)) {
			$fragmentFrac = ((float)$fragSurface) / (2 * 3.14 * $distanceValue ** 2);
			$fragmentFrac = min($fragmentFrac, 0.45);
		}

		// Mathematical expectation of number of fragments that hit
		$fragmentHits = $totalFragmentNumber * $fragmentFrac;

		// provides a random value of fragment hits based on mathematical expectation
		$randomizedFragmentHits = 0;

		while ($fragmentHits >= 1) {
			// each sure fragment is transform into 0-2 fragment(s)
			$randomizedFragmentHits += mt_rand(0, 2);
			$fragmentHits--;
		}

		// each partial fragment is randomly checked.
		// If success, check again for another one with probablity ÷ 2
		$checkAgainForFragment = true;
		while ($checkAgainForFragment) {
			$addedFragment = mt_rand(1, 1000) <= $fragmentHits * 1000 ? 1 : 0;
			$randomizedFragmentHits += $addedFragment;
			$checkAgainForFragment = !!$addedFragment;
			$fragmentHits /= 2;
		}

		// fall distance due to blast projection
		$height = round($effectiveBlastDmg*0.25);

		return ["damages" => (int) round($effectiveBlastDmg), "fragments" => $randomizedFragmentHits, "height" => $height];
	}
}
