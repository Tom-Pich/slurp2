<?php

use App\Entity\Character;

ini_set('xdebug.var_display_max_depth', 10);
ini_set("xdebug.var_display_max_data", -1);

// WoundController::getWoundEffects("std", 10, 10, 10, 10, 0, 3, 0, "tr", "", "visage", [10,10,10,10,10,10,10]);


$test = new Character(33);
//$test->processCharacter();

?>
<pre>
<?php
print_r($test);
?>
</pre>