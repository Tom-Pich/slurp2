<?php

namespace App\Lib;

class TableReader
{
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
}