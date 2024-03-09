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
	 * @return string parsed dices / modifiers
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
		$dices_sum = array_reduce($dices, function ($sum, $x){
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
				if($dices_sum >= 2){
					$dices_sum -= 1;
					$fixed_sum = 2;
				}
				break;
			case -3:
				if($dices_sum >= 2){
					$dices_sum -= 1;
					$fixed_sum = 1;
				}
				break;
			case -4:
				if($dices_sum >= 2){
					$dices_sum -= 1;
					$fixed_sum = 0;
				}
				break;
			case -5:
				if($dices_sum >= 3){
					$dices_sum -= 2;
					$fixed_sum = 2;
				}
				elseif ($dices_sum === 2){
					$dices_sum -= 1;
					$fixed_sum = -1;
				}
			case -6:
				if($dices_sum >= 3){
					$dices_sum -= 2;
					$fixed_sum = 1;
				}
				elseif ($dices_sum === 2){
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
}
