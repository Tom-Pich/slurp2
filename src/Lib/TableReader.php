<?php

namespace App\Lib;

class TableReader
{
	/**
	 * return the element of the array with the nearest index superior to value
	 * @param array $table : an simple array or indexed array with integer indexes
	 * @param float $value : the value of the index to be found. If index does not exist, return the nearest superior index.
	 * @param bool $strict : if true, the index must be strictly superior to the value
	 * @return any : the nearest array element superior (or equal) to the value provided. Null if that’s not possible
	 */
	static function getResult(array $table, float $value, bool $strict = false)
	{
		foreach ($table as $index => $line) {
			if ($strict && $value < $index) {
				return $line;
			} elseif (!$strict && $value <= $index) {
				return $line;
			}
		}
	}

	/**
	 * return a random element of $table with weighted probability.
	 * the probability weight for each element of $table is given as an integer
	 * in the $index_weights.
	 * @param array $table with n elements
	 * @param array $index_weights contains n integers >= 0
	 * @return any the element picked in $table
	 */
	static function getWeightedResult(array $table, array $index_weights)
	{
		if(count($table) !== count($index_weights)){
			throw new \Exception("Both argument arrays must have the same dimensions");
		}

		$indexes = [];
		// add index number as many time as weight
		foreach ($index_weights as $index => $weight) {
			for ($i = 0; $i < $weight; $i++) {
				$indexes[] = $index;
			}
		}

		// select a random index
		$picked_index = $indexes[random_int(0, count($indexes) - 1)];

		// return the picked element from the table
		return $table[$picked_index];
	}

}