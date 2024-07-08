<?php

use App\Entity\Character;
use App\Rules\WoundController;
use App\Lib\DiceManager;

ini_set('xdebug.var_display_max_depth', 10);
ini_set("xdebug.var_display_max_data", -1);

/* $character = new Character(31);
$character->processCharacter(); */

$dmg_types = ["br", "tr", "pe", "mn", "b0", "b1", "b2", "b3", "exp"];
$raw_dmg = 3;
$rd = 0;
$rolls = [10, 10, 10, 10, 10, 10, 10];
$test = WoundController::getWoundEffects("std", 12, 12, 10, 10, 0, $raw_dmg, $rd, "pe", "std", "jambe", $rolls)
// var_dump($test)
//$test = [];
?>

<pre>
	<?php
	print_r($test);
	/* $first_pop = array_shift($test);
	echo "first shift: " . $first_pop . "<br>" ;
	print_r($test); */
	?>
</pre>


<script type="module" src="/scripts/unit-tests.js"></script>