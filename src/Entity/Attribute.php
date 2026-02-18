<?php

namespace App\Entity;

use App\Lib\DiceManager;

class Attribute
{
	private string $name;
	const cost_for = "10 pts/niv";
	const cost_dex = "10 à 25 pts/niv";
	const cost_int = "10 à 25 pts/niv";
	const cost_san = "10 pts/niv";
	const cost_per = "5 pts/niv";
	const cost_vol = "5 pts/niv";
	const reflexes = "Moy. (Dex, Per) – 3";
	const sang_froid = "Moy. (San, Vol)";
	const vitesse = "Moy. (For, Dex, San)÷2";
	const pdv = "Moy. (For, San)";
	const pdf = "Moy. (For, San)";
	const pdm = "Int";
	const pde = "Moy. (San, Vol)";

	public function __construct(string $name = "undefined")
	{
		$this->name = $name;
	}

	/**
	 * costHigh
	 * return cost for Dex and Int
	 * 
	 * @param  int $value attribute score
	 * @return int cost in character points
	 */
	public function costHigh(int $value)
	{
		if ($value < 10) {
			return max(-150, ($value - 10) * 15);
		} elseif ($value <= 13) {
			return ($value - 10) * 10;
		} elseif ($value <= 15) {
			return ($value - 13) * 15 + 30;
		} elseif ($value <= 17) {
			return ($value - 15) * 20 + 60;
		} else {
			return ($value - 17) * 25 + 100;
		}
	}

	/**
	 * costMedium
	 * return cost for For and San
	 * 
	 * @param  int $value attribute score
	 * @return int cost in character points
	 */
	public function costMedium(int $value)
	{
		return max(-100, ($value - 10) * 10);
	}

	/**
	 * costLow
	 * return cost for Per and Vol
	 * 
	 * @param  int $value attribute score
	 * @return int cost in character points
	 */
	public function costLow(int $value)
	{
		return max(-50, ($value - 10) * 5);
	}

	/**
	 * cost
	 * return cost according to attribute name
	 * 
	 * @param  int $value attribute score
	 * @return int cost in character points
	 */
	public function cost(int $value)
	{
		switch ($this->name) {
			case "For":
				return $this->costMedium($value);
			case "Dex":
				return $this->costHigh($value);
			case "Int":
				return $this->costHigh($value);
			case "San":
				return $this->costMedium($value);
			case "Vol":
				return $this->costLow($value);
			case "Per":
				return $this->costLow($value);
			default:
				return 0;
		}
	}

	/**
	 * getDamages
	 * return an array of different damages
	 *
	 * @param  int $strength score
	 * @return array dammages dices [estoc=> ..., taille => ..., morsure => ..., cornes => ...]
	 */
	static function getDamages(int $strength): array
	{
		if ($strength <= 19) {
			$ip_t = 0.9 * $strength - 5.41;
		} else if ($strength > 19) {
			$ip_t = 9 * log($strength - 9) - 9;
		}

		$ip_e = 0.5 * $ip_t;
		$ip_m = 0.4 * $ip_t;
		$ip_c = 0.3 * $ip_t;

		if ($strength <= 0) {
			$taille = $estoc = $morsure = $cornes = '0';
		} elseif ($strength <= 2) {
			$taille = $estoc = $morsure = $cornes = '1d-5';
		} elseif ($strength <= 5) {
			$taille = $estoc = $cornes = '1d-5';
			$morsure = '1d-4';
		} elseif ($strength == 6) {
			$taille = $estoc = '1d-4';
			$morsure = '1d-3';
			$cornes = '1d-5';
		} elseif ($strength == 7) {
			$taille = $estoc = $morsure = '1d-3';
			$cornes = '1d-5';
		} else {
			$taille = DiceManager::ip2dice($ip_t);
			$estoc = DiceManager::ip2dice($ip_e);
			$morsure = DiceManager::ip2dice($ip_m);
			$cornes = DiceManager::ip2dice($ip_c);
		}
		$damages = [
			'estoc' => $estoc,
			'taille' => $taille,
			'morsure' => $morsure,
			'cornes' => $cornes
		];
		return $damages;
	}

	/**
	 * processAttributes – process raw attributes, with no acount of AvDesav
	 *
	 * @param  array $attr raw indexed attributes
	 * @return array primary attributes with cost and secondary attributes
	 */
	static function processAttributes(array $attr = []): array
	{
		$keys = ["For", "Dex", "Int", "San", "Per", "Vol"];
		$points = [];

		foreach ($keys as $key) {
			$score = $attr[$key] ?? 10;
			$cost = (new Attribute($key))->cost($score);
			$points[$key] = $cost;
			$proc_attr[$key] = $score;
		}

		$for = $proc_attr["For"];
		$dex = $proc_attr["Dex"];
		$int = $proc_attr["Int"];
		$san = $proc_attr["San"];
		$per = $proc_attr["Per"];
		$vol = $proc_attr["Vol"];

		$proc_attr["Dégâts"] = self::getDamages($for);
		$proc_attr["Réflexes"] = floor(($dex + $per) / 2 - 3);
		$proc_attr["Sang-Froid"] = floor(($san + $vol) / 2);
		$proc_attr["Vitesse"] = ($for + $dex + $san)/6;
		$proc_attr["PdV"] = floor(($for + $san) / 2);
		$proc_attr["PdF"] = floor(($for + $san) / 2);
		$proc_attr["PdM"] = $int;
		$proc_attr["PdE"] = floor(($san + $vol) / 2);

		return [$proc_attr, $points];
	}
}
