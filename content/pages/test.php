<?php

use App\Lib\TextParser;
use App\Entity\Character;
use App\Rules\WoundController;

ini_set('xdebug.var_display_max_depth', 10);
ini_set("xdebug.var_display_max_data", -1);


/* $character = new Character (2);
$character->processCharacter(false);
var_dump($character->equipment); */

$dex = 10;
$san = 11;
$pdvm = 12;
$pdv = 10;
$has_pain_resistance = false;
$raw_dmg = 4;
$rd = 0;
$dmg_type = "br";
$bullet_type = "std";
$localisation = "crane";
$rolls = [10,10,10,10,10,7,10];

$test = WoundController::getWoundEffects($dex, $san, $pdvm, $pdv, $has_pain_resistance, $raw_dmg, $rd, $dmg_type, $bullet_type, $localisation, $rolls);
//var_dump($test);