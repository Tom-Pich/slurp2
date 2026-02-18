<?php

namespace App\Rules;

class ArmorsController
{
	const armors = [
		// prix [ AD&D, Ombres d’Esteren ]
		'coutil' => ["nom" => "Coutil", 'RD' => 1, 'pds' => 3.5, 'notes' => NULL, 'prix' => [130],],
		'cuir' => ["nom" => "Armure de cuir", 'RD' => 2, 'pds' => 7, 'notes' => NULL, 'prix' => [340, 20],],
		'cuir-l' => ["nom" => "Armure de cuir lourde", 'RD' => 3, 'pds' => 10.5, 'notes' => NULL, 'prix' => [480, 30],],
		'ecailles' => ["nom" => "Armure d’écailles", 'RD' => 4, 'pds' => 16, 'notes' => '(1)', 'prix' => [600],],
		'brigandine' => ["nom" => "Brigandine", 'RD' => 4, 'pds' => 15, 'notes' => NULL, 'prix' => [650],],
		'ecailles-l' => ["nom" => "Armure d’écailles lourde", 'RD' => 5, 'pds' => 19.5, 'notes' => '(1)', 'prix' => [730],],
		'brigandine-l' => ["nom" => "Brigandine lourde", 'RD' => 5, 'pds' => 18, 'notes' => NULL, 'prix' => [800],],
		'maille' => ["nom" => "Cotte de maille", 'RD' => 5, 'pds' => 17, 'notes' => '(1)(2)', 'prix' => [850, 70],],
		'bandes' => ["nom" => "Armure à bandes", 'RD' => 6, 'pds' => 23, 'notes' => '(1)(2)', 'prix' => [880],],
		'maille-l' => ["nom" => "Cotte de maille lourde", 'RD' => 6, 'pds' => 20, 'notes' => '(1)(2)', 'prix' => [1000],],
		'plates' => ["nom" => "Armure de plates", 'RD' => 8, 'pds' => 31, 'notes' => '(1)(3)', 'prix' => [3000],],
		'plates-l' => ["nom" => "Armure de plates lourde", 'RD' => 9, 'pds' => 35, 'notes' => '(1)(3)', 'prix' => [3300],],
	];

	const armors_notes = [
		'(1)' => 'poids et prix incluent un coutil qui doit être porté sous l’armure',
		'(2)' => '-1 en RD contre des attaques perforantes.',
		'(3)' => '-1 en RD contre des attaques portée par des armes de taille lourdes qui concentrent le point d’impact (hache, marteau de guerre, hallebarde, etc.)',
	];

	const armor_parts = [
		"tete" => ["nom" => "Tête (sans visage)", "mult_pds" => 0.05, "mult_prix" => 0.1, "notes" => null,],
		"visage" => ["nom" => "Visage", "mult_pds" => 0.015, "mult_prix" => 0.03, "notes" => null,],
		"cou" => ["nom" => "Cou", "mult_pds" => 0.03, "mult_prix" => 0.03, "notes" => "(1)",],
		"torse" => ["nom" => "Torse", "mult_pds" => 0.4, "mult_prix" => 0.42, "notes" => "(2)",],
		"bras" => ["nom" => "Bras", "mult_pds" => 0.17, "mult_prix" => 0.2, "notes" => "(2)",],
		"jambes" => ["nom" => "Jambes", "mult_pds" => 0.25, "mult_prix" => 0.25, "notes" => "(2)",],
		"mains" => ["nom" => "Mains", "mult_pds" => 0.025, "mult_prix" => 0.05, "notes" => null,],
		"pieds" => ["nom" => "Pieds", "mult_pds" => 0.08, "mult_prix" => 0.05, "notes" => null,],
		"bottes" => ["nom" => "Bottes", "mult_pds" => 0.1425, "mult_prix" => 0.1125, "notes" => null,],
	];

	const armor_parts_notes = [
		"(1)" => "la protection du cou est normalement assurée par la pièce d’armure du torse. Mais pour certains types d’armures (cuir, brigandine, maille), il est possible de rattacher cette protection à la pièce protégeant la tête.",
		"(2)" => "il est possible de ne protéger que la moitié de cette localisation. Moitié du coût et moitié du poids.",
	];

	const armor_qualities = [
		"std" => ["nom" => "Normale", "mult_pds" => 1, "mult_prix" => 1],
		"bq" => ["nom" => "Bonne qualité", "mult_pds" => 0.9, "mult_prix" => 1.25],
		"tbq" => ["nom" => "Très bonne qualité", "mult_pds" => 0.8, "mult_prix" => 4],
	];

	const armor_sizes = [
		"l" => ["nom" => "grande", "notes" => "homme, grande taille", "mult_pds" => 1.1, "mult_prix" => 1.1],
		"m" => ["nom" => "normale", "notes" => "homme, taille moyenne", "mult_pds" => 1, "mult_prix" => 1],
		"s" => ["nom" => "petite", "notes" => "femme, elfe, nain", "mult_pds" => 0.8, "mult_prix" => 0.9],
		"xs" => ["nom" => "très petite", "notes" => "enfant, hobbit", "mult_pds" => 0.6, "mult_prix" => 0.8],
	];

	const shields = [
		// prix [ AD&D, Ombres d’Esteren ]
		["nom" => "Petit, type viking", "DP" => 2, 'pds' => 2.5, 'prix' => [30, 20]],
		["nom" => "Moyen, écu de chevalier", "DP" => 3, 'pds' => 4, 'prix' => [40, 30]],
		["nom" => "Grand, pavois d’archer", "DP" => 4, 'pds' => 6.5, 'prix' => [60]],
	];
}
