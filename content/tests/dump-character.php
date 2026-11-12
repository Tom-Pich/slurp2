<?php

use App\Entity\Character;

$character = new Character(34);
$character->processCharacter(false, true);

echo "<pre>";
print_r($character);
