<?php

use App\Entity\Character;
use App\Repository\CharacterRepository;

$character_repo = new CharacterRepository;

$character_ids = $character_repo->getAllCharacters();
foreach ($character_ids as $id) {
	$test = new Character($id);
	$test->processCharacter();
	echo "<p class='mt-1'><b>" . $test->name . " :</b> " . json_encode($test->state,  JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES |  JSON_PRETTY_PRINT) . "</p>";
}
