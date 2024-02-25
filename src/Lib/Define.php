<?php

namespace App\Lib;

abstract class Define
{	

	const magic_dictionnary = [
		'dégâts P-Ex-sRD' 	=> '1d-1/1d+2/3d/5d/(12d) ; ×1,5 à NT7+',
		'dégâts standards' 	=> '1d/2d/4d/7d/(18d) ; ×1,5 à NT7+',
		'dégâts répétés' 	=> '1d-2/1d/2d/3d+2/(9d) ; ×1,5 à NT7+',
		'bonus standards'	=> '+1/+2/+3/+5/&infin;',
		'malus standards'	=> '-1/-2/-3/-5/&infin;',
		'bonus BDS' 		=> '+2/+1d+1/+2d/+3d/+7d+2',
		'modificateurs de longue distance' => "jusqu’à 100 m → 0 ; 300 m → -1 ; 1 km → -2 ; 3 km → -3 ; 10 km → -4 ; 30 km → -5 ; etc.",
		'bonus de RD'		=> '+2/+4/+6/+10 ; ×1,5 à NT6 ×2 à NT7+',
		"bonus de Force standards" => "+20% / +40% / +60% / +100% / &infin;"
	];

	/**
	 * implementDefinitions
	 *
	 * @param  string $text
	 * @param  array $dictionnary containing "word" => "definition"
	 * @return string text with definitions implemented
	 */
	static public function implementDefinitions(string $text, array $dictionnary){
		foreach ($dictionnary as $word => $definition) {
			$regex_f = '#'.$word.'#i';
			$regex_r = "<dfn title='$definition'>".$word.'</dfn>';
			$text = preg_replace($regex_f, $regex_r, $text);
		}
		return $text;
	}
}