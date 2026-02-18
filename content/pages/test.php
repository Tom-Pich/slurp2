<?php

use App\Entity\Character;

ini_set('xdebug.var_display_max_depth', 10);
ini_set("xdebug.var_display_max_data", -1);

include "content/tests/character-skills.php";
//include "content/tests/character-skills-v2.php";

$test = new Character(31);
//$test->processCharacter(false);