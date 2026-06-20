<?php

use App\Generator\NPCGenerator;
use App\Generator\WildGenerator;
use App\Lib\AiService;

ini_set('xdebug.var_display_max_depth', 10);
ini_set("xdebug.var_display_max_data", -1);

//$test = WildGenerator::generateResult(["category" => "fantasy-street[vendeurs-mobiles]", "use-ai" => "on"]);
/* $parameters = [
	"gender" => "female",
	"region" => "french",
	"profile" => "standard",
	"use-ai" => true,
	//"name-only" => true,
];
$test = NPCGenerator::generateNPC($parameters);
echo "<pre>";
var_dump($test); */
/* $ai = new AiService;
$test = $ai->ask("Décris-moi le marché dans un petit village");
echo "<pre>";
print_r($test); */
