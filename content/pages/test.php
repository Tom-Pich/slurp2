<?php

use App\Entity\Character;

ini_set('xdebug.var_display_max_depth', 10);
ini_set("xdebug.var_display_max_data", -1);

$character = new Character(31);
$character->processCharacter();


?>

<pre>
	<?php foreach ($character->equipment as $list) { ?>
		<div><?php print_r($list) ?></div>
	<?php } ?>
</pre>


<script type="module" src="/scripts/unit-tests.js"></script>