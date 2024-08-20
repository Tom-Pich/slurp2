<?php

use App\Entity\Character;
use App\Rules\WoundController;
use App\Lib\DiceManager;

ini_set('xdebug.var_display_max_depth', 10);
ini_set("xdebug.var_display_max_data", -1);

$perso = new Character(34);
$perso->processCharacter();

?>

<h4>Compétences</h4>
<pre>
	<?php print_r($perso->state) ?>
</pre>


<script type="module" src="/scripts/unit-tests.js"></script>