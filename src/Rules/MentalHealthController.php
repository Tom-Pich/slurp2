<?php

namespace App\Rules;

use App\Lib\DiceManager;

class MentalHealthController
{

	public const levels = [
		0 => [
			"name" => "catatonie",
			"description" => "Catatonie. Position fœtale et semi-conscience. Le personnage ne résistera pas si quelqu’un veut le déplacer. Il restera fou si ses PdE atteignent définitivement 0. <b>Perte définitive d’un pt de <i>Volonté</i>, d’un pt de <i>Sang-froid</i> et de 2 PdE</b>.",
			"attributes-effects" => "<i>Volonté</i> et <i>Sang-Froid</i> réduits à 0.",
			"sf-modifier" => -100,
			"vol-modifier" => -100,
		],
		"0.25" => [
			"name" => "instable",
			"description" => "Le personnage est très instable et peut basculer dans une crise de folie aisément. Tant qu’il reste en dessous de ce seuil, le personnage souffre d’un désavantage mental à -15 choisi par le MJ. <b>Perte définitive d’un pt de <i>Sang-froid</i> et d’un PdE</b>.",
			"attributes-effects" => "-2 en <i>Volonté</i>, -4 à tous les jets de <i>Sang-froid</i>.",
			"sf-modifier" => -3,
			"vol-modifier" => -2,
		],
		"0.5" => [
			"name" => "perturbé",
			"description" => "Le comportement du personnage change suffisamment pour être remarqué aisément. Tant qu’il reste en dessous de ce seuil, le personnage souffre d’un désavantage mental à -5 choisi par le MJ. <b>Perte définitive d’un PdE</b>.",
			"attributes-effects" => "-1 en <i>Volonté</i>, -2 aux jets de <i>Sang-froid</i>.",
			"sf-modifier" => -1,
			"vol-modifier" => -1,
		],

	];

	static function getEffects(int $pde, int $pdem)
	{
		$ratio = $pde / $pdem;
		foreach (self::levels as $level => $effects) {
			//$level = (int) $level;
			if ($ratio <= $level) {
				return $effects;
			}
		}
		return ["description" => "Bonne santé mentale", "sf-modifier" => 0,];
	}

