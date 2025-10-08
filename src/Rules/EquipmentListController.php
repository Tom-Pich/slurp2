<?php

namespace App\Rules;

class EquipmentListController
{
	const equipment_list = [
		// label, poids, prix [ AD&D, OdE ], catégorie
		["Couchage dans un dortoir", NULL, ["2 pc", "2 dB"], "auberge"],
		["Chambre, auberge moyenne", NULL, ["4-10 pc", "5 dB"], "auberge"],
		["Écurie et avoine, 1 cheval", NULL, ["2 pc"], "auberge"],
		["Repas (taverne)",	NULL, ["2-4 pc", "3-7 dB"], "auberge"],
		["Chope de bière", NULL, ["½ pc"], "auberge"],

		["Ration de voyageur (un repas)", 0.25,	["2 pc", "3 dB"], "nourriture"],
		["Formage (1 kg)", NULL, ["2-5 pc"], "nourriture"],
		["Lard (1 kg)", NULL, ["3 pc"], "nourriture"],
		["Viande de porc (1 kg)", NULL, ["3 pc"], "nourriture"],
		["Œufs, la douzaine", NULL, ["1 pc"], "nourriture"],
		["Pain (1 kg)", NULL, ["1 pc"], "nourriture"],
		["Bière (1 L)", NULL, ["1 pc"], "nourriture"],
		["Vin (1 L)", NULL, ["1-3 pc"], "nourriture"],
		["Liqueur (1 L)", NULL, ["3-6 pc"], "nourriture"],

		["Haillons*", 1, ["2 pc"], "vêtements"],
		["Vêtements pauvres*", 1, ["10 pc"], "vêtements"],
		["Vêtements moyens*", 1, ["40 pc"], "vêtements"],
		["Vêtements bourgeois*", 1, ["200 pc"], "vêtements"],
		["Vêtements nobles*", 1, ["1000 pc+"], "vêtements"],
		["Vêtements d’hiver** (RD1)", 2.5, ["prix ×2"], "vêtements"],
		["Tunique", 0.25, ["30 pc"], "vêtements"],
		["Ceinture de cuir", 0.15, ["7 pc"], "vêtements"],
		["Veste de cuir (souple, RD1)", 1.5, ["75 pc"], "vêtements"],
		["Pelisse (cuir et laine, RD1)", 2, ["50 pc"], "vêtements"],
		["Sandales", NULL, ["2 pc"], "vêtements"],
		["Mocassins", 0.25, ["5 pc"], "vêtements"],
		["Chaussures bourgeoises, de ville", 0.25, ["25 pc"], "vêtements"],
		["Chaussures de marche cuir souple (RD1)", 0.5, ["15 pc"], "vêtements"],
		["Cape basique", 0.5, ["20 pc"], "vêtements"],
		["Cape en belle fourrure", 1.5, ["500 pc"], "vêtements"],
		["Cape lourde (tissu épais)", 1, ["40 pc"], "vêtements"],
		["Chapeau de feutre", NULL, ["5 pc"], "vêtements"],
		["Chapeau de paille", NULL, ["2 pc"], "vêtements"],
		["Gants en cuir souple", NULL, ["10 pc"], "vêtements"],
		["Gants en laine", NULL, ["5 pc"], "vêtements"],

		["Set pour manger (cuillère, petit couteau, bol en bois)", 0.25, ["5 pc"], "voyage"],
		["Bourse", NULL, ["2 pc"], "voyage"],
		["Sacoche / Besace", 0.25, ["10 pc"], "voyage"],
		["Sac à dos", 0.5, ["15 pc"], "voyage"],
		["Outre, 1 L", NULL, ["3 pc"], "voyage"],
		["Outre, 2 L", NULL, ["5 pc"], "voyage"],
		["Outre, 5 L", NULL, ["8 pc"], "voyage"],
		["Bouteille de céramique, 1 L", 0.5, ["3 pc"], "voyage"],
		["Grosse bouteille de céramique, 5 L", 2, ["5 pc"], "voyage"],
		["Torche, ½ heure", 0.5, ["½ pc"], "voyage"],
		["Torche, 1 heure", 0.75, ["1 pc"], "voyage"],
		["Petite lanterne à huile, fermée<br>réserve 100 mL (10 h)", 0.5, ["40 pc"], "voyage"],
		["Huile de lampe (0,5L, 50h)", 0.5, ["2 pc"], "voyage"],
		["Briquet à amadou<br>percuteur, silex et fibres d’amadou", 0.15, ["5 pc"], "voyage"],
		["Tente 4 places (+ 2 perches de 2 m)", 15, ["150 pc"], "voyage"],
		["Couverture (laine)", 2, ["10 pc"], "voyage"],
		["Sac de couchage (pour grand froid)", 6, ["100 pc"], "voyage"],
		["Cordelette (diam. 0.5 cm, 40), 10 m", 0.2, ["3 pc"], "voyage"],
		["Corde (diam. 1 cm, 150), 10 m", 0.75, ["5 pc"], "voyage"],
		["Grosse corde (diam. 2 cm, 600), 10 m", 3, ["15 pc"], "voyage"],
		["Grappin léger (supporte 150kg)", 1, ["20 pc"], "voyage"],
		["Pierre à aiguiser", 0.1, ["2 pc"], "voyage"],

		["Voyage en bâteau, par jour, confort basique", NULL, ["10-15pc"], "service"],

		["Outils de crochetage", 0.1, ["30 pc"], "spécial"],
		["Outils de crochetage BQ, (+1 crochetage)", 0.1, ["200 pc"], "spécial"],
		["Serpe d’or (pour druide)", 0.25, ["500 pc"], "spécial"],
		["Trousse premiers secours (+1 comp.)", 1, ["30 pc"], "spécial"],
		["Labo d’alchimie improvisé (-2 comp.)", 4, ["50 pc"], "spécial"],
		["Labo d’alchimie portable (-1 comp.)", 8, ["250 pc"], "spécial"],
		["Labo d’alchimie - atelier domestique", NULL, ["1200 pc"], "spécial"],
		["Labo d’alchimie, très équipé (+1 comp.)", NULL, ["4800 pc"], "spécial"],
		["Gourde en mithrill (10 doses de potions)", 0.1, ["300 pc"], "spécial"],
		["Caltrops, la centaine", 0.5, ["10 pc"], "spécial"],

		["Âne", NULL, ["120 pc"], "animaux"],
		["Mule", NULL, ["500 pc"], "animaux"],
		["Cheval de selle", NULL, ["700 pc"], "animaux"],
		["Cheval de guerre", NULL, ["2500 pc"], "animaux"],
		["Cheval de guerre lourd", NULL, ["3000 pc"], "animaux"],
		["Selle, mors et rênes", NULL, ["100 pc"], "animaux"],
		["Sacoches de selle", NULL, ["50 pc"], "animaux"],
		["Ration d’avoine (1 cheval, 1 jour)", 1.5, ["1 pc"], "animaux"],
		["Carriole (pour un cheval, transporte 1 tonne)", NULL, ["400 pc"], "animaux"],
		["Mouton (50 kg)", NULL, ["50 pc"], "animaux"],
		["Bœuf", NULL, ["850 pc"], "animaux"],
		["Poule", NULL, ["2 pc"], "animaux"],
		["Porc (80 kg)", NULL, ["45 pc"], "animaux"],
	];

