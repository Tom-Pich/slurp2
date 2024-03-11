<?php

use App\Rules\ExplosionController;


ini_set('xdebug.var_display_max_depth', 10);
ini_set("xdebug.var_display_max_data", -1);

$params = [
	"damages" => 25,
	"distance" => "6",
	"surface-exposed" => .75,
	"fragmentation-engine" => false,
];
var_dump($params);
echo "<br><br>";

$test = ExplosionController::getExplosionDamages($params["damages"], $params["distance"], $params["surface-exposed"], $params["fragmentation-engine"]);

echo "<br><br>";
var_dump($test);