<?php

use App\Lib\TextParser;
use App\Entity\Character;
use App\Repository\CharacterRepository;
use App\Repository\EquipmentRepository;
use App\Rules\WoundController;

ini_set('xdebug.var_display_max_depth', 10);
ini_set("xdebug.var_display_max_data", -1);

$repo = new CharacterRepository;
$state = $repo->getCharacterState(31);
var_dump($state["PdM"] ?? "");