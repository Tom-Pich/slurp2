<?php

namespace App\Rules;

class CriticalController
{
	public const attack_success = [
		2 => "Dégâts ×2&nbsp;; l’ennemi est sonné s’il reçoit des dégâts.",
		5 => "Dégâts ×2, RD divisée par 2&nbsp;; l’ennemi est sonné (niveau 2) s’il reçoit des dégâts.",
		6 => "Dégâts ×3, RD divisée par 3&nbsp;; l’ennemi perd conscience s’il reçoit des dégâts."
	];

	public const contact_weapon_miss = [
		1 => "Arme désapprêtée.",
		2 => "Jet de <i>Dex</i>-3 pour ne pas tomber. Au tour suivant perte initiative et <i>Défenses</i> à -2.",
		3 => "L’attaquant perd son arme, elle atterrit à 1d mètre de lui ou l’arme se plante dans le décor (choix du MJ)",
		4 => "L’arme peut se briser&nbsp;: probabilité de n/6 que l’arme se brise. n = 2 en cas d’attaque ou en parant une arme de même poids, n = 3 pour une arme 2× plus lourde, n = 4 pour une arme 3× plus lourde, etc.",
		5 => "L’attaquant blesse un allié. Si ce n’est pas possible, il perd son arme.",
		6 => "L’attaquant se blesse avec son arme (demi-dégâts normaux) ou se foule l’épaule / se blesse la main (bras/main handicapé, une journée pour se rétablir)."
	];

	public const missile_weapon_miss = [
		2 => "l’arme glisse des mains du personnage. Le tir est manqué et le personnage doit réapprêter son arme.",
		4 => "le personnage hésite. Il perd le tour.",
		6 => "une victime au hasard, dans la direction de la cible, est touchée.",
	];

	public const throwing_weapon_miss = [
		1 => "L’attaquant se foule l’épaule ou se bloque le dos (bras handicapé, une journée pour se rétablir).",
		2 => "Jet de <i>Dex</i>-3 pour ne pas tomber.",
		3 => "L’arme a 50&nbsp;% de chance de se briser.",
		4 => "Le personnage hésite. Il perd son tour.",
		6 => "Une victime au hasard, dans la direction de la cible, est touchée.",
	];

	public const movement_miss = [
		1 => "Jet de <i>Dex</i>-3 pour ne pas tomber.",
		2 => "Le personnage tombe.",
		3 => "Le personnage tombe et est sonné au niveau 2. Faire un jet de <i>San</i>. Le nombre d’actions perdues est égale à la ME du jet (minimum 1).",
		4 => "Le personnage tombe, subit 1d-3 de dégâts au bras ou à la main et est sonné. Faire un jet de <i>San</i>. Le nombre d’actions perdues est égale à la ME du jet (minimum 1).",
		5 => "Le personnage tombe la tête la première, 1d÷2 pts de dégâts à la tête. Voir les conséquences avec le widget <i>Blessure</i>",
		6 => "Le personnage fait une chute spectaculaire. Il encaisse 1d pts de dégâts et est sonné au niveau 3.",
	];

	public const spell_miss = [
		6 => "Le sort semble agir, mais les effets produits ne sont qu'un pâle ersatz des effets attendus.",
		7 => "Les effets du sort se limitent à un grand bruit suivi de crépitement de lumière colorée.",
		8 => "Le sort échoue. L'initiateur est sonné (niveau 2). Faire un jet de <i>San</i>. Le nombre d’actions perdues est égale à la ME du jet (minimum 1).",
		9 => "Les effets sont l’inverse de ceux attendus. Refaire un jet si ce n’est pas possible.",
		10 => "Le sort affecte une autre cible au choix du MJ. Refaire un jet si ce n’est pas possible.",
		11 => "Le sort se retourne contre son initiateur. Refaire un jet si ce n’est pas possible.",
		13 => "Le sort échoue. L’initiateur subit [1d×niveau de puissance] de dégâts, perd tous ses PdM et ceux de la ou des pierres de puissance qu’il portait.",
		14 => "Le sort échoue. L’initiateur tombe dans le coma pendant 1d minutes / heures / jours / semaines / mois selon le niveau du sort.",
		15 => "Explosion&nbsp;! [1d×niveau de puissance] de dégâts explosifs centrés sur l’initiateur.",
		16 => "Le sort échoue. L’initiateur vieillit de [1d×niveau de puissance] années et perd 1d/1d+2/2d/2d+2/3d PdE selon le niveau de puissance.",
		17 => "Le sort échoue. Un démon apparaît et attaque l’initiateur, sauf si ses intentions étaient pures (refaire un jet). Sort de niveau I ou II → démon mineur. III/IV/V → démon moyen / majeur / majeur extrêmement puissant.",
	];

	public static function CriticalResult(string $table_name, int $roll_3d, int $roll_1d)
	{
		$table = constant("self::$table_name");
		$roll = in_array($table_name, ["spell_miss"]) ? $roll_3d : $roll_1d;
		while (!isset($table[$roll])) {
			$roll++;
		}
		return $table[$roll];
	}
}
