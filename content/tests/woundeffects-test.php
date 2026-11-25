<?php
// require __DIR__ . "/../../vendor/autoload.php"; // pour CLI

use App\Rules\WoundController;

/* Données brutes envoyées par le widget + vérifications par index.php
{
  "opponent-selector": "0",
  "category": "std",		→ obl. + htmlspecialchars
  "dex": "12",				→ obl. + conversion int
  "san": "12",				→ obl. + conversion int
  "pdvm": "12",				→ obl. + conversion int
  "pdv": "-3",				→ obl. + conversion int + pdvm si vide
  "raw-dmg": "0",			→ obl. + conversion int
  "rd": "",					→ obl. + conversion int
  "dmg-type": "tr",			→ obl. + htmlspecialchars
  ("bullet-type": "std")	→ si absent "std", sinon htmlspecialchars
  "localisation": "torse",	→ obl. + htmlspecialchars
  "pain-resistance": "undefined", → obl. + conversion int
  "rolls": "9,15,14,16,15,10,9", → obl. + conversion array d’int
}
*/

$seed = (int) ($argv[1] ?? random_int(1, PHP_INT_MAX));
mt_srand($seed);
echo "seed = $seed<br>";

$pick = fn(array $a) => $a[mt_rand(0, count($a) - 1)];

$categories    = ["std", "nbh", "nbx", "ins", "ci"];
$dmgTypes      = ["br", "tr", "pe", "mn", "b0", "b1", "b2", "b3", "exp"];
$bulletTypes   = ["std", "bpa", "bpc"];
$localisations = ["torse", "coeur", "crane", "visage", "cou", "jambe", "bras", "pied", "main", "oeil", "org_gen"];
$pdvm_range    = [1, 5, 10, 12, 20, 50, 100, 300, mt_rand(1, 1000)];

$nb_test = 1;

$failures = 0;
for ($i = 0; $i < $nb_test; $i++) {
	$pdvm = $pick($pdvm_range);
	$args = $nb_test == 1 ? [
		// si un seul test
		"category"        => "std",
		"dex"             => 12,
		"san"             => 12,
		"pdvm"            => 12,
		"pdv"             => 12,
		"pain_resistance" => 0,
		"raw_dmg"         => 5,
		"rd"              => 0,
		"dmg_type"        => "br",
		"bullet_type"     => "",
		"localisation"    => "torse",
		"rolls"           => [12, 12, 12, 12, 12, 12, 12],
	] : $args = [
		// si tests multiples
		"category"        => $pick($categories),
		"dex"             => mt_rand(1, 20),
		"san"             => mt_rand(1, 20),
		"pdvm"            => $pdvm,
		"pdv"             => mt_rand(-3 * $pdvm, $pdvm), // y compris très négatifs
		"pain_resistance" => $pick([-1, 0, 1]),
		"raw_dmg"         => $pick([0, 1, mt_rand(0, $pdvm), mt_rand(0, 3 * $pdvm), 10_000]),
		"rd"              => $pick([0, 1, mt_rand(0, 30)]),
		"dmg_type"        => $pick($dmgTypes),
		"bullet_type"     => $pick($bulletTypes),
		"localisation"    => $pick($localisations),
		"rolls"           => array_map(fn() => mt_rand(1, 6) + mt_rand(1, 6) + mt_rand(1, 6), range(1, 7)),
	];

	try {
		$r = WoundController::getWoundEffects(...array_values($args));
		if ($nb_test === 1) {
			echo "<pre>"; print_r($r); echo "</pre>";};
		if ($r["dégâts effectifs"] < 0 || $r["pdv"] > $args["pdv"]) {
			throw new \RuntimeException("invariant violé");
		}
		if (json_encode(["data" => $r], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) === false) {
			throw new \RuntimeException("json_encode a échoué : " . json_last_error_msg());
		}
	} catch (\Throwable $e) {
		$failures++;
		echo get_class($e), ": ", $e->getMessage(), " @", $e->getLine(), "\n  ", json_encode($args, JSON_UNESCAPED_UNICODE), "\n";
		if ($failures >= 20) break;
	}
}
echo "$failures échec(s)\n";
