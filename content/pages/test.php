<?php

use App\Lib\AiService;

ini_set('xdebug.var_display_max_depth', 10);
ini_set("xdebug.var_display_max_data", -1);

$ai = new AiService($_ENV["GEMINI_KEY"]);

// Générer la description d'un PNJ à la volée
$pnj = $ai->ask(
	"Tu es le meneur d'un jeu de rôle médiéval-fantastique. 
     Génère en deux phrases la description d'un garde de château 
     dans la ville de Sardam (univers de Paorn). 
     Style sobre, pas de clichés. Réponds uniquement avec la description."
);
var_dump($pnj);