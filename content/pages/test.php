<?php

use App\Lib\TableReader;
use App\Rules\WoundController;
use App\Controller\ApiController;

ini_set('xdebug.var_display_max_depth', 10);
ini_set("xdebug.var_display_max_data", -1);

// int $dex, int $san, int $pdvm, int $pdv, int $pain_resistance, int $raw_dmg, int $rd, string $dmg_type, string $bullet_type, string $localisation, array $rolls
//$test = WoundController::getWoundEffects(11, 11, 12, 12, 0, 15, 0, "tr", "std", "torse", [8, 8, 8, 8, 8, 8, 8]);


echo "<br><br>";
//var_dump($test);