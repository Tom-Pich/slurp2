<?php

namespace App\Rules;

class WeaponsController
{

	const weapons = [
		['nom' => 'Arc moyen', 'dégâts' => 'P.e+2, 15/F×5', 'Fmin' => 10, 'poids' => 1, 'notes' => NULL, 'catégorie' => 'arc-arbalète', 'prix-add' => 100,],
		['nom' => 'Arc long', 'dégâts' => 'P.e+3, 15/F×8', 'Fmin' => 11, 'poids' => 1.5, 'notes' => NULL, 'catégorie' => 'arc-arbalète', 'prix-add' => 200,],
		['nom' => 'Arc composite', 'dégâts' => 'P.e+3, 15/F×8', 'Fmin' => 10, 'poids' => 1.5, 'notes' => NULL, 'catégorie' => 'arc-arbalète', 'prix-add' => 300,],
		['nom' => 'Arc court (pour nain)', 'dégâts' => 'P.e+1, 10/F×4', 'Fmin' => 9, 'poids' => 0.8, 'notes' => NULL, 'catégorie' => 'arc-arbalète-add', 'prix-add' => 100,],
		['nom' => 'Arbalète légère', 'dégâts' => 'P.1d+2, 15/30', 'Fmin' => NULL, 'poids' => 2, 'notes' => NULL, 'catégorie' => 'arc-arbalète', 'prix-add' => 150,],
		['nom' => 'Arbalète moyenne', 'dégâts' => 'P.2d+1, 20/60', 'Fmin' => 8, 'poids' => 3, 'notes' => NULL, 'catégorie' => 'arc-arbalète', 'prix-add' => 150,],
		['nom' => 'Arbalète lourde', 'dégâts' => 'P.3d, 20/100', 'Fmin' => 10, 'poids' => 6, 'notes' => NULL, 'catégorie' => 'arc-arbalète', 'prix-add' => 300,],

		['nom' => 'Épée longue', 'dégâts' => 'T.t+1 - P.e+2', 'Fmin' => 10, 'poids' => 1.5, 'notes' => NULL, 'catégorie' => 'épée-couteau', 'prix-add' => 600,],
		['nom' => 'Épée bâtarde', 'dégâts' => 'T.t+1 - P.e+2', 'Fmin' => 11, 'poids' => 1.7, 'notes' => '(M)', 'catégorie' => 'épée-couteau', 'prix-add' => 750,],
		['nom' => 'Épée courte', 'dégâts' => 'T.t - P.e+1', 'Fmin' => 7, 'poids' => 1, 'notes' => NULL, 'catégorie' => 'épée-couteau', 'prix-add' => 400,],
		['nom' => 'Épée à 2 mains', 'dégâts' => 'T.t+3 - P.e+3', 'Fmin' => 12, 'poids' => 3.5, 'notes' => NULL, 'catégorie' => 'épée-couteau', 'prix-add' => 900,],
		['nom' => 'Poignard', 'dégâts' => 'T.t-2 - P.e+1, 7/F-2', 'Fmin' => NULL, 'poids' => 0.5, 'notes' => '(PA)', 'catégorie' => 'épée-couteau', 'prix-add' => 40,],
		['nom' => 'Couteau', 'dégâts' => 'T.t-3 - P.e, 7/F-2', 'Fmin' => NULL, 'poids' => 0.25, 'notes' => '(PA)(L)', 'catégorie' => 'épée-couteau', 'prix-add' => 30,],
		['nom' => 'Rapière', 'dégâts' => 'P.e+1', 'Fmin' => NULL, 'poids' => 0.75, 'notes' => '(PF)(L)', 'catégorie' => 'épée-couteau', 'prix-add' => NULL,],
		['nom' => 'Sabre', 'dégâts' => 'T.t - P.e+1', 'Fmin' => 7, 'poids' => 1, 'notes' => '(PF)', 'catégorie' => 'épée-couteau', 'prix-add' => NULL,],

		['nom' => 'Hachette', 'dégâts' => 'T.t+1, 7/F', 'Fmin' => 8, 'poids' => 1, 'notes' => '(A)', 'catégorie' => 'exclu', 'prix-add' => 40,],
		['nom' => 'Hache d’arme', 'dégâts' => 'T.t+2, 7/F', 'Fmin' => 11, 'poids' => 2, 'notes' => '(M)(A)', 'catégorie' => 'hache-masse', 'prix-add' => 50,],
		['nom' => 'Hache à 2 mains', 'dégâts' => 'T.t+4', 'Fmin' => 13, 'poids' => 3, 'notes' => '(A)', 'catégorie' => 'hache-masse', 'prix-add' => 100,],
		['nom' => 'Massette', 'dégâts' => 'B.t+2', 'Fmin' => 10, 'poids' => 1, 'notes' => '(A)', 'catégorie' => 'exclu', 'prix-add' => 35,],
		['nom' => 'Masse d’arme', 'dégâts' => 'B.t+3 - B.e+2', 'Fmin' => 12, 'poids' => 2, 'notes' => '(M)(A)', 'catégorie' => 'hache-masse', 'prix-add' => 50,],
		['nom' => 'Masse à 2 mains', 'dégâts' => 'B.t+4 - B.e+3', 'Fmin' => 14, 'poids' => 4, 'notes' => '(A)', 'catégorie' => 'hache-masse', 'prix-add' => 80,],
		['nom' => 'Marteau de guerre', 'dégâts' => 'P.t+2 - B.t+2', 'Fmin' => 11, 'poids' => 1.5, 'notes' => '(M)(A)', 'catégorie' => 'hache-masse', 'prix-add' => 100,],
		['nom' => 'Marteau à 2 mains', 'dégâts' => 'P.t+4 - B.t+4', 'Fmin' => 13, 'poids' => 3, 'notes' => '(A)', 'catégorie' => 'hache-masse', 'prix-add' => 140,],
		['nom' => 'Fléau', 'dégâts' => 'B.t+2', 'Fmin' => 12, 'poids' => 2, 'notes' => '(M)(A)(PA)(1)', 'catégorie' => 'hache-masse', 'prix-add' => 80,],
		['nom' => 'Fléau à 2 mains', 'dégâts' => 'B.t+4', 'Fmin' => 13, 'poids' => 4, 'notes' => '(A)(PA)(1)', 'catégorie' => 'exclu', 'prix-add' => 100,],

		['nom' => 'Hallebarde', 'dégâts' => 'T.t+4 - P.t+4 - P.e+3', 'Fmin' => 13, 'poids' => 4, 'notes' => '(A*)', 'catégorie' => 'lance', 'prix-add' => 150,],
		['nom' => 'Javelot', 'dégâts' => 'P.e+1, 7/F×1.5', 'Fmin' => 7, 'poids' => 1, 'notes' => '(A*)', 'catégorie' => 'lance', 'prix-add' => NULL,],
		['nom' => 'Lance', 'dégâts' => 'P.e+2, 7/F', 'Fmin' => 9, 'poids' => 2, 'notes' => '(M)(A*)', 'catégorie' => 'lance', 'prix-add' => 40,],
		['nom' => 'Trident', 'dégâts' => 'P.e+3, 7/F', 'Fmin' => 9, 'poids' => 2, 'notes' => '(M)(A*)(2)', 'catégorie' => 'lance', 'prix-add' => NULL,],

		['nom' => 'Gourdin (50 cm)', 'dégâts' => 'B.t - B.e', 'Fmin' => 7, 'poids' => 1, 'notes' => NULL, 'catégorie' => 'gourdin-caillou', 'prix-add' => NULL,],
		['nom' => 'Gourdin (80 cm)', 'dégâts' => 'B.t+1 - B.e', 'Fmin' => 9, 'poids' => 1.5, 'notes' => NULL, 'catégorie' => 'gourdin-caillou', 'prix-add' => NULL,],
		['nom' => 'Bâton', 'dégâts' => 'B.t+1 - B.e+1', 'Fmin' => 9, 'poids' => 1.5, 'notes' => '(3)', 'catégorie' => 'gourdin-caillou', 'prix-add' => NULL,],
		['nom' => 'Caillou', 'dégâts' => 'B.e, 7/F×1.5', 'Fmin' => 7, 'poids' => 0.5, 'notes' => NULL, 'catégorie' => 'gourdin-caillou', 'prix-add' => NULL,],

		['nom' => 'Fléchette', 'dégâts' => 'P.e-2, 7/F-2', 'Fmin' => NULL, 'poids' => 0.05, 'notes' => '(L)(5)', 'catégorie' => 'divers', 'prix-add' => 2,],
		['nom' => 'Fronde', 'dégâts' => 'B.t, 10/F×3', 'Fmin' => NULL, 'poids' => 0.25, 'notes' => NULL, 'catégorie' => 'divers', 'prix-add' => 2,],
		['nom' => 'Lance de joute', 'dégâts' => 'P.e+3', 'Fmin' => 12, 'poids' => 3, 'notes' => NULL, 'catégorie' => 'divers', 'prix-add' => NULL,],
		['nom' => 'Lance-javelot', 'dégâts' => 'P.t+1, 10/F×2', 'Fmin' => 7, 'poids' => 1, 'notes' => NULL, 'catégorie' => 'exclu', 'prix-add' => NULL,],
		['nom' => 'Lance-pierre', 'dégâts' => 'B.t, 15/F×3', 'Fmin' => NULL, 'poids' => 0.5, 'notes' => NULL, 'catégorie' => 'divers', 'prix-add' => NULL,],
		['nom' => 'Matraque', 'dégâts' => 'B.t-3', 'Fmin' => NULL, 'poids' => 0.5, 'notes' => '(PA)(4)', 'catégorie' => 'divers', 'prix-add' => NULL,],
		['nom' => 'Sarbacane', 'dégâts' => 'Spé, 10/F', 'Fmin' => NULL, 'poids' => 0.2, 'notes' => '(6)', 'catégorie' => 'divers', 'prix-add' => NULL,],

		[
			'nom' => 'Grand filet', 'dégâts' => 'voir ci-dessous, 3/–', 'Fmin' => 12, 'poids' => 8, 'notes' => NULL, 'catégorie' => 'spéciale', 'prix-add' => NULL,
			'description' => '1 round pour l’apprêter. L’Esquive est la seule défense possible. Trois jets de Dex-4, pas forcément consécutifs, pour se libérer (Dex-6 pour des animaux ou des êtres humains n’ayant qu’une main disponible). Si trois jets consécutifs sont ratés, la victime est tellement emmêlée qu’il faudra couper le filet pour la libérer.',
		],
		[
			'nom' => 'Petit filet', 'dégâts' => 'voir ci-dessous, 3/–', 'Fmin' => 8, 'poids' => 2.5, 'notes' => NULL, 'catégorie' => 'spéciale', 'prix-add' => NULL,
			'description' => '1 seconde pour l’apprêter. Peut être manié à une main. Les défenses possibles contre un petit filet sont les mêmes que pour une grande arme de jet. Trois jets de Dex pour se libérer (Dex-2 pour les animaux ou les humains n’ayant qu’une main disponible).',
		],
		[
			'nom' => 'Fouet', 'dégâts' => 'voir ci-dessous', 'Fmin' => 8, 'poids' => 1, 'notes' => NULL, 'catégorie' => 'spéciale', 'prix-add' => 20,
			'description' => 'Parade à -5. Faire claquer : -4 au jet d’attaque, +2 aux dégâts. Faire lâcher une arme : -4 au jet d’attaque, jet de Vol de la victime pour ne pas lâcher l’arme. Arracher une arme : -4 au jet d’attaque puis duel de For. Ficeler : -4 au jet d’attaque, traiter comme le lasso. Nécessite d’être d’apprêté. Dégâts pour un fouet de 2 m : B.t-2, limités à 1d-1.',
		],
		[
			'nom' => 'Lasso', 'dégâts' => 'voir ci-dessous, 5/–', 'Fmin' => 7, 'poids' => 1.5, 'notes' => NULL, 'catégorie' => 'spéciale', 'prix-add' => NULL,
			'description' => '3 secondes pour l’apprêter. Duel de For pour ne pas perdre le lasso une fois la victime attrapée. -3 pour prendre les jambes d’un être humain. -4 pour prendre le cou, la victime est alors à For-5 pour tenter d’arracher le lasso des mains de l’attaquant et elle subit un étranglement tant que le lasso est tendu. Après un échec, il peut être ré-enroulé à la vitesse de 2 mètres par seconde.',
		],
		[
			'nom' => 'Bolas', 'dégâts' => 'voir ci-dessous, 7/F×1.5', 'Fmin' => 8, 'poids' => 1, 'notes' => NULL, 'catégorie' => 'spéciale', 'prix-add' => 20,
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
		['nom' => 'Pistolet .45ACP', 'dégâts' => '2d(+), 15/180, 3, 7, -2', 'Fmin' => 10, 'poids' => 1.4, 'notes' => NULL, 'catégorie' => 'arme-de-poing-nt6',],
		['nom' => 'Pistolet 9mmP', 'dégâts' => '2d+2, 15/150, 3, 8, -1', 'Fmin' => 9, 'poids' => 1.1, 'notes' => NULL, 'catégorie' => 'arme-de-poing-nt6',],
		['nom' => 'Revolver .38Sp', 'dégâts' => '2d-1, 15/120, 3, 6, -1', 'Fmin' => 8, 'poids' => 0.9, 'notes' => NULL, 'catégorie' => 'arme-de-poing-nt6',],
		['nom' => 'Revolver .38Sp mini', 'dégâts' => '1d+2, 10/120, 3, 5, -2', 'Fmin' => 8, 'poids' => 0.7, 'notes' => NULL, 'catégorie' => 'arme-de-poing-nt6',],
		['nom' => 'Pistolet 9mmP', 'dégâts' => '2d+2, 15/150, 3, 15, -1', 'Fmin' => 9, 'poids' => 1.2, 'notes' => NULL, 'catégorie' => 'arme-de-poing-nt7',],
		['nom' => 'Pistolet .38ACP mini', 'dégâts' => '2d, 10/120, 3, 5, -2', 'Fmin' => 8, 'poids' => 0.6, 'notes' => NULL, 'catégorie' => 'arme-de-poing-nt7',],
		['nom' => 'Revolver .357M', 'dégâts' => '3d-1, 15/180, 3, 6, -2', 'Fmin' => 10, 'poids' => 1.4, 'notes' => NULL, 'catégorie' => 'arme-de-poing-nt7',],
		['nom' => 'Revolver .44M', 'dégâts' => '3d(+), 15/200, 3, 6, -3', 'Fmin' => 11, 'poids' => 1.5, 'notes' => NULL, 'catégorie' => 'arme-de-poing-nt7',],
		['nom' => 'Pistolet .40S&W', 'dégâts' => '2d+2(+), 15/150, 3, 13, -1', 'Fmin' => 9, 'poids' => 1, 'notes' => NULL, 'catégorie' => 'arme-de-poing-nt8',],
		['nom' => 'Pistolet .44M', 'dégâts' => '3d(+), 15/230, 3, 9, -3', 'Fmin' => 12, 'poids' => 2, 'notes' => NULL, 'catégorie' => 'arme-de-poing-nt8',],
		['nom' => 'Desert Eagle .50 AE', 'dégâts' => '4d(+), 15/220, 3, 7, -3', 'Fmin' => 12, 'poids' => 2.1, 'notes' => NULL, 'catégorie' => 'desert-eagle',],

		['nom' => 'Fusil 7.62N à verrou', 'dégâts' => '7d, 50/1000, 1, 5, -3', 'Fmin' => 10, 'poids' => 4, 'notes' => NULL, 'catégorie' => 'fusil-nt6',],
		['nom' => 'Fusil 7.62N', 'dégâts' => '7d, 50/1000, 3, 8, -2', 'Fmin' => 10, 'poids' => 4.5, 'notes' => NULL, 'catégorie' => 'fusil-nt6',],
		['nom' => 'F. d’assaut 5.56N', 'dégâts' => '5d, 50/800, 12, 30, -1', 'Fmin' => 9, 'poids' => 4.1, 'notes' => NULL, 'catégorie' => 'fusil-nt7',],
		['nom' => 'F. d’assaut 7.62S', 'dégâts' => '5d+1, 30/500, 10, 30, -1', 'Fmin' => 10, 'poids' => 4.8, 'notes' => NULL, 'catégorie' => 'fusil-nt7',],
		['nom' => 'F. d’assaut 7.62N', 'dégâts' => '7d, 50/1000, 11, 20, -2', 'Fmin' => 11, 'poids' => 5, 'notes' => NULL, 'catégorie' => 'fusil-nt7',],
		['nom' => 'Fusil .338LM', 'dégâts' => '9d+1, 200*/1500, 1, 4, -3', 'Fmin' => 11, 'poids' => 8, 'notes' => NULL, 'catégorie' => 'fusil-nt8',],
		['nom' => 'Fusil .50BMG', 'dégâts' => '6d×2(+), 200*/1700, 1, 10, -2', 'Fmin' => 13, 'poids' => 15.9, 'notes' => NULL, 'catégorie' => 'fusil-nt8',],
		['nom' => 'FA 5.56N court', 'dégâts' => '4d+2, 30/750, 15, 30, -1', 'Fmin' => 9, 'poids' => 3.3, 'notes' => NULL, 'catégorie' => 'fusil-nt8',],
		['nom' => 'Win. CH .30-06', 'dégâts' => '7d+1, 50/1100, 1, 5, -3', 'Fmin' => 10, 'poids' => 3.5, 'notes' => NULL, 'catégorie' => 'winchester-classic-hunter',],
		['nom' => 'Win. CH .308 Win', 'dégâts' => '7d, 50/1000, 1, 5, -3', 'Fmin' => 10, 'poids' => 3.5, 'notes' => NULL, 'catégorie' => 'winchester-classic-hunter',],
		['nom' => 'Canon 23 cm', 'dégâts' => '4d+2, 30/750, 14, 20-30, -1', 'Fmin' => 9, 'poids' => 3.1, 'notes' => NULL, 'catégorie' => 'hk-416',],
		['nom' => 'Canon std 42 cm', 'dégâts' => '5d, 50/800, 14, 20-30, -1', 'Fmin' => 9, 'poids' => 3.6, 'notes' => NULL, 'catégorie' => 'hk-416',],

		['nom' => 'Canon double 12G', 'dégâts' => '5d, 20/40, 2, 2, -2', 'Fmin' => 12, 'poids' => 3.5, 'notes' => NULL, 'catégorie' => 'shotgun',],
		['nom' => 'Fusil à pompe 12G', 'dégâts' => '5d, 20/40, 2, 5, -2', 'Fmin' => 11, 'poids' => 4, 'notes' => NULL, 'catégorie' => 'shotgun',],

		['nom' => 'PM 9mmP', 'dégâts' => '3d-1, 20/160, 8, 32, -1', 'Fmin' => 10, 'poids' => 4.8, 'notes' => NULL, 'catégorie' => 'mitraillette-nt6',],
		['nom' => 'PM .45ACP', 'dégâts' => '2d+1(+), 20/190, 13, 30, -2', 'Fmin' => 11, 'poids' => 7, 'notes' => NULL, 'catégorie' => 'mitraillette-nt6',],
		['nom' => 'PM 9mmP', 'dégâts' => '3d-1, 30/160, 13, 30, -1', 'Fmin' => 10, 'poids' => 3.4, 'notes' => NULL, 'catégorie' => 'mitraillette-nt7',],
		['nom' => 'PM 9mmP compact', 'dégâts' => '2d+2, 15/160, 20, 25, -2', 'Fmin' => 12, 'poids' => 2.5, 'notes' => NULL, 'catégorie' => 'mitraillette-nt7',],
		['nom' => 'PM 4.6×30mm', 'dégâts' => '4d+1(-), 20/200, 15, 20, -1', 'Fmin' => 7, 'poids' => 2, 'notes' => NULL, 'catégorie' => 'mitraillette-nt8',],
		['nom' => 'MAC-10 9mmP', 'dégâts' => '2d+2, 15/160, 20, 32, -2', 'Fmin' => 12, 'poids' => 3, 'notes' => NULL, 'catégorie' => 'ingram-mac-10',],
		['nom' => 'MAC-10 .45ACP', 'dégâts' => '2d(+), 15/180, 18, 30, -3', 'Fmin' => 12, 'poids' => 3, 'notes' => NULL, 'catégorie' => 'ingram-mac-10',],
	];

	/**
	 * displayWeaponsList – display a weapons list in rules
	 *
	 * @param  array $weapons
	 * @param  bool $is_firearms_list display firearms data in header
	 * @param  bool $display_headers add header for table
	 * @param  ?string $display_price add price column and display price corresponding to price name
	 * @return void
	 */
	static function displayWeaponsList(array $weapons, bool $is_firearms_list = false, bool $display_headers = true, ?string $display_price = null): void
	{
?>
		<table class="weapons <?= $display_headers ? "" : "alternate-o" ?>">
			<?php if ($display_headers) { ?>
				<tr>
					<th></th>
					<?php if ($is_firearms_list) { ?>
						<th>Dég, Prt, VdT, Cps, Rcl</th>
					<?php } else { ?>
						<th>Dégâts, Prt</th>
					<?php } ?>
					<th>Fm</th>
					<th>Pds</th>
					<?php if($display_price){ ?><th>$</th><?php } ?>
				</tr>
			<?php }
			foreach ($weapons as $weapon) { ?>
				<tr>
					<td><?= $weapon["nom"] ?><?= $weapon["notes"] ? ("<sup>" . $weapon["notes"] . "</sup>") : "" ?></td>
					<td><?= $weapon["dégâts"] ?></td>
					<td><?= $weapon["Fmin"] ?? "×" ?></td>
					<td><?= $weapon["poids"] ?></td>
					<?php if($display_price){ ?><td><?= $weapon[$display_price] ?? "–" ?></td><?php } ?>
				</tr>
			<?php } ?>
		</table>
<?php
	}

	public static function burstHits(int $rcl, int $bullets, int $mr){
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
