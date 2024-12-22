<?php

use App\Entity\Character;
use App\Repository\CharacterRepository;
use App\Repository\EquipmentRepository;
use App\Rules\MentalHealthController;

ini_set('xdebug.var_display_max_depth', 10);
ini_set("xdebug.var_display_max_data", -1);

$ch_repo = new CharacterRepository;
$raw_c = $ch_repo->getCharacterRawData(1);
$raw_c["Description"] = "...description...";
$raw_c["Background"] = "...background...";
$raw_c["Notes"] = "...notes...";
/* $perso = new Character(35);
$perso->processCharacter(); */
/* $repo = new EquipmentRepository;
$objects = $repo->getCharacterEquipment(31); */

$symbols = ["🟢", "🔴", "😖", "😎" ];
$result = MentalHealthController::getFrighcheckEffects(7, 12, 12, -1, 0, $symbols[1], [ 17, 17, 17, 17, 17, 17, 17 ]);


?>

<pre class="mt-1">
	<?php print_r($raw_c) ?>
</pre>


<script type="module" src="/scripts/unit-tests.js"></script>