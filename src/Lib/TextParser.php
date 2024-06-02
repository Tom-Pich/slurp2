<?php

namespace App\Lib;

class TextParser
{
	const latinNumbers = [1 => "I", 2 => "II", 3 => "III", 4 => "IV", 5 => "V", 6 => "VI", 7 => "VII", 8 => "VIII", 9 => "IX", 10 => "X",];

	/**
	 * parseModif – finds pattern like (+3) or (-2) and return corresponding int
	 *
	 * @param  string $str containing a modifier expression or not
	 * @return int modifier value or zero
	 */
	public static function parseModif(string $str): int
	{
		$modifier_regexp = "/\(([\+-]\d+)\)/";
		preg_match($modifier_regexp, $str, $matches);
		return !empty($matches[1]) ? (int)($matches[1]) : 0;
	}

	public static function parseMultiplier(string $str): float
	{
		$multiplier_regexp = "/\(×(\d*\.*\d*)\)/";
		preg_match($multiplier_regexp, $str, $matches);
		return !empty($matches[1]) ? (float)($matches[1]) : 1.0;
	}

	/**
	 * parseNumbers2Latin – returns latin numbers expression corresponding to min and max \
	 * if max = 0 or max = min, return only one latin number
	 *
	 * @param  int $min
	 * @param  int $max
	 * @return string like I-III or II-V or III
	 */
	public static function parseNumbers2Latin(int $min, int $max = 0): string
	{
		$is_multi_level = $min < $max && $max;
		$latin_numbers = self::latinNumbers[$min] ?? "NA";
		if ($is_multi_level) {
			$latin_numbers .= "-" . (self::latinNumbers[$max] ?? "NA");
		}
		return $latin_numbers;
	}

	/**
	 * parseLatin2Numbers – from string containing pattern like (II-IV) or (I) \
	 * extracts and return array with corresponding numbers
	 *
	 * @param  string $str
	 * @return array empty if nothing is found, one number or two numbers
	 */
	public static function parseLatin2Numbers(string $str): array
	{
		$latin_regexp = "/\(([IVX-]+)\)/";
		preg_match($latin_regexp, $str, $matches);
		$result = [];
		if (!empty($matches[1])) {
			$latin_number_array = explode("-", $matches[1]);
			$result[] = array_search($latin_number_array[0], self::latinNumbers);
			if (!empty($latin_number_array[1])) {
				$result[] = array_search($latin_number_array[1], self::latinNumbers);
			}
		}
		return $result;
	}


	/**
	 * correctLatin – correct or insert latin expression like (I-III) or (IV) \
	 * according to the min and max values given.
	 *
	 * @param  string $str
	 * @param  int $min
	 * @param  int $max
	 * @return string
	 */
	public static function correctLatin(string $str, int $min, int $max = 0): string
	{
		$latin_regexp = "/\(([IVX-]+)\)/";
		$correct_latin_expr = self::parseNumbers2Latin($min, $max);
		preg_match($latin_regexp, $str, $matches);
		if (empty($matches[1])) {
			$corrected_str = $str . " (" . $correct_latin_expr . ")";
		} else {
			$corrected_str = preg_replace($latin_regexp, "(" . $correct_latin_expr . ")", $str);
		}
		return $corrected_str;
	}


	/**
	 * parseInt2Modif – return a +x if x>=0, unchanged if x < 0
	 *
	 * @param  int $modif
	 * @return string
	 */
	public static function parseInt2Modif(int $modif): string
	{
		if ($modif >= 0) {
			return "+" . $modif;
		}
		return $modif;
	}

