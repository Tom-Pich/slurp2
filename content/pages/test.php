<?php

use App\Entity\Character;
use App\Rules\WoundController;
use App\Lib\DiceManager;

ini_set('xdebug.var_display_max_depth', 10);
ini_set("xdebug.var_display_max_data", -1);

class Test extends stdClass
{
	public function __construct(array $params)
	{
		foreach ($params as $param => $value) {
			$this->$param = $value;
		}
	}

	public function giveMe($property)
	{
		return $this->$property;
	}
}

$test = new Test(["blip" => "blup"]);
$test->var2 = "Coucou var 2";
var_dump($test->blip);
var_dump($test->var2);
var_dump($test->giveMe("blip"));

?>


<script type="module" src="/scripts/unit-tests.js"></script>