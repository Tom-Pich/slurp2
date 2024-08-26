<?php

namespace App\Rules;

class WeaponsController
{

	const weapons = [
		// prix : [AD&D]
		['nom' => 'Arc moyen', 'deg' => 'P.e+2, 15/F×5', 'Fm' => 10, 'pds' => 1, 'cat' => 'arc', 'prix' => [100],],
		['nom' => 'Arc long', 'deg' => 'P.e+3, 15/F×8', 'Fm' => 11, 'pds' => 1.5, 'cat' => 'arc', 'prix' => [200],],
		['nom' => 'Arc composite', 'deg' => 'P.e+3, 15/F×8', 'Fm' => 10, 'pds' => 1.5, 'cat' => 'arc', 'prix' => [300],],
		['nom' => 'Arc court (pour nain)', 'deg' => 'P.e+1, 10/F×4', 'Fm' => 9, 'pds' => 0.8, 'cat' => 'exclu', 'prix' => [100],],
		['nom' => 'Arbalète légère', 'deg' => 'P.1d+2, 15/30', 'Fm' => NULL, 'pds' => 2, 'cat' => 'arc', 'prix' => [150],],
		['nom' => 'Arbalète moyenne', 'deg' => 'P.2d+1, 20/60', 'Fm' => 8, 'pds' => 3, 'cat' => 'arc', 'prix' => [150],],
		['nom' => 'Arbalète lourde', 'deg' => 'P.3d, 20/100', 'Fm' => 10, 'pds' => 6, 'cat' => 'arc', 'prix' => [300],],

		['nom' => 'Épée longue', 'deg' => 'T.t+1 - P.e+2', 'Fm' => 10, 'pds' => 1.25, 'cat' => 'épée', 'prix' => [600, 70],],
		['nom' => 'Épée bâtarde', 'deg' => 'T.t+1 - P.e+2', 'Fm' => 11, 'pds' => 1.5, 'notes' => '(M)', 'cat' => 'épée', 'prix' => [750],],
		['nom' => 'Épée courte', 'deg' => 'T.t - P.e+1', 'Fm' => 7, 'pds' => 1, 'cat' => 'épée', 'prix' => [400],],
		['nom' => 'Épée à 2 mains', 'deg' => 'T.t+3 - P.e+3', 'Fm' => 12, 'pds' => 2.5, 'cat' => 'épée', 'prix' => [900],],
		['nom' => 'Poignard', 'deg' => 'T.t-2 - P.e+1, 7/F-2', 'Fm' => NULL, 'pds' => 0.5, 'notes' => '(PA)', 'cat' => 'épée', 'prix' => [40],],
		['nom' => 'Couteau', 'deg' => 'T.t-3 - P.e, 7/F-2', 'Fm' => NULL, 'pds' => 0.25, 'notes' => '(PA)(L)', 'cat' => 'épée', 'prix' => [30],],
		['nom' => 'Rapière', 'deg' => 'P.e+1', 'Fm' => NULL, 'pds' => 0.75, 'notes' => '(PF)(L)', 'cat' => 'épée', 'prix' => [NULL],],
		['nom' => 'Sabre', 'deg' => 'T.t - P.e+1', 'Fm' => 7, 'pds' => 1, 'notes' => '(PF)', 'cat' => 'épée', 'prix' => [NULL],],

		['nom' => 'Hachette', 'deg' => 'T.t+1, 7/F', 'Fm' => 8, 'pds' => 1, 'notes' => '(A)', 'cat' => 'exclu', 'prix' => [NULL],],
		['nom' => 'Hache d’arme', 'deg' => 'T.t+2, 7/F', 'Fm' => 11, 'pds' => 2, 'notes' => '(M)(A)', 'cat' => 'h-m', 'prix' => [50],],
		['nom' => 'Hache à 2 mains', 'deg' => 'T.t+4', 'Fm' => 13, 'pds' => 3, 'notes' => '(A)', 'cat' => 'h-m', 'prix' => [100],],
		['nom' => 'Massette', 'deg' => 'B.t+2', 'Fm' => 10, 'pds' => 1, 'notes' => '(A)', 'cat' => 'exclu', 'prix' => [NULL],],
		['nom' => 'Masse d’arme', 'deg' => 'B.t+3 - B.e+2', 'Fm' => 12, 'pds' => 2, 'notes' => '(M)(A)', 'cat' => 'h-m', 'prix' => [50],],
		['nom' => 'Masse à 2 mains', 'deg' => 'B.t+4 - B.e+3', 'Fm' => 14, 'pds' => 4, 'notes' => '(A)', 'cat' => 'h-m', 'prix' => [80],],
		['nom' => 'Marteau de guerre', 'deg' => 'P.t+2 - B.t+2', 'Fm' => 11, 'pds' => 1.5, 'notes' => '(M)(A)', 'cat' => 'h-m', 'prix' => [100],],
		['nom' => 'Marteau à 2 mains', 'deg' => 'P.t+4 - B.t+4', 'Fm' => 13, 'pds' => 3, 'notes' => '(A)', 'cat' => 'h-m', 'prix' => [140],],
		['nom' => 'Fléau', 'deg' => 'B.t+2', 'Fm' => 12, 'pds' => 2, 'notes' => '(M)(A)(PA)(1)', 'cat' => 'h-m', 'prix' => [80],],
		['nom' => 'Fléau à 2 mains', 'deg' => 'B.t+4', 'Fm' => 13, 'pds' => 4, 'notes' => '(A)(PA)(1)', 'cat' => 'exclu', 'prix' => [100],],

		['nom' => 'Hallebarde', 'deg' => 'T.t+4 - P.t+4 - P.e+3', 'Fm' => 13, 'pds' => 4, 'notes' => '(A*)', 'cat' => 'lance', 'prix' => [150],],
		['nom' => 'Javelot', 'deg' => 'P.e+1, 7/F×1.5', 'Fm' => 7, 'pds' => 1, 'notes' => '(A*)', 'cat' => 'lance', 'prix' => [NULL],],
		['nom' => 'Lance', 'deg' => 'P.e+2, 7/F', 'Fm' => 9, 'pds' => 2, 'notes' => '(M)(A*)', 'cat' => 'lance', 'prix' => [40],],
		['nom' => 'Trident', 'deg' => 'P.e+3, 7/F', 'Fm' => 9, 'pds' => 2, 'notes' => '(M)(A*)(2)', 'cat' => 'lance', 'prix' => [NULL],],

		['nom' => 'Gourdin (50 cm)', 'deg' => 'B.t - B.e', 'Fm' => 7, 'pds' => 1, 'cat' => 'g-c', 'prix' => [0],],
		['nom' => 'Gourdin (80 cm)', 'deg' => 'B.t+1 - B.e', 'Fm' => 9, 'pds' => 1.5, 'cat' => 'g-c', 'prix' => [0],],
		['nom' => 'Bâton', 'deg' => 'B.t+1 - B.e+1', 'Fm' => 9, 'pds' => 1.5, 'notes' => '(3)', 'cat' => 'g-c', 'prix' => [0],],
		['nom' => 'Caillou', 'deg' => 'B.e, 7/F×1.5', 'Fm' => 7, 'pds' => 0.5, 'cat' => 'g-c', 'prix' => [0],],

		['nom' => 'Fléchette', 'deg' => 'P.e-2, 7/F-2', 'Fm' => NULL, 'pds' => 0.05, 'notes' => '(L)(5)', 'cat' => 'divers', 'prix' => [2],],
		['nom' => 'Fronde', 'deg' => 'B.t, 10/F×3', 'Fm' => NULL, 'pds' => 0.25, 'cat' => 'divers', 'prix' => [2],],
		['nom' => 'Lance de joute', 'deg' => 'P.e+3', 'Fm' => 12, 'pds' => 3, 'cat' => 'divers', 'prix' => [NULL],],
		['nom' => 'Lance-javelot', 'deg' => 'P.t+1, 10/F×2', 'Fm' => 7, 'pds' => 1, 'cat' => 'exclu', 'prix' => [NULL],],
		['nom' => 'Lance-pierre', 'deg' => 'B.t, 15/F×3', 'Fm' => NULL, 'pds' => 0.5, 'cat' => 'divers', 'prix' => [NULL],],
		['nom' => 'Matraque', 'deg' => 'B.t-3', 'Fm' => NULL, 'pds' => 0.5, 'notes' => '(PA)(4)', 'cat' => 'divers', 'prix' => [NULL],],
		['nom' => 'Sarbacane', 'deg' => 'Spé, 10/F', 'Fm' => NULL, 'pds' => 0.2, 'notes' => '(6)', 'cat' => 'divers', 'prix' => [NULL],],

		[
			'nom' => 'Grand filet',
			'deg' => 'voir details, 3/–',
			'Fm' => 12,
			'pds' => 8,
			'cat' => 'spéciale',
			'prix' => [NULL],
			'description' => '1 round pour l’apprêter. L’Esquive est la seule défense possible. Trois jets de Dex-4, pas forcément consécutifs, pour se libérer (Dex-6 pour des animaux ou des êtres humains n’ayant qu’une main disponible). Si trois jets consécutifs sont ratés, la victime est tellement emmêlée qu’il faudra couper le filet pour la libérer.',
		],
		[
			'nom' => 'Petit filet',
			'deg' => 'voir details, 3/–',
			'Fm' => 8,
			'pds' => 2.5,
			'cat' => 'spéciale',
			'prix' => [NULL],
			'description' => '1 seconde pour l’apprêter. Peut être manié à une main. Les défenses possibles contre un petit filet sont les mêmes que pour une grande arme de jet. Trois jets de Dex pour se libérer (Dex-2 pour les animaux ou les humains n’ayant qu’une main disponible).',
		],
		[
			'nom' => 'Fouet',
			'deg' => 'voir details',
			'Fm' => 8,
			'pds' => 1,
			'cat' => 'spéciale',
			'prix' => [20],
			'description' => 'Parade à -5. Faire claquer : -4 au jet d’attaque, +2 aux dégâts. Faire lâcher une arme : -4 au jet d’attaque, jet de Vol de la victime pour ne pas lâcher l’arme. Arracher une arme : -4 au jet d’attaque puis duel de For. Ficeler : -4 au jet d’attaque, traiter comme le lasso. Nécessite d’être d’apprêté. Dégâts pour un fouet de 2 m : B.t-2, limités à 1d-1.',
		],
		[
			'nom' => 'Lasso',
			'deg' => 'voir details, 5/–',
			'Fm' => 7,
			'pds' => 1.5,
			'cat' => 'spéciale',
			'prix' => [NULL],
			'description' => '3 secondes pour l’apprêter. Duel de For pour ne pas perdre le lasso une fois la victime attrapée. -3 pour prendre les jambes d’un être humain. -4 pour prendre le cou, la victime est alors à For-5 pour tenter d’arracher le lasso des mains de l’attaquant et elle subit un étranglement tant que le lasso est tendu. Après un échec, il peut être ré-enroulé à la vitesse de 2 mètres par seconde.',
		],
		[
			'nom' => 'Bolas',
			'deg' => 'voir details, 7/F×1.5',
			'Fm' => 8,
			'pds' => 1,
			'cat' => 'spéciale',
			'prix' => [20],
			'description' => '2 secondes pour l’apprêter. Si les bolas atteignent leur cible, elles s’enrouleront autour d’elle et infligeront B.e-1 de dégâts. Dans le cas où une jambe est touchée, on considérera que les deux sont emprisonnées par les liens des bolas. Jet de Dex pour ne pas tomber. Une fois emprisonnée, la victime a besoin de trois jets de Dex réussis (et qu’une de ses mains soit libre) pour s’échapper et pendant ce temps, aucune autre action ne pourra être entreprise. Pour les animaux : Dex-3 s’ils sont dotés de pattes, Dex-6 s’ils ont des sabots.',
		],
	];