	/**
	 * parse2array – transform a losely formatted string into an index array \
	 * entry separator: ; or ,
	 * key/value separator: space or :
	 *
	 * @param  string $text
	 * @return array
	 */
	public static function parsePseudoArray2Array(string $text): array
	{
		$text = trim($text);
		$text = rtrim($text, ";, ");
		// check if string format seems correct
		$text = preg_replace("/\s{1,}[,;]/", ";", $text);
		$uncorrect_pattern = "/[^\s:;,]+\s+[^\s:;,]+\s+/";
		preg_match($uncorrect_pattern, $text, $matches);
		if (!empty($matches)) {
			return [];
		}
		// parse string format
		$elements_separator_regexp = "/\s{0,}[,;]\s{0,}/";
		$text = preg_replace($elements_separator_regexp, ";", $text);
		$text = preg_replace("/:/", " ", $text);
		$text = preg_replace("/\s{1,}/", " ", $text);
		$simple_array = explode(";", $text);
		$indexed_array = [];
		foreach ($simple_array as $element) {
			$exploded_element = explode(" ", $element);
			$indexed_array[$exploded_element[0]] = $exploded_element[1] ?? NULL;
		}
		return $indexed_array;
	}

	/**
	 * parseModifiersChain
	 *
	 * @param  string $expression like "+2-5+3"
	 * @return int sum of all modifiers
	 */
	public static function parseModifiersChain(string $expression): int
	{
		$expression = preg_replace("/-/", "+-", $expression);
		$expression = preg_split("/\+/", $expression, -1, PREG_SPLIT_NO_EMPTY);
		foreach ($expression as $key => $number) {
			$expression[$key] = (int) $number;
		}
		$expression_sum = array_reduce($expression, function ($sum, $x) {
			$sum += $x;
			return $sum;
		}) ?? 0;
		return $expression_sum;
	}

	/**
	 * parseObjectCounter – from object name, extract label, current value, max value and unit\
	 * format must be like : my object name 15/20 my-unit OR my object name (75%)
	 *
	 * @param  string $name
	 * @return array empty if nothing found, else indexed array with label, current, max, unit
	 */
	public static function parseObjectCounter(string $name): array
	{
		$regexp_counter1 = "/(.+[ \(])(\d+[\.]*\d{0,})\/(\d+[\.,]*\d{0,})( .{0,})*/"; // like : object name 10/12 charges
		$regexp_counter2 = "/(.+[ \(])[ \(](\d+[\.]*\d{0,}) ?\%/"; // like : object name (75%)

		preg_match($regexp_counter1, $name, $matches1);
		preg_match($regexp_counter2, $name, $matches2);
		if (!empty($matches1)) {
			return [
				"label" => isset($matches1[1]) ? trim($matches1[1]) : "erreur de format&nbsp;!",
				"current" => (float) $matches1[2] ?? 0,
				"max" => (float) $matches1[3] ?? 10,
				"unit" => isset($matches1[4]) ? trim($matches1[4]) : "",
			];
		} elseif (!empty($matches2)) {
			return [
				"label" => isset($matches2[1]) ? trim($matches2[1]) : "erreur de format&nbsp;!",
				"current" => (float) $matches2[2] ?? 0,
				"max" => 100,
				"unit" => "%",
			];
		} else {
			return [];
		}
	}

