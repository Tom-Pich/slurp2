<?php

use App\Entity\Character;

ini_set('xdebug.var_display_max_depth', 10);
ini_set("xdebug.var_display_max_data", -1);

$character = new Character(27);
// $controller = new ApiController;
// $controller->getCharacter($character);
$character->processCharacter();

$test = $character;

echo "<pre>";
print_r($test);