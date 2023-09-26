<?php

namespace App\Rules;

class ArmorsController
{


	const armors = [
		'coutil' => ["nom" => "Coutil", 'RD' => 1, 'poids' => 3.5, 'notes' => NULL, 'prix-add' => 130,],
		'cuir' => ["nom" => "Armure de cuir", 'RD' => 2, 'poids' => 7, 'notes' => NULL, 'prix-add' => 340,],
		'cuir-l' => ["nom" => "Armure de cuir lourde", 'RD' => 3, 'poids' => 10.5, 'notes' => NULL, 'prix-add' => 480,],
		'ecailles' => ["nom" => "Armure d’écailles", 'RD' => 4, 'poids' => 16, 'notes' => '(1)', 'prix-add' => 600,],
		'brigandine' => ["nom" => "Brigandine", 'RD' => 4, 'poids' => 15, 'notes' => NULL, 'prix-add' => 650,],
		'ecailles-l' => ["nom" => "Armure d’écailles lourde", 'RD' => 5, 'poids' => 19.5, 'notes' => '(1)', 'prix-add' => 730,],
		'brigandine-l' => ["nom" => "Brigandine lourde", 'RD' => 5, 'poids' => 18, 'notes' => NULL, 'prix-add' => 800,],
		'maille' => ["nom" => "Cotte de maille", 'RD' => 5, 'poids' => 17, 'notes' => '(1)(2)', 'prix-add' => 850,],
		'bandes' => ["nom" => "Armure à bandes", 'RD' => 6, 'poids' => 23, 'notes' => '(1)(2)', 'prix-add' => 880,],
		'maille-l' => ["nom" => "Cotte de maille lourde", 'RD' => 6, 'poids' => 20, 'notes' => '(1)(2)', 'prix-add' => 1000,],
		'plates' => ["nom" => "Armure de plates", 'RD' => 8, 'poids' => 31, 'notes' => '(1)(3)', 'prix-add' => 3000,],
		'plates-l' => ["nom" => "Armure de plates lourde", 'RD' => 9, 'poids' => 35, 'notes' => '(1)(3)', 'prix-add' => 3300,],
	];

	const armors_notes = [
		'(1)' => 'poids et prix incluent un coutil qui doit être porté sous l’armure',
		'(2)' => '-1 en RD contre des attaques perforantes.',
		'(3)' => '-1 en RD contre des attaques portée par des armes de taille lourdes qui concentrent le point d’impact (hache, marteau de guerre, hallebarde, etc.)',
	];

	const armor_parts = [ // weight mult, price mult
		"tete" => ["nom" => "Tête (sans visage)", "mult_poids" => 0.05, "mult_prix" => 0.1, "notes" => null,],
		"visage" => ["nom" => "Visage", "mult_poids" => 0.015, "mult_prix" => 0.03, "notes" => null,],
		"cou" => ["nom" => "Cou", "mult_poids" => 0.03, "mult_prix" => 0.03, "notes" => "(1)",],
		"torse" => ["nom" => "Torse", "mult_poids" => 0.4, "mult_prix" => 0.42, "notes" => "(2)",],
		"bras" => ["nom" => "Bras", "mult_poids" => 0.17, "mult_prix" => 0.2, "notes" => null,],
		"jambes" => ["nom" => "Jambes", "mult_poids" => 0.25, "mult_prix" => 0.25, "notes" => "(3)",],
		"mains" => ["nom" => "Mains", "mult_poids" => 0.025, "mult_prix" => 0.05, "notes" => null,],
		"pieds" => ["nom" => "Pieds", "mult_poids" => 0.08, "mult_prix" => 0.05, "notes" => null,],
		"bottes" => ["nom" => "Bottes", "mult_poids" => 0.1425, "mult_prix" => 0.1125, "notes" => null,],
	];

	const armor_qualities = [ // weight mult, price mult
		"std" => ["nom" => "Normale", "mult_poids" => 1, "mult_prix" => 1],
		"bq" => ["nom" => "Bonne qualité", "mult_poids" => 0.9, "mult_prix" => 1.25],
		"tbq" => ["nom" => "Très bonne qualité", "mult_poids" => 0.8, "mult_prix" => 4],
	];

	const armor_sizes = [
		"m" => ["nom" => "normale", "mult_poids" => 1, "mult_prix" => 1],
		"s" => ["nom" => "petite", "mult_poids" => 0.8, "mult_prix" => 0.9],
		"xs" => ["nom" => "très petite", "mult_poids" => 0.6, "mult_prix" => 0.8],
	];

	const shields = [
		["nom" => "Petit, viking", "DP" => 2, "poids" => 3, "prix-add" => 30],
		["nom" => "Moyen, écu de chevalier", "DP" => 3, "poids" => 5, "prix-add" => 40],
		["nom" => "Grand, pavois d’archer", "DP" => 4, "poids" => 8, "prix-add" => 60],
	];
}