	/**
	 * pseudoMDParser – convert custom simplified markdown to html string \
	 * ** for h4 \
	 * - for list item\
	 * *text* for bold\
	 * _text_ for italic\
	 * default tag is p
	 *
	 * @param  string $text
	 * @return string HTML converted text
	 */
	public static function pseudoMDParser(string $text): string
	{
		$lines = explode("\n", $text);

		// implementing block tags
		$processed_lines_blocks = [];
		$current_block = null;
		foreach ($lines as $index => $line) {
			$line = trim($line);

			// block h4
			if (substr($line, 0, 2) === "**") {
				$line = trim($line, "** ");
				$line = sprintf("<h4>%s", $line);
				if ($current_block === "li") {
					$line = "</li></ul>" . $line;
				} elseif ($current_block) {
					$line = "</$current_block>" . $line;
				}
				$current_block = "h4";
			}
			// block ul/li
			elseif (substr($line, 0, 1) === "-") {
				$line = trim($line, "- ");
				$line = sprintf("<li>%s", $line);
				if ($current_block === "li") {
					$line = "</li>" . $line;
				} elseif ($current_block) {
					$line = "</$current_block><ul>" . $line;
				} else {
					$line = "<ul>" . $line;
				}
				$current_block = "li";
			}

			// no block : opening p
			elseif (!$current_block && !empty($line)) {
				$line = "<p>" . $line;
				$current_block = "p";
			}
			// block : ending block and opening p
			elseif ($current_block !== "p" && !empty($line)) {
				if ($current_block === "li") {
					$line = "</li></ul><p>" . $line;
				} else {
					$line = "</$current_block><p>" . $line;
				}
				$current_block = "p";
			}
			// inserting <br> on new line inside p
			elseif ($current_block === "p" && !empty($line)) {
				$line = "<br>" . $line;
			}

			// ending block if line empty
			elseif (empty($line) && $current_block) {
				if ($current_block === "li") {
					$line = "</li></ul>";
				} else {
					$line = "</$current_block>";
				}
				$current_block = null;
			}

			// ending current block on last line
			if ($index === array_key_last($lines)) {
				if ($current_block === "li") {
					$line = $line . "</li></ul>";
				} else {
					$line = $line . "</$current_block>";
				}
			}

			//filtering empty lines
			if (!empty($line)) {
				$processed_lines_blocks[] = $line;
			}
		}

		// joining blocks → each array element is a complete block
		// joining each element in a string
		$joined_lines_blocks = join(" ", $processed_lines_blocks);

		// cleaning the string
		$joined_lines_blocks = preg_replace("/\s+/", " ", $joined_lines_blocks); // multiple space into one
		$joined_lines_blocks = preg_replace("/ </", "<", $joined_lines_blocks); // delete space before tag

		// regenerating array
		$joined_lines_blocks = preg_replace("/>\s*</", ">|–|<", $joined_lines_blocks); // custom explode marker |–|
		$processed_lines_blocks = explode("|–|", $joined_lines_blocks);

		// processing inline tag
		$processed_lines_inline = [];
		foreach ($processed_lines_blocks as $block) {
			$block = preg_replace("/\*([^\*<>]+)\*/", "<b>$1</b>", $block);
			$block = preg_replace("/_([^\*<>]+)_/", "<i>$1</i>", $block);
			$processed_lines_inline[] = $block;
		}

		// joining final result in a string
		$final_html = join("", $processed_lines_inline);
		return $final_html;
	}

	/**
	 * cleanPunctuation – various transformations of spacing and signs \
	 * to fit french rules
	 *
	 * @param  string $text
	 * @return string
	 */
	public static function cleanPunctuation(string $text): string
	{
		$char_replaces = [

			"#\s{1,}#" => " ",
			"# {1,}#" => "",
			"#  #" => "",

			"#'#" => "’",
			"#(&nbsp;){1,}#" => " ",

			"#([^\s ]):#" => "$1 : ",
			"#([^\s ]);#" => "$1 ; ",
			"#([^\s ])\?#" => "$1 ? ",
			"#([^\s ])\!#" => "$1 ! ",

			//"#,\S#" => ", ",
			"# ,[\S\D]#" => ", ",
			"#, (\d+)#" => ",$1",

			"# :#" => " :",
			"# ;#" => " ;",
			"# \?#" => " ?",
			"# \!#" => " !",
			"# %#" => " %",

			"#\"(\S)#" => "« $1",
			"#(\S)\"#" => "$1 »",
			"#« #" => "« ",
			"# »#" => " »",
			
			/* "#\s{1,}#" => " ",
			"# {1,}#" => " ",
			"#  #" => " ", */
		];
		foreach ($char_replaces as $char_search => $char_replace) {
			$text = preg_replace($char_search, $char_replace, $text);
		}
		return trim($text);
	}

	/**
	 * transform a string serie of operations (with + and -) into a number
	 * will return 0 if argument is not a number or a string, and if string cannot be parsed
	 */
	public static function evalString($value): int|float
	{
		if(is_int($value) || is_float($value)) return $value;
		if (!is_string($value)) return 0;

		// sanitizing expression
		$value = preg_replace('/,/', '.', $value); // comma into dot

		// return 0 if not valid string
		if (preg_match('/[^0-9+\-. ]/',$value)) return 0;

		$result = eval("return $value;");
		if (is_null($result)) $result = 0;

		return $result;
	}
}
