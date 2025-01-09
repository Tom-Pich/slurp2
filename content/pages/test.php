<?php

use App\Entity\Character;
use App\Lib\TextParser;
use App\Repository\EquipmentRepository;
use App\Rules\WoundController;

ini_set('xdebug.var_display_max_depth', 10);
ini_set("xdebug.var_display_max_data", -1);

$tests = [
	" blap 4, blup 5",
	"bla bli",
	";bla 4;",
	" bla bli : blu",
	"",
	"bla",
]

//$char = new Character(36);
//$char->processCharacter();

//$equipment_repo = new EquipmentRepository;
//$liste_objets_orphelins = $equipment_repo->getOrphanEquiment();

?>
<pre>
<?php
print_r(WoundController::getWoundEffects("std", 10, 10, 10, 10, 0, 3, 0, "tr", "", "visage", [10,10,10,10,10,10,10]))
?>
</pre>
<!-- <script type="module" src="/scripts/unit-tests.js"></script> -->