<?php

define("IS_ONLINE", $_SERVER['HTTP_HOST'] === 'jdr.pichegru.net');
define("DB_ACTIVE", true);
define("TABLE_PREFIX", "");
define("GENERIC_PASSWORD", $_ENV["GENERIC_PASSWORD"]);

if (IS_ONLINE){
	define("DB_HOST", $_ENV["DB_HOST"]);
	define("DB_NAME", $_ENV["DB_NAME"]);
	define("DB_USER", $_ENV["DB_USER"]);
	define("DB_PASSWORD", $_ENV["DB_USER"]);
}
else {
	define("DB_HOST", "localhost");
	define("DB_NAME", "site_jdr");
	define("DB_USER", "root");
	define("DB_PASSWORD", "");
}

setlocale(LC_ALL,"fra_FRA.utf-8");
setlocale(LC_ALL,"fr_FR.utf-8");