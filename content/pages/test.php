<?php

use App\Entity\Skill;
use App\Lib\TableReader;
use App\Entity\Character;


ini_set('xdebug.var_display_max_depth', 10);
ini_set("xdebug.var_display_max_data", -1);

/* foreach ([ .15, 0.45, 0.5, .75, 1, 1.5, 2, 3.5, 4, 5, 7, 8, 10, 12, 13, 15, 16, 18, 19, 20, 21, 25, 26, 32 ] as $pts){
	echo $pts . " pts → " . Skill::cost2niv($pts, -4, "D") . "<br>";
}; */

/* $char = new Character(31);
$char->processCharacter();
echo "<pre>";
foreach ($char->skills as $skill){
	$skill["description"] = "(&hellip;)";
	print_r($skill);
}
echo "</pre>"; */

include "content/components/chat-window.php";

?>
<!-- <script type="module" src="/scripts/unit-tests.js"></script> -->