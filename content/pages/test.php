<?php

use App\Entity\Character;
use App\Repository\PsiPowerRepository;
use App\Repository\SpellRepository;

ini_set('xdebug.var_display_max_depth', 10);
ini_set("xdebug.var_display_max_data", -1);

// WoundController::getWoundEffects("std", 10, 10, 10, 10, 0, 3, 0, "tr", "", "visage", [10,10,10,10,10,10,10]);

$spell_repo = new SpellRepository;
$spell = $spell_repo->getSpell(1);
$psi_repo = new PsiPowerRepository;
$psi = $psi_repo->getPower(1);
//$test->processCharacter();

?>
<pre>
<?php
print_r($spell);
print_r($psi);
?>
</pre>