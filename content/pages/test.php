<?php

use App\Repository\CreatureRepository;

ini_set('xdebug.var_display_max_depth', 10);
ini_set("xdebug.var_display_max_data", -1);

// WoundController::getWoundEffects("std", 10, 10, 10, 10, 0, 3, 0, "tr", "", "visage", [10,10,10,10,10,10,10]);
// include "content/tests/character-skills.php";

$repo = new CreatureRepository;
$test = $repo->getCreature(15);

echo "<pre>";
var_dump($test);
