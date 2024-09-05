<?php

use App\Entity\Character;
use App\Repository\EquipmentRepository;
use App\Rules\MentalHealthController;

ini_set('xdebug.var_display_max_depth', 10);
ini_set("xdebug.var_display_max_data", -1);

/* $perso = new Character(35);
$perso->processCharacter(); */
/* $repo = new EquipmentRepository;
$objects = $repo->getCharacterEquipment(31); */

$symbols = ["🟢", "🔴", "😖", "😎" ];
$result = MentalHealthController::getFrighcheckEffects(7, 12, 12, -1, 0, $symbols[1], [ 17, 17, 17, 17, 17, 17, 17 ]);


?>

<h4>Test de frayeur</h4>
<div class="mt-1">
	<?php print_r($result) ?>
</div>


<script type="module" src="/scripts/unit-tests.js"></script>