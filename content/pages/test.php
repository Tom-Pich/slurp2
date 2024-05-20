<?php

use App\Lib\TableReader;
use App\Rules\WoundController;
use App\Controller\ApiController;

ini_set('xdebug.var_display_max_depth', 10);
ini_set("xdebug.var_display_max_data", -1);

$bool = null;

$test1 = $bool && "coucou";
$test2 = $bool || "coucou";
$test3 = $bool ?? "coucou";

var_dump( $test1 );
var_dump( $test2 );
var_dump( $test3 );