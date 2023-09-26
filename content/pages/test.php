<?php

use App\Entity\Creature;
use App\Entity\PsiPower;
use App\Entity\Character;
use App\Entity\Equipment;
use App\Repository\CreatureRepository;
use App\Repository\PsiPowerRepository;

ini_set('xdebug.var_display_max_depth', 10);
ini_set("xdebug.var_display_max_data", -1);


/* $character = new Character (2);
$character->processCharacter(false);
var_dump($character->equipment); */

var_dump($_SESSION);