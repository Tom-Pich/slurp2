<?php

use App\Lib\TextParser;
use App\Entity\Character;
use App\Rules\WoundController;
use App\Rules\WeaponsController;

ini_set('xdebug.var_display_max_depth', 10);
ini_set("xdebug.var_display_max_data", -1);


/* $character = new Character (2);
$character->processCharacter(false);
var_dump($character->equipment); */

$san = 12;
$pdvm = 12;
$pdv = 12;
$pain_resistance = false;
$raw_damages = 3;
$rd = 1;
$dmg_type = "tr";
$bullet_type = "";
$localisation = "torse";

$test = WoundController::getWoundEffects($san, $pdvm, $pdv, $pain_resistance, $raw_damages, $rd, $dmg_type, $bullet_type, $localisation);
var_dump($test);