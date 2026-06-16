<?php

namespace App\Lib;

class ListWriter
{
	// première lettre en majuscule, y compris caractères accentués
	public static function ucf(string $str, string $encoding = 'UTF-8'): string
	{
		$str = htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
		return mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding)
			. mb_substr($str, 1, null, $encoding);
	}

	// renvoie les éléments HTML <li> près à être afficher
	static function displayList(array $list): string
	{
		$list_content = '';
		if (array_is_list($list)) {
			// liste simple
			foreach ($list as $item) {
				$item = self::ucf($item);
				$list_content .= '<li>' . $item . '</li>';
			}
		} else {
			// tableau associatif label => [sous-liste]
			foreach ($list as $label => $sublist) {
				$label = self::ucf($label);
				$list_content .= '<li><b>' . $label . '</b>';
				if (count($sublist)) {
					$sublist = join(", ", $sublist);
					$list_content .= ' : ' . htmlspecialchars($sublist, ENT_QUOTES, 'UTF-8');
				}
				$list_content .= '</li>';
			}
		}
		return $list_content;
	}
}
