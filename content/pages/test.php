<?php

use App\Repository\CreatureRepository;
use App\Rules\WoundController;

ini_set('xdebug.var_display_max_depth', 10);
ini_set("xdebug.var_display_max_data", -1);

$category = "std";
$dex = 12;
$san = 12;
$pdvm = 12;
$pdv = 12;
$pain_resistance = 0;
$raw_dmg = 2;
$rd = 0;
$dmg_type = "b1";
$bullet_type = "std";
$localisation = "oeil";
$rolls = [10, 10, 10, 10, 18, 10, 16];

$test = WoundController::getWoundEffects($category, $dex, $san, $pdvm, $pdv, $pain_resistance, $raw_dmg, $rd, $dmg_type, $bullet_type, $localisation, $rolls);

echo "<pre>";
var_dump($test);