	const weapons_notes = [
		'(A)' => 'Doit être apprêtée.',
		'(A*)' => 'Apprêt pour changer de portée de contact ou après un coup de taille. Une parade ne désapprête pas l’arme.',
		'(M)' => 'Peut être maniée à une ou deux mains.',
		'(PF)' => 'Parade à -1 au lieu de -3.',
		'(PA)' => 'Parade à -5 au lieu de –3.',
		'(L)' => 'Dégâts limités : couteau et rapière 1d+1 ; fléchette 1d-1.',
		'(1)' => '-4 pour parer un coup donné par un fléau, -2 pour le bloquer ou l’esquiver.',
		'(2)' => 'RD doublée contre cette arme. Pas de limite de dégâts pour le torse ou les membres.',
		'(3)' => 'Caractéristiques données pour la compétence <i>Épée</i>. Avec la compétence <i>Bâton</i>&nbsp;: parade à -1, +1 aux dégâts, Fmin -2.',
		'(4)' => 'Comme des dégâts à mains nues pour sonner et assommer.',
		'(5)' => 'Utilise la compétence <i>Lancer</i>.',
		'(6)' => '1 pt de dégâts sur RD 0. La compétence <i>Contrôle du souffle</i> peut remplacer la <i>For</i> pour le calcul de portée.',
	];

