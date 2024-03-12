<?php

namespace App\Rules;

class ObjectController
{
	public const object_types = [
		"voiture" => [
			"localisations" => [
				"avant" => [2 => "Moteur" , 4 => "Occupant", 5 => "Équipement divers", 6 => "Roue"],
				"latéral" => [1 => "Moteur", 2 => "Occupant", 3 => "Porte", 4 => "Roue", 5 => "Équipement divers", 6 => "Réservoir"],
				"arrière" => [2 => "Occupant" , 3 => "Équipement divers", 4 => "Roue", 5 => "Réservoir"],
			],
		],
		"moto" => [
			"localisations" => [
				"avant" => [2 => "Roue" , 4 => "Fourche" , 6 => "Conducteur"],
				"latéral" => [1 => "Roue", 2 => "Fourche", 3 => "Réservoir", 4 => "Moteur", 5 => "Équipement divers", 6 => "Conducteur"],
				"arrière" => [2 => "Roue", 5 => "Conducteur", 6 => "Équipement divers"],
			],
		],
		"robot" => [
			"localisations" => [
				"générale" => [1 => "Membre manipulateur", 2 => "Dispositif de locomotion", 3 => "Système informatique central", 4 => "Système sensoriel", 5 => "Batterie", 6 => "Armement/outillage"],
			],
		],
		"quadricoptère" => [
			"localisations" => [
				"générale" => [2 => "Hélice", 4 => "Pilote", 5 => "Batterie", 6 => "Équipement divers"],
			],
		]
	];
}