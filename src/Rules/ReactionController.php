<?php

namespace App\Rules;
use App\Lib\TableReader;

class ReactionController
{
	public const reactions = [
		"-4" => "<b>Désastreuse.</b> Le PNJ déteste le personnage et fera tout ce qui est en son pouvoir pour lui nuire.",
		"-2" => "<b>Très mauvaise</b>. Le PNJ n’apprécie pas le personnage et le desservira si c’est possible et profitable.",
		"0" => "<b>Mauvaise.</b> Le PNJ se fiche éperdument des joueurs et leur mettra des bâtons dans les roues si cela peut lui être profitable.",
		"2" => "<b>Médiocre.</b> Le PNJ n’est pas impressionné le moins du monde. Il ne sera ni agréable ni serviable.",
		"4" => "<b>Neutre.</b> Le PNJ se comportera selon les normes sociales en vigueur.",
		"6" => "<b>Assez bonne.</b> Le PNJ sera plutôt agréable et relativement serviable si cela ne lui coûte rien.",
		"8" => "<b>Bonne.</b> Le PNJ se montre accueillant avec le personnage et s’efforcera de lui être utile dans les limites du raisonnable.",
		"10" => "<b>Très bonne.</b> Le PNJ ne pense que du bien du personnage, il sera très amical et peu avare de ses services.",
		"11" => "<b>Excellente.</b> Le PNJ est impressionné par le personnage et agira dans son intérêt à tous les instants dans les limites de ses propres capacités."
	];

	static public function getReaction(int $roll)
	{
		return TableReader::getResult(self::reactions, $roll);
	}
}