	static function getFrighcheckEffects(int $frightLevel, int $sfScore, int $sanScore, int $frightcheckMR, int $frighcheckCriticalStatus, string $frighcheckSymbol, array $rolls)
	{
		// actual fright level
		if ($frighcheckCriticalStatus === 1) {
			$frightLevelModifier = -3;
			$stats = "Réussite critique&nbsp;! $frighcheckSymbol";
		} elseif ($frighcheckCriticalStatus === -1) {
			$frightLevelModifier = 2;
			$stats = "Échec critique&nbsp;! $frighcheckSymbol";
		} else {
			if ($frightcheckMR >= 3) $frightLevelModifier = -2;
			elseif ($frightcheckMR >= 0) $frightLevelModifier = -1;
			elseif ($frightcheckMR >= -3) $frightLevelModifier = 0;
			else $frightLevelModifier = 1;
			$stats = "MR $frightcheckMR $frighcheckSymbol";
		}

		$actual_fright_level = min($frightLevel + $frightLevelModifier, 7); // limit is 7

		// repeated text elements
		$result_header = "<b>Test de frayeur</b> (" . $stats . ")<br>";
		$new_kirk_text = " Nouveau <i>Travers</i>*.";
		$shamefull_gesture_text = " Réaction physique «&nbsp;inconvenante&nbsp;»*";
		$rules_link = "<br>* voir règles <i>Équilibre Psychique</i>";

		// level and consequences
		if ($actual_fright_level < 0) return $result_header . "Aucun effet";

		switch ($actual_fright_level) {
			case 0:
				$result = "Sonné 1 pour 1 action.";
				break;

			case 1:
				$stun_duration = max($rolls[0] - $sfScore, 2); // ME Sang-Froid, min. 2
				$shout = !DiceManager::isSuccess($sfScore, $rolls[1]); // jet de SF pour éviter de crier
				$result = "Sonné 1 pour $stun_duration actions.";
				if ($shout) $result .= " Le personnage ne peut retenir un cri ou une exclamation.";
				break;

			case 2:
				$stun_duration = max($rolls[0] - ($sfScore - 5), 3); // ME Sang-Froid -5, min. 3
				$shout = !DiceManager::isSuccess($sfScore - 3, $rolls[1]); // jet de SF - 3 pour éviter de crier
				$pdf_loss = random_int(0, 2);
				$pde_loss = 1;
				$result = "Sonné 2 pour $stun_duration actions.";
				if ($shout) $result .= " Le personnage ne peut retenir un cri ou une exclamation.";
				$result .= " <b>Perte de " . ($pdf_loss ? "$pdf_loss PdF et " : "") . "$pde_loss PdE.</b>";
				break;

			case 3:
				$is_shock = DiceManager::isSuccess($sfScore, $rolls[0]); // choc vs panique
				$duration = DiceManager::mr2ratio($sfScore - $rolls[1]) * 10; // 1-30
				$shameful_gesture = !DiceManager::isSuccess($sfScore, $rolls[2]); // réaction inconvenante
				$new_kirk = !DiceManager::isSuccess($sfScore, $rolls[3]); // nouveau travers
				$pdf_loss = random_int(2, 4);
				$pde_loss = 2;
				if ($is_shock) $result = "Figé pendant $duration secondes.";
				else $result = "Fuite pendant $duration secondes. Si impossible&nbsp;: action inutile.";
				if ($shameful_gesture) $result .= $shamefull_gesture_text;
				if ($new_kirk) $result .= $new_kirk_text;
				$result .= " <b>Perte de $pdf_loss PdF et $pde_loss PdE</b>.";
				break;

			case 4:
				$is_panic = DiceManager::isSuccess($sfScore + 3, $rolls[0]); // jet de SF raté de 3 ou moins → panique
				$is_shock = DiceManager::isSuccess($sfScore, $rolls[0]); // jet de SF raté → choc grave
				$duration = DiceManager::mr2ratio($sfScore - $rolls[1]) * 30; // 3-90
				//$duration = round($duration / 5) * 5;
				$shameful_gesture = !DiceManager::isSuccess($sfScore - 3, $rolls[2]); // jet de SF -3 pour éviter une réaction inconvenante
				$new_kirk = !DiceManager::isSuccess($sfScore - 3, $rolls[2]); // jet de SF -3 pour éviter un nouveau travers
				$pdf_loss = random_int(3, 5);
				$pde_loss = 3;
				$pdv_loss = 1;

				if ($is_shock) $result = "État de choc. Figé pendant $duration secondes.";
				elseif ($is_panic) {
					$action_type = "totalement inutile";
					if ($rolls[5] >= 10) $action_type = "dangereuse";
					if ($rolls[5] >= 13) $action_type = "très dangereuse";
					if ($rolls[5] >= 16) $action_type = "suicidaire";
					$result = "Panique totale pendant $duration secondes&nbsp;: action $action_type.";
				} else {
					$result = "Évanouissement pendant " . round($duration * 0.5) . " minutes. Après ce délai, voir <i>Rétablissement après inconscience.</i>";
				}
				if ($shameful_gesture) $result .= $shamefull_gesture_text;
				if ($new_kirk) $result .= $new_kirk_text;
				$result .= " <b>Perte de $pdf_loss PdF, de $pde_loss PdE et de $pdv_loss PdV</b>.";
				break;

			case 5:
				$is_catatony = DiceManager::isSuccess($sfScore, $rolls[0]); // catatonie vs évanouissement long
				$duration = DiceManager::mr2ratio($sfScore - $rolls[1]) * 10; // 1-30
				$stroke = !DiceManager::isSuccess($sanScore, $rolls[2]); // jet de san pour éviter attaque cardiaque légère
				$new_kirk = !DiceManager::isSuccess($sfScore - 3, $rolls[3]); // jet de SF -3 pour éviter un nouveau travers
				$physical_effects = !DiceManager::isSuccess($sanScore, $rolls[4]); // jet de san pour éviter des conséquences physiques
				$pdf_loss = random_int(4, 7);
				$pde_loss = 4;
				$pdv_loss = 2;

				if ($is_catatony) $result = "Catatonie pendant " . round($duration * .67) . " heures. Faire ensuite un jet de <i>San</i>. Catatonie prolongée de 2d heures en cas d’échec.";
				else $result = "Le personnage perd conscience pendant $duration minutes. Après ce délai, voir <i>Rétablissement après inconscience</i>.";
				if ($stroke) {
					$result .= "<br>Attaque cardiaque&nbsp;: le personnage tombe.";
					$pdf_loss += random_int(1, 6) + random_int(1, 6);
					$pdv_loss += random_int(1, 6);
				}
				if ($new_kirk) $result .= $new_kirk_text;
				if ($physical_effects) $result .= " Conséquences physiques*.";
				$result .= " <b>Perte de $pdf_loss PdF, de $pde_loss PdE et de $pdv_loss PdV</b>.";
				break;

			case 6:
				$is_catatony = DiceManager::isSuccess($sfScore, $rolls[0]); // catatonie longue vs coma
				$duration = DiceManager::mr2ratio($sfScore - $rolls[1]) * 3;  // 0.3 - 9
				$duration = round($duration * 2) / 2; // round to nearest 0.5
				$stroke = !DiceManager::isSuccess($sanScore, $rolls[2]); // jet de San pour éviter attaque cardiaque
				$new_kirk = !DiceManager::isSuccess($sfScore - 3, $rolls[3]); // jet de SF -3 pour éviter un nouveau travers
				$physical_effects = !DiceManager::isSuccess($sanScore - 1, $rolls[4]); // jet de san-1 pour éviter des conséquences physiques
				$pdf_loss = random_int(5, 8);
				$pde_loss = 5;
				$pdv_loss = random_int(3, 6);

				if ($is_catatony) $result = "Catatonie pendant $duration jour(s). Après ce délai, faire un jet de <i>San</i>. En cas d’échec, la catatonie est prolongée de 1d jours.";
				else $result = "Coma pendant $duration jour(s). Après ce délai, faire un jet de <i>San</i>. En cas d’échec, le coma est prolongé de 1d jours.";

				if ($stroke) {
					$result .= " Le personnage tombe au sol.";
					$pdf_loss += (random_int(1, 6) + random_int(1, 6) + random_int(1, 6));
					$pdv_loss += random_int(1, 6) + random_int(1, 6);
					$san_loss = $rolls[5] > $sanScore;
					$death = $rolls[5] >= 17;
					if ($san_loss) $result .= " Perte définitive d’un point de <i>San</i>.";
					if ($death) $result .= " Le personnage meurt de son arrêt cardiaque.";
				}

				if ($new_kirk) $result .= $new_kirk_text;
				if ($physical_effects) $result .= " Conséquences physiques*.";
				$result .= " <b>Perte de $pdf_loss PdF, de $pde_loss PdE et de $pdv_loss PdV</b>.";
				break;

			case 7:
				$is_catatony = DiceManager::isSuccess($sfScore, $rolls[0]); // catatonie très longue vs coma long
				$duration = DiceManager::mr2ratio($sfScore - $rolls[1]) * 10; // 1 - 30
				$duration = round($duration);
				$stroke = !DiceManager::isSuccess($sanScore - 3, $rolls[2]); // jet de San -3 pour éviter attaque cardiaque
				$new_kirk = !DiceManager::isSuccess($sfScore - 3, $rolls[3]); // jet de SF -3 pour éviter un nouveau travers
				$physical_effects = !DiceManager::isSuccess($sanScore - 3, $rolls[4]); // jet de San -3 pour éviter des conséquences physiques
				$intLoss = !DiceManager::isSuccess($sanScore, $rolls[5]);
				$pdf_loss = random_int(8, 12);
				$pde_loss = 6;
				$pdv_loss = random_int(6, 12);

				if ($is_catatony) $result = "Catatonie pendant $duration jour(s). Après ce délai, faire un jet de <i>San</i>. En cas d’échec, la catatonie est prolongée de 3d jours.";
				else $result = "Coma pendant $duration jour(s). Après ce délai, faire un jet de <i>San</i>. En cas d’échec, le coma est prolongé de 3d jours.";

				if ($stroke) {
					$result .= " Le personnage tombe au sol.";
					$pdf_loss += (random_int(1, 6) + random_int(1, 6) + random_int(1, 6));
					$pdv_loss += random_int(1, 6) + random_int(1, 6);
					$san_loss = $rolls[6] > $sanScore;
					$death = $rolls[6] >= 17;
					if ($san_loss) $result .= " Perte définitive d’un point de <i>San</i>.";
					if ($death) $result .= " Le personnage meurt de son arrêt cardiaque.";
				}

				if ($new_kirk) $result .= $new_kirk_text;
				if ($physical_effects) $result .= " Conséquences physiques*.";
				if ($intLoss) $result .= " Perte définitive d’un point d’<i>Int</i>.";
				$result .= " <b>Perte de $pdf_loss PdF, de $pde_loss PdE et de $pdv_loss PdV</b>.";

				break;

			default:
				$result = "Résultat impossible 😅";
		}
		if (isset($new_kirk) || isset($shameful_gesture) || isset($physical_effects)) $result .= $rules_link;
		return $result_header . $result;
	}
}