	const cloth_notes = [
		"* Les vêtements incluent un pantalon, une chemise, une ceinture et des sous-vêtements, mais ni chaussures, ni veste, ni cape.",
		"** Les vêtements d’hiver sont plus chauds et plus épais. Ils incluent une veste ou autre protection légère (tunique) contre le froid."
	];

	const esteren_flux = [
		["Cartouche, minéral", 0.13, [NULL, "10 dB"], "flux-taol-kaer"],
		["Cartouche, végétal", 0.13, [NULL, "11 dB"], "flux-taol-kaer"],
		["Cartouche, organique", 0.13, [NULL, "15 dB"], "flux-taol-kaer"],
		["Cartouche, fossile", 0.13, [NULL, "50 dB"], "flux-taol-kaer"],
	];

	public static function displayEquipmentList(array $list, int $price_index)
	{
?>
		<table class="left-1 right-2 fs-300 alternate-o mt-1">
			<?php foreach ($list as $item) {
				if (isset($item[2][$price_index])) {
			?>
					<tr>
						<td><?= $item[0] ?></td>
						<td><?= $item[2][$price_index] ?><?= $item[1] ? "&nbsp;; " . $item[1] . "&nbsp;kg" : "" ?></td>
					</tr>
			<?php }
			} ?>
		</table>
<?php
	}
}
?>