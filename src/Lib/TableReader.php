<?php

namespace App\Lib;

class TableReader
{
	/**
	 * return a random array element
	 * @param array $table simple or indexed array
	 * @param int|float|array|null $x choice method.
	 * 		null → pick random element (default),
	 * 		number → return nearest element with index ≥ $x
	 *      array → pick element with weighted probability
	 * @return mixed picked element
	 */
	static function pickResult(array $table, int|float|array|null $x = null): mixed
	{
		// pick a random element
		if (is_null($x)) {
			if (!count($table)) return "La table est vide";
			shuffle($table);
			return $table[0];
		}

		// return the closest superior index
		if (is_numeric($x)) {
			foreach ($table as $index => $line) {
				if ($x <= $index) return $line;
			}
			return "Valeur non présente dans la table";
		}

		//pick an element with weighted probability
		if (is_array($x)) {

			if (count($table) !== count($x)) throw new \Exception("arrays must have same dimension!");

			$pickable_table = [];
			$table = array_values($table); // get rid of potential incoherent indexes

			foreach ($x as $index => $weight) {
				for ($i = 0; $i < $weight; $i++) $pickable_table[] = $table[$index];
			}

			if (!count($pickable_table)) return "Aucun résultat à retourner";
			$random_index = random_int(0, count($pickable_table) - 1);
			return $pickable_table[$random_index];
		}

		throw new \Exception("Something unexpected happened! 😖");
	}
}
