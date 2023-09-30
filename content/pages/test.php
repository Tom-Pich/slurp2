<?php

use App\Entity\Character;
use App\Rules\WoundController;

ini_set('xdebug.var_display_max_depth', 10);
ini_set("xdebug.var_display_max_data", -1);


/* $character = new Character (2);
$character->processCharacter(false);
var_dump($character->equipment); */

$dex = 12;
$san = 12;
$pdvm = 12;
$pdv = 12;
$pain_resistance = false;
$raw_damages = 3;
$rd = 0;
$dmg_type = "tr";
$bullet_type = "std";
$localisation = "coeur";
$rolls = [10, 10, 10, 10, 10, 10, 10];

//$test = WoundController::getWoundEffects($dex, $san, $pdvm, $pdv, $pain_resistance, $raw_damages, $rd, $dmg_type, $bullet_type, $localisation, $rolls);
//var_dump($test);