	const firearms = [
		['nom' => 'Pistolet .45ACP', 'deg' => '2d(+), 15/180, 3, 7, -2', 'Fm' => 10, 'pds' => 1.4, 'cat' => 'arme-de-poing-nt6',],
		['nom' => 'Pistolet 9mmP', 'deg' => '2d+2, 15/150, 3, 8, -1', 'Fm' => 9, 'pds' => 1.1, 'cat' => 'arme-de-poing-nt6',],
		['nom' => 'Revolver .38Sp', 'deg' => '2d-1, 15/120, 3, 6, -1', 'Fm' => 8, 'pds' => 0.9, 'cat' => 'arme-de-poing-nt6',],
		['nom' => 'Revolver .38Sp mini', 'deg' => '1d+2, 10/120, 3, 5, -2', 'Fm' => 8, 'pds' => 0.7, 'cat' => 'arme-de-poing-nt6',],
		['nom' => 'Pistolet 9mmP', 'deg' => '2d+2, 15/150, 3, 15, -1', 'Fm' => 9, 'pds' => 1.2, 'cat' => 'arme-de-poing-nt7',],
		['nom' => 'Pistolet .38ACP mini', 'deg' => '2d, 10/120, 3, 5, -2', 'Fm' => 8, 'pds' => 0.6, 'cat' => 'arme-de-poing-nt7',],
		['nom' => 'Revolver .357M', 'deg' => '3d-1, 15/180, 3, 6, -2', 'Fm' => 10, 'pds' => 1.4, 'cat' => 'arme-de-poing-nt7',],
		['nom' => 'Revolver .44M', 'deg' => '3d(+), 15/200, 3, 6, -3', 'Fm' => 11, 'pds' => 1.5, 'cat' => 'arme-de-poing-nt7',],
		['nom' => 'Pistolet .40S&W', 'deg' => '2d+2(+), 15/150, 3, 13, -1', 'Fm' => 9, 'pds' => 1, 'cat' => 'arme-de-poing-nt8',],
		['nom' => 'Pistolet .44M', 'deg' => '3d(+), 15/230, 3, 9, -3', 'Fm' => 12, 'pds' => 2, 'cat' => 'arme-de-poing-nt8',],
		['nom' => 'Desert Eagle .50 AE', 'deg' => '4d(+), 15/220, 3, 7, -3', 'Fm' => 12, 'pds' => 2.1, 'cat' => 'desert-eagle',],

		['nom' => 'Fusil 7.62N à verrou', 'deg' => '7d, 50/1000, 1, 5, -3', 'Fm' => 10, 'pds' => 4, 'cat' => 'fusil-nt6',],
		['nom' => 'Fusil 7.62N', 'deg' => '7d, 50/1000, 3, 8, -2', 'Fm' => 10, 'pds' => 4.5, 'cat' => 'fusil-nt6',],
		['nom' => 'F. d’assaut 5.56N', 'deg' => '5d, 50/800, 12, 30, -1', 'Fm' => 9, 'pds' => 4.1, 'cat' => 'fusil-nt7',],
		['nom' => 'F. d’assaut 7.62S', 'deg' => '5d+1, 30/500, 10, 30, -1', 'Fm' => 10, 'pds' => 4.8, 'cat' => 'fusil-nt7',],
		['nom' => 'F. d’assaut 7.62N', 'deg' => '7d, 50/1000, 11, 20, -2', 'Fm' => 11, 'pds' => 5, 'cat' => 'fusil-nt7',],
		['nom' => 'Fusil .338LM', 'deg' => '9d+1, 200*/1500, 1, 4, -3', 'Fm' => 11, 'pds' => 8, 'cat' => 'fusil-nt8',],
		['nom' => 'Fusil .50BMG', 'deg' => '6d×2(+), 200*/1700, 1, 10, -2', 'Fm' => 13, 'pds' => 15.9, 'cat' => 'fusil-nt8',],
		['nom' => 'FA 5.56N court', 'deg' => '4d+2, 30/750, 15, 30, -1', 'Fm' => 9, 'pds' => 3.3, 'cat' => 'fusil-nt8',],
		['nom' => 'Win. CH .30-06', 'deg' => '7d+1, 50/1100, 1, 5, -3', 'Fm' => 10, 'pds' => 3.5, 'cat' => 'winchester-classic-hunter',],
		['nom' => 'Win. CH .308 Win', 'deg' => '7d, 50/1000, 1, 5, -3', 'Fm' => 10, 'pds' => 3.5, 'cat' => 'winchester-classic-hunter',],
		['nom' => 'Canon 23 cm', 'deg' => '4d+2, 30/750, 14, 20-30, -1', 'Fm' => 9, 'pds' => 3.1, 'cat' => 'hk-416',],
		['nom' => 'Canon std 42 cm', 'deg' => '5d, 50/800, 14, 20-30, -1', 'Fm' => 9, 'pds' => 3.6, 'cat' => 'hk-416',],

		['nom' => 'Canon double 12G', 'deg' => '5d, 20/40, 2, 2, -2', 'Fm' => 12, 'pds' => 3.5, 'cat' => 'shotgun',],
		['nom' => 'Fusil à pompe 12G', 'deg' => '5d, 20/40, 2, 5, -2', 'Fm' => 11, 'pds' => 4, 'cat' => 'shotgun',],

		['nom' => 'PM 9mmP', 'deg' => '3d-1, 20/160, 8, 32, -1', 'Fm' => 10, 'pds' => 4.8, 'cat' => 'mitraillette-nt6',],
		['nom' => 'PM .45ACP', 'deg' => '2d+1(+), 20/190, 13, 30, -2', 'Fm' => 11, 'pds' => 7, 'cat' => 'mitraillette-nt6',],
		['nom' => 'PM 9mmP', 'deg' => '3d-1, 30/160, 13, 30, -1', 'Fm' => 10, 'pds' => 3.4, 'cat' => 'mitraillette-nt7',],
		['nom' => 'PM 9mmP compact', 'deg' => '2d+2, 15/160, 20, 25, -2', 'Fm' => 12, 'pds' => 2.5, 'cat' => 'mitraillette-nt7',],
		['nom' => 'PM 4.6×30mm', 'deg' => '4d+1(-), 20/200, 15, 20, -1', 'Fm' => 7, 'pds' => 2, 'cat' => 'mitraillette-nt8',],
		['nom' => 'MAC-10 9mmP', 'deg' => '2d+2, 15/160, 20, 32, -2', 'Fm' => 12, 'pds' => 3, 'cat' => 'ingram-mac-10',],
		['nom' => 'MAC-10 .45ACP', 'deg' => '2d(+), 15/180, 18, 30, -3', 'Fm' => 12, 'pds' => 3, 'cat' => 'ingram-mac-10',],
	];

