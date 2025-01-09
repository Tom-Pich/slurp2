<?php

namespace App\Lib;

abstract class Sorter
{

	/**
	 * sort
	 *
	 * @param  array $array to be sorted
	 * @param  string $key (optionnal) sorted by key
	 * @return array
	 */
	static public function sort(array $array, string $key = "", bool $reverse = false) : array
	{
		if ($key) {
			usort($array, function ($a, $b) use ($key, $reverse) {
				if (is_numeric($a[$key])) {
					$compare = $reverse ? $b[$key] - $a[$key] : $a[$key] - $b[$key];
				}
				else {
					$compare = $reverse ? strcoll($b[$key], $a[$key]) : strcoll($a[$key], $b[$key]);
				}
				return $compare;
			});
		} else {
			usort($array, function ($a, $b) use ($reverse) {
				return $reverse ? strcoll($a, $b) : strcoll($a, $b);
			});
		}
		return $array;
		/* if ($key) {
			uasort($array, function ($a, $b) use ($key, $reverse) {
				if (is_numeric($a[$key])) {
					$compare = $reverse ? $b[$key] - $a[$key] : $a[$key] - $b[$key];
				}
				else {
					$compare = $reverse ? strcoll($b[$key], $a[$key]) : strcoll($a[$key], $b[$key]);
				}
				return $compare;
			});
		} else {
			uasort($array, function ($a, $b) use ($reverse) {
				return $reverse ? strcoll($a, $b) : strcoll($a, $b);
			});
		}
		return array_values($array); */
	}

	static public function sortPowersByName(array $array)
	{
		uasort($array, function ($a, $b) {
			return strcoll( $a->specific["Nom"] ?? $a->data->name, $b->specific["Nom"] ?? $b->data->name);
		});

		return array_values($array);
	}
}
