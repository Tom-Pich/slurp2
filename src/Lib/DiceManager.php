<?php

namespace App\Lib;

abstract class DiceManager
{
	/**
	 * ip2dice
	 * Converts a number in to a dice expression
	 * with same manthematical expectation
	 *
	 * @param  float $ip
	 * @return string
	 */
	public static function ip2dice(float $ip)
	{
		$dices = intval($ip / 3.5);
		$remainder = fmod($ip, 3.5);

		if ($ip <= 0.2) {
			$result = '1d-5';
		} elseif ($ip <= 0.54) {
			$result = '1d-4';
		} elseif ($ip <= 1.34) {
			$result = '1d-3';
		} elseif ($ip <= 2.24) {
			$result = '1d-2';
		} else {
			if ($remainder > 3.14) {
				$result = ($dices + 1) . 'd';
			} elseif ($remainder > 2.24) {
				$result = ($dices + 1) . 'd-1';
			} elseif ($remainder > 1.44) {
				$result = $dices . 'd+2';
			} elseif ($remainder > 0.54) {
				$result = $dices . 'd+1';
			} elseif ($remainder <= 0.54) {
				$result = $dices . 'd';
			}
		}
		return $result;
	}

	/**
	 * diceParser
	 * Parses a dice expression into a valid sum
	 *
	 * @param  string $expression – like 2d+1-4+1d-2
	 * @return string parsed dices / modifiers – like 1d+2
	 */
	public static function diceParser(string $expression)
	{
		$dice_pattern = "/[\+-]*\d+d/";

		// check expression validity
		$invalid_characters = preg_match("/[a-c]|[e-zA-Z]|[\*\/]/", $expression);
		$invalid_dice_expression = preg_match("/^d|[\+-]d|d\d/", $expression);
		if ($invalid_characters || $invalid_dice_expression) {
			return "expression non valide";
		}

		// parsing dices
		preg_match_all($dice_pattern, $expression, $results);
		$dices = $results[0];
		foreach ($dices as $key => $value) {
			$dices[$key] = (int) rtrim($value, "d");
		}
		$dices_sum = array_reduce($dices, function ($sum, $x) {
			$sum += $x;
			return $sum;
		}) ?? 0;

		// parsing fixed numbers
		$fixed = preg_split($dice_pattern, $expression, -1, PREG_SPLIT_NO_EMPTY);
		$fixed = join("+", $fixed);
		$fixed_sum = TextParser::parseModifiersChain($fixed);

		// converting fixed numbers sum in dices
		$quotient = intval($fixed_sum / 7);
		$remainder = fmod($fixed_sum, 7);

		$dices_sum += $quotient * 2;
		$fixed_sum -= $quotient * 7;

		switch ($remainder) {
			case 6:
				$dices_sum += 2;
				$fixed_sum = -1;
				break;
			case 5:
				$dices_sum += 1;
				$fixed_sum = 2;
				break;
			case 4:
				$dices_sum += 1;
				$fixed_sum = 1;
				break;
			case 3:
				$dices_sum += 1;
				$fixed_sum = 0;
				break;

			case -2:
				if ($dices_sum >= 2) {
					$dices_sum -= 1;
					$fixed_sum = 2;
				}
				break;
			case -3:
				if ($dices_sum >= 2) {
					$dices_sum -= 1;
					$fixed_sum = 1;
				}
				break;
			case -4:
				if ($dices_sum >= 2) {
					$dices_sum -= 1;
					$fixed_sum = 0;
				}
				break;
			case -5:
				if ($dices_sum >= 3) {
					$dices_sum -= 2;
					$fixed_sum = 2;
				} elseif ($dices_sum === 2) {
					$dices_sum -= 1;
					$fixed_sum = -1;
				}
			case -6:
				if ($dices_sum >= 3) {
					$dices_sum -= 2;
					$fixed_sum = 1;
				} elseif ($dices_sum === 2) {
					$dices_sum -= 1;
					$fixed_sum = -2;
				}
				break;
		}

		$parsed_expression = $dices_sum . "d";
		if ($fixed_sum < 0) {
			$parsed_expression .= $fixed_sum;
		}
		if ($fixed_sum > 0) {
			$parsed_expression .= "+" . $fixed_sum;
		}

		return $parsed_expression;
	}

	/**
	 * Calculate a modifier based on a value and a reference. This modifier is equal to
	 * ± 1 per 10% of difference.
	 * @param float $value number that will be compared to $ref
	 * @param float $ref the reference number
	 * @param bool $excess_is_bad if true, modifier will be negative if value > ref
	 * @return int ± 1 per 10% of difference
	 */
	public static function getModifier(float $value, float $ref, bool $excess_is_bad = true): int
	{
		if ($ref == 0) return 0;
		return (int) round(($value / $ref - 1) * 10) * ($excess_is_bad ? -1 : 1);
	}

	/**
	 * given a score and a dice roll, return roll success status
	 * does not take into account critical success or critical miss
	 * @param int $score the score to be tested
	 * @param int $roll the roll result (3d6)
	 * @return bool success status of the roll
	 */
	public static function isSuccess(int $score, int $roll): bool
	{
		if ($roll <= 4) {
			return true; // automatic success
		} elseif ($roll >= 17) {
			return false; // automatic failure
		} else {
			return $roll <= $score;
		}
	}

	/**
	 * transform a MR into a number between 0.1 and 3
	 * if MR = 0, ratio = 1
	 * ratio is < 1 when MR > 0
	 * @param int $mr
	 */
	public static function mr2ratio(int $mr)
	{
		if ($mr >= 0) $ratio = 1 - 0.1 * $mr; // MR 0 → 1 ; MR 5 → 0.5
		else $ratio = 1 - 0.2 * $mr; // MR -1 → 1.2 ; MR -5 → 2; MR -10 → -3
		$ratio = max($ratio, 0.1); // min 0.1
		$ratio = min($ratio, 3); // max 3
		return $ratio;
	}
}