	/**
	 * displayWeaponsList – display a weapons list in rules
	 *
	 * @param  array $weapons
	 * @param  bool $is_firearms_list display firearms data in header
	 * @param  bool $display_headers add header for table
	 * @param  ?int $price_index price index to be used (no price if NULL)
	 * @return void
	 */
	static function displayWeaponsList(array $weapons, bool $is_firearms_list = false, bool $display_headers = true, ?int $price_index = null): void
	{
?>
		<table class="weapons <?= $display_headers ? "" : "alternate-o" ?>">
			<?php if ($display_headers) { ?>
				<tr>
					<th></th>
					<th>Dég, Prt<?= $is_firearms_list ? ", VdT, Cps, Rcl" : "" ?></th>
					<th>Fm</th>
					<th>Pds</th>
					<?php if (is_int($price_index)) { ?><th>$</th><?php } ?>
				</tr>
			<?php }
			foreach ($weapons as $weapon) {
				if (is_int($price_index)) {
					$price = $weapon["prix"][$price_index] ?? "?";
					if ($price === 0) $price = "–";
				}
			?>
				<tr>
					<td><?= $weapon["nom"] ?><?= !empty($weapon["notes"]) ? ("<sup>" . $weapon["notes"] . "</sup>") : "" ?></td>
					<td><?= $weapon["deg"] ?></td>
					<td><?= $weapon["Fm"] ?? "×" ?></td>
					<td><?= $weapon["pds"] ?></td>
					<?php if (is_int($price_index)) { ?><td><?= $price ?></td><?php } ?>
				</tr>
			<?php } ?>
		</table>
		<?php
	}

	public static function displaySpecialWeapon(array $weapons, bool $display_headers = true)
	{
		if ($display_headers) { ?>
			<div class="flex-s fw-600 fs-300 gap-½ mt-½">
				<div style="width: 10ch"></div>
				<div class="fl-1">Dégâts, Prt</div>
				<div class="ta-center" style="width: 3.5ch">Fm</div>
				<div class="ta-center" style="width: 3.5ch">Pds</div>
				<div style="width: 1ch"></div>
			</div>
		<?php }
		foreach ($weapons as $weapon) {
		?>
			<details class="fs-300 alternate-o">
				<summary class="flex-s gap-½">
					<div style="width: 10ch"><?= $weapon["nom"] ?><?= !empty($weapon["notes"]) ? ("<sup>" . $weapon["notes"] . "</sup>") : "" ?></div>
					<div class="fl-1"><?= $weapon["deg"] ?></div>
					<div class="ta-center" style="width: 3.5ch"><?= $weapon["Fm"] ?></div>
					<div class="ta-center" style="width: 3.5ch"><?= $weapon["pds"] ?></div>
				</summary>
				<p><?= $weapon["description"] ?></p>
			</details>
<?php
		}
	}

	public static function burstHits(int $rcl, int $bullets, int $mr)
	{
		$alpha = 1.5 / (2 - $rcl);
		$frac = (0.133 * $mr + 0.333) * ((1.54 - $alpha) * exp(-0.1 * ($bullets - 1) / $alpha) + $alpha);
		$frac = $frac > 1 ? 1 : $frac;
		$frac = $frac < 0 ? 0 : $frac;
		$hits_number = (int) round($frac * $bullets);
		/* $localisations = [];
		for($i = 0; $i < $hits_number; $i++){

		} */
		return $hits_number;
	}